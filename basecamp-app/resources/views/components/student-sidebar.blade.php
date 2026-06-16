@php
use App\Models\Admission;

$hasAdmission = false;
if (Auth::check()) {
    $hasAdmission = Admission::where('user_id', Auth::id())->exists();
}

$navItems = [
    [
        'label' => 'Overview',
        'icon' => 'dashboard',
        'url' => url('/dashboard'),
        'subpages' => []
    ],
    [
        'label' => 'Learning',
        'icon' => 'school',
        'url' => url('/learning'),
        'subpages' => []
    ],
    [
        'label' => 'Mock Tests',
        'icon' => 'quiz',
        'url' => url('/mocktests'),
        'subpages' => []
    ],
    [
        'label' => 'Assignments (TMA)',
        'icon' => 'assignment',
        'url' => url('/tma'),
        'subpages' => []
    ],
    [
        'label' => 'Resources',
        'icon' => 'folder',
        'url' => url('/downloads'),
        'subpages' => [
            ['label' => 'All Resources', 'url' => url('/downloads')],
            ['label' => 'PDF Notes', 'url' => url('/downloads?category=pdf')],
            ['label' => 'TMA', 'url' => url('/downloads?category=tma')],
        ]
    ],
    [
        'label' => 'Referrals',
        'icon' => 'group_add',
        'url' => url('/referrals'),
        'subpages' => []
    ],
    [
        'label' => 'Membership',
        'icon' => 'workspace_premium',
        'url' => url('/membership'),
        'subpages' => []
    ]
];
@endphp

<!-- Sidebar Navigation Shell -->
<aside class="h-full w-full bg-gradient-to-b from-white to-slate-50 border border-slate-200/50 shadow-[10px_0_40px_-15px_rgba(0,0,0,0.05)] flex flex-col p-6 gap-6 overflow-y-auto rounded-[2.5rem]">
    <div class="flex items-center justify-between mb-4 shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-600 to-cyan-400 flex items-center justify-center text-white shadow-lg shadow-cyan-500/25">
                <span class="material-symbols-outlined">auto_awesome</span>
            </div>
            <div>
                <h1 class="text-lg font-black text-slate-800 leading-none">The Base Camp</h1>
                <p class="text-[10px] text-cyan-600 font-bold tracking-widest uppercase mt-1">Student Portal</p>
            </div>
        </div>
        <!-- Close Button (Mobile Only) -->
        <button class="md:hidden p-2 rounded-xl hover:bg-slate-100 transition-colors flex items-center justify-center" onclick="closeSidebar()">
            <span class="material-symbols-outlined text-slate-600">close</span>
        </button>
    </div>
    
    <nav class="flex-1 flex flex-col gap-2 shrink-0 pb-10">
        @foreach($navItems as $item)
            @php
                $isActive = request()->url() === $item['url'];
                $hasSub = count($item['subpages']) > 0;
            @endphp
            <div x-data="{ expanded: {{ $isActive ? 'true' : 'false' }} }" class="flex flex-col gap-1">
                <div class="flex justify-between items-center px-4 py-3 rounded-xl transition-all duration-300 {{ $isActive ? 'bg-gradient-to-r from-cyan-600 to-cyan-500 text-white shadow-lg shadow-cyan-500/25 font-bold' : 'text-slate-600 hover:bg-gradient-to-r hover:from-cyan-600 hover:to-cyan-500 hover:text-white hover:shadow-lg hover:shadow-cyan-500/20' }}">
                   
                    <a href="{{ $item['url'] }}" class="flex items-center gap-4 flex-1 hover:translate-x-1 transition-transform">
                       <span class="material-symbols-outlined">{{ $item['icon'] }}</span>
                       <span class="text-sm tracking-wide">{{ $item['label'] }}</span>
                    </a>
                    
                    @if($hasSub)
                        <button @click.prevent="expanded = !expanded" class="p-1 rounded-md hover:bg-white/50 transition-colors flex items-center justify-center -mr-2">
                            <span class="material-symbols-outlined text-sm transition-transform duration-300" :class="expanded ? 'rotate-180' : ''">expand_more</span>
                        </button>
                    @endif
                </div>

                @if($hasSub)
                <div x-show="expanded" x-collapse style="display: none;" class="flex flex-col gap-1 pl-8 pr-4 py-2 bg-gradient-to-r from-slate-50 to-slate-100/50 rounded-lg ml-2">
                    @foreach($item['subpages'] as $sub)
                        <a href="{{ $sub['url'] }}" class="text-sm font-medium text-slate-600 hover:text-white hover:translate-x-1 hover:bg-gradient-to-r hover:from-cyan-600 hover:to-cyan-500 px-3 py-2 rounded-lg transition-all duration-300 shadow-sm hover:shadow-cyan-500/10">
                            {{ $sub['label'] }}
                        </a>
                    @endforeach
                </div>
                @endif
            </div>
        @endforeach
    </nav>

    <div class="mt-auto flex flex-col gap-2 pt-4 border-t border-slate-200 shrink-0">
        <a class="flex items-center gap-4 px-4 py-3 text-slate-600 hover:bg-gradient-to-r hover:from-cyan-600 hover:to-cyan-500 hover:text-white hover:shadow-lg hover:shadow-cyan-500/20 rounded-xl transition-all" href="{{ url('/contact') }}">
            <span class="material-symbols-outlined">support_agent</span>
            <span class="text-sm">Help & Contact</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" id="sidebar-logout">
            @csrf
            <a href="#" class="flex items-center gap-4 px-4 py-3 text-slate-600 hover:bg-gradient-to-r hover:from-red-600 hover:to-orange-500 hover:text-white hover:shadow-lg hover:shadow-red-500/25 rounded-xl transition-all group" onclick="event.preventDefault(); document.getElementById('sidebar-logout').submit();">
                <span class="material-symbols-outlined text-red-500 group-hover:text-white transition-colors">logout</span>
                <span class="text-sm font-bold text-red-500 group-hover:text-white transition-colors">Logout</span>
            </a>
        </form>
    </div>
</aside>
