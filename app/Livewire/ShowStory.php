<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Story;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ShowStory extends Component
{
    use AuthorizesRequests;

    public Story $story;

    public function mount(Story $story)
    {
        $this->authorize('view', $story);
        $this->story = $story;
    }

    public function render()
    {
        return view('livewire.show-story')
            ->title($this->story->title . ' - Povestitorul Magic');
    }
}