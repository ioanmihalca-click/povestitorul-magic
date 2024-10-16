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
}