<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <div class="p-6 bg-white border-b rounded-lg border-gray-200">
    <form wire:submit.prevent="generateStory">
        <div class="space-y-6">
            <div>
                <label for="childAge" class="block text-sm font-medium text-gray-700">Vârsta copilului</label>
                <input wire:model="childAge" type="number" id="childAge" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                @error('childAge') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="storyGenre" class="block text-sm font-medium text-gray-700">Genul poveștii</label>
                <select wire:model="storyGenre" id="storyGenre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">Selectează genul</option>
                    @foreach($availableGenres as $genre => $details)
                        <option value="{{ $genre }}">{{ $details['name'] }}</option>
                    @endforeach
                </select>
                @error('storyGenre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Alegere temă</label>
                <div class="mt-2 space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="useCustomTheme" name="themeChoice" value="0" class="form-radio h-5 w-5 text-blue-600">
                        <span class="ml-2 text-gray-700">Temă predefinită</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="useCustomTheme" name="themeChoice" value="1" class="form-radio h-5 w-5 text-blue-600">
                        <span class="ml-2 text-gray-700">Temă personalizată</span>
                    </label>
                </div>
            </div>

            <div x-data="{ useCustomTheme: @entangle('useCustomTheme') }">
                <div x-show="!useCustomTheme">
                    <label for="storyTheme" class="block text-sm font-medium text-gray-700">Tema poveștii</label>
                    <select wire:model="storyTheme" id="storyTheme" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" :disabled="useCustomTheme">
                        <option value="">Selectează tema</option>
                        @foreach($availableGenres as $genre => $details)
                            <optgroup label="{{ $details['name'] }}">
                                @foreach($details['themes'] as $theme)
                                    <option value="{{ $theme }}">{{ $theme }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('storyTheme') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div x-show="useCustomTheme">
                    <label for="customTheme" class="block text-sm font-medium text-gray-700">Introduceți tema personalizată</label>
                    <input wire:model="customTheme" type="text" id="customTheme" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" :disabled="!useCustomTheme">
                    @error('customTheme') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Generează Poveste
            </button>
        </div>
    </form>

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