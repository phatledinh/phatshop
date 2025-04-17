<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            // Dành cho người dùng đã đăng nhập
            $table->unsignedBigInteger('user_id')->nullable();

            // Dành cho người dùng chưa đăng nhập (guest)
            $table->char('cart_id', 32)->nullable();

            $table->unsignedBigInteger('product_id');
            $table->integer('quantity')->default(1);
            $table->timestamps();

            // Ràng buộc khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // Tăng tốc truy vấn và tránh trùng sản phẩm trong cùng giỏ
            $table->unique(['user_id', 'product_id']);
            $table->unique(['cart_id', 'product_id']);
            $table->index(['user_id', 'product_id']);
            $table->index(['cart_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};