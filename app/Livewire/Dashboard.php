<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Story;
use Illuminate\Support\Facades\Auth;

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