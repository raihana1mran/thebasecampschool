<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Login | thebasecampschool</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&amp;family=Space+Grotesk:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
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
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .anti-gravity-shadow {
        box-shadow: 0 64px 64px -12px rgba(27, 27, 28, 0.04);
    }
    .glass-panel {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.35);
    }
</style>
</head>
<body class="bg-surface font-body text-on-surface selection:bg-primary-fixed">
<main class="min-h-screen flex items-center justify-center p-4 md:p-12">
<!-- Main Layout Container: Transactional Page -->
<div class="flex flex-col lg:flex-row w-full max-w-[1440px] min-h-[600px] md:min-h-[800px] bg-surface-container-lowest lg:rounded-[40px] overflow-hidden shadow-[0_64px_64px_-12px_rgba(0,0,0,0.04)]">
<!-- Form Section -->
<section class="flex-1 flex flex-col justify-between p-5 sm:p-8 md:p-12 lg:p-16 order-2 lg:order-1">
<!-- Brand Header -->
<div class="flex items-center gap-3 mb-8">
<div class="w-8 h-8 md:w-10 md:h-10 bg-primary flex items-center justify-center rounded-full">
<span class="material-symbols-outlined text-on-primary text-lg md:text-xl">account_balance</span>
</div>
<span class="font-headline font-extrabold tracking-tighter text-lg md:text-2xl">thebasecampschool</span>
</div>
<!-- Login Form Content -->
<div class="max-w-md w-full mx-auto lg:mx-0">
<header class="mb-8 md:mb-12">
<h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-headline font-bold tracking-tight mb-2 md:mb-4 text-primary leading-tight">Welcome back,<br/>Scholar.</h1>
<p class="text-on-surface-variant font-body text-base md:text-lg leading-relaxed">Enter your credentials to continue your journey into the weightless academic space.</p>
</header>
<x-auth-session-status class="mb-4" :status="session('status')" />
<form method="POST" action="{{ route('login') }}" class="space-y-6 md:space-y-8">
@csrf
<div class="space-y-4 md:space-y-6">
<!-- Email Input -->
<div class="group border-b border-outline-variant focus-within:border-primary transition-all duration-300">
<label class="block font-label text-xs uppercase tracking-[0.2em] text-on-surface-variant mb-1 md:mb-2" for="enrollment_number">Enrollment Number</label>
<input class="w-full bg-transparent border-none px-0 py-2 md:py-4 focus:ring-0 text-primary placeholder:text-outline-variant/50 text-base md:text-lg transition-all" id="enrollment_number" name="enrollment_number" value="{{ old('enrollment_number') }}" placeholder="123456789" required="" type="text" autofocus autocomplete="username"/>
<x-input-error :messages="$errors->get('enrollment_number')" class="mt-2" />
</div>
<!-- Password Input -->
<div class="group border-b border-outline-variant focus-within:border-primary transition-all duration-300">
<div class="flex justify-between items-end mb-1 md:mb-2">
<label class="block font-label text-xs uppercase tracking-[0.2em] text-on-surface-variant" for="password">Access Key</label>
@if (Route::has('password.request'))
<a class="font-label text-xs uppercase tracking-[0.1em] text-on-surface-variant hover:text-primary transition-colors" href="{{ route('password.request') }}">Forgot Password?</a>
@endif
</div>
<input class="w-full bg-transparent border-none px-0 py-2 md:py-4 focus:ring-0 text-primary placeholder:text-outline-variant/50 text-base md:text-lg transition-all" id="password" name="password" placeholder="••••••••" required="" type="password" autocomplete="current-password"/>
<x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>
</div>

<div class="block pt-2">
    <label for="remember_me" class="inline-flex items-center group cursor-pointer">
        <input id="remember_me" type="checkbox" class="rounded border-outline-variant/50 text-primary shadow-sm focus:ring-primary/20 bg-surface-container transition-all cursor-pointer" name="remember">
        <span class="ms-3 text-sm font-medium text-on-surface-variant group-hover:text-primary transition-colors">{{ __('Remember me on this device') }}</span>
    </label>
</div>

<div class="pt-4 space-y-4 md:space-y-6">
<button class="w-full h-12 md:h-16 bg-primary text-on-primary rounded-full font-headline font-bold text-base md:text-lg hover:scale-[1.02] active:scale-95 transition-all duration-300 flex items-center justify-center gap-3" type="submit">
    Sign In
    <span class="material-symbols-outlined">arrow_forward</span>
</button>
</div>
</form>
<!-- Footer Links -->
<div class="pt-6 md:pt-8">
<p class="font-body text-on-surface-variant text-sm">
    New to the Academy? 
    <a class="text-primary font-bold hover:underline transition-all underline-offset-4 ml-1" href="{{ route('register') }}">Enroll Now</a>
</p>
<p class="font-body text-on-surface-variant text-sm mt-3">
    <a class="text-primary font-bold hover:underline transition-all underline-offset-4" href="/">← Back to Home</a>
</p>
</div>
</div>
</section>
<!-- Visual Section -->
<section class="hidden lg:flex flex-[1.2] relative bg-primary items-center justify-center overflow-hidden order-1 lg:order-2">
<!-- Background Image with data-alt -->
<img class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-screen scale-110" data-alt="abstract high-tech digital atmosphere with glowing ethereal nodes and deep blue ethereal light trails symbolizing cosmic knowledge and futuristic education" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDaQjgOFUxkU8pBzAeV5-IFzwjBb_zRxc5-rFOn5mOdC-sPmpztapfasW9g-jz0QHAVR2zjRtNT9teUG-yuDCEfGIkZZwL2a7o9JYCGbxwSe512Kb_KnEqyXGbFM0st0poclUS_mpR3GpwIoY_QdfMNCwn3RF-RxhSVV71nD6EKtxVAwrbE0WJ-yhTpucpw8-kOqAicqbNAVM6Ktt-BHS6Y4bMUCkwT490DHeOSBt9squhWWAS4N2DvizwEaZKWqDoLEhC1qKyTd6k"/>
<!-- Floating Decorative Elements -->
<div class="absolute inset-0 bg-gradient-to-tr from-primary/95 via-primary/40 to-primary/10"></div>
<!-- Centerpiece Quote (Editorial Impact) -->
<div class="relative z-10 p-16 max-w-xl text-white">
<span class="font-label text-xs uppercase tracking-[0.4em] text-surface-variant/60 block mb-8">The Weightless Scholar</span>
<h2 class="text-5xl font-headline font-extralight italic tracking-tight leading-[1.1] mb-12">
    "Gravity is but a <span class="font-extrabold not-italic border-b-2 border-white/30">choice</span> of the unlearned mind."
</h2>
<!-- Glass Status Card -->
<div class="glass-panel p-8 rounded-3xl border border-white/10 flex items-center gap-6">
<div class="w-16 h-16 rounded-full bg-gradient-to-br from-white/20 to-white/5 flex items-center justify-center">
<span class="material-symbols-outlined text-white text-3xl">auto_awesome</span>
</div>
<div>
<p class="font-label text-[10px] uppercase tracking-widest text-white/50 mb-1">Academy Status</p>
<p class="font-headline font-medium text-white text-lg">Systems Optimal &amp; Weights Zeroed</p>
</div>
</div>
</div>
<!-- Subtle Texture Overlays -->
<div class="absolute bottom-12 right-12 flex gap-3">
<div class="w-2 h-2 rounded-full bg-white opacity-20"></div>
<div class="w-2 h-2 rounded-full bg-white opacity-40"></div>
<div class="w-2 h-2 rounded-full bg-white opacity-60"></div>
</div>
</section>
</div>
</main>
</body>
</html>