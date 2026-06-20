<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | The Basecamp School</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "error-container": "#fb5151",
                        "on-secondary": "#d8f8ff",
                        "on-surface-variant": "#575c5e",
                        "on-secondary-container": "#005560",
                        "on-background": "#2a3031",
                        "primary-container": "#40cef3",
                        "inverse-surface": "#0a0f11",
                        "surface-variant": "#d6dee1",
                        "on-tertiary-fixed": "#001835",
                        "primary": "#006479",
                        "tertiary-dim": "#004f98",
                        "on-error-container": "#570008",
                        "on-primary": "#e0f6ff",
                        "on-primary-fixed": "#002a34",
                        "on-tertiary-fixed-variant": "#003971",
                        "surface-bright": "#f2f7f9",
                        "surface-container": "#e3e9ec",
                        "tertiary-container": "#80b2ff",
                        "surface-container-high": "#dce4e6",
                        "outline": "#72787a",
                        "on-tertiary-container": "#003061",
                        "secondary-dim": "#005863",
                        "secondary-container": "#96e6f6",
                        "inverse-on-surface": "#989ea0",
                        "error": "#b31b25",
                        "surface": "#f2f7f9",
                        "inverse-primary": "#40cef3",
                        "surface-container-low": "#ecf2f4",
                        "primary-fixed": "#40cef3",
                        "on-tertiary": "#eff2ff",
                        "secondary": "#006572",
                        "tertiary-fixed": "#80b2ff",
                        "error-dim": "#9f0519",
                        "outline-variant": "#a8aeb0",
                        "tertiary-fixed-dim": "#65a4ff",
                        "on-secondary-fixed": "#004049",
                        "primary-fixed-dim": "#28c0e4",
                        "primary-dim": "#00576a",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary-fixed-variant": "#005f6b",
                        "tertiary": "#005bae",
                        "surface-tint": "#006479",
                        "secondary-fixed-dim": "#88d8e7",
                        "surface-dim": "#cdd6d9",
                        "on-surface": "#2a3031",
                        "on-primary-container": "#00414f",
                        "surface-container-highest": "#d6dee1",
                        "on-error": "#ffefee",
                        "secondary-fixed": "#96e6f6",
                        "background": "#f2f7f9",
                        "on-primary-fixed-variant": "#004a5a"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Space Grotesk"],
                        "display": ["Space Grotesk"],
                        "body": ["Space Grotesk"],
                        "label": ["Space Grotesk"]
                    }
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: #f2f7f9;
            overflow-x: hidden;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 40px 60px rgba(42, 48, 49, 0.04);
        }

        .ghost-border {
            border: 1px solid rgba(168, 174, 176, 0.15);
        }

        .active-nav-indicator {
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #006479;
            box-shadow: 0 0 12px rgba(0, 100, 121, 0.5);
        }

        .cyan-glow {
            box-shadow: 0 0 20px rgba(64, 206, 243, 0.2);
        }

        .signature-gradient {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 100, 121, 0.1);
            border-radius: 10px;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="text-on-background bg-background min-h-screen relative" x-data="{ mobileOpen: false }">

<!-- Atmospheric Background Blobs -->
<div class="fixed inset-0 overflow-hidden -z-10 pointer-events-none">
    <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-primary-container/10 blur-[120px]"></div>
    <div class="absolute top-[20%] -right-[5%] w-[30%] h-[30%] rounded-full bg-secondary-container/10 blur-[100px]"></div>
    <div class="absolute bottom-[10%] left-[20%] w-[50%] h-[50%] rounded-full bg-tertiary-container/5 blur-[150px]"></div>
</div>

<!-- Mobile SideNavBar Overlay -->
<div 
    x-show="mobileOpen" 
    @click="mobileOpen = false" 
    class="fixed inset-0 bg-inverse-surface/30 backdrop-blur-sm z-40 md:hidden"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-cloak
></div>

<!-- SideNavBar -->
<aside 
    x-data="{ isHovered: false, isMobile: window.innerWidth < 768 }"
    @resize.window="isMobile = window.innerWidth < 768"
    @mouseenter="isHovered = isMobile ? false : true"
    @mouseleave="isHovered = false"
    :class="[
        mobileOpen ? 'flex w-72' : 'hidden md:flex',
        (isHovered && !isMobile) ? 'md:w-72 shadow-[0_20px_50px_rgba(42,48,49,0.15)]' : 'md:w-20'
    ]"
    class="h-[calc(100vh-2rem)] flex-col fixed left-4 top-4 bg-surface-container-lowest/85 backdrop-blur-3xl shadow-[0_10px_40px_rgba(42,48,49,0.06)] z-50 border border-white/20 transition-all duration-300 ease-in-out rounded-2xl"
    x-cloak
>
    <div class="flex flex-col h-full py-8 px-4 md:px-5">
        <div class="mb-10 flex justify-between items-center" :class="(isHovered && !isMobile) ? 'px-2' : 'md:justify-center px-0'">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 signature-gradient rounded-lg flex items-center justify-center text-white font-bold italic shadow-md shrink-0">B</div>
                <div x-show="isHovered || isMobile" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" class="flex flex-col">
                    <span class="font-display font-bold text-base tracking-tight text-primary whitespace-nowrap">The Basecamp School</span>
                    <p class="text-[9px] tracking-[0.2em] uppercase font-bold text-on-surface-variant/60">Institutional Admin</p>
                </div>
            </div>
            <!-- Mobile Close Button -->
            <button @click="mobileOpen = false" class="md:hidden p-1.5 rounded-lg hover:bg-surface-container-high text-on-surface-variant">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        @php
            $navLinks = [
                ['name' => 'Student Management', 'icon' => 'person', 'route' => 'admin.students'],
                ['name' => 'admin dashboard', 'icon' => 'how_to_reg', 'route' => 'admin.dashboard'],
                ['name' => 'Payment Management', 'icon' => 'payments', 'route' => 'admin.payments'],
                ['name' => 'Public Exam Management', 'icon' => 'school', 'route' => 'admin.exams'],
                ['name' => 'PCP Management', 'icon' => 'groups', 'route' => 'admin.pcp'],
                ['name' => 'TMA Management', 'icon' => 'assignment', 'route' => 'admin.tma'],
                ['name' => 'Study Material Management', 'icon' => 'book', 'route' => 'admin.study_material'],
                ['name' => 'Video Lesson Management', 'icon' => 'smart_display', 'route' => 'admin.video-lessons'],
                ['name' => 'Mocktest', 'icon' => 'quiz', 'route' => 'admin.mocktests'],
                ['name' => 'Digital Library', 'icon' => 'local_library', 'route' => 'admin.products'],
                ['name' => 'Result Management', 'icon' => 'grade', 'route' => 'admin.results'],
                ['name' => 'Notifications Center', 'icon' => 'notifications', 'route' => 'admin.notifications'],
                ['name' => 'Referral Monitor', 'icon' => 'group_add', 'route' => 'admin.referrals'],
                ['name' => 'Reports & Analytics', 'icon' => 'analytics', 'route' => 'admin.reports'],
            ];
        @endphp

        <nav class="flex-1 overflow-y-auto custom-scrollbar -mx-2 px-2 space-y-1">
            @foreach($navLinks as $link)
                @php
                    $isActive = $link['route'] !== '#' && request()->routeIs($link['route']);
                    // If route is #, it is a non-active module, otherwise render actual route link
                    $href = $link['route'] !== '#' ? route($link['route']) : '#';
                @endphp
                <a 
                    class="group relative flex items-center py-3 px-4 border-l-4 rounded-xl transition-all duration-350 {{ $isActive ? 'bg-primary/10 text-primary font-bold border-primary' : 'bg-transparent border-transparent hover:bg-primary/5 hover:text-primary hover:border-primary/30 text-on-surface-variant/80' }}" 
                    :class="(isHovered || isMobile) ? 'gap-4 justify-start' : 'md:justify-center md:gap-0 md:px-0'"
                    href="{{ $href }}"
                    title="{{ $link['name'] }}"
                >
                    <span 
                        class="material-symbols-outlined text-[20px] transition-all duration-300 scale-100 shrink-0 {{ $isActive ? 'text-primary scale-110' : 'text-on-surface-variant/60 group-hover:text-primary group-hover:scale-110' }}"
                        style="{{ $isActive ? 'font-variation-settings: \'FILL\' 1;' : '' }}"
                    >
                        {{ $link['icon'] }}
                    </span>
                    <span 
                        x-show="isHovered || isMobile" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="font-body text-xs tracking-[0.05em] uppercase whitespace-nowrap"
                    >
                        {{ $link['name'] }}
                    </span>
                </a>
            @endforeach
        </nav>

        <div class="mt-8 pt-6 border-t border-outline-variant/10">
            <div class="flex items-center justify-between" :class="(isHovered || isMobile) ? 'px-2' : 'md:justify-center px-0'">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full signature-gradient flex items-center justify-center text-white text-sm font-bold shadow-md shrink-0">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div x-show="isHovered || isMobile" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" class="flex flex-col">
                        <p class="font-bold text-sm text-on-background leading-none whitespace-nowrap">{{ Auth::user()->name ?? 'Admin Central' }}</p>
                        <p class="text-[10px] text-on-surface-variant mt-1">System Administrator</p>
                    </div>
                </div>
                <form x-show="isHovered || isMobile" method="POST" action="{{ route('logout') }}" class="m-0" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-2" x-transition:enter-end="opacity-100 translate-x-0">
                    @csrf
                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-error-container/10 text-on-surface-variant hover:text-error transition-all" title="Logout">
                        <span class="material-symbols-outlined text-[20px]">logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>

<!-- TopAppBar -->
<header class="flex justify-between items-center w-full md:pl-32 pr-6 md:pr-12 py-6 docked full-width top-0 sticky z-40 bg-surface/30 backdrop-blur-2xl transition-all duration-300">
    <div class="flex items-center gap-3">
        <!-- Mobile hamburger toggle button -->
        <button @click="mobileOpen = true" class="md:hidden p-2 rounded-xl hover:bg-surface-container text-on-surface-variant transition-colors">
            <span class="material-symbols-outlined">menu</span>
        </button>
        <h1 class="font-display font-extrabold text-lg sm:text-2xl text-primary tracking-tight">Institutional Command Center</h1>
    </div>
    
    <div class="flex items-center gap-4 sm:gap-8">
        <!-- Search bar (Hidden on mobile) -->
        <div class="relative hidden lg:block">
            <input class="bg-surface-container-low/50 ghost-border rounded-full py-2 px-6 pl-12 text-sm w-64 focus:ring-2 ring-primary/20 transition-all outline-none" placeholder="Search records..." type="text">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant/60 text-[20px]">search</span>
        </div>

        <div class="flex items-center gap-1 sm:gap-3">
            <!-- Language Switcher from Original UI -->
            <div x-data="{ langOpen: false }" class="relative">
                <button @click="langOpen = !langOpen"
                    class="flex items-center gap-1 px-2.5 py-2 rounded-xl hover:bg-surface-container-high/60 text-on-surface-variant hover:text-primary transition-colors text-sm font-semibold" type="button">
                    <span class="material-symbols-outlined text-[18px]">translate</span>
                    <span class="hidden xl:inline text-xs">{{ ['en'=>'English','hi'=>'हिन्दी','bn'=>'বাংলা','te'=>'తెలుగు','mr'=>'मराठी','ta'=>'தமிழ்','gu'=>'ગુજરાતી','kn'=>'കന്നಡ','ml'=>'മലയാളം','pa'=>'ਪੰਜਾਬੀ','ur'=>'اردو'][session('locale', 'en')] ?? 'English' }}</span>
                </button>
                <div x-show="langOpen" @click.outside="langOpen = false"
                    class="absolute right-0 top-full mt-2 w-44 bg-surface-container-lowest border border-outline-variant/20 rounded-2xl shadow-xl z-[999] py-2 max-h-[50dvh] overflow-y-auto"
                    style="display:none;">
                    @foreach(['en'=>'English','hi'=>'हिन्दी','bn'=>'বাংলা','te'=>'తెలుగు','mr'=>'मराठी','ta'=>'தமிழ்','gu'=>'ગુજરાતી','kn'=>'കന്നಡ','ml'=>'മലയാളം','pa'=>'ਪੰਜਾਬੀ','ur'=>'اردو'] as $code => $native)
                    <a href="{{ route('language.switch', $code) }}"
                       class="flex items-center gap-2 px-4 py-2.5 text-xs font-semibold transition-colors
                              {{ (session('locale', 'en') === $code) ? 'bg-primary/10 text-primary' : 'text-on-surface-variant hover:bg-surface-container-low' }}">
                        <span class="leading-none">{{ $native }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Settings -->
            <a href="{{ route('admin.settings') }}" class="w-10 h-10 flex items-center justify-center rounded-full text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined">settings</span>
            </a>

            <!-- Notifications -->
            <button class="w-10 h-10 flex items-center justify-center rounded-full text-on-surface-variant hover:text-primary transition-colors relative">
                <span class="material-symbols-outlined">notifications</span>
                <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-error rounded-full border-2 border-surface"></span>
            </button>

            <!-- Help -->
            <button class="w-10 h-10 flex items-center justify-center rounded-full text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined">help</span>
            </button>
        </div>
    </div>
</header>

<!-- Main Content Canvas -->
<main class="md:ml-28 min-h-[calc(100vh-100px)] p-6 lg:p-12 relative transition-all duration-300">
    {{ $slot }}
</main>

<script>
    // Atmospheric Scroll Interactions
    window.addEventListener('scroll', () => {
        const header = document.querySelector('header');
        if (header) {
            if (window.scrollY > 20) {
                header.classList.add('bg-white/70', 'shadow-sm');
                header.classList.remove('bg-surface/30');
            } else {
                header.classList.remove('bg-white/70', 'shadow-sm');
                header.classList.add('bg-surface/30');
            }
        }
    });
</script>
</body>
</html>