<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function viewCart()
    {
        $cartItems = $this->getCartItems(); // Lấy danh sách từ cơ sở dữ liệu
        $totalPrice = $this->calculateTotal();

        // Làm mới session checkout_items và checkout_items_ids dựa trên dữ liệu hiện tại
        $itemIds = $cartItems->pluck('id')->toArray();
        session([
            'checkout_items' => $cartItems->map(function ($item) {
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
            })->toArray(),
            'checkout_items_ids' => $itemIds,
            'total_price' => $totalPrice,
        ]);

        return view('cart', compact('cartItems', 'totalPrice'));
    }

    public function addToCart(Request $request)
    {
        try {
            $productId = $request->product_id;
            $quantity = max(1, (int)($request->quantity ?? 1));

            $data = [
                'product_id' => $productId,
                'quantity' => $quantity,
            ];

            if (Auth::check()) {
                $data['user_id'] = Auth::id();
                $cartItem = CartItem::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();
            } else {
                $data['cart_id'] = $this->getCartId();
                $cartItem = CartItem::where('cart_id', $data['cart_id'])
                    ->where('product_id', $productId)
                    ->first();
            }

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                $cartItem = CartItem::create($data);
            }

            // Tính số lượng sản phẩm duy nhất trong giỏ hàng
            $cartCount = Auth::check()
                ? CartItem::where('user_id', Auth::id())->distinct('product_id')->count('product_id')
                : CartItem::where('cart_id', $data['cart_id'])->distinct('product_id')->count('product_id');

            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã được thêm vào giỏ hàng!',
                'cart_item_id' => $cartItem->id,
                'cartCount' => $cartCount
            ]);
        } catch (\Exception $e) {
            Log::error('Error adding to cart', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng: ' . $e->getMessage()
            ], 500);
        }
    }

    public function remove(Request $request, $id)
    {
        $cartItem = $this->findCartItem($id);
        if ($cartItem) {
            Log::info('Removing cart item', ['cart_item_id' => $id, 'user_id' => Auth::id(), 'cart_id' => session('cart_id')]);
            $cartItem->delete();

            // Cập nhật session checkout_items và checkout_items_ids
            $checkoutItems = session('checkout_items', []);
            $checkoutItems = array_filter($checkoutItems, fn($item) => $item['id'] != $id);
            $checkoutItemIds = session('checkout_items_ids', []);
            $checkoutItemIds = array_diff($checkoutItemIds, [$id]);

            session([
                'checkout_items' => $checkoutItems,
                'checkout_items_ids' => $checkoutItemIds,
                'total_price' => array_sum(array_map(fn($item) => $item['quantity'] * $item['product']['price_new'], $checkoutItems))
            ]);

            $cartItems = $this->getCartItems();
            $total = $this->calculateTotal();
            $count = Auth::check()
                ? CartItem::where('user_id', Auth::id())->distinct('product_id')->count('product_id')
                : CartItem::where('cart_id', $this->getCartId())->distinct('product_id')->count('product_id');

            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng!',
                'total' => $total,
                'count' => $count
            ]);
        }

        Log::warning('Cart item not found', ['cart_item_id' => $id, 'user_id' => Auth::id(), 'cart_id' => session('cart_id')]);
        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy sản phẩm trong giỏ hàng!'
        ], 404);
    }

    public function removeSelected(Request $request)
    {
        try {
            $itemIds = $request->input('itemIds', []);

            if (empty($itemIds)) {
                Log::warning('No items selected for removal', [
                    'user_id' => Auth::id(),
                    'cart_id' => session('cart_id')
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng chọn ít nhất một sản phẩm để xóa.'
                ], 400);
            }

            $query = Auth::check()
                ? CartItem::where('user_id', Auth::id())
                : CartItem::where('cart_id', $this->getCartId());

            $deletedCount = $query->whereIn('id', $itemIds)->delete();

            // Cập nhật session checkout_items
            $checkoutItems = session('checkout_items', []);
            $checkoutItems = array_filter($checkoutItems, fn($item) => !in_array($item['id'], $itemIds));
            $checkoutItemIds = session('checkout_items_ids', []);
            $checkoutItemIds = array_diff($checkoutItemIds, $itemIds);

            session([
                'checkout_items' => $checkoutItems,
                'checkout_items_ids' => $checkoutItemIds,
                'total_price' => array_sum(array_map(fn($item) => $item['quantity'] * $item['product']['price_new'], $checkoutItems))
            ]);

            Log::info('Removed selected cart items', [
                'user_id' => Auth::id(),
                'cart_id' => session('cart_id'),
                'item_ids' => $itemIds,
                'deleted_count' => $deletedCount
            ]);

            $cartItems = $this->getCartItems();
            $total = $this->calculateTotal();
            $count = Auth::check()
                ? CartItem::where('user_id', Auth::id())->distinct('product_id')->count('product_id')
                : CartItem::where('cart_id', $this->getCartId())->distinct('product_id')->count('product_id');

            return response()->json([
                'success' => true,
                'message' => "Đã xóa $deletedCount sản phẩm được chọn khỏi giỏ hàng!",
                'total' => $total,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            Log::error('Error removing selected cart items', [
                'error' => $e->getMessage(),
                'item_ids' => $itemIds
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa các sản phẩm: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $cartItem = $this->findCartItem($id);
        if ($cartItem) {
            $quantity = (int)$request->input('quantity');
            if ($quantity < 1) {
                $cartItem->delete();
                Log::info('Cart item deleted due to zero quantity', ['cart_item_id' => $id]);
                return response()->json([
                    'success' => true,
                    'message' => 'Sản phẩm đã được xóa vì số lượng bằng 0!',
                    'total' => $this->calculateTotal(),
                    // Sửa count để dùng distinct('product_id')
                    'count' => Auth::check()
                        ? CartItem::where('user_id', Auth::id())->distinct('product_id')->count('product_id')
                        : CartItem::where('cart_id', $this->getCartId())->distinct('product_id')->count('product_id'),
                    'deleted' => true
                ]);
            }

            $cartItem->quantity = $quantity;
            $cartItem->save();
            Log::info('Cart item quantity updated', [
                'cart_item_id' => $id,
                'quantity' => $quantity
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Số lượng sản phẩm đã được cập nhật!',
                'total' => $this->calculateTotal(),
                // Sửa count để dùng distinct('product_id')
                'count' => Auth::check()
                    ? CartItem::where('user_id', Auth::id())->distinct('product_id')->count('product_id')
                    : CartItem::where('cart_id', $this->getCartId())->distinct('product_id')->count('product_id'),
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price_new,
                'item_total' => $cartItem->product->price_new * $cartItem->quantity
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy sản phẩm trong giỏ hàng!'
        ], 404);
    }

    public function mergeCartAfterLogin()
    {
        if (Auth::check() && session()->has('cart_id')) {
            $cartId = session('cart_id');
            $userId = Auth::id();

            $guestCartItems = CartItem::where('cart_id', $cartId)->get();

            try {
                DB::beginTransaction();
                foreach ($guestCartItems as $guestItem) {
                    $existingItem = CartItem::where('user_id', $userId)
                        ->where('product_id', $guestItem->product_id)
                        ->first();

                    if ($existingItem) {
                        $existingItem->quantity += $guestItem->quantity;
                        $existingItem->save();
                        $guestItem->delete();
                    } else {
                        $guestItem->user_id = $userId;
                        $guestItem->cart_id = null;
                        $guestItem->save();
                    }
                }
                DB::commit();
                session()->forget('cart_id');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error merging cart', ['error' => $e->getMessage()]);
            }

            // Cập nhật session checkout_items sau khi hợp nhất
            $checkoutItems = session('checkout_items', []);
            $checkoutItemIds = session('checkout_items_ids', []);
            $updatedCartItems = $this->getCartItems()->map(function ($item) {
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

            $updatedCheckoutItems = array_filter($updatedCartItems, fn($item) => in_array($item['id'], $checkoutItemIds));
            session([
                'checkout_items' => $updatedCheckoutItems,
                'total_price' => array_sum(array_map(fn($item) => $item['quantity'] * $item['product']['price_new'], $updatedCheckoutItems))
            ]);
        }
    }

    private function calculateTotal()
    {
        return $this->getCartItems()->sum(function ($item) {
            return $item->product->price_new * $item->quantity;
        });
    }

    // Lấy ID giỏ hàng từ session
    private function getCartId(): string
    {
        if (!session()->has('cart_id')) {
            $cartId = bin2hex(random_bytes(16));
            session(['cart_id' => $cartId]);
            Log::info('Generated new cart_id', ['cart_id' => $cartId]);
        }
        $cartId = session('cart_id');
        Log::info('Retrieved cart_id', ['cart_id' => $cartId]);
        return $cartId;
    }

    // Lấy danh sách sản phẩm trong giỏ hàng
    private function getCartItems()
    {
        if (Auth::check()) {
            $items = CartItem::where('user_id', Auth::id())->with('product')->get();
            return $items;
        }
        $cartId = $this->getCartId();
        $items = CartItem::where('cart_id', $cartId)->with('product')->get();
        return $items;
    }

    // Tìm CartItem dựa trên user_id hoặc cart_id
    private function findCartItem($id)
    {
        if (Auth::check()) {
            Log::info('Finding cart item for user', ['user_id' => Auth::id(), 'cart_item_id' => $id]);
            return CartItem::where('user_id', Auth::id())->find($id);
        }
        $cartId = $this->getCartId();
        Log::info('Finding cart item for guest', ['cart_id' => $cartId, 'cart_item_id' => $id]);
        return CartItem::where('cart_id', $cartId)->find($id);
    }

    public function debugCartItemsQuery()
    {
        if (Auth::check()) {
            $items = DB::table('cart_items')->where('user_id', Auth::id())->get()->toArray();
        } else {
            $cartId = $this->getCartId();
            $items = DB::table('cart_items')->where('cart_id', $cartId)->get()->toArray();
        }
        Log::info('Cart items debug:', ['items' => $items]);
        return $items;
    }
}
