<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Đảm bảo đã import model Product

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
        return view('home', compact(
            'flashsaleProducts',
            'phoneProducts',
            'laptopProducts',
            'accessoryProducts',
            'watchProducts',
            "suggestionProducts",
            'recommendedProduct'
        ));
    }
    public function about() {
        return view('about');
    }
    public function contact() {
        return view('contact');
    }
    public function news() {
        return view('news');
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
}