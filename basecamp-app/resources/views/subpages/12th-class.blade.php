<x-student-layout>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .signature-gradient {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
        }
    </style>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-[2.5rem] bg-white/70 p-4 sm:p-12 mb-12 flex flex-col md:flex-row items-center gap-4 sm:gap-8 shadow-sm border border-slate-200">
        <div class="absolute top-0 right-0 w-1/2 h-full opacity-[0.03]">
            <img alt="Education Pattern" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD9zAiuqY_JkrYEDlCZcoKZZ3TL28MUk0GW2C71dlydMohBL1Xy6F04TyAiyXbcof4Ub71I4N48T732DrhK-LpbFGTwfhoq4O4l2Li2izjcbi2Cjn0u_q14KHcX_w7kky3I6-3E7ox0afVJVjDkWNwCrJVx4QIZKnh1WsCY4Fl0cG6fmPAnY3vht_m5a4B7DAp6NZCoNqDBg_BU2KVQTAoQxf0bLRaOlBlNVme9BYjfamwXtAf6veqMrakGb082-VZLtj85mb2x53s"/>
        </div>
        <div class="relative z-10 flex-1">
            <span class="bg-[#006479]/10 text-[#006479] px-4 py-1.5 rounded-full text-[10px] font-bold tracking-[0.2em] uppercase mb-6 inline-block border border-[#006479]/20 shadow-sm">Target 2024</span>
            <h2 class="text-[clamp(2rem,5vw,3rem)] font-bold tracking-tighter text-slate-800 mb-4 leading-tight">12th Grade <br/><span class="text-[#006479]">Medical Core</span></h2>
            <p class="text-slate-500 text-lg max-w-xl mb-8 leading-relaxed font-medium">Master the advanced sciences with our curated path designed exclusively for premium academic performance.</p>
            <div class="flex flex-wrap gap-4">
                <button class="w-full sm:w-auto min-h-[44px] signature-gradient text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-cyan-900/20 flex items-center gap-2 hover:scale-[1.02] transition-transform">
                    Resume Biology <span class="material-symbols-outlined text-lg">play_arrow</span>
                </button>
                <button class="w-full sm:w-auto min-h-[44px] bg-white text-slate-700 border border-slate-200 shadow-sm px-8 py-4 rounded-2xl font-bold hover:bg-[#f2f7f9] transition-colors">
                    View Progress
                </button>
            </div>
        </div>
        <div class="relative z-10 w-full md:w-1/3">
            <div class="glass-card p-4 sm:p-8 rounded-3xl space-y-6 shadow-sm">
                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Board Prep</p>
                        <h3 class="text-[clamp(1.5rem,6vw,2rem)] sm:text-4xl font-bold text-slate-800">41%</h3>
                    </div>
                    <span class="material-symbols-outlined text-[#006479] text-5xl">trending_up</span>
                </div>
                <div class="h-2.5 w-full bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-[#006479] w-[41%] rounded-full shadow-[0_0_12px_rgba(0,100,121,0.4)]"></div>
                </div>
                <p class="text-sm font-medium text-slate-500">Intensive modules triggered ahead of Mid-terms.</p>
            </div>
        </div>
    </div>

    <!-- Subject Bento Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-8 pb-10 relative z-10">
        <!-- Biology Card -->
        <div class="glass-card p-4 sm:p-8 rounded-3xl hover:shadow-2xl hover:shadow-cyan-900/10 transition-all group border-t-[6px] border-t-[#006479] bg-white/40">
            <div class="flex justify-between items-start mb-6">
                <div class="h-12 w-12 sm:h-16 sm:w-16 rounded-2xl bg-[#006479]/5 border border-[#006479]/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[#006479] text-2xl sm:text-4xl" style="font-variation-settings: 'FILL' 1;">biotech</span>
                </div>
                <span class="text-slate-600 bg-white shadow-sm border border-slate-100 px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-[0.1em]">Target Subject</span>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold mb-2 text-slate-800 tracking-tight">Biology</h3>
            <p class="text-slate-500 text-sm font-medium mb-8 leading-relaxed">Comprehensive study of Human Physiology, Genetics, and Evolutionary theory.</p>
            
            <div class="mb-8">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#006479]">52% Complete</span>
                </div>
                <div class="h-2 w-full bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-[#006479] w-[52%] rounded-full shadow-[0_0_8px_rgba(0,100,121,0.6)]"></div>
                </div>
            </div>
            
            <div class="space-y-3">
                <a href="{{ route('subpage', '12th-biology') }}" class="w-full sm:w-auto min-h-[44px] signature-gradient text-white py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:scale-[1.02] shadow-md shadow-cyan-900/20 transition-all text-sm">
                    Start Learning <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- Physics Card -->
        <div class="glass-card p-4 sm:p-8 rounded-3xl hover:shadow-2xl hover:shadow-cyan-900/10 transition-all group bg-white/40 border border-slate-200 border-t-4 border-t-cyan-500">
            <div class="flex justify-between items-start mb-6">
                <div class="h-12 w-12 sm:h-16 sm:w-16 rounded-2xl bg-cyan-50 border border-cyan-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-cyan-600 text-2xl sm:text-4xl">electric_bolt</span>
                </div>
                <span class="text-slate-600 bg-white shadow-sm border border-slate-100 px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-[0.1em]">Core Science</span>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold mb-2 text-slate-800 tracking-tight">Physics</h3>
            <p class="text-slate-500 text-sm font-medium mb-8 leading-relaxed">Advanced mechanics, electromagnetism, and modern physics tailored for accuracy.</p>
            
            <div class="mb-8">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-cyan-700">35% Complete</span>
                </div>
                <div class="h-2 w-full bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-cyan-500 w-[35%] rounded-full shadow-[0_0_8px_rgba(6,182,212,0.4)]"></div>
                </div>
            </div>
            
            <div class="space-y-3 mt-auto">
                <a href="{{ route('subpage', '12th-biology') }}" class="w-full sm:w-auto min-h-[44px] bg-cyan-600 text-white py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:scale-[1.02] shadow-md shadow-cyan-600/20 transition-all text-sm">
                    Start Learning <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- Chemistry Card -->
        <div class="glass-card p-4 sm:p-8 rounded-3xl hover:shadow-2xl hover:shadow-cyan-900/10 transition-all group bg-white/40 border border-slate-200 border-t-4 border-t-indigo-500">
            <div class="flex justify-between items-start mb-6">
                <div class="h-12 w-12 sm:h-16 sm:w-16 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-indigo-600 text-2xl sm:text-4xl">science</span>
                </div>
                <span class="text-slate-600 bg-white shadow-sm border border-slate-100 px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-[0.1em]">Reaction Engine</span>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold mb-2 text-slate-800 tracking-tight">Chemistry</h3>
            <p class="text-slate-500 text-sm font-medium mb-8 leading-relaxed">Deep dive into Organic reaction mechanisms, Inorganic properties, and Physical chemistry bounds.</p>
            
            <div class="mb-8">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-indigo-700">48% Complete</span>
                </div>
                <div class="h-2 w-full bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-indigo-500 w-[48%] rounded-full shadow-[0_0_8px_rgba(99,102,241,0.4)]"></div>
                </div>
            </div>
            
            <div class="space-y-3 mt-auto">
                <a href="{{ route('subpage', '12th-biology') }}" class="w-full sm:w-auto min-h-[44px] bg-indigo-600 text-white py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:scale-[1.02] shadow-md shadow-indigo-600/20 transition-all text-sm">
                    Start Learning <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- English Core Card -->
        <div class="glass-card p-4 sm:p-8 rounded-3xl hover:shadow-2xl hover:shadow-cyan-900/10 transition-all group bg-white/40 border border-slate-200 border-t-4 border-t-amber-500">
            <div class="flex justify-between items-start mb-6">
                <div class="h-12 w-12 sm:h-16 sm:w-16 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-amber-600 text-2xl sm:text-4xl">local_library</span>
                </div>
                <span class="text-slate-600 bg-white shadow-sm border border-slate-100 px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-[0.1em]">Communication</span>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold mb-2 text-slate-800 tracking-tight">English Core</h3>
            <p class="text-slate-500 text-sm font-medium mb-8 leading-relaxed">Senior literature studies focusing on comprehension, advanced writing, and critical analysis.</p>
            
            <div class="mb-8">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-amber-700">70% Complete</span>
                </div>
                <div class="h-2 w-full bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-amber-500 w-[70%] rounded-full shadow-[0_0_8px_rgba(245,158,11,0.4)]"></div>
                </div>
            </div>
            
            <div class="space-y-3 mt-auto">
                <a href="{{ route('subpage', '12th-biology') }}" class="w-full sm:w-auto min-h-[44px] bg-amber-500 text-white py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:scale-[1.02] shadow-md shadow-amber-500/20 transition-all text-sm">
                    Start Learning <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- Mock Tests Link Card -->
        <div class="glass-card p-4 sm:p-8 rounded-3xl hover:shadow-2xl hover:shadow-cyan-900/10 transition-all group bg-white/40 border border-slate-200 border-t-4 border-t-rose-500">
            <div class="flex justify-between items-start mb-6">
                <div class="h-12 w-12 sm:h-16 sm:w-16 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-rose-600 text-2xl sm:text-4xl">quiz</span>
                </div>
                <span class="text-slate-600 bg-white shadow-sm border border-slate-100 px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-[0.1em]">Simulations</span>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold mb-2 text-slate-800 tracking-tight">Test Series</h3>
            <p class="text-slate-500 text-sm font-medium mb-8 leading-relaxed">Rigorous high-yield mock tests and previous year question paper break-downs.</p>
            
            <div class="mb-8">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-rose-700">12 Tests Taken</span>
                </div>
                <div class="h-2 w-full bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-rose-500 w-[100%] rounded-full shadow-[0_0_8px_rgba(244,63,94,0.4)]"></div>
                </div>
            </div>
            
            <div class="space-y-3 mt-auto">
                <button class="w-full sm:w-auto min-h-[44px] bg-[#111827] text-white py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:scale-[1.02] shadow-md shadow-slate-900/40 transition-all text-sm">
                    Enter Exam Hall <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </button>
            </div>
        </div>

        <!-- Mentorship Card - Asymmetric Callout -->
        <div class="glass-card p-4 sm:p-8 rounded-3xl bg-gradient-to-br from-indigo-50 to-white relative overflow-hidden group border border-slate-200">
            <div class="absolute -right-4 -bottom-4 opacity-10 transform group-hover:scale-[1.15] transition-transform duration-[1000ms]">
                <span class="material-symbols-outlined text-9xl text-indigo-600">psychiatry</span>
            </div>
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <h3 class="text-xl sm:text-2xl font-bold mb-4 text-slate-800 tracking-tight">Need Medical <br/>Mentorship?</h3>
                    <p class="text-slate-500 text-sm mb-12 max-w-[200px] leading-relaxed font-medium">Connect with a senior doctor or topper to optimize your preparation strategy and conquer competitive exams.</p>
                </div>
                <button class="min-h-[44px] text-indigo-600 font-bold flex items-center gap-2 hover:gap-4 transition-all w-fit">
                    Book Session <span class="material-symbols-outlined">arrow_right_alt</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Recent Activity Asymmetric Layout -->
    <div class="mt-8 pb-16 relative z-10">
        <h4 class="text-[clamp(1.5rem,6vw,2rem)] sm:text-3xl font-bold mb-8 text-slate-800 tracking-tight">Latest Milestones</h4>
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="flex-1 glass-card p-4 sm:p-10 rounded-[2.5rem] shadow-sm border border-slate-200 bg-white/50">
                <div class="space-y-8">
                    <div class="flex items-center gap-6">
                        <div class="h-10 w-10 sm:h-14 sm:w-14 rounded-full bg-cyan-50 border border-cyan-100 flex items-center justify-center text-cyan-600 shadow-sm">
                            <span class="material-symbols-outlined text-2xl">verified</span>
                        </div>
                        <div>
                            <h5 class="font-bold text-lg text-slate-800">Biology - Human Physiology</h5>
                            <p class="text-sm text-slate-500 font-medium">Completed with <span class="text-cyan-600 font-bold">100% Score</span> • 3 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="h-10 w-10 sm:h-14 sm:w-14 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 shadow-sm">
                            <span class="material-symbols-outlined text-2xl">science</span>
                        </div>
                        <div>
                            <h5 class="font-bold text-lg text-slate-800">Organic Chemistry Notes</h5>
                            <p class="text-sm text-slate-500 font-medium">Synced from Digital Locker • Yesterday</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="w-full lg:w-80 glass-card p-4 sm:p-10 rounded-[2.5rem] flex flex-col justify-between shadow-sm border border-slate-200 bg-white/50">
                <div>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-2">Study Streak</p>
                    <h3 class="text-[clamp(2.5rem,10vw,4rem)] sm:text-6xl font-black tracking-tighter text-[#006479]">38 <span class="text-2xl font-bold text-slate-500 tracking-tight">Days</span></h3>
                </div>
                <div class="pt-8">
                    <p class="text-sm text-slate-500 leading-relaxed font-medium">You're in the <span class="text-[#006479] font-bold">top 1%</span> of aspiring doctors. Push forward!</p>
                </div>
            </div>
        </div>
    </div>
</x-student-layout>
