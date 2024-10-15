<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Sterge contul') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Odata ce contul este sters, toate resursele si datele vor fi permanent sterse. Inainte de a sterge contul, va rugam downoadati toate datele sau informatiile de care aveti nevoie.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Sterge contul') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6">

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Sunteti sigur/a ca doriti sa stergeti contul?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Odata ce contul este sters, toate resursele si datele vor fi permanent sterse. Va rugam introduceti parola pentru a confirma ca doriti stergerea permanenta a contului') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="block w-3/4 mt-1"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Anuleaza') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Sterge contul') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
