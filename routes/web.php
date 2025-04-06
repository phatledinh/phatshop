<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/gioi-thieu', [PageController::class, 'about'])->name('about');
Route::get('/lien-he', [PageController::class, 'contact'])->name('contact');
Route::get('/gio-hang', [PageController::class, 'cart'])->name('cart');
Route::get('/thanh-toan', [PageController::class, 'checkout'])->name('checkout');
Route::get('product/{slug}', [ProductController::class, 'show'])->name('product.detail');
Route::get('category/{slug}', [CategoryController::class, 'show'])->name('category.detail');