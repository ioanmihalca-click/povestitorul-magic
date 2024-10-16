<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-lg bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 rounded-3xl">
            <div class="p-6">
                <h2 class="mb-6 text-3xl font-bold text-center text-indigo-600">Biblioteca ta Magică</h2>
                @if($stories->count() > 0)
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($stories as $story)
                            <div class="p-4 transition duration-300 bg-white shadow-md rounded-xl hover:shadow-lg">
                                @if($story->image_url)
                                    <img src="{{ $story->image_url }}" alt="Ilustrație pentru {{ $story->title }}" class="object-cover w-full h-auto mb-4 rounded-lg">
                                @else
                                    <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
                                        <span class="text-gray-500">Fără imagine</span>
                                    </div>
                                @endif
                                <h3 class="mb-2 text-xl font-semibold text-indigo-700 line-clamp-1">{{ $story->title }}</h3>
                                <p class="text-gray-600"><i class="mr-2 fas fa-book"></i>{{ $story->genre->value }}</p>
                                <p class="text-gray-600"><i class="mr-2 fas fa-child"></i>{{ $story->age }} ani</p>
                                <p class="text-gray-600"><i class="mr-2 far fa-calendar-alt"></i>{{ $story->created_at->format('d.m.Y H:i') }}</p>
                                <a href="{{ route('story.show', $story) }}" class="inline-block px-4 py-2 mt-4 text-white transition duration-300 bg-indigo-500 rounded-lg hover:bg-indigo-600">Citește povestea</a>
                            </div>
                        @endforeach
                    </div>
                @else
                
 <p class="text-center text-gray-600">
        Nu ai generat încă nicio poveste. 
        <a href="{{ route('povestitorulmagic') }}" class="text-indigo-600 underline hover:text-indigo-800">
            Hai să creăm una împreună!
        </a>
    </p>
                @endif
            </div>
        </div>
    </div>
</div>