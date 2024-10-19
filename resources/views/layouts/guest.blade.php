<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Povestitorul Magic - Povești Interactive și Personalizate pentru Copii</title>
    <meta name="description" content="Povestitorul Magic creează povești interactive și personalizate care încântă imaginația copiilor. Explorează o lume de aventuri, basme și lecții educative adaptate vârstei copilului tău.">
    <meta name="keywords" content="povești pentru copii, povești personalizate, povești interactive, basme, aventuri pentru copii, educație prin povești">
    <meta name="author" content="Povestitorul Magic">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Povestitorul Magic - Povești Interactive pentru Copii">
    <meta property="og:description" content="Descoperă lumea magică a poveștilor personalizate pentru copilul tău. Creăm aventuri unice adaptate vârstei fiecărui copil.">
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
<body class="font-['Nunito'] antialiased text-base sm:text-lg">
    <div class="flex flex-col items-center min-h-screen pt-4 bg-white sm:pt-6 sm:justify-center">
        <div class="flex items-center shrink-0">
            <a href="/" wire:navigate>
                <img src="{{ asset('assets/logo.jpg') }}" alt="Logo Povestitorul Magic"
                    class="block w-auto h-20 text-gray-800 fill-current sm:h-32" />
            </a>
        </div>
        
        <div class="w-full px-4 py-6 mt-4 overflow-hidden bg-white rounded-lg shadow-md sm:px-6 sm:mt-6 sm:max-w-md md:max-w-lg lg:max-w-xl">
            {{ $slot }}
        </div>
    </div>
    <x-footer />
</body>
</html>