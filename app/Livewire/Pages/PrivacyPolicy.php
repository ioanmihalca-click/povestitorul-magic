<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class PrivacyPolicy extends Component
{
    public function render()
    {
        return view('livewire.pages.privacy-policy')
            ->layout('layouts.guest', ['title' => 'Politica de Confidențialitate']);
    }
}