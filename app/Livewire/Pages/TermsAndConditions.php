<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class TermsAndConditions extends Component
{
    public function render()
    {
        return view('livewire.pages.terms-and-conditions')
            ->layout('layouts.guest', ['title' => 'Termeni și Condiții']);
    }
}