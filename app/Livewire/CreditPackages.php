<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Stripe\StripeClient;
use Livewire\Attributes\On;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Exceptions\IncompletePayment;

class CreditPackages extends Component
{
    public $packages = [
        [
            'credits' => 10,
            'price' => 4.50,
            'stripe_price_id' => 'price_1QBFDgBBirsJlR3vwYfr3uuT',
        ],
        [
            'credits' => 50,
            'price' => 20.00,
            'stripe_price_id' => 'price_1QBFDgBBirsJlR3vzOOtMfGJ',
        ],
        [
            'credits' => 100,
            'price' => 35.00,
            'stripe_price_id' => 'price_1QBFDgBBirsJlR3vqr1rHpnW',
        ],
    ];

    public $basePrice = 0.50; // 0.50 RON per credit
    public $sessionId;

    protected $queryString = ['sessionId'];

    public function mount()
    {
        if (request()->has('session_id')) {
            $this->handleCheckoutSuccess(request()->get('session_id'));
            $this->dispatch('refreshComponent');
        }
    }

    #[On('refreshComponent')]
    public function refreshComponent()
    {
        // Această metodă va fi apelată pentru a reîmprospăta datele componentei
        $this->getUserCredits();
        $this->getUserCreditValue();
    }

    public function getUserCredits()
    {
        return Auth::user()->credits;
    }

    public function getUserCreditValue()
    {
        return Auth::user()->remaining_credit_value;
    }

    public function purchaseCredits($packageIndex)
    {
        $package = $this->packages[$packageIndex];
        $user = Auth::user();

        try {
            $stripe = new \Stripe\StripeClient(config('cashier.secret'));

            $checkout_session = $stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price' => $package['stripe_price_id'],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('credits') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('credits'),
                'client_reference_id' => $user->id,
                'customer_email' => $user->email,
                'metadata' => [
                    'credits' => $package['credits'],
                    'package_index' => $packageIndex,
                ],
            ]);

            return redirect($checkout_session->url);
        } catch (\Exception $e) {
            $this->addError('checkout', 'A apărut o eroare la inițierea plății: ' . $e->getMessage());
        }
    }

    public function handleCheckoutSuccess($sessionId)
    {
        try {
            $stripe = new \Stripe\StripeClient(config('cashier.secret'));
            $session = $stripe->checkout->sessions->retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                $credits = $session->metadata['credits'];
                $user = User::find(Auth::id());

                if ($user) {
                    $user->addCredits($credits);
                    session()->flash('message', "Ați achiziționat cu succes {$credits} credite!");
                    $this->dispatch('creditsUpdated');
                } else {
                    session()->flash('error', 'Nu s-a putut găsi utilizatorul.');
                }
            } else {
                session()->flash('error', 'A apărut o eroare la procesarea plății. Vă rugăm să contactați suportul.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Nu s-a putut verifica starea plății: ' . $e->getMessage());
        }
    }

    public function getCostPerCredit($credits, $price)
    {
        return round($price / $credits, 2);
    }

    public function getPackageSavings($credits, $price)
    {
        $regularPrice = $credits * $this->basePrice;
        $savings = $regularPrice - $price;
        return round($savings, 2);
    }

    public function render()
    {
        return view('livewire.credit-packages', [
            'userCredits' => $this->getUserCredits(),
            'userCreditValue' => $this->getUserCreditValue(),
        ]);
    }
}
