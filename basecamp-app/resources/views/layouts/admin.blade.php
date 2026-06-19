<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'thebasecampschool') }} - Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Space Grotesk', sans-serif; background-color: #f0f4f8; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .signature-gradient { background: linear-gradient(135deg, #006479 0%, #40cef3 100%); }
        .glass-panel { background: rgba(255,255,255,0.7); backdrop-filter: blur(24px); border: 1px solid rgba(255,255,255,0.2); }
        [x-cloak] { display: none !important; }

        /* Sidebar width transitions */
        #admin-sidebar { transition: width 0.35s cubic-bezier(0.4,0,0.2,1), transform 0.35s cubic-bezier(0.4,0,0.2,1); }
        #admin-main-content { transition: margin-left 0.35s cubic-bezier(0.4,0,0.2,1); }

        /* Tooltip for collapsed mode */
        .sidebar-tooltip {
            position: absolute;
            left: calc(100% + 12px);
            top: 50%;
            transform: translateY(-50%);
            background: #1e293b;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 8px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s ease;
            z-index: 100;
        }
        .sidebar-tooltip::before {
            content: '';
            position: absolute;
            right: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: #1e293b;
        }

        /* Scrollbar styling */
        #admin-sidebar::-webkit-scrollbar { width: 4px; }
        #admin-sidebar::-webkit-scrollbar-track { background: transparent; }
        #admin-sidebar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }
    </style>
</head>
<body class="bg-[#f0f4f8] text-slate-800 antialiased h-screen w-screen flex overflow-hidden">

<div
    x-data="{
        expanded: true,
        mobileOpen: false,
        toggleExpand() { this.expanded = !this.expanded; },
        openMobile() { this.mobileOpen = true; },
        closeMobile() { this.mobileOpen = false; }
    }"
    class="h-screen w-screen flex relative overflow-hidden"
>
    <!-- ==================== SIDEBAR ==================== -->
    <aside
        id="admin-sidebar"
        :class="[
            expanded ? 'w-[280px] sm:w-64' : 'w-[72px]',
            mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
        ]"
        class="fixed top-0 left-0 bottom-0 sm:top-4 sm:left-4 sm:bottom-4 h-full sm:h-[calc(100vh-2rem)] bg-white border-0 sm:border sm:border-slate-200/60 shadow-2xl sm:shadow-xl sm:shadow-slate-200/50 flex flex-col z-50 rounded-none sm:rounded-[2rem] overflow-hidden"
    >
        <!-- Brand Header -->
        <div class="flex items-center px-4 py-5 border-b border-slate-100 shrink-0" :class="expanded ? 'justify-between' : 'justify-center'">
            <!-- Logo Icon always visible -->
            <div class="w-9 h-9 rounded-xl signature-gradient flex items-center justify-center text-white shadow-lg shrink-0">
                <span class="material-symbols-outlined text-[18px]">admin_panel_settings</span>
            </div>
            <!-- Title: only shown when expanded -->
            <div x-show="expanded" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" class="ml-3 overflow-hidden">
                <p class="text-[13px] font-black text-slate-800 leading-none whitespace-nowrap">thebasecampschool</p>
                <p class="text-[9px] text-cyan-600 font-bold tracking-[0.2em] uppercase mt-0.5">Admin Portal</p>
            </div>
            <!-- Expand/Collapse toggle always visible on desktop -->
            <button
                @click="toggleExpand()"
                class="hidden lg:flex ml-auto p-1.5 rounded-lg hover:bg-slate-100 transition-colors text-slate-400 hover:text-slate-700 shrink-0"
                :class="expanded ? '' : 'mx-auto mt-2'"
                x-show="expanded"
                x-transition
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m11 17-5-5 5-5"/><path d="m18 17-5-5 5-5"/></svg>
            </button>
            <!-- Mobile Close -->
            <button @click="closeMobile()" class="lg:hidden p-1.5 rounded-lg hover:bg-slate-100 text-slate-400" x-show="expanded">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        <!-- Collapsed expand button -->
        <div x-show="!expanded" class="flex justify-center pt-3 pb-1 shrink-0">
            <button
                @click="toggleExpand()"
                class="p-2 rounded-xl hover:bg-cyan-50 hover:text-cyan-600 transition-colors text-slate-400"
                title="Expand sidebar"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m13 17 5-5-5-5"/><path d="m6 17 5-5-5-5"/></svg>
            </button>
        </div>

        <!-- Nav Items -->
        @php
            $navLinks = [
                ['name' => __('overview_title'), 'icon' => 'dashboard',        'route' => 'admin.dashboard'],
                // ['name' => __('students'),       'icon' => 'group',            'route' => 'admin.students'],
                ['name' => __('enrollments'),    'icon' => 'fact_check',       'route' => 'admin.admissions'],
                ['name' => __('digital_library'),'icon' => 'library_books',    'route' => 'admin.products'],
                ['name' => __('mock_tests'),     'icon' => 'quiz',             'route' => 'admin.mocktests'],
                ['name' => __('payments'),       'icon' => 'payments',         'route' => 'admin.payments'],
                ['name' => __('referrals'),      'icon' => 'card_giftcard',    'route' => 'admin.referrals'],
                ['name' => __('settings'),       'icon' => 'settings',         'route' => 'admin.settings'],
            ];
        @endphp

        <nav class="flex-1 overflow-y-auto py-3 px-2 space-y-0.5" id="admin-nav">
            @foreach($navLinks as $link)
                @php $isActive = request()->routeIs($link['route']); @endphp
                <a href="{{ route($link['route']) }}" class="relative flex items-center rounded-xl transition-all duration-200 group
                    {{ $isActive
                        ? 'bg-gradient-to-r from-cyan-600 to-cyan-500 text-white shadow-lg shadow-cyan-500/25'
                        : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}"
                    :class="expanded ? 'gap-3 px-3 py-3' : 'justify-center px-0 py-3 mx-1'"
                >
                    <!-- Icon -->
                    <span class="material-symbols-outlined text-[20px] shrink-0 transition-colors {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-cyan-600' }}"
                          style="{{ $isActive ? 'font-variation-settings: \'FILL\' 1;' : '' }}">
                        {{ $link['icon'] }}
                    </span>

                    <!-- Label (only when expanded) -->
                    <span x-show="expanded" x-transition:enter="transition ease-out duration-150 delay-75" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        class="text-[13px] font-semibold whitespace-nowrap overflow-hidden">
                        {{ $link['name'] }}
                    </span>

                    <!-- Active dot (collapsed mode) -->
                    @if($isActive)
                        <span x-show="!expanded" class="absolute right-1 top-1/2 -translate-y-1/2 w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                    @endif

                    <!-- Tooltip for collapsed mode -->
                    <span x-show="!expanded" class="sidebar-tooltip group-hover:opacity-100">{{ $link['name'] }}</span>
                </a>
            @endforeach
        </nav>

        <!-- Footer: Logout -->
        <div class="p-2 border-t border-slate-100 shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="relative flex items-center w-full rounded-xl text-slate-500 hover:bg-red-50 hover:text-red-600 transition-all duration-200 group"
                    :class="expanded ? 'gap-3 px-3 py-3' : 'justify-center px-0 py-3 mx-1'"
                >
                    <span class="material-symbols-outlined text-[20px] shrink-0 text-slate-400 group-hover:text-red-500 transition-colors">logout</span>
                    <span x-show="expanded" x-transition:enter="transition ease-out duration-150 delay-75" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        class="text-[13px] font-semibold whitespace-nowrap">{{ __('sign_out') }}</span>
                    <span x-show="!expanded" class="sidebar-tooltip group-hover:opacity-100">{{ __('sign_out') }}</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Mobile overlay -->
    <div
        x-show="mobileOpen"
        @click="closeMobile()"
        class="fixed inset-0 bg-black/30 z-40 lg:hidden backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display:none;"
    ></div>


    <!-- ==================== MAIN CONTENT ==================== -->
    <div
        id="admin-main-content"
        :class="expanded ? 'lg:ml-[17.5rem]' : 'lg:ml-[88px]'"
        class="flex-grow flex flex-col bg-white border-0 lg:border lg:border-slate-200/50 shadow-sm
               m-0 lg:my-4 lg:mr-4
               rounded-none lg:rounded-[2rem]
               h-full lg:h-[calc(100vh-2rem)]"
    >
        <!-- Top Header -->
        <header class="flex items-center justify-between w-full px-5 py-4 bg-white/80 backdrop-blur-xl border-b border-slate-100/80 shrink-0">
            <div class="flex items-center gap-3">
                <!-- Mobile menu button -->
                <button @click="openMobile()" class="lg:hidden p-2 rounded-xl hover:bg-slate-100 text-slate-500 transition-colors">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <!-- Desktop collapse-toggle (hamburger style) -->
                <button @click="toggleExpand()" class="hidden lg:flex p-2 rounded-xl hover:bg-slate-100 text-slate-500 transition-colors">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div>
                    <h1 class="text-[15px] font-bold text-slate-800 leading-none">Admin Dashboard</h1>
                    <p class="text-[11px] text-slate-400 mt-0.5">thebasecampschool</p>
                </div>
            </div>

            <div class="flex items-center gap-1 sm:gap-2">
                <!-- Language Switcher -->
                <div x-data="{ langOpen: false }" class="relative">
                    <button @click="langOpen = !langOpen"
                        class="flex items-center gap-1 px-2 py-2 rounded-xl hover:bg-slate-100 text-slate-500 transition-colors text-sm font-semibold" type="button">
                        <span class="material-symbols-outlined text-[18px]">translate</span>
                        <span class="hidden lg:inline">{{ ['en'=>'English','hi'=>'हिन्दी','bn'=>'বাংলা','te'=>'తెలుగు','mr'=>'मराठी','ta'=>'தமிழ்','gu'=>'ગુજરાતી','kn'=>'കന്നಡ','ml'=>'മലയാളം','pa'=>'ਪੰਜਾਬੀ','ur'=>'اردو'][session('locale', 'en')] ?? 'English' }}</span>
                    </button>
                    <div x-show="langOpen" @click.outside="langOpen = false"
                        class="absolute left-0 top-full mt-2 w-44 bg-white border border-slate-200 rounded-2xl shadow-xl shadow-slate-200/50 z-[999] py-2 max-h-[50dvh] overflow-y-auto"
                        style="display:none;">
                        @foreach(['en'=>'English','hi'=>'हिन्दी','bn'=>'বাংলা','te'=>'తెలుగు','mr'=>'मराठी','ta'=>'தமிழ்','gu'=>'ગુજરાતી','kn'=>'കന്നಡ','ml'=>'മലയാളം','pa'=>'ਪੰਜਾਬੀ','ur'=>'اردو'] as $code => $native)
                        <a href="{{ route('language.switch', $code) }}"
                           class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium transition-colors
                                  {{ (session('locale', 'en') === $code) ? 'bg-cyan-50 text-cyan-700' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span class="text-base leading-none">{{ $native }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('admin.settings') }}" class="p-2 rounded-xl hover:bg-slate-100 text-slate-500 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">settings</span>
                </a>
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full signature-gradient flex items-center justify-center text-white text-sm font-bold shadow-md">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-grow overflow-y-auto p-5 md:p-8">
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>