<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seo['metaTitle'] ?? 'Povestitorul Magic' }}</title>
    <meta name="description"
        content="{{ $seo['metaDescription'] ?? 'Descoperă lumea magică a poveștilor personalizate pentru copilul tău. Creăm aventuri unice adaptate vârstei fiecărui copil.' }}">

    @if (isset($seo['canonicalUrl']))
        <link rel="canonical" href="{{ $seo['canonicalUrl'] }}">
    @endif

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="{{ $seo['ogType'] ?? 'website' }}">
    <meta property="og:url" content="{{ $seo['ogUrl'] ?? url('/') }}">
    <meta property="og:title"
        content="{{ $seo['ogTitle'] ?? 'Povestitorul Magic - Povești Interactive pentru Copii' }}">
    <meta property="og:description"
        content="{{ $seo['ogDescription'] ?? 'Descoperă lumea magică a poveștilor personalizate pentru copilul tău. Creăm aventuri unice adaptate vârstei fiecărui copil.' }}">
    <meta property="og:image" content="{{ asset('assets/og-image.jpg') }}">

    @if (isset($seo['schemaMarkup']))
        <script type="application/ld+json">
        {!! json_encode($seo['schemaMarkup']) !!}
    </script>
    @endif

    <link rel="icon" type="image/png" href="{{ asset('assets/favicon/favicon-48x48.png') }}" sizes="48x48" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="Povestitorul Magic" />
    <link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-['Nunito'] antialiased">
    <div class="min-h-screen bg-gradient-to-br from-red-500 via-blue-300 to-yellow-200">
        <nav class="bg-white shadow-lg">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                         <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="/" wire:navigate>
                        <img src="{{ asset('assets/logo.jpg') }}" alt="Logo Povestitorul Magic"
                            class="block w-auto h-16 text-gray-800 fill-current" />
                    </a>
                </div>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ route('povestitorulmagic') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Creează o Poveste Magică
                        </a>
                    </div>
                </div>
            </div>
        </nav>

   

        <!-- Page Content -->
        <main class="p-2">
            {{ $slot }}
        </main>
    </div>
    <x-footer />
    @livewireScripts
</body>

</html>