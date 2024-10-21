<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-lg rounded-3xl">
            <div class="p-6 bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100">
                <h1 class="mb-4 text-3xl font-bold text-center text-indigo-700">{{ $post->title }}</h1>
                <div class="flex justify-center mb-6">
                    @if ($post->featured_image)
                        <img src="{{ $post->featured_image }}" alt="Ilustrație pentru {{ $post->title }}" class="object-cover w-full max-w-2xl rounded-lg shadow-md">
                    @else
                        <div class="flex items-center justify-center w-full h-64 bg-gray-200 rounded-lg">
                            <span class="text-gray-500">Fără imagine</span>
                        </div>
                    @endif
                </div>
                <div class="max-w-2xl p-4 mx-auto bg-white shadow-inner rounded-xl">
                    <div class="flex justify-between max-w-xs mx-auto mb-4 text-sm text-gray-600">
                        <p><i class="mr-2 fas fa-book"></i>{{ $post->story->genre->value }}</p>
                        <p><i class="mr-2 fas fa-child"></i>{{ $post->story->age }} ani</p>
                    </div>
                    <div class="prose text-indigo-900 max-w-none no-select">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>
                <div class="flex items-center justify-between max-w-2xl mx-auto mt-6">
                    <a href="{{ route('blog.index') }}" class="inline-block px-6 py-3 text-white transition duration-300 bg-indigo-500 rounded-full hover:bg-indigo-600">
                        <i class="mr-2 fas fa-arrow-left"></i>Înapoi la Blog
                    </a>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800">
                            <i class="fab fa-facebook-square fa-2x"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-600">
                            <i class="fab fa-twitter-square fa-2x"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer" class="text-blue-700 hover:text-blue-900">
                            <i class="fab fa-linkedin fa-2x"></i>
                        </a>
                    </div>
                </div>
                <div class="max-w-xl mx-auto mt-12 space-y-8">
                    <p class="text-xl text-center text-gray-700">Îți place această poveste? <br> Înregistrează-te pentru a crea și citi mai multe!</p>
                    <div class="max-w-2xl p-4 mx-auto mb-6 border-2 border-yellow-300 shadow-md bg-gradient-to-br from-green-100 to-blue-100 rounded-2xl">
                        <h2 class="mb-3 text-2xl font-bold text-center text-indigo-700">
                            <i class="mr-2 fas fa-hat-wizard"></i>Ingredientele magice ale poveștii
                        </h2>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 mt-1 mr-3 text-sm font-bold text-white bg-indigo-500 rounded-full">1</div>
                                <div>
                                    <h3 class="text-lg font-semibold text-indigo-700">Alege varsta copilului</h3>
                                    <p class="text-sm text-indigo-600">Alege vârsta micuțului ascultător pentru a crea o poveste potrivită.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 mt-1 mr-3 text-sm font-bold text-white bg-indigo-500 rounded-full">2</div>
                                <div>
                                    <h3 class="text-lg font-semibold text-indigo-700">Alege genul poveștii</h3>
                                    <p class="text-sm text-indigo-600">Selectează un gen magic (ex: "Aventură" sau "Basm")</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 mt-1 mr-3 text-sm font-bold text-white bg-indigo-500 rounded-full">3</div>
                                <div>
                                    <h3 class="text-lg font-semibold text-indigo-700">Alege tema poveștii</h3>
                                    <div class="space-y-2 text-sm">
                                        <p class="text-indigo-600"><i class="mr-2 text-yellow-500 fas fa-star"></i>Alege din coșulețul cu idei</p>
                                        <p class="font-bold text-indigo-600"><i class="mr-2 text-purple-500 fas fa-star"></i>Sau inventează propria temă (ex: numele copilului, un loc anume sau o intamplare, prietenie, curaj, familie, etc)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('register') }}" class="inline-block px-8 py-4 text-xl font-bold text-white transition-all duration-300 transform bg-indigo-600 rounded-full shadow-lg hover:bg-indigo-700 hover:shadow-xl hover:-translate-y-1">
                                Înregistrează-te și începe aventura!
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
document.addEventListener('contextmenu', (e) => e.preventDefault());
</script>
</div>