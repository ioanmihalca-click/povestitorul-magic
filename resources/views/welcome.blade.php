<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Povestitorul Magic</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        

    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <img class="rounded-full mb-4 w-72 h-72 object-contain" src="{{ asset('assets/fat-frumos.webp') }}" alt="Povestitorul Magic">
    <h1 class="text-4xl font-bold mb-4">Bun venit la Povestitorul Magic</h1>
    <p class="mb-8 text-xl">Generăm povești interactive personalizate pentru copilul tău.</p>
    <div class="space-x-4">
                            @if (Route::has('login'))
                            <livewire:welcome.navigation />
                        @endif
    </div>
</div>

    </body>
</html>
