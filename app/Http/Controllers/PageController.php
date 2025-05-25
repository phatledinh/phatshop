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
        // Lấy 12 sản phẩm khuyến mãi
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
        $revenueData = [
            50000000, 60000000, 75000000, 40000000, 80000000, 90000000,
            65000000, 70000000, 55000000, 85000000, 95000000, 100000000
        ]; // Dữ liệu doanh thu mẫu cho 12 tháng

        $topCustomers = DB::table('orders')
        ->select('name') // Lấy tên khách hàng từ cột name trong bảng orders
        ->selectRaw('SUM(total_price) as total_purchase') // Tính tổng giá trị đơn hàng
        ->whereMonth('created_at', now()->month) // Lọc đơn hàng trong tháng hiện tại
        ->groupBy('name') // Nhóm theo tên khách hàng
        ->orderByDesc('total_purchase') // Sắp xếp theo tổng giá trị giảm dần
        ->take(10) // Lấy 10 khách hàng đầu
        ->get();
        return view('admin/pages/home', compact('products', 'totalCustomer', 'totalCategory', 'totalProduct', 'totalNews', 'revenueData', 'topCustomers'));
    }
}
