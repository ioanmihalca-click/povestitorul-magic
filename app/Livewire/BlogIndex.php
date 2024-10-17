<?php

namespace App\Livewire;

use App\Models\BlogPost;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.bloglayout')]
class BlogIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $seo;
    protected $queryString = ['search'];

    public function mount()
    {
        $this->seo = $this->getSEOData();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $posts = BlogPost::where('title', 'like', '%' . $this->search . '%')
                         ->orderBy('published_at', 'desc')
                         ->paginate(10);

        return view('livewire.blog-index', ['posts' => $posts])
            ->layout('components.layouts.bloglayout', ['seo' => $this->seo]);
    }

    protected function getSEOData()
    {
        return [
            'metaTitle' => 'Blog | Povestitorul Magic',
            'metaDescription' => 'Descoperă cele mai recente povești și articole despre lumea magică a poveștilor pentru copii pe blogul Povestitorul Magic.',
            'canonicalUrl' => route('blog.index'),
            'ogType' => 'website',
            'ogUrl' => route('blog.index'),
            'ogTitle' => 'Blog | Povestitorul Magic',
            'ogDescription' => 'Descoperă cele mai recente povești și articole despre lumea magică a poveștilor pentru copii pe blogul Povestitorul Magic.',
            'ogImage' => asset('assets/blog-og-image.jpg'),
            'schemaMarkup' => $this->getSchemaMarkup(),
        ];
    }

    protected function getSchemaMarkup()
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Blog',
            'name' => 'Blog | Povestitorul Magic',
            'description' => 'Descoperă cele mai recente povești și articole despre lumea magică a poveștilor pentru copii pe blogul Povestitorul Magic.',
            'url' => route('blog.index'),
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