<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;


Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/gioi-thieu', [PageController::class, 'about'])->name('about');
Route::get('/lien-he', [PageController::class, 'contact'])->name('contact');
Route::get('/tin-tuc', [PageController::class, 'news'])->name('news');
Route::get('/cau-hoi-thuong-gap', [PageController::class, 'ask'])->name('ask');
Route::get('/tuyen-dung', [PageController::class, 'cruit'])->name('cruit');
Route::get('/gio-hang', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/gio-hang', [CartController::class, 'addToCart'])->name('cart');
Route::get('/thanh-toan', [PageController::class, 'checkout'])->name('checkout');
Route::get('product/{slug}', [ProductController::class, 'show'])->name('product.detail');
Route::get('category/{slug}', [CategoryController::class, 'show'])->name('category.detail');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';