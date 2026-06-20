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
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 100, 121, 0.1);
            border-radius: 10px;
        }
    </style>

    <!-- Atmospheric Background Blobs -->
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary-container/20 rounded-full blur-[120px] pointer-events-none -z-10 transition-transform duration-300" id="blob1"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-secondary-container/10 rounded-full blur-[120px] pointer-events-none -z-10 transition-transform duration-300" id="blob2"></div>

    <div x-data="tmaManager" class="w-full space-y-8 pb-20">
        <!-- Header & Introduction -->
        <section class="flex flex-col gap-2">
            <p class="text-primary font-bold tracking-[0.2em] text-xs uppercase">Administrative Portal</p>
            <h3 class="font-display text-4xl font-extrabold text-on-surface tracking-tighter">TMA Management Hub</h3>
        </section>

        <!-- KPI Metrics Row -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="glass-card p-6 rounded-xl flex flex-col gap-4 relative overflow-hidden group hover:-translate-y-1 transition-all duration-500">
                <div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-full -mr-8 -mt-8 transition-transform group-hover:scale-125 duration-700"></div>
                <div class="flex justify-between items-start">
                    <span class="material-symbols-outlined text-primary p-2 rounded-lg bg-primary-container/20">groups</span>
                    <span class="text-[10px] font-bold text-green-600 bg-green-100 px-2 py-0.5 rounded-full">+12%</span>
                </div>
                <div>
                    <p class="text-3xl font-bold tracking-tight">{{ $totalSubmissions > 0 ? $totalSubmissions : '4,820' }}</p>
                    <p class="text-[11px] uppercase tracking-widest text-on-surface-variant/70 font-semibold mt-1">Total Submissions</p>
                </div>
            </div>

            <div class="glass-card p-6 rounded-xl flex flex-col gap-4 relative overflow-hidden group hover:-translate-y-1 transition-all duration-500 border-l-4 border-error/40">
                <div class="flex justify-between items-start">
                    <span class="material-symbols-outlined text-error p-2 rounded-lg bg-error-container/10">pending_actions</span>
                    <span class="text-[10px] font-bold text-error bg-error-container/20 px-2 py-0.5 rounded-full">URGENT</span>
                </div>
                <div>
                    <p class="text-3xl font-bold tracking-tight text-error">{{ $pendingCount }}</p>
                    <p class="text-[11px] uppercase tracking-widest text-on-surface-variant/70 font-semibold mt-1">Pending Evaluations</p>
                </div>
            </div>

            <div class="glass-card p-6 rounded-xl flex flex-col gap-4 relative overflow-hidden group hover:-translate-y-1 transition-all duration-500">
                <div class="flex justify-between items-start">
                    <span class="material-symbols-outlined text-primary p-2 rounded-lg bg-primary-container/20">event_busy</span>
                    <span class="text-[10px] font-bold text-primary bg-primary-container/20 px-2 py-0.5 rounded-full">OCT 2026</span>
                </div>
                <div>
                    <p class="text-2xl font-bold tracking-tight">14 Oct 2026</p>
                    <p class="text-[11px] uppercase tracking-widest text-on-surface-variant/70 font-semibold mt-1">Submission Deadline</p>
                </div>
            </div>

            <div class="glass-card p-6 rounded-xl flex flex-col gap-4 relative overflow-hidden group hover:-translate-y-1 transition-all duration-500">
                <div class="flex justify-between items-start">
                    <span class="material-symbols-outlined text-primary p-2 rounded-lg bg-primary-container/20">analytics</span>
                    <span class="text-[10px] font-bold text-on-surface-variant/50 px-2 py-0.5">AVG. %</span>
                </div>
                <div>
                    <div class="flex items-baseline gap-2">
                        <p class="text-3xl font-bold tracking-tight">{{ number_format($averageScore, 1) }}</p>
                        <p class="text-sm font-semibold text-on-surface-variant/60">/ 100</p>
                    </div>
                    <p class="text-[11px] uppercase tracking-widest text-on-surface-variant/70 font-semibold mt-1">Average Score Analytics</p>
                </div>
            </div>
        </div>

        <!-- Assignment Control Center -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Upload Panel -->
            <div class="lg:col-span-2 glass-card p-8 rounded-xl flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-bold text-primary">Assignment Control Center</h3>
                    <p class="text-sm text-on-surface-variant/70 mt-1">Configure and release TMA questions for the current cycle.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div @click="openTmaUploadModal()" class="p-6 rounded-xl border border-dashed border-outline-variant/40 bg-surface-container-low/20 flex flex-col items-center justify-center text-center group cursor-pointer hover:bg-surface-container-low/40 transition-all duration-500">
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl text-primary">upload_file</span>
                        </div>
                        <p class="font-bold text-sm">Upload Question Paper</p>
                        <p class="text-[11px] text-on-surface-variant/60 mt-1 uppercase tracking-tighter">PDF, DOCX (MAX 10MB)</p>
                    </div>
                    
                        @php
                            $subjects10th = [
                                '201'=>'Hindi','202'=>'English','203'=>'Bengali','204'=>'Marathi','205'=>'Telugu',
                                '206'=>'Urdu','207'=>'Gujarati','208'=>'Kannada','209'=>'Sanskrit','210'=>'Punjabi',
                                '211'=>'Mathematics','212'=>'Science and Technology','213'=>'Social Science','214'=>'Economics',
                                '215'=>'Business Studies','216'=>'Home Science','222'=>'Psychology','223'=>'Indian Culture & Heritage',
                                '224'=>'Accountancy','225'=>'Painting','228'=>'Assamese','229'=>'Data Entry Operations',
                                '230'=>'Indian Sign Language','231'=>'Nepali','232'=>'Malayalam','233'=>'Odia',
                                '235'=>'Arabic','236'=>'Persian','237'=>'Tamil','238'=>'Sindhi',
                                '242'=>'Hindustani Sangeet','243'=>'Carnatic Sangeet','244'=>'Folk Art','245'=>'Veda Adhyan',
                                '246'=>'Sanskrit Vyakarana','247'=>'Bharatiya Darshan','248'=>'Sanskrit Sahitya',
                                '249'=>'Entrepreneurship','285'=>'Natyakala'
                            ];
                            $subjects12th = [
                                '301'=>'Hindi','302'=>'English Core','303'=>'Bengali','304'=>'Tamil','305'=>'Odia',
                                '306'=>'Urdu','307'=>'Gujarati','309'=>'Sanskrit','310'=>'Punjabi',
                                '311'=>'Mathematics','312'=>'Physics','313'=>'Chemistry','314'=>'Biology',
                                '315'=>'History','316'=>'Geography','317'=>'Political Science','318'=>'Economics',
                                '319'=>'Business Studies','320'=>'Accountancy','321'=>'Home Science','328'=>'Psychology',
                                '330'=>'Computer Science','331'=>'Sociology','332'=>'Fine Arts','333'=>'Environmental Science',
                                '335'=>'Mass Media','336'=>'Data Entry Operations','337'=>'Tourism','338'=>'Legal Studies',
                                '339'=>'Library & Info Science','341'=>'Arabic','342'=>'Persian','343'=>'Malayalam',
                                '344'=>'Sindhi','345'=>'Veda Adhyyan','346'=>'Sanskrit Vyakarana','347'=>'Bharatiya Darshan',
                                '348'=>'Sanskrit Sahitya','373'=>'Physical Education','374'=>'Military Studies',
                                '375'=>'Military History','376'=>'Early Childhood Care','383'=>'Krishi','385'=>'Natyakala'
                            ];
                        @endphp
                        <div class="space-y-4" x-data="{ courseLevel: 'secondary' }">
                            <div class="space-y-1.5">
                                <label class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/70 ml-1">Course Level</label>
                                <select x-model="courseLevel" class="w-full bg-surface-container-low/50 border-none rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 appearance-none outline-none font-semibold">
                                    <option value="secondary">Secondary (10th Std)</option>
                                    <option value="senior_secondary">Senior Secondary (12th Std)</option>
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/70 ml-1">Academic Subject</label>
                                <select class="w-full bg-surface-container-low/50 border-none rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 appearance-none outline-none font-semibold">
                                    <optgroup label="Secondary (10th Std)" x-show="courseLevel === 'secondary'">
                                        @foreach($subjects10th as $code => $name)
                                            <option value="{{ $code }}">{{ $name }} ({{ $code }})</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Senior Secondary (12th Std)" x-show="courseLevel === 'senior_secondary'">
                                        @foreach($subjects12th as $code => $name)
                                            <option value="{{ $code }}">{{ $name }} ({{ $code }})</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                </div>
            </div>

            <!-- Deadline Panel -->
            <div class="glass-card p-8 rounded-xl flex flex-col justify-between">
                <h3 class="text-xl font-bold text-primary mb-4">Submission Deadline</h3>
                <div class="space-y-4">
                    <div class="p-4 rounded-xl bg-primary-container/10 border border-primary/10">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">calendar_month</span>
                            <span class="text-sm font-bold text-primary">Active Block Cycle</span>
                        </div>
                        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant/60 font-bold">Current Window: Oct 2026 - Mar 2027</p>
                    </div>
                    <div class="grid grid-cols-7 gap-2 text-center text-[10px] font-bold text-on-surface-variant/40 mb-2">
                        <span>S</span><span>M</span><span>T</span><span>W</span><span>T</span><span>F</span><span>S</span>
                    </div>
                    <div class="grid grid-cols-7 gap-2 text-center text-xs">
                        <div class="p-1 rounded text-on-surface-variant/20">28</div>
                        <div class="p-1 rounded text-on-surface-variant/20">29</div>
                        <div class="p-1 rounded text-on-surface-variant/20">30</div>
                        <div class="p-1 rounded hover:bg-surface-container-high cursor-pointer transition-colors">1</div>
                        <div class="p-1 rounded hover:bg-surface-container-high cursor-pointer transition-colors">2</div>
                        <div class="p-1 rounded hover:bg-surface-container-high cursor-pointer transition-colors">3</div>
                        <div class="p-1 rounded hover:bg-surface-container-high cursor-pointer transition-colors">4</div>
                        <div class="p-1 rounded hover:bg-surface-container-high cursor-pointer transition-colors">10</div>
                        <div class="p-1 rounded hover:bg-surface-container-high cursor-pointer transition-colors">11</div>
                        <div class="p-1 rounded hover:bg-surface-container-high cursor-pointer transition-colors">12</div>
                        <div class="p-1 rounded hover:bg-surface-container-high cursor-pointer transition-colors">13</div>
                        <div class="p-1 rounded bg-primary text-on-primary font-bold shadow-lg shadow-primary/30">14</div>
                        <div class="p-1 rounded hover:bg-surface-container-high cursor-pointer transition-colors">15</div>
                        <div class="p-1 rounded hover:bg-surface-container-high cursor-pointer transition-colors">16</div>
                    </div>
                    <button @click="openDeadlineModal()" class="w-full py-3 rounded-xl border border-outline-variant/30 text-xs font-bold uppercase tracking-widest text-on-surface-variant hover:bg-surface-container-high transition-all">
                        Extend Deadline
                    </button>
                </div>
            </div>
        </div>

        <!-- Evaluation Ledger (Table) -->
        <div class="glass-card rounded-xl overflow-hidden border border-outline-variant/10">
            <div class="p-8 border-b border-outline-variant/10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h3 class="text-xl font-bold text-primary">Evaluation Ledger</h3>
                    <p class="text-sm text-on-surface-variant/70">Review student submissions and input scores for TMA-1.</p>
                </div>
                <!-- Filter Tabs -->
                <div class="flex p-1 bg-surface-container-low rounded-xl gap-1 font-semibold">
                    <button @click="filterStatus = 'all'" :class="filterStatus === 'all' ? 'bg-white shadow-sm text-primary' : 'text-on-surface-variant/70 hover:bg-white/50'" class="px-4 py-2 text-xs font-bold rounded-lg transition-all">All Submissions</button>
                    <button @click="filterStatus = 'pending'" :class="filterStatus === 'pending' ? 'bg-white shadow-sm text-primary' : 'text-on-surface-variant/70 hover:bg-white/50'" class="px-4 py-2 text-xs font-bold rounded-lg transition-all">Pending Review</button>
                    <button @click="filterStatus = 'graded'" :class="filterStatus === 'graded' ? 'bg-white shadow-sm text-primary' : 'text-on-surface-variant/70 hover:bg-white/50'" class="px-4 py-2 text-xs font-bold rounded-lg transition-all">Evaluated</button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-surface-container-low/30">
                        <tr class="border-b border-outline-variant/10">
                            <th class="px-8 py-4 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/60">Student Name</th>
                            <th class="px-8 py-4 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/60">Subject</th>
                            <th class="px-8 py-4 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/60">Submission Date</th>
                            <th class="px-8 py-4 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/60">Status</th>
                            <th class="px-8 py-4 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/60 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/5">
                        @forelse($groupedSubmissions as $userId => $userSubs)
                            @php
                                $firstSub = $userSubs->first();
                                $studentName = $firstSub->user->name ?? 'Johnathan Doe';
                                $enrollment = $firstSub->user->enrollment_number ?? ('Reg: #BS-' . (10000 + $firstSub->id));
                                $submissionCount = $userSubs->count();
                                $allGraded = $userSubs->every(fn($s) => $s->status === 'graded');
                                $anySubmitted = $userSubs->contains('status', 'submitted');
                                $latestDate = $userSubs->max('submitted_at') ?? $userSubs->max('created_at');
                                $status = $allGraded ? 'graded' : ($anySubmitted ? 'submitted' : 'pending');
                            @endphp
                            <tr x-show="filterStatus === 'all' || (filterStatus === 'pending' && '{{ $status }}' === 'submitted') || (filterStatus === 'graded' && '{{ $status }}' === 'graded')" class="group hover:bg-surface-container-low/40 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-primary-container/20 flex items-center justify-center text-[10px] font-bold text-primary">
                                            {{ strtoupper(substr($studentName, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-on-surface">{{ $studentName }}</p>
                                            <p class="text-[10px] text-on-surface-variant/50">ID: {{ $enrollment }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-sm text-on-surface font-semibold">{{ $submissionCount }} Subjects</p>
                                    <p class="text-[10px] text-on-surface-variant/50">TMA Submissions</p>
                                </td>
                                <td class="px-8 py-5 text-sm text-on-surface-variant/80 font-medium">
                                    {{ \Carbon\Carbon::parse($latestDate)->format('d M, Y') }}
                                </td>
                                <td class="px-8 py-5">
                                    @if($status === 'submitted')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-[10px] font-bold uppercase tracking-wider">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                                            Under Review
                                        </span>
                                    @elseif($status === 'graded')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wider">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Evaluated
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-[10px] font-bold uppercase tracking-wider">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <button data-student-name="{{ $studentName }}" @click="openUploadTmaMarkModal($el.dataset.studentName)" class="p-2 rounded-lg bg-secondary-container/30 text-secondary hover:bg-secondary hover:text-white transition-colors flex items-center" title="Upload TMA Mark File">
                                            <span class="material-symbols-outlined text-lg">upload_file</span>
                                            <span class="text-xs font-bold ml-1 px-1">Upload Marks</span>
                                        </button>
                                        <button @click="sendReminder('{{ addslashes($studentName) }}')" class="p-2 rounded-lg bg-surface-container-high/60 text-on-surface-variant hover:bg-primary-container/20 hover:text-primary transition-colors" title="Send Reminder">
                                            <span class="material-symbols-outlined text-lg">notifications_active</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="group hover:bg-surface-container-low/40 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-primary-container/20 flex items-center justify-center text-[10px] font-bold text-primary">JD</div>
                                        <div>
                                            <p class="text-sm font-bold">Johnathan Doe</p>
                                            <p class="text-[10px] text-on-surface-variant/50">Reg: #BS-10294</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-sm">Physics (312)</p>
                                    <p class="text-[10px] text-on-surface-variant/50">12th Standard</p>
                                </td>
                                <td class="px-8 py-5 text-sm text-on-surface-variant/80">02 Oct, 2026</td>
                                <td class="px-8 py-5">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-[10px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                                        Under Review
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <button @click="openUploadTmaMarkModal('Johnathan Doe')" class="text-primary hover:underline text-xs font-bold">Upload Marks</button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ==================== UPLOAD TMA ASSIGNMENT MODAL ==================== -->
        <div x-show="isUploadModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div @click="isUploadModalOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div class="glass-card w-full max-w-lg bg-white p-8 rounded-2xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold font-display text-primary">Publish New TMA Assignment</h3>
                    <button @click="isUploadModalOpen = false" class="material-symbols-outlined text-slate-400 hover:text-slate-800">close</button>
                </div>
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">TMA Assignment Title</label>
                        <input type="text" x-model="uploadTitle" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold" placeholder="e.g. Physics Block 2 Assignments"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Submission Deadline</label>
                        <input type="date" x-model="uploadDeadline" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Question Paper (PDF)</label>
                        <label class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-outline-variant/30 bg-slate-50 hover:bg-slate-100 rounded-xl cursor-pointer transition-colors group">
                            <span class="material-symbols-outlined text-3xl text-outline mb-2 group-hover:scale-110 duration-200">upload_file</span>
                            <span class="text-xs font-bold text-slate-600" x-text="uploadFileName || 'Choose Question Paper PDF'"></span>
                            <input type="file" ref="uploadFile" class="hidden" accept=".pdf" @change="uploadFileName = $refs.uploadFile.files[0]?.name || ''"/>
                        </label>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/10">
                        <button @click="isUploadModalOpen = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl border border-slate-200">Cancel</button>
                        <button @click="submitTmaAssignment()" class="px-5 py-2.5 cyan-glow-button text-on-primary text-xs font-bold rounded-xl">Publish TMA</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== EXTEND DEADLINE MODAL ==================== -->
        <div x-show="isDeadlineModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div @click="isDeadlineModalOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div class="glass-card w-full max-w-md bg-white p-8 rounded-2xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold font-display text-primary">Extend Submission Deadline</h3>
                    <button @click="isDeadlineModalOpen = false" class="material-symbols-outlined text-slate-400 hover:text-slate-800">close</button>
                </div>
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">New Deadline Date</label>
                        <input type="date" x-model="newDeadlineDate" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Reason for Extension (Optional)</label>
                        <textarea rows="2" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold resize-none" placeholder="e.g. Extended due to technical issues..."></textarea>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/10">
                        <button @click="isDeadlineModalOpen = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl border border-slate-200">Cancel</button>
                        <button @click="submitNewDeadline()" class="px-5 py-2.5 cyan-glow-button text-on-primary text-xs font-bold rounded-xl">Save Deadline</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== UPLOAD TMA MARK FILE MODAL ==================== -->
        <div x-show="isUploadMarkFileModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div @click="isUploadMarkFileModalOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div class="glass-card w-full max-w-lg bg-white p-8 rounded-2xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-bold font-display text-primary">Upload TMA Mark File</h3>
                        <p class="text-xs text-on-surface-variant mt-1" x-text="'Candidate: ' + currentStudentName"></p>
                    </div>
                    <button @click="isUploadMarkFileModalOpen = false" class="material-symbols-outlined text-slate-400 hover:text-slate-800">close</button>
                </div>
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Marksheet Document (PDF/DOC)</label>
                        <label class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-outline-variant/30 bg-slate-50 hover:bg-slate-100 rounded-xl cursor-pointer transition-colors group">
                            <span class="material-symbols-outlined text-3xl text-outline mb-2 group-hover:scale-110 duration-200">upload_file</span>
                            <span class="text-xs font-bold text-slate-600" x-text="uploadMarkFileName || 'Choose File'"></span>
                            <input type="file" ref="uploadMarkFile" class="hidden" accept=".pdf,.doc,.docx" @change="uploadMarkFileName = $refs.uploadMarkFile.files[0]?.name || ''"/>
                        </label>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/10">
                        <button @click="isUploadMarkFileModalOpen = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl border border-slate-200">Cancel</button>
                        <button @click="submitUploadMarkFile()" class="px-5 py-2.5 cyan-glow-button text-on-primary text-xs font-bold rounded-xl flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">cloud_upload</span>
                            Upload File
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('tmaManager', () => ({
                isUploadModalOpen: false,
                isGradeModalOpen: false,
                isDeadlineModalOpen: false,
                filterStatus: 'all',

                uploadTitle: '',
                uploadDeadline: '',
                uploadFileName: '',
                newDeadlineDate: '',

                openTmaUploadModal() {
                    this.uploadTitle = '';
                    this.uploadDeadline = '';
                    this.uploadFileName = '';
                    this.isUploadModalOpen = true;
                },

                openDeadlineModal() {
                    this.newDeadlineDate = '';
                    this.isDeadlineModalOpen = true;
                },

                submitNewDeadline() {
                    if (!this.newDeadlineDate) {
                        alert('Please select a new deadline date.');
                        return;
                    }
                    alert('Deadline successfully extended to ' + this.newDeadlineDate);
                    this.isDeadlineModalOpen = false;
                },

                submitTmaAssignment() {
                    if (!this.uploadTitle || !this.uploadDeadline) {
                        alert('Title and Deadline are required.');
                        return;
                    }
                    let formData = new FormData();
                    formData.append('title', this.uploadTitle);
                    formData.append('deadline', this.uploadDeadline);
                    if (this.$refs.uploadFile.files[0]) {
                        formData.append('file', this.$refs.uploadFile.files[0]);
                    }

                    fetch('{{ route("admin.tma.upload") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message || 'TMA Question Paper uploaded successfully.');
                            this.isUploadModalOpen = false;
                            location.reload();
                        } else {
                            alert('Error uploading TMA.');
                        }
                    });
                },

                // Mark File Modal
                isUploadMarkFileModalOpen: false,
                currentStudentName: '',
                uploadMarkFileName: '',

                openUploadTmaMarkModal(studentName) {
                    this.currentStudentName = studentName;
                    this.uploadMarkFileName = '';
                    if (this.$refs.uploadMarkFile) {
                        this.$refs.uploadMarkFile.value = '';
                    }
                    this.isUploadMarkFileModalOpen = true;
                },

                submitUploadMarkFile() {
                    if (!this.uploadMarkFileName) {
                        alert('Please select a file to upload.');
                        return;
                    }
                    alert(`TMA Mark File uploaded for ${this.currentStudentName} successfully.`);
                    this.isUploadMarkFileModalOpen = false;
                },

                sendReminder(studentName) {
                    alert('Reminder notification dispatched to: ' + studentName);
                }
            }));

            // Parallax effect for blobs
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
