<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="mb-8 text-3xl font-bold text-center text-indigo-700">Blogul Povestitorului Magic</h1>
        
        <div class="mb-6">
            <input wire:model.debounce.300ms="search" type="text" placeholder="Caută articole..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="space-y-8">
            @foreach($posts as $post)
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="mb-2 text-2xl font-semibold text-indigo-600">
                            <a href="{{ route('blog.show', $post->slug) }}" class="hover:underline">{{ $post->title }}</a>
                        </h2>
                        <p class="mb-4 text-gray-600">Publicat la: {{ $post->published_at->format('d M Y') }}</p>
                        <p class="mb-4 text-gray-700">{{ Str::limit($post->excerpt, 150) }}</p>
                        <a href="{{ route('blog.show', $post->slug) }}" class="text-indigo-500 hover:text-indigo-600">
                            Citește mai mult <span class="ml-1">&rarr;</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
</div>