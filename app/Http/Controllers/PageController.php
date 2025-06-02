<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\News;
use Illuminate\Support\Facades\DB;
class PageController extends Controller
{
    public function home() {
        $flashsaleProducts = Product::where('discount', '>', 0)
                                    ->inRandomOrder()
                                    ->limit(12)
                                    ->get();

        // Lấy 12 sản phẩm thuộc danh mục "Điện thoại"
        $phoneProducts = Product::where('category_id', '1')
                                ->where('discount', '>', 0)
                                ->limit(12)
                                ->get();

        // Lấy 12 sản phẩm thuộc danh mục "Laptop"
        $laptopProducts = Product::where('category_id', '2')
                                 ->where('discount', '>', 0)
                                 ->limit(12)
                                 ->get();

        // Lấy 12 sản phẩm thuộc danh mục "Phụ kiện"
        $accessoryProducts = Product::where('category_id', '3')
                                    ->where('discount', '>', 0)
                                    ->limit(12)
                                    ->get();

        // Lấy 12 sản phẩm thuộc danh mục "Đồng hồ"
        $watchProducts = Product::where('category_id', '5')
                                ->where('discount', '>', 0)
                                ->limit(12)
                                ->get();

        // Trả về view với các dữ liệu đã lấy
        $suggestionProducts = Product::where('suggestion', '2')
                                ->limit(12)
                                ->get();
        $recommendedProduct = Product::where('suggestion', '1')
                                ->limit(8)
                                ->get();

        $saleNews = News::where('category_id', '1')
                                ->limit(4)
                                ->get();
        return view('home', compact(
            'flashsaleProducts',
            'phoneProducts',
            'laptopProducts',
            'accessoryProducts',
            'watchProducts',
            "suggestionProducts",
            'recommendedProduct',
            'saleNews'
        ));
    }
    public function about() {
        return view('about');
    }
    public function contact() {
        return view('contact');
    }
    public function ask() {
        return view('ask');
    }
    public function cruit() {
        return view('cruit');
    }
    public function cart() {
        return view('cart');
    }
    public function checkout() {
        return view('checkout');
    }
    public function success() {
        return view('order_success');
    }
    public function dashboard() {
        $products = Product::orderBy('sold', 'desc')
            ->take(20)
            ->get();

        $totalCustomer = User::where('role', 'client')->count();
        $totalCategory = Category::count();
        $totalProduct = Product::count();
        $totalNews = News::count();

        $revenueData = DB::table('orders')
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total_revenue')
            ->where('delivery_status', 'Đã giao')
            ->whereYear('created_at', 2025)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get()
            ->pluck('total_revenue')
            ->toArray();

        // Ensure revenueData has 12 elements (one for each month), filling missing months with 0
        $revenueData = array_replace(array_fill(0, 12, 0), array_map('floatval', $revenueData));

        $topCustomers = DB::table('orders')
            ->select('name')
            ->selectRaw('SUM(total_price) as total_purchase')
            ->whereMonth('created_at', now()->month)
            ->groupBy('name')
            ->orderByDesc('total_purchase')
            ->take(10)
            ->get();

        return view('admin/pages/home', compact('products', 'totalCustomer', 'totalCategory', 'totalProduct', 'totalNews', 'revenueData', 'topCustomers'));
    }
}
