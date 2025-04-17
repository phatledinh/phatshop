<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Chạy migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();  // Khóa chính tự động tăng
            $table->string('name');  // Tên thương hiệu
            $table->string('thumbnail')->nullable();  // Đường dẫn tới hình ảnh (có thể rỗng)
            $table->unsignedBigInteger('id_category');  // Khóa ngoại liên kết đến bảng categories

            $table->timestamps();

            $table->foreign('id_category')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Lùi lại migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
    }
};