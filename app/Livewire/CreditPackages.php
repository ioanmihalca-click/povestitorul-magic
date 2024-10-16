<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreditPackages extends Component
{
    public $packages = [
        ['credits' => 10, 'price' => 4.50, 'discount' => '10%'],
        ['credits' => 50, 'price' => 20.00, 'discount' => '20%'],
        ['credits' => 100, 'price' => 35.00, 'discount' => '30%'],
    ];

    public $basePrice = 0.50; // 0.50 RON per credit

    public function getUserCredits()
    {
        return Auth::user()->credits;
    }

    public function getUserCreditValue()
    {
        return Auth::user()->remaining_credit_value;
    }

    public function purchaseCredits($credits, $price)
    {
        // Aici ar trebui să implementați logica de plată reală
        // Pentru exemplu, vom simula o achiziție reușită
        // $user = Auth::user();
        // $user->addCredits($credits);
        // $this->emit('creditsUpdated');
        // session()->flash('message', "Ați achiziționat cu succes {$credits} credite pentru {$price} RON!");
    }

    public function getCostPerCredit($credits, $price)
    {
        return round($price / $credits, 2);
    }

    public function render()
    {
        return view('livewire.credit-packages', [
            'userCredits' => $this->getUserCredits(),
            'userCreditValue' => $this->getUserCreditValue(),
        ]);
    }
}