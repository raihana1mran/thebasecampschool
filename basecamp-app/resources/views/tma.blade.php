<x-student-layout>
    <style>
        .glass { background: rgba(255,255,255,0.85); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.4); }
        .grade-badge { font-variant-numeric: tabular-nums; }
        @keyframes slideIn { from { opacity:0; transform: translateY(12px); } to { opacity:1; transform: translateY(0); } }
        .tma-card { animation: slideIn 0.4s ease both; }
    </style>

    <div class="max-w-4xl mx-auto relative z-10 pb-20">

        <!-- Header -->
        <div class="mb-10">
            <span class="text-xs uppercase tracking-[0.2em] text-[#006479] font-bold mb-2 block">Academic Submissions</span>
            <h1 class="text-3xl font-bold text-slate-800 mb-2 tracking-tight">TMA Submission Portal</h1>
            <p class="text-slate-500 font-medium">Download your assignment sheets, upload your answers, and track your grades here.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center gap-3 shadow-sm">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <p class="text-sm font-bold text-emerald-800">{{ session('success') }}</p>
            </div>
        @endif

        @if($tmas->isEmpty())
            <!-- Empty state -->
            <div class="glass rounded-3xl p-16 text-center shadow-sm">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-cyan-50 flex items-center justify-center text-[#006479]">
                    <span class="material-symbols-outlined text-4xl">assignment_late</span>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">No TMA Assignments Yet</h3>
                <p class="text-sm text-slate-500 max-w-sm mx-auto">The administration has not published any TMA sheets yet. Check back soon.</p>
            </div>
        @else
            <div class="space-y-5">
                @foreach($tmas as $index => $tma)
                    @php
                        $fileUrls = $tma->file_urls;
                        if (is_string($fileUrls)) { $fileUrls = json_decode($fileUrls, true) ?: []; }
                        $templateUrl = '#';
                        if (is_array($fileUrls) && count($fileUrls) > 0) {
                            $templateUrl = str_starts_with($fileUrls[0], 'http') ? $fileUrls[0] : asset('storage/' . $fileUrls[0]);
                        }
                        $submission = $mySubmissions[$tma->id] ?? null;
                        $isGraded = $submission && $submission->status === 'graded';
                        $isSubmitted = $submission && $submission->status === 'submitted';
                        $delay = $index * 60;
                        
                        $deadlinePassed = $tma->deadline && \Carbon\Carbon::parse($tma->deadline)->isPast();
                        $hasPaidLateFee = false;
                        if ($deadlinePassed) {
                            $hasPaidLateFee = auth()->user()->payments()
                                ->where('type', 'TMA')
                                ->where('payment_id', 'like', 'tma_late_' . $tma->id . '%')
                                ->where('status', 'Success')
                                ->exists();
                        }
                    @endphp
                    <div class="tma-card glass rounded-2xl overflow-hidden shadow-sm border border-white/60" style="animation-delay: {{ $delay }}ms">
                        <!-- Card Header -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-6 gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-600 to-cyan-400 flex items-center justify-center text-white shadow-lg shadow-cyan-500/20 shrink-0">
                                    <span class="material-symbols-outlined text-2xl">biotech</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800 text-base leading-snug">{{ $tma->title }}</h3>
                                    <p class="text-xs text-slate-400 font-medium mt-0.5">TMA Assignment · Published {{ $tma->created_at->format('d M Y') }}</p>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div class="shrink-0">
                                @if($isGraded)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Graded
                                    </span>
                                @elseif($isSubmitted)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-100 text-amber-700 text-xs font-bold border border-amber-200 animate-pulse">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Under Review
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 text-slate-500 text-xs font-bold border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Pending Upload
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Grades Panel (if graded) -->
                        @if($isGraded)
                            <div class="mx-6 mb-4 p-5 rounded-2xl bg-gradient-to-r from-emerald-50 to-cyan-50 border border-emerald-200/50">
                                <h4 class="text-xs font-bold uppercase tracking-widest text-emerald-700 mb-3">Your Results</h4>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                    <div class="text-center p-3 bg-white rounded-xl shadow-sm border border-emerald-100">
                                        <div class="text-2xl font-black text-[#006479] grade-badge">{{ $submission->tma_marks ?? '—' }}<span class="text-sm font-bold text-slate-400">/100</span></div>
                                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mt-1">TMA Marks</div>
                                    </div>
                                    <div class="text-center p-3 bg-white rounded-xl shadow-sm border border-emerald-100">
                                        <div class="text-2xl font-black text-[#006479] grade-badge">{{ $submission->practical_marks ?? '—' }}<span class="text-sm font-bold text-slate-400">/50</span></div>
                                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mt-1">Practical Marks</div>
                                    </div>
                                    <div class="col-span-2 sm:col-span-1 text-center p-3 bg-white rounded-xl shadow-sm border border-emerald-100">
                                        <div class="text-2xl font-black text-emerald-600 grade-badge">
                                            {{ (($submission->tma_marks ?? 0) + ($submission->practical_marks ?? 0)) }}<span class="text-sm font-bold text-slate-400">/150</span>
                                        </div>
                                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mt-1">Total Score</div>
                                    </div>
                                </div>
                                @if($submission->admin_remarks)
                                    <div class="mt-3 p-3 bg-white rounded-xl border border-slate-100">
                                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Tutor Remarks</p>
                                        <p class="text-sm text-slate-700 font-medium">{{ $submission->admin_remarks }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Submitted file info (if submitted/graded) -->
                        @if($submission)
                            <div class="mx-6 mb-4 flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200">
                                <span class="material-symbols-outlined text-slate-400">attach_file</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-slate-700 truncate">{{ $submission->original_filename ?? 'Submitted File' }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium">Submitted {{ $submission->submitted_at ? $submission->submitted_at->diffForHumans() : $submission->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Action Row -->
                        <div class="px-6 pb-6 flex flex-col gap-4">
                            @if($deadlinePassed && $hasPaidLateFee)
                                <div class="p-3 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center gap-2">
                                    <span class="material-symbols-outlined text-emerald-600 text-sm">check_circle</span>
                                    <span class="text-xs font-bold text-emerald-700">Late submission fee paid successfully. Submission unlocked!</span>
                                </div>
                            @endif

                            <div class="flex flex-wrap gap-3 items-center w-full">
                                <!-- Download Template -->
                                <a href="{{ $templateUrl }}" target="_blank" class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:border-[#006479] hover:text-[#006479] text-slate-600 text-xs font-bold transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-sm">download</span>
                                    Download Template
                                </a>

                                @if($deadlinePassed && !$hasPaidLateFee)
                                    <!-- Late Payment Call-to-action instead of upload form -->
                                    <div class="flex-1 min-w-[220px] flex items-center justify-between bg-red-50/50 border border-red-200/50 rounded-xl p-3">
                                        <div>
                                            <p class="text-xs text-red-600 font-bold flex items-center gap-1">
                                                <span class="material-symbols-outlined text-sm">warning</span>
                                                Deadline passed ({{ \Carbon\Carbon::parse($tma->deadline)->format('d M Y') }})
                                            </p>
                                            <p class="text-[10px] text-slate-500 font-medium">Late submission fee of ₹1,200 is required to upload.</p>
                                        </div>
                                        <form action="{{ route('payments.tma-late-fee', $tma->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-1.5 hover:scale-[1.02] active:scale-95 duration-200">
                                                <span class="material-symbols-outlined text-sm">payment</span>
                                                Pay ₹1,200
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <!-- Upload Form -->
                                    <div x-data="{ fileName: '', uploading: false }" class="flex-1 min-w-[220px]">
                                        <form action="{{ route('tma.submit', $tma->id) }}" method="POST" enctype="multipart/form-data"
                                              x-on:submit="uploading = true" class="flex items-center gap-2 m-0">
                                            @csrf
                                            <label class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-dashed border-[#006479]/40 bg-cyan-50/50 hover:bg-cyan-50 text-[#006479] text-xs font-bold transition-all cursor-pointer flex-1">
                                                <span class="material-symbols-outlined text-sm">upload_file</span>
                                                <span x-text="fileName || '{{ $submission ? 'Re-upload Answer' : 'Upload Answer' }}'"></span>
                                                <input type="file" name="tma_file" class="hidden" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                                       x-on:change="fileName = $event.target.files[0]?.name || ''">
                                            </label>
                                            <button type="submit"
                                                    x-bind:disabled="!fileName || uploading"
                                                    x-bind:class="(!fileName || uploading) ? 'opacity-40 cursor-not-allowed' : 'hover:bg-[#006479]'"
                                                    class="px-4 py-2.5 rounded-xl bg-[#006479] text-white text-xs font-bold transition-all shadow-sm flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-sm" x-show="!uploading">send</span>
                                                <span class="material-symbols-outlined text-sm animate-spin" x-show="uploading" style="display:none">progress_activity</span>
                                                <span x-text="uploading ? 'Sending...' : 'Submit'"></span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-student-layout>