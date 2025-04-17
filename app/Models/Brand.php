<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'brands'; // Chỉ định tên bảng

    protected $fillable = ['id', 'name', 'thumbnail', 'id_category'];
}
