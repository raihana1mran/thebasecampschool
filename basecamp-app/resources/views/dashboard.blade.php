<x-student-layout>
    @php
        $admission = \App\Models\Admission::where('user_id', Auth::id())->first();
        $courseBadge = $admission ? strtoupper($admission->course_type) : 'MEDICAL ASPIRANT';
        
        // Determine Block based on admission application submission date or current date if none
        $isBlock1 = false;
        $examLabel = 'October 2026 Public Exams';
        $examDate = \Carbon\Carbon::parse('2026-10-01 09:00:00');
        
        $refDate = $admission ? $admission->created_at : \Carbon\Carbon::now();
        $month = $refDate->month;
        
        // Block 1: Admission generally from March to September (months 3 to 9)
        // Block 2: Admission generally from September to March (months 10 to 12, and 1 to 2)
        if ($month >= 3 && $month <= 9) {
            $isBlock1 = true;
            $examYear = $refDate->year + 1;
            $examLabel = "April/May {$examYear} Public Exams";
            $examDate = \Carbon\Carbon::parse("{$examYear}-04-01 09:00:00");
        } else {
            $isBlock1 = false;
            $examYear = ($month > 9) ? $refDate->year + 1 : $refDate->year;
            $examLabel = "October/November {$examYear} Public Exams";
            $examDate = \Carbon\Carbon::parse("{$examYear}-10-01 09:00:00");
        }
        
        $now = \Carbon\Carbon::now();
        $daysLeft = $now->diffInDays($examDate, false);
        $hoursLeft = $now->diffInHours($examDate, false) % 24;
        
        if ($daysLeft < 0) {
            $daysLeft = 0;
            $hoursLeft = 0;
        }
    @endphp

    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
    </style>

    <!-- Hero Section / User Profile Summary -->
    <section class="mb-6 sm:mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 sm:gap-6 relative z-10">
        <div class="relative w-full md:w-auto">
            <span class="text-xs uppercase tracking-[0.2em] text-[#006479] font-bold mb-2 block">{{ __('student_command_center') }}</span>
            <h1 class="text-2xl sm:text-3xl md:text-5xl font-bold tracking-tighter text-slate-800 mb-2">{{ __('welcome_back') }}, {{ explode(' ', Auth::user()->name ?? 'Aryan')[0] }}.</h1>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 mt-3 sm:mt-4">
                <div class="flex items-center gap-2 bg-[#40cef3]/10 text-[#006479] px-3 py-1.5 rounded-full text-[10px] font-bold tracking-[0.15em] border border-[#40cef3]/20 shadow-sm">
                    <span class="w-2 h-2 bg-[#006479] rounded-full animate-pulse"></span>
                    {{ $courseBadge }}
                </div>
                <p class="text-slate-500 font-medium text-xs sm:text-sm">{{ __('enrollment_id') }}: <span class="text-slate-700 font-bold tracking-tight">{{ Auth::user()->enrollment_number ?? __('pending_registration') }}</span></p>
            </div>
        </div>

        <!-- Exam Timer Widget -->
        <div class="glass-panel p-4 sm:p-6 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-6 shadow-sm w-full sm:w-auto">
            <div class="flex flex-col">
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#006479] mb-1">{{ __('countdown_to_exams') }}</span>
                <span class="text-sm sm:text-lg font-bold text-slate-800">{{ $examLabel }}</span>
            </div>
            <div class="flex gap-4">
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-[#006479] tabular-nums">{{ $daysLeft }}</div>
                    <div class="text-[10px] font-bold text-slate-500 tracking-widest uppercase">{{ __('days') }}</div>
                </div>
                <div class="w-px h-8 sm:h-10 bg-slate-200 self-center"></div>
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-[#006479] tabular-nums">{{ $hoursLeft }}</div>
                    <div class="text-[10px] font-bold text-slate-500 tracking-widest uppercase">{{ __('hrs') }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Admission Application Status Alert Banners -->
    @if($admission && $admission->status === 'Document Error')
    <section class="mb-10 relative z-10 animate-fade-in">
        <div class="p-4 sm:p-6 rounded-2xl sm:rounded-3xl bg-amber-50/90 border border-amber-300 text-amber-900 shadow-md flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-start gap-4">
                <span class="material-symbols-outlined text-amber-600 text-3xl shrink-0">warning</span>
                <div>
                    <h4 class="font-extrabold text-lg mb-1 text-amber-900">Action Required: Document Verification Error</h4>
                    <p class="text-sm font-medium opacity-90 leading-relaxed">
                        The administration reviewed your application and found an issue with your uploaded documents. Please review and re-submit your enrollment details.
                    </p>
                </div>
            </div>
            <a href="{{ route('application') }}" class="px-5 py-2.5 bg-amber-600 text-white rounded-xl text-xs font-bold hover:bg-amber-700 transition-colors flex items-center gap-2 whitespace-nowrap self-stretch md:self-auto justify-center">
                <span class="material-symbols-outlined text-sm">edit_document</span>
                Correct Documents
            </a>
        </div>
    </section>
    @elseif($admission && $admission->status === 'Pending')
    <section class="mb-10 relative z-10 animate-fade-in">
        <div class="p-5 rounded-3xl bg-sky-50/90 border border-sky-200 text-sky-900 shadow-sm flex items-start gap-4">
            <span class="material-symbols-outlined text-sky-600 text-2xl shrink-0">hourglass_empty</span>
            <div>
                <h4 class="font-bold text-sm mb-0.5 text-sky-900">Profile Under Verification</h4>
                <p class="text-xs font-medium opacity-90 leading-relaxed">
                    Your enrollment documents are currently under review by our administration. We will notify you here once verification is completed.
                </p>
            </div>
        </div>
    </section>
    @elseif($admission && $admission->status === 'Rejected')
    <section class="mb-10 relative z-10 animate-fade-in">
        <div class="p-6 rounded-3xl bg-red-50/90 border border-red-200 text-red-900 shadow-md flex items-start gap-4">
            <span class="material-symbols-outlined text-red-600 text-3xl shrink-0">cancel</span>
            <div>
                <h4 class="font-extrabold text-lg mb-1 text-red-900">Admission Application Rejected</h4>
                <p class="text-sm font-medium opacity-90 leading-relaxed">
                    Unfortunately, your admission application has been rejected by the administration. Please contact the study center or admin helpdesk for further assistance.
                </p>
            </div>
        </div>
    </section>
    @endif

    <!-- Notice Board / Broadcast Messages -->
    @if($broadcasts && $broadcasts->count() > 0)
    <section class="mb-6 sm:mb-10 relative z-10">
        <div class="glass-panel p-4 sm:p-6 rounded-3xl border border-cyan-200/50 shadow-sm bg-gradient-to-r from-cyan-50/50 to-white/50">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-[#006479] animate-bounce">notifications_active</span>
                <h2 class="text-base sm:text-lg font-bold tracking-tight text-slate-800">{{ __('campus_announcements') }}</h2>
            </div>
            <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2">
                @foreach($broadcasts as $broadcast)
                    <div class="p-4 bg-white/80 border border-slate-100 rounded-2xl shadow-sm hover:border-[#40cef3]/30 transition-all">
                        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 mb-2">
                            <h4 class="font-bold text-slate-800 text-sm">{{ $broadcast->subject }}</h4>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $broadcast->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $broadcast->message }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Bento Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start relative z-10 pb-20">
        <!-- TMA Tracker (High Column) -->
        <div class="md:col-span-8 glass-panel p-8 rounded-3xl min-h-[400px] shadow-sm">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6 sm:mb-8">
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-800 mb-1">{{ __('tma_tracker') }}</h2>
                    <p class="text-xs sm:text-sm font-medium text-slate-500">{{ __('assignment_evaluation') }}</p>
                </div>
                <a href="{{ url('/tma') }}" class="bg-gradient-to-r from-cyan-700 to-cyan-500 text-white px-4 sm:px-5 py-2 sm:py-2.5 rounded-lg flex items-center gap-2 text-xs sm:text-sm font-bold shadow-lg shadow-cyan-900/20 hover:scale-[0.98] transition-transform whitespace-nowrap">
                    <span class="material-symbols-outlined text-sm">upload_file</span>
                    {{ __('upload_new_tma') }}
                </a>
            </div>

            @if($tmaCount > 0)
                <div class="space-y-6">
                    @foreach($tmas as $product)
                        @php
                            $fileUrls = $product->file_urls;
                            if (is_string($fileUrls)) {
                                $fileUrls = json_decode($fileUrls, true) ?: [];
                            }
                            $fileUrl = '#';
                            if (is_array($fileUrls) && count($fileUrls) > 0) {
                                $fileUrl = str_starts_with($fileUrls[0], 'http') ? $fileUrls[0] : asset('storage/' . $fileUrls[0]);
                            }
                        @endphp
                        <div class="group p-4 sm:p-5 rounded-2xl bg-[#f2f7f9] border border-transparent hover:border-slate-200 hover:bg-white transition-all duration-300 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4">
                            <div class="flex gap-3 sm:gap-4 w-full sm:w-auto">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-white flex items-center justify-center text-[#006479] shadow-sm border border-slate-100 shrink-0">
                                    <span class="material-symbols-outlined text-lg sm:text-xl">biotech</span>
                                </div>
                                <div class="min-w-0 flex-1 sm:flex-none">
                                    <h3 class="font-bold text-slate-800 text-sm sm:text-base truncate">{{ $product->title }}</h3>
                                    <p class="text-[11px] sm:text-xs text-slate-500 font-medium">TMA Assignment | Published: {{ $product->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2 w-full sm:w-auto">
                                <a href="{{ $fileUrl }}" target="_blank" class="flex-1 sm:flex-initial text-center px-3 sm:px-4 py-1.5 sm:py-2 border border-slate-200 hover:border-cyan-600 hover:text-cyan-600 rounded-xl text-[11px] sm:text-xs font-bold transition-all bg-white shadow-sm">
                                    Download
                                </a>
                                <a href="{{ url('/tma') }}" class="flex-1 sm:flex-initial text-center px-3 sm:px-4 py-1.5 sm:py-2 bg-[#006479] text-white rounded-xl text-[11px] sm:text-xs font-bold hover:bg-cyan-700 transition-all shadow-sm">
                                    Submit Answer
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-16 px-4 border-2 border-dashed border-slate-200 rounded-3xl bg-white/40 text-center min-h-[260px]">
                    <div class="w-16 h-16 bg-cyan-50 text-cyan-600 rounded-full flex items-center justify-center mb-4 shadow-inner">
                        <span class="material-symbols-outlined text-2xl">assignment_late</span>
                    </div>
                        <h3 class="font-bold text-slate-800 text-sm sm:text-base">No Assignments Assigned Yet</h3>
                        <p class="text-xs text-slate-500 mt-1 max-w-[280px] sm:max-w-sm">Your Tutor Marked Assignments (TMAs) will appear here once published by the administration.</p>
                </div>
            @endif
        </div>

        <!-- Digital Locker & Refer/Earn (Right Stack) -->
        <div class="md:col-span-4 space-y-6">
            <!-- Digital Locker -->
            <div class="glass-panel p-4 sm:p-6 rounded-3xl border border-white/60 shadow-sm">
                <div class="flex items-center gap-3 mb-4 sm:mb-6">
                    <span class="material-symbols-outlined text-[#006479] text-xl sm:text-2xl" style="font-variation-settings: 'FILL' 1;">cloud_done</span>
                    <h2 class="text-lg sm:text-xl font-bold tracking-tight text-slate-800">{{ __('digital_locker') }}</h2>
                </div>
                @if($resourceCount > 0)
                    <div class="space-y-3">
                        @foreach($resources as $product)
                            @php
                                $fileUrls = $product->file_urls;
                                if (is_string($fileUrls)) {
                                    $fileUrls = json_decode($fileUrls, true) ?: [];
                                }
                                $fileUrl = '#';
                                if (is_array($fileUrls) && count($fileUrls) > 0) {
                                    $fileUrl = str_starts_with($fileUrls[0], 'http') ? $fileUrls[0] : asset('storage/' . $fileUrls[0]);
                                }
                            @endphp
                            <a href="{{ $fileUrl }}" target="_blank" class="w-full flex items-center justify-between p-4 rounded-2xl bg-[#f2f7f9] hover:bg-white transition-all group border border-slate-100 shadow-sm">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-slate-400 group-hover:text-[#006479] transition-colors">article</span>
                                    <span class="text-sm font-semibold text-slate-700 truncate max-w-[180px]">{{ $product->title }}</span>
                                </div>
                                <span class="material-symbols-outlined text-slate-400 text-lg">download</span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-8 px-4 border border-dashed border-slate-200 rounded-2xl bg-white/30 text-center">
                        <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-xl">folder_off</span>
                        </div>
                        <h3 class="font-bold text-slate-700 text-sm">Your Locker is Empty</h3>
                        <p class="text-[11px] text-slate-400 mt-1 max-w-[200px]">Admit cards and official documents will appear here once released by the admin.</p>
                    </div>
                @endif
            </div>

            <!-- Refer & Earn -->
            <div class="relative overflow-hidden p-5 sm:p-8 rounded-3xl bg-slate-900 text-white shadow-2xl border border-slate-700">
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#40cef3]/30 rounded-full blur-[40px] -mr-8 -mt-8 pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="bg-[#40cef3]/20 text-[#40cef3] w-fit px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-full text-[9px] sm:text-[10px] font-bold tracking-[0.2em] mb-3 sm:mb-4 border border-[#40cef3]/20">PLATINUM OFFER</div>
                    <h3 class="text-xl sm:text-2xl font-bold mb-2 tracking-tight">Refer 10 Students = <br/>100% Refund</h3>
                    <p class="text-slate-400 text-xs mb-4 sm:mb-6 leading-relaxed font-medium">Join our mission to democratize medical excellence. Share your code and secure a refund.</p>
                    <div class="bg-white/5 border border-white/10 rounded-xl p-3 flex items-center justify-between mb-4 sm:mb-6 backdrop-blur-md">
                        <span class="font-mono text-xs font-bold tracking-widest text-[#40cef3]">BASE-A-24</span>
                        <button class="material-symbols-outlined text-white/50 hover:text-white transition-colors text-lg">content_copy</button>
                    </div>
                    <a href="{{ url('/referrals') }}" class="block text-center w-full py-3 sm:py-4 bg-white text-slate-900 rounded-xl font-bold text-xs sm:text-sm hover:scale-[1.02] transition-transform shadow-lg shadow-white/10">
                        Invite Peers Now
                    </a>
                </div>
            </div>

            <!-- Subtle 3D Background Placeholder -->
            <div class="w-full h-48 rounded-3xl overflow-hidden relative grayscale opacity-[0.35] hover:grayscale-0 hover:opacity-100 transition-all duration-700 border border-slate-200">
                <img alt="3D medical render" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDUIICDnh42U-GEIdZZhVv6gQL4mCgn0JVGfFPBDZzanF4FQvEJSi9SkddLxibTAuDxLy_LWBkVjwmH8XEH3vxtofoYci6zfdFNj3pTLIdgIBpfHCsyw6WpGuRROrUReNDQ4jEccoN62gpsURtk7CWioe5BVM4vBvD5TwmxahGp6e4WU1bwu7bv54iAni9R6f5u8gGG7Y9tdBzjPuvWmakGvnem6dECQU91JtNHZKtsV5inykHaiy1TjyI4TtJQk0Eg1PqbhHu7naQ"/>
            </div>
        </div>
    </div>
</x-student-layout>
