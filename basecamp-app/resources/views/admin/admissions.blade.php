<x-admin-layout>
    <!-- Inject Custom CSS and Tailwind configuration for this page -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-variant": "#d6dee1",
                        "primary": "#006479",
                        "tertiary-fixed": "#80b2ff",
                        "on-primary": "#e0f6ff",
                        "surface-dim": "#cdd6d9",
                        "surface-container-lowest": "#ffffff",
                        "inverse-on-surface": "#989ea0",
                        "outline": "#72787a",
                        "tertiary": "#005bae",
                        "error": "#b31b25",
                        "primary-fixed": "#40cef3",
                        "on-secondary-fixed-variant": "#005f6b",
                        "tertiary-container": "#80b2ff",
                        "surface-container-low": "#ecf2f4",
                        "on-tertiary": "#eff2ff",
                        "on-secondary-fixed": "#004049",
                        "surface-container-high": "#dce4e6",
                        "surface-container": "#e3e9ec",
                        "on-primary-fixed-variant": "#004a5a",
                        "tertiary-dim": "#004f98",
                        "surface": "#f2f7f9",
                        "surface-bright": "#f2f7f9",
                        "surface-tint": "#006479",
                        "error-dim": "#9f0519",
                        "secondary-fixed-dim": "#88d8e7",
                        "on-surface": "#2a3031",
                        "on-error": "#ffefee",
                        "primary-container": "#40cef3",
                        "secondary": "#006572",
                        "secondary-fixed": "#96e6f6",
                        "tertiary-fixed-dim": "#65a4ff",
                        "background": "#f2f7f9",
                        "on-secondary": "#d8f8ff",
                        "secondary-container": "#96e6f6",
                        "on-background": "#2a3031",
                        "on-tertiary-container": "#003061",
                        "surface-container-highest": "#d6dee1",
                        "outline-variant": "#a8aeb0",
                        "on-surface-variant": "#575c5e",
                        "on-primary-container": "#00414f",
                        "on-tertiary-fixed": "#001835",
                        "on-secondary-container": "#005560",
                        "on-primary-fixed": "#002a34",
                        "inverse-primary": "#40cef3",
                        "primary-dim": "#00576a",
                        "secondary-dim": "#005863",
                        "primary-fixed-dim": "#28c0e4",
                        "on-tertiary-fixed-variant": "#003971",
                        "error-container": "#fb5151",
                        "inverse-surface": "#0a0f11",
                        "on-error-container": "#570008"
                    },
                    "fontFamily": {
                        "headline": ["Space Grotesk"],
                        "display": ["Space Grotesk"],
                        "body": ["Space Grotesk"],
                        "label": ["Space Grotesk"]
                    }
                }
            }
        }
    </script>
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: transform 0.3s ease, background 0.3s ease;
        }
        .glass-card:hover {
            background: rgba(255, 255, 255, 0.8);
            transform: translateY(-2px);
        }
        .cyan-glow {
            box-shadow: 0 0 30px rgba(64, 206, 243, 0.15);
        }
        .active-nav-indicator {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 24px;
            background: #006479;
            border-radius: 4px 0 0 4px;
        }
    </style>

    @php
        // Prepare pending documents from all admissions
        $docKeys = [
            'photo' => 'Student Photo', 
            'signature' => 'Signature', 
            'idProof' => 'ID Proof', 
            'addressProof' => 'Address Proof', 
            'previousMarksheet' => 'Marksheet', 
            'categoryCertificate' => 'Category Certificate'
        ];
        
        $pendingDocs = [];
        foreach($admissions as $admission) {
            $docs = $admission->documents ?? [];
            foreach($docKeys as $key => $label) {
                if(!empty($docs[$key])) {
                    $statusKey = $key . '_status';
                    $status = $docs[$statusKey] ?? 'Pending';
                    if($status !== 'Approved' && $status !== 'Rejected') {
                        $pendingDocs[] = [
                            'admission_id' => $admission->id,
                            'student_name' => $admission->full_name,
                            'doc_key' => $key,
                            'doc_label' => $label,
                            'doc_path' => $docs[$key],
                        ];
                    }
                }
            }
        }
    @endphp

    <div x-data="admissionManager" class="relative w-full min-h-screen">
        <!-- Atmospheric Background Decorations -->
        <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-primary-container/20 rounded-full blur-[100px]"></div>
            <div class="absolute top-1/2 -left-20 w-80 h-80 bg-secondary-container/10 rounded-full blur-[120px]"></div>
            <div class="absolute -bottom-20 right-1/4 w-64 h-64 bg-tertiary-container/15 rounded-full blur-[80px]"></div>
        </div>

        <!-- Top App Bar Details -->
        <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-10">
            <div>
                <div class="flex items-center gap-3 text-primary/60 font-medium text-sm tracking-widest uppercase mb-2">
                    <span class="material-symbols-outlined text-sm">home</span>
                    <span class="">Dashboard</span>
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                    <span class="">Admissions</span>
                </div>
                <h2 class="font-display text-4xl font-bold text-primary leading-tight">Admission Management</h2>
                <p class="text-on-surface-variant text-sm mt-1">Manage enrollments, document verification, and NIOS status updates.</p>
            </div>
            
            <div class="flex items-center gap-4">
                <button @click="exportCSV()" class="flex items-center gap-2 px-5 py-3 rounded-xl border border-outline-variant/20 font-bold text-sm bg-white hover:bg-surface-container-low transition-colors text-on-surface">
                    <span class="material-symbols-outlined text-lg">download</span>
                    Export CSV
                </button>
                <a href="{{ route('admin.admissions.create') }}" class="flex items-center gap-2 px-6 py-3 rounded-xl bg-primary text-on-primary font-bold text-sm shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform active:scale-95">
                    <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">add</span>
                    Create New Student
                </a>
            </div>
        </header>

        <!-- Success Notifications -->
        @if(session('success'))
            <div class="mb-8 p-6 bg-emerald-50 border border-emerald-200 rounded-3xl text-emerald-900 shadow-md">
                <div class="flex items-start gap-4">
                    <span class="material-symbols-outlined text-emerald-600 text-3xl shrink-0">check_circle</span>
                    <div class="flex-grow">
                        <h4 class="font-extrabold text-lg mb-1">Success! Student Enrolled</h4>
                        <p class="text-sm font-medium opacity-90 leading-relaxed mb-4">
                            {{ session('success') }}
                        </p>
                        <div class="flex items-center gap-3">
                            <button onclick="navigator.clipboard.writeText('{{ session('success') }}').then(() => alert('Copied credentials!'))" class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">content_copy</span>
                                Copy Credentials
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Admission Workflow Section -->
        <section class="mb-12">
            <h3 class="text-label-md font-bold uppercase tracking-[0.2em] text-on-surface-variant/70 mb-6 font-display">Pipeline Workflow</h3>
            <div class="glass-panel rounded-3xl p-8 cyan-glow grid grid-cols-5 items-center gap-4 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10 -z-10">
                    <div class="w-full h-full" style="background-image: radial-gradient(circle at 2px 2px, #006479 1px, transparent 0); background-size: 32px 32px;"></div>
                </div>
                <!-- Workflow Node 1 -->
                <div class="flex flex-col items-center gap-3">
                    <div class="w-14 h-14 rounded-2xl bg-primary text-on-primary flex items-center justify-center shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined text-3xl">school</span>
                    </div>
                    <span class="text-sm font-bold">Student Portal</span>
                    <span class="text-[10px] text-center text-on-surface-variant uppercase tracking-tighter">Initial Inquiry &amp; Draft</span>
                </div>
                <div class="flex justify-center">
                    <span class="material-symbols-outlined text-primary-fixed-dim animate-pulse">trending_flat</span>
                </div>
                <!-- Workflow Node 2 -->
                <div class="flex flex-col items-center gap-3 scale-110">
                    <div class="w-16 h-16 rounded-2xl bg-white flex items-center justify-center shadow-xl shadow-black/5 border border-primary/20">
                        <span class="material-symbols-outlined text-primary text-4xl">verified_user</span>
                    </div>
                    <span class="text-sm font-bold text-primary">Basecamp Admin</span>
                    <span class="text-[10px] text-center text-on-surface-variant uppercase tracking-tighter">Verification &amp; Review</span>
                </div>
                <div class="flex justify-center">
                    <span class="material-symbols-outlined text-primary-fixed-dim animate-pulse">trending_flat</span>
                </div>
                <!-- Workflow Node 3 -->
                <div class="flex flex-col items-center gap-3">
                    <div class="w-14 h-14 rounded-2xl bg-surface-container-high flex items-center justify-center">
                        <span class="material-symbols-outlined text-3xl text-on-surface-variant">send</span>
                    </div>
                    <span class="text-sm font-bold">NIOS Portal</span>
                    <span class="text-[10px] text-center text-on-surface-variant uppercase tracking-tighter">Official Submission</span>
                </div>
                <!-- Connector Line Decoration (CSS-based) -->
                <div class="col-span-5 flex justify-center mt-6">
                    <div class="flex gap-4 items-center bg-surface-container-low/40 px-6 py-2 rounded-full border border-outline-variant/10">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                            <span class="text-[10px] font-bold uppercase tracking-wider">Status: Real-time Update</span>
                        </div>
                        <span class="material-symbols-outlined text-xs text-outline-variant">sync</span>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider">Return to Student Portal</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filters Section -->
        <section class="glass-panel p-4 rounded-2xl flex flex-wrap items-center gap-4 shadow-[0_20px_50px_rgba(0,0,0,0.02)] mb-8">
            <div class="flex-1 min-w-[280px]">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                    <input x-model="search" class="w-full pl-12 pr-4 py-3 bg-surface-container-low/50 border-none rounded-xl focus:ring-2 focus:ring-primary/40 text-body-md transition-all placeholder:text-on-surface-variant/50 text-on-surface" placeholder="Search applicant by name, email or reference ID..." type="text">
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <div class="relative">
                    <select x-model="streamFilter" class="appearance-none pl-4 pr-10 py-3 bg-surface-container-low/50 border-none rounded-xl focus:ring-2 focus:ring-primary/40 text-on-surface text-sm font-medium transition-all min-w-[150px]">
                        <option value="All">All Streams</option>
                        <option value="Medical">Medical</option>
                        <option value="Engineering">Engineering</option>
                        <option value="Foundation">Foundation</option>
                        <option value="Pending">Pending</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">expand_more</span>
                </div>
                <div class="relative">
                    <select x-model="gradeFilter" class="appearance-none pl-4 pr-10 py-3 bg-surface-container-low/50 border-none rounded-xl focus:ring-2 focus:ring-primary/40 text-on-surface text-sm font-medium transition-all min-w-[150px]">
                        <option value="All">All Grades</option>
                        <option value="10th">Standard 10</option>
                        <option value="12th">Standard 12</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">expand_more</span>
                </div>
                <div class="relative">
                    <select x-model="statusFilter" class="appearance-none pl-4 pr-10 py-3 bg-surface-container-low/50 border-none rounded-xl focus:ring-2 focus:ring-primary/40 text-on-surface text-sm font-medium transition-all min-w-[150px]">
                        <option value="All">All Statuses</option>
                        <option value="Pending">Pending Review</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Document Error">Document Error</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">expand_more</span>
                </div>
                <button @click="search = ''; streamFilter = 'All'; gradeFilter = 'All'; statusFilter = 'All';" class="p-3 bg-surface-container-low/50 hover:bg-surface-container-high rounded-xl text-on-surface-variant transition-colors flex items-center justify-center" title="Reset Filters">
                    <span class="material-symbols-outlined text-sm">tune</span>
                </button>
            </div>
        </section>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-12 gap-8 items-start mb-12">
            <!-- Active Applications Table -->
            <div class="col-span-12 xl:col-span-8">
                <div class="glass-panel rounded-3xl overflow-hidden shadow-2xl border border-outline-variant/10">
                    <div class="px-8 py-6 flex justify-between items-center border-b border-outline-variant/5 bg-white/40">
                        <h4 class="text-lg font-bold font-headline text-primary">Active Applications</h4>
                        <div class="flex gap-2">
                            <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-primary/10 text-primary uppercase">Total: {{ $admissions->count() }}</span>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-low/30 border-b border-outline-variant/10">
                                    <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant">Student Details</th>
                                    <th class="px-6 py-5 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant">Course / Standard</th>
                                    <th class="px-6 py-5 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant">Admission Status</th>
                                    <th class="px-6 py-5 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10 bg-white/20">
                                @forelse($admissions as $admission)
                                    @php
                                        // Initials & Colors
                                        $initials = '';
                                        if ($admission->full_name) {
                                            $words = explode(' ', $admission->full_name);
                                            foreach ($words as $w) {
                                                $initials .= substr($w, 0, 1);
                                            }
                                            $initials = strtoupper(substr($initials, 0, 2));
                                        } else {
                                            $initials = 'ST';
                                        }

                                        // Grade mapping
                                        $grade = 'Standard ' . ($admission->course_type === '10th' || $admission->course_type === 'Secondary' ? '10' : '12');
                                        
                                        // Stream mapping
                                        $stream = 'Pending';
                                        if ($admission->course_type === '10th' || $admission->course_type === 'Secondary') {
                                            $stream = 'Foundation';
                                        } elseif ($admission->course_type === '12th' || $admission->course_type === 'Senior Secondary') {
                                            $stream = ($admission->id % 2 === 0) ? 'Engineering' : 'Medical';
                                        }

                                        // Status Classes
                                        $statusClass = 'bg-primary-container/20 text-primary';
                                        $statusDot = 'bg-primary';
                                        $statusLabel = 'Pending Review';

                                        if ($admission->status === 'Approved') {
                                            $statusClass = 'bg-green-100 text-green-700';
                                            $statusDot = 'bg-green-500';
                                            $statusLabel = 'Approved';
                                        } elseif ($admission->status === 'Rejected') {
                                            $statusClass = 'bg-red-100 text-red-700';
                                            $statusDot = 'bg-red-500';
                                            $statusLabel = 'Rejected';
                                        } elseif ($admission->status === 'Document Error') {
                                            $statusClass = 'bg-orange-100 text-orange-700';
                                            $statusDot = 'bg-orange-500';
                                            $statusLabel = 'Document Error';
                                        }
                                    @endphp
                                    <tr 
                                        x-show="(search === '' || '{{ addslashes(strtolower($admission->full_name)) }}'.includes(search.toLowerCase()) || '{{ addslashes(strtolower($admission->email)) }}'.includes(search.toLowerCase()) || '{{ $admission->id }}'.includes(search.toLowerCase())) &&
                                                (streamFilter === 'All' || streamFilter === '{{ $stream }}') &&
                                                (gradeFilter === 'All' || gradeFilter === '{{ $admission->course_type === '10th' || $admission->course_type === 'Secondary' ? '10th' : '12th' }}') &&
                                                (statusFilter === 'All' || statusFilter === '{{ $admission->status }}')"
                                        class="hover:bg-surface-container-lowest/40 transition-colors group cursor-pointer"
                                    >
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-600 to-cyan-400 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                                    {{ $initials }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-on-surface">{{ $admission->full_name }}</p>
                                                    <p class="text-xs text-on-surface-variant font-medium">ID: #BC-{{ 9000 + $admission->id }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <p class="text-sm font-bold text-on-surface">{{ $grade }}</p>
                                            <p class="text-xs text-on-surface-variant font-medium">{{ $stream }}</p>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusClass }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $statusDot }}"></span>
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            <button 
                                                @click="
                                                    selectedAdmission = {
                                                        id: '{{ $admission->id }}',
                                                        name: '{{ addslashes($admission->full_name) }}',
                                                        email: '{{ addslashes($admission->email) }}',
                                                        phone: '{{ addslashes($admission->mobile_number) }}',
                                                        father: '{{ addslashes($admission->father_name) }}',
                                                        mother: '{{ addslashes($admission->mother_name) }}',
                                                        dob: '{{ $admission->date_of_birth ? $admission->date_of_birth->format('Y-m-d') : '' }}',
                                                        qualification: '{{ addslashes($admission->previous_qualification) }}',
                                                        address: '{{ addslashes($admission->address) }}',
                                                        documents: {{ json_encode($admission->documents) }}
                                                    };
                                                    isReviewModalOpen = true;
                                                "
                                                class="text-primary hover:underline font-bold text-xs"
                                            >
                                                Manage
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-24 text-center">
                                            <div class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center mb-6 mx-auto text-primary">
                                                <span class="material-symbols-outlined text-4xl">assignment</span>
                                            </div>
                                            <h3 class="text-2xl font-bold tracking-tight mb-2 text-primary">No Applications Found</h3>
                                            <p class="text-sm text-on-surface-variant max-w-md mx-auto">
                                                No admission forms match your query or filters.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-8 py-5 bg-surface-container-low/20 border-t border-outline-variant/10 text-center">
                        <span class="text-xs font-bold text-on-surface-variant">Showing 1 - {{ $admissions->count() }} of {{ $admissions->count() }} applicants</span>
                    </div>
                </div>
            </div>

            <!-- Document Verification Sidebar -->
            <div class="col-span-12 xl:col-span-4">
                <div class="glass-panel rounded-3xl p-6 shadow-2xl border border-outline-variant/10">
                    <div class="flex items-center justify-between mb-6 pb-3 border-b border-outline-variant/5">
                        <h4 class="text-lg font-bold font-headline text-primary">Quick Verification</h4>
                        <span class="text-[10px] font-bold bg-primary/10 text-primary px-2.5 py-1 rounded-md uppercase tracking-wider">Pending: {{ count($pendingDocs) }}</span>
                    </div>
                    <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-1">
                        @forelse(array_slice($pendingDocs, 0, 4) as $pdoc)
                            <div class="glass-card rounded-2xl p-4 flex flex-col gap-3 border border-white">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-primary-dim">
                                        <span class="material-symbols-outlined text-xl">badge</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold truncate text-on-surface">{{ $pdoc['doc_label'] }}</p>
                                        <p class="text-[10px] text-on-surface-variant uppercase tracking-tighter truncate">By {{ $pdoc['student_name'] }}</p>
                                    </div>
                                    <button @click="openDocPreview('/storage/{{ $pdoc['doc_path'] }}', '{{ $pdoc['doc_label'] }} ({{ $pdoc['student_name'] }})')" class="text-primary hover:text-primary-dim">
                                        <span class="material-symbols-outlined text-lg">open_in_new</span>
                                    </button>
                                </div>
                                <div class="flex gap-2">
                                    <button @click="verifyDocument({{ $pdoc['admission_id'] }}, '{{ $pdoc['doc_key'] }}', 'approve')" class="flex-1 py-2 rounded-lg bg-green-500/10 text-green-600 text-[10px] font-bold uppercase tracking-wider hover:bg-green-500/20 transition-colors">Approve</button>
                                    <button @click="verifyDocument({{ $pdoc['admission_id'] }}, '{{ $pdoc['doc_key'] }}', 'reject')" class="flex-1 py-2 rounded-lg bg-error/10 text-error text-[10px] font-bold uppercase tracking-wider hover:bg-error/20 transition-colors">Reject</button>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center text-on-surface-variant/60">
                                <span class="material-symbols-outlined text-3xl mb-2 block">task_alt</span>
                                <p class="text-xs font-bold">No Pending Documents</p>
                                <p class="text-[10px] mt-1 text-on-surface-variant/40">All uploaded documents are verified.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Review Modal -->
        <div x-show="isReviewModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <!-- Backdrop -->
            <div 
                x-show="isReviewModalOpen"
                @click="isReviewModalOpen = false"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
            ></div>
            
            <!-- Panel -->
            <div 
                x-show="isReviewModalOpen"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-10 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-10 scale-95"
                class="glass-card w-full max-w-2xl bg-white p-8 rounded-3xl border border-outline-variant/30 shadow-2xl relative z-10 overflow-y-auto max-h-[90vh] text-on-surface"
            >
                <div class="flex justify-between items-center mb-6 border-b border-outline-variant/10 pb-4">
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight text-primary">Admission Application Profile</h2>
                        <p class="text-xs text-on-surface-variant mt-1">Application ID: #<span x-text="selectedAdmission.id"></span></p>
                    </div>
                    <button @click="isReviewModalOpen = false" class="p-2 hover:bg-surface-container rounded-full text-on-surface-variant transition-colors flex items-center justify-center border border-transparent hover:border-outline-variant/20">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div>
                        <h3 class="text-sm font-extrabold tracking-widest text-primary uppercase mb-3 font-display">Student Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-surface-container-low/40 p-5 rounded-2xl border border-outline-variant/10">
                            <div>
                                <div class="text-[10px] uppercase font-bold text-on-surface-variant">Full Name</div>
                                <div class="text-sm font-semibold text-on-surface" x-text="selectedAdmission.name"></div>
                            </div>
                            <div>
                                <div class="text-[10px] uppercase font-bold text-on-surface-variant">Email Address</div>
                                <div class="text-sm font-semibold text-on-surface" x-text="selectedAdmission.email"></div>
                            </div>
                            <div>
                                <div class="text-[10px] uppercase font-bold text-on-surface-variant">Mobile Number</div>
                                <div class="text-sm font-semibold text-on-surface" x-text="selectedAdmission.phone"></div>
                            </div>
                            <div>
                                <div class="text-[10px] uppercase font-bold text-on-surface-variant">Date of Birth</div>
                                <div class="text-sm font-semibold text-on-surface" x-text="selectedAdmission.dob"></div>
                            </div>
                            <div>
                                <div class="text-[10px] uppercase font-bold text-on-surface-variant">Father's Name</div>
                                <div class="text-sm font-semibold text-on-surface" x-text="selectedAdmission.father"></div>
                            </div>
                            <div>
                                <div class="text-[10px] uppercase font-bold text-on-surface-variant">Mother's Name</div>
                                <div class="text-sm font-semibold text-on-surface" x-text="selectedAdmission.mother"></div>
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <div class="text-[10px] uppercase font-bold text-on-surface-variant">Previous Qualification</div>
                                <div class="text-sm font-semibold text-on-surface" x-text="selectedAdmission.qualification"></div>
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <div class="text-[10px] uppercase font-bold text-on-surface-variant">Home Address</div>
                                <div class="text-sm font-semibold text-on-surface" x-text="selectedAdmission.address"></div>
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <div class="text-[10px] uppercase font-bold text-on-surface-variant">Selected Subjects</div>
                                <div class="text-sm font-semibold text-on-surface" x-text="selectedAdmission.documents && selectedAdmission.documents.selectedSubjects ? selectedAdmission.documents.selectedSubjects.join(', ') : 'None Selected'"></div>
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <div class="text-[10px] uppercase font-bold text-on-surface-variant">Selected Study Center</div>
                                <div class="text-sm font-semibold text-on-surface" x-text="selectedAdmission.documents && selectedAdmission.documents.studyCentre ? (selectedAdmission.documents.studyCentreCountry + ' > ' + selectedAdmission.documents.studyCentreState + ' > ' + selectedAdmission.documents.studyCentreDistrict + ' > ' + selectedAdmission.documents.studyCentre) : 'None Selected'"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Uploaded Files -->
                    <div>
                        <h3 class="text-sm font-extrabold tracking-widest text-primary uppercase mb-3 font-display">Submitted Documents</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <!-- Photo -->
                            <template x-if="selectedAdmission.documents && selectedAdmission.documents.photo">
                                <div class="p-4 bg-surface-container rounded-xl border border-outline-variant/20 shadow-sm">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-primary text-sm">image</span>
                                            </div>
                                            <div class="text-xs font-bold text-on-surface">Student Photo</div>
                                        </div>
                                        <span class="text-[9px] font-bold uppercase px-2 py-0.5 rounded" :class="selectedAdmission.documents.photo_status === 'Approved' ? 'bg-green-100 text-green-700' : (selectedAdmission.documents.photo_status === 'Rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700')" x-text="selectedAdmission.documents.photo_status || 'Pending'"></span>
                                    </div>
                                    <div class="flex gap-2">
                                        <button @click="openDocPreview('/storage/' + selectedAdmission.documents.photo, 'Student Photo')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">visibility</span> Preview
                                        </button>
                                        <button @click="downloadDoc('/storage/' + selectedAdmission.documents.photo, 'student_photo')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-high hover:bg-outline-variant/20 text-on-surface text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">download</span> Download
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <!-- Signature -->
                            <template x-if="selectedAdmission.documents && selectedAdmission.documents.signature">
                                <div class="p-4 bg-surface-container rounded-xl border border-outline-variant/20 shadow-sm">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-primary text-sm">draw</span>
                                            </div>
                                            <div class="text-xs font-bold text-on-surface">Signature</div>
                                        </div>
                                        <span class="text-[9px] font-bold uppercase px-2 py-0.5 rounded" :class="selectedAdmission.documents.signature_status === 'Approved' ? 'bg-green-100 text-green-700' : (selectedAdmission.documents.signature_status === 'Rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700')" x-text="selectedAdmission.documents.signature_status || 'Pending'"></span>
                                    </div>
                                    <div class="flex gap-2">
                                        <button @click="openDocPreview('/storage/' + selectedAdmission.documents.signature, 'Signature')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">visibility</span> Preview
                                        </button>
                                        <button @click="downloadDoc('/storage/' + selectedAdmission.documents.signature, 'signature')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-high hover:bg-outline-variant/20 text-on-surface text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">download</span> Download
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <!-- ID Proof -->
                            <template x-if="selectedAdmission.documents && selectedAdmission.documents.idProof">
                                <div class="p-4 bg-surface-container rounded-xl border border-outline-variant/20 shadow-sm">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-primary text-sm">badge</span>
                                            </div>
                                            <div class="text-xs font-bold text-on-surface">ID Proof Document</div>
                                        </div>
                                        <span class="text-[9px] font-bold uppercase px-2 py-0.5 rounded" :class="selectedAdmission.documents.idProof_status === 'Approved' ? 'bg-green-100 text-green-700' : (selectedAdmission.documents.idProof_status === 'Rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700')" x-text="selectedAdmission.documents.idProof_status || 'Pending'"></span>
                                    </div>
                                    <div class="flex gap-2">
                                        <button @click="openDocPreview('/storage/' + selectedAdmission.documents.idProof, 'ID Proof')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">visibility</span> Preview
                                        </button>
                                        <button @click="downloadDoc('/storage/' + selectedAdmission.documents.idProof, 'id_proof')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-high hover:bg-outline-variant/20 text-on-surface text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">download</span> Download
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <!-- Marksheet -->
                            <template x-if="selectedAdmission.documents && selectedAdmission.documents.previousMarksheet">
                                <div class="p-4 bg-surface-container rounded-xl border border-outline-variant/20 shadow-sm">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-primary text-sm">text_snippet</span>
                                            </div>
                                            <div class="text-xs font-bold text-on-surface">Marksheet / Transcript</div>
                                        </div>
                                        <span class="text-[9px] font-bold uppercase px-2 py-0.5 rounded" :class="selectedAdmission.documents.previousMarksheet_status === 'Approved' ? 'bg-green-100 text-green-700' : (selectedAdmission.documents.previousMarksheet_status === 'Rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700')" x-text="selectedAdmission.documents.previousMarksheet_status || 'Pending'"></span>
                                    </div>
                                    <div class="flex gap-2">
                                        <button @click="openDocPreview('/storage/' + selectedAdmission.documents.previousMarksheet, 'Marksheet')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">visibility</span> Preview
                                        </button>
                                        <button @click="downloadDoc('/storage/' + selectedAdmission.documents.previousMarksheet, 'marksheet')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-high hover:bg-outline-variant/20 text-on-surface text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">download</span> Download
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <!-- Address Proof -->
                            <template x-if="selectedAdmission.documents && selectedAdmission.documents.addressProof">
                                <div class="p-4 bg-surface-container rounded-xl border border-outline-variant/20 shadow-sm">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-primary text-sm">home_pin</span>
                                            </div>
                                            <div class="text-xs font-bold text-on-surface">Address Proof</div>
                                        </div>
                                        <span class="text-[9px] font-bold uppercase px-2 py-0.5 rounded" :class="selectedAdmission.documents.addressProof_status === 'Approved' ? 'bg-green-100 text-green-700' : (selectedAdmission.documents.addressProof_status === 'Rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700')" x-text="selectedAdmission.documents.addressProof_status || 'Pending'"></span>
                                    </div>
                                    <div class="flex gap-2">
                                        <button @click="openDocPreview('/storage/' + selectedAdmission.documents.addressProof, 'Address Proof')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">visibility</span> Preview
                                        </button>
                                        <button @click="downloadDoc('/storage/' + selectedAdmission.documents.addressProof, 'address_proof')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-high hover:bg-outline-variant/20 text-on-surface text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">download</span> Download
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <!-- Category Certificate -->
                            <template x-if="selectedAdmission.documents && selectedAdmission.documents.categoryCertificate">
                                <div class="p-4 bg-surface-container rounded-xl border border-outline-variant/20 shadow-sm">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-primary text-sm">workspace_premium</span>
                                            </div>
                                            <div class="text-xs font-bold text-on-surface">Category Certificate</div>
                                        </div>
                                        <span class="text-[9px] font-bold uppercase px-2 py-0.5 rounded" :class="selectedAdmission.documents.categoryCertificate_status === 'Approved' ? 'bg-green-100 text-green-700' : (selectedAdmission.documents.categoryCertificate_status === 'Rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700')" x-text="selectedAdmission.documents.categoryCertificate_status || 'Pending'"></span>
                                    </div>
                                    <div class="flex gap-2">
                                        <button @click="openDocPreview('/storage/' + selectedAdmission.documents.categoryCertificate, 'Category Certificate')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">visibility</span> Preview
                                        </button>
                                        <button @click="downloadDoc('/storage/' + selectedAdmission.documents.categoryCertificate, 'category_certificate')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-high hover:bg-outline-variant/20 text-on-surface text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">download</span> Download
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Footer / Actions -->
                <div class="pt-6 border-t border-outline-variant/10 flex flex-wrap justify-end gap-3 mt-8">
                    <button type="button" @click="isReviewModalOpen = false" class="px-5 py-2.5 rounded-xl font-bold bg-surface-container hover:bg-surface-container-high text-primary transition-colors border border-outline-variant/30 text-sm">
                        Close Profile
                    </button>
                    <button type="button" @click="updateStatus(selectedAdmission.id, 'Pending'); isReviewModalOpen = false;" class="px-5 py-2.5 rounded-xl font-bold bg-amber-50 hover:bg-amber-100 text-amber-700 transition-all border border-amber-200/50 text-sm">
                        Mark Pending
                    </button>
                    <button type="button" @click="updateStatus(selectedAdmission.id, 'Document Error'); isReviewModalOpen = false;" class="px-5 py-2.5 rounded-xl font-bold bg-orange-50 hover:bg-orange-100 text-orange-700 transition-all border border-orange-200/50 text-sm">
                        Document Error
                    </button>
                    <button type="button" @click="updateStatus(selectedAdmission.id, 'Rejected'); isReviewModalOpen = false;" class="px-5 py-2.5 rounded-xl font-bold bg-error/10 hover:bg-error/20 text-error transition-all text-sm">
                        Reject Application
                    </button>
                    <button type="button" @click="updateStatus(selectedAdmission.id, 'Approved'); isReviewModalOpen = false;" class="px-5 py-2.5 rounded-xl font-bold bg-primary text-white shadow-md hover:bg-primary/95 transition-all text-sm">
                        Approve Application
                    </button>
                </div>
            </div>
        </div>

        <!-- Document Preview Overlay Modal -->
        <div x-show="isPreviewOpen" x-cloak class="fixed inset-0 z-[100] flex flex-col items-center justify-center">
            <!-- Backdrop -->
            <div
                x-show="isPreviewOpen"
                @click="isPreviewOpen = false"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-slate-900/80 backdrop-blur-md"
            ></div>

            <!-- Preview Panel -->
            <div
                x-show="isPreviewOpen"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative z-10 w-full max-w-5xl h-[90vh] mx-4 flex flex-col rounded-3xl overflow-hidden shadow-2xl border border-white/10"
            >
                <!-- Preview Header -->
                <div class="flex items-center justify-between px-6 py-4 bg-slate-900/95 backdrop-blur-md border-b border-white/10 shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary/20 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-sm">preview</span>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Document Preview</p>
                            <h3 class="text-sm font-bold text-white" x-text="previewTitle"></h3>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button @click="downloadDoc(previewUrl, previewTitle.toLowerCase().replace(/ /g, '_'))" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-primary/20 hover:bg-primary/40 text-primary text-xs font-bold transition-colors border border-primary/20">
                            <span class="material-symbols-outlined text-sm">download</span> Download
                        </button>
                        <button @click="isPreviewOpen = false" class="p-2 hover:bg-white/10 rounded-xl text-white/60 hover:text-white transition-colors flex items-center justify-center border border-white/10">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                </div>

                <!-- Preview Content -->
                <div class="flex-1 bg-slate-800 overflow-hidden">
                    <!-- Image Preview -->
                    <template x-if="previewUrl && (previewUrl.endsWith('.jpg') || previewUrl.endsWith('.jpeg') || previewUrl.endsWith('.png') || previewUrl.endsWith('.gif') || previewUrl.endsWith('.webp'))">
                        <div class="w-full h-full flex items-center justify-center p-4">
                            <img :src="previewUrl" :alt="previewTitle" class="max-w-full max-h-full object-contain rounded-xl shadow-2xl">
                        </div>
                    </template>
                    <!-- PDF / Other file (iframe) -->
                    <template x-if="previewUrl && !(previewUrl.endsWith('.jpg') || previewUrl.endsWith('.jpeg') || previewUrl.endsWith('.png') || previewUrl.endsWith('.gif') || previewUrl.endsWith('.webp'))">
                        <iframe :src="previewUrl" class="w-full h-full border-0" :title="previewTitle"></iframe>
                    </template>
                </div>
            </div>
        </div>

    </div>

    <!-- AlpineJS Manager script block -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('admissionManager', () => ({
                search: '',
                streamFilter: 'All',
                gradeFilter: 'All',
                statusFilter: 'All',
                isReviewModalOpen: false,
                isAddStudentModalOpen: false,
                isPreviewOpen: false,
                previewUrl: '',
                previewTitle: '',
                selectedAdmission: {
                    id: '',
                    name: '',
                    email: '',
                    phone: '',
                    father: '',
                    mother: '',
                    dob: '',
                    qualification: '',
                    address: '',
                    documents: {
                        photo: '',
                        signature: '',
                        idProof: '',
                        addressProof: '',
                        previousMarksheet: '',
                        categoryCertificate: ''
                    }
                },
                updateStatus(id, newStatus) {
                    fetch(`/admin/admissions/${id}/status`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ status: newStatus })
                    })
                    .then(r => r.json())
                    .then(data => {
                        if(data.success) {
                            window.location.reload();
                        } else {
                            alert('Failed to update status: ' + (data.message || 'Error'));
                        }
                    })
                    .catch(e => {
                        console.error(e);
                        alert('Network error while updating status');
                    });
                },
                verifyDocument(admissionId, docKey, action) {
                    fetch('/admin/documents/verify', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            admission_id: admissionId,
                            document: docKey,
                            action: action
                        })
                    })
                    .then(r => r.json())
                    .then(data => {
                        if(data.success) {
                            window.location.reload();
                        } else {
                            alert('Failed to verify document: ' + (data.message || 'Error'));
                        }
                    })
                    .catch(e => {
                        console.error(e);
                        alert('Network error during verification.');
                    });
                },
                openDocPreview(url, title) {
                    this.previewUrl = url;
                    this.previewTitle = title;
                    this.isPreviewOpen = true;
                },
                downloadDoc(url, filename) {
                    if (!url || url === '/storage/') return;
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = filename || 'document';
                    a.target = '_blank';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                },
                exportCSV() {
                    let csvContent = 'ID,Name,Email,Mobile,Course,Status,Created At\n';
                    const admissionsData = [
                        @foreach($admissions as $admission)
                            {
                                id: '{{ addslashes($admission->id) }}',
                                name: '{{ addslashes($admission->full_name) }}',
                                email: '{{ addslashes($admission->email) }}',
                                phone: '{{ addslashes($admission->mobile_number) }}',
                                course: '{{ $admission->course_type === '10th' || $admission->course_type === 'Secondary' ? '10th Grade' : '12th Grade' }}',
                                status: '{{ addslashes($admission->status) }}',
                                createdAt: '{{ $admission->created_at ? $admission->created_at->format('Y-m-d') : '' }}'
                            },
                        @endforeach
                    ];
                    
                    admissionsData.forEach(row => {
                        csvContent += '"' + row.id + '","' + row.name + '","' + row.email + '","' + row.phone + '","' + row.course + '","' + row.status + '","' + row.createdAt + '"\n';
                    });
                    
                    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.setAttribute('href', url);
                    link.setAttribute('download', `enrollments_${new Date().toISOString().slice(0,10)}.csv`);
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            }));
        });
    </script>
</x-admin-layout>
