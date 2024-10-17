<?php

namespace App\Models;

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

trait SEOTrait
{
    public function getMetaTitle()
    {
        return $this->meta_title ?? $this->title . ' - Poveste pentru copii | Povestitorul Magic';
    }

    public function getMetaDescription()
    {
        return $this->meta_description ?? substr(strip_tags($this->content), 0, 160);
    }

    public function getCanonicalUrl()
    {
        return route('blog.show', $this->slug);
    }

    public function getSchemaMarkup()
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $this->getMetaTitle(),
            'description' => $this->getMetaDescription(),
            'datePublished' => $this->published_at->toIso8601String(),
            'dateModified' => $this->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => 'Povestitorul Magic',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Povestitorul Magic',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('assets/favicon/apple-touch-icon.png'),
                ]
            ],
        ];
    }
}