<div class="py-12">
    <div class="max-w-4xl mx-auto ">
        <div class="overflow-hidden bg-white shadow-lg rounded-3xl">
            <div class="p-4 bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100">
                <h1 class="mb-4 text-3xl font-bold text-center text-indigo-700">{{ $story->title }}</h1>
                <div class="flex justify-center mb-6">
                    @if ($story->image_url)
                        <img src="{{ $story->image_url }}" alt="Ilustrație pentru {{ $story->title }}"
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
                        <span class="mr-4"><i class="mr-2 fas fa-book"></i>{{ $story->genre }}</span>
                        <span class="mr-4"><i class="mr-2 fas fa-child"></i>{{ $story->age }} ani</span>
                        <span><i class="mr-2 fas fa-tag"></i>{{ $story->theme }}</span>
                    </p>

                    @if ($story->has_audio && $story->audio_url)
                        <div class="p-4 mb-4 bg-white rounded-lg shadow-md">
                            <h3 class="mb-2 text-lg font-semibold text-indigo-700">
                                <i class="mr-2 fas fa-headphones"></i>Ascultă povestea
                            </h3>
                            <audio controls controlsList="nodownload" class="w-full">
                                <source src="{{ $story->audio_url }}" type="audio/mpeg">
                                Browserul dumneavoastră nu suportă redarea audio.
                            </audio>
                        </div>
                    @else
                        <div class="p-4 mb-4 text-center rounded-lg shadow-sm bg-gray-50">
                            <p class="text-gray-600">
                                <i class="mr-2 fas fa-volume-mute"></i>
                                Această poveste nu are variantă audio disponibilă
                            </p>
                        </div>
                    @endif

                    <div class="prose text-indigo-900 max-w-none">
                        {!! nl2br(e($story->content)) !!}
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ route('biblioteca-magica') }}"
                        class="inline-block px-6 py-3 text-white transition duration-300 bg-indigo-500 rounded-full hover:bg-indigo-600">
                        <i class="mr-2 fas fa-arrow-left"></i>Înapoi la Biblioteca Magică
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
