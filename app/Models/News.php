<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'id',
        'category_id',
        'title',
        'slug',
        'content',
        'excerpt',
        'image',
        'author',
    ];
    public function category()
    {
        return $this->belongsTo(NewsCategory::class);
    }
}
