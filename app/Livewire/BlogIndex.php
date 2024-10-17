<?php

namespace App\Livewire;

use App\Models\BlogPost;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Traits\SEOTrait;

#[Layout('components.layouts.bloglayout')]
class BlogIndex extends Component
{
    use WithPagination, SEOTrait;

    public $search = '';
    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $posts = BlogPost::where('title', 'like', '%' . $this->search . '%')
                         ->orderBy('published_at', 'desc')
                         ->paginate(10);

        return view('livewire.blog-index', [
            'posts' => $posts,
            'metaTitle' => $this->getMetaTitle(),
            'metaDescription' => $this->getMetaDescription(),
            'canonicalUrl' => $this->getCanonicalUrl(),
            'schemaMarkup' => $this->getSchemaMarkup(),
            'ogType' => $this->getOgType(),
            'ogUrl' => $this->getOgUrl(),
            'ogTitle' => $this->getOgTitle(),
            'ogDescription' => $this->getOgDescription(),
            'ogImage' => $this->getOgImage(),
        ]);
    }

    // Suprascriem metodele SEO specifice pentru pagina de index a blogului
    public function getMetaTitle()
    {
        return 'Blog | Povestitorul Magic';
    }

    public function getMetaDescription()
    {
        return 'Descoperă cele mai recente povești și articole despre lumea magică a poveștilor pentru copii pe blogul Povestitorul Magic.';
    }

    public function getSchemaMarkup()
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Blog',
            'name' => $this->getMetaTitle(),
            'description' => $this->getMetaDescription(),
            'url' => $this->getCanonicalUrl(),
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