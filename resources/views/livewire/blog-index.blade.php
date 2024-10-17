<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="mb-8 text-3xl font-bold text-center text-indigo-700">Blogul Povestitorului Magic</h1>
        
        {{-- <div class="mb-6">
            <input wire:model.debounce.300ms="search" type="text" placeholder="Caută articole..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div> --}}

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($posts as $post)
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="flex flex-col h-full">
                        <div class="w-full">
                            @if ($post->featured_image)
                                <img src="{{ $post->featured_image }}" alt="Ilustrație pentru {{ $post->title }}"
                                    class="object-cover w-full h-auto"
                                    onerror="this.onerror=null; this.src='{{ asset('images/placeholder.webp') }}'; this.alt='Imaginea nu a putut fi încărcată';">
                            @else
                                <div class="flex items-center justify-center w-full h-48 bg-gray-200">
                                    <span class="text-gray-500">Fără imagine</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col justify-between flex-grow p-6">
                            <div>
                                <h2 class="mb-2 text-xl font-semibold text-indigo-600">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="hover:underline">{{ $post->title }}</a>
                                </h2>
                                <p class="mb-4 text-sm text-gray-600">Publicat la: {{ $post->published_at->format('d M Y') }} de Povestitorul Magic</p>
                                <p class="mb-4 text-gray-700">{{ Str::limit($post->excerpt, 100) }}</p>
                            </div>
                            <a href="{{ route('blog.show', $post->slug) }}" class="text-indigo-500 hover:text-indigo-600">
                                Citește mai mult <span class="ml-1">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
</div>