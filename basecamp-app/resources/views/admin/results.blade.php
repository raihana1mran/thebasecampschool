<x-admin-layout>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 40px 60px rgba(42, 48, 49, 0.04);
        }
        .ghost-border { border: 1px solid rgba(168, 174, 176, 0.15); }
        .cyan-glow {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
            box-shadow: 0 4px 20px rgba(64, 206, 243, 0.2);
        }
        .cyan-glow-button {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
            box-shadow: 0 4px 20px rgba(64, 206, 243, 0.2);
            color: #e0f6ff;
        }
        .cyan-glow-button:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 100, 121, 0.1);
            border-radius: 10px;
        }
        .result-badge-pass {
            background: #dcfce7; color: #15803d;
        }
        .result-badge-fail {
            background: #fee2e2; color: #b91c1c;
        }
        .result-badge-pending {
            background: #fef9c3; color: #a16207;
        }
    </style>

    <!-- Atmospheric Background Blobs -->
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary-container/20 rounded-full blur-[120px] pointer-events-none -z-10 transition-transform duration-300" id="blob1"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-secondary-container/10 rounded-full blur-[120px] pointer-events-none -z-10 transition-transform duration-300" id="blob2"></div>

    <div x-data="resultManager" class="w-full space-y-8 pb-20">

        <!-- Header -->
        <section class="flex flex-col gap-2">
            <p class="text-primary font-bold tracking-[0.2em] text-xs uppercase">Administrative Portal</p>
            <h3 class="font-display text-4xl font-extrabold text-on-surface tracking-tighter">Result Management Hub</h3>
            <p class="text-sm text-on-surface-variant/70 max-w-2xl">Publish exam results, manage student scorecards, and send result notifications. All published results are instantly broadcast to enrolled students.</p>
        </section>

        <!-- KPI Metrics Row -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="glass-card p-6 rounded-xl flex flex-col gap-4 relative overflow-hidden group hover:-translate-y-1 transition-all duration-500">
                <div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-full -mr-8 -mt-8 transition-transform group-hover:scale-125 duration-700"></div>
                <div class="flex justify-between items-start">
                    <span class="material-symbols-outlined text-primary p-2 rounded-lg bg-primary-container/20">groups</span>
                    <span class="text-[10px] font-bold text-green-600 bg-green-100 px-2 py-0.5 rounded-full">LIVE</span>
                </div>
                <div>
                    <p class="text-3xl font-bold tracking-tight">{{ $totalStudents }}</p>
                    <p class="text-[11px] uppercase tracking-widest text-on-surface-variant/70 font-semibold mt-1">Total Students</p>
                </div>
            </div>

            <div class="glass-card p-6 rounded-xl flex flex-col gap-4 relative overflow-hidden group hover:-translate-y-1 transition-all duration-500 border-l-4 border-primary/30">
                <div class="flex justify-between items-start">
                    <span class="material-symbols-outlined text-primary p-2 rounded-lg bg-primary-container/20">task_alt</span>
                    <span class="text-[10px] font-bold text-primary bg-primary-container/20 px-2 py-0.5 rounded-full">PASS</span>
                </div>
                <div>
                    <p class="text-3xl font-bold tracking-tight text-primary">{{ $passCount }}</p>
                    <p class="text-[11px] uppercase tracking-widest text-on-surface-variant/70 font-semibold mt-1">Students Passed</p>
                </div>
            </div>

            <div class="glass-card p-6 rounded-xl flex flex-col gap-4 relative overflow-hidden group hover:-translate-y-1 transition-all duration-500 border-l-4 border-error/30">
                <div class="flex justify-between items-start">
                    <span class="material-symbols-outlined text-error p-2 rounded-lg bg-error-container/10">cancel</span>
                    <span class="text-[10px] font-bold text-error bg-error-container/20 px-2 py-0.5 rounded-full">FAIL</span>
                </div>
                <div>
                    <p class="text-3xl font-bold tracking-tight text-error">{{ $failCount }}</p>
                    <p class="text-[11px] uppercase tracking-widest text-on-surface-variant/70 font-semibold mt-1">Students Failed</p>
                </div>
            </div>

            <div class="glass-card p-6 rounded-xl flex flex-col gap-4 relative overflow-hidden group hover:-translate-y-1 transition-all duration-500">
                <div class="flex justify-between items-start">
                    <span class="material-symbols-outlined text-primary p-2 rounded-lg bg-primary-container/20">analytics</span>
                    <span class="text-[10px] font-bold text-on-surface-variant/50 px-2 py-0.5">AVG%</span>
                </div>
                <div>
                    <div class="flex items-baseline gap-2">
                        <p class="text-3xl font-bold tracking-tight">{{ number_format($avgScore, 1) }}</p>
                        <p class="text-sm font-semibold text-on-surface-variant/60">/ 100</p>
                    </div>
                    <p class="text-[11px] uppercase tracking-widest text-on-surface-variant/70 font-semibold mt-1">Average Score (TMA)</p>
                </div>
            </div>
        </div>

        <!-- Action Panels -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Publish Result Panel -->
            <div class="lg:col-span-2 glass-card p-8 rounded-xl">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-primary">Publish Exam Result</h3>
                        <p class="text-sm text-on-surface-variant/70 mt-1">Broadcast a public exam result link to all enrolled students instantly.</p>
                    </div>
                    <span class="material-symbols-outlined text-primary/20 text-6xl" style="font-variation-settings: 'FILL' 1;">grade</span>
                </div>
                <form @submit.prevent="publishResult()" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/70 ml-1">Exam / Batch Name</label>
                            <input x-model="pubExamName" type="text" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-semibold" placeholder="e.g. NIOS Oct–Nov 2026 (10th)"/>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/70 ml-1">Official Result URL</label>
                            <input x-model="pubLink" type="url" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-semibold" placeholder="https://results.nios.ac.in/..."/>
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/70 ml-1">Additional Notes (Optional)</label>
                        <textarea x-model="pubNotes" rows="3" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-semibold resize-none" placeholder="e.g. Students can check their results using their Enrollment Number..."></textarea>
                    </div>
                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="cyan-glow-button px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">send</span>
                            Publish & Notify Students
                        </button>
                        <p class="text-[10px] text-on-surface-variant/50 font-medium">This will broadcast a notification to all active students.</p>
                    </div>
                </form>
            </div>

            <!-- Quick Links Panel -->
            <div class="glass-card p-8 rounded-xl flex flex-col gap-4">
                <h3 class="text-xl font-bold text-primary">Quick Actions</h3>
                <p class="text-sm text-on-surface-variant/70 -mt-2">Generate and download administrative reports.</p>

                <a href="{{ route('admin.exams.eligible') }}" class="flex items-center gap-4 p-4 rounded-xl border border-outline-variant/20 hover:bg-primary-container/10 hover:border-primary/20 group transition-all duration-300">
                    <span class="material-symbols-outlined text-primary p-2 bg-primary-container/10 rounded-lg group-hover:scale-110 transition-transform">format_list_bulleted</span>
                    <div>
                        <p class="font-bold text-sm text-on-surface">Eligible Students List</p>
                        <p class="text-[10px] text-on-surface-variant/60">Download CSV of all exam-eligible students</p>
                    </div>
                </a>

                <a href="{{ route('admin.reports.admissions') }}" class="flex items-center gap-4 p-4 rounded-xl border border-outline-variant/20 hover:bg-primary-container/10 hover:border-primary/20 group transition-all duration-300">
                    <span class="material-symbols-outlined text-primary p-2 bg-primary-container/10 rounded-lg group-hover:scale-110 transition-transform">download</span>
                    <div>
                        <p class="font-bold text-sm text-on-surface">Admission Report</p>
                        <p class="text-[10px] text-on-surface-variant/60">Full CSV of all admission records</p>
                    </div>
                </a>

                <a href="{{ route('admin.reports.revenue') }}" class="flex items-center gap-4 p-4 rounded-xl border border-outline-variant/20 hover:bg-primary-container/10 hover:border-primary/20 group transition-all duration-300">
                    <span class="material-symbols-outlined text-primary p-2 bg-primary-container/10 rounded-lg group-hover:scale-110 transition-transform">receipt_long</span>
                    <div>
                        <p class="font-bold text-sm text-on-surface">Revenue Report</p>
                        <p class="text-[10px] text-on-surface-variant/60">Full CSV of all payment records</p>
                    </div>
                </a>

                <div @click="showScoreModal = true" class="flex items-center gap-4 p-4 rounded-xl border border-outline-variant/20 hover:bg-primary-container/10 hover:border-primary/20 group transition-all duration-300 cursor-pointer">
                    <span class="material-symbols-outlined text-primary p-2 bg-primary-container/10 rounded-lg group-hover:scale-110 transition-transform">add_circle</span>
                    <div>
                        <p class="font-bold text-sm text-on-surface">Add Student Score</p>
                        <p class="text-[10px] text-on-surface-variant/60">Manually enter exam marks for a student</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Results Ledger -->
        <div class="glass-card rounded-xl overflow-hidden border border-outline-variant/10">
            <div class="p-8 border-b border-outline-variant/10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h3 class="text-xl font-bold text-primary">Student Result Ledger</h3>
                    <p class="text-sm text-on-surface-variant/70">View TMA scores and overall academic performance per student.</p>
                </div>
                <!-- Filter Tabs -->
                <div class="flex p-1 bg-surface-container-low rounded-xl gap-1 font-semibold">
                    <button @click="filterResult = 'all'" :class="filterResult === 'all' ? 'bg-white shadow-sm text-primary' : 'text-on-surface-variant/70 hover:bg-white/50'" class="px-4 py-2 text-xs font-bold rounded-lg transition-all">All Students</button>
                    <button @click="filterResult = 'pass'" :class="filterResult === 'pass' ? 'bg-white shadow-sm text-primary' : 'text-on-surface-variant/70 hover:bg-white/50'" class="px-4 py-2 text-xs font-bold rounded-lg transition-all">Passed</button>
                    <button @click="filterResult = 'fail'" :class="filterResult === 'fail' ? 'bg-white shadow-sm text-error' : 'text-on-surface-variant/70 hover:bg-white/50'" class="px-4 py-2 text-xs font-bold rounded-lg transition-all">Failed</button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-surface-container-low/30">
                        <tr class="border-b border-outline-variant/10">
                            <th class="px-8 py-4 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/60">Student</th>
                            <th class="px-8 py-4 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/60">Enrollment No.</th>
                            <th class="px-8 py-4 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/60">Course Level</th>
                            <th class="px-8 py-4 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/60">TMA Score</th>
                            <th class="px-8 py-4 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/60">Status</th>
                            <th class="px-8 py-4 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/60 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/5">
                        @forelse($students as $student)
                        @php
                            $tmaScore = $student->tmaSubmissions->whereNotNull('tma_marks')->avg('tma_marks');
                            $tmaScore = $tmaScore ? round($tmaScore, 1) : null;
                            $status = $tmaScore !== null ? ($tmaScore >= 33 ? 'pass' : 'fail') : 'pending';
                            $courseLevel = $student->admissions->first()?->course_type ?? 'N/A';
                        @endphp
                        <tr
                            x-show="filterResult === 'all' || filterResult === '{{ $status }}'"
                            class="group hover:bg-surface-container-low/40 transition-colors"
                        >
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-primary-container/20 flex items-center justify-center text-[11px] font-bold text-primary shrink-0">
                                        {{ strtoupper(substr($student->name ?? 'ST', 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-on-surface">{{ $student->name }}</p>
                                        <p class="text-[10px] text-on-surface-variant/50">{{ $student->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-sm font-semibold text-on-surface font-mono">{{ $student->enrollment_number ?? '—' }}</p>
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-sm text-on-surface-variant/80 font-medium">{{ $courseLevel }}</p>
                            </td>
                            <td class="px-8 py-5">
                                @if($tmaScore !== null)
                                    <div class="flex items-center gap-2">
                                        <div class="w-20 h-1.5 bg-surface-container rounded-full overflow-hidden">
                                            <div class="h-full rounded-full {{ $tmaScore >= 33 ? 'bg-green-500' : 'bg-red-400' }}" style="width: {{ min($tmaScore, 100) }}%;"></div>
                                        </div>
                                        <span class="text-sm font-bold">{{ $tmaScore }}<span class="text-[10px] text-on-surface-variant/50 font-normal">/100</span></span>
                                    </div>
                                @else
                                    <span class="text-sm text-on-surface-variant/40 italic">No data</span>
                                @endif
                            </td>
                            <td class="px-8 py-5">
                                @if($status === 'pass')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full result-badge-pass text-[10px] font-bold uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Pass
                                    </span>
                                @elseif($status === 'fail')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full result-badge-fail text-[10px] font-bold uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>Fail
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full result-badge-pending text-[10px] font-bold uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="openUploadMarksheetModal({{ $student->id }}, '{{ addslashes($student->name) }}')" class="p-2 rounded-lg bg-primary/10 text-primary hover:bg-primary hover:text-white transition-colors" title="Upload Marksheet">
                                        <span class="material-symbols-outlined text-lg">upload_file</span>
                                    </button>
                                    <button @click="sendResultNotification('{{ addslashes($student->name) }}')" class="p-2 rounded-lg bg-surface-container-high/60 text-on-surface-variant hover:bg-primary-container/20 hover:text-primary transition-colors" title="Send Result Notification">
                                        <span class="material-symbols-outlined text-lg">notifications_active</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <!-- Placeholder row when no students -->
                        <tr class="group hover:bg-surface-container-low/40 transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-primary-container/20 flex items-center justify-center text-[11px] font-bold text-primary">JD</div>
                                    <div>
                                        <p class="text-sm font-bold">Johnathan Doe</p>
                                        <p class="text-[10px] text-on-surface-variant/50">john.doe@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5"><p class="text-sm font-mono font-semibold">BS-10294</p></td>
                            <td class="px-8 py-5"><p class="text-sm text-on-surface-variant/80">Senior Secondary (12th)</p></td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-20 h-1.5 bg-surface-container rounded-full overflow-hidden">
                                        <div class="h-full rounded-full bg-green-500" style="width: 72%;"></div>
                                    </div>
                                    <span class="text-sm font-bold">72<span class="text-[10px] text-on-surface-variant/50 font-normal">/100</span></span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full result-badge-pass text-[10px] font-bold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Pass
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <button class="text-primary hover:underline text-xs font-bold">View Details</button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ==================== PUBLISH RESULT CONFIRMATION MODAL ==================== -->
        <div x-show="isPublishConfirmOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div @click="isPublishConfirmOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div class="glass-card w-full max-w-md bg-white p-8 rounded-2xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface">
                <div class="flex flex-col items-center text-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-3xl text-primary" style="font-variation-settings: 'FILL' 1;">grade</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold font-display text-primary">Confirm Result Publication</h3>
                        <p class="text-sm text-on-surface-variant mt-2">You're about to publish <strong x-text="pubExamName"></strong> results. All students will be notified immediately.</p>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/10">
                    <button @click="isPublishConfirmOpen = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl border border-slate-200">Cancel</button>
                    <button @click="confirmPublish()" class="px-5 py-2.5 cyan-glow-button text-on-primary text-xs font-bold rounded-xl">Publish Now</button>
                </div>
            </div>
        </div>

        <!-- ==================== UPLOAD MARKSHEET MODAL ==================== -->
        <div x-show="showUploadMarksheetModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div @click="showUploadMarksheetModal = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div class="glass-card w-full max-w-lg bg-white p-8 rounded-2xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-bold font-display text-primary">Upload Student Marksheet</h3>
                        <p class="text-xs text-on-surface-variant mt-1" x-text="marksheetStudentName ? 'Candidate: ' + marksheetStudentName : 'Upload marksheet for student'"></p>
                    </div>
                    <button @click="showUploadMarksheetModal = false" class="material-symbols-outlined text-slate-400 hover:text-slate-800">close</button>
                </div>
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Marksheet Document (PDF)</label>
                        <label class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-outline-variant/30 bg-slate-50 hover:bg-slate-100 rounded-xl cursor-pointer transition-colors group">
                            <span class="material-symbols-outlined text-3xl text-outline mb-2 group-hover:scale-110 duration-200">upload_file</span>
                            <span class="text-xs font-bold text-slate-600" x-text="marksheetFileName || 'Choose PDF File'"></span>
                            <input type="file" ref="marksheetFile" class="hidden" accept=".pdf" @change="marksheetFileName = $refs.marksheetFile.files[0]?.name || ''"/>
                        </label>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Subject / Exam Level</label>
                        <input type="text" x-model="marksheetSubject" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold" placeholder="e.g. Class 10th - October 2026"/>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/10">
                        <button @click="showUploadMarksheetModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl border border-slate-200">Cancel</button>
                        <button @click="saveMarksheet()" class="px-5 py-2.5 cyan-glow-button text-on-primary text-xs font-bold rounded-xl flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">cloud_upload</span>
                            Upload Marksheet
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('resultManager', () => ({
                filterResult: 'all',

                // Publish Result form
                pubExamName: '',
                pubLink: '',
                pubNotes: '',
                isPublishConfirmOpen: false,

                // Marksheet Modal
                showUploadMarksheetModal: false,
                marksheetStudentId: null,
                marksheetStudentName: '',
                marksheetFileName: '',
                marksheetSubject: '',

                publishResult() {
                    if (!this.pubExamName || !this.pubLink) {
                        alert('Please fill in the Exam Name and Result URL before publishing.');
                        return;
                    }
                    this.isPublishConfirmOpen = true;
                },

                confirmPublish() {
                    const body = {
                        exam_name: this.pubExamName,
                        link: this.pubLink,
                        notes: this.pubNotes,
                    };
                    fetch('{{ route("admin.results.publish") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(body)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message || 'Result published and students notified!');
                            this.isPublishConfirmOpen = false;
                            this.pubExamName = '';
                            this.pubLink = '';
                            this.pubNotes = '';
                        } else {
                            alert('Error publishing result. Please try again.');
                        }
                    })
                    .catch(() => alert('Network error. Please try again.'));
                },

                openUploadMarksheetModal(studentId, studentName) {
                    this.marksheetStudentId = studentId;
                    this.marksheetStudentName = studentName;
                    this.marksheetFileName = '';
                    this.marksheetSubject = '';
                    if (this.$refs.marksheetFile) {
                        this.$refs.marksheetFile.value = '';
                    }
                    this.showUploadMarksheetModal = true;
                },

                saveMarksheet() {
                    if (!this.marksheetFileName) {
                        alert('Please select a PDF marksheet file to upload.');
                        return;
                    }
                    alert(`Marksheet uploaded for ${this.marksheetStudentName} successfully!`);
                    this.showUploadMarksheetModal = false;
                },

                sendResultNotification(studentName) {
                    alert('Result notification dispatched to: ' + studentName);
                }
            }));

            // Parallax blobs
            window.addEventListener('mousemove', (e) => {
                const blob1 = document.getElementById('blob1');
                const blob2 = document.getElementById('blob2');
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;
                if (blob1) blob1.style.transform = `translate(${x * 20}px, ${y * 20}px)`;
                if (blob2) blob2.style.transform = `translate(${x * 40}px, ${y * 40}px)`;
            });
        });
    </script>
</x-admin-layout>
