<?php

namespace App\Traits;

trait SEOTrait
{
    public function getMetaTitle()
    {
        return $this->meta_title ?? $this->title . ' - Poveste pentru copii | Povestitorul Magic';
    }

    public function getMetaDescription()
    {
        return $this->meta_description ?? substr(strip_tags($this->content ?? ''), 0, 160);
    }

    public function getCanonicalUrl()
    {
        return route('blog.show', $this->slug);
    }

    public function getOgType()
    {
        return 'article';
    }

    public function getOgUrl()
    {
        return $this->getCanonicalUrl();
    }

    public function getOgTitle()
    {
        return $this->getMetaTitle();
    }

    public function getOgDescription()
    {
        return $this->getMetaDescription();
    }

    public function getOgImage()
    {
        return $this->featured_image ?? asset('assets/og-image.jpg');
    }

    public function getSchemaMarkup()
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $this->getMetaTitle(),
            'description' => $this->getMetaDescription(),
            'datePublished' => $this->published_at->toIso8601String() ?? now()->toIso8601String(),
            'dateModified' => $this->updated_at->toIso8601String() ?? now()->toIso8601String(),
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
            'image' => $this->getOgImage(),
        ];
    }
}