<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-lg rounded-3xl">
            <div class="p-6 bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100">
                <h1 class="mb-4 text-3xl font-bold text-center text-indigo-700">{{ $post->title }}</h1>

                <div class="flex justify-center mb-6">
                    @if ($post->featured_image)
                        <img src="{{ $post->featured_image }}" alt="Ilustrație pentru {{ $post->title }}"
                            class="object-cover w-full max-w-2xl rounded-lg shadow-md">
                    @else
                        <div class="flex items-center justify-center w-full h-64 bg-gray-200 rounded-lg">
                            <span class="text-gray-500">Fără imagine</span>
                        </div>
                    @endif
                </div>

                <div class="max-w-2xl p-4 mx-auto bg-white shadow-inner rounded-xl">
                    <div class="flex justify-between max-w-xs mx-auto mb-4 text-sm text-gray-600">
                        {{-- <p><i class="mr-2 far fa-calendar-alt"></i>{{ $post->published_at->format('d.m.Y') }}</p> --}}
                        <p><i class="mr-2 fas fa-book"></i>Gen: {{ $post->story->genre->value }}</p>
                        <p><i class="mr-2 fas fa-child"></i>Varsta recomandata: {{ $post->story->age }} ani</p>
                    </div>

                    <div class="prose text-indigo-900 max-w-none">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>

                <div class="flex items-center justify-between max-w-2xl mx-auto mt-6">
                    <a href="{{ route('blog.index') }}"
                        class="inline-block px-6 py-3 text-white transition duration-300 bg-indigo-500 rounded-full hover:bg-indigo-600">
                        <i class="mr-2 fas fa-arrow-left"></i>Înapoi la Blog
                    </a>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                            target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800">
                            <i class="fab fa-facebook-square fa-2x"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}"
                            target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-600">
                            <i class="fab fa-twitter-square fa-2x"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($post->title) }}"
                            target="_blank" rel="noopener noreferrer" class="text-blue-700 hover:text-blue-900">
                            <i class="fab fa-linkedin fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
