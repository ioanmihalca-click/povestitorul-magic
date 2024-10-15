<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="p-6 bg-white border-b border-gray-200 rounded-lg">
            <form wire:submit.prevent="generateStory">
                <div class="space-y-6">
                    <div>
                        <label for="childAge" class="block text-sm font-medium text-gray-700">Vârsta copilului</label>
                        <input wire:model="childAge" type="number" id="childAge" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('childAge') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <div class="p-4 mb-4 rounded-lg bg-blue-50">
                        <h2 class="mb-2 text-lg font-semibold">Selectați genul și tema poveștii</h2>
                        <ol class="space-y-2 list-decimal list-inside">
                            <li>Selectați tipul de poveste care vă place (de exemplu, "Aventură" sau "Basm").</li>
                            <li>Apoi, aveți două opțiuni pentru tema poveștii:
                                <ul class="mt-1 ml-4 list-disc list-inside">
                                    <li>Alegeți una din temele gata pregătite din listă</li>
                                    <li>SAU</li>
                                    <li>Scrieți propria voastră idee de temă în căsuța "Temă personalizată"</li>
                                </ul>
                            </li>
                        </ol>
                        <p class="mt-2 font-medium">Haideți să creăm o poveste magicaă împreună!</p>
                    </div>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($availableGenres as $genre => $details)
                                <div class="border rounded-lg p-4 {{ $selectedGenre === $genre ? 'border-blue-500' : 'border-gray-200' }}">
                                    <h3 class="mb-2 text-lg font-semibold">
                                        <button type="button" wire:click="$set('selectedGenre', '{{ $genre }}')" class="w-full text-left">
                                            {{ $details['name'] }}
                                        </button>
                                    </h3>
                                    @if($selectedGenre === $genre)
                                        <ul class="space-y-2">
                                            @foreach($details['themes'] as $theme)
                                                <li>
                                                    <button type="button" wire:click="selectTheme('{{ $theme }}')" class="w-full text-left px-2 py-1 rounded {{ $selectedTheme === $theme ? 'bg-blue-100' : 'hover:bg-gray-100' }}">
                                                        {{ $theme }}
                                                    </button>
                                                </li>
                                            @endforeach
                                            <li>
                                                <button type="button" wire:click="setCustomTheme" class="w-full font-bold text-blue-500 text-left px-2 py-1 rounded {{ $selectedTheme === 'custom' ? 'bg-blue-100' : 'hover:bg-gray-100' }}">
                                                    Temă personalizată
                                                </button>
                                            </li>
                                        </ul>
                                        @if($selectedTheme === 'custom')
                                            <input wire:model="customTheme" type="text" placeholder="Introduceți tema personalizată" class="w-full mt-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        @error('selectedGenre') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        @error('selectedTheme') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        @error('customTheme') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                        Generează Poveste
                    </button>
                </div>
            </form>

            @if(session()->has('message'))
                <div class="p-4 mt-4 text-green-700 bg-green-100 rounded">
                    {{ session('message') }}
                </div>
            @endif

            @error('generation')
                <div class="p-4 mt-4 text-red-700 bg-red-100 rounded">
                    {{ $message }}
                </div>
            @enderror

            @if($generatedStory)
                <div class="mt-6">
                    <h2 class="text-xl font-bold">{{ $storyTitle }}</h2>
                    <div class="mt-2 prose">
                        {!! nl2br(e($generatedStory)) !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>