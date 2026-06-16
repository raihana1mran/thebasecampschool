@php
    $navLinks = [
        ['name' => 'Overview', 'icon' => 'layout-dashboard', 'route' => 'admin.dashboard'],
        ['name' => 'Manage Students', 'icon' => 'users', 'route' => 'admin.students'],
        ['name' => 'Enrollments', 'icon' => 'file-check', 'route' => 'admin.admissions'],
        ['name' => 'Digital Library', 'icon' => 'folder-plus', 'route' => 'admin.products'],
        ['name' => 'Mock Tests', 'icon' => 'clipboard-edit', 'route' => 'admin.mocktests'],
        ['name' => 'Payments', 'icon' => 'credit-card', 'route' => 'admin.payments'],
        ['name' => 'Referrals', 'icon' => 'gift', 'route' => 'admin.referrals'],
        ['name' => 'Settings', 'icon' => 'settings', 'route' => 'admin.settings'],
    ];

    function getIconSvg($name) {
        $icons = [
            'layout-dashboard' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>',
            'users' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
            'file-check' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="m9 15 2 2 4-4"/></svg>',
            'folder-plus' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 10v6"/><path d="M9 13h6"/><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>',
            'clipboard-edit' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z"/></svg>',
            'credit-card' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>',
            'gift' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="14" x="3" y="8" rx="2"/><path d="M12 5a3 3 0 1 0-3 3h6a3 3 0 1 0-3-3Z"/><path d="M12 2v20"/><path d="M3 12h18"/></svg>',
            'settings' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>',
        ];
        return $icons[$name] ?? '';
    }
@endphp

<aside
    :class="isOpen ? 'translate-x-0' : '-translate-x-full lg:-translate-x-full lg:-left-20'"
    class="fixed top-4 left-4 bottom-4 h-[calc(100vh-2rem)] w-64 bg-white border border-slate-200/50 shadow-sm flex flex-col z-50 transition-all duration-300 rounded-[2.5rem]"
>
    <div class="px-8 py-4 mb-4 border-b border-outline-variant/20 flex justify-between items-center">
        <h2 class="text-xs font-bold uppercase tracking-widest text-primary flex items-center gap-3"><span class="w-6 h-[1px] bg-primary/40 block"></span> Admin Portal</h2>
        <!-- Close Button (Mobile Only) -->
        <button @click="isOpen = false" class="lg:hidden p-1 rounded-xl hover:bg-slate-100 transition-colors flex items-center justify-center">
            <span class="material-symbols-outlined text-slate-600">close</span>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto py-4 px-4 space-y-1.5 scrollbar-thin scrollbar-thumb-primary/10 scrollbar-track-transparent">
        @foreach($navLinks as $link)
            @php
                $isActive = request()->routeIs($link['route']) || ($link['route'] === '#' && false);
            @endphp
            <a href="{{ $link['route'] !== '#' ? route($link['route']) : '#' }}" class="block p-1">
                <div class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 {{ $isActive ? 'bg-surface-container-highest border border-outline-variant/30 text-primary font-bold shadow-[0_8px_16px_rgba(0,0,0,0.03)] filter-[contrast(1.05)] cursor-default scale-100' : 'bg-transparent border border-transparent hover:bg-surface-container hover:border-outline-variant/20 text-on-surface-variant hover:text-primary hover:scale-[1.02]' }}">
                    <span class="transition-colors duration-300 {{ $isActive ? 'text-primary' : 'text-on-surface-variant/60 group-hover:text-primary' }}">
                        {!! getIconSvg($link['icon']) !!}
                    </span>
                    <span class="text-[15px] tracking-wide">{{ $link['name'] }}</span>
                </div>
            </a>
        @endforeach
    </div>

    <div class="p-6 border-t border-outline-variant/20 bg-gradient-to-t from-surface-container/50 to-transparent">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center justify-center gap-3 px-4 py-3.5 w-full rounded-2xl border border-primary/20 text-primary hover:bg-primary/10 font-bold tracking-wide transition-all duration-300 hover:shadow-[0_4px_12px_rgba(0,0,0,0.05)] group">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300 group-hover:-translate-x-1"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                Exit Admin
            </button>
        </form>
    </div>
</aside>

<!-- Overlay for mobile -->
<div
    x-show="isOpen"
    @click="isOpen = false"
    class="fixed inset-0 bg-black/40 z-40 lg:hidden"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
></div>
