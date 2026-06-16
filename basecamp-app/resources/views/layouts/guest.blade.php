<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'thebasecampschool') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300..800&family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased min-h-screen flex flex-col bg-surface text-primary transition-colors duration-[1000ms]">
        <!-- Dynamic Educational Background -->
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 bg-surface">
            <div class="absolute inset-0 bg-surface/85 backdrop-blur-xl pointer-events-none z-10"></div>
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop" alt="Students studying together" class="w-[120vw] h-[120vh] -ml-[10vw] -mt-[10vh] object-cover absolute top-0 left-0 z-0 parallax-img opacity-50 grayscale" data-speed="0.6">
        </div>

        @include('layouts.navigation')

        <!-- Page Content -->
        <main class="flex-grow pt-24 pb-16">
            <div class="w-full sm:max-w-md px-6 sm:px-8 py-10 glass-panel shadow-none border-none bg-surface-container-highest/80 backdrop-blur-xl sm:rounded-[2rem] z-10 relative mx-auto">
                {{ $slot }}
            </div>
        </main>

        @include('layouts.footer')
    </body>
</html>