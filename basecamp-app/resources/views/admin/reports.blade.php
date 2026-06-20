<x-admin-layout>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(42, 48, 49, 0.04);
        }
        .animated-gradient-text {
            background: linear-gradient(135deg, #006479, #40cef3, #005bae);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shine 5s linear infinite;
        }
        @keyframes shine { to { background-position: 200% center; } }
        .cyan-glow-button {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
            box-shadow: 0 4px 20px rgba(64, 206, 243, 0.25);
            color: #e0f6ff;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 100, 121, 0.1);
            border-radius: 10px;
        }
        [x-cloak] { display: none !important; }
    </style>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Atmospheric blobs -->
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary-container/10 rounded-full blur-[120px] pointer-events-none -z-10"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-secondary-container/10 rounded-full blur-[120px] pointer-events-none -z-10"></div>

    <div class="w-full space-y-10 pb-20">

        <!-- Header -->
        <header class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <p class="text-primary font-bold tracking-[0.2em] text-xs uppercase">Administrative Portal</p>
                <h3 class="font-display text-4xl font-extrabold tracking-tighter animated-gradient-text mt-1">Reports &amp; Analytics</h3>
                <p class="text-on-surface-variant text-sm mt-1 font-medium">Institutional intelligence dashboard — live data overview.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.reports.admissions') }}" class="bg-surface-container-lowest/70 backdrop-blur-lg border border-outline-variant/20 px-5 py-2.5 rounded-full font-semibold text-sm flex items-center gap-2 hover:bg-surface-container-high transition-all">
                    <span class="material-symbols-outlined text-primary text-[20px]">description</span>
                    Generate Report
                </a>
            </div>
        </header>

        <!-- KPI Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Total Enrollment -->
            <div class="glass-card p-6 rounded-xl group hover:scale-[1.02] transition-all duration-500">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-primary/10 rounded-xl text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                        <span class="material-symbols-outlined">group_add</span>
                    </div>
                    <span class="text-xs font-bold text-primary px-2 py-1 bg-primary-container/20 rounded-full">LIVE</span>
                </div>
                <p class="text-on-surface-variant text-sm font-medium">Total Enrollment</p>
                <h3 class="text-3xl font-bold mt-1 tracking-tight">{{ number_format($totalStudents) }}</h3>
            </div>

            <!-- Net Revenue -->
            <div class="glass-card p-6 rounded-xl group hover:scale-[1.02] transition-all duration-500">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-secondary/10 rounded-xl text-secondary group-hover:bg-secondary group-hover:text-on-secondary transition-colors">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <span class="text-xs font-bold text-secondary px-2 py-1 bg-secondary-container/20 rounded-full">LIVE</span>
                </div>
                <p class="text-on-surface-variant text-sm font-medium">Net Revenue</p>
                <h3 class="text-3xl font-bold mt-1 tracking-tight">₹{{ number_format($totalRevenue, 0) }}</h3>
            </div>

            <!-- TMA Completion -->
            <div class="glass-card p-6 rounded-xl group hover:scale-[1.02] transition-all duration-500">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-tertiary/10 rounded-xl text-tertiary group-hover:bg-tertiary group-hover:text-on-tertiary transition-colors">
                        <span class="material-symbols-outlined">task_alt</span>
                    </div>
                    <span class="text-xs font-bold text-tertiary px-2 py-1 bg-tertiary-container/20 rounded-full">LIVE</span>
                </div>
                <p class="text-on-surface-variant text-sm font-medium">TMA Completion</p>
                <h3 class="text-3xl font-bold mt-1 tracking-tight">{{ $tmaCompletionRate }}%</h3>
            </div>

            <!-- Pending Admissions -->
            <div class="glass-card p-6 rounded-xl group hover:scale-[1.02] transition-all duration-500">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-error/10 rounded-xl text-error group-hover:bg-error group-hover:text-on-error transition-colors">
                        <span class="material-symbols-outlined">trending_up</span>
                    </div>
                    <span class="text-xs font-bold text-error px-2 py-1 bg-error-container/10 rounded-full">LIVE</span>
                </div>
                <p class="text-on-surface-variant text-sm font-medium">Pending Admissions</p>
                <h3 class="text-3xl font-bold mt-1 tracking-tight">{{ $pendingAdmissions }}</h3>
            </div>
        </div>

        <!-- Main Chart Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Monthly Admissions Trend (wide) -->
            <div class="glass-card p-8 rounded-xl lg:col-span-2 relative overflow-hidden">
                <div class="flex justify-between items-center mb-6 flex-wrap gap-3">
                    <div>
                        <h4 class="text-xl font-bold">Monthly Admissions Trend</h4>
                        <p class="text-sm text-on-surface-variant">Student intake — current year</p>
                    </div>
                    <div class="flex gap-2">
                        <span class="flex items-center gap-1.5 text-xs font-bold text-primary">
                            <span class="w-3 h-0.5 bg-primary rounded-full inline-block"></span>
                            Admissions
                        </span>
                    </div>
                </div>
                <div class="h-64 w-full">
                    <canvas id="admissionsChart"></canvas>
                </div>
            </div>

            <!-- Doughnut: TMA Completion -->
            <div class="glass-card p-8 rounded-xl flex flex-col items-center justify-center text-center">
                <h4 class="text-xl font-bold mb-1">TMA/Exam Completion</h4>
                <p class="text-sm text-on-surface-variant mb-6">Aggregate success metrics</p>
                <div class="relative w-44 h-44">
                    <canvas id="completionChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-4xl font-extrabold text-primary">{{ $tmaCompletionRate }}%</span>
                        <span class="text-[10px] uppercase font-bold tracking-widest text-on-surface-variant">Completion</span>
                    </div>
                </div>
                <div class="mt-6 w-full space-y-2 text-left">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-on-surface-variant">Graded Submissions</span>
                        <span class="text-primary font-bold">{{ $gradedTma }}</span>
                    </div>
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-on-surface-variant">Pending Review</span>
                        <span class="text-error font-bold">{{ $pendingTma }}</span>
                    </div>
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-on-surface-variant">Total Submissions</span>
                        <span class="font-bold">{{ $totalTma }}</span>
                    </div>
                </div>
            </div>

            <!-- Bar: Revenue Growth -->
            <div class="glass-card p-8 rounded-xl flex flex-col">
                <h4 class="text-xl font-bold mb-1">Revenue Overview</h4>
                <p class="text-sm text-on-surface-variant mb-6">Payment totals by type</p>
                <div class="flex-1 min-h-[220px]">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Pie: Student Status -->
            <div class="glass-card p-8 rounded-xl lg:col-span-2">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h4 class="text-xl font-bold">Student Lifecycle Status</h4>
                        <p class="text-sm text-on-surface-variant">Current active vs non-active distribution</p>
                    </div>
                    <div class="p-2 bg-surface-container-high rounded-lg flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-xs font-medium">Live Data</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="h-52">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-surface-container-low rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-primary"></div>
                                <span class="text-sm font-medium">Active Students</span>
                            </div>
                            <span class="text-sm font-bold">{{ $activeStudents }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-surface-container-low rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-primary-container"></div>
                                <span class="text-sm font-medium">Approved (Enrolled)</span>
                            </div>
                            <span class="text-sm font-bold">{{ $approvedStudents }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-surface-container-low rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-on-surface-variant"></div>
                                <span class="text-sm font-medium">Pending / Other</span>
                            </div>
                            <span class="text-sm font-bold">{{ $pendingStudents }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-surface-container-low rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-error/60"></div>
                                <span class="text-sm font-medium">Rejected</span>
                            </div>
                            <span class="text-sm font-bold">{{ $rejectedStudents }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Reports Vault -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-2xl font-bold tracking-tight">Quick Reports Vault</h4>
                <a href="{{ route('admin.reports.admissions') }}" class="text-primary text-sm font-bold flex items-center gap-1 hover:underline">
                    View All
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5">

                <!-- Admission Report -->
                <a href="{{ route('admin.reports.admissions') }}" class="glass-card p-6 rounded-xl hover:bg-surface-container-lowest transition-all cursor-pointer group border-l-4 border-l-primary">
                    <div class="flex justify-between items-start mb-4">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">person_add</span>
                        <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary transition-colors">download</span>
                    </div>
                    <h5 class="font-bold text-sm mb-1">Admission Report</h5>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-widest font-bold">CSV • Live</p>
                    <div class="mt-4 pt-4 border-t border-outline-variant/10 text-[10px] text-on-surface-variant">
                        All admissions — {{ $totalAdmissions }} records
                    </div>
                </a>

                <!-- Revenue Report -->
                <a href="{{ route('admin.reports.revenue') }}" class="glass-card p-6 rounded-xl hover:bg-surface-container-lowest transition-all cursor-pointer group border-l-4 border-l-secondary">
                    <div class="flex justify-between items-start mb-4">
                        <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">account_balance_wallet</span>
                        <span class="material-symbols-outlined text-on-surface-variant group-hover:text-secondary transition-colors">download</span>
                    </div>
                    <h5 class="font-bold text-sm mb-1">Revenue Report</h5>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-widest font-bold">CSV • Live</p>
                    <div class="mt-4 pt-4 border-t border-outline-variant/10 text-[10px] text-on-surface-variant">
                        Total: ₹{{ number_format($totalRevenue, 0) }}
                    </div>
                </a>

                <!-- Eligible Students -->
                <a href="{{ route('admin.exams.eligible') }}" class="glass-card p-6 rounded-xl hover:bg-surface-container-lowest transition-all cursor-pointer group border-l-4 border-l-tertiary">
                    <div class="flex justify-between items-start mb-4">
                        <span class="material-symbols-outlined text-tertiary" style="font-variation-settings: 'FILL' 1;">quiz</span>
                        <span class="material-symbols-outlined text-on-surface-variant group-hover:text-tertiary transition-colors">download</span>
                    </div>
                    <h5 class="font-bold text-sm mb-1">Eligible Students</h5>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-widest font-bold">CSV • Live</p>
                    <div class="mt-4 pt-4 border-t border-outline-variant/10 text-[10px] text-on-surface-variant">
                        Approved with enrollment
                    </div>
                </a>

                <!-- TMA Report (link to TMA page) -->
                <a href="{{ route('admin.tma') }}" class="glass-card p-6 rounded-xl hover:bg-surface-container-lowest transition-all cursor-pointer group border-l-4 border-l-primary-dim">
                    <div class="flex justify-between items-start mb-4">
                        <span class="material-symbols-outlined text-primary-dim" style="font-variation-settings: 'FILL' 1;">assignment</span>
                        <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary-dim transition-colors">open_in_new</span>
                    </div>
                    <h5 class="font-bold text-sm mb-1">TMA Management</h5>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-widest font-bold">VIEW • Live</p>
                    <div class="mt-4 pt-4 border-t border-outline-variant/10 text-[10px] text-on-surface-variant">
                        {{ $totalTma }} total submissions
                    </div>
                </a>

                <!-- Student Report (link to students page) -->
                <a href="{{ route('admin.students') }}" class="glass-card p-6 rounded-xl hover:bg-surface-container-lowest transition-all cursor-pointer group border-l-4 border-l-outline">
                    <div class="flex justify-between items-start mb-4">
                        <span class="material-symbols-outlined text-outline" style="font-variation-settings: 'FILL' 1;">groups</span>
                        <span class="material-symbols-outlined text-on-surface-variant group-hover:text-outline transition-colors">open_in_new</span>
                    </div>
                    <h5 class="font-bold text-sm mb-1">Student Records</h5>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-widest font-bold">VIEW • Live</p>
                    <div class="mt-4 pt-4 border-t border-outline-variant/10 text-[10px] text-on-surface-variant">
                        {{ $totalStudents }} students total
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const primaryColor   = '#006479';
        const secondaryColor = '#006572';
        const tertiaryColor  = '#005bae';
        const mutedColor     = '#d6dee1';

        // ── Monthly Admissions Trend ──────────────────────────────
        const admissionsCtx = document.getElementById('admissionsChart');
        if (admissionsCtx) {
            new Chart(admissionsCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: @json($admissionMonths),
                    datasets: [{
                        label: 'Admissions',
                        data: @json($admissionCounts),
                        borderColor: primaryColor,
                        backgroundColor: 'rgba(0, 100, 121, 0.08)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 4,
                        pointHoverRadius: 7,
                        pointBackgroundColor: primaryColor,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            display: true,
                            grid: { color: 'rgba(168,174,176,0.1)' },
                            ticks: { color: '#575c5e', font: { family: 'Space Grotesk', size: 10 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#575c5e', font: { family: 'Space Grotesk', size: 11 } }
                        }
                    }
                }
            });
        }

        // ── Revenue by Type ───────────────────────────────────────
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            new Chart(revenueCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($revenueLabels),
                    datasets: [{
                        label: 'Revenue (₹)',
                        data: @json($revenueAmounts),
                        backgroundColor: [primaryColor, secondaryColor, tertiaryColor, mutedColor, '#a8aeb0'],
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx => '₹' + ctx.parsed.y.toLocaleString('en-IN')
                            }
                        }
                    },
                    scales: {
                        y: {
                            display: true,
                            grid: { color: 'rgba(168,174,176,0.1)' },
                            ticks: { color: '#575c5e', font: { family: 'Space Grotesk', size: 10 },
                                     callback: v => '₹' + (v >= 1000 ? (v/1000).toFixed(0)+'k' : v) }
                        },
                        x: { grid: { display: false }, ticks: { color: '#575c5e', font: { family: 'Space Grotesk', size: 10 } } }
                    }
                }
            });
        }

        // ── TMA Completion Doughnut ────────────────────────────────
        const completionCtx = document.getElementById('completionChart');
        if (completionCtx) {
            const rate = {{ $tmaCompletionRate }};
            new Chart(completionCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [rate, 100 - rate],
                        backgroundColor: [primaryColor, '#e3e9ec'],
                        borderWidth: 0,
                        cutout: '82%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { tooltip: { enabled: false } }
                }
            });
        }

        // ── Student Status Pie ────────────────────────────────────
        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            new Chart(statusCtx.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Active', 'Approved', 'Pending/Other', 'Rejected'],
                    datasets: [{
                        data: [
                            {{ $activeStudents }},
                            {{ $approvedStudents }},
                            {{ $pendingStudents }},
                            {{ $rejectedStudents }}
                        ],
                        backgroundColor: [primaryColor, '#40cef3', '#575c5e', '#b31b25'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: ctx => ctx.label + ': ' + ctx.parsed } }
                    }
                }
            });
        }
    });
    </script>
</x-admin-layout>
