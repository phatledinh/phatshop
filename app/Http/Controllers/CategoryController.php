<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
 use App\Models\Product;
 use App\Models\Brand;

use PHPUnit\Framework\Constraint\Count;

class CategoryController extends Controller {
    public function index() {

    }

    public function show($slug){
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)
                           ->get();

        $brands = Brand::where('id_category', $category->id)
                           ->get();
        $categoryName = Category::all();
        return view('category', compact('category', 'products', 'categoryName', 'brands'));
    }

}
