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
    <div class="relative overflow-hidden rounded-[2.5rem] bg-white/70 p-6 sm:p-12 mb-12 flex flex-col md:flex-row items-center gap-8 shadow-sm border border-slate-200">
        <div class="absolute top-0 right-0 w-1/2 h-full opacity-[0.03]">
            <img alt="Education Pattern" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD9zAiuqY_JkrYEDlCZcoKZZ3TL28MUk0GW2C71dlydMohBL1Xy6F04TyAiyXbcof4Ub71I4N48T732DrhK-LpbFGTwfhoq4O4l2Li2izjcbi2Cjn0u_q14KHcX_w7kky3I6-3E7ox0afVJVjDkWNwCrJVx4QIZKnh1WsCY4Fl0cG6fmPAnY3vht_m5a4B7DAp6NZCoNqDBg_BU2KVQTAoQxf0bLRaOlBlNVme9BYjfamwXtAf6veqMrakGb082-VZLtj85mb2x53s"/>
        </div>
        <div class="relative z-10 flex-1">
            <span class="bg-[#006479]/10 text-[#006479] px-4 py-1.5 rounded-full text-[10px] font-bold tracking-[0.2em] uppercase mb-6 inline-block border border-[#006479]/20 shadow-sm">Current Focus</span>
            <h2 class="text-[clamp(2rem,5vw,3rem)] font-bold tracking-tighter text-slate-800 mb-4 leading-tight">10th Grade <br/><span class="text-[#006479]">Core Curriculum</span></h2>
            <p class="text-slate-500 text-lg max-w-xl mb-8 leading-relaxed font-medium">Master the nuances of Hindi literature and grammar with our curated path to peak academic performance.</p>
            <div class="flex flex-wrap gap-4">
                <button class="signature-gradient text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-cyan-900/20 flex items-center gap-2 hover:scale-[1.02] transition-transform">
                    Resume Last Lesson <span class="material-symbols-outlined text-lg">play_arrow</span>
                </button>
                <button class="bg-white text-slate-700 border border-slate-200 shadow-sm px-8 py-4 rounded-2xl font-bold hover:bg-[#f2f7f9] transition-colors">
                    View Progress
                </button>
            </div>
        </div>
        <div class="relative z-10 w-full md:w-1/3">
            <div class="glass-card p-8 rounded-3xl space-y-6 shadow-sm">
                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Completion</p>
                        <h3 class="text-4xl font-bold text-slate-800">64%</h3>
                    </div>
                    <span class="material-symbols-outlined text-[#006479] text-5xl">trending_up</span>
                </div>
                <div class="h-2.5 w-full bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-[#006479] w-[64%] rounded-full shadow-[0_0_12px_rgba(0,100,121,0.4)]"></div>
                </div>
                <p class="text-sm font-medium text-slate-500">4 Modules remaining for the Mid-term goal.</p>
            </div>
        </div>
    </div>

    <!-- Subject Bento Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 pb-10 relative z-10">
        <!-- Hindi Card -->
        <div class="glass-card p-8 rounded-3xl hover:shadow-2xl hover:shadow-cyan-900/10 transition-all group border-t-[6px] border-t-[#006479] bg-white/40">
            <div class="flex justify-between items-start mb-6">
                <div class="h-16 w-16 rounded-2xl bg-[#006479]/5 border border-[#006479]/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[#006479] text-4xl" style="font-variation-settings: 'FILL' 1;">auto_stories</span>
                </div>
                <span class="text-slate-600 bg-white shadow-sm border border-slate-100 px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-[0.1em]">Core Subject</span>
            </div>
            <h3 class="text-2xl font-bold mb-2 text-slate-800 tracking-tight">Hindi</h3>
            <p class="text-slate-500 text-sm font-medium mb-8 leading-relaxed">Detailed study of Kshitij and Kritika series with advanced grammar analysis.</p>
            
            <div class="mb-8">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#006479]">100% Complete</span>
                </div>
                <div class="h-2 w-full bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-[#006479] w-[100%] rounded-full shadow-[0_0_8px_rgba(0,100,121,0.6)]"></div>
                </div>
            </div>
            
            <div class="space-y-3">
                <button class="w-full signature-gradient text-white py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:scale-[1.02] shadow-md shadow-cyan-900/20 transition-all text-sm">
                    Start Learning <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </button>
                <button class="w-full bg-[#f2f7f9] text-slate-700 py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-white border border-slate-200 shadow-sm transition-all text-sm">
                    <span class="material-symbols-outlined text-lg">download</span> Download Syllabus
                </button>
            </div>
        </div>

        <!-- Mathematics Card -->
        <div class="glass-card p-8 rounded-3xl hover:shadow-2xl hover:shadow-cyan-900/10 transition-all group bg-white/40 border border-slate-200 border-t-4 border-t-cyan-500">
            <div class="flex justify-between items-start mb-6">
                <div class="h-16 w-16 rounded-2xl bg-cyan-50 border border-cyan-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-cyan-600 text-4xl">functions</span>
                </div>
                <span class="text-slate-600 bg-white shadow-sm border border-slate-100 px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-[0.1em]">Logic Focus</span>
            </div>
            <h3 class="text-2xl font-bold mb-2 text-slate-800 tracking-tight">Mathematics</h3>
            <p class="text-slate-500 text-sm font-medium mb-8 leading-relaxed">Comprehensive coverage of Algebra, Geometry, and Trigonometry with practice sets.</p>
            
            <div class="mb-8">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-cyan-700">85% Complete</span>
                </div>
                <div class="h-2 w-full bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-cyan-500 w-[85%] rounded-full shadow-[0_0_8px_rgba(6,182,212,0.4)]"></div>
                </div>
            </div>
            
            <div class="space-y-3 mt-auto">
                <button class="w-full bg-cyan-600 text-white py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:scale-[1.02] shadow-md shadow-cyan-600/20 transition-all text-sm">
                    Start Learning <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </button>
                <button class="w-full bg-[#f2f7f9] text-slate-700 py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-white border border-slate-200 shadow-sm transition-all text-sm">
                    <span class="material-symbols-outlined text-lg">download</span> Download Syllabus
                </button>
            </div>
        </div>

        <!-- Science Card -->
        <div class="glass-card p-8 rounded-3xl hover:shadow-2xl hover:shadow-cyan-900/10 transition-all group bg-white/40 border border-slate-200 border-t-4 border-t-indigo-500">
            <div class="flex justify-between items-start mb-6">
                <div class="h-16 w-16 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-indigo-600 text-4xl">biotech</span>
                </div>
                <span class="text-slate-600 bg-white shadow-sm border border-slate-100 px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-[0.1em]">Inquiry Based</span>
            </div>
            <h3 class="text-2xl font-bold mb-2 text-slate-800 tracking-tight">Science & Tech</h3>
            <p class="text-slate-500 text-sm font-medium mb-8 leading-relaxed">Interactive modules for Physics, Chemistry, and Biology experiments and theory.</p>
            
            <div class="mb-8">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-indigo-700">42% Complete</span>
                </div>
                <div class="h-2 w-full bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-indigo-500 w-[42%] rounded-full shadow-[0_0_8px_rgba(99,102,241,0.4)]"></div>
                </div>
            </div>
            
            <div class="space-y-3 mt-auto">
                <button class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:scale-[1.02] shadow-md shadow-indigo-600/20 transition-all text-sm">
                    Start Learning <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </button>
                <button class="w-full bg-[#f2f7f9] text-slate-700 py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-white border border-slate-200 shadow-sm transition-all text-sm">
                    <span class="material-symbols-outlined text-lg">download</span> Download Syllabus
                </button>
            </div>
        </div>

        <!-- Social Science Card -->
        <div class="glass-card p-8 rounded-3xl hover:shadow-2xl hover:shadow-cyan-900/10 transition-all group bg-white/40 border border-slate-200 border-t-4 border-t-amber-500">
            <div class="flex justify-between items-start mb-6">
                <div class="h-16 w-16 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-amber-600 text-4xl">public</span>
                </div>
                <span class="text-slate-600 bg-white shadow-sm border border-slate-100 px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-[0.1em]">Social Context</span>
            </div>
            <h3 class="text-2xl font-bold mb-2 text-slate-800 tracking-tight">Social Science</h3>
            <p class="text-slate-500 text-sm font-medium mb-8 leading-relaxed">Exploration of History, Geography, Political Science, and Economics.</p>
            
            <div class="mb-8">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-amber-700">60% Complete</span>
                </div>
                <div class="h-2 w-full bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-amber-500 w-[60%] rounded-full shadow-[0_0_8px_rgba(245,158,11,0.4)]"></div>
                </div>
            </div>
            
            <div class="space-y-3 mt-auto">
                <button class="w-full bg-amber-500 text-white py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:scale-[1.02] shadow-md shadow-amber-500/20 transition-all text-sm">
                    Start Learning <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </button>
                <button class="w-full bg-[#f2f7f9] text-slate-700 py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-white border border-slate-200 shadow-sm transition-all text-sm">
                    <span class="material-symbols-outlined text-lg">download</span> Download Syllabus
                </button>
            </div>
        </div>

        <!-- English Card -->
        <div class="glass-card p-8 rounded-3xl hover:shadow-2xl hover:shadow-cyan-900/10 transition-all group bg-white/40 border border-slate-200 border-t-4 border-t-rose-500">
            <div class="flex justify-between items-start mb-6">
                <div class="h-16 w-16 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-rose-600 text-4xl">translate</span>
                </div>
                <span class="text-slate-600 bg-white shadow-sm border border-slate-100 px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-[0.1em]">Communication</span>
            </div>
            <h3 class="text-2xl font-bold mb-2 text-slate-800 tracking-tight">English</h3>
            <p class="text-slate-500 text-sm font-medium mb-8 leading-relaxed">Developing advanced reading, writing, and analytical skills in literature.</p>
            
            <div class="mb-8">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-rose-700">25% Complete</span>
                </div>
                <div class="h-2 w-full bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-rose-500 w-[25%] rounded-full shadow-[0_0_8px_rgba(244,63,94,0.4)]"></div>
                </div>
            </div>
            
            <div class="space-y-3 mt-auto">
                <button class="w-full bg-rose-500 text-white py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:scale-[1.02] shadow-md shadow-rose-500/20 transition-all text-sm">
                    Start Learning <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </button>
                <button class="w-full bg-[#f2f7f9] text-slate-700 py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-white border border-slate-200 shadow-sm transition-all text-sm">
                    <span class="material-symbols-outlined text-lg">download</span> Download Syllabus
                </button>
            </div>
        </div>

        <!-- Mentorship Card - Asymmetric Callout -->
        <div class="glass-card p-8 rounded-3xl bg-gradient-to-br from-indigo-50 to-white relative overflow-hidden group border border-slate-200">
            <div class="absolute -right-4 -bottom-4 opacity-10 transform group-hover:scale-[1.15] transition-transform duration-[1000ms]">
                <span class="material-symbols-outlined text-9xl text-indigo-600">groups</span>
            </div>
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-800 tracking-tight">Need help with <br/>Study Planning?</h3>
                    <p class="text-slate-500 text-sm mb-12 max-w-[200px] leading-relaxed font-medium">Connect with a senior mentor to optimize your preparation strategy and conquer exams.</p>
                </div>
                <button class="text-indigo-600 font-bold flex items-center gap-2 hover:gap-4 transition-all w-fit">
                    Book Session <span class="material-symbols-outlined">arrow_right_alt</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Recent Activity Asymmetric Layout -->
    <div class="mt-8 pb-16 relative z-10">
        <h4 class="text-3xl font-bold mb-8 text-slate-800 tracking-tight">Course Milestones</h4>
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="flex-1 glass-card p-10 rounded-[2.5rem] shadow-sm border border-slate-200 bg-white/50">
                <div class="space-y-8">
                    <div class="flex items-center gap-6">
                        <div class="h-14 w-14 rounded-full bg-cyan-50 border border-cyan-100 flex items-center justify-center text-cyan-600 shadow-sm">
                            <span class="material-symbols-outlined text-2xl">verified</span>
                        </div>
                        <div>
                            <h5 class="font-bold text-lg text-slate-800">Mathematics - Calculus Module</h5>
                            <p class="text-sm text-slate-500 font-medium">Completed with <span class="text-cyan-600 font-bold">98% Score</span> • 2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="h-14 w-14 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 shadow-sm">
                            <span class="material-symbols-outlined text-2xl">description</span>
                        </div>
                        <div>
                            <h5 class="font-bold text-lg text-slate-800">Science Lab Reports</h5>
                            <p class="text-sm text-slate-500 font-medium">Syllabus PDF Downloaded • Yesterday</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="w-full lg:w-80 glass-card p-10 rounded-[2.5rem] flex flex-col justify-between shadow-sm border border-slate-200 bg-white/50">
                <div>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-2">Study Streak</p>
                    <h3 class="text-6xl font-black tracking-tighter text-[#006479]">12 <span class="text-2xl font-bold text-slate-500 tracking-tight">Days</span></h3>
                </div>
                <div class="pt-8">
                    <p class="text-sm text-slate-500 leading-relaxed font-medium">You're in the <span class="text-[#006479] font-bold">top 5%</span> of active students this week. Keep crushing it!</p>
                </div>
            </div>
        </div>
    </div>
</x-student-layout>
