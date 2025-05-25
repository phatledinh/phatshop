<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function listCustomer()
    {
        $customers = User::where('role', 'client')
            ->withCount('orders') // Đếm số đơn hàng
            ->get();

        return view('admin/pages/Customer', compact('customers'));
    }
}
