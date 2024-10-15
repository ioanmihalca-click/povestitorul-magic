<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Povestitorul Magic</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="font-['Nunito'] antialiased">
    <div
        class="flex flex-col items-center justify-center min-h-screen p-4 bg-gradient-to-br from-red-500 via-blue-300 to-yellow-200">
        <div class="w-full max-w-4xl overflow-hidden bg-white shadow-2xl bg-opacity-90 rounded-3xl">
            <div class="relative p-8 text-center">

                <!-- Elemente decorative -->
                <div class="absolute top-0 left-0 w-16 h-16 bg-yellow-300 rounded-full opacity-50 "></div>
                <div class="absolute bottom-0 right-0 w-24 h-24 bg-blue-300 rounded-full opacity-30 ">
                </div>
                <div class="absolute w-12 h-12 bg-red-300 rounded-full opacity-50 top-1/4 right-1/4 ">
                </div>

                <!-- Conținut principal -->
                <div class="relative z-10">
                    <img class="object-cover w-48 h-48 mx-auto mb-6 transition-transform duration-300 transform border-4 border-yellow-400 rounded-full shadow-lg hover:scale-105"
                        src="{{ asset('assets/fat-frumos.webp') }}" alt="Povestitorul Magic">
                    <h1 class="mb-4 text-4xl font-bold leading-tight text-indigo-800">Bun venit în lumea <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">Povestitorului
                            Magic</span></h1>
                    <p class="mb-8 text-xl text-gray-700">Creăm povești interactive și personalizate care vor încânta
                        imaginația copilului tău.</p>

<div class="flex items-center justify-center w-full mt-8">
    <div class="inline-flex flex-col items-center justify-center space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
        @if (Route::has('login'))
            <livewire:welcome.navigation />
        @endif
    </div>
</div>
                </div>

                <!-- Elemente suplimentare -->
                <div class="flex justify-center mt-12 space-x-8">
                    <div class="text-center">
                        <i class="mb-2 text-3xl text-purple-500 fas fa-magic"></i>
                        <p class="text-sm text-gray-600">Povești Magice</p>
                    </div>
                    <div class="text-center">
                        <i class="mb-2 text-3xl text-green-500 fas fa-child"></i>
                        <p class="text-sm text-gray-600">Personalizate pentru Copii</p>
                    </div>
                    <div class="text-center">
                        <i class="mb-2 text-3xl text-blue-500 fas fa-book-reader"></i>
                        <p class="text-sm text-gray-600">Experiențe Interactive</p>
                    </div>
                </div>
            </div>
        </div>


    </div>
            <!-- Footer -->
        <x-footer />
</body>

</html>
