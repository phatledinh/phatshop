<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Review;
use Illuminate\Support\Str;
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
        $reviews = Review::where('product_id', $product->id)
                            ->with('user')
                            ->latest()
                            ->paginate(5);

        return view('detailProduct', compact('product', 'reviews', 'phoneProducts', 'productImages', 'category'));
    }
    public function search(Request $request)
    {
        $search = $request->input('key');
        $results = Product::where('product_name', 'like', "%$search%")
                            ->get();

        return view('searchProduct', compact('results', 'search'));
    }
    public function listProduct(){
        $products = Product::with(['category', 'brand'])->get();
        return view('admin/pages/Products/listProduct', compact('products'));
    }
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.pages.Products.addProduct', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'product_name' => 'required|string|max:255',
            'price_new' => 'required|numeric|min:0',
            'price_old' => 'nullable|numeric|min:0',
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'description' => 'nullable|string',
            'sortDesc' => 'nullable|string|max:255',
            'discount' => 'required|integer|min:0|max:100',
            'suggestion' => 'required|boolean',
            'stock' => 'required|integer|min:0',
            'sold' => 'required|integer|min:0',
            'giftbox' => 'nullable|string',
        ]);

        $data = $request->all();

        // Tạo slug từ product_name
        $data['slug'] = Str::slug($request->product_name);

        // Xử lý upload ảnh thumbnail
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);
            $data['thumbnail'] = 'images/products/' . $filename;
        }

        Product::create($data);

        return redirect()->route('products.create')->with('success', 'Thêm sản phẩm thành công!');
    }
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/uploads'), $filename);
            $url = asset('images/uploads/' . $filename);

            return response()->json([
                'url' => $url,
                'uploaded' => 1
            ]);
        }

        return response()->json(['error' => 'Upload failed'], 400);
    }
    public function getBrandsByCategory(Request $request)
    {
        $categoryId = $request->query('category_id');

        $brands = Brand::where('id_category', $categoryId)->get();

        return response()->json(['brands' => $brands]);
    }
}
