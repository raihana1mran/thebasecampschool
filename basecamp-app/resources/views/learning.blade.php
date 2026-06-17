@php
$tenthSubjects = [
    ['name' => 'Hindi', 'icon' => 'language', 'category' => 'Languages'],
    ['name' => 'Mathematics', 'icon' => 'calculate', 'category' => 'Core'],
    ['name' => 'Science and Tech', 'icon' => 'science', 'category' => 'Core'],
    ['name' => 'Psychology', 'icon' => 'psychology', 'category' => 'Humanities'],
    ['name' => 'Painting', 'icon' => 'palette', 'category' => 'Arts'],
];

$twelfthScience = ['Physics', 'Chemistry', 'Biology', 'Mathematics'];
$twelfthCommerce = ['Accountancy', 'Business Studies', 'Economics', 'Legal Studies'];
$twelfthHumanities = ['History', 'Geography', 'Political Science', 'Mass Media'];

$electives = ['English Core', 'Physical Education', 'Computer Science', 'Informatics Practices', 'Fine Arts', 'Hindustani Music', 'Entrepreneurship', 'Biotechnology', 'Home Science', 'Sociology', 'NCC', 'Foreign Languages'];

$tagCloud = ['English', 'Sanskrit', 'Social Science', 'Economics', 'Business Studies', 'Accountancy', 'Veda Adhyan', 'Bharatiya Darshan', 'Sanskrit Sahitya', 'Data Entry Operations'];
@endphp

<x-student-layout>
<style>
    .glass-panel { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(24px); border: 1px solid rgba(255, 255, 255, 0.2); }
    .glass-card { background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.15); transition: all 0.4s; }
    .glass-card:hover { background: rgba(255, 255, 255, 0.6); transform: translateY(-4px) scale(1.02); box-shadow: 0 20px 40px -10px rgba(0, 100, 121, 0.1); }
    .signature-gradient { background: linear-gradient(135deg, #006479 0%, #40cef3 100%); }
</style>

<div class="fixed top-40 -left-20 w-96 h-96 bg-[#40cef3]/10 rounded-full blur-[120px] pointer-events-none z-0"></div>
<div class="fixed bottom-20 -right-20 w-80 h-80 bg-[#80b2ff]/10 rounded-full blur-[100px] pointer-events-none z-0"></div>

<main class="flex-grow pt-5 sm:pt-8 pb-16 sm:pb-20 px-4 sm:px-6 max-w-7xl mx-auto w-full relative z-10 overflow-hidden">
    <header class="mb-12 sm:mb-20 text-center relative z-10 mt-4 sm:mt-6">
        <div class="inline-block px-3 sm:px-4 py-1 sm:py-1.5 mb-4 sm:mb-6 rounded-full glass-panel border-slate-200">
            <span class="text-[9px] sm:text-[10px] font-bold uppercase tracking-[0.2em] text-[#006479]">Academic Excellence</span>
        </div>
        <h1 class="text-[clamp(1.75rem,7vw,4.5rem)] font-bold tracking-tighter mb-4 sm:mb-6 text-slate-800">Peak Performance <br/><span class="text-transparent bg-clip-text signature-gradient">Curriculum</span></h1>
        <p class="text-slate-500 max-w-2xl mx-auto text-sm sm:text-lg leading-relaxed font-medium px-2">Navigating the ethereal archive of knowledge. A structured pathway designed for modern scholars to achieve absolute clarity in their learning journey.</p>
    </header>

    <section class="mb-16 sm:mb-24 rounded-2xl overflow-hidden glass-panel relative group shadow-sm border border-slate-200">
        <img alt="Curriculum Subjects Overview" class="w-full h-48 sm:h-[400px] object-cover opacity-90 group-hover:scale-105 transition-transform duration-[2s]" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDT8DzTNoq9CwKLMBFUZ45ZTMCrDYimknRt_EsbF5qvxk_0_y22-RZ9Mg53R8t_gQ4clIL7gZw1406yBwb1zMR9Y3xboQQl-2nTa7domtzfOwxvyCKTVH6_usPlGhyRVO8P3GCr3jXI2onz-yvzUKawPBx7A0FbnEtAVGwlfw8ead-_msW-oHjM6BvIYB2f1EkQCsPIuQlmrWiRKUWKVzRWdHo0a6AAVQOEIlLTWjggpHyQHPsqs4wdnwYqb0xg5SPzfP9Hshvltc8"/>
        <div class="absolute inset-0 bg-gradient-to-t from-white/80 via-transparent to-transparent"></div>
        <div class="absolute bottom-4 sm:bottom-8 left-3 sm:left-8 right-3 sm:right-auto">
            <div class="glass-panel p-3 sm:p-6 rounded-xl sm:rounded-2xl border border-white/40 shadow-lg">
                <h3 class="text-base sm:text-xl font-bold mb-0.5 sm:mb-1 text-slate-800">Interactive Syllabus</h3>
                <p class="text-[11px] sm:text-sm text-slate-600 font-medium">Explore the comprehensive list of available academic streams.</p>
            </div>
        </div>
    </section>

    <!-- Secondary Level -->
    <section class="mb-20 sm:mb-32 relative">
        <div class="flex items-center justify-between mb-8 sm:mb-12 flex-wrap gap-3 sm:gap-4">
            <div>
                <h2 class="text-[clamp(1.5rem,6vw,2.5rem)] sm:text-4xl font-bold tracking-tight mb-1 sm:mb-2 text-slate-800">Secondary Level</h2>
                <p class="text-[#006479] font-bold tracking-[0.2em] text-[10px] sm:text-xs">CLASS 10TH • ACADEMIC FOUNDATION</p>
            </div>
            <div class="w-16 sm:w-24 h-1 bg-cyan-200 rounded-full hidden sm:block"></div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($tenthSubjects as $subject)
            <div class="glass-card p-4 sm:p-6 rounded-xl sm:rounded-2xl flex flex-col justify-between group shadow-sm bg-white/60">
                <div class="mb-3 sm:mb-4">
                    <span class="material-symbols-outlined text-[#006479] mb-3 sm:mb-4 p-2 sm:p-3 bg-cyan-50 rounded-xl shadow-sm border border-cyan-100 text-lg sm:text-2xl">{{ $subject['icon'] }}</span>
                    <h4 class="font-bold text-base sm:text-lg text-slate-800 tracking-tight">{{ $subject['name'] }}</h4>
                </div>
                <span class="text-[9px] sm:text-[10px] uppercase tracking-[0.15em] text-slate-400 font-bold mb-3 sm:mb-4">Category: {{ $subject['category'] }}</span>
                <div class="space-y-2 mt-auto">
                    <a href="{{ url('/subpage/10th-class') }}" class="flex items-center justify-center gap-2 w-full py-3 sm:py-3 signature-gradient rounded-xl transition-all hover:scale-[1.02] shadow-md shadow-cyan-900/20 active:scale-95 min-h-[44px]">
                        <span class="material-symbols-outlined text-white text-base sm:text-lg">play_circle</span>
                        <span class="text-[9px] sm:text-[10px] font-bold text-white uppercase tracking-wider">Start Learning</span>
                    </a>
                    <button class="flex items-center justify-center gap-2 w-full py-3 sm:py-3 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition-all group/btn shadow-sm min-h-[44px]">
                        <span class="material-symbols-outlined text-slate-400 text-base sm:text-lg group-hover/btn:text-[#006479]">download</span>
                        <span class="text-[9px] sm:text-[10px] font-bold text-slate-500 uppercase tracking-wider group-hover/btn:text-[#006479]">Syllabus</span>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Bento Card -->
        <div class="mt-4 sm:mt-6 glass-panel p-5 sm:p-8 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-end relative overflow-hidden bg-white/60">
            <div class="absolute top-0 right-0 p-4 sm:p-8 transform rotate-12">
                <span class="material-symbols-outlined text-[#40cef3] text-5xl sm:text-8xl opacity-[0.08]">auto_awesome</span>
            </div>
            <h3 class="text-xl sm:text-3xl font-bold mb-3 sm:mb-4 text-slate-800 tracking-tight">Indian Culture & Heritage</h3>
            <p class="text-slate-500 mb-6 sm:mb-8 leading-relaxed font-medium text-sm sm:text-base">Delve into the rich tapestry of Indian civilization and its profound impact on global thought leadership.</p>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <a href="{{ url('/subpage/10th-class') }}" class="w-full sm:w-auto text-center signature-gradient text-white px-6 sm:px-8 py-3 sm:py-3.5 rounded-xl sm:rounded-2xl font-bold shadow-lg shadow-cyan-900/20 hover:scale-105 transition-transform text-xs sm:text-sm min-h-[44px] flex items-center justify-center">Start Learning</a>
                <button class="w-full sm:w-auto text-center px-6 sm:px-8 py-3 sm:py-3.5 rounded-xl sm:rounded-2xl font-bold border border-slate-200 bg-white text-slate-600 text-xs sm:text-sm hover:bg-slate-50 shadow-sm transition-all min-h-[44px]">Syllabus</button>
            </div>
        </div>

        <!-- Tag Cloud -->
        <div class="mt-6 sm:mt-10">
            <div class="flex flex-wrap gap-2 sm:gap-3">
                @foreach($tagCloud as $tag)
                <span class="px-3 sm:px-4 py-1.5 sm:py-2 bg-white/90 rounded-full text-[10px] sm:text-xs font-bold text-slate-600 border border-slate-200 shadow-sm hover:border-[#006479] hover:text-[#006479] transition-colors cursor-pointer select-none">{{ $tag }}</span>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Senior Secondary Level -->
    <section class="mb-20 sm:mb-32">
        <div class="flex items-center justify-between mb-8 sm:mb-12 flex-wrap gap-3 sm:gap-4">
            <div>
                <h2 class="text-[clamp(1.5rem,6vw,2.5rem)] sm:text-4xl font-bold tracking-tight mb-1 sm:mb-2 text-slate-800">Senior Secondary</h2>
                <p class="text-indigo-600 font-bold tracking-[0.2em] text-[10px] sm:text-xs">CLASS 12TH • ADVANCED SPECIALIZATION</p>
            </div>
            <div class="w-16 sm:w-24 h-1 bg-indigo-200 rounded-full hidden sm:block"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-8">
            <!-- Science Stream -->
            <div class="glass-panel p-5 sm:p-8 rounded-2xl sm:rounded-3xl border border-slate-200 bg-white/60 shadow-sm flex flex-col space-y-4 sm:space-y-6 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 sm:gap-4 mb-1 sm:mb-2 border-b border-slate-100 pb-4 sm:pb-6">
                    <div class="p-2 sm:p-3 bg-cyan-50 rounded-xl sm:rounded-2xl border border-cyan-100">
                        <span class="material-symbols-outlined text-[#006479] text-2xl sm:text-3xl">biotech</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Science Stream</h3>
                </div>
                <ul class="space-y-2 sm:space-y-3">
                    @foreach($twelfthScience as $sub)
                    <li class="flex items-center gap-2 sm:gap-3 p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl hover:bg-white border border-transparent hover:border-slate-200 hover:shadow-sm transition-all group">
                        <span class="w-1.5 sm:w-2 h-1.5 sm:h-2 rounded-full bg-[#006479] shadow-sm shrink-0 transform group-hover:scale-125 transition-transform duration-300"></span>
                        <span class="font-bold text-xs sm:text-sm text-slate-700 flex-1 truncate min-w-0">{{ $sub }}</span>
                        <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                            <a href="{{ url('/subpage/12th-class') }}" class="px-2.5 sm:px-3.5 py-2 sm:py-2.5 signature-gradient rounded-xl text-[9px] sm:text-[10px] font-bold text-white uppercase tracking-wider shadow-md shadow-cyan-900/10 hover:shadow-lg hover:scale-[1.02] transition-all min-h-[44px] flex items-center whitespace-nowrap">Start</a>
                            <button class="p-2 sm:p-2.5 rounded-xl border border-slate-200 bg-white text-slate-400 hover:text-[#006479] hover:bg-cyan-50 shadow-sm transition-colors min-h-[44px] min-w-[44px] flex items-center justify-center"><span class="material-symbols-outlined text-sm">download</span></button>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Commerce Stream -->
            <div class="glass-panel p-5 sm:p-8 rounded-2xl sm:rounded-3xl border border-slate-200 bg-white/60 shadow-sm flex flex-col space-y-4 sm:space-y-6 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 sm:gap-4 mb-1 sm:mb-2 border-b border-slate-100 pb-4 sm:pb-6">
                    <div class="p-2 sm:p-3 bg-amber-50 rounded-xl sm:rounded-2xl border border-amber-100">
                        <span class="material-symbols-outlined text-amber-600 text-2xl sm:text-3xl">balance</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Commerce & Law</h3>
                </div>
                <ul class="space-y-2 sm:space-y-3">
                    @foreach($twelfthCommerce as $sub)
                    <li class="flex items-center gap-2 sm:gap-3 p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl hover:bg-white border border-transparent hover:border-slate-200 hover:shadow-sm transition-all group">
                        <span class="w-1.5 sm:w-2 h-1.5 sm:h-2 rounded-full bg-amber-500 shadow-sm shrink-0 transform group-hover:scale-125 transition-transform duration-300"></span>
                        <span class="font-bold text-xs sm:text-sm text-slate-700 flex-1 truncate min-w-0">{{ $sub }}</span>
                        <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                            <a href="{{ url('/subpage/12th-class') }}" class="px-2.5 sm:px-3.5 py-2 sm:py-2.5 bg-gradient-to-br from-amber-500 to-orange-400 rounded-xl text-[9px] sm:text-[10px] font-bold text-white uppercase tracking-wider shadow-md shadow-amber-500/20 hover:shadow-lg hover:scale-[1.02] transition-all min-h-[44px] flex items-center whitespace-nowrap">Start</a>
                            <button class="p-2 sm:p-2.5 rounded-xl border border-slate-200 bg-white text-slate-400 hover:text-amber-600 hover:bg-amber-50 shadow-sm transition-colors min-h-[44px] min-w-[44px] flex items-center justify-center"><span class="material-symbols-outlined text-sm">download</span></button>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Humanities Stream -->
            <div class="glass-panel p-5 sm:p-8 rounded-2xl sm:rounded-3xl border border-slate-200 bg-white/60 shadow-sm flex flex-col space-y-4 sm:space-y-6 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 sm:gap-4 mb-1 sm:mb-2 border-b border-slate-100 pb-4 sm:pb-6">
                    <div class="p-2 sm:p-3 bg-rose-50 rounded-xl sm:rounded-2xl border border-rose-100">
                        <span class="material-symbols-outlined text-rose-600 text-2xl sm:text-3xl">theater_comedy</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Humanities</h3>
                </div>
                <ul class="space-y-2 sm:space-y-3">
                    @foreach($twelfthHumanities as $sub)
                    <li class="flex items-center gap-2 sm:gap-3 p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl hover:bg-white border border-transparent hover:border-slate-200 hover:shadow-sm transition-all group">
                        <span class="w-1.5 sm:w-2 h-1.5 sm:h-2 rounded-full bg-rose-500 shadow-sm shrink-0 transform group-hover:scale-125 transition-transform duration-300"></span>
                        <span class="font-bold text-xs sm:text-sm text-slate-700 flex-1 truncate min-w-0">{{ $sub }}</span>
                        <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                            <a href="{{ url('/subpage/12th-class') }}" class="px-2.5 sm:px-3.5 py-2 sm:py-2.5 bg-gradient-to-br from-rose-500 to-pink-500 rounded-xl text-[9px] sm:text-[10px] font-bold text-white uppercase tracking-wider shadow-md shadow-rose-500/20 hover:shadow-lg hover:scale-[1.02] transition-all min-h-[44px] flex items-center whitespace-nowrap">Start</a>
                            <button class="p-2 sm:p-2.5 rounded-xl border border-slate-200 bg-white text-slate-400 hover:text-rose-600 hover:bg-rose-50 shadow-sm transition-colors min-h-[44px] min-w-[44px] flex items-center justify-center"><span class="material-symbols-outlined text-sm">download</span></button>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Electives Box -->
        <div class="mt-8 sm:mt-12 glass-panel p-5 sm:p-10 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm bg-white/60">
            <h3 class="text-base sm:text-xl font-bold text-slate-800 mb-6 sm:mb-8 flex items-center gap-2 sm:gap-3 tracking-tight">
                <div class="p-1.5 sm:p-2 bg-indigo-50 rounded-xl border border-indigo-100 shrink-0">
                     <span class="material-symbols-outlined text-indigo-600 text-lg sm:text-2xl">translate</span>
                </div>
                <span>Global Languages & Specialized Studies</span>
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-5">
                @foreach($electives as $elective)
                <div class="p-3 sm:p-5 rounded-xl sm:rounded-2xl bg-white border border-slate-100 shadow-sm text-center hover:shadow-md hover:border-cyan-200 transition-all flex flex-col items-center gap-2 sm:gap-4 group cursor-pointer">
                    <span class="font-bold text-[9px] sm:text-[10px] md:text-xs text-slate-700 group-hover:text-[#006479] transition-colors leading-tight truncate w-full max-w-full">{{ $elective }}</span>
                    <div class="flex gap-1 sm:gap-2 w-full mt-auto opacity-80 group-hover:opacity-100 transition-opacity">
                        <a href="{{ url('/subpage/12th-class') }}" class="flex-1 py-2 signature-gradient rounded-xl text-[7px] sm:text-[8px] md:text-[9px] font-bold text-white uppercase tracking-tighter hover:scale-[1.04] transition-transform min-h-[44px] flex items-center justify-center px-0.5">Start</a>
                        <button class="p-1.5 sm:p-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-400 hover:text-[#006479] hover:bg-cyan-50 transition-colors min-h-[44px] min-w-[44px] flex items-center justify-center"><span class="material-symbols-outlined text-[11px] sm:text-xs">download</span></button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="mt-12 sm:mt-20 relative rounded-2xl sm:rounded-3xl overflow-hidden glass-panel p-6 sm:p-16 text-center border border-slate-200 shadow-lg group bg-white/80">
        <div class="absolute inset-0 signature-gradient opacity-[0.03] group-hover:opacity-[0.08] transition-opacity duration-700"></div>
        <h2 class="text-[clamp(1.5rem,6vw,2.5rem)] sm:text-4xl font-black mb-4 sm:mb-6 text-slate-800 tracking-tight">Ready to begin your journey?</h2>
        <p class="text-slate-500 max-w-xl mx-auto mb-6 sm:mb-10 text-sm sm:text-lg font-medium">Join thousands of students achieving peak performance through our curated curriculum pathways.</p>
        <div class="flex flex-col sm:flex-row justify-center items-center gap-3 sm:gap-4 relative z-10">
            <button class="w-full sm:w-auto signature-gradient text-white px-8 sm:px-10 py-3 sm:py-4 rounded-xl sm:rounded-2xl font-bold shadow-xl shadow-cyan-900/20 hover:scale-105 transition-transform text-sm min-h-[44px]">Enroll Now</button>
            <button class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 rounded-xl sm:rounded-2xl font-bold bg-white text-slate-600 shadow-sm border border-slate-100 hover:bg-slate-50 hover:-translate-y-1 transition-all text-sm flex items-center justify-center gap-2 min-h-[44px]">
                <span class="material-symbols-outlined text-lg">download</span> Master Syllabus
            </button>
        </div>
    </section>
</main>
</x-student-layout>
