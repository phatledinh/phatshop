<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function listCategory()
    {
        $categories = Category::with('parent')->get();
        return view('admin.pages.Category.listCategory', compact('categories'));
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

    public function create()
    {
        $categories = Category::all();
        return view('admin.pages.Category.addCategory', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'ParentID' => 'nullable|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $thumbnailPath = public_path('images/categories');

        if (!file_exists($thumbnailPath) && !mkdir($thumbnailPath, 0755, true)) {
            return redirect()->back()->with('error', 'Không thể tạo thư mục lưu ảnh.');
        }

        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            try {
                $file->move($thumbnailPath, $filename);
                $data['thumbnail'] = 'images/categories/' . $filename;
            } catch (\Exception $e) {
                Log::error('Lỗi lưu thumbnail: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Lỗi lưu ảnh thumbnail.');
            }
        }

        Category::create($data);

        return redirect()->route('categories.create')->with('success', 'Thêm danh mục thành công!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::where('id', '!=', $id)->get();
        return view('admin.pages.Category.editCategory', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'ParentID' => 'nullable|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->ParentID = $request->ParentID;

        $thumbnailPath = public_path('images/categories');

        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            if ($category->thumbnail && file_exists(public_path($category->thumbnail))) {
                unlink(public_path($category->thumbnail));
            }
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($thumbnailPath, $filename);
            $category->thumbnail = 'images/categories/' . $filename;
        }

        $category->save();

        return redirect()->route('listCategory')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            if ($category->thumbnail && file_exists(public_path($category->thumbnail))) {
                unlink(public_path($category->thumbnail));
            }
            $category->delete();
            return response()->json(['success' => true, 'message' => 'Xóa danh mục thành công']);
        }
        return response()->json(['success' => false, 'message' => 'Không tìm thấy danh mục'], 404);
    }
}
