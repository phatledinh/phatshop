<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'brands'; // Chỉ định tên bảng

    protected $fillable = ['id', 'name', 'thumbnail', 'id_category'];
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}