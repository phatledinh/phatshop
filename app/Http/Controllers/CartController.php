<?php

// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function viewCart()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();
        return view('cart', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        if (Auth::check()) {
            $userId = Auth::id();

            // Tìm item theo user
            $cartItem = CartItem::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();
        } else {
            $cartId = $this->getCartId();

            // Tìm item theo cart_id cho guest
            $cartItem = CartItem::where('cart_id', $cartId)
                ->where('product_id', $productId)
                ->first();
        }

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $data = [
                'product_id' => $productId,
                'quantity' => $quantity,
            ];

            if (Auth::check()) {
                $data['user_id'] = Auth::id();
            } else {
                $data['cart_id'] = $this->getCartId();
            }

            CartItem::create($data);
        }

        return response()->json(['success' => true, 'message' => 'Sản phẩm đã được thêm vào giỏ hàng!']);
    }

    private function getCartId(): string
    {
        if (!session()->has('cart_id')) {
            $cartId = bin2hex(random_bytes(16)); // 32 ký tự hex
            session(['cart_id' => $cartId]);
        } else {
            $cartId = session('cart_id');
        }

        return $cartId;
    }
}