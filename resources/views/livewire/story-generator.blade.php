<div x-data="{
    userCredits: @entangle('userCredits'),
    requiredCredits: 1,
    insufficientCredits() { return this.userCredits < this.requiredCredits; }
}">
    <div class="max-w-4xl mx-auto">
        <div class="overflow-hidden bg-white shadow-lg rounded-3xl">
            <div class="p-4 bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100">
                <h1 class="mb-6 text-3xl font-bold text-center text-indigo-600">Atelierul Povestitorului Magic</h1>

                <div class="mb-4 text-center">
                    <p class="font-bold"
                        :class="{ 'text-green-600': !insufficientCredits(), 'text-indigo-600': insufficientCredits() }">
                        <i class="mr-2 fas"
                            :class="{ 'fa-check-circle': !insufficientCredits(), 'fa-coins': insufficientCredits() }"></i>
                        Credite disponibile: <span x-text="userCredits"></span>
                    </p>
                    <p class="mt-2 text-sm text-indigo-500">
                        Valoare totală credite: {{ number_format($userCreditValue, 2) }} RON
                    </p>
                </div>

                <template x-if="insufficientCredits()">
                    <div class="p-4 mb-4 text-center text-yellow-700 bg-yellow-100 rounded-xl">
                        <p><i class="mr-2 fas fa-exclamation-triangle"></i>Atenție: Nu aveți suficiente credite pentru a
                            genera o poveste.</p>
                        <p class="mt-2">
                            <a href="{{ route('credits') }}" class="font-bold text-indigo-600 hover:text-indigo-800">
                                Cumpărați credite acum
                            </a>
                        </p>
                    </div>
                </template>

                <div
                    class="max-w-2xl p-4 mx-auto mb-6 border-2 border-yellow-300 shadow-md bg-gradient-to-br from-green-100 to-blue-100 rounded-2xl">
                    <h2 class="mb-3 text-2xl font-bold text-center text-indigo-700">
                        <i class="mr-2 fas fa-hat-wizard"></i>Ingredientele magice ale poveștii
                    </h2>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-8 h-8 mt-1 mr-3 text-sm font-bold text-white bg-indigo-500 rounded-full">
                                1</div>
                            <div>
                                <h3 class="text-lg font-semibold text-indigo-700">Vârsta copilului</h3>
                                <p class="text-sm text-indigo-600">Alege vârsta micuțului ascultător pentru a crea o
                                    poveste potrivită.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-8 h-8 mt-1 mr-3 text-sm font-bold text-white bg-indigo-500 rounded-full">
                                2</div>
                            <div>
                                <h3 class="text-lg font-semibold text-indigo-700">Formatul poveștii</h3>
                                <p class="text-sm text-indigo-600">Alege dacă dorești poveste cu text și ilustrație (1
                                    credit) sau cu versiune audio inclusă (3 credite)</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-8 h-8 mt-1 mr-3 text-sm font-bold text-white bg-indigo-500 rounded-full">
                                3</div>
                            <div>
                                <h3 class="text-lg font-semibold text-indigo-700">Genul poveștii</h3>
                                <p class="text-sm text-indigo-600">Selectează un gen magic (ex: "Aventură" sau "Basm")
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-8 h-8 mt-1 mr-3 text-sm font-bold text-white bg-indigo-500 rounded-full">
                                4</div>
                            <div>
                                <h3 class="text-lg font-semibold text-indigo-700">Alege tema poveștii</h3>
                                <div class="space-y-2 text-sm">
                                    <p class="text-indigo-600"><i class="mr-2 text-yellow-500 fas fa-star"></i>Alege din
                                        coșulețul cu idei</p>
                                    <p class="font-bold text-indigo-600"><i
                                            class="mr-2 text-purple-500 fas fa-star"></i>Sau inventează propria temă
                                        (ex: numele copilului, un loc anume sau o intamplare, prietenie, curaj, familie,
                                        etc)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form wire:submit.prevent="generateStory" class="space-y-8">
                    <!-- Secțiunea Vârsta -->
                    <div class="p-4 bg-yellow-100 shadow-inner rounded-2xl">
                        <label for="childAge" class="block mb-2 text-lg font-medium text-indigo-700">
                            <i class="mr-2 fas fa-birthday-cake"></i>Vârsta micului ascultător
                        </label>
                        <input wire:model.defer="childAge" type="number" id="childAge"
                            class="block w-full text-xl bg-white border-2 border-indigo-300 shadow-sm rounded-xl focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('childAge')
                            <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Secțiunea Format Poveste -->
                    <div class="p-4 bg-yellow-100 shadow-inner rounded-2xl">
                        <label class="block mb-2 text-lg font-medium text-indigo-700">
                            <i class="mr-2 fas fa-book"></i>Formatul poveștii
                        </label>
                        <div class="space-y-3">
                            <label class="flex items-center p-3 space-x-3 bg-white border rounded-xl"
                                :class="{ 'border-indigo-300': !
                                    includeAudio, 'cursor-not-allowed opacity-50': insufficientCredits() }">
                                <input type="radio" wire:model.defer="includeAudio" name="storyFormat" value="0"
                                    :disabled="insufficientCredits()"
                                    class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                <div class="flex flex-col">
                                    <span class="font-semibold text-indigo-700">Poveste cu text și ilustrație</span>
                                    <span class="text-sm text-indigo-600">Cost: 1 credit</span>
                                </div>
                            </label>

                            <label class="flex items-center p-3 space-x-3 bg-white border rounded-xl"
                                :class="{ 'border-indigo-300': includeAudio, 'cursor-not-allowed opacity-50': insufficientCredits() }">
                                <input type="radio" wire:model.defer="includeAudio" name="storyFormat" value="1"
                                    :disabled="insufficientCredits()"
                                    class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                <div class="flex flex-col">
                                    <span class="font-semibold text-indigo-700">Poveste audio cu text și
                                        ilustrație</span>
                                    <span class="text-sm text-indigo-600">Cost: 3 credite</span>
                                    <span class="text-xs text-indigo-500">Include lectură audio profesională</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Secțiunea Genuri -->
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        @foreach ($availableGenres as $genre => $details)
                            <div x-data="{ open: @entangle('selectedGenre').defer === '{{ $genre }}' }"
                                class="bg-white rounded-2xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105 {{ $selectedGenre === $genre ? 'ring-4 ring-indigo-400' : '' }}">
                                <button type="button"
                                    @click="open = !open; $wire.set('selectedGenre', open ? '{{ $genre }}' : '')"
                                    class="flex items-center justify-between w-full px-4 py-3 text-left bg-indigo-500">
                                    <h3 class="text-lg font-bold text-white">{{ $details['name'] }}</h3>
                                    <svg xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': open }"
                                        class="w-6 h-6 text-white transition-transform duration-200 transform"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-95" class="p-4 space-y-2">
                                    <button type="button" wire:click="setCustomTheme"
                                        class="w-full text-left px-3 py-2 rounded-xl font-bold text-pink-600 {{ $selectedTheme === 'custom' ? 'bg-pink-100' : 'hover:bg-pink-50' }}">
                                        <i class="mr-2 fas fa-star"></i>Temă personalizată
                                    </button>
                                    @if ($selectedTheme === 'custom')
                                        <input wire:model="customTheme" type="text"
                                            placeholder="Scrie-ți propria aventură aici"
                                            class="w-full mt-2 border-2 border-pink-300 shadow-sm rounded-xl focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50">
                                    @endif
                                    @foreach ($details['themes'] as $theme)
                                        <button type="button" wire:click="selectTheme('{{ $theme }}')"
                                            class="w-full text-left px-3 py-2 rounded-xl text-indigo-700 {{ $selectedTheme === $theme ? 'bg-indigo-100 font-bold' : 'hover:bg-indigo-50' }}">
                                            {{ $theme }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('selectedGenre')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                    @error('selectedTheme')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                    @error('customTheme')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror

                    <div class="text-center">
                        <button type="submit"
                            class="px-8 py-3 text-lg font-bold text-white transition duration-300 transform rounded-full shadow-lg md:text-xl bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                            wire:loading.attr="disabled" wire:target="generateStory"
                            :disabled="insufficientCredits()">
                            <span wire:loading.remove wire:target="generateStory">
                                <i class="mr-2 fas fa-book-open"></i>
                                Creează Povestea Magică
                            </span>
                            <span wire:loading wire:target="generateStory">
                                <i class="mr-2 fas fa-spinner fa-spin"></i>
                                <span x-show="!includeAudio">Povestitorul Magic pregătește povestea...</span>
                            </span>
                        </button>
                    </div>
                </form>

                <div class="flex items-center justify-center">
                    <div wire:loading wire:target="generateStory" class="mx-auto mt-4 text-center text-indigo-600">
                        <p class="text-lg font-semibold">
                            <i class="mr-2 fas fa-magic fa-spin"></i>Povestitorul Magic își folosește puterile pentru a
                            crea o poveste uimitoare...
                        </p>
                        <p class="mt-2 text-sm">Acest proces poate dura 1-2 minute. Vă rugăm să așteptați.</p>
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="p-4 mt-4 text-green-700 bg-green-100 rounded-xl">
                        <i class="mr-2 fas fa-check-circle"></i>{{ session('message') }}
                    </div>
                @endif

                @error('generation')
                    <div class="p-4 mt-4 text-red-700 bg-red-100 rounded-xl">
                        <i class="mr-2 fas fa-exclamation-circle"></i>{{ $message }}
                    </div>
                @enderror

                @if ($generatedStory && $story)
                    <div class="p-4 mt-8 bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100 rounded-2xl">
                        <h2 class="mb-4 text-2xl font-bold text-center text-indigo-700">{{ $storyTitle }}</h2>

                        @if ($story->image_url)
                            <img src="{{ $story->image_url }}" alt="Ilustrație pentru {{ $storyTitle }}"
                                class="object-cover w-full h-auto mb-4 rounded-lg shadow-lg"
                                onerror="this.onerror=null; this.src='/images/placeholder.webp'; this.alt='Imaginea nu a putut fi încărcată';">
                        @endif

                        @if ($story->has_audio && $story->audio_url)
                            <div class="p-4 mb-4 bg-white rounded-lg shadow-md">
                                <h3 class="mb-2 text-lg font-semibold text-indigo-700">
                                    <i class="mr-2 fas fa-headphones"></i>Ascultă povestea
                                </h3>
                                <audio controls controlsList="nodownload" class="w-full">
                                    <source src="{{ $story->audio_url }}" type="audio/mpeg">
                                    Browserul dumneavoastră nu suportă redarea audio.
                                </audio>
                            </div>
                        @else
                            <div class="p-4 mb-4 text-center rounded-lg shadow-sm bg-gray-50">
                                <p class="text-gray-600">
                                    <i class="mr-2 fas fa-volume-mute"></i>
                                    Această poveste nu are variantă audio disponibilă
                                </p>
                            </div>
                        @endif

                        <div class="p-6 prose text-indigo-900 bg-white shadow-inner max-w-none rounded-2xl">
                            {!! nl2br(e($generatedStory)) !!}
                        </div>


                    </div>
            </div>
            @endif
        </div>
    </div>
</div>
</div>
