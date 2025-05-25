<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Review;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class ProductController extends Controller
{
    public function index()
    {
        // Chưa triển khai
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
        $results = Product::where('product_name', 'like', "%$search%")->get();
        return view('searchProduct', compact('results', 'search'));
    }

    public function listProduct()
    {
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
            'related_images' => 'nullable|array|max:5',
            'related_images.*' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'description' => 'nullable|string',
            'suggestion' => 'required|boolean',
            'stock' => 'required|integer|min:0',
            'giftbox' => 'nullable|string',
        ]);
        $description = $request->description;
        $giftbox = $request->giftbox;

    $description = preg_replace('/style="[^"]*"/', '', $description);
    $giftbox = preg_replace('/style="[^"]*"/', '', $giftbox);
        $data = $request->all();
        $data['sold'] = 0;
        $data['slug'] = Str::slug($request->product_name);

        $thumbnailPath = public_path('images/products');
        $relatedPath = public_path('images/products/related');

        if (!file_exists($thumbnailPath) && !mkdir($thumbnailPath, 0755, true)) {
            return redirect()->back()->with('error', 'Không thể tạo thư mục lưu ảnh.');
        }
        if (!file_exists($relatedPath) && !mkdir($relatedPath, 0755, true)) {
            return redirect()->back()->with('error', 'Không thể tạo thư mục lưu ảnh liên quan.');
        }

        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            try {
                $file->move($thumbnailPath, $filename);
                $data['thumbnail'] = 'images/products/' . $filename;
            } catch (\Exception $e) {
                Log::error('Lỗi lưu thumbnail: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Lỗi lưu ảnh thumbnail.');
            }
        }

        $product = Product::create($data);

        if ($request->hasFile('related_images')) {
            foreach ($request->file('related_images') as $image) {
                if ($image->isValid()) {
                    $filename = time() . '_' . $image->getClientOriginalName();
                    try {
                        $image->move($relatedPath, $filename);
                        $product->images()->create([
                            'img_path' => 'images/products/related/' . $filename,
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Lỗi lưu ảnh liên quan: ' . $e->getMessage());
                        continue;
                    }
                }
            }
        }

        return redirect()->route('products.create')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/uploads'), $filename);
            $url = asset('images/uploads/' . $filename);
            return response()->json(['url' => $url, 'uploaded' => 1]);
        }
        return response()->json(['error' => 'Upload failed'], 400);
    }

    public function getBrandsByCategory(Request $request)
    {
        $categoryId = $request->query('category_id');
        $brands = Brand::where('id_category', $categoryId)->get();
        return response()->json(['brands' => $brands]);
    }
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return response()->json(['success' => true, 'message' => 'Xóa sản phẩm thành công']);
        }
        return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm'], 404);
    }
    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.pages.Products.editProduct', compact('product', 'categories', 'brands'));
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price_new' => 'required|numeric|min:0',
            'price_old' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'thumbnail' => 'nullable|image|max:2048',
            'related_images' => 'nullable|array|max:5',
            'related_images.*' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'deleted_images' => 'nullable|string',
            'description' => 'nullable|string',
            'giftbox' => 'nullable|string',
        ]);

        // Cập nhật thông tin sản phẩm
        $product->product_name = $request->product_name;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->price_new = $request->price_new;
        $product->price_old = $request->price_old;
        $product->stock = $request->stock;
        $product->description = $request->description; // Lưu description
        $product->giftbox = $request->giftbox; // Lưu giftbox

        $thumbnailPath = public_path('images/products');
        $relatedPath = public_path('images/products/related');

        // Xử lý thumbnail
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            if ($product->thumbnail && file_exists(public_path($product->thumbnail))) {
                unlink(public_path($product->thumbnail));
            }
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($thumbnailPath, $filename);
            $product->thumbnail = 'images/products/' . $filename;
        }

        // Xử lý xóa ảnh liên quan
        if ($request->filled('deleted_images')) {
            $deletedImageIds = explode(',', $request->input('deleted_images'));
            foreach ($deletedImageIds as $imageId) {
                $image = ProductImage::find($imageId);
                if ($image) {
                    if (file_exists(public_path($image->img_path))) {
                        unlink(public_path($image->img_path));
                    }
                    $image->delete();
                }
            }
        }

        // Xử lý ảnh liên quan mới
        if ($request->hasFile('related_images')) {
            if (!file_exists($relatedPath) && !mkdir($relatedPath, 0755, true)) {
                return redirect()->back()->with('error', 'Không thể tạo thư mục lưu ảnh liên quan.');
            }

            foreach ($request->file('related_images') as $image) {
                if ($image->isValid()) {
                    $filename = time() . '_' . $image->getClientOriginalName();
                    $image->move($relatedPath, $filename);
                    $product->images()->create([
                        'img_path' => 'images/products/related/' . $filename,
                    ]);
                }
            }
        }

        $product->save();

        return redirect()->route('listProduct')->with('success', 'Sản phẩm đã được cập nhật thành công.');
    }
}
