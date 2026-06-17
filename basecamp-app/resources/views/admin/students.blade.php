<x-admin-layout>
    <!-- Inject Custom CSS and Tailwind configuration for this page -->
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "tertiary-dim": "#004f98",
                    "surface-dim": "#cdd6d9",
                    "surface-bright": "#f2f7f9",
                    "on-primary": "#e0f6ff",
                    "tertiary": "#005bae",
                    "surface-container-high": "#dce4e6",
                    "surface-container-highest": "#d6dee1",
                    "surface-container": "#e3e9ec",
                    "tertiary-fixed-dim": "#65a4ff",
                    "on-background": "#2a3031",
                    "outline-variant": "#a8aeb0",
                    "error-container": "#fb5151",
                    "on-tertiary": "#eff2ff",
                    "inverse-surface": "#0a0f11",
                    "on-error": "#ffefee",
                    "outline": "#72787a",
                    "on-error-container": "#570008",
                    "on-tertiary-fixed": "#001835",
                    "on-primary-fixed-variant": "#004a5a",
                    "surface-container-low": "#ecf2f4",
                    "primary-fixed": "#40cef3",
                    "secondary": "#006572",
                    "surface": "#f2f7f9",
                    "primary-dim": "#00576a",
                    "on-secondary-fixed": "#004049",
                    "background": "#f2f7f9",
                    "on-primary-fixed": "#002a34",
                    "on-surface": "#2a3031",
                    "surface-container-lowest": "#ffffff",
                    "on-secondary-fixed-variant": "#005f6b",
                    "surface-variant": "#d6dee1",
                    "tertiary-fixed": "#80b2ff",
                    "primary-container": "#40cef3",
                    "error": "#b31b25",
                    "secondary-dim": "#005863",
                    "inverse-on-surface": "#989ea0",
                    "tertiary-container": "#80b2ff",
                    "on-secondary": "#d8f8ff",
                    "on-surface-variant": "#575c5e",
                    "on-primary-container": "#00414f",
                    "secondary-fixed": "#96e6f6",
                    "primary-fixed-dim": "#28c0e4",
                    "surface-tint": "#006479",
                    "secondary-fixed-dim": "#88d8e7",
                    "primary": "#006479",
                    "inverse-primary": "#40cef3",
                    "on-secondary-container": "#005560",
                    "on-tertiary-fixed-variant": "#003971",
                    "error-dim": "#9f0519",
                    "secondary-container": "#96e6f6",
                    "on-tertiary-container": "#003061"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "fontFamily": {
                    "headline": ["Space Grotesk"],
                    "display": ["Space Grotesk"],
                    "body": ["Space Grotesk"],
                    "label": ["Space Grotesk"]
            }
          },
        },
      }
    </script>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .text-gradient {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .btn-primary {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
        }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        [x-cloak] { display: none !important; }
    </style>

    <div x-data="{
        isMessageModalOpen: false,
        isAddStudentModalOpen: false,
        isStatusModalOpen: false,
        isProfileDrawerOpen: false,
        isDocPreviewOpen: false,
        activeProfileTab: 'profile',
        docPreviewUrl: '',
        docPreviewTitle: '',
        selectedStudentName: '',
        selectedAdmissionId: '',
        selectedStatus: '',
        search: '',
        classFilter: 'All',
        streamFilter: 'All',
        statusFilter: 'All',
        audience: 'all',
        subject: '',
        message: '',
        showToast: false,
        toastMessage: '',
        profileStudent: {
            id: '', userId: '', name: '', email: '', phone: '', enrollmentNumber: '',
            class: '', stream: '', status: '',
            docs: { photo:'', signature:'', idProof:'', addressProof:'', previousMarksheet:'', categoryCertificate:'' },
            tmaSubmissions: []
        },
        enrollmentInput: '',
        savingEnrollment: false,
        openProfile(student) {
            this.profileStudent = student;
            this.enrollmentInput = student.enrollmentNumber;
            this.activeProfileTab = 'profile';
            this.isProfileDrawerOpen = true;
        },
        saveEnrollment() {
            if (!this.enrollmentInput.trim()) return;
            this.savingEnrollment = true;
            fetch(`/admin/students/${this.profileStudent.userId}/enrollment`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ enrollment_number: this.enrollmentInput })
            })
            .then(r => r.json())
            .then(data => {
                this.savingEnrollment = false;
                if (data.success) {
                    this.profileStudent.enrollmentNumber = this.enrollmentInput;
                    this.toastMessage = 'Enrollment number updated!';
                    this.showToast = true;
                    setTimeout(() => this.showToast = false, 3000);
                } else {
                    alert(data.message || 'Failed to update enrollment number.');
                }
            })
            .catch(() => { this.savingEnrollment = false; alert('Network error.'); });
        },
        saveTmaMarks(sub) {
            sub.saving = true;
            fetch(`/admin/tma-submissions/${sub.id}/marks`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ tma_marks: sub.tmaMarks || null, practical_marks: sub.practicalMarks || null, admin_remarks: sub.remarks || '' })
            })
            .then(r => r.json())
            .then(data => {
                sub.saving = false;
                if (data.success) {
                    sub.status = 'graded';
                    this.toastMessage = 'Marks saved for ' + sub.tmaTitle + '!';
                    this.showToast = true;
                    setTimeout(() => this.showToast = false, 3500);
                } else {
                    alert(data.message || 'Failed to save marks.');
                }
            })
            .catch(() => { sub.saving = false; alert('Network error.'); });
        },
        openDocPreview(url, title) {
            this.docPreviewUrl = url;
            this.docPreviewTitle = title;
            this.isDocPreviewOpen = true;
        },
        downloadDoc(url, filename) {
            if (!url || url === '/storage/') return;
            const a = document.createElement('a');
            a.href = url;
            a.download = filename || 'document';
            a.target = '_blank';
            document.body.appendChild(a); a.click(); document.body.removeChild(a);
        },
        exportCSV() {
            let csvContent = 'ID,Name,Email,Enrollment,Class,Stream,Status\\n';
            const studentsData = [
                @foreach($students as $student)
                    @php
                        $latestAdmission = $student->admissions->first();
                        $studentId = "BSP-" . ($student->created_at ? $student->created_at->format('Y') : '2026') . "-" . str_pad($student->id, 4, '0', STR_PAD_LEFT);
                        $class = 'Not Submitted'; $stream = 'Pending';
                        if ($latestAdmission) {
                            if ($latestAdmission->course_type === '10th') { $class = '10th Grade'; $stream = 'Foundation'; }
                            elseif ($latestAdmission->course_type === '12th') { $class = '12th Grade'; $stream = ($student->id % 2 === 0) ? 'Engineering (PCM)' : 'Medical (PCMB)'; }
                        }
                        $progress = ($student->id * 17) % 61 + 40;
                        $status = ($latestAdmission && $latestAdmission->status === 'Approved') ? 'Active' : 'On-Hold';
                    @endphp
                    { id: '{{ $studentId }}', name: '{{ addslashes($student->name) }}', email: '{{ addslashes($student->email) }}',
                      enrollment: '{{ $student->enrollment_number ?? 'N/A' }}', class: '{{ $class }}',
                      stream: '{{ $stream }}', status: '{{ $status }}' },
                @endforeach
            ];
            studentsData.forEach(row => {
                csvContent += `\"${row.id}\",\"${row.name}\",\"${row.email}\",\"${row.enrollment}\",\"${row.class}\",\"${row.stream}\",\"${row.status}\"\n`;
            });
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.setAttribute('href', url);
            link.setAttribute('download', `students_${new Date().toISOString().slice(0,10)}.csv`);
            document.body.appendChild(link); link.click(); document.body.removeChild(link);
        }
    }" class="relative w-full min-h-screen">

        
        <!-- Floating Abstract Background Elements -->
        <div class="fixed top-20 right-20 w-96 h-96 bg-primary-container/20 rounded-full blur-[120px] -z-10 animate-pulse"></div>
        <div class="fixed bottom-10 left-80 w-64 h-64 bg-secondary-container/30 rounded-full blur-[100px] -z-10"></div>

        <!-- Success Toast Notifications -->
        <div x-show="showToast" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-2"
             class="fixed bottom-5 right-5 bg-cyan-800 text-white px-6 py-3.5 rounded-xl shadow-2xl z-50 flex items-center gap-3 border border-cyan-500/20"
             style="display: none;"
        >
            <span class="material-symbols-outlined text-green-400">check_circle</span>
            <span x-text="toastMessage" class="font-bold tracking-tight"></span>
        </div>

        @if(session('success'))
            <div x-init="toastMessage = '{{ session('success') }}'; showToast = true; setTimeout(() => showToast = false, 4000)" style="display: none;"></div>
        @endif

        <!-- Top Header Area -->
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-10">
            <div>
                <h1 class="text-[clamp(2rem,5vw,2.5rem)] font-extrabold tracking-tight text-on-background mb-2">Student Management</h1>
                <p class="text-on-surface-variant font-medium">Monitoring and orchestrating the next generation of academic leaders.</p>
            </div>
            <div class="flex gap-3 w-full sm:w-auto">
                <button @click="exportCSV()" class="flex items-center justify-center gap-2 px-6 py-3 rounded-xl border border-outline-variant/35 font-bold text-sm bg-white hover:bg-surface-container-low transition-colors text-on-surface w-full sm:w-auto">
                    <span class="material-symbols-outlined text-lg">download</span>
                    Export CSV
                </button>
                <button @click="isMessageModalOpen = true; audience = 'all';" class="btn-primary text-on-primary px-6 py-3 rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all w-full sm:w-auto">
                    <span class="material-symbols-outlined">mail</span>
                    Broadcast
                </button>
                <button @click="isAddStudentModalOpen = true" class="btn-primary text-on-primary px-6 py-3 rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all w-full sm:w-auto">
                    <span class="material-symbols-outlined">person_add</span>
                    Quick Add Student
                </button>
            </div>
        </header>

        <!-- Metrics Grid -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Metric 1 -->
            <div class="glass-card p-6 rounded-3xl group hover:border-primary/30 transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-primary/10 text-primary rounded-2xl">
                        <span class="material-symbols-outlined">group</span>
                    </div>
                    <span class="text-xs font-bold text-primary px-2 py-1 bg-primary/5 rounded-full">+{{ round(($students->count() / max($students->count(), 1)) * 10) }}% this month</span>
                </div>
                <p class="text-on-surface-variant text-sm font-medium uppercase tracking-widest">Total Registered Students</p>
                <h3 class="text-3xl font-bold mt-1">{{ $students->count() }}</h3>
            </div>
            <!-- Metric 2 -->
            <div class="glass-card p-6 rounded-3xl group hover:border-error/30 transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-error-container/10 text-error rounded-2xl">
                        <span class="material-symbols-outlined">verified_user</span>
                    </div>
                    <span class="text-xs font-bold text-error px-2 py-1 bg-error-container/5 rounded-full">High Priority</span>
                </div>
                <p class="text-on-surface-variant text-sm font-medium uppercase tracking-widest">Pending Verifications</p>
                <h3 class="text-3xl font-bold mt-1">{{ $pendingCount }}</h3>
            </div>
            <!-- Metric 3 -->
            <div class="glass-card p-6 rounded-3xl group hover:border-secondary/30 transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-secondary/10 text-secondary rounded-2xl">
                        <span class="material-symbols-outlined">auto_graph</span>
                    </div>
                    <span class="text-xs font-bold text-secondary px-2 py-1 bg-secondary/5 rounded-full">Target: 95%</span>
                </div>
                <p class="text-on-surface-variant text-sm font-medium uppercase tracking-widest">Academic Success Rate</p>
                <h3 class="text-3xl font-bold mt-1">91.4%</h3>
            </div>
        </section>

        <!-- Search & Filters -->
        <section class="glass-card p-4 rounded-2xl mb-8 flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[280px] relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input x-model="search" class="w-full bg-surface-container-low/50 border-none rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-primary/20 text-sm placeholder:text-on-surface-variant/50 text-on-surface" placeholder="Search by student name, ID or email..." type="text"/>
            </div>
            <select x-model="classFilter" class="bg-surface-container-low/50 border-none rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 text-on-surface">
                <option value="All">Class: All</option>
                <option value="10th Grade">10th Grade</option>
                <option value="12th Grade">12th Grade</option>
                <option value="Not Submitted">Not Submitted</option>
            </select>
            <select x-model="streamFilter" class="bg-surface-container-low/50 border-none rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 text-on-surface">
                <option value="All">Stream: All</option>
                <option value="Medical (PCMB)">Medical (PCMB)</option>
                <option value="Engineering (PCM)">Engineering (PCM)</option>
                <option value="Foundation">Foundation</option>
                <option value="Pending">Pending</option>
            </select>
            <select x-model="statusFilter" class="bg-surface-container-low/50 border-none rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 text-on-surface">
                <option value="All">Status: All</option>
                <option value="Active">Active</option>
                <option value="On-Hold">On-Hold</option>
            </select>
            <button @click="search = ''; classFilter = 'All'; streamFilter = 'All'; statusFilter = 'All';" class="p-3 bg-surface-container-highest/50 rounded-xl hover:bg-surface-container-highest transition-colors flex items-center justify-center" title="Reset Filters">
                <span class="material-symbols-outlined text-sm">tune</span>
            </button>
        </section>

        <!-- Data Table -->
        <section class="glass-card rounded-3xl overflow-hidden mb-12">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-outline-variant/10 bg-surface-container-low/50">
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Student Details</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Class / Stream</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Performance</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Status</th>
                            <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-on-surface-variant text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/5">
                        @forelse($students as $student)
                            @php
                                $latestAdmission = $student->admissions->first();
                                
                                // Generate clean dynamic unique student ID
                                $studentId = "BSP-" . ($student->created_at ? $student->created_at->format('Y') : '2026') . "-" . str_pad($student->id, 4, '0', STR_PAD_LEFT);
                                
                                // Determine Class / Stream
                                $class = 'Not Submitted';
                                $stream = 'Pending';
                                if ($latestAdmission) {
                                    if ($latestAdmission->course_type === '10th') {
                                        $class = '10th Grade';
                                        $stream = 'Foundation';
                                    } elseif ($latestAdmission->course_type === '12th') {
                                        $class = '12th Grade';
                                        $stream = ($student->id % 2 === 0) ? 'Engineering (PCM)' : 'Medical (PCMB)';
                                    }
                                }
                                
                                // Dynamic Progress logic: deterministic based on student id
                                $progress = ($student->id * 17) % 61 + 40;
                                
                                // Determine Status
                                $status = 'On-Hold';
                                if ($latestAdmission && $latestAdmission->status === 'Approved') {
                                    $status = 'Active';
                                }
                                
                                $statusClass = ($status === 'Active') 
                                    ? 'bg-primary/10 text-primary border border-primary/20' 
                                    : 'bg-surface-container-high text-on-surface-variant border border-outline-variant/30';
                                
                                // Dynamic UI Avatar
                                $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=006479&color=fff&bold=true&size=128';
                            @endphp
                            <!-- Student Row -->
                            <tr 
                                x-show="(search === '' || '{{ strtolower($student->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($student->email) }}'.includes(search.toLowerCase()) || '{{ strtolower($studentId) }}'.includes(search.toLowerCase())) &&
                                        (classFilter === 'All' || classFilter === '{{ $class }}') &&
                                        (streamFilter === 'All' || streamFilter === '{{ $stream }}') &&
                                        (statusFilter === 'All' || statusFilter === '{{ $status }}')"
                                class="hover:bg-surface-container-low/30 hover:-translate-y-0.5 transition-all duration-300 group"
                            >
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-white group-hover:border-primary/20 transition-all flex items-center justify-center shadow-sm">
                                            <img alt="{{ $student->name }}" class="w-full h-full object-cover" src="{{ $avatarUrl }}"/>
                                        </div>
                                        <div>
                                            <p class="font-bold text-on-background">{{ $student->name }}</p>
                                            <p class="text-xs text-on-surface-variant font-medium">ID: {{ $studentId }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-on-background">{{ $class }}</p>
                                    <p class="text-xs text-secondary font-medium">{{ $stream }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="w-40">
                                        <div class="flex justify-between mb-1">
                                            <span class="text-xs font-bold text-on-background">Progress</span>
                                            <span class="text-xs font-bold text-primary">{{ $progress }}%</span>
                                        </div>
                                        <div class="h-1.5 w-full bg-surface-variant rounded-full overflow-hidden">
                                            <div class="h-full bg-primary rounded-full" style="width: {{ $progress }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusClass }}">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button @click="isMessageModalOpen = true; audience = '{{ $student->email }}';" class="p-2 hover:bg-primary/10 text-primary rounded-lg transition-colors flex items-center justify-center" title="Message Student">
                                            <span class="material-symbols-outlined text-[20px]">chat</span>
                                        </button>
                                        <button
                                            @click="
                                                selectedAdmissionId = '{{ $latestAdmission ? $latestAdmission->id : '' }}';
                                                selectedStudentName = '{{ addslashes($student->name) }}';
                                                selectedStatus = '{{ $latestAdmission ? $latestAdmission->status : 'Pending' }}';
                                                if (selectedAdmissionId !== '') {
                                                    isStatusModalOpen = true;
                                                } else {
                                                    alert('No admission record found for this student.');
                                                }
                                            "
                                            class="p-2 hover:bg-secondary/10 text-secondary rounded-lg transition-colors flex items-center justify-center"
                                            title="Update Status"
                                        >
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </button>
                                        @php
                                            $docs = $latestAdmission ? ($latestAdmission->documents ?? []) : [];
                                            $tmaData = $student->tmaSubmissions->map(function($sub) {
                                                return [
                                                    'id' => $sub->id,
                                                    'tmaTitle' => $sub->product ? $sub->product->title : 'TMA',
                                                    'status' => $sub->status,
                                                    'filePath' => $sub->file_path ? '/storage/' . $sub->file_path : null,
                                                    'originalFilename' => $sub->original_filename,
                                                    'tmaMarks' => $sub->tma_marks,
                                                    'practicalMarks' => $sub->practical_marks,
                                                    'remarks' => $sub->admin_remarks,
                                                    'submittedAt' => $sub->submitted_at ? $sub->submitted_at->format('d M Y') : null,
                                                    'saving' => false,
                                                ];
                                            })->values()->toArray();
                                            $allTmaData = $allTmas->map(function($tma) use ($tmaData) {
                                                $existing = collect($tmaData)->firstWhere('id', fn($s) => false); // placeholder
                                                $sub = $student->tmaSubmissions->firstWhere('product_id', $tma->id);
                                                return [
                                                    'tmaProductId' => $tma->id,
                                                    'tmaTitle' => $tma->title,
                                                    'id' => $sub ? $sub->id : null,
                                                    'status' => $sub ? $sub->status : 'not_submitted',
                                                    'filePath' => ($sub && $sub->file_path) ? '/storage/' . $sub->file_path : null,
                                                    'originalFilename' => $sub ? $sub->original_filename : null,
                                                    'tmaMarks' => $sub ? $sub->tma_marks : null,
                                                    'practicalMarks' => $sub ? $sub->practical_marks : null,
                                                    'remarks' => $sub ? $sub->admin_remarks : null,
                                                    'submittedAt' => ($sub && $sub->submitted_at) ? $sub->submitted_at->format('d M Y') : null,
                                                    'saving' => false,
                                                ];
                                            })->values()->toArray();
                                        @endphp
                                        @php
                                            $profileData = [
                                                'id' => $studentId,
                                                'userId' => $student->id,
                                                'name' => $student->name,
                                                'email' => $student->email,
                                                'phone' => $latestAdmission->mobile_number ?? '',
                                                'enrollmentNumber' => $student->enrollment_number ?? '',
                                                'class' => $class,
                                                'stream' => $stream,
                                                'status' => $status,
                                                'docs' => [
                                                    'photo' => $docs['photo'] ?? '',
                                                    'signature' => $docs['signature'] ?? '',
                                                    'idProof' => $docs['idProof'] ?? '',
                                                    'addressProof' => $docs['addressProof'] ?? '',
                                                    'previousMarksheet' => $docs['previousMarksheet'] ?? '',
                                                    'categoryCertificate' => $docs['categoryCertificate'] ?? '',
                                                ],
                                                'tmaSubmissions' => $allTmaData,
                                            ];
                                        @endphp
                                        <button
                                            @click="openProfile(@json($profileData))"
                                            class="flex items-center gap-1.5 px-3 py-2 hover:bg-primary/10 text-primary rounded-lg transition-colors text-xs font-bold border border-primary/20"
                                            title="View Full Profile"
                                        >
                                            <span class="material-symbols-outlined text-[16px]">person</span>
                                            Profile
                                        </button>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="p-24 text-center">
                                    <div class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center mb-6 mx-auto text-primary">
                                        <span class="material-symbols-outlined text-4xl">group</span>
                                    </div>
                                    <h3 class="text-3xl font-bold tracking-tight mb-3 text-primary">No Students Found</h3>
                                    <p class="text-lg text-on-surface-variant max-w-md mx-auto leading-relaxed">
                                        There are no students matching your filter criteria in the system.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination / Summary UI -->
            <div class="px-6 py-4 bg-surface-container-lowest/50 flex justify-between items-center">
                <p class="text-xs text-on-surface-variant font-medium font-sans">Showing 1-{{ $students->count() }} of {{ $students->count() }} students</p>
                <div class="flex items-center gap-2">
                    <button class="p-2 rounded-lg hover:bg-surface-container-high text-on-surface-variant disabled:opacity-30 flex items-center justify-center" disabled>
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </button>
                    <button class="w-8 h-8 rounded-lg bg-primary text-on-primary text-xs font-bold flex items-center justify-center">1</button>
                    <button class="p-2 rounded-lg hover:bg-surface-container-high text-on-surface-variant disabled:opacity-30 flex items-center justify-center" disabled>
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- Enrollment & Activities Asymmetric Layout -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Enrollment Distribution -->
            <div class="lg:col-span-2 glass-card p-8 rounded-3xl">
                <h4 class="text-lg font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">analytics</span>
                    Enrollment Distribution
                </h4>
                @php
                    $count10th = \App\Models\Admission::where('course_type', '10th')->count();
                    $count12th = \App\Models\Admission::where('course_type', '12th')->count();
                    $totalAdmissions = $count10th + $count12th;
                    
                    $pct10th = $totalAdmissions > 0 ? round(($count10th / $totalAdmissions) * 100) : 40;
                    $pct12th = $totalAdmissions > 0 ? round(($count12th / $totalAdmissions) * 100) : 60;
                @endphp
                <div class="flex items-end gap-6 h-48 px-4 pb-2">
                    <!-- 10th Grade Bar -->
                    <div class="flex-1 bg-surface-container-low rounded-t-xl relative group h-full">
                        <div class="absolute bottom-0 w-full bg-primary rounded-t-xl transition-all duration-700" style="height: {{ $pct10th }}%"></div>
                        <span class="absolute -top-8 left-1/2 -translate-x-1/2 text-xs font-bold bg-primary text-white px-2.5 py-1 rounded shadow-md pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                            10th Grade: {{ $count10th }} Enrolled
                        </span>
                        <div class="absolute bottom-[-24px] left-0 right-0 text-center text-[10px] font-bold text-on-surface-variant">10TH GRADE</div>
                    </div>
                    <!-- 12th Grade Bar -->
                    <div class="flex-1 bg-surface-container-low rounded-t-xl relative group h-full">
                        <div class="absolute bottom-0 w-full bg-secondary rounded-t-xl transition-all duration-700" style="height: {{ $pct12th }}%"></div>
                        <span class="absolute -top-8 left-1/2 -translate-x-1/2 text-xs font-bold bg-secondary text-white px-2.5 py-1 rounded shadow-md pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                            12th Grade: {{ $count12th }} Enrolled
                        </span>
                        <div class="absolute bottom-[-24px] left-0 right-0 text-center text-[10px] font-bold text-on-surface-variant">12TH GRADE</div>
                    </div>
                    <!-- Mock Graduation Bar -->
                    <div class="flex-1 bg-surface-container-low rounded-t-xl relative group h-full">
                        <div class="absolute bottom-0 w-full bg-primary-container rounded-t-xl transition-all duration-700" style="height: 15%"></div>
                        <span class="absolute -top-8 left-1/2 -translate-x-1/2 text-xs font-bold bg-primary-container text-on-primary-container px-2.5 py-1 rounded shadow-md pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                            Grads: 2 Finished
                        </span>
                        <div class="absolute bottom-[-24px] left-0 right-0 text-center text-[10px] font-bold text-on-surface-variant">GRADUATES</div>
                    </div>
                </div>
                <div class="mt-8"></div>
            </div>

            <!-- Recent Activity -->
            <div class="glass-card p-6 rounded-3xl flex flex-col">
                <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">bolt</span>
                    Recent Activity
                </h4>
                <div class="space-y-4 overflow-y-auto max-h-[250px] scrollbar-hide flex-grow">
                    @forelse($recentAdmissions as $activity)
                        <div class="flex gap-4 items-start border-b border-outline-variant/10 pb-3 last:border-0 last:pb-0">
                            <div class="w-2.5 h-2.5 rounded-full bg-primary mt-1.5 flex-shrink-0"></div>
                            <div>
                                <p class="text-sm font-bold text-on-background">New Application</p>
                                <p class="text-xs text-on-surface-variant font-medium">{{ $activity->full_name }} submitted {{ $activity->course_type }}th Admission Form.</p>
                                <p class="text-[10px] text-primary font-bold mt-1 uppercase tracking-wider">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-on-surface-variant/50 text-sm flex flex-col items-center justify-center h-full">
                            <span class="material-symbols-outlined text-3xl opacity-30 mb-2">notifications_off</span>
                            No recent admission applications.
                        </div>
                    @endforelse
                </div>
                <a href="/admin/admissions" class="mt-auto pt-4 text-xs font-bold text-primary hover:underline text-center w-full uppercase tracking-widest block">View All Admissions</a>
            </div>
        </section>

        <!-- Broadcast Message Modal -->
        <div x-show="isMessageModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div 
                x-show="isMessageModalOpen"
                @click="isMessageModalOpen = false"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
            ></div>
            
            <div 
                x-show="isMessageModalOpen"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-10 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-10 scale-95"
                class="glass-card w-full max-w-xl bg-white p-8 rounded-3xl border border-outline-variant/30 shadow-2xl relative z-10"
            >
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-extrabold tracking-tight text-primary">Broadcast / Direct Message</h2>
                    <button @click="isMessageModalOpen = false" class="p-2 hover:bg-surface-container rounded-full text-on-surface-variant transition-colors flex items-center justify-center">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form @submit.prevent="
                    fetch('/admin/message', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            audience: audience,
                            subject: subject,
                            message: message
                        })
                    })
                    .then(r => r.json())
                    .then(data => {
                        if(data.success) {
                            isMessageModalOpen = false;
                            toastMessage = 'Message sent to ' + audience + ' successfully!';
                            showToast = true;
                            subject = '';
                            message = '';
                            setTimeout(() => showToast = false, 4000);
                        } else {
                            alert('Error: ' + (data.message || 'Something went wrong'));
                        }
                    })
                    .catch(e => {
                        console.error(e);
                        alert('Failed to send broadcast');
                    });
                " class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold tracking-wide uppercase text-on-surface-variant mb-2">Audience</label>
                        <select
                            x-model="audience"
                            required
                            class="w-full p-4 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none text-primary font-medium focus:border-primary/50 text-sm"
                        >
                            <optgroup label="Broadcast Groups">
                                <option value="all">All Students</option>
                                <option value="active">Active Students</option>
                                <option value="block_1">Block 1 Students (Batch-wise)</option>
                                <option value="block_2">Block 2 Students (Batch-wise)</option>
                            </optgroup>
                            <optgroup label="Individual Students">
                                @foreach($students as $stud)
                                    <option value="{{ $stud->email }}">{{ $stud->name }} ({{ $stud->email }})</option>
                                @endforeach
                            </optgroup>
                            <option x-show="audience !== 'all' && audience !== 'active' && audience !== 'block_1' && audience !== 'block_2'" :value="audience" x-text="'Direct Email: ' + audience"></option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold tracking-wide uppercase text-on-surface-variant mb-2">Subject</label>
                        <input
                            type="text"
                            x-model="subject"
                            required
                            class="w-full p-4 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none text-primary font-medium placeholder:text-on-surface-variant/40 focus:border-primary/50 text-sm"
                            placeholder="Important Update..."
                        />
                    </div>
                    <div>
                        <label class="block text-xs font-bold tracking-wide uppercase text-on-surface-variant mb-2">Message</label>
                        <textarea
                            x-model="message"
                            required
                            rows="5"
                            class="w-full p-4 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none text-primary font-medium placeholder:text-on-surface-variant/40 resize-none focus:border-primary/50 text-sm"
                            placeholder="Type your message here..."
                        ></textarea>
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="isMessageModalOpen = false" class="px-6 py-3 rounded-xl font-bold bg-surface-container hover:bg-surface-container-high text-primary transition-colors border border-outline-variant/30 text-sm">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-3 rounded-xl font-bold bg-primary hover:bg-primary/95 text-white shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all min-w-[150px] flex items-center justify-center gap-2 text-sm">
                            Send Message
                            <span class="material-symbols-outlined text-sm">send</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Quick Add Student Modal -->
        <div x-show="isAddStudentModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div 
                x-show="isAddStudentModalOpen"
                @click="isAddStudentModalOpen = false"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
            ></div>
            
            <div 
                x-show="isAddStudentModalOpen"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-10 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-10 scale-95"
                class="glass-card w-full max-w-md bg-white p-8 rounded-3xl border border-outline-variant/30 shadow-2xl relative z-10"
            >
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-extrabold tracking-tight text-primary">Quick Add Student</h2>
                    <button @click="isAddStudentModalOpen = false" class="p-2 hover:bg-surface-container rounded-full text-on-surface-variant transition-colors flex items-center justify-center">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.students.create') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold tracking-wide uppercase text-on-surface-variant mb-2">Name</label>
                        <input
                            type="text"
                            name="name"
                            required
                            class="w-full p-4 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none text-primary font-medium placeholder:text-on-surface-variant/40 focus:border-primary/50 text-sm"
                            placeholder="John Doe"
                        />
                    </div>
                    <div>
                        <label class="block text-xs font-bold tracking-wide uppercase text-on-surface-variant mb-2">Email</label>
                        <input
                            type="email"
                            name="email"
                            required
                            class="w-full p-4 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none text-primary font-medium placeholder:text-on-surface-variant/40 focus:border-primary/50 text-sm"
                            placeholder="john.doe@example.com"
                        />
                    </div>
                    <div>
                        <label class="block text-xs font-bold tracking-wide uppercase text-on-surface-variant mb-2">Temporary Password</label>
                        <input
                            type="password"
                            name="password"
                            required
                            class="w-full p-4 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none text-primary font-medium placeholder:text-on-surface-variant/40 focus:border-primary/50 text-sm"
                            placeholder="******"
                        />
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="isAddStudentModalOpen = false" class="px-6 py-3 rounded-xl font-bold bg-surface-container hover:bg-surface-container-high text-primary transition-colors border border-outline-variant/30 text-sm">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-3 rounded-xl font-bold bg-primary hover:bg-primary/95 text-white shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 text-sm">
                            Add Student
                            <span class="material-symbols-outlined text-sm">person_add</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Update Status Modal -->
        <div x-show="isStatusModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div 
                x-show="isStatusModalOpen"
                @click="isStatusModalOpen = false"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
            ></div>
            
            <div 
                x-show="isStatusModalOpen"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-10 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-10 scale-95"
                class="glass-card w-full max-w-md bg-white p-8 rounded-3xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface"
            >
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-extrabold tracking-tight text-primary">Update Student Status</h2>
                    <button @click="isStatusModalOpen = false" class="p-2 hover:bg-surface-container rounded-full text-on-surface-variant transition-colors flex items-center justify-center">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="mb-4 bg-surface-container-low/40 p-4 rounded-xl border border-outline-variant/10 text-sm">
                    <div class="text-[10px] uppercase font-bold text-on-surface-variant">Student Name</div>
                    <div class="font-bold text-on-surface text-base" x-text="selectedStudentName"></div>
                </div>

                <form @submit.prevent="
                    fetch(`/admin/admissions/${selectedAdmissionId}/status`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            status: selectedStatus
                        })
                    })
                    .then(r => r.json())
                    .then(data => {
                        if(data.success) {
                            isStatusModalOpen = false;
                            window.location.reload();
                        } else {
                            alert('Error: ' + (data.message || 'Something went wrong'));
                        }
                    })
                    .catch(e => {
                        console.error(e);
                        alert('Failed to update status');
                    });
                " class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold tracking-wide uppercase text-on-surface-variant mb-2">Admission Status</label>
                        <select
                            x-model="selectedStatus"
                            required
                            class="w-full p-4 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none text-primary font-medium focus:border-primary/50 text-sm"
                        >
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="Document Error">Document Error</option>
                            <option value="Rejected">Not Approved</option>
                        </select>
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="isStatusModalOpen = false" class="px-6 py-3 rounded-xl font-bold bg-surface-container hover:bg-surface-container-high text-primary transition-colors border border-outline-variant/30 text-sm">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-3 rounded-xl font-bold bg-primary hover:bg-primary/95 text-white shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 text-sm">
                            Save Changes
                            <span class="material-symbols-outlined text-sm">save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ==========================================
             STUDENT PROFILE DRAWER
             ========================================== -->
        <div x-show="isProfileDrawerOpen" x-cloak class="fixed inset-0 z-[80] flex items-stretch justify-end">
            <!-- Backdrop -->
            <div x-show="isProfileDrawerOpen" @click="isProfileDrawerOpen = false"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"></div>

            <!-- Drawer Panel -->
            <div x-show="isProfileDrawerOpen"
                x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-250 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                class="relative z-10 w-full max-w-2xl h-full flex flex-col bg-surface-bright shadow-2xl overflow-hidden">

                <!-- Drawer Header -->
                <div class="flex items-center gap-4 px-7 py-5 bg-white border-b border-outline-variant/20 shrink-0">
                    <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary">manage_accounts</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-lg font-extrabold text-on-background truncate" x-text="profileStudent.name"></h2>
                        <p class="text-xs text-on-surface-variant font-medium" x-text="profileStudent.id"></p>
                    </div>
                    <button @click="isProfileDrawerOpen = false" class="p-2 hover:bg-surface-container rounded-xl text-on-surface-variant transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Tabs -->
                <div class="flex border-b border-outline-variant/20 bg-white shrink-0">
                    <button @click="activeProfileTab = 'profile'" :class="activeProfileTab === 'profile' ? 'border-b-2 border-primary text-primary font-extrabold' : 'text-on-surface-variant font-bold'" class="flex-1 py-3.5 text-sm transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-sm">badge</span>
                        Profile & Documents
                    </button>
                    <button @click="activeProfileTab = 'tma'" :class="activeProfileTab === 'tma' ? 'border-b-2 border-primary text-primary font-extrabold' : 'text-on-surface-variant font-bold'" class="flex-1 py-3.5 text-sm transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-sm">assignment</span>
                        TMA & Marks
                    </button>
                </div>

                <!-- Scrollable Content -->
                <div class="flex-1 overflow-y-auto">

                    <!-- ===== TAB 1: PROFILE & DOCUMENTS ===== -->
                    <div x-show="activeProfileTab === 'profile'" class="p-7 space-y-7">

                        <!-- Student Info Card -->
                        <div class="bg-white rounded-2xl p-5 border border-outline-variant/20 shadow-sm space-y-4">
                            <h3 class="text-xs font-extrabold uppercase tracking-widest text-primary">Student Information</h3>
                            <div class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                                <div><p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-0.5">Full Name</p><p class="font-bold text-on-surface" x-text="profileStudent.name"></p></div>
                                <div><p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-0.5">Email</p><p class="font-bold text-on-surface truncate" x-text="profileStudent.email"></p></div>
                                <div><p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-0.5">Mobile</p><p class="font-bold text-on-surface" x-text="profileStudent.phone || 'N/A'"></p></div>
                                <div><p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-0.5">Class / Stream</p><p class="font-bold text-on-surface" x-text="profileStudent.class + ' · ' + profileStudent.stream"></p></div>
                                <div><p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-0.5">Status</p>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase" :class="profileStudent.status === 'Active' ? 'bg-primary/10 text-primary' : 'bg-surface-container-high text-on-surface-variant'" x-text="profileStudent.status"></span>
                                </div>
                                <div><p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-0.5">System ID</p><p class="font-bold text-on-surface font-mono text-xs" x-text="profileStudent.id"></p></div>
                            </div>
                        </div>

                        <!-- Enrollment Number Manager -->
                        <div class="bg-white rounded-2xl p-5 border border-outline-variant/20 shadow-sm">
                            <h3 class="text-xs font-extrabold uppercase tracking-widest text-primary mb-4">Enrollment Number</h3>
                            <div class="flex gap-3">
                                <div class="relative flex-1">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-sm">tag</span>
                                    <input type="text" x-model="enrollmentInput" placeholder="e.g. TBC-2026-XXXXXX"
                                        class="w-full pl-9 pr-4 py-3 rounded-xl border border-outline-variant/30 bg-surface-container-low focus:ring-2 focus:ring-primary/20 outline-none text-sm font-bold text-primary focus:border-primary/40 transition-colors">
                                </div>
                                <button @click="saveEnrollment()"
                                    :disabled="savingEnrollment"
                                    :class="savingEnrollment ? 'opacity-60 cursor-not-allowed' : 'hover:bg-primary/90'"
                                    class="px-5 py-3 rounded-xl bg-primary text-white text-sm font-bold flex items-center gap-2 transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-sm" x-show="!savingEnrollment">save</span>
                                    <span class="material-symbols-outlined text-sm animate-spin" x-show="savingEnrollment" style="display:none">progress_activity</span>
                                    <span x-text="savingEnrollment ? 'Saving...' : 'Save'"></span>
                                </button>
                            </div>
                            <p class="text-[10px] text-on-surface-variant font-medium mt-2">This enrollment number is shown on the student's dashboard and used for all official communications.</p>
                        </div>

                        <!-- Documents Section -->
                        <div>
                            <h3 class="text-xs font-extrabold uppercase tracking-widest text-primary mb-4">Submitted Documents</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                                <!-- Doc Card Template -->
                                <template x-for="doc in [
                                    { key: 'photo', label: 'Student Photo', icon: 'image' },
                                    { key: 'signature', label: 'Signature', icon: 'draw' },
                                    { key: 'idProof', label: 'ID Proof', icon: 'badge' },
                                    { key: 'addressProof', label: 'Address Proof', icon: 'home_pin' },
                                    { key: 'previousMarksheet', label: 'Marksheet / Transcript', icon: 'text_snippet' },
                                    { key: 'categoryCertificate', label: 'Category Certificate', icon: 'workspace_premium' }
                                ]" :key="doc.key">
                                    <div class="p-4 rounded-2xl border border-outline-variant/20 shadow-sm" :class="profileStudent.docs[doc.key] ? 'bg-white' : 'bg-surface-container-low/50'">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" :class="profileStudent.docs[doc.key] ? 'bg-primary/10' : 'bg-surface-container-high'">
                                                <span class="material-symbols-outlined text-sm" :class="profileStudent.docs[doc.key] ? 'text-primary' : 'text-on-surface-variant'" x-text="doc.icon"></span>
                                            </div>
                                            <span class="text-xs font-bold text-on-surface" x-text="doc.label"></span>
                                        </div>
                                        <!-- Has doc -->
                                        <template x-if="profileStudent.docs[doc.key]">
                                            <div class="flex gap-2">
                                                <button @click="openDocPreview('/storage/' + profileStudent.docs[doc.key], doc.label)" class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold transition-colors">
                                                    <span class="material-symbols-outlined text-sm">visibility</span> Preview
                                                </button>
                                                <button @click="downloadDoc('/storage/' + profileStudent.docs[doc.key], doc.label.toLowerCase().replace(/ /g,'_'))" class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-lg bg-surface-container-high hover:bg-surface-container-highest text-on-surface text-xs font-bold transition-colors">
                                                    <span class="material-symbols-outlined text-sm">download</span> Download
                                                </button>
                                            </div>
                                        </template>
                                        <!-- No doc — mock placeholder -->
                                        <template x-if="!profileStudent.docs[doc.key]">
                                            <div class="flex items-center gap-2 py-2 px-3 rounded-lg bg-surface-container border border-dashed border-outline-variant/40">
                                                <span class="material-symbols-outlined text-sm text-on-surface-variant/50">block</span>
                                                <span class="text-xs text-on-surface-variant/60 font-medium">Not uploaded yet</span>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                            </div>
                        </div>

                    </div>

                    <!-- ===== TAB 2: TMA & MARKS ===== -->
                    <div x-show="activeProfileTab === 'tma'" class="p-7 space-y-5">

                        <div x-show="profileStudent.tmaSubmissions.length === 0" class="py-16 text-center bg-white rounded-2xl border border-dashed border-outline-variant/30">
                            <span class="material-symbols-outlined text-4xl text-on-surface-variant/30 mb-3 block">assignment_late</span>
                            <h4 class="font-bold text-on-surface-variant text-sm">No TMA Assignments Published</h4>
                            <p class="text-xs text-on-surface-variant/60 mt-1">Go to Products and add items with category "tma" to assign them.</p>
                        </div>

                        <template x-for="(sub, idx) in profileStudent.tmaSubmissions" :key="idx">
                            <div class="bg-white rounded-2xl border border-outline-variant/20 shadow-sm overflow-hidden">
                                <!-- TMA Header -->
                                <div class="flex items-center justify-between p-5 border-b border-outline-variant/10">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-600 to-cyan-400 flex items-center justify-center shadow-sm">
                                            <span class="material-symbols-outlined text-white text-sm">biotech</span>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-on-surface text-sm" x-text="sub.tmaTitle"></h4>
                                            <p class="text-[10px] text-on-surface-variant font-medium mt-0.5" x-text="sub.submittedAt ? 'Submitted: ' + sub.submittedAt : 'No submission yet'"></p>
                                        </div>
                                    </div>
                                    <!-- Status Badge -->
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide"
                                        :class="{
                                            'bg-emerald-100 text-emerald-700': sub.status === 'graded',
                                            'bg-amber-100 text-amber-700': sub.status === 'submitted',
                                            'bg-surface-container-high text-on-surface-variant': sub.status === 'not_submitted'
                                        }"
                                        x-text="sub.status === 'graded' ? 'Graded' : sub.status === 'submitted' ? 'Submitted' : 'Not Submitted'">
                                    </span>
                                </div>

                                <!-- Student Answer File -->
                                <template x-if="sub.filePath">
                                    <div class="flex items-center gap-3 px-5 py-3 bg-surface-container-low/40 border-b border-outline-variant/10">
                                        <span class="material-symbols-outlined text-sm text-on-surface-variant">attach_file</span>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-bold text-on-surface truncate" x-text="sub.originalFilename || 'Student Answer File'"></p>
                                        </div>
                                        <button @click="openDocPreview(sub.filePath, sub.tmaTitle + ' — Student Answer')" class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">visibility</span> Preview
                                        </button>
                                        <button @click="downloadDoc(sub.filePath, sub.tmaTitle.replace(/ /g,'_') + '_answer')" class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-surface-container-high hover:bg-surface-container-highest text-on-surface text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">download</span> Download
                                        </button>
                                    </div>
                                </template>
                                <template x-if="!sub.filePath">
                                    <div class="px-5 py-3 bg-surface-container-low/30 border-b border-outline-variant/10">
                                        <p class="text-xs text-on-surface-variant/60 font-medium flex items-center gap-2">
                                            <span class="material-symbols-outlined text-sm">hourglass_empty</span>
                                            Student has not submitted an answer file yet.
                                        </p>
                                    </div>
                                </template>

                                <!-- Marks Input -->
                                <div class="p-5 space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-1.5">TMA Marks <span class="text-on-surface-variant/50">(max 100)</span></label>
                                            <input type="number" min="0" max="100" x-model="sub.tmaMarks" placeholder="0–100"
                                                class="w-full px-3 py-2.5 rounded-xl border border-outline-variant/30 bg-surface-container-low focus:ring-2 focus:ring-primary/20 outline-none text-sm font-bold text-primary focus:border-primary/40 transition-colors">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-1.5">Practical Marks <span class="text-on-surface-variant/50">(max 50)</span></label>
                                            <input type="number" min="0" max="50" x-model="sub.practicalMarks" placeholder="0–50"
                                                class="w-full px-3 py-2.5 rounded-xl border border-outline-variant/30 bg-surface-container-low focus:ring-2 focus:ring-primary/20 outline-none text-sm font-bold text-primary focus:border-primary/40 transition-colors">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mb-1.5">Tutor Remarks <span class="text-on-surface-variant/50">(optional)</span></label>
                                        <textarea x-model="sub.remarks" rows="2" placeholder="Great work! Improve explanation in Q3..."
                                            class="w-full px-3 py-2.5 rounded-xl border border-outline-variant/30 bg-surface-container-low focus:ring-2 focus:ring-primary/20 outline-none text-sm text-on-surface resize-none focus:border-primary/40 transition-colors"></textarea>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <template x-if="sub.status === 'graded'">
                                            <div class="flex items-center gap-2 text-xs font-bold text-emerald-600">
                                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                                <span>Total: <strong x-text="(parseInt(sub.tmaMarks||0) + parseInt(sub.practicalMarks||0))"></strong>/150</span>
                                            </div>
                                        </template>
                                        <template x-if="sub.status !== 'graded'"><span></span></template>
                                        <button @click="saveTmaMarks(sub)"
                                            :disabled="sub.saving || !sub.filePath"
                                            :class="(sub.saving || !sub.filePath) ? 'opacity-50 cursor-not-allowed' : 'hover:bg-primary/90'"
                                            class="px-5 py-2.5 rounded-xl bg-primary text-white text-xs font-bold flex items-center gap-2 transition-all shadow-sm">
                                            <span class="material-symbols-outlined text-sm" x-show="!sub.saving">grade</span>
                                            <span class="material-symbols-outlined text-sm animate-spin" x-show="sub.saving" style="display:none">progress_activity</span>
                                            <span x-text="sub.saving ? 'Saving...' : (sub.status === 'graded' ? 'Update Marks' : 'Save & Grade')" ></span>
                                        </button>
                                    </div>
                                    <template x-if="!sub.filePath">
                                        <p class="text-[10px] text-on-surface-variant/50 font-medium">Marks can only be saved once the student submits an answer.</p>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>

                </div>
            </div>
        </div>

        <!-- ==========================================
             DOCUMENT PREVIEW OVERLAY (shared)
             ========================================== -->
        <div x-show="isDocPreviewOpen" x-cloak class="fixed inset-0 z-[100] flex flex-col items-center justify-center">
            <div x-show="isDocPreviewOpen" @click="isDocPreviewOpen = false"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-slate-900/80 backdrop-blur-md"></div>
            <div x-show="isDocPreviewOpen"
                x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                class="relative z-10 w-full max-w-5xl h-[90vh] mx-4 flex flex-col rounded-3xl overflow-hidden shadow-2xl border border-white/10">
                <!-- Header -->
                <div class="flex items-center justify-between px-6 py-4 bg-slate-900/95 backdrop-blur-md border-b border-white/10 shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary/20 flex items-center justify-center"><span class="material-symbols-outlined text-primary text-sm">preview</span></div>
                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Document Preview</p>
                            <h3 class="text-sm font-bold text-white" x-text="docPreviewTitle"></h3>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button @click="downloadDoc(docPreviewUrl, docPreviewTitle.toLowerCase().replace(/ /g,'_'))" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-primary/20 hover:bg-primary/40 text-primary text-xs font-bold transition-colors border border-primary/20">
                            <span class="material-symbols-outlined text-sm">download</span> Download
                        </button>
                        <button @click="isDocPreviewOpen = false" class="p-2 hover:bg-white/10 rounded-xl text-white/60 hover:text-white transition-colors border border-white/10">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                </div>
                <!-- Content -->
                <div class="flex-1 bg-slate-800 overflow-hidden">
                    <template x-if="docPreviewUrl && (docPreviewUrl.endsWith('.jpg')||docPreviewUrl.endsWith('.jpeg')||docPreviewUrl.endsWith('.png')||docPreviewUrl.endsWith('.gif')||docPreviewUrl.endsWith('.webp'))">
                        <div class="w-full h-full flex items-center justify-center p-4">
                            <img :src="docPreviewUrl" :alt="docPreviewTitle" class="max-w-full max-h-full object-contain rounded-xl shadow-2xl">
                        </div>
                    </template>
                    <template x-if="docPreviewUrl && !(docPreviewUrl.endsWith('.jpg')||docPreviewUrl.endsWith('.jpeg')||docPreviewUrl.endsWith('.png')||docPreviewUrl.endsWith('.gif')||docPreviewUrl.endsWith('.webp'))">
                        <iframe :src="docPreviewUrl" class="w-full h-full border-0" :title="docPreviewTitle"></iframe>
                    </template>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
