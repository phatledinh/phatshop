<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    public function index()
    {
        $saleNews = News::where('category_id', '1')->get();
        $suggesNews = News::inRandomOrder()->limit(4)->get();
        $topNews = News::where('category_id', '2')->get();
        $newNews = News::limit(7)->orderByDesc('created_at')->get();
        return view('news', compact('saleNews', 'suggesNews', 'topNews', 'newNews'));
    }

    public function listNews()
    {
        $news = News::with('category')->orderByDesc('created_at')->get();
        return view('admin.pages.News.listNews', compact('news'));
    }

    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('detailNews', compact('news'));
    }

    public function create()
    {
        $categories = NewsCategory::all();
        return view('admin.pages.News.addNews', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:news_categories,id',
            'author' => 'nullable|string|max:100',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $news = new News();
            $news->title = $validatedData['title'];
            $news->slug = Str::slug($validatedData['title']);
            $news->category_id = $validatedData['category_id'];
            $news->author = $validatedData['author'];
            $news->content = strip_tags($validatedData['content'], '<p><b><i><u><ul><ol><li><a><img><table><tr><td>');
            $news->excerpt = strip_tags($validatedData['excerpt'], '<p><b><i><ul><ol><li>');

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('images/news');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $image->move($destinationPath, $imageName);
                $news->image = 'images/news/' . $imageName;
            }

            $news->save();

            return redirect()->route('news.create')->with('success', 'Tin tức đã được thêm thành công.');
        } catch (\Exception $e) {
            Log::error('Error storing news: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Không thể thêm tin tức: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        $categories = NewsCategory::all();
        return view('admin.pages.News.editNews', compact('news', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:news_categories,id',
            'author' => 'nullable|string|max:100',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $news->title = $validatedData['title'];
            $news->slug = Str::slug($validatedData['title']);
            $news->category_id = $validatedData['category_id'];
            $news->author = $validatedData['author'];
            $news->content = strip_tags($validatedData['content'], '<p><b><i><u><ul><ol><li><a><img><table><tr><td>');
            $news->excerpt = strip_tags($validatedData['excerpt'], '<p><b><i><ul><ol><li>');

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($news->image && file_exists(public_path($news->image))) {
                    unlink(public_path($news->image));
                }

                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('images/news');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $image->move($destinationPath, $imageName);
                $news->image = 'images/news/' . $imageName;
            }

            $news->save();

            return redirect()->route('listNews')->with('success', 'Tin tức đã được cập nhật thành công.');
        } catch (\Exception $e) {
            Log::error('Error updating news: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Không thể cập nhật tin tức: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $news = News::find($id);
        if ($news) {
            if ($news->image && file_exists(public_path($news->image))) {
                unlink(public_path($news->image));
            }
            $news->delete();
            return response()->json(['success' => true, 'message' => 'Xóa tin tức thành công']);
        }
        return response()->json(['success' => false, 'message' => 'Không tìm thấy tin tức'], 404);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('news_images', $imageName, 'public');

            return response()->json([
                'url' => Storage::url($imagePath)
            ]);
        }

        return response()->json(['error' => 'Không có file được tải lên'], 400);
    }
}
