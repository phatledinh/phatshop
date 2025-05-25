<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
class CategoryController extends Controller
{
    public function index()
    {
        // Nếu cần
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)->get();
        $brands = Brand::where('id_category', $category->id)->withCount('products')->get();
        return view('category', compact('category', 'products', 'brands'));
    }

    public function filter(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $minPrice = $request->input('min_price', 300000);
        $maxPrice = $request->input('max_price', 50000000);
        $brands = $request->input('brands', []);

        $query = Product::where('category_id', $category->id)
            ->whereBetween('price_new', [$minPrice, $maxPrice]);

        if (!empty($brands)) {
            $query->whereIn('brand_id', $brands);
        }

        $products = $query->get();

        $formattedProducts = $products->map(function ($product) {
            return [
                'product_name' => $product->product_name,
                'slug' => $product->slug,
                'thumbnail' => asset($product->thumbnail),
                'price_new' => $product->price_new,
                'price_old' => $product->price_old,
                'detail_url' => route('product.detail', $product->slug)
            ];
        });

        return response()->json(['products' => $formattedProducts]);
    }
    public function listCategory(){
        $categories = Category::with('parent')->get();
        return view('admin/pages/Category/listCategory', compact('categories'));
    }
}