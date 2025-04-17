<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImages;
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
                                
        $productImages = ProductImages::where('product_id', $product->id)->get();                        
        $category = Category::find($product->category_id);
                  
        return view('detailProduct', compact('product', 'phoneProducts', 'productImages', 'category'));
    }
}