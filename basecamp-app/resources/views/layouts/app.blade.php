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
    <body class="antialiased min-h-screen flex flex-col bg-surface text-primary transition-colors duration-[1000ms]" style="overflow-x: visible; overflow-y: auto;">
        <!-- Dynamic Educational Background -->
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 bg-surface">
            <!-- Decorative overlay -->
            <div class="absolute inset-0 bg-surface/85 backdrop-blur-xl pointer-events-none z-10"></div>
            <!-- Parallax Background Image -->
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop" alt="Students studying together" class="w-[120vw] h-[120vh] -ml-[10vw] -mt-[10vh] object-cover absolute top-0 left-0 z-0 parallax-img opacity-50 grayscale" data-speed="0.6">
        </div>

        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="glass-panel border-none shadow-none bg-surface-container-highest mt-24 mx-4 max-w-7xl lg:mx-auto rounded-[2rem]">
                <div class="py-10 px-4 sm:px-8 lg:px-12">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-grow pt-8 pb-16">
            {{ $slot }}
        </main>
        
        @include('layouts.footer')
    </body>
</html>
