<?php

namespace App\Livewire;

use App\Models\Story;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('Biblioteca Magica | Povestitorul Magic')]
class Dashboard extends Component
{
    public function render()
    {
        $stories = collect();

        if (Auth::check()) {
            $stories = Story::where('user_id', Auth::id())->latest()->get();
        }

        return view('livewire.dashboard', compact('stories'));
    }

    public function deleteStory($storyId)
    {
        $story = Story::where('id', $storyId)
                      ->where('user_id', Auth::id())
                      ->first();

        if ($story) {
            $story->delete();
            session()->flash('message', 'Povestea a fost ștearsă cu succes.');
        }
    }
}