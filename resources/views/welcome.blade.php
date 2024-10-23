<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Povestitorul Magic - Povești Interactive și Personalizate pentru Copii</title>

    <meta name="description"
        content="Povestitorul Magic creează povești interactive și personalizate care încântă imaginația copiilor. Explorează o lume de aventuri, basme și lecții educative adaptate vârstei copilului tău.">

    <meta name="keywords"
        content="povești pentru copii, povești personalizate, povești interactive, basme, aventuri pentru copii, educație prin povești">

    <meta name="author" content="Povestitorul Magic">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Povestitorul Magic - Povești Interactive pentru Copii">
    <meta property="og:description"
        content="Descoperă lumea magică a poveștilor personalizate pentru copilul tău. Creăm aventuri unice adaptate vârstei fiecărui copil.">
    <meta property="og:image" content="{{ asset('assets/og-image.jpg') }}">

    <link rel="icon" type="image/png" href="assets/favicon/favicon-48x48.png" sizes="48x48" />
    <link rel="icon" type="image/svg+xml" href="assets/favicon/favicon.svg" />
    <link rel="shortcut icon" href="assets/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Povestitorul Magic" />
    <link rel="manifest" href="assets/favicon/site.webmanifest" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-EXFN904JQL"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-EXFN904JQL');
    </script>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="font-['Nunito'] antialiased">
    <div
        class="flex flex-col items-center justify-center min-h-screen p-4 bg-gradient-to-br from-red-500 via-blue-300 to-yellow-200">
        <div class="w-full max-w-4xl overflow-hidden bg-white shadow-2xl bg-opacity-90 rounded-3xl">
            <div class="relative p-4 text-center">

                <!-- Elemente decorative -->
                <div class="absolute top-0 left-0 w-16 h-16 bg-yellow-300 rounded-full opacity-50 "></div>
                <div class="absolute bottom-0 right-0 hidden w-24 h-24 bg-blue-300 rounded-full opacity-50 sm:block">
                </div>
                <div class="absolute w-12 h-12 bg-red-300 rounded-full opacity-50 top-1/4 right-1/4 ">
                </div>

                <!-- Conținut principal -->
                <div class="relative z-10">
                    <img class="object-cover w-48 h-48 mx-auto mb-6 transition-transform duration-300 transform border-4 border-yellow-400 rounded-full shadow-lg hover:scale-105"
                        src="{{ asset('assets/fat-frumos.webp') }}" alt="Povestitorul Magic">
                    <h1 class="mb-8 text-3xl font-bold leading-tight text-indigo-800 md:text-4xl">
                        <span class="block mb-2">Bun venit în lumea</span>
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 via-indigo-600 to-pink-600 animate-gradient">
                            Povestitorului Magic
                        </span>
                    </h1>

                    <div class="grid max-w-3xl gap-6 mx-auto mb-8 md:grid-cols-3">


                        <div
                            class="p-6 transition-all duration-300 transform bg-white shadow-md rounded-xl hover:scale-105 hover:shadow-xl">
                            <i class="mb-3 text-4xl text-indigo-600 fas fa-magic"></i>
                            <h3 class="mb-2 text-lg font-semibold text-indigo-800">Povești Personalizate</h3>
                            <p class="text-gray-600">Create special pentru copilul tău, adaptate vârstei și
                                preferințelor sale</p>
                        </div>

                        <div
                            class="p-6 transition-all duration-300 transform bg-white shadow-md rounded-xl hover:scale-105 hover:shadow-xl">
                            <i class="mb-2 text-3xl text-purple-600 fas fa-image"></i>
                            <h3 class="text-lg font-semibold text-indigo-800">Ilustrații Unice</h3>
                            <p class="text-gray-600">Fiecare poveste vine cu ilustrații magice</p>
                        </div>

                        <div
                            class="p-6 transition-all duration-300 transform bg-white shadow-md rounded-xl hover:scale-105 hover:shadow-xl">
                            <i class="mb-2 text-3xl text-pink-600 fas fa-headphones"></i>
                            <h3 class="text-lg font-semibold text-indigo-800">Poveste Audio</h3>
                            <p class="text-gray-600">Opțional, ascultă povestea in format audio</p>
                        </div>
                    </div>


                    <div
                        class="max-w-3xl p-4 mx-auto mb-8 shadow-lg bg-gradient-to-r from-indigo-50 via-purple-50 to-pink-50 rounded-xl">
                        <p class="text-lg text-indigo-900">
                            Creează povești unice pentru copilul tău în doar câțiva pași simpli.
                            <span class="font-semibold">Alege vârsta micului ascultător, formatul (text sau audio) și
                                tema dorită</span>,
                            iar Povestitorul Magic va crea o aventură specială, gata de citit sau de ascultat!
                        </p>
                    </div>


                    <div class="flex items-center justify-center w-full mt-8">
                        <div
                            class="inline-flex flex-col items-center justify-center space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                            @if (Route::has('login'))
                                <livewire:welcome.navigation />
                            @endif
                        </div>
                    </div>
                </div>



                <!-- Elemente suplimentare -->
                {{-- <div class="flex justify-center mt-12 space-x-8">
                    <div class="text-center">
                        <i class="mb-2 text-3xl text-purple-500 fas fa-magic"></i>
                        <p class="text-sm text-gray-600">Povești audio si text</p>
                    </div>
                    <div class="text-center">
                        <i class="mb-2 text-3xl text-green-500 fas fa-child"></i>
                        <p class="text-sm text-gray-600">Personalizate pentru Copii</p>
                    </div>
                    <div class="text-center">
                        <i class="mb-2 text-3xl text-blue-500 fas fa-book-reader"></i>
                        <p class="text-sm text-gray-600">Ilustrații Interactive</p>
                    </div>
                </div> --}}
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('blog.index') }}" class="text-lg text-gray-700 underline hover:text-indigo-700">
                    Viziteaza Blogul cu Povești
                </a>
            </div>

            <div class="my-4 text-center">
                <a href="{{ route('about') }}"
                    class="px-4 py-2 text-base font-medium text-gray-700 hover:text-indigo-700">
                    Află mai multe despre noi
                </a>
            </div>



            <!-- Secțiunea cu povestea aleatorie -->
            @if ($randomStory)
                <div class="p-4 mt-8 rounded-3xl">
                    <h2 class="mb-6 text-2xl font-bold text-center text-indigo-800 md:text-3xl">O poveste aleatorie din
                        Bibioteca Magică</h2>
                    <div class="max-w-xl mx-auto overflow-hidden bg-white rounded-lg shadow-lg">
                        @if ($randomStory->image_url)
                            <img src="{{ $randomStory->image_url }}" alt="{{ $randomStory->title }}"
                                class="object-cover w-full h-auto shadow-md ">
                        @endif
                        <div class="p-4">
                            <h3 class="mb-2 text-2xl font-bold text-center text-indigo-700">{{ $randomStory->title }}
                            </h3>
                            <div class="flex items-center justify-center mb-4 text-sm text-gray-600">
                                <span class="mr-4"><i
                                        class="mr-2 fas fa-book"></i>{{ $randomStory->genre->value }}</span>
                                <span><i class="mr-2 fas fa-child"></i>{{ $randomStory->age }}
                                    ani</span>
                            </div>

                            @if ($randomStory->has_audio && $randomStory->audio_url)
                                <div class="p-4 mb-4 bg-white rounded-lg shadow-md">
                                    <h3 class="mb-2 text-lg font-semibold text-indigo-700">
                                        <i class="mr-2 fas fa-headphones"></i>Ascultă povestea
                                    </h3>
                                    <audio controls controlsList="nodownload" class="w-full">
                                        <source src="{{ $randomStory->audio_url }}" type="audio/mpeg">
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

                            <div class="prose max-w-none">
                                {!! nl2br(e($randomStory->content)) !!}
                            </div>
                        </div>
                    </div>

                    <div class="max-w-xl mx-auto mt-12 space-y-8">
                        <p class="text-xl text-center text-gray-700">Îți place această poveste? <br> Înregistrează-te
                            pentru a crea, a citi sau a asculta mai multe!</p>
                        <div
                            class="max-w-2xl p-4 mx-auto mb-6 border-2 border-yellow-300 shadow-md bg-gradient-to-br from-green-100 to-blue-100 rounded-2xl">
                            <h2 class="mb-3 text-2xl font-bold text-center text-indigo-700">
                                <i class="mr-2 fas fa-hat-wizard"></i>Ingredientele magice ale poveștii
                            </h2>
                            <div class="space-y-4">
                                <div
                                    class="flex items-start p-3 transition-all duration-300 hover:bg-white hover:shadow-md rounded-xl">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-8 h-8 mt-1 mr-3 text-sm font-bold text-white bg-indigo-500 rounded-full">
                                        1</div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-indigo-700">Vârsta copilului</h3>
                                        <p class="text-sm text-indigo-600">Alege vârsta micuțului ascultător pentru a
                                            crea o poveste potrivită.</p>
                                    </div>
                                </div>

                                <div
                                    class="flex items-start p-3 transition-all duration-300 hover:bg-white hover:shadow-md rounded-xl">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-8 h-8 mt-1 mr-3 text-sm font-bold text-white bg-indigo-500 rounded-full">
                                        2</div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-indigo-700">Formatul poveștii</h3>
                                        <p class="text-sm text-indigo-600">Alege dacă dorești poveste cu text și
                                            ilustrație sau cu versiune audio inclusă</p>
                                    </div>
                                </div>

                                <div
                                    class="flex items-start p-3 transition-all duration-300 hover:bg-white hover:shadow-md rounded-xl">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-8 h-8 mt-1 mr-3 text-sm font-bold text-white bg-indigo-500 rounded-full">
                                        3</div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-indigo-700">Genul poveștii</h3>
                                        <p class="text-sm text-indigo-600">Selectează un gen magic (ex: "Aventură" sau
                                            "Basm")</p>
                                    </div>
                                </div>

                                <div
                                    class="flex items-start p-3 transition-all duration-300 hover:bg-white hover:shadow-md rounded-xl">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-8 h-8 mt-1 mr-3 text-sm font-bold text-white bg-indigo-500 rounded-full">
                                        4</div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-indigo-700">Alege tema poveștii</h3>
                                        <div class="space-y-2 text-sm">
                                            <p class="text-indigo-600"><i
                                                    class="mr-2 text-yellow-500 fas fa-star"></i>Alege din
                                                coșulețul cu idei</p>
                                            <p class="font-bold text-indigo-600"><i
                                                    class="mr-2 text-purple-500 fas fa-star"></i>Sau inventează propria
                                                temă
                                                (ex: numele copilului, un loc anume sau o intamplare, prietenie, curaj,
                                                familie,
                                                etc)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-center ">
                                <a href="{{ route('register') }}"
                                    class="inline-block px-8 py-4 text-xl font-bold text-white transition-all duration-300 transform bg-indigo-600 rounded-full shadow-lg hover:bg-indigo-700 hover:shadow-xl hover:-translate-y-1">
                                    Înregistrează-te și începe aventura!
                                </a>
                            </div>
                        </div>
                    </div>
            @endif
        </div>
        <x-footer />
    </div>


</body>

</html>
