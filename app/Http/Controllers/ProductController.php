<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;

class ProductController extends Controller {
    public function index() {

    }
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $phoneProducts = Product::where('category_id', $product->category_id)
                        ->where('id', '!=', $product->id)
                        ->limit(8)
                        ->get();

        $productImages = ProductImage::where('product_id', $product->id)->get();
        $category = Category::find($product->category_id);

        return view('detailProduct', compact('product', 'phoneProducts', 'productImages', 'category'));
    }
    public function search(Request $request)
    {
        $search = $request->input('key');
        $results = Product::where('product_name', 'like', "%$search%")
                            ->get();

        return view('searchProduct', compact('results', 'search'));
    }

}
