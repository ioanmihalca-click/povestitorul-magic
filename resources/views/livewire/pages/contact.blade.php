
<div class="container px-4 py-8 mx-auto">
    <h1 class="mb-6 text-3xl font-bold">Contactează-ne</h1>
    <form wire:submit.prevent="submitForm" class="max-w-lg">
        <div class="mb-4">
            <label for="name" class="block mb-2">Nume</label>
            <input type="text" id="name" wire:model="name" class="w-full px-3 py-2 border rounded">
            @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block mb-2">Email</label>
            <input type="email" id="email" wire:model="email" class="w-full px-3 py-2 border rounded">
            @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="message" class="block mb-2">Mesaj</label>
            <textarea id="message" wire:model="message" rows="4" class="w-full px-3 py-2 border rounded"></textarea>
            @error('message') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
<button 
    type="submit" 
    class="relative w-32 px-4 py-2 text-white bg-indigo-500 rounded"
    wire:loading.attr="disabled"
    wire:loading.class="opacity-75 cursor-not-allowed"
>
    <span wire:loading.remove>Trimite</span>
    <span wire:loading class="inline-flex items-center">
        <svg class="w-5 h-5 mr-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </span>
</button>
    </form>
    @if (session()->has('message'))
        <div class="p-4 mt-4 text-green-700 bg-green-100 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>