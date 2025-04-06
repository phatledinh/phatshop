<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products'; // Chỉ định tên bảng

    protected $fillable = ['id', 'category_id', 'product_name', 'price_new', 'price_old', 'thumbnail', 'description', 'discount', 'suggestion', 'slug', 'giftbox'];
}