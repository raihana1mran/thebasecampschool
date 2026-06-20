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
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <script id="tailwind-config">
          tailwind.config = {
            darkMode: "class",
            theme: {
              extend: {
                "colors": {
                  "tertiary-fixed": "#80b2ff","surface-bright": "#f2f7f9","on-secondary-fixed-variant": "#005f6b",
                  "tertiary-fixed-dim": "#65a4ff","surface": "#f2f7f9","primary": "#006479",
                  "outline-variant": "#a8aeb0","surface-container-lowest": "#ffffff","on-secondary": "#d8f8ff",
                  "inverse-on-surface": "#989ea0","on-primary-fixed": "#002a34","surface-container-high": "#dce4e6",
                  "tertiary": "#005bae","tertiary-container": "#80b2ff","secondary-fixed-dim": "#88d8e7",
                  "surface-dim": "#cdd6d9","surface-container-low": "#ecf2f4","surface-container-highest": "#d6dee1",
                  "surface-tint": "#006479","primary-fixed": "#40cef3","on-error": "#ffefee",
                  "on-surface-variant": "#575c5e","on-primary": "#e0f6ff","inverse-primary": "#40cef3",
                  "inverse-surface": "#0a0f11","secondary-dim": "#005863","secondary-fixed": "#96e6f6",
                  "secondary-container": "#96e6f6","on-tertiary": "#eff2ff","on-tertiary-fixed-variant": "#003971",
                  "tertiary-dim": "#004f98","error-dim": "#9f0519","primary-dim": "#00576a",
                  "surface-container": "#e3e9ec","on-tertiary-container": "#003061","on-secondary-container": "#005560",
                  "on-primary-fixed-variant": "#004a5a","on-primary-container": "#00414f","on-tertiary-fixed": "#001835",
                  "primary-container": "#40cef3","on-error-container": "#570008","primary-fixed-dim": "#28c0e4",
                  "on-surface": "#2a3031","outline": "#72787a","secondary": "#006572",
                  "error-container": "#fb5151","error": "#b31b25","on-secondary-fixed": "#004049",
                  "background": "#f2f7f9","surface-variant": "#d6dee1"
                },
                "borderRadius": {"DEFAULT": "0.25rem","lg": "0.5rem","xl": "1.5rem","full": "9999px"},
                "fontFamily": {"headline": ["Space Grotesk"],"display": ["Space Grotesk"],"body": ["Space Grotesk"],"label": ["Space Grotesk"]}
              },
            },
          }
        </script>
        <style>
            body {
                font-family: 'Space Grotesk', sans-serif;
            }
            .glass-panel {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(24px);
                border: 1px solid rgba(255, 255, 255, 0.35);
            }
        </style>
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