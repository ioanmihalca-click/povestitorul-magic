<?php

namespace App\Livewire;

use App\Models\BlogPost;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Traits\SEOTrait;

#[Layout('components.layouts.bloglayout')]
class ShowBlogPost extends Component
{
    use SEOTrait;

    public BlogPost $post;

    public function mount($slug)
    {
        $this->post = BlogPost::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.show-blog-post', [
            'metaTitle' => $this->post->getMetaTitle(),
            'metaDescription' => $this->post->getMetaDescription(),
            'canonicalUrl' => $this->post->getCanonicalUrl(),
            'schemaMarkup' => $this->post->getSchemaMarkup(),
            'ogType' => $this->post->getOgType(),
            'ogUrl' => $this->post->getOgUrl(),
            'ogTitle' => $this->post->getOgTitle(),
            'ogDescription' => $this->post->getOgDescription(),
            'ogImage' => $this->post->getOgImage(),
        ]);
    }
}