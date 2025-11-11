<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'content',
        'image',
        'preview',
        'status',
        'views',
    ];
    protected $casts = [
        'content' => 'array'
    ];
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_news');
    }
}
