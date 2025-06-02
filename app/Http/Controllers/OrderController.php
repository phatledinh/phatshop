<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function listOrder()
    {
        $orders = Order::with('orderItems.product')
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('admin.pages.Order', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->delivery_status = $request->delivery_status;
        $order->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
}
