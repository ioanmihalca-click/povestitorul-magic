<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
       
            <div class="p-6 bg-white border-b border-gray-200 rounded-lg">
                <h2 class="mb-4 text-2xl font-bold">Poveștile tale</h2>
                @if($stories->count() > 0)
                    <div class="space-y-4">
                        @foreach($stories as $story)
                            <div class="p-4 bg-gray-100 rounded">
                                <h3 class="text-xl font-semibold">{{ $story->title }}</h3>
                                <p class="text-gray-600">Gen: {{ $story->genre->value }}</p>
                                <p class="text-gray-600">Vârsta recomandată: {{ $story->age }} ani</p>
                                <p class="text-gray-600">Generată la: {{ $story->created_at->format('d.m.Y H:i') }}</p>
                                <a href="{{ route('story.show', $story) }}" class="text-blue-500 hover:underline">Citește povestea</a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>Nu ai generat încă nicio poveste.</p>
                @endif
            </div>
        
    </div>
</div>