    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="mb-6 text-center">
                    <p class="font-bold text-indigo-600">
                        <i class="mr-2 fas fa-coins"></i>Credite disponibile: {{ $userCredits }}
                    </p>
                    <p class="mt-2 text-sm text-indigo-500">
                        Valoare totală credite: {{ number_format($userCreditValue, 2) }} RON
                    </p>
                </div>

                <h2 class="mb-6 text-2xl font-semibold text-center text-indigo-700">Pachete de Credite</h2>

                <div class="mb-6 text-center">
                    <p class="text-lg font-semibold text-indigo-600">Preț standard: {{ number_format($basePrice, 2) }}
                        RON per credit</p>
                </div>

 <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                @foreach ($packages as $index => $package)
                    <div class="relative p-4 {{ $package['credits'] == 100 ? 'bg-indigo-200 border-2 border-indigo-500' : 'bg-indigo-100' }} rounded-lg shadow-sm transform transition-transform duration-300 hover:scale-105">
                        @if ($package['credits'] == 100)
                            <div class="absolute top-0 px-4 py-1 text-sm font-bold text-white transform -translate-x-1/2 -translate-y-1/2 bg-indigo-500 rounded-full left-1/2">
                                Cel mai popular
                            </div>
                        @endif
                        <h3 class="mb-2 text-xl font-bold text-indigo-700">{{ $package['credits'] }} Credite</h3>
                        <p class="mb-2 text-indigo-600">Preț: {{ number_format($package['price'], 2) }} RON</p>
                        <p class="mb-2 text-green-600">
                            Economisiți: {{ number_format($this->getPackageSavings($package['credits'], $package['price']), 2) }} RON
                        </p>
                        <p class="mb-4 text-sm text-indigo-500">
                            {{ number_format($this->getCostPerCredit($package['credits'], $package['price']), 2) }} RON per credit
                        </p>
                        <button wire:click="purchaseCredits({{ $index }})" wire:loading.attr="disabled"
                            wire:target="purchaseCredits({{ $index }})"
                            class="w-full px-4 py-2 text-white {{ $package['credits'] == 100 ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-indigo-500 hover:bg-indigo-600' }} rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-300">
                            <span wire:loading.remove wire:target="purchaseCredits({{ $index }})">
                                Cumpără
                            </span>
                            <span wire:loading wire:target="purchaseCredits({{ $index }})">
                                <i class="mr-2 fas fa-spinner fa-spin"></i>Se procesează...
                            </span>
                        </button>
                    </div>
                @endforeach
            </div>

                <div wire:loading wire:target="purchaseCredits"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
                    <div class="p-6 text-center bg-white rounded-lg shadow-xl">
                        <i class="mb-4 text-4xl text-indigo-500 fas fa-spinner fa-spin"></i>
                        <p class="text-lg font-semibold text-indigo-700">Se inițiază procesul de plată...</p>
                        <p class="mt-2 text-sm text-indigo-600">Vă rugăm să așteptați. Veți fi redirecționat în curând.
                        </p>
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="p-4 mt-4 text-green-700 bg-green-100 rounded">
                        {{ session('message') }}
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="p-4 mt-4 text-red-700 bg-red-100 rounded">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
        <script>
        document.addEventListener('livewire:initialized', () => {
            if (new URLSearchParams(window.location.search).has('session_id')) {
                Livewire.dispatch('refreshComponent');
            }
        });
    </script>
    </div>
