<?php

namespace App\Models;
use App\Traits\SEOTrait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogPost extends Model
{
    use HasFactory, SEOTrait;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'story_id',
        'published_at',
        'featured_image',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}

