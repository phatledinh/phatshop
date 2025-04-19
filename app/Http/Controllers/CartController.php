<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function viewCart()
    {
        $cartItems = $this->getCartItems();
        $totalPrice = $this->calculateTotal();
        return view('cart', compact('cartItems', 'totalPrice'));
    }

    // Thêm sản phẩm vào giỏ hàng
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
                Log::info('Cart item updated', [
                    'cart_item_id' => $cartItem->id,
                    'product_id' => $productId,
                    'quantity' => $cartItem->quantity
                ]);
            } else {
                $cartItem = CartItem::create($data);
                Log::info('Cart item created', [
                    'cart_item_id' => $cartItem->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'cart_id' => $data['cart_id'] ?? null,
                    'data' => $data
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã được thêm vào giỏ hàng!',
                'cart_item_id' => $cartItem->id
            ]);
        } catch (\Exception $e) {
            Log::error('Error adding to cart: ' . $e->getMessage(), [
                'product_id' => $productId,
                'quantity' => $quantity,
                'cart_id' => $data['cart_id'] ?? null,
                'data' => $data
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng: ' . $e->getMessage()
            ], 500);
        }
    }
    // Xóa sản phẩm khỏi giỏ hàng
    public function remove(Request $request, $id)
    {
        $cartItem = $this->findCartItem($id);
        if ($cartItem) {
            $cartItem->delete();
            Log::info('Cart item removed', ['cart_item_id' => $id]);
            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng!',
                'total' => $this->calculateTotal()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy sản phẩm trong giỏ hàng!'
        ], 404);
    }

    // Cập nhật số lượng sản phẩm
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
                'quantity' => $cartItem->quantity,
                'item_total' => $cartItem->product->price_new * $cartItem->quantity
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy sản phẩm trong giỏ hàng!'
        ], 404);
    }

    // Xóa toàn bộ giỏ hàng
    public function clearCart(Request $request)
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
            Log::info('Cart cleared for user', ['user_id' => Auth::id()]);
        } else {
            $cartId = $this->getCartId();
            CartItem::where('cart_id', $cartId)->delete();
            Log::info('Cart cleared for guest', ['cart_id' => $cartId]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Giỏ hàng đã được xóa!',
            'total' => 0
        ]);
    }

    // Gộp giỏ hàng sau khi đăng nhập
    public function mergeCartAfterLogin()
    {
        if (Auth::check() && session()->has('cart_id')) {
            $cartId = session('cart_id');
            $userId = Auth::id();

            Log::info('Starting cart merge', ['user_id' => $userId, 'cart_id' => $cartId]);

            $guestCartItems = CartItem::where('cart_id', $cartId)->get();
            Log::info('Guest cart items', ['count' => $guestCartItems->count(), 'items' => $guestCartItems->toArray()]);

            try {
                foreach ($guestCartItems as $guestItem) {
                    $existingItem = CartItem::where('user_id', $userId)
                        ->where('product_id', $guestItem->product_id)
                        ->first();

                    if ($existingItem) {
                        $existingItem->quantity += $guestItem->quantity;
                        $existingItem->save();
                        $guestItem->delete();
                        Log::info('Cart item merged', [
                            'user_id' => $userId,
                            'product_id' => $guestItem->product_id,
                            'quantity' => $existingItem->quantity
                        ]);
                    } else {
                        $guestItem->user_id = $userId;
                        $guestItem->cart_id = null;
                        $guestItem->save();
                        Log::info('Cart item transferred', [
                            'user_id' => $userId,
                            'product_id' => $guestItem->product_id
                        ]);
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error merging cart: ' . $e->getMessage(), [
                    'user_id' => $userId,
                    'cart_id' => $cartId
                ]);
            }

            Log::info('Cart merged for user', ['user_id' => $userId, 'cart_id' => $cartId]);
            session()->forget('cart_id');
        } else {
            Log::warning('No cart merge needed', [
                'user_id' => Auth::id(),
                'has_cart_id' => session()->has('cart_id')
            ]);
        }
    }

    // Tính tổng tiền giỏ hàng
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
            Log::info('New cart_id generated', ['cart_id' => $cartId]);
        }
        $cartId = session('cart_id');
        Log::info('Cart ID accessed', ['cart_id' => $cartId, 'length' => strlen($cartId)]);
        return $cartId;
    }

    // Lấy danh sách sản phẩm trong giỏ hàng
    private function getCartItems()
    {
        if (Auth::check()) {
            $items = CartItem::where('user_id', Auth::id())->with('product')->get();
            Log::info('Fetching cart items for user', ['user_id' => Auth::id(), 'count' => $items->count()]);
            return $items;
        }
        $cartId = $this->getCartId();
        $items = CartItem::where('cart_id', $cartId)->with('product')->get();
        Log::info('Fetching cart items for guest', [
            'cart_id' => $cartId,
            'count' => $items->count(),
            'raw_items' => DB::table('cart_items')->where('cart_id', $cartId)->get()->toArray()
        ]);
        // Debug bản ghi NULL cart_id
        $nullItems = DB::table('cart_items')->whereNull('cart_id')->get()->toArray();
        Log::info('Debug NULL cart_id items', ['null_items' => $nullItems]);
        return $items;
    }

    // Tìm CartItem dựa trên user_id hoặc cart_id
    private function findCartItem($id)
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id())->find($id);
        }
        $cartId = $this->getCartId();
        return CartItem::where('cart_id', $cartId)->find($id);
    }

    // Debug truy vấn cart_items
    private function debugCartItemsQuery()
    {
        if (Auth::check()) {
            return DB::table('cart_items')->where('user_id', Auth::id())->get()->toArray();
        }
        $cartId = $this->getCartId();
        return DB::table('cart_items')->where('cart_id', $cartId)->get()->toArray();
    }
}
