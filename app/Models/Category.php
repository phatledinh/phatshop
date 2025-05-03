<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories'; // Chỉ định tên bảng

    protected $fillable = ['id', 'name', 'thumbnail'];
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    public function brands()
    {
        return $this->hasMany(Brand::class, 'category_id');
    }
}