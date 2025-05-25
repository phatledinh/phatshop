<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Models\Category;
use App\Models\Order;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/gioi-thieu', [PageController::class, 'about'])->name('about');
Route::get('/lien-he', [PageController::class, 'contact'])->name('contact');
Route::get('/tin-tuc', [NewsController::class, 'index'])->name('news');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('detailNews');
Route::get('/cau-hoi-thuong-gap', [PageController::class, 'ask'])->name('ask');
Route::get('/tuyen-dung', [PageController::class, 'cruit'])->name('cruit');
Route::get('/gio-hang', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/gio-hang', [CartController::class, 'addToCart'])->name('cart');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove-selected', [CartController::class, 'removeSelected'])->name('cart.removeSelected');
Route::get('/search', [ProductController::class, 'search'])->name('product.search');
Route::post('/checkout/store-cart-items', [CheckoutController::class, 'storeCartItems'])->name('checkout.store')->middleware('auth');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.process')->middleware('auth');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout')->middleware('auth');


Route::post('/order', [CheckoutController::class, 'store'])->name('order.store')->middleware('auth');
Route::get('product/{slug}', [ProductController::class, 'show'])->name('product.detail');
Route::get('category/{slug}', [CategoryController::class, 'show'])->name('category.detail');
Route::post('/category/{slug}/filter', [CategoryController::class, 'filter'])->name('category.filter');
Route::post('/product/{slug}/review', [ReviewController::class, 'store'])->name('product.review.store');

// Method Payment
Route::post('/momo/payment', [CheckoutController::class, 'momo_payment'])->name('momo.payment');
Route::post('/momo/callback', [CheckoutController::class, 'momoCallback'])->name('momo.callback')->middleware('throttle:60,1');
Route::get('/momo/return', [CheckoutController::class, 'momoReturn'])->name('momo.return');
Route::get('/vnpay-return', [CheckoutController::class, 'vnpayReturn'])->name('vnpay.return');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/order/success', function () {
    return view('order_success');
})->name('order_success');
Route::post('/order/{orderId}/cancel', [CheckoutController::class, 'cancelOrder'])->name('order.cancel');

Route::get('/admin', [PageController::class, 'dashboard'])->name('admin');
Route::get('/admin/danh-sach-san-pham', [ProductController::class, 'listProduct'])->name('listProduct');
Route::get('/admin/them-san-pham', [ProductController::class, 'create'])->name('products.create');
Route::post('/admin/them-san-pham', [ProductController::class, 'store'])->name('products.store');
Route::post('/upload-image', [ProductController::class, 'uploadImage'])->name('upload.image');
Route::get('/get-brands-by-category', [ProductController::class, 'getBrandsByCategory'])->name('get.brands.by.category');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

Route::get('/admin/danh-sach-danh-muc', [CategoryController::class, 'listCategory'])->name('listCategory');
Route::get('/admin/them-tin-tuc', [NewsController::class, 'create'])->name('news.create');
Route::get('/admin/khach-hang', [UserController::class, 'listCustomer'])->name('listCustomer');
Route::get('/admin/don-hang', [OrderController::class, 'listOrder'])->name('listOrder');

Route::get('/admin/news/create', [NewsController::class, 'create'])->name('news.create');
Route::post('/admin/news', [NewsController::class, 'store'])->name('news.store');
Route::post('/admin/upload-image', [NewsController::class, 'uploadImage'])->name('upload.image');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';