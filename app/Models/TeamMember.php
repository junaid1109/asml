<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'bio',
        'image',
        'email',
        'phone',
        'twitter',
        'linkedin',
        'facebook',
        'instagram',
        'published',
        'order',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];
}
