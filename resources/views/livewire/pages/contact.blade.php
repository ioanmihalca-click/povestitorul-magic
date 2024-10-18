// resources/views/livewire/pages/contact.blade.php
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
        <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded">Trimite</button>
    </form>
    @if (session()->has('message'))
        <div class="p-4 mt-4 text-green-700 bg-green-100 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>