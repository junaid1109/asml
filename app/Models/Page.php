<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'meta_description',
        'meta_keywords',
        'published',
        'page_type',
        'display_location',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        // Use ID for admin routes (they include 'admin' in the route name), slug for frontend
        $route = \Illuminate\Support\Facades\Route::currentRouteName();
        
        if ($route && str_contains($route, 'admin')) {
            return 'id';
        }
        
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }
}
