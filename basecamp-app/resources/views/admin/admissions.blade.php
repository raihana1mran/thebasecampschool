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
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 40px 60px -15px rgba(42, 48, 49, 0.05);
        }
        .ghost-border {
            border: 1px solid rgba(168, 174, 176, 0.15);
        }
        .signature-gradient {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
        }
        .active-dot {
            box-shadow: 0 0 12px #40cef3;
        }
        @keyframes drift {
            from { transform: translate(0, 0); }
            to { transform: translate(20px, 40px); }
        }
        .bg-blob {
            filter: blur(80px);
            animation: drift 10s infinite alternate ease-in-out;
        }
    </style>

    <div x-data="{
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
                        id: '{{ $admission->id }}',
                        name: '{{ addslashes($admission->full_name) }}',
                        email: '{{ addslashes($admission->email) }}',
                        phone: '{{ addslashes($admission->mobile_number) }}',
                        course: '{{ $admission->course_type === '10th' ? '10th Grade' : '12th Grade' }}',
                        status: '{{ $admission->status }}',
                        createdAt: '{{ $admission->created_at->format('Y-m-d') }}'
                    },
                @endforeach
            ];
            
            admissionsData.forEach(row => {
                csvContent += `"${row.id}","${row.name}","${row.email}","${row.phone}","${row.course}","${row.status}","${row.createdAt}"\n`;
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
    }" class="relative w-full min-h-screen">

        <!-- Atmospheric Background Layers -->
        <div class="fixed inset-0 z-[-1] overflow-hidden">
            <div class="bg-blob absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-primary-container/20 rounded-full"></div>
            <div class="bg-blob absolute bottom-[-5%] right-[5%] w-[600px] h-[600px] bg-tertiary-container/10 rounded-full" style="animation-delay: -5s;"></div>
        </div>

        <!-- Header Section -->
        <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <nav class="flex items-center gap-2 text-on-surface-variant text-sm font-medium mb-2">
                    <span>Admin</span>
                    <span class="material-symbols-outlined text-xs">chevron_right</span>
                    <span class="text-primary font-bold">Enrollment Operations</span>
                </nav>
                <h1 class="text-4xl md:text-5xl font-bold tracking-tighter text-on-surface leading-none">Enrollment Operations</h1>
            </div>
            <div class="flex items-center gap-3">
                <button @click="exportCSV()" class="flex items-center gap-2 px-5 py-3 rounded-xl border ghost-border font-bold text-sm bg-white hover:bg-surface-container-low transition-colors text-on-surface">
                    <span class="material-symbols-outlined text-lg">download</span>
                    Export CSV
                </button>
                <a href="{{ route('admin.admissions.create') }}" class="flex items-center gap-2 px-6 py-3 rounded-xl signature-gradient text-on-primary font-bold text-sm shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform active:scale-95">
                    <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">add</span>
                    Create New Student
                </a>
            </div>
        </header>

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

        <!-- Metrics Row: Glassmorphic Bento -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Applications Card -->
            <div class="glass-card p-6 rounded-3xl relative overflow-hidden group border border-outline-variant/10">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-7xl text-primary">description</span>
                </div>
                <p class="text-on-surface-variant text-sm font-bold uppercase tracking-widest mb-1">Applications Today</p>
                <div class="flex items-baseline gap-3">
                    <h2 class="text-5xl font-black tracking-tighter text-on-surface">{{ $todayCount }}</h2>
                    <span class="flex items-center text-primary text-sm font-bold bg-primary-container/20 px-2 py-0.5 rounded-full">
                        <span class="material-symbols-outlined text-xs mr-0.5">trending_up</span>
                        Active
                    </span>
                </div>
                <p class="text-xs text-on-surface-variant mt-4 font-medium italic">New applications submitted today</p>
            </div>
            <!-- Pending Approval Card -->
            <div class="glass-card p-6 rounded-3xl border-l-4 border-l-error relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-7xl text-error">priority_high</span>
                </div>
                <p class="text-on-surface-variant text-sm font-bold uppercase tracking-widest mb-1">Pending Approval</p>
                <div class="flex items-baseline gap-3">
                    <h2 class="text-5xl font-black tracking-tighter text-on-surface">{{ $pendingCount }}</h2>
                    @if($pendingCount > 0)
                        <span class="flex items-center text-error text-[10px] font-black bg-error-container/10 px-2 py-0.5 rounded-md uppercase tracking-tighter animate-pulse">
                            Urgent
                        </span>
                    @endif
                </div>
                <p class="text-xs text-on-surface-variant mt-4 font-medium italic">Requires verification and review</p>
            </div>
            <!-- Processing Time Card -->
            <div class="glass-card p-6 rounded-3xl relative overflow-hidden group border border-outline-variant/10">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-7xl text-secondary">speed</span>
                </div>
                <p class="text-on-surface-variant text-sm font-bold uppercase tracking-widest mb-1">Avg. Processing Time</p>
                <div class="flex items-baseline gap-3">
                    <h2 class="text-5xl font-black tracking-tighter text-on-surface">18.5h</h2>
                    <span class="flex items-center text-primary text-sm font-bold bg-primary-container/20 px-2 py-0.5 rounded-full">
                        -4h goal
                    </span>
                </div>
                <p class="text-xs text-on-surface-variant mt-4 font-medium italic">Baseline target: 22h</p>
            </div>
        </section>

        <!-- Filter Bar -->
        <section class="mb-6 flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[240px]">
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant">search</span>
                    <input x-model="search" class="w-full bg-surface-container-low/50 border-none rounded-xl pl-12 pr-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 placeholder:text-on-surface-variant/60 font-medium text-on-surface" placeholder="Search applicant by name or email..." type="text"/>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <div class="relative group">
                    <select x-model="streamFilter" class="appearance-none bg-white/50 border border-outline-variant/30 rounded-xl px-4 py-3 pr-10 text-sm font-medium focus:ring-2 focus:ring-primary/20 outline-none cursor-pointer text-on-surface">
                        <option value="All">Academic Stream: All</option>
                        <option value="Medical">Medical</option>
                        <option value="Engineering">Engineering</option>
                        <option value="Foundation">Foundation</option>
                        <option value="Pending">Pending</option>
                    </select>
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant pointer-events-none">expand_more</span>
                </div>
                <div class="relative group">
                    <select x-model="gradeFilter" class="appearance-none bg-white/50 border border-outline-variant/30 rounded-xl px-4 py-3 pr-10 text-sm font-medium focus:ring-2 focus:ring-primary/20 outline-none cursor-pointer text-on-surface">
                        <option value="All">Grade Level: All</option>
                        <option value="10th">10th Grade</option>
                        <option value="12th">12th Grade</option>
                    </select>
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant pointer-events-none">expand_more</span>
                </div>
                <div class="relative group">
                    <select x-model="statusFilter" class="appearance-none bg-white/50 border border-outline-variant/30 rounded-xl px-4 py-3 pr-10 text-sm font-medium focus:ring-2 focus:ring-primary/20 outline-none cursor-pointer text-on-surface">
                        <option value="All">Status: All</option>
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant pointer-events-none">filter_list</span>
                </div>
                <button @click="search = ''; streamFilter = 'All'; gradeFilter = 'All'; statusFilter = 'All';" class="p-3 bg-white/50 border border-outline-variant/30 rounded-xl hover:bg-surface-container-low transition-colors flex items-center justify-center" title="Reset Filters">
                    <span class="material-symbols-outlined text-sm">tune</span>
                </button>
            </div>
        </section>

        <!-- Enrollment Queue Table -->
        <section class="glass-card rounded-[2rem] overflow-hidden border border-outline-variant/10">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-outline-variant/10 bg-surface-container-low/20">
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-on-surface-variant">Applicant Name</th>
                            <th class="px-6 py-5 text-xs font-black uppercase tracking-widest text-on-surface-variant">Stream / Grade</th>
                            <th class="px-6 py-5 text-xs font-black uppercase tracking-widest text-on-surface-variant">Submission Date</th>
                            <th class="px-6 py-5 text-xs font-black uppercase tracking-widest text-on-surface-variant">Status</th>
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-on-surface-variant text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse($admissions as $admission)
                            @php
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
                                
                                // Dynamic stream and grade mapping
                                $grade = 'Grade ' . ($admission->course_type === '10th' ? '10' : '12');
                                
                                $stream = 'Pending';
                                if ($admission->course_type === '10th') {
                                    $stream = 'Foundation';
                                } elseif ($admission->course_type === '12th') {
                                    $stream = ($admission->id % 2 === 0) ? 'Engineering' : 'Medical';
                                }
                                
                                // Dynamic Status
                                $statusText = 'Pending Review';
                                $statusBadgeClass = 'bg-primary-container/20 text-primary';
                                $statusDotClass = 'bg-primary active-dot';
                                
                                if ($admission->status === 'Approved') {
                                    $statusText = 'Approved';
                                    $statusBadgeClass = 'bg-green-100 text-green-700';
                                    $statusDotClass = 'bg-green-600';
                                } elseif ($admission->status === 'Rejected') {
                                    $statusText = 'Rejected';
                                    $statusBadgeClass = 'bg-error-container/10 text-error';
                                    $statusDotClass = 'bg-error';
                                } elseif ($admission->status === 'Document Error') {
                                    $statusText = 'Document Error';
                                    $statusBadgeClass = 'bg-amber-100 text-amber-800 border border-amber-200/50';
                                    $statusDotClass = 'bg-amber-600';
                                }
                            @endphp
                            <!-- Table Row -->
                            <tr 
                                x-show="(search === '' || '{{ strtolower($admission->full_name) }}'.includes(search.toLowerCase()) || '{{ strtolower($admission->email) }}'.includes(search.toLowerCase()) || '{{ $admission->id }}'.includes(search.toLowerCase())) &&
                                        (streamFilter === 'All' || streamFilter === '{{ $stream }}') &&
                                        (gradeFilter === 'All' || gradeFilter === '{{ $admission->course_type === '10th' ? '10th' : '12th' }}') &&
                                        (statusFilter === 'All' || statusFilter === '{{ $admission->status }}')"
                                class="hover:bg-surface-container-lowest/50 hover:-translate-y-0.5 transition-all duration-300 group"
                            >
                                <td class="px-8 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full signature-gradient flex items-center justify-center text-on-primary font-bold text-sm shadow-md flex-shrink-0">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-on-surface">{{ $admission->full_name }}</div>
                                            <div class="text-xs text-on-surface-variant font-medium">{{ $admission->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-sm text-on-surface">{{ $stream }}</span>
                                        <span class="text-xs text-on-surface-variant font-medium">{{ $grade }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-on-surface-variant">{{ $admission->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $statusBadgeClass }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $statusDotClass }}"></span>
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Review Details Button -->
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
                                            class="p-2 rounded-lg hover:bg-surface-container-high transition-colors text-on-surface-variant hover:text-primary flex items-center justify-center" 
                                            title="View Documents / Details"
                                        >
                                            <span class="material-symbols-outlined text-xl">visibility</span>
                                        </button>
                                        <!-- Approve Action -->
                                        @if($admission->status !== 'Approved')
                                            <button @click="updateStatus({{ $admission->id }}, 'Approved')" class="p-2 rounded-lg hover:bg-surface-container-high transition-colors text-on-surface-variant hover:text-green-600 flex items-center justify-center" title="Approve Application">
                                                <span class="material-symbols-outlined text-xl">check_circle</span>
                                            </button>
                                        @endif
                                        <!-- Mark Pending Action -->
                                        @if($admission->status !== 'Pending')
                                            <button @click="updateStatus({{ $admission->id }}, 'Pending')" class="p-2 rounded-lg hover:bg-surface-container-high transition-colors text-on-surface-variant hover:text-amber-500 flex items-center justify-center" title="Mark Pending">
                                                <span class="material-symbols-outlined text-xl">schedule</span>
                                            </button>
                                        @endif
                                        <!-- Document Error Action -->
                                        @if($admission->status !== 'Document Error')
                                            <button @click="updateStatus({{ $admission->id }}, 'Document Error')" class="p-2 rounded-lg hover:bg-surface-container-high transition-colors text-on-surface-variant hover:text-orange-500 flex items-center justify-center" title="Document Error">
                                                <span class="material-symbols-outlined text-xl">assignment_late</span>
                                            </button>
                                        @endif
                                        <!-- Reject Action -->
                                        @if($admission->status !== 'Rejected')
                                            <button @click="updateStatus({{ $admission->id }}, 'Rejected')" class="p-2 rounded-lg hover:bg-surface-container-high transition-colors text-on-surface-variant hover:text-error flex items-center justify-center" title="Reject Application">
                                                <span class="material-symbols-outlined text-xl">cancel</span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-24 text-center">
                                    <div class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center mb-6 mx-auto text-primary">
                                        <span class="material-symbols-outlined text-4xl">assignment</span>
                                    </div>
                                    <h3 class="text-3xl font-bold tracking-tight mb-3 text-primary">No Admissions Found</h3>
                                    <p class="text-lg text-on-surface-variant max-w-md mx-auto leading-relaxed">
                                        There are no admission applications matching your criteria.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="p-6 bg-surface-container-low/20 border-t border-outline-variant/10 flex items-center justify-between">
                <p class="text-sm font-medium text-on-surface-variant">Showing <span class="text-on-surface font-bold">{{ $admissions->count() }}</span> admissions total</p>
                <div class="flex items-center gap-2">
                    <button class="p-2 rounded-lg border border-outline-variant/20 disabled:opacity-30 flex items-center justify-center bg-white" disabled>
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg signature-gradient text-on-primary text-sm font-bold shadow-md">1</button>
                    <button class="p-2 rounded-lg border border-outline-variant/20 disabled:opacity-30 flex items-center justify-center bg-white" disabled>
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- Detailed Review Modal -->
        <div x-show="isReviewModalOpen" class="fixed inset-0 z-50 flex items-center justify-center px-4" style="display: none;">
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
                        <h3 class="text-sm font-extrabold tracking-widest text-primary uppercase mb-3">Student Information</h3>
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
                        <h3 class="text-sm font-extrabold tracking-widest text-primary uppercase mb-3">Submitted Documents</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <!-- Photo -->
                            <template x-if="selectedAdmission.documents && selectedAdmission.documents.photo">
                                <div class="p-4 bg-surface-container rounded-xl border border-outline-variant/20 shadow-sm">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-primary text-sm">image</span>
                                        </div>
                                        <div class="text-xs font-bold text-on-surface">Student Photo</div>
                                    </div>
                                    <div class="flex gap-2">
                                        <button @click="openDocPreview('/storage/' + selectedAdmission.documents.photo, 'Student Photo')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                            Preview
                                        </button>
                                        <button @click="downloadDoc('/storage/' + selectedAdmission.documents.photo, 'student_photo')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-high hover:bg-outline-variant/20 text-on-surface text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">download</span>
                                            Download
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <!-- Signature -->
                            <template x-if="selectedAdmission.documents && selectedAdmission.documents.signature">
                                <div class="p-4 bg-surface-container rounded-xl border border-outline-variant/20 shadow-sm">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-primary text-sm">draw</span>
                                        </div>
                                        <div class="text-xs font-bold text-on-surface">Signature</div>
                                    </div>
                                    <div class="flex gap-2">
                                        <button @click="openDocPreview('/storage/' + selectedAdmission.documents.signature, 'Signature')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                            Preview
                                        </button>
                                        <button @click="downloadDoc('/storage/' + selectedAdmission.documents.signature, 'signature')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-high hover:bg-outline-variant/20 text-on-surface text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">download</span>
                                            Download
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <!-- ID Proof -->
                            <template x-if="selectedAdmission.documents && selectedAdmission.documents.idProof">
                                <div class="p-4 bg-surface-container rounded-xl border border-outline-variant/20 shadow-sm">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-primary text-sm">badge</span>
                                        </div>
                                        <div class="text-xs font-bold text-on-surface">ID Proof Document</div>
                                    </div>
                                    <div class="flex gap-2">
                                        <button @click="openDocPreview('/storage/' + selectedAdmission.documents.idProof, 'ID Proof')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                            Preview
                                        </button>
                                        <button @click="downloadDoc('/storage/' + selectedAdmission.documents.idProof, 'id_proof')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-high hover:bg-outline-variant/20 text-on-surface text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">download</span>
                                            Download
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <!-- Marksheet -->
                            <template x-if="selectedAdmission.documents && selectedAdmission.documents.previousMarksheet">
                                <div class="p-4 bg-surface-container rounded-xl border border-outline-variant/20 shadow-sm">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-primary text-sm">text_snippet</span>
                                        </div>
                                        <div class="text-xs font-bold text-on-surface">Marksheet / Transcript</div>
                                    </div>
                                    <div class="flex gap-2">
                                        <button @click="openDocPreview('/storage/' + selectedAdmission.documents.previousMarksheet, 'Marksheet')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                            Preview
                                        </button>
                                        <button @click="downloadDoc('/storage/' + selectedAdmission.documents.previousMarksheet, 'marksheet')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-high hover:bg-outline-variant/20 text-on-surface text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">download</span>
                                            Download
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <!-- Address Proof -->
                            <template x-if="selectedAdmission.documents && selectedAdmission.documents.addressProof">
                                <div class="p-4 bg-surface-container rounded-xl border border-outline-variant/20 shadow-sm">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-primary text-sm">home_pin</span>
                                        </div>
                                        <div class="text-xs font-bold text-on-surface">Address Proof</div>
                                    </div>
                                    <div class="flex gap-2">
                                        <button @click="openDocPreview('/storage/' + selectedAdmission.documents.addressProof, 'Address Proof')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                            Preview
                                        </button>
                                        <button @click="downloadDoc('/storage/' + selectedAdmission.documents.addressProof, 'address_proof')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-high hover:bg-outline-variant/20 text-on-surface text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">download</span>
                                            Download
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <!-- Category Certificate -->
                            <template x-if="selectedAdmission.documents && selectedAdmission.documents.categoryCertificate">
                                <div class="p-4 bg-surface-container rounded-xl border border-outline-variant/20 shadow-sm">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-primary text-sm">workspace_premium</span>
                                        </div>
                                        <div class="text-xs font-bold text-on-surface">Category Certificate</div>
                                    </div>
                                    <div class="flex gap-2">
                                        <button @click="openDocPreview('/storage/' + selectedAdmission.documents.categoryCertificate, 'Category Certificate')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                            Preview
                                        </button>
                                        <button @click="downloadDoc('/storage/' + selectedAdmission.documents.categoryCertificate, 'category_certificate')" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-high hover:bg-outline-variant/20 text-on-surface text-xs font-bold transition-colors">
                                            <span class="material-symbols-outlined text-sm">download</span>
                                            Download
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
                    <button type="button" @click="updateStatus(selectedAdmission.id, 'Approved'); isReviewModalOpen = false;" class="px-5 py-2.5 rounded-xl font-bold signature-gradient text-white shadow-md hover:shadow-lg transition-all text-sm">
                        Approve Application
                    </button>
                </div>
            </div>
        </div>

        <!-- Quick Add Student Modal -->
        <div x-show="isAddStudentModalOpen" class="fixed inset-0 z-50 flex items-center justify-center px-4" style="display: none;">
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
                class="glass-card w-full max-w-md bg-white p-8 rounded-3xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface"
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

        <!-- Document Preview Overlay Modal -->
        <div x-show="isPreviewOpen" class="fixed inset-0 z-[100] flex flex-col items-center justify-center" style="display: none;">
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
                            <span class="material-symbols-outlined text-sm">download</span>
                            Download
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
</x-admin-layout>
