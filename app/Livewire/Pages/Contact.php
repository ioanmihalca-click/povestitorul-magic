<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Contact extends Component
{
    public $name;
    public $email;
    public $message;

    protected $rules = [
        'name' => 'required|min:2',
        'email' => 'required|email',
        'message' => 'required|min:10',
    ];

    public function submitForm()
    {
        $this->validate();

        // Aici puteți adăuga logica pentru trimiterea emailului sau salvarea în baza de date
        // Pentru acest exemplu, doar vom afișa un mesaj de succes

        session()->flash('message', 'Mesajul dumneavoastră a fost trimis cu succes!');

        $this->reset(['name', 'email', 'message']);
    }

    public function render()
    {
        return view('livewire.pages.contact')
            ->layout('layouts.app', ['title' => 'Contact']);
    }
}