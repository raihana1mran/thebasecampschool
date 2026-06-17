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

    <div x-data="{
        searchQuery: '',
        filterCategory: '',
        showComposeModal: false,
        composeSubject: '',
        composeMessage: '',
        sending: false,
        toast: { show: false, message: '', type: 'success' },

        get filteredTmas() {
            const items = {{ json_encode($tmas->map(fn($p) => ['id' => $p->id, 'title' => $p->title, 'created_at' => $p->created_at->format('d M Y'), 'file_url' => (function() use ($p) { $urls = is_string($p->file_urls) ? json_decode($p->file_urls, true) ?: [] : ($p->file_urls ?? []); return (is_array($urls) && count($urls) > 0) ? (str_starts_with($urls[0], 'http') ? $urls[0] : asset('storage/' . $urls[0])) : '#'; })() ])->values()) }}
            if (!this.searchQuery && !this.filterCategory) return items;
            const q = this.searchQuery.toLowerCase();
            return items.filter(item => {
                if (this.filterCategory === 'resource') return false;
                if (q && !item.title.toLowerCase().includes(q)) return false;
                return true;
            });
        },

        get filteredResources() {
            const items = {{ json_encode($resources->map(fn($p) => ['id' => $p->id, 'title' => $p->title, 'created_at' => $p->created_at->format('d M Y'), 'file_url' => (function() use ($p) { $urls = is_string($p->file_urls) ? json_decode($p->file_urls, true) ?: [] : ($p->file_urls ?? []); return (is_array($urls) && count($urls) > 0) ? (str_starts_with($urls[0], 'http') ? $urls[0] : asset('storage/' . $urls[0])) : '#'; })() ])->values()) }}
            if (!this.searchQuery && !this.filterCategory) return items;
            const q = this.searchQuery.toLowerCase();
            return items.filter(item => {
                if (this.filterCategory === 'tma') return false;
                if (q && !item.title.toLowerCase().includes(q)) return false;
                return true;
            });
        },

        async sendMessage() {
            if (!this.composeSubject.trim() || !this.composeMessage.trim()) return;
            this.sending = true;
            try {
                const resp = await fetch('{{ route("student.message") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ subject: this.composeSubject, message: this.composeMessage })
                });
                const data = await resp.json();
                if (data.success) {
                    this.toast = { show: true, message: 'Message sent to administration successfully!', type: 'success' };
                    this.composeSubject = '';
                    this.composeMessage = '';
                    this.showComposeModal = false;
                } else {
                    this.toast = { show: true, message: 'Failed to send message. Please try again.', type: 'error' };
                }
            } catch {
                this.toast = { show: true, message: 'Network error. Please try again.', type: 'error' };
            } finally {
                this.sending = false;
                setTimeout(() => this.toast.show = false, 4000);
            }
        }
    }">
    <!-- Hero Section / User Profile Summary -->
    <section class="mb-5 sm:mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 sm:gap-6 relative z-10">
        <div class="relative w-full md:w-auto">
            <span class="text-[10px] sm:text-xs uppercase tracking-[0.2em] text-[#006479] font-bold mb-1 sm:mb-2 block">{{ __('student_command_center') }}</span>
            <h1 class="text-[clamp(1.25rem,5vw,3rem)] sm:text-3xl md:text-5xl font-bold tracking-tighter text-slate-800 mb-1 sm:mb-2">{{ __('welcome_back') }}, {{ explode(' ', Auth::user()->name ?? 'Aryan')[0] }}.</h1>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 mt-2 sm:mt-4">
                <div class="flex items-center gap-2 bg-[#40cef3]/10 text-[#006479] px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-full text-[9px] sm:text-[10px] font-bold tracking-[0.15em] border border-[#40cef3]/20 shadow-sm shrink-0">
                    <span class="w-1.5 sm:w-2 h-1.5 sm:h-2 bg-[#006479] rounded-full animate-pulse"></span>
                    {{ $courseBadge }}
                </div>
                <p class="text-slate-500 font-medium text-[11px] sm:text-sm">{{ __('enrollment_id') }}: <span class="text-slate-700 font-bold tracking-tight">{{ Auth::user()->enrollment_number ?? __('pending_registration') }}</span></p>
            </div>
        </div>

        <!-- Exam Timer Widget -->
        <div class="glass-panel p-3 sm:p-6 rounded-2xl flex flex-row sm:flex-row items-center gap-3 sm:gap-6 shadow-sm w-full sm:w-auto">
            <div class="flex flex-col min-w-0 flex-1 sm:flex-none">
                <span class="text-[9px] sm:text-[10px] font-bold uppercase tracking-widest text-[#006479] mb-0.5 sm:mb-1">{{ __('countdown_to_exams') }}</span>
                <span class="text-[11px] sm:text-lg font-bold text-slate-800 truncate">{{ $examLabel }}</span>
            </div>
            <div class="flex gap-3 sm:gap-4 shrink-0">
                <div class="text-center min-w-[40px] sm:min-w-0">
                    <div class="text-[clamp(1.25rem,5vw,1.875rem)] sm:text-3xl font-bold text-[#006479] tabular-nums">{{ $daysLeft }}</div>
                    <div class="text-[9px] sm:text-[10px] font-bold text-slate-500 tracking-widest uppercase">{{ __('days') }}</div>
                </div>
                <div class="w-px h-6 sm:h-10 bg-slate-200 self-center"></div>
                <div class="text-center min-w-[40px] sm:min-w-0">
                    <div class="text-[clamp(1.25rem,5vw,1.875rem)] sm:text-3xl font-bold text-[#006479] tabular-nums">{{ $hoursLeft }}</div>
                    <div class="text-[9px] sm:text-[10px] font-bold text-slate-500 tracking-widest uppercase">{{ __('hrs') }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Admission Application Status Alert Banners -->
    @if($admission && $admission->status === 'Document Error')
    <section class="mb-6 sm:mb-10 relative z-10">
        <div class="p-4 sm:p-6 rounded-2xl sm:rounded-3xl bg-amber-50/90 border border-amber-300 text-amber-900 shadow-md flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-start gap-3 sm:gap-4 w-full md:w-auto">
                <span class="material-symbols-outlined text-amber-600 text-2xl sm:text-3xl shrink-0">warning</span>
                <div class="min-w-0">
                    <h4 class="font-extrabold text-sm sm:text-lg mb-1 text-amber-900">Action Required: Document Verification Error</h4>
                    <p class="text-xs sm:text-sm font-medium opacity-90 leading-relaxed">
                        The administration reviewed your application and found an issue with your uploaded documents. Please review and re-submit your enrollment details.
                    </p>
                </div>
            </div>
            <a href="{{ route('application') }}" class="w-full md:w-auto px-5 py-2.5 bg-amber-600 text-white rounded-xl text-xs font-bold hover:bg-amber-700 transition-colors flex items-center gap-2 whitespace-nowrap justify-center">
                <span class="material-symbols-outlined text-sm">edit_document</span>
                Correct Documents
            </a>
        </div>
    </section>
    @elseif($admission && $admission->status === 'Pending')
    <section class="mb-6 sm:mb-10 relative z-10">
        <div class="p-4 sm:p-5 rounded-2xl sm:rounded-3xl bg-sky-50/90 border border-sky-200 text-sky-900 shadow-sm flex items-start gap-3 sm:gap-4">
            <span class="material-symbols-outlined text-sky-600 text-xl sm:text-2xl shrink-0">hourglass_empty</span>
            <div class="min-w-0">
                <h4 class="font-bold text-xs sm:text-sm mb-0.5 text-sky-900">Profile Under Verification</h4>
                <p class="text-[11px] sm:text-xs font-medium opacity-90 leading-relaxed">
                    Your enrollment documents are currently under review by our administration. We will notify you here once verification is completed.
                </p>
            </div>
        </div>
    </section>
    @elseif($admission && $admission->status === 'Rejected')
    <section class="mb-6 sm:mb-10 relative z-10">
        <div class="p-4 sm:p-6 rounded-2xl sm:rounded-3xl bg-red-50/90 border border-red-200 text-red-900 shadow-md flex items-start gap-3 sm:gap-4">
            <span class="material-symbols-outlined text-red-600 text-2xl sm:text-3xl shrink-0">cancel</span>
            <div class="min-w-0">
                <h4 class="font-extrabold text-sm sm:text-lg mb-1 text-red-900">Admission Application Rejected</h4>
                <p class="text-xs sm:text-sm font-medium opacity-90 leading-relaxed">
                    Unfortunately, your admission application has been rejected by the administration. Please contact the study center or admin helpdesk for further assistance.
                </p>
            </div>
        </div>
    </section>
    @endif

    <!-- Notice Board / Broadcast Messages -->
    @if($broadcasts && $broadcasts->count() > 0)
    <section class="mb-5 sm:mb-10 relative z-10">
        <div class="glass-panel p-3 sm:p-6 rounded-2xl sm:rounded-3xl border border-cyan-200/50 shadow-sm bg-gradient-to-r from-cyan-50/50 to-white/50">
            <div class="flex items-center gap-2 mb-3 sm:mb-4">
                <span class="material-symbols-outlined text-[#006479] animate-bounce text-lg sm:text-2xl">notifications_active</span>
                <h2 class="text-sm sm:text-lg font-bold tracking-tight text-slate-800">{{ __('campus_announcements') }}</h2>
            </div>
            <div class="space-y-3 sm:space-y-4 max-h-[300px] overflow-y-auto pr-1 sm:pr-2">
                @foreach($broadcasts as $broadcast)
                    <div class="p-3 sm:p-4 bg-white/80 border border-slate-100 rounded-xl sm:rounded-2xl shadow-sm hover:border-[#40cef3]/30 transition-all">
                        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-1 sm:gap-2 mb-1 sm:mb-2">
                            <h4 class="font-bold text-slate-800 text-xs sm:text-sm">{{ $broadcast->subject }}</h4>
                            <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $broadcast->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-[11px] sm:text-xs text-slate-600 leading-relaxed break-words">{!! preg_replace('/\b(https?:\/\/[^\s<]+)/', '<a href="$1" target="_blank" class="text-cyan-600 font-bold hover:underline">$1</a>', e($broadcast->message)) !!}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Search & Filter Bar -->
    <div class="mb-4 sm:mb-6 relative z-10 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
        <div class="relative flex-1">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-lg pointer-events-none">search</span>
            <input type="text" x-model="searchQuery" placeholder="Search TMAs, resources..." class="w-full pl-10 pr-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-slate-200 bg-white/80 text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/40 focus:border-cyan-400 transition-all shadow-sm min-h-[44px]" />
        </div>
        <div class="flex gap-2">
            <select x-model="filterCategory" class="px-3 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-slate-200 bg-white/80 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-400/40 focus:border-cyan-400 transition-all shadow-sm min-h-[44px]">
                <option value="">All Categories</option>
                <option value="tma">TMA Assignments</option>
                <option value="resource">Resources</option>
            </select>
            <button @click="searchQuery = ''; filterCategory = ''" class="px-3 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-slate-200 bg-white/80 text-slate-500 hover:text-slate-700 hover:bg-slate-50 transition-all shadow-sm text-sm font-medium min-h-[44px] flex items-center gap-1">
                <span class="material-symbols-outlined text-lg">refresh</span>
                <span class="hidden sm:inline">Reset</span>
            </button>
        </div>
    </div>

    <!-- Bento Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 sm:gap-6 items-start relative z-10 pb-24 sm:pb-28">
        <!-- TMA Tracker (High Column) -->
        <div class="md:col-span-8 glass-panel p-4 sm:p-8 rounded-2xl sm:rounded-3xl min-h-[300px] sm:min-h-[400px] shadow-sm">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4 sm:mb-8">
                <div>
                    <h2 class="text-lg sm:text-2xl font-bold tracking-tight text-slate-800 mb-0.5 sm:mb-1">{{ __('tma_tracker') }}</h2>
                    <p class="text-[11px] sm:text-sm font-medium text-slate-500">{{ __('assignment_evaluation') }}</p>
                </div>
                <a href="{{ url('/tma') }}" class="w-full sm:w-auto text-center bg-gradient-to-r from-cyan-700 to-cyan-500 text-white px-4 sm:px-5 py-2.5 sm:py-2.5 rounded-lg flex items-center justify-center gap-2 text-xs sm:text-sm font-bold shadow-lg shadow-cyan-900/20 hover:scale-[0.98] transition-transform whitespace-nowrap">
                    <span class="material-symbols-outlined text-sm">upload_file</span>
                    {{ $tmaCount > 0 ? __('upload_new_tma') : 'View TMA Portal' }}
                </a>
            </div>

            @if($tmaCount > 0)
                <div class="space-y-3 sm:space-y-6">
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
                        <div x-show="(!searchQuery || '{{ $product->title }}'.toLowerCase().includes(searchQuery.toLowerCase())) && (filterCategory !== 'resource')" class="group p-3 sm:p-5 rounded-xl sm:rounded-2xl bg-[#f2f7f9] border border-transparent hover:border-slate-200 hover:bg-white transition-all duration-300 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4">
                            <div class="flex gap-3 sm:gap-4 w-full sm:w-auto items-start">
                                <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl bg-white flex items-center justify-center text-[#006479] shadow-sm border border-slate-100 shrink-0">
                                    <span class="material-symbols-outlined text-base sm:text-xl">biotech</span>
                                </div>
                                <div class="min-w-0 flex-1 sm:flex-none">
                                    <h3 class="font-bold text-slate-800 text-xs sm:text-base truncate">{{ $product->title }}</h3>
                                    <p class="text-[10px] sm:text-xs text-slate-500 font-medium">TMA Assignment | Published: {{ $product->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2 w-full sm:w-auto">
                                <a href="{{ $fileUrl }}" target="_blank" class="flex-1 sm:flex-initial text-center px-3 sm:px-4 py-2 sm:py-2 border border-slate-200 hover:border-cyan-600 hover:text-cyan-600 rounded-xl text-[11px] sm:text-xs font-bold transition-all bg-white shadow-sm min-h-[44px] sm:min-h-0 flex items-center justify-center">
                                    Download
                                </a>
                                <a href="{{ url('/tma') }}" class="flex-1 sm:flex-initial text-center px-3 sm:px-4 py-2 sm:py-2 bg-[#006479] text-white rounded-xl text-[11px] sm:text-xs font-bold hover:bg-cyan-700 transition-all shadow-sm min-h-[44px] sm:min-h-0 flex items-center justify-center">
                                    Submit Answer
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- No search results state -->
                <div x-show="searchQuery && filteredTmas.length === 0" class="flex flex-col items-center justify-center py-8 px-4 border-2 border-dashed border-slate-200 rounded-2xl sm:rounded-3xl bg-white/40 text-center">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-lg sm:text-xl">search_off</span>
                    </div>
                    <h3 class="font-bold text-slate-700 text-sm sm:text-base">No Matching TMAs</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-[260px]">Try adjusting your search or filter to find what you're looking for.</p>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 sm:py-16 px-4 border-2 border-dashed border-slate-200 rounded-2xl sm:rounded-3xl bg-white/40 text-center min-h-[200px] sm:min-h-[260px]">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-cyan-50 text-cyan-600 rounded-full flex items-center justify-center mb-3 sm:mb-4 shadow-inner">
                        <span class="material-symbols-outlined text-xl sm:text-2xl">assignment_late</span>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm sm:text-base">No Assignments Assigned Yet</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-[260px] sm:max-w-sm">Your Tutor Marked Assignments (TMAs) will appear here once published by the administration.</p>
                    <a href="{{ url('/tma') }}" class="mt-4 px-4 py-2 bg-cyan-50 text-cyan-700 rounded-xl text-xs font-bold hover:bg-cyan-100 transition-colors border border-cyan-200">View TMA Portal</a>
                </div>
            @endif
        </div>

        <!-- Digital Locker & Refer/Earn (Right Stack) -->
        <div class="md:col-span-4 space-y-4 sm:space-y-6">
            <!-- Digital Locker -->
            <div class="glass-panel p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-white/60 shadow-sm">
                <div class="flex items-center gap-3 mb-4 sm:mb-6">
                    <span class="material-symbols-outlined text-[#006479] text-xl sm:text-2xl" style="font-variation-settings: 'FILL' 1;">cloud_done</span>
                    <h2 class="text-base sm:text-xl font-bold tracking-tight text-slate-800">{{ __('digital_locker') }}</h2>
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
                            <a x-show="(!searchQuery || '{{ $product->title }}'.toLowerCase().includes(searchQuery.toLowerCase())) && (filterCategory !== 'tma')" href="{{ $fileUrl }}" target="_blank" class="w-full flex items-center justify-between p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-[#f2f7f9] hover:bg-white transition-all group border border-slate-100 shadow-sm min-h-[44px]">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="material-symbols-outlined text-slate-400 group-hover:text-[#006479] transition-colors shrink-0">article</span>
                                    <span class="text-xs sm:text-sm font-semibold text-slate-700 truncate">{{ $product->title }}</span>
                                </div>
                                <span class="material-symbols-outlined text-slate-400 text-lg shrink-0">download</span>
                            </a>
                        @endforeach
                    </div>
                    <!-- No search results for resources -->
                    <div x-show="searchQuery && filteredResources.length === 0" class="flex flex-col items-center justify-center py-6 px-4 border border-dashed border-slate-200 rounded-xl bg-white/30 text-center">
                        <div class="w-10 h-10 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-lg">search_off</span>
                        </div>
                        <h3 class="font-bold text-slate-700 text-xs sm:text-sm">No Matching Resources</h3>
                        <p class="text-[10px] sm:text-[11px] text-slate-400 mt-1 max-w-[180px]">Adjust your search or filter to find resources.</p>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-6 sm:py-8 px-4 border border-dashed border-slate-200 rounded-xl sm:rounded-2xl bg-white/30 text-center">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-lg sm:text-xl">folder_off</span>
                        </div>
                        <h3 class="font-bold text-slate-700 text-xs sm:text-sm">Your Locker is Empty</h3>
                        <p class="text-[10px] sm:text-[11px] text-slate-400 mt-1 max-w-[180px] sm:max-w-[200px]">Admit cards and official documents will appear here once released by the admin.</p>
                        <a href="{{ url('/downloads') }}" class="mt-3 px-3 py-1.5 bg-cyan-50 text-cyan-700 rounded-lg text-[10px] font-bold hover:bg-cyan-100 transition-colors border border-cyan-200">Browse Resources</a>
                    </div>
                @endif
            </div>

            <!-- Refer & Earn -->
            <div class="relative overflow-hidden p-5 sm:p-8 rounded-2xl sm:rounded-3xl bg-slate-900 text-white shadow-2xl border border-slate-700">
                <div class="absolute top-0 right-0 w-24 h-24 sm:w-32 sm:h-32 bg-[#40cef3]/30 rounded-full blur-[40px] -mr-8 -mt-8 pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="bg-[#40cef3]/20 text-[#40cef3] w-fit px-2 sm:px-3 py-1 sm:py-1.5 rounded-full text-[9px] sm:text-[10px] font-bold tracking-[0.2em] mb-3 sm:mb-4 border border-[#40cef3]/20">PLATINUM OFFER</div>
                    <h3 class="text-lg sm:text-2xl font-bold mb-2 tracking-tight">Refer 10 Students = <br class="hidden sm:block"/>100% Refund</h3>
                    <p class="text-slate-400 text-xs mb-4 sm:mb-6 leading-relaxed font-medium">Join our mission to democratize medical excellence. Share your code and secure a refund.</p>
                    <div class="bg-white/5 border border-white/10 rounded-xl p-3 flex items-center justify-between mb-4 sm:mb-6 backdrop-blur-md">
                        <span class="font-mono text-xs font-bold tracking-widest text-[#40cef3]">BASE-A-24</span>
                        <button class="material-symbols-outlined text-white/50 hover:text-white transition-colors text-lg">content_copy</button>
                    </div>
                    <a href="{{ url('/referrals') }}" class="block text-center w-full py-3 sm:py-4 bg-white text-slate-900 rounded-xl font-bold text-xs sm:text-sm hover:scale-[1.02] transition-transform shadow-lg shadow-white/10 min-h-[44px] flex items-center justify-center">
                        Invite Peers Now
                    </a>
                </div>
            </div>

            <!-- Subtle 3D Background Placeholder -->
            <div class="w-full h-36 sm:h-48 rounded-2xl sm:rounded-3xl overflow-hidden relative grayscale opacity-[0.35] hover:grayscale-0 hover:opacity-100 transition-all duration-700 border border-slate-200">
                <img alt="3D medical render" class="w-full h-full object-cover" loading="lazy" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDUIICDnh42U-GEIdZZhVv6gQL4mCgn0JVGfFPBDZzanF4FQvEJSi9SkddLxibTAuDxLy_LWBkVjwmH8XEH3vxtofoYci6zfdFNj3pTLIdgIBpfHCsyw6WpGuRROrUReNDQ4jEccoN62gpsURtk7CWioe5BVM4vBvD5TwmxahGp6e4WU1bwu7bv54iAni9R6f5u8gGG7Y9tdBzjPuvWmakGvnem6dECQU91JtNHZKtsV5inykHaiy1TjyI4TtJQk0Eg1PqbhHu7naQ"/>
            </div>
        </div>
    </div><!-- end bento grid -->

    <!-- Floating Broadcast / Compose Button -->
    <button @click="showComposeModal = true" class="fixed bottom-6 right-6 z-50 w-14 h-14 rounded-full bg-gradient-to-r from-cyan-600 to-cyan-500 text-white shadow-2xl shadow-cyan-500/40 hover:scale-110 active:scale-95 transition-all duration-200 flex items-center justify-center">
        <span class="material-symbols-outlined text-2xl" x-show="!showComposeModal" style="font-variation-settings: 'FILL' 1;">edit_note</span>
    </button>

    <!-- Toast Notification -->
    <div x-show="toast.show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" class="fixed bottom-24 right-6 z-[60] max-w-sm w-full sm:w-auto" x-cloak>
        <div :class="toast.type === 'success' ? 'bg-emerald-50 border-emerald-200 text-emerald-900' : 'bg-red-50 border-red-200 text-red-900'" class="p-4 rounded-2xl border shadow-xl backdrop-blur-xl flex items-center gap-3">
            <span :class="toast.type === 'success' ? 'text-emerald-600' : 'text-red-600'" class="material-symbols-outlined shrink-0" x-text="toast.type === 'success' ? 'check_circle' : 'error'"></span>
            <div>
                <p class="font-bold text-sm" x-text="toast.type === 'success' ? 'Success' : 'Error'"></p>
                <p class="text-xs mt-0.5 opacity-80" x-text="toast.message"></p>
            </div>
            <button @click="toast.show = false" class="ml-auto shrink-0 p-1 rounded-lg hover:bg-black/5 transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    </div>

    <!-- Compose Message Modal -->
    <div x-show="showComposeModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" @click.self="showComposeModal = false">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
        <div @click.stop class="relative w-full max-w-lg bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-slate-200 overflow-hidden" @keydown.escape.window="showComposeModal = false">
            <div class="flex items-center justify-between p-4 sm:p-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#006479] text-xl" style="font-variation-settings: 'FILL' 1;">forward_to_inbox</span>
                    <h2 class="text-base sm:text-lg font-bold text-slate-800">Send Message to Admin</h2>
                </div>
                <button @click="showComposeModal = false" class="p-2 rounded-xl hover:bg-slate-100 text-slate-400 transition-colors">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
            <div class="p-4 sm:p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Subject</label>
                    <input type="text" x-model="composeSubject" placeholder="e.g. Query about TMA submission" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/40 focus:border-cyan-400 transition-all" maxlength="255" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Message</label>
                    <textarea x-model="composeMessage" rows="5" placeholder="Write your message here..." class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/40 focus:border-cyan-400 transition-all resize-none" maxlength="5000"></textarea>
                    <p class="text-[10px] text-slate-400 mt-1 text-right" x-text="composeMessage.length + '/5000'"></p>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 p-4 sm:p-6 border-t border-slate-100 bg-slate-50/50">
                <button @click="showComposeModal = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-bold hover:bg-slate-100 transition-colors min-h-[44px]">Cancel</button>
                <button @click="sendMessage()" :disabled="sending || !composeSubject.trim() || !composeMessage.trim()" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-cyan-600 to-cyan-500 text-white text-sm font-bold hover:scale-[0.98] transition-all shadow-lg shadow-cyan-500/25 disabled:opacity-50 disabled:cursor-not-allowed min-h-[44px] flex items-center gap-2">
                    <span x-show="sending" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                    <span x-text="sending ? 'Sending...' : 'Send Message'"></span>
                </button>
            </div>
        </div>
    </div><!-- end compose modal -->
</div><!-- end x-data wrapper -->

</x-student-layout>
