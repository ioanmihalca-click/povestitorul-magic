<?php

namespace App\Livewire;

use App\Models\BlogPost;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.bloglayout')]
class ShowBlogPost extends Component
{
    public BlogPost $post;
    public $seo;

    public function mount($slug)
    {
        $this->post = BlogPost::where('slug', $slug)->firstOrFail();
        $this->seo = $this->getSEOData();
    }

    public function render()
    {
        return view('livewire.show-blog-post')->layout('components.layouts.bloglayout', ['seo' => $this->seo]);
    }

    protected function getSEOData()
    {
        return [
            'metaTitle' => $this->post->meta_title ?? $this->post->title,
            'metaDescription' => $this->post->meta_description ?? $this->post->excerpt,
            'canonicalUrl' => route('blog.show', $this->post->slug),
            'ogType' => 'article',
            'ogUrl' => route('blog.show', $this->post->slug),
            'ogTitle' => $this->post->meta_title ?? $this->post->title,
            'ogDescription' => $this->post->meta_description ?? $this->post->excerpt,
            'ogImage' => $this->post->featured_image ? asset('storage/' . $this->post->featured_image) : asset('assets/blog-og-image.jpg'),
            'schemaMarkup' => $this->getSchemaMarkup(),
        ];
    }

    protected function getSchemaMarkup()
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $this->post->title,
            'description' => $this->post->excerpt,
            'datePublished' => $this->post->published_at->toIso8601String(),
            'dateModified' => $this->post->updated_at->toIso8601String(),
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
            'image' => $this->post->featured_image ? asset('storage/' . $this->post->featured_image) : asset('assets/blog-og-image.jpg'),
            'url' => route('blog.show', $this->post->slug),
        ];
    }
}