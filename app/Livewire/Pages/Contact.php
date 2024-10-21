<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;

class Contact extends Component
{
    public $name;
    public $email;
    public $message;

    public $isLoading = false;

    protected $rules = [
        'name' => 'required|min:2',
        'email' => 'required|email',
        'message' => 'required|min:10',
    ];

    public function submitForm()
    {
        $this->isLoading = true;

        $this->validate();

        // Trimite email
    Mail::to('contact@povestitorulmagic.ro')->send(new ContactFormMail($this->name, $this->email, $this->message));

        session()->flash('message', 'Mesajul dumneavoastră a fost trimis cu succes!');

        $this->reset(['name', 'email', 'message']);

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.pages.contact')
            ->layout('layouts.guest', ['title' => 'Contact']);
    }
}