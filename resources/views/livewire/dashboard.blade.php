<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-4">Poveștile tale</h2>
                @if($stories->count() > 0)
                    <div class="space-y-4">
                        @foreach($stories as $story)
                            <div class="bg-gray-100 p-4 rounded">
                                <h3 class="text-xl font-semibold">{{ $story->title }}</h3>
                                <p class="text-gray-600">Generată la: {{ $story->created_at->format('d.m.Y H:i') }}</p>
                                <a href="{{ route('story.show', $story) }}" class="text-blue-500 hover:underline">Citește povestea</a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>Nu ai generat încă nicio poveste. Începe să creezi povești magice pentru copilul tău!</p>
                @endif
            </div>
        </div>
    </div>
</div>