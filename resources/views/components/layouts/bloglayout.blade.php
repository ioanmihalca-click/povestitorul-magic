<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metaTitle ?? 'Povestitorul Magic' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Descoperă lumea magică a poveștilor personalizate pentru copilul tău. Creăm aventuri unice adaptate vârstei fiecărui copil.' }}">
    
    @if(isset($canonicalUrl))
    <link rel="canonical" href="{{ $canonicalUrl }}">
    @endif

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:url" content="{{ $ogUrl ?? url('/') }}">
    <meta property="og:title" content="{{ $ogTitle ?? 'Povestitorul Magic - Povești Interactive pentru Copii' }}">
    <meta property="og:description" content="{{ $ogDescription ?? 'Descoperă lumea magică a poveștilor personalizate pentru copilul tău. Creăm aventuri unice adaptate vârstei fiecărui copil.' }}">
    <meta property="og:image" content="{{ $ogImage ?? asset('assets/og-image.jpg') }}">

    @if(isset($schemaMarkup))
    <script type="application/ld+json">
        {!! json_encode($schemaMarkup) !!}
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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-['Nunito'] antialiased">
    <div class="min-h-screen bg-gradient-to-br from-red-500 via-blue-300 to-yellow-200">
        <livewire:layout.navigation />

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="p-2">
            {{ $slot }}
        </main>
    </div>
    <x-footer />
    @livewireScripts
</body>

</html>
