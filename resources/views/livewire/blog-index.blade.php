<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-lg bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 rounded-3xl">
            <div class="p-6">
                <h2 class="mb-4 text-3xl font-bold text-center text-indigo-600">Blogul Povestitorului Magic</h2>
                <p class="max-w-2xl mx-auto mb-8 text-center text-gray-700 bg-white bg-opacity-25">Povestitorul Magic
                    scrie săptămânal o poveste pe blog din Atelierul Magic de Povești</p>

                {{-- <div class="mb-6">
                    <input wire:model.debounce.300ms="search" type="text" placeholder="Caută articole..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div> --}}

                @if ($posts->count() > 0)
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($posts as $post)
                            <div class="p-4 transition duration-300 bg-white shadow-md rounded-xl hover:shadow-lg">
                                @if ($post->featured_image)
                                    <img src="{{ $post->featured_image }}" alt="Ilustrație pentru {{ $post->title }}"
                                        class="object-cover w-full h-48 mb-4 rounded-lg">
                                @else
                                    <div
                                        class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
                                        <span class="text-gray-500">Fără imagine</span>
                                    </div>
                                @endif
                                <h3 class="mb-2 text-xl font-semibold text-indigo-700 line-clamp-1">{{ $post->title }}
                                </h3>
                                <p class="text-gray-600"><i
                                        class="mr-2 far fa-calendar-alt"></i>{{ $post->published_at->format('d.m.Y') }}
                                </p>
                                <p class="text-gray-600"><i
                                        class="mr-2 fas fa-book"></i>Genul: {{ $post->story->genre->value }}</p>
                                <p class="text-gray-600"><i class="mr-2 fas fa-child"></i>Varsta recomandata: {{ $post->story->age }} ani
                                </p>
                                <p class="my-2 text-gray-700 line-clamp-3">{{ $post->excerpt }}</p>
                                <a href="{{ route('blog.show', $post->slug) }}"
                                    class="inline-block px-4 py-2 mt-2 text-white transition duration-300 bg-indigo-500 rounded-lg hover:bg-indigo-600">Citește
                                    povestea</a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-600">
                        Nu există încă articole pe blog.
                        <a href="{{ route('home') }}" class="text-indigo-600 underline hover:text-indigo-800">
                            Explorează alte secțiuni ale site-ului!
                        </a>
                    </p>
                @endif
            </div>
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
</div>
