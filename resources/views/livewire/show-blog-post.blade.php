<div class="py-12">
    <div class="max-w-4xl mx-auto">
        <div class="overflow-hidden bg-white shadow-lg rounded-3xl">
            <div class="p-4 bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100">
                <h1 class="mb-4 text-3xl font-bold text-center text-indigo-700">{{ $post->title }}</h1>
                <div class="flex justify-center mb-6">
                    @if ($post->featured_image)
                        <img src="{{ $post->featured_image }}" alt="Ilustrație pentru {{ $post->title }}"
                            class="h-auto max-w-full rounded-lg shadow-md"
                            onerror="this.onerror=null; this.src='/images/placeholder.webp'; this.alt='Imaginea nu a putut fi încărcată';">
                    @else
                        <div class="flex items-center justify-center w-full h-64 bg-gray-200 rounded-lg">
                            <span class="text-gray-500">Fără imagine</span>
                        </div>
                    @endif
                </div>
                <div class="p-6 bg-white shadow-inner rounded-xl">
                    <p class="mb-4 text-center text-gray-600">
                        Publicat la: {{ $post->published_at->format('d M Y') }} de Povestitorul Magic
                    </p>
                    <div class="prose text-indigo-900 max-w-none">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ route('blog.index') }}"
                        class="inline-block px-6 py-3 text-white transition duration-300 bg-indigo-500 rounded-full hover:bg-indigo-600">
                        <i class="mr-2 fas fa-arrow-left"></i>Înapoi la Blog
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>