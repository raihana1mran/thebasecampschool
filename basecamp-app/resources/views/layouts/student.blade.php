<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover, maximum-scale=5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f0f4f8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <title>{{ config('app.name', 'thebasecampschool') }} - Student Dashboard</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Space Grotesk', sans-serif; background-color: #f0f4f8; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .signature-gradient { background: linear-gradient(135deg, #006479 0%, #40cef3 100%); }
        [x-cloak] { display: none !important; }

        * { -webkit-tap-highlight-color: transparent; }

        /* Safe area support for iPhone notch/Dynamic Island */
        .safe-top { padding-top: env(safe-area-inset-top, 0px); }
        .safe-bottom { padding-bottom: env(safe-area-inset-bottom, 0px); }
        .safe-left { padding-left: env(safe-area-inset-left, 0px); }
        .safe-right { padding-right: env(safe-area-inset-right, 0px); }

        /* Sidebar & content transitions */
        #student-sidebar { transition: width 0.35s cubic-bezier(0.4,0,0.2,1), transform 0.35s cubic-bezier(0.4,0,0.2,1); }
        #student-main  { transition: margin-left 0.35s cubic-bezier(0.4,0,0.2,1); }

        /* Tooltip shown in collapsed mode on hover */
        .nav-tooltip {
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
        .nav-tooltip::before {
            content: '';
            position: absolute;
            right: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: #1e293b;
        }
        a:hover .nav-tooltip, button:hover .nav-tooltip { opacity: 1; }

        /* Scrollbar */
        #student-sidebar::-webkit-scrollbar { width: 4px; }
        #student-sidebar::-webkit-scrollbar-track { background: transparent; }
        #student-sidebar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }

        /* Prevent horizontal overflow */
        .overflow-x-visible { overflow-x: visible; }
        img, video, iframe, svg { max-width: 100%; height: auto; }

        /* Mobile hidden by default */
        @media (max-width: 1023px) {
            #student-sidebar { transform: translateX(-110%); }
            #student-sidebar.mobile-open { transform: translateX(0); }
            #student-main { margin-left: 0 !important; }
            #sidebar-overlay.active { display: block; }
            .safe-top { padding-top: max(env(safe-area-inset-top, 0px), 8px); }
        }

        @media (max-width: 430px) {
            .container-px { padding-left: 16px; padding-right: 16px; }
            .text-responsive-xs { font-size: clamp(0.625rem, 2.5vw, 0.75rem); }
            .text-responsive-sm { font-size: clamp(0.75rem, 3vw, 0.875rem); }
            .text-responsive-base { font-size: clamp(0.875rem, 3.5vw, 1rem); }
            .text-responsive-lg { font-size: clamp(1rem, 4vw, 1.25rem); }
            .text-responsive-xl { font-size: clamp(1.25rem, 5vw, 1.5rem); }
            .text-responsive-2xl { font-size: clamp(1.5rem, 6vw, 2rem); }
            .text-responsive-3xl { font-size: clamp(1.75rem, 7vw, 2.5rem); }
        }
    </style>
</head>
<body class="font-['Space_Grotesk'] bg-[#f0f4f8] text-[#2a3031] h-screen w-screen flex overflow-hidden antialiased">

<!-- Alpine state lives on body so sidebar & main content share it -->
<div
    x-data="{
        expanded: true,
        mobileOpen: false,
        toggleExpand() {
            if (window.innerWidth < 1024) {
                this.mobileOpen = !this.mobileOpen;
                const el = document.getElementById('student-sidebar');
                el.classList.toggle('mobile-open', this.mobileOpen);
                document.getElementById('sidebar-overlay').classList.toggle('active', this.mobileOpen);
            } else {
                this.expanded = !this.expanded;
            }
        },
        closeMobile() {
            this.mobileOpen = false;
            document.getElementById('student-sidebar').classList.remove('mobile-open');
            document.getElementById('sidebar-overlay').classList.remove('active');
        }
    }"
    class="relative flex h-screen w-screen overflow-hidden"
>
    <!-- Mobile overlay -->
        <div id="sidebar-overlay"
            class="fixed inset-0 bg-black/35 backdrop-blur-sm z-40 lg:hidden hidden"
            :class="{ 'hidden': !mobileOpen }"
            @click="closeMobile()">
    </div>

    <!-- ==================== SIDEBAR ==================== -->
    <aside
        id="student-sidebar"
        :class="expanded ? 'w-[280px] sm:w-72' : 'w-[72px]'"
        class="fixed top-0 left-0 bottom-0 sm:top-4 sm:left-4 sm:bottom-4 h-full sm:h-[calc(100vh-2rem)] bg-white border-0 sm:border sm:border-slate-200/60 shadow-2xl sm:shadow-xl sm:shadow-slate-200/40 flex flex-col z-50 rounded-none sm:rounded-[2rem] overflow-hidden"
    >
        <!-- Brand -->
        <div class="flex items-center px-4 py-5 border-b border-slate-100 shrink-0"
             :class="expanded ? 'justify-between' : 'justify-center'">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-cyan-600 to-cyan-400 flex items-center justify-center text-white shadow-lg shadow-cyan-500/30 shrink-0">
                <span class="material-symbols-outlined text-[18px]">auto_awesome</span>
            </div>
            <div x-show="expanded"
                 x-transition:enter="transition ease-out duration-200 delay-50"
                 x-transition:enter-start="opacity-0 -translate-x-2"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 class="ml-3 overflow-hidden">
                <p class="text-[13px] font-black text-slate-800 leading-none whitespace-nowrap tracking-wider">THE BASE CAMP</p>
                <p class="text-[9px] text-cyan-600 font-bold tracking-[0.2em] uppercase mt-0.5">Student Portal</p>
            </div>
            <!-- Collapse button (desktop) -->
            <button
                @click="expanded = !expanded"
                x-show="expanded"
                class="hidden lg:flex ml-auto p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-700 transition-colors shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m11 17-5-5 5-5"/><path d="m18 17-5-5 5-5"/></svg>
            </button>
            <!-- Mobile close -->
            <button @click="closeMobile()" x-show="expanded" class="lg:hidden p-1.5 rounded-lg hover:bg-slate-100 text-slate-400">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        <!-- Expand icon (collapsed state) -->
        <div x-show="!expanded" class="flex justify-center pt-3 pb-1 shrink-0">
            <button @click="expanded = true" class="p-2 rounded-xl hover:bg-cyan-50 hover:text-cyan-600 text-slate-400 transition-colors" title="Expand">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m13 17 5-5-5-5"/><path d="m6 17 5-5-5-5"/></svg>
            </button>
        </div>

        <!-- Navigation Items -->
        @php
        $navItems = [
            ['label' => __('overview'),        'icon' => 'dashboard',         'url' => url('/dashboard')],
            ['label' => __('learning'),        'icon' => 'school',            'url' => url('/learning')],
            ['label' => __('mock_tests'),      'icon' => 'quiz',              'url' => url('/mocktests')],
            ['label' => __('assignments'),     'icon' => 'assignment',        'url' => url('/tma')],
            ['label' => __('resources'),       'icon' => 'folder_open',       'url' => url('/downloads'),
                'sub' => [
                    ['label' => __('all_resources'), 'url' => url('/downloads')],
                    ['label' => __('pdf_notes'),     'url' => url('/downloads?category=pdf')],
                    ['label' => __('tma_files'),     'url' => url('/downloads?category=tma')],
                ]
            ],
            ['label' => __('referrals'),      'icon' => 'group_add',         'url' => url('/referrals')],
            ['label' => __('membership'),     'icon' => 'workspace_premium', 'url' => url('/membership')],
        ];
        @endphp

        <nav class="flex-1 overflow-y-auto py-3 px-2 space-y-0.5">
            @foreach($navItems as $item)
                @php
                    $isActive = str_starts_with(request()->url(), $item['url']);
                    $hasSub = !empty($item['sub']);
                @endphp

                @if($hasSub)
                    <!-- Item with subpages -->
                    <div x-data="{ subOpen: {{ $isActive ? 'true' : 'false' }} }">
                        <button
                            @click="if($el.closest('aside').__x.$data.expanded) subOpen = !subOpen; else window.location='{{ $item['url'] }}';"
                            class="relative flex items-center w-full rounded-xl transition-all duration-200 group text-left
                                {{ $isActive ? 'bg-gradient-to-r from-cyan-600 to-cyan-500 text-white shadow-lg shadow-cyan-500/25' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}"
                            :class="expanded ? 'gap-3 px-3 py-3' : 'justify-center px-0 py-3 mx-1'"
                        >
                            <span class="material-symbols-outlined text-[20px] shrink-0 {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-cyan-600' }}"
                                  style="{{ $isActive ? 'font-variation-settings: \'FILL\' 1;' : '' }}">{{ $item['icon'] }}</span>
                            <span x-show="expanded" x-transition:enter="transition ease-out duration-150 delay-75" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                  class="text-[13px] font-semibold flex-1 whitespace-nowrap">{{ $item['label'] }}</span>
                            <span x-show="expanded" class="material-symbols-outlined text-[16px] transition-transform duration-300 shrink-0 {{ $isActive ? 'text-white/70' : 'text-slate-400' }}"
                                  :class="subOpen ? 'rotate-180' : ''">expand_more</span>
                            <span x-show="!expanded" class="nav-tooltip">{{ $item['label'] }}</span>
                        </button>
                        <!-- Sub items (only when expanded) -->
                        <div x-show="subOpen && expanded" x-collapse class="pl-11 pr-2 mt-0.5 space-y-0.5" style="display:none;">
                            @foreach($item['sub'] as $sub)
                                <a href="{{ $sub['url'] }}"
                                   class="block text-[12px] font-medium px-3 py-2 rounded-lg text-slate-500 hover:text-cyan-700 hover:bg-cyan-50 transition-all duration-150">
                                    {{ $sub['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ $item['url'] }}"
                       class="relative flex items-center rounded-xl transition-all duration-200 group
                           {{ $isActive ? 'bg-gradient-to-r from-cyan-600 to-cyan-500 text-white shadow-lg shadow-cyan-500/25' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}"
                       :class="expanded ? 'gap-3 px-3 py-3' : 'justify-center px-0 py-3 mx-1'"
                    >
                        <span class="material-symbols-outlined text-[20px] shrink-0 transition-colors {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-cyan-600' }}"
                              style="{{ $isActive ? 'font-variation-settings: \'FILL\' 1;' : '' }}">{{ $item['icon'] }}</span>
                        <span x-show="expanded" x-transition:enter="transition ease-out duration-150 delay-75" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                              class="text-[13px] font-semibold whitespace-nowrap">{{ $item['label'] }}</span>
                        @if($isActive)
                            <span x-show="!expanded" class="absolute right-1 top-1/2 -translate-y-1/2 w-1.5 h-1.5 rounded-full bg-cyan-300"></span>
                        @endif
                        <span x-show="!expanded" class="nav-tooltip">{{ $item['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </nav>

        <!-- Footer: Help + Logout -->
        <div class="p-2 border-t border-slate-100 space-y-0.5 shrink-0">
            <a href="{{ url('/contact') }}"
               class="relative flex items-center rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-800 transition-all duration-200 group"
               :class="expanded ? 'gap-3 px-3 py-3' : 'justify-center px-0 py-3 mx-1'"
            >
                <span class="material-symbols-outlined text-[20px] shrink-0 text-slate-400 group-hover:text-cyan-600 transition-colors">support_agent</span>
                <span x-show="expanded" x-transition:enter="transition ease-out duration-150 delay-75" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-[13px] font-semibold whitespace-nowrap">{{ __('help_contact') }}</span>
                <span x-show="!expanded" class="nav-tooltip">{{ __('help_contact') }}</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" id="sidebar-logout-form">@csrf
                <button type="submit"
                    class="relative flex items-center w-full rounded-xl text-slate-500 hover:bg-red-50 hover:text-red-600 transition-all duration-200 group"
                    :class="expanded ? 'gap-3 px-3 py-3' : 'justify-center px-0 py-3 mx-1'"
                >
                    <span class="material-symbols-outlined text-[20px] shrink-0 text-slate-400 group-hover:text-red-500 transition-colors">logout</span>
                    <span x-show="expanded" x-transition:enter="transition ease-out duration-150 delay-75" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                          class="text-[13px] font-semibold whitespace-nowrap">{{ __('logout') }}</span>
                    <span x-show="!expanded" class="nav-tooltip">{{ __('logout') }}</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ==================== MAIN CONTENT ==================== -->
    <div
        id="student-main"
        :class="expanded ? 'lg:ml-[19.5rem]' : 'lg:ml-[88px]'"
        class="flex-grow flex flex-col bg-white border-0 lg:border lg:border-slate-200/50 shadow-sm
               m-0 lg:my-4 lg:mr-4
               rounded-none lg:rounded-[2rem]
               overflow-hidden h-full lg:h-[calc(100vh-2rem)]"
    >
        <!-- Top Nav -->
        <header class="flex items-center justify-between w-full px-3 sm:px-5 py-3 sm:py-4 bg-white/80 backdrop-blur-xl border-b border-slate-100/80 shrink-0 safe-top">
            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                <button @click="toggleExpand()" class="p-2 rounded-xl hover:bg-slate-100 text-slate-500 transition-colors shrink-0">
                    <span class="material-symbols-outlined text-[20px] sm:text-[24px]">menu</span>
                </button>
                <div class="min-w-0">
                    <h1 class="text-[13px] sm:text-[15px] font-bold text-slate-800 leading-none truncate">{{ __('student_command_center') }}</h1>
                    <p class="text-[10px] sm:text-[11px] text-slate-400 mt-0.5 truncate">thebasecampschool</p>
                </div>
            </div>

            <div class="flex items-center gap-1 sm:gap-2 shrink-0">
                <!-- Language Switcher -->
                <div x-data="{ langOpen: false }" class="relative">
                    <button @click="langOpen = !langOpen"
                        class="flex items-center gap-1 px-1.5 sm:px-2 py-2 rounded-xl hover:bg-slate-100 text-slate-500 transition-colors text-sm font-semibold" type="button">
                        <span class="material-symbols-outlined text-[18px] sm:text-[20px]">translate</span>
                        <span class="hidden lg:inline text-xs">{{ ['en'=>'English','hi'=>'हिन्दी','bn'=>'বাংলা','te'=>'తెలుగు','mr'=>'मराठी','ta'=>'தமிழ்','gu'=>'ગુજરાતી','kn'=>'കന്നడ','ml'=>'മലയാളം','pa'=>'ਪੰਜਾਬੀ','ur'=>'اردو'][session('locale', 'en')] ?? 'English' }}</span>
                    </button>
                    <div x-show="langOpen" @click.outside="langOpen = false"
                        class="absolute right-0 top-full mt-2 w-44 bg-white border border-slate-200 rounded-2xl shadow-xl shadow-slate-200/50 z-50 py-2 max-h-64 overflow-y-auto"
                        x-cloak>
                        @foreach(['en'=>'English','hi'=>'हिन्दी','bn'=>'বাংলা','te'=>'తెలుగు','mr'=>'मराठी','ta'=>'தமிழ்','gu'=>'ગુજરાતી','kn'=>'കന്നడ','ml'=>'മലയാളം','pa'=>'ਪੰਜਾਬੀ','ur'=>'اردو'] as $code => $native)
                        <a href="{{ route('language.switch', $code) }}"
                           class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium transition-colors
                                  {{ (session('locale', 'en') === $code) ? 'bg-cyan-50 text-cyan-700' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span class="text-base leading-none">{{ $native }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center gap-1 sm:gap-2 bg-slate-50 border border-slate-100 px-1.5 sm:px-3 py-1.5 sm:py-2 rounded-full cursor-pointer group hover:bg-red-50 hover:border-red-100 transition-all min-w-0"
                     onclick="document.getElementById('sidebar-logout-form').submit()">
                    <span class="material-symbols-outlined text-[16px] sm:text-[18px] text-cyan-600 group-hover:text-red-500 transition-colors shrink-0" style="font-variation-settings: 'FILL' 1;">account_circle</span>
                    <span class="text-[10px] sm:text-[12px] font-medium text-slate-700 hidden sm:inline group-hover:text-red-600 transition-colors truncate max-w-[80px]">{{ Auth::user()->name ?? 'Student' }}</span>
                    <span class="material-symbols-outlined text-[14px] sm:text-[16px] text-slate-400 group-hover:text-red-500 transition-colors shrink-0">logout</span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-grow overflow-y-auto overflow-x-hidden px-3 sm:px-5 md:px-10 py-5 sm:py-7 relative">
            <!-- Decorative blobs -->
            <div class="fixed top-20 right-[-10%] w-[400px] h-[400px] bg-cyan-400/8 rounded-full blur-[100px] pointer-events-none -z-10"></div>
            <div class="fixed bottom-[-10%] left-[-5%] w-[350px] h-[350px] bg-blue-400/8 rounded-full blur-[80px] pointer-events-none -z-10"></div>

            @if(session('error'))
            <div class="mb-4 sm:mb-6 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-4 sm:px-6 py-3 sm:py-4 flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <span class="material-symbols-outlined text-red-500 shrink-0">warning</span>
                <div class="min-w-0 flex-1">
                    <p class="font-bold text-xs sm:text-sm">Access Restricted</p>
                    <p class="text-xs sm:text-sm">{{ session('error') }}</p>
                </div>
                <a href="{{ url('/application') }}" class="w-full sm:w-auto text-center bg-red-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-red-700 transition-colors whitespace-nowrap">Select Course</a>
            </div>
            @endif

            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="px-3 sm:px-5 py-3 border-t border-slate-100 shrink-0 flex flex-col sm:flex-row items-center justify-between gap-2 safe-bottom">
            <p class="text-[10px] sm:text-[11px] text-slate-400 text-center sm:text-left">© 2024 thebasecampschool. All Rights Reserved.</p>
            <p class="text-[9px] sm:text-[10px] text-slate-400 font-bold uppercase tracking-wider">Developed by Wolfcore Technology</p>
        </footer>
    </div>
</div>
</body>
</html>
