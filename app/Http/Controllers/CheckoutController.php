<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PendingOrder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use DateTimeZone;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedItemIds = session('checkout_items_ids', []); // Lấy danh sách ID sản phẩm được chọn từ session

        if (empty($selectedItemIds)) {
            // Nếu không có sản phẩm được chọn, chuyển về trang giỏ hàng
            return redirect()->route('cart')->with('error', 'Vui lòng chọn sản phẩm để thanh toán.');
        }

        $cartItems = CartItem::where('user_id', Auth::id())
            ->whereIn('id', $selectedItemIds)
            ->with('product')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product' => [
                        'id' => $item->product->id,
                        'product_name' => $item->product->product_name,
                        'thumbnail' => $item->product->thumbnail,
                        'price_new' => $item->product->price_new,
                        'price_old' => $item->product->price_old,
                    ],
                    'quantity' => $item->quantity,
                ];
            })->toArray();

        $totalPrice = array_sum(array_map(function ($item) {
            return $item['quantity'] * $item['product']['price_new'];
        }, $cartItems));

        session([
            'checkout_items' => $cartItems,
            'total_price' => $totalPrice,
        ]);

        return view('checkout', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
            'user' => $user,
        ]);
    }

    function execPostRequest($url, $data, $maxRetries = 3)
    {
        $attempt = 0;
        $ch = curl_init($url);

        do {
            try {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data)
                ]);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                // Tắt xác thực SSL trong môi trường phát triển
                if (app()->environment('local')) {
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                } else {
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                }

                $result = curl_exec($ch);

                if (curl_errno($ch)) {
                    Log::error('cURL Error: ' . curl_error($ch), ['url' => $url, 'attempt' => $attempt + 1]);
                    $attempt++;
                    if ($attempt >= $maxRetries) {
                        curl_close($ch);
                        return false;
                    }
                    sleep(1);
                    continue;
                }

                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($httpCode !== 200) {
                    Log::error('API HTTP Error', ['http_code' => $httpCode, 'response' => $result]);
                }

                curl_close($ch);
                return $result;
            } catch (\Exception $e) {
                Log::error('cURL Exception: ' . $e->getMessage(), ['url' => $url, 'attempt' => $attempt + 1]);
                $attempt++;
                if ($attempt >= $maxRetries) {
                    curl_close($ch);
                    return false;
                }
                sleep(1);
            }
        } while ($attempt < $maxRetries);

        curl_close($ch);
        return false;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|in:cod,momo,vnpay',
            'note' => 'nullable|string',
            'bank_code' => 'nullable|string|in:VNPAYQR,VNBANK,INTCARD',
            'language' => 'nullable|string|in:vn,en',
        ]);

        $cartItems = session('checkout_items', []);
        $totalPrice = session('total_price', 0);

        if (empty($cartItems)) {
            return redirect()->route('cart')->with('error', 'Không có sản phẩm nào để đặt hàng.');
        }

        // Kiểm tra stock
        foreach ($cartItems as $item) {
            $product = Product::find($item['product']['id']);
            if (!$product || $product->stock < $item['quantity']) {
                return redirect()->route('cart')->with('error', "Sản phẩm {$item['product']['product_name']} không đủ hàng (còn {$product->stock} sản phẩm).");
            }
        }

        $pendingOrder = [
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'note' => $request->note,
            'payment_method' => $request->payment_method,
            'total_price' => $totalPrice,
            'cart_items' => $cartItems,
            'bank_code' => $request->bank_code,
            'language' => $request->language ?? 'vn',
        ];

        $orderId = time() . "_" . Str::random(6);

        DB::transaction(function () use ($pendingOrder, $orderId) {
            PendingOrder::create([
                'user_id' => Auth::id(),
                'order_data' => json_encode($pendingOrder),
                'order_id' => $orderId,
            ]);
        });

        session(['pending_order_id' => $orderId]);
        Log::info('Pending Order Stored', ['order_id' => $orderId]);

        if ($request->payment_method === 'cod') {
            try {
                $order = DB::transaction(function () use ($request, $totalPrice, $cartItems, $orderId) {
                    $order = Order::create([
                        'user_id' => Auth::id(),
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'note' => $request->note,
                        'payment_method' => $request->payment_method,
                        'total_price' => $totalPrice,
                        'status' => 'Chưa thanh toán',
                    ]);

                    foreach ($cartItems as $item) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $item['product']['id'],
                            'quantity' => $item['quantity'],
                            'price' => $item['product']['price_new'],
                        ]);

                        // Giảm stock và tăng sold_
                        Product::where('id', $item['product']['id'])
                            ->update([
                                'stock' => DB::raw('stock - ' . $item['quantity']),
                                'sold' => DB::raw('sold + ' . $item['quantity']),
                            ]);
                    }

                    CartItem::whereIn('id', array_column($cartItems, 'id'))->delete();
                    PendingOrder::where('order_id', $orderId)->delete();

                    return $order;
                });

                session()->forget(['checkout_items', 'total_price', 'pending_order_id']);
                return redirect()->route('order_success')->with('success', 'Đặt hàng thành công.');
            } catch (\Exception $e) {
                Log::error('COD Order Creation Failed', ['error' => $e->getMessage()]);
                return redirect()->route('checkout')->with('error', 'Lỗi khi tạo đơn hàng. Vui lòng thử lại.');
            }
        } elseif ($request->payment_method === 'momo') {
            return $this->momo_payment($request);
        } elseif ($request->payment_method === 'vnpay') {
            return $this->processVNPayPayment($totalPrice, $request->bank_code, $request->language);
        }

        return redirect()->route('checkout')->with('error', 'Phương thức thanh toán không hợp lệ.');
    }
    public function storeCartItems(Request $request)
    {
        try {
            $request->validate([
                'selectedItems' => 'required|array',
                'selectedItems.*' => 'exists:cart_items,id,user_id,' . Auth::id(),
            ]);

            $selectedItems = $request->input('selectedItems', []);

            if (empty($selectedItems)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng chọn ít nhất một sản phẩm.'
                ], 422);
            }

            $validCartItems = CartItem::where('user_id', Auth::id())
                ->whereIn('id', $selectedItems)
                ->with('product')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product' => [
                            'id' => $item->product->id,
                            'product_name' => $item->product->product_name,
                            'thumbnail' => $item->product->thumbnail,
                            'price_new' => $item->product->price_new,
                            'price_old' => $item->product->price_old,
                        ],
                        'quantity' => $item->quantity,
                    ];
                })->toArray();

            if (empty($validCartItems)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy sản phẩm hợp lệ trong giỏ hàng. Vui lòng làm mới trang.'
                ], 422);
            }

            $totalPrice = array_sum(array_map(function ($item) {
                return $item['quantity'] * $item['product']['price_new'];
            }, $validCartItems));

            session([
                'checkout_items' => $validCartItems,
                'checkout_items_ids' => array_column($validCartItems, 'id'),
                'total_price' => $totalPrice,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Chuyển đến trang thanh toán thành công.',
                'redirect' => route('checkout')
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in storeCartItems', ['errors' => $e->errors(), 'selectedItems' => $request->input('selectedItems')]);
            return response()->json([
                'success' => false,
                'message' => 'Một hoặc nhiều sản phẩm đã chọn không hợp lệ. Vui lòng làm mới trang hoặc kiểm tra lại.'
            ], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi xử lý giỏ hàng: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại.'
            ], 500);
        }
    }
    public function momo_payment(Request $request)
    {
        $orderId = session('pending_order_id');
        if (!$orderId) {
            Log::error('MoMo Payment Failed: Missing pending order ID');
            return redirect()->route('checkout')->with('error', 'Dữ liệu đơn hàng không hợp lệ.');
        }

        $pendingOrderRecord = PendingOrder::where('order_id', $orderId)->first();
        if (!$pendingOrderRecord) {
            Log::error('MoMo Payment Failed: Pending order not found', ['order_id' => $orderId]);
            return redirect()->route('checkout')->with('error', 'Dữ liệu đơn hàng không hợp lệ.');
        }

        $pendingOrder = json_decode($pendingOrderRecord->order_data, true);
        $amount = (int) $pendingOrder['total_price'];

        $config = config('services.momo');
        $endpoint = $config['endpoint'] ?? 'https://test-payment.momo.vn/v2/gateway/api/create';
        $partnerCode = $config['partner_code'];
        $accessKey = $config['access_key'];
        $secretKey = $config['secret_key'];

        $orderInfo = "Thanh toán qua MoMo";
        $orderId = time() . "_" . Str::random(6);
        $redirectUrl = env('MOMO_REDIRECT_URL', route('momo.return'));
        $ipnUrl = env('MOMO_IPN_URL', route('order_success'));
        $extraData = base64_encode(json_encode(['pending_order_id' => session('pending_order_id')]));
        $requestId = time() . "";
        $requestType = config('services.momo.request_type', 'payWithATM'); // Lấy từ config

        if ($amount <= 0) {
            Log::error('MoMo Payment Failed: Invalid amount', ['amount' => $amount]);
            return redirect()->route('checkout')->with('error', 'Số tiền thanh toán không hợp lệ.');
        }

        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            'storeId' => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        ];

        Log::info('MoMo Payment Request', ['data' => $data]);
        $result = $this->execPostRequest($endpoint, json_encode($data));
        if ($result === false) {
            Log::error('MoMo Payment Failed: cURL returned false');
            return redirect()->route('checkout')->with('error', 'Lỗi kết nối đến MoMo.');
        }

        $jsonResult = json_decode($result, true);
        Log::info('MoMo Payment Response', ['response' => $jsonResult]);

        if (isset($jsonResult['payUrl']) && !empty($jsonResult['payUrl'])) {
            return redirect()->to($jsonResult['payUrl']);
        }

        $errorMessage = $jsonResult['message'] ?? 'Không thể khởi tạo thanh toán MoMo.';
        Log::error('MoMo Payment Failed', ['response' => $jsonResult]);
        return redirect()->route('checkout')->with('error', $errorMessage);
    }

    public function momoCallback(Request $request)
    {
        $data = $request->all();
        $config = config('services.momo');

        $rawHash = "accessKey={$config['access_key']}&amount={$data['amount']}&extraData={$data['extraData']}&message={$data['message']}&orderId={$data['orderId']}&orderInfo={$data['orderInfo']}&orderType={$data['orderType']}&partnerCode={$data['partnerCode']}&payType={$data['payType']}&requestId={$data['requestId']}&responseTime={$data['responseTime']}&resultCode={$data['resultCode']}&transId={$data['transId']}";
        $signature = hash_hmac('sha256', $rawHash, $config['secret_key']);

        if ($signature !== $data['signature']) {
            Log::error('MoMo Callback: Invalid signature', ['data' => $data]);
            return response()->json(['error' => 'Chữ ký không hợp lệ'], 400);
        }

        $extraData = json_decode(base64_decode($data['extraData']), true);
        $pendingOrderRecord = PendingOrder::where('order_id', $extraData['pending_order_id'])->first();

        if (!$pendingOrderRecord) {
            Log::error('MoMo Callback: Invalid order data', ['extraData' => $extraData]);
            return response()->json(['error' => 'Dữ liệu đơn hàng không hợp lệ'], 400);
        }

        $pendingOrder = json_decode($pendingOrderRecord->order_data, true);
        $cartItems = $pendingOrder['cart_items'];

        // Kiểm tra giao dịch trùng lặp
        if (Order::where('order_id', $extraData['pending_order_id'])->exists()) {
            Log::warning('MoMo Callback: Order already processed', ['order_id' => $extraData['pending_order_id']]);
            return response()->json(['success' => true]);
        }

        if ($data['resultCode'] == 0) {
            try {
                DB::transaction(function () use ($pendingOrder, $cartItems, $extraData) {
                    $order = Order::create([
                        'user_id' => $pendingOrder['user_id'],
                        'name' => $pendingOrder['name'],
                        'phone' => $pendingOrder['phone'],
                        'address' => $pendingOrder['address'],
                        'note' => $pendingOrder['note'],
                        'payment_method' => $pendingOrder['payment_method'],
                        'total_price' => $pendingOrder['total_price'],
                        'status' => 'Đã thanh toán',
                        'order_id' => $extraData['pending_order_id'], // Thêm order_id
                    ]);

                    foreach ($cartItems as $item) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $item['product']['id'],
                            'quantity' => $item['quantity'],
                            'price' => $item['product']['price_new'],
                        ]);
                    }

                    CartItem::whereIn('id', array_column($cartItems, 'id'))->delete();
                    PendingOrder::where('order_id', $extraData['pending_order_id'])->delete();
                    session()->forget('pending_order_id');
                });

                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                Log::error('MoMo Callback: Order creation failed', ['error' => $e->getMessage()]);
                return response()->json(['error' => 'Lỗi khi tạo đơn hàng'], 500);
            }
        } else {
            PendingOrder::where('order_id', $extraData['pending_order_id'])->delete();
            session()->forget('pending_order_id');
            Log::error('MoMo Callback: Payment failed', ['resultCode' => $data['resultCode'], 'message' => $data['message']]);
            return response()->json(['success' => true]);
        }
    }
    public function momoReturn(Request $request)
    {
        $data = $request->all();
        $config = config('services.momo');

        $rawHash = "accessKey={$config['access_key']}&amount={$data['amount']}&extraData={$data['extraData']}&message={$data['message']}&orderId={$data['orderId']}&orderInfo={$data['orderInfo']}&orderType={$data['orderType']}&partnerCode={$data['partnerCode']}&payType={$data['payType']}&requestId={$data['requestId']}&responseTime={$data['responseTime']}&resultCode={$data['resultCode']}&transId={$data['transId']}";
        $signature = hash_hmac('sha256', $rawHash, $config['secret_key']);

        Log::info('MoMo Return: Processing', [
            'order_id' => $data['orderId'],
            'resultCode' => $data['resultCode'],
            'signature_valid' => $signature === $data['signature']
        ]);

        if ($signature !== $data['signature']) {
            Log::error('MoMo Return: Invalid signature', ['data' => $data]);
            return redirect()->route('checkout')->with('error', 'Chữ ký không hợp lệ.');
        }

        $extraData = json_decode(base64_decode($data['extraData']), true);
        $pendingOrderId = $extraData['pending_order_id'] ?? null;

        if (!$pendingOrderId) {
            Log::error('MoMo Return: Missing pending order ID', ['data' => $data]);
            return redirect()->route('checkout')->with('error', 'Dữ liệu đơn hàng không hợp lệ.');
        }

        $pendingOrderRecord = PendingOrder::where('order_id', $pendingOrderId)->first();

        if (!$pendingOrderRecord) {
            Log::error('MoMo Return: Pending order not found', ['pending_order_id' => $pendingOrderId]);
            return redirect()->route('checkout')->with('error', 'Dữ liệu đơn hàng không hợp lệ.');
        }

        $pendingOrder = json_decode($pendingOrderRecord->order_data, true);

        if ($data['resultCode'] == 0) {
            try {
                DB::transaction(function () use ($pendingOrder, $pendingOrderId) {
                    $order = Order::where('order_id', $pendingOrderId)->first();
                    if (!$order) {
                        $order = Order::create([
                            'user_id' => $pendingOrder['user_id'],
                            'name' => $pendingOrder['name'],
                            'phone' => $pendingOrder['phone'],
                            'address' => $pendingOrder['address'],
                            'note' => $pendingOrder['note'],
                            'payment_method' => $pendingOrder['payment_method'],
                            'total_price' => $pendingOrder['total_price'],
                            'status' => 'Đã thanh toán',
                            'order_id' => $pendingOrderId,
                        ]);

                        foreach ($pendingOrder['cart_items'] as $item) {
                            OrderItem::create([
                                'order_id' => $order->id,
                                'product_id' => $item['product']['id'],
                                'quantity' => $item['quantity'],
                                'price' => $item['product']['price_new'],
                            ]);

                            // Giảm stock và tăng sold
                            Product::where('id', $item['product']['id'])
                                ->update([
                                    'stock' => DB::raw('stock - ' . $item['quantity']),
                                    'sold' => DB::raw('sold + ' . $item['quantity']),
                                ]);
                        }

                        CartItem::whereIn('id', array_column($pendingOrder['cart_items'], 'id'))->delete();
                    }
                    $order->update(['status' => 'Đã thanh toán']);
                    PendingOrder::where('order_id', $pendingOrderId)->delete();
                    session()->forget('pending_order_id');
                });

                Log::info('MoMo Return: Payment successful', ['order_id' => $pendingOrderId]);
                return redirect()->route('order_success')->with('success', 'Thanh toán MoMo thành công.');
            } catch (\Exception $e) {
                Log::error('MoMo Return: Order processing failed', ['error' => $e->getMessage(), 'order_id' => $pendingOrderId]);
                return redirect()->route('checkout')->with('error', 'Lỗi khi xử lý đơn hàng.');
            }
        } elseif ($data['resultCode'] == 7002) {
            Log::info('MoMo Return: Transaction pending', [
                'order_id' => $pendingOrderId,
                'resultCode' => $data['resultCode'],
                'message' => $data['message']
            ]);
            return redirect()->route('order_pending')->with('info', 'Giao dịch đang được xử lý. Vui lòng kiểm tra trạng thái đơn hàng sau.');
        } else {
            PendingOrder::where('order_id', $pendingOrderId)->delete();
            session()->forget('pending_order_id');
            Log::error('MoMo Return: Payment failed', [
                'order_id' => $pendingOrderId,
                'resultCode' => $data['resultCode'],
                'message' => $data['message']
            ]);
            return redirect()->route('checkout')->with('error', 'Thanh toán MoMo không thành công: ' . ($data['message'] ?? 'Lỗi không xác định'));
        }
    }
    public function processVNPayPayment($amount, $bankCode = null, $language = 'vn')
    {
        $orderId = session('pending_order_id');
        if (!$orderId) {
            Log::error('VNPay Payment Failed: Missing pending order ID', ['session_keys' => array_keys(session()->all())]);
            return redirect()->route('checkout')->with('error', 'Dữ liệu đơn hàng không hợp lệ.');
        }

        $pendingOrderRecord = PendingOrder::where('order_id', $orderId)->first();
        if (!$pendingOrderRecord) {
            Log::error('VNPay Payment Failed: Pending order not found', ['order_id' => $orderId]);
            return redirect()->route('checkout')->with('error', 'Dữ liệu đơn hàng không hợp lệ.');
        }

        $pendingOrder = json_decode($pendingOrderRecord->order_data, true);
        $cartItems = $pendingOrder['cart_items'];

        if (empty($cartItems)) {
            Log::error('VNPay Payment Failed: Empty cart items', ['order_id' => $orderId]);
            return redirect()->route('checkout')->with('error', 'Giỏ hàng trống.');
        }

        // Đảm bảo $amount là số nguyên
        $amount = (int) $amount;
        if ($amount <= 0) {
            Log::error('VNPay Payment Failed: Invalid amount', ['amount' => $amount, 'order_id' => $orderId]);
            return redirect()->route('checkout')->with('error', 'Số tiền không hợp lệ.');
        }

        Log::info('VNPay Payment Initiated', [
            'order_id' => $orderId,
            'amount' => $amount,
            'item_count' => count($cartItems)
        ]);

        $config = config('services.vnpay');
        $vnp_TmnCode = $config['tmn_code'];
        $vnp_HashSecret = $config['hash_secret'];
        $vnp_Url = $config['endpoint'] ?? 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
        $vnp_ReturnUrl = env('VNPAY_RETURN_URL', route('vnpay.return'));

        // Đặt múi giờ là Asia/Ho_Chi_Minh (GMT+7) để đồng bộ với VNPay
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $vnp_TxnRef = $orderId;
        $vnp_OrderInfo = "Thanh toán đơn hàng #$orderId";
        $vnp_OrderType = config('services.vnpay.order_type', 'billpayment');
        $vnp_Amount = $amount * 100; // VNPay requires amount in VND, multiplied by 100
        $vnp_Locale = in_array($language, ['vn', 'en']) ? $language : 'vn';
        $vnp_IpAddr = request()->ip();
        $vnp_CreateDate = date('YmdHis');
        $vnp_ExpireDate = date('YmdHis', strtotime('+15 minutes'));

        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => $vnp_TmnCode,
            'vnp_Amount' => $vnp_Amount,
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => $vnp_CreateDate,
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $vnp_IpAddr,
            'vnp_Locale' => $vnp_Locale,
            'vnp_OrderInfo' => $vnp_OrderInfo,
            'vnp_OrderType' => $vnp_OrderType,
            'vnp_ReturnUrl' => $vnp_ReturnUrl,
            'vnp_TxnRef' => $vnp_TxnRef,
            'vnp_ExpireDate' => $vnp_ExpireDate,
        ];

        if ($bankCode && in_array($bankCode, ['VNPAYQR', 'VNBANK', 'INTCARD'])) {
            $inputData['vnp_BankCode'] = $bankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url .= '?' . $query;
        $vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnp_SecureHash;

        Log::info('VNPay Payment Request', [
            'order_id' => $orderId,
            'vnp_url' => $vnp_Url,
            'input_data' => $inputData,
            'timezone' => date_default_timezone_get()
        ]);

        return redirect($vnp_Url);
    }

    public function vnpayCallback(Request $request)
    {
        $data = $request->all();
        $config = config('services.vnpay');
        $vnp_HashSecret = $config['hash_secret'];

        $vnp_SecureHash = $data['vnp_SecureHash'];
        $inputData = array_filter($data, fn($key) => str_starts_with($key, 'vnp_'), ARRAY_FILTER_USE_KEY);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $hashData = http_build_query($inputData);
        $calculatedHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        Log::info('VNPay Callback', [
            'data' => $data,
            'calculated_hash' => $calculatedHash,
            'received_hash' => $vnp_SecureHash
        ]);

        $returnData = [];

        try {
            if ($calculatedHash !== $vnp_SecureHash) {
                Log::error('VNPay Callback: Invalid signature', ['data' => $data]);
                $returnData = ['RspCode' => '97', 'Message' => 'Invalid signature'];
                return response()->json($returnData, 400);
            }

            $pendingOrderId = $data['vnp_TxnRef'];
            $pendingOrderRecord = PendingOrder::where('order_id', $pendingOrderId)->first();

            if (!$pendingOrderRecord) {
                Log::error('VNPay Callback: Pending order not found', ['pending_order_id' => $pendingOrderId]);
                $returnData = ['RspCode' => '01', 'Message' => 'Order not found'];
                return response()->json($returnData, 400);
            }

            $pendingOrder = json_decode($pendingOrderRecord->order_data, true);
            $cartItems = $pendingOrder['cart_items'];
            $vnp_Amount = $data['vnp_Amount'] / 100;

            if ($pendingOrder['total_price'] != $vnp_Amount) {
                Log::error('VNPay Callback: Invalid amount', ['expected' => $pendingOrder['total_price'], 'received' => $vnp_Amount]);
                $returnData = ['RspCode' => '04', 'Message' => 'Invalid amount'];
                return response()->json($returnData, 400);
            }

            $order = Order::where('order_id', $pendingOrderId)->first();
            if ($order && $order->status !== 'Chưa thanh toán') {
                Log::warning('VNPay Callback: Order already confirmed', ['order_id' => $pendingOrderId, 'status' => $order->status]);
                $returnData = ['RspCode' => '02', 'Message' => 'Order already confirmed'];
                return response()->json($returnData, 200);
            }

            if ($data['vnp_ResponseCode'] == '00' && $data['vnp_TransactionStatus'] == '00') {
                DB::transaction(function () use ($pendingOrder, $cartItems, $pendingOrderId) {
                    $order = Order::create([
                        'user_id' => $pendingOrder['user_id'],
                        'name' => $pendingOrder['name'],
                        'phone' => $pendingOrder['phone'],
                        'address' => $pendingOrder['address'],
                        'note' => $pendingOrder['note'],
                        'payment_method' => $pendingOrder['payment_method'],
                        'total_price' => $pendingOrder['total_price'],
                        'status' => 'Đã thanh toán',
                        'order_id' => $pendingOrderId,
                    ]);

                    foreach ($cartItems as $item) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $item['product']['id'],
                            'quantity' => $item['quantity'],
                            'price' => $item['product']['price_new'],
                        ]);
                    }

                    CartItem::whereIn('id', array_column($cartItems, 'id'))->delete();
                    PendingOrder::where('order_id', $pendingOrderId)->delete();
                    session()->forget('pending_order_id');
                });

                $returnData = ['RspCode' => '00', 'Message' => 'Confirm Success'];
            } else {
                PendingOrder::where('order_id', $pendingOrderId)->delete();
                session()->forget('pending_order_id');
                Log::error('VNPay Callback: Payment failed', [
                    'response_code' => $data['vnp_ResponseCode'],
                    'transaction_status' => $data['vnp_TransactionStatus']
                ]);
                $returnData = ['RspCode' => '00', 'Message' => 'Confirm Success'];
            }
        } catch (\Exception $e) {
            Log::error('VNPay Callback: Unknown error', ['error' => $e->getMessage()]);
            $returnData = ['RspCode' => '99', 'Message' => 'Unknown error'];
            return response()->json($returnData, 500);
        }

        return response()->json($returnData);
    }
    public function vnpayReturn(Request $request)
    {
        $data = $request->all();
        $config = config('services.vnpay');
        $vnp_HashSecret = $config['hash_secret'];

        $vnp_SecureHash = $data['vnp_SecureHash'] ?? '';
        unset($data['vnp_SecureHash']);
        ksort($data);
        $hashData = http_build_query($data);
        $calculatedHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        Log::info('VNPay Return', [
            'data' => $data,
            'calculated_hash' => $calculatedHash,
            'received_hash' => $vnp_SecureHash
        ]);

        if ($calculatedHash !== $vnp_SecureHash) {
            Log::error('VNPay Return: Invalid signature', ['data' => $data]);
            return redirect()->route('checkout')->with('error', 'Chữ ký không hợp lệ.');
        }

        $pendingOrderId = $data['vnp_TxnRef'];
        $pendingOrderRecord = PendingOrder::where('order_id', $pendingOrderId)->first();

        if (!$pendingOrderRecord) {
            Log::error('VNPay Return: Pending order not found', ['pending_order_id' => $pendingOrderId]);
            return redirect()->route('checkout')->with('error', 'Dữ liệu đơn hàng không hợp lệ.');
        }

        $pendingOrder = json_decode($pendingOrderRecord->order_data, true);
        $vnp_Amount = $data['vnp_Amount'] / 100;

        if ($pendingOrder['total_price'] != $vnp_Amount) {
            Log::error('VNPay Return: Invalid amount', ['expected' => $pendingOrder['total_price'], 'received' => $vnp_Amount]);
            return redirect()->route('checkout')->with('error', 'Số tiền không khớp.');
        }

        if ($data['vnp_ResponseCode'] == '00' && $data['vnp_TransactionStatus'] == '00') {
            try {
                DB::transaction(function () use ($pendingOrder, $pendingOrderId) {
                    $order = Order::where('order_id', $pendingOrderId)->first();
                    if (!$order) {
                        $order = Order::create([
                            'user_id' => $pendingOrder['user_id'],
                            'name' => $pendingOrder['name'],
                            'phone' => $pendingOrder['phone'],
                            'address' => $pendingOrder['address'],
                            'note' => $pendingOrder['note'],
                            'payment_method' => $pendingOrder['payment_method'],
                            'total_price' => $pendingOrder['total_price'],
                            'status' => 'Đã thanh toán',
                            'order_id' => $pendingOrderId,
                        ]);

                        foreach ($pendingOrder['cart_items'] as $item) {
                            OrderItem::create([
                                'order_id' => $order->id,
                                'product_id' => $item['product']['id'],
                                'quantity' => $item['quantity'],
                                'price' => $item['product']['price_new'],
                            ]);

                            // Giảm stock và tăng sold
                            Product::where('id', $item['product']['id'])
                                ->update([
                                    'stock' => DB::raw('stock - ' . $item['quantity']),
                                    'sold' => DB::raw('sold + ' . $item['quantity']),
                                ]);
                        }

                        CartItem::whereIn('id', array_column($pendingOrder['cart_items'], 'id'))->delete();
                    }
                    $order->update(['status' => 'Đã thanh toán']);
                    PendingOrder::where('order_id', $pendingOrderId)->delete();
                    session()->forget('pending_order_id');
                });

                return redirect()->route('order_success')->with('success', 'Thanh toán thành công.');
            } catch (\Exception $e) {
                Log::error('VNPay Return: Order processing failed', ['error' => $e->getMessage()]);
                return redirect()->route('checkout')->with('error', 'Lỗi khi xử lý đơn hàng.');
            }
        } else {
            PendingOrder::where('order_id', $pendingOrderId)->delete();
            session()->forget('pending_order_id');
            Log::error('VNPay Return: Payment failed', [
                'response_code' => $data['vnp_ResponseCode'],
                'message' => $data['vnp_Message'] ?? ''
            ]);
            return redirect()->route('checkout')->with('error', 'Thanh toán không thành công: ' . ($data['vnp_Message'] ?? 'Lỗi không xác định'));
        }
    }
    public function cancelOrder($orderId)
    {
        try {
            DB::transaction(function () use ($orderId) {
                $order = Order::findOrFail($orderId);
                if ($order->status !== 'cancelled') {
                    foreach ($order->orderItems as $item) {
                        Product::where('id', $item->product_id)
                            ->update([
                                'stock' => DB::raw('stock + ' . $item->quantity),
                                'sold' => DB::raw('sold - ' . $item->quantity),
                            ]);
                    }
                    $order->update(['status' => 'cancelled']);
                }
            });

            return redirect()->back()->with('success', 'Đơn hàng đã được hủy.');
        } catch (\Exception $e) {
            Log::error('Order Cancellation Failed', ['error' => $e->getMessage(), 'order_id' => $orderId]);
            return redirect()->back()->with('error', 'Lỗi khi hủy đơn hàng.');
        }
    }
}