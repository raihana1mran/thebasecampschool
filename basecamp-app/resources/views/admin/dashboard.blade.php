<x-admin-layout>
    <style>
        .glass-panel {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        .signature-gradient {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
        }
    </style>

    <div x-data="{
        isBroadcastModalOpen: false,
        broadcastAudience: 'all',
        broadcastSubject: '',
        broadcastMessage: '',
        showToast: false,
        toastMessage: '',
        documentAdmission: null,
        documentData: null,
        documentName: '',
        actionAdmission: null,
        actionDropdown: null,
        actionDropdownRect: null,
        sendingStatus: false,
        studentMsg: { show: false, id: null, name: '', email: '', subject: '', message: '', sending: false },

        // Modal state management
        activeModal: null,
        modalTitle: '',
        modalFields: {},

        // Action-specific form data
        formData: {},
        isFormUploading: false,

        openModal(name, title) {
            this.activeModal = name;
            this.modalTitle = title;
            this.formData = {};
        },
        closeModal() {
            this.activeModal = null;
            this.formData = {};
        },

        async submitAction(route, data) {
            try {
                const resp = await fetch(route, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: JSON.stringify(data)
                });
                const result = await resp.json();
                if (result.success) {
                    this.toastMessage = result.message;
                    this.showToast = true;
                    this.closeModal();
                    setTimeout(() => this.showToast = false, 4000);
                } else {
                    alert(result.message || 'Action failed.');
                }
            } catch {
                alert('Network error. Please try again.');
            }
        },

        async submitFormData(route, formId) {
            const form = document.getElementById(formId);
            if (!form) return;
            this.isFormUploading = true;
            try {
                const formData = new FormData(form);
                const resp = await fetch(route, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: formData
                });
                const result = await resp.json();
                if (result.success) {
                    this.toastMessage = result.message;
                    this.showToast = true;
                    this.closeModal();
                    setTimeout(() => this.showToast = false, 4000);
                } else {
                    alert(result.message || 'Action failed.');
                }
            } catch {
                alert('Network error. Please try again.');
            } finally {
                this.isFormUploading = false;
            }
        },

        openStudentMsg(id, name, email) {
            this.studentMsg = { show: true, id, name, email, subject: '', message: '', sending: false };
        },

        async sendStudentMsg() {
            if (!this.studentMsg.subject.trim() || !this.studentMsg.message.trim()) return;
            this.studentMsg.sending = true;
            try {
                const resp = await fetch('{{ route("admin.student.message") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({
                        email: this.studentMsg.email,
                        subject: this.studentMsg.subject,
                        message: this.studentMsg.message
                    })
                });
                const data = await resp.json();
                if (data.success) {
                    this.toastMessage = 'Message sent to ' + this.studentMsg.name;
                    this.showToast = true;
                    this.studentMsg.show = false;
                    setTimeout(() => this.showToast = false, 4000);
                } else {
                    alert('Failed to send message');
                }
            } catch {
                alert('Network error');
            } finally {
                this.studentMsg.sending = false;
            }
        },

        viewDocuments(docsJson, name) {
            this.documentData = JSON.parse(docsJson);
            this.documentName = name;
        },

        async updateStatus(admissionId, status, admissionIndex) {
            this.sendingStatus = true;
            try {
                const resp = await fetch('/admin/admissions/' + admissionId + '/status', {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ status: status })
                });
                const data = await resp.json();
                if (data.success) {
                    if (data.credentials) {
                        this.toastMessage = 'Student approved! Enrollment: ' + data.credentials.enrollment_number + ' | Password: ' + data.credentials.password;
                    } else {
                        this.toastMessage = 'Status updated to ' + status;
                    }
                    this.showToast = true;
                    this.actionDropdown = null;
                    this.actionAdmission = null;
                    setTimeout(() => this.showToast = false, 6000);
                }
            } catch (e) {
                alert('Failed to update status');
            } finally {
                this.sendingStatus = false;
            }
        },

        sendBroadcast() {
            fetch('/admin/message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    audience: this.broadcastAudience,
                    subject: this.broadcastSubject,
                    message: this.broadcastMessage
                })
            })
            .then(r => r.json())
            .then(data => {
                if(data.success) {
                    this.isBroadcastModalOpen = false;
                    this.toastMessage = 'Message sent to ' + this.broadcastAudience + ' successfully!';
                    this.showToast = true;
                    this.broadcastSubject = '';
                    this.broadcastMessage = '';
                    setTimeout(() => this.showToast = false, 4000);
                } else {
                    alert('Error: ' + (data.message || 'Something went wrong'));
                }
            })
            .catch(e => {
                console.error(e);
                alert('Failed to send broadcast');
            });
        }
    }">

    <!-- Header -->
    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6 sm:mb-8">
        <div>
            <div class="text-lg sm:text-xl md:text-2xl font-bold">{{ __('overview_title') }}</div>
            <p class="text-xs text-slate-500 font-medium mt-1">Monitor enrollments, active students, and recent activity</p>
        </div>
        <div class="flex items-center gap-2 sm:gap-4 w-full sm:w-auto">
            <button @click="isBroadcastModalOpen = true" class="p-1.5 sm:p-2 rounded-xl hover:bg-cyan-50 transition-all text-slate-600" title="Broadcast Message">
                <span class="material-symbols-outlined text-[20px] sm:text-[24px]">notifications</span>
            </button>
            <a href="{{ route('admin.admissions.create') }}" class="signature-gradient hover:opacity-90 hover:scale-[1.02] text-on-primary px-3 sm:px-5 py-1.5 sm:py-2 rounded-xl text-[11px] sm:text-xs md:text-sm font-bold transition-all shadow-lg shadow-cyan-500/20 flex items-center gap-1.5 whitespace-nowrap">
                <span class="material-symbols-outlined text-sm">add</span>
                New Enrollment
            </a>
        </div>
    </header>

    <!-- Stats -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 mb-6 sm:mb-8">
        <div class="glass-panel p-3 sm:p-4 md:p-5 rounded-2xl flex flex-col items-start">
            <span class="material-symbols-outlined text-[20px] text-primary mb-1">group</span>
            <p class="text-[9px] font-bold uppercase tracking-widest text-primary">Total Admissions</p>
            <p class="text-xl sm:text-2xl font-extrabold text-cyan-700 mt-auto">{{ $studentCount }}</p>
        </div>
        <div class="glass-panel p-3 sm:p-4 md:p-5 rounded-2xl flex flex-col items-start">
            <span class="material-symbols-outlined text-[20px] text-amber-600 mb-1">hourglass_empty</span>
            <p class="text-[9px] font-bold uppercase tracking-widest text-amber-600">Pending</p>
            <p class="text-xl sm:text-2xl font-extrabold text-amber-600 mt-auto">{{ $pendingAdmissions }}</p>
        </div>
        <div class="glass-panel p-3 sm:p-4 md:p-5 rounded-2xl flex flex-col items-start">
            <span class="material-symbols-outlined text-[20px] text-green-600 mb-1">check_circle</span>
            <p class="text-[9px] font-bold uppercase tracking-widest text-green-600">Approved</p>
            <p class="text-xl sm:text-2xl font-extrabold text-green-600 mt-auto">{{ $approvedAdmissions }}</p>
        </div>
        <div class="glass-panel p-3 sm:p-4 md:p-5 rounded-2xl flex flex-col items-start">
            <span class="material-symbols-outlined text-[20px] text-red-600 mb-1">cancel</span>
            <p class="text-[9px] font-bold uppercase tracking-widest text-red-600">Rejected</p>
            <p class="text-xl sm:text-2xl font-extrabold text-red-600 mt-auto">{{ $rejectedAdmissions }}</p>
        </div>
        <div class="glass-panel p-3 sm:p-4 md:p-5 rounded-2xl flex flex-col items-start">
            <span class="material-symbols-outlined text-[20px] text-emerald-600 mb-1">payments</span>
            <p class="text-[9px] font-bold uppercase tracking-widest text-emerald-600">Revenue</p>
            <p class="text-xl sm:text-2xl font-extrabold text-emerald-600 mt-auto">₹{{ number_format($totalRevenue) }}</p>
        </div>
        <div class="glass-panel p-3 sm:p-4 md:p-5 rounded-2xl flex flex-col items-start">
            <span class="material-symbols-outlined text-[20px] text-purple-600 mb-1">assignment</span>
            <p class="text-[9px] font-bold uppercase tracking-widest text-purple-600">Pending TMA</p>
            <p class="text-xl sm:text-2xl font-extrabold text-purple-600 mt-auto">{{ $pendingTma }}</p>
        </div>
    </div>

    <!-- Management Overview -->
    <div class="mb-6 sm:mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base sm:text-lg font-bold flex items-center gap-2">
                <span class="material-symbols-outlined text-cyan-600 text-lg">dashboard_customize</span>
                Management Overview
            </h3>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
            <a href="{{ route('admin.students') }}" class="glass-panel p-4 sm:p-5 rounded-2xl hover:scale-[1.02] transition-all group flex flex-col items-start gap-2">
                <div class="p-2 bg-cyan-50 rounded-xl group-hover:bg-cyan-100 transition-colors">
                    <span class="material-symbols-outlined text-cyan-600 text-xl">group</span>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Student Management</h4>
                <p class="text-[10px] text-slate-500">Search, filter, edit, export</p>
                <span class="text-[10px] font-bold text-cyan-600 bg-cyan-50 px-2 py-0.5 rounded-full mt-1">{{ $studentCount }} total</span>
            </a>
            <a href="{{ route('admin.admissions') }}" class="glass-panel p-4 sm:p-5 rounded-2xl hover:scale-[1.02] transition-all group flex flex-col items-start gap-2">
                <div class="p-2 bg-amber-50 rounded-xl group-hover:bg-amber-100 transition-colors">
                    <span class="material-symbols-outlined text-amber-600 text-xl">fact_check</span>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Admission Management</h4>
                <p class="text-[10px] text-slate-500">Review, approve, reject applications</p>
                <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full mt-1">{{ $pendingAdmissions }} pending</span>
            </a>
            <a href="{{ route('admin.admissions') }}" class="glass-panel p-4 sm:p-5 rounded-2xl hover:scale-[1.02] transition-all group flex flex-col items-start gap-2">
                <div class="p-2 bg-blue-50 rounded-xl group-hover:bg-blue-100 transition-colors">
                    <span class="material-symbols-outlined text-blue-600 text-xl">verified</span>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Document Verification</h4>
                <p class="text-[10px] text-slate-500">Aadhaar, TC, marksheets & more</p>
            </a>
            <a href="{{ route('admin.payments') }}" class="glass-panel p-4 sm:p-5 rounded-2xl hover:scale-[1.02] transition-all group flex flex-col items-start gap-2">
                <div class="p-2 bg-emerald-50 rounded-xl group-hover:bg-emerald-100 transition-colors">
                    <span class="material-symbols-outlined text-emerald-600 text-xl">payments</span>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Payment Management</h4>
                <p class="text-[10px] text-slate-500">Fees, invoices, refunds</p>
                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full mt-1">₹{{ number_format($totalRevenue) }}</span>
            </a>
            <div class="glass-panel p-4 sm:p-5 rounded-2xl flex flex-col items-start gap-2">
                <div class="p-2 bg-purple-50 rounded-xl">
                    <span class="material-symbols-outlined text-purple-600 text-xl">assignment</span>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Public Exams</h4>
                <p class="text-[10px] text-slate-500">Notifications, hall tickets, fee deadlines</p>
            </div>
            <div class="glass-panel p-4 sm:p-5 rounded-2xl flex flex-col items-start gap-2">
                <div class="p-2 bg-orange-50 rounded-xl">
                    <span class="material-symbols-outlined text-orange-600 text-xl">calendar_month</span>
                </div>
                <h4 class="text-sm font-bold text-slate-800">PCP Management</h4>
                <p class="text-[10px] text-slate-500">Schedules, study centers, hall tickets</p>
            </div>
            <a href="{{ route('admin.students') }}" class="glass-panel p-4 sm:p-5 rounded-2xl hover:scale-[1.02] transition-all group flex flex-col items-start gap-2">
                <div class="p-2 bg-rose-50 rounded-xl group-hover:bg-rose-100 transition-colors">
                    <span class="material-symbols-outlined text-rose-600 text-xl">rate_review</span>
                </div>
                <h4 class="text-sm font-bold text-slate-800">TMA Management</h4>
                <p class="text-[10px] text-slate-500">Upload, evaluate, publish marks</p>
                <span class="text-[10px] font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full mt-1">{{ $pendingTma }} pending</span>
            </a>
            <a href="{{ route('admin.products') }}" class="glass-panel p-4 sm:p-5 rounded-2xl hover:scale-[1.02] transition-all group flex flex-col items-start gap-2">
                <div class="p-2 bg-indigo-50 rounded-xl group-hover:bg-indigo-100 transition-colors">
                    <span class="material-symbols-outlined text-indigo-600 text-xl">library_books</span>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Study Material</h4>
                <p class="text-[10px] text-slate-500">Upload PDFs, notes, question banks</p>
                <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full mt-1">{{ $digitalProducts }} items</span>
            </a>
            <div class="glass-panel p-4 sm:p-5 rounded-2xl flex flex-col items-start gap-2">
                <div class="p-2 bg-teal-50 rounded-xl">
                    <span class="material-symbols-outlined text-teal-600 text-xl">leaderboard</span>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Result Management</h4>
                <p class="text-[10px] text-slate-500">Upload links, publish results</p>
            </div>
            <button @click="isBroadcastModalOpen = true" class="glass-panel p-4 sm:p-5 rounded-2xl hover:scale-[1.02] transition-all group flex flex-col items-start gap-2 text-left">
                <div class="p-2 bg-sky-50 rounded-xl group-hover:bg-sky-100 transition-colors">
                    <span class="material-symbols-outlined text-sky-600 text-xl">notifications</span>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Notifications Center</h4>
                <p class="text-[10px] text-slate-500">SMS, email, portal alerts</p>
            </button>
            <div class="glass-panel p-4 sm:p-5 rounded-2xl flex flex-col items-start gap-2">
                <div class="p-2 bg-violet-50 rounded-xl">
                    <span class="material-symbols-outlined text-violet-600 text-xl">analytics</span>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Reports & Analytics</h4>
                <p class="text-[10px] text-slate-500">Revenue, admissions, completion</p>
            </div>
            <div class="glass-panel p-4 sm:p-5 rounded-2xl flex flex-col items-start gap-2">
                <div class="p-2 bg-gray-50 rounded-xl">
                    <span class="material-symbols-outlined text-gray-600 text-xl">military_tech</span>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Upcoming PCP</h4>
                <p class="text-[10px] text-slate-500">{{ $upcomingPcp }} programs scheduled</p>
            </div>
        </div>
    </div>

    <!-- Automation Features -->
    <div class="relative z-10 mb-6">
        <div class="glass-panel p-5 sm:p-8 rounded-2xl sm:rounded-3xl shadow-sm border border-cyan-100/50">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 bg-cyan-50 rounded-xl border border-cyan-100">
                    <span class="material-symbols-outlined text-[#006479] text-xl">auto_awesome</span>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-slate-800">Automation Features</h3>
                    <p class="text-[10px] sm:text-xs text-slate-500 font-medium">Seamless admission & notification workflows</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div class="p-4 sm:p-5 bg-white/60 rounded-2xl border border-slate-100">
                    <h4 class="text-xs sm:text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-cyan-600 text-lg">person_add</span>
                        Admission Automation
                    </h4>
                    <ol class="space-y-2 text-[10px] sm:text-xs text-slate-600">
                        <li class="flex items-center gap-2"><span class="w-5 h-5 rounded-full bg-cyan-100 text-cyan-700 flex items-center justify-center text-[9px] font-bold">1</span>Generate Reference Number <span class="ml-auto text-[9px] text-green-600 font-bold bg-green-50 px-1.5 py-0.5 rounded-full">Auto</span></li>
                        <li class="flex items-center gap-2"><span class="w-5 h-5 rounded-full bg-cyan-100 text-cyan-700 flex items-center justify-center text-[9px] font-bold">2</span>Document Verification Reminder <span class="ml-auto text-[9px] text-amber-600 font-bold bg-amber-50 px-1.5 py-0.5 rounded-full">Manual</span></li>
                        <li class="flex items-center gap-2"><span class="w-5 h-5 rounded-full bg-cyan-100 text-cyan-700 flex items-center justify-center text-[9px] font-bold">3</span>Status Change Notification <span class="ml-auto text-[9px] text-green-600 font-bold bg-green-50 px-1.5 py-0.5 rounded-full">Auto</span></li>
                        <li class="flex items-center gap-2"><span class="w-5 h-5 rounded-full bg-cyan-100 text-cyan-700 flex items-center justify-center text-[9px] font-bold">4</span>Enrollment Credentials Email <span class="ml-auto text-[9px] text-green-600 font-bold bg-green-50 px-1.5 py-0.5 rounded-full">Auto</span></li>
                        <li class="flex items-center gap-2"><span class="w-5 h-5 rounded-full bg-cyan-100 text-cyan-700 flex items-center justify-center text-[9px] font-bold">5</span>Move to Processing Queue <span class="ml-auto text-[9px] text-green-600 font-bold bg-green-50 px-1.5 py-0.5 rounded-full">Auto</span></li>
                    </ol>
                    <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[9px] font-bold text-slate-400 uppercase">Pipeline Status</span>
                        <span class="text-[10px] font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">3 Active</span>
                    </div>
                </div>
                <div class="p-4 sm:p-5 bg-white/60 rounded-2xl border border-slate-100">
                    <h4 class="text-xs sm:text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-cyan-600 text-lg">notifications</span>
                        Notification Automation
                    </h4>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between p-2 bg-white rounded-lg border border-slate-100"><span class="text-[10px] font-semibold text-slate-700">Admission Updates</span><span class="material-symbols-outlined text-green-600 text-sm">check</span></div>
                        <div class="flex items-center justify-between p-2 bg-white rounded-lg border border-slate-100"><span class="text-[10px] font-semibold text-slate-700">Payment Reminders</span><span class="material-symbols-outlined text-green-600 text-sm">check</span></div>
                        <div class="flex items-center justify-between p-2 bg-white rounded-lg border border-slate-100"><span class="text-[10px] font-semibold text-slate-700">PCP Alerts</span><span class="material-symbols-outlined text-green-600 text-sm">check</span></div>
                        <div class="flex items-center justify-between p-2 bg-white rounded-lg border border-slate-100"><span class="text-[10px] font-semibold text-slate-700">TMA Deadlines</span><span class="material-symbols-outlined text-green-600 text-sm">check</span></div>
                        <div class="flex items-center justify-between p-2 bg-white rounded-lg border border-slate-100"><span class="text-[10px] font-semibold text-slate-700">Exam Notifications</span><span class="material-symbols-outlined text-green-600 text-sm">check</span></div>
                        <div class="flex items-center justify-between p-2 bg-white rounded-lg border border-slate-100"><span class="text-[10px] font-semibold text-slate-700">Result Alerts</span><span class="material-symbols-outlined text-green-600 text-sm">check</span></div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[9px] font-bold text-slate-400 uppercase">Triggers Active</span>
                        <span class="text-[10px] font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">6 / 6</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Management Sections -->
    <div class="space-y-6 mb-6">

        <!-- Admission Workflow -->
        <div x-data="{ open: false }" class="glass-panel rounded-2xl overflow-hidden">
            <button @click="open = !open" class="w-full p-4 sm:p-5 flex items-center justify-between hover:bg-slate-50/50 transition-colors">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-600 text-lg">alt_route</span>
                    <h3 class="text-base sm:text-lg font-bold">Admission Workflow</h3>
                </div>
                <span class="material-symbols-outlined text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
            </button>
            <div x-show="open" x-collapse>
                <div class="px-4 sm:px-6 pb-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 text-xs sm:text-sm">
                        <div class="flex items-center gap-2 px-3 py-2 bg-amber-50 rounded-xl border border-amber-100"><span class="material-symbols-outlined text-amber-600 text-sm">person</span>Student</div>
                        <span class="material-symbols-outlined text-slate-300 hidden sm:block">arrow_forward</span>
                        <div class="flex items-center gap-2 px-3 py-2 bg-cyan-50 rounded-xl border border-cyan-100"><span class="material-symbols-outlined text-cyan-600 text-sm">flag</span>Basecamp</div>
                        <span class="material-symbols-outlined text-slate-300 hidden sm:block">arrow_forward</span>
                        <div class="flex items-center gap-2 px-3 py-2 bg-purple-50 rounded-xl border border-purple-100"><span class="material-symbols-outlined text-purple-600 text-sm">account_balance</span>NIOS</div>
                        <span class="material-symbols-outlined text-slate-300 hidden sm:block">arrow_forward</span>
                        <div class="flex items-center gap-2 px-3 py-2 bg-green-50 rounded-xl border border-green-100"><span class="material-symbols-outlined text-green-600 text-sm">sync</span>Status Update</div>
                        <span class="material-symbols-outlined text-slate-300 hidden sm:block">arrow_forward</span>
                        <div class="flex items-center gap-2 px-3 py-2 bg-blue-50 rounded-xl border border-blue-100"><span class="material-symbols-outlined text-blue-600 text-sm">person</span>Student</div>
                    </div>
                    <div class="mt-4 grid grid-cols-2 sm:grid-cols-5 gap-2 text-center">
                        <div class="p-2 bg-slate-50 rounded-lg"><span class="text-[10px] font-bold text-slate-500">Draft</span></div>
                        <div class="p-2 bg-amber-50 rounded-lg"><span class="text-[10px] font-bold text-amber-600">Submitted to NIOS</span></div>
                        <div class="p-2 bg-blue-50 rounded-lg"><span class="text-[10px] font-bold text-blue-600">Under Review</span></div>
                        <div class="p-2 bg-green-50 rounded-lg"><span class="text-[10px] font-bold text-green-600">Approved</span></div>
                        <div class="p-2 bg-red-50 rounded-lg"><span class="text-[10px] font-bold text-red-600">Rejected</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Verification -->
        <div x-data="{ open: false }" class="glass-panel rounded-2xl overflow-hidden">
            <button @click="open = !open" class="w-full p-4 sm:p-5 flex items-center justify-between hover:bg-slate-50/50 transition-colors">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600 text-lg">verified</span>
                    <h3 class="text-base sm:text-lg font-bold">Document Verification</h3>
                </div>
                <span class="material-symbols-outlined text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
            </button>
            <div x-show="open" x-collapse>
                <div class="px-4 sm:px-6 pb-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100">
                            <div class="flex items-center gap-2"><span class="material-symbols-outlined text-slate-500 text-sm">badge</span><span class="text-xs font-semibold">Aadhaar</span></div>
                            <div class="flex gap-1"><button @click="openModal('docVerify', 'Verify Document'); formData.document = 'Aadhaar'; formData.action = 'approve'" class="px-2 py-1 bg-green-100 text-green-700 rounded text-[10px] font-bold">✓</button><button @click="openModal('docVerify', 'Verify Document'); formData.document = 'Aadhaar'; formData.action = 'reject'" class="px-2 py-1 bg-red-100 text-red-700 rounded text-[10px] font-bold">✗</button></div>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100">
                            <div class="flex items-center gap-2"><span class="material-symbols-outlined text-slate-500 text-sm">description</span><span class="text-xs font-semibold">Transfer Certificate</span></div>
                            <div class="flex gap-1"><button @click="openModal('docVerify', 'Verify Document'); formData.document = 'Transfer Certificate'; formData.action = 'approve'" class="px-2 py-1 bg-green-100 text-green-700 rounded text-[10px] font-bold">✓</button><button @click="openModal('docVerify', 'Verify Document'); formData.document = 'Transfer Certificate'; formData.action = 'reject'" class="px-2 py-1 bg-red-100 text-red-700 rounded text-[10px] font-bold">✗</button></div>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100">
                            <div class="flex items-center gap-2"><span class="material-symbols-outlined text-slate-500 text-sm">image</span><span class="text-xs font-semibold">Passport Photo</span></div>
                            <div class="flex gap-1"><button @click="openModal('docVerify', 'Verify Document'); formData.document = 'Passport Photo'; formData.action = 'approve'" class="px-2 py-1 bg-green-100 text-green-700 rounded text-[10px] font-bold">✓</button><button @click="openModal('docVerify', 'Verify Document'); formData.document = 'Passport Photo'; formData.action = 'reject'" class="px-2 py-1 bg-red-100 text-red-700 rounded text-[10px] font-bold">✗</button></div>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100">
                            <div class="flex items-center gap-2"><span class="material-symbols-outlined text-slate-500 text-sm">draw</span><span class="text-xs font-semibold">Signature</span></div>
                            <div class="flex gap-1"><button @click="openModal('docVerify', 'Verify Document'); formData.document = 'Signature'; formData.action = 'approve'" class="px-2 py-1 bg-green-100 text-green-700 rounded text-[10px] font-bold">✓</button><button @click="openModal('docVerify', 'Verify Document'); formData.document = 'Signature'; formData.action = 'reject'" class="px-2 py-1 bg-red-100 text-red-700 rounded text-[10px] font-bold">✗</button></div>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100">
                            <div class="flex items-center gap-2"><span class="material-symbols-outlined text-slate-500 text-sm">text_snippet</span><span class="text-xs font-semibold">Previous Marksheets</span></div>
                            <div class="flex gap-1"><button @click="openModal('docVerify', 'Verify Document'); formData.document = 'Previous Marksheets'; formData.action = 'approve'" class="px-2 py-1 bg-green-100 text-green-700 rounded text-[10px] font-bold">✓</button><button @click="openModal('docVerify', 'Verify Document'); formData.document = 'Previous Marksheets'; formData.action = 'reject'" class="px-2 py-1 bg-red-100 text-red-700 rounded text-[10px] font-bold">✗</button></div>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100">
                            <div class="flex items-center gap-2"><span class="material-symbols-outlined text-slate-500 text-sm">workspace_premium</span><span class="text-xs font-semibold">Category Certificate</span></div>
                            <div class="flex gap-1"><button @click="openModal('docVerify', 'Verify Document'); formData.document = 'Category Certificate'; formData.action = 'approve'" class="px-2 py-1 bg-green-100 text-green-700 rounded text-[10px] font-bold">✓</button><button @click="openModal('docVerify', 'Verify Document'); formData.document = 'Category Certificate'; formData.action = 'reject'" class="px-2 py-1 bg-red-100 text-red-700 rounded text-[10px] font-bold">✗</button></div>
                        </div>
                    </div>
                    <div class="mt-3 flex gap-2">
                        <button @click="openModal('docReupload', 'Request Document Re-upload')" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-[10px] font-bold hover:bg-blue-700">Request Re-upload</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment & TMA Management Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Payment Management -->
            <div x-data="{ open: false }" class="glass-panel rounded-2xl overflow-hidden">
                <button @click="open = !open" class="w-full p-4 sm:p-5 flex items-center justify-between hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600 text-lg">payments</span>
                        <h3 class="text-base sm:text-lg font-bold">Payment Management</h3>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-collapse>
                    <div class="px-4 sm:px-6 pb-6">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100"><span class="text-xs font-semibold">Admission Fee</span><span class="text-[10px] text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-full">Tracked</span></div>
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100"><span class="text-xs font-semibold">Public Exam Fee</span><span class="text-[10px] text-amber-600 font-bold bg-amber-50 px-2 py-0.5 rounded-full">Deadline: 15 Jul</span></div>
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100"><span class="text-xs font-semibold">TMA Fee</span><span class="text-[10px] text-purple-600 font-bold bg-purple-50 px-2 py-0.5 rounded-full">Per Assignment</span></div>
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100"><span class="text-xs font-semibold">Service Charges</span><span class="text-[10px] text-blue-600 font-bold bg-blue-50 px-2 py-0.5 rounded-full">One-time</span></div>
                        </div>
                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('admin.payments') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-[10px] font-bold hover:bg-emerald-700">Payment History</a>
                            <a href="{{ route('admin.invoices.download') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-bold text-slate-600 hover:bg-slate-50 inline-block">Download Invoices</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TMA Management -->
            <div x-data="{ open: false }" class="glass-panel rounded-2xl overflow-hidden">
                <button @click="open = !open" class="w-full p-4 sm:p-5 flex items-center justify-between hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-rose-600 text-lg">rate_review</span>
                        <h3 class="text-base sm:text-lg font-bold">TMA Management</h3>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-collapse>
                    <div class="px-4 sm:px-6 pb-6">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100">
                                <span class="text-xs font-semibold">Upload Assignment Questions</span>
                                <button @click="openModal('tmaUpload', 'Upload TMA Assignment')" class="px-3 py-1.5 bg-rose-600 text-white rounded-lg text-[10px] font-bold">Upload</button>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100">
                                <span class="text-xs font-semibold">Set Submission Deadline</span>
                                <button @click="openModal('tmaSetDeadline', 'Set TMA Deadline')" class="px-3 py-1.5 bg-rose-600 text-white rounded-lg text-[10px] font-bold">Set</button>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100">
                                <span class="text-xs font-semibold">Review Uploaded Assignments</span>
                                <span class="text-[10px] font-bold text-rose-600">{{ $pendingTma }} pending</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100">
                                <span class="text-xs font-semibold">Enter & Publish Marks</span>
                                <button @click="openModal('tmaPublish', 'Publish TMA Marks')" class="px-3 py-1.5 bg-rose-600 text-white rounded-lg text-[10px] font-bold">Publish</button>
                            </div>
                        </div>
                        <div class="mt-3 flex gap-2">
                            <span class="px-3 py-1.5 bg-amber-50 text-amber-700 rounded-lg text-[10px] font-bold border border-amber-200">Not Submitted</span>
                            <span class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-[10px] font-bold border border-blue-200">Submitted</span>
                            <span class="px-3 py-1.5 bg-purple-50 text-purple-700 rounded-lg text-[10px] font-bold border border-purple-200">Under Review</span>
                            <span class="px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-[10px] font-bold border border-green-200">Evaluated</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications & Reports Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Notifications Center -->
            <div x-data="{ open: false }" class="glass-panel rounded-2xl overflow-hidden">
                <button @click="open = !open" class="w-full p-4 sm:p-5 flex items-center justify-between hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sky-600 text-lg">notifications</span>
                        <h3 class="text-base sm:text-lg font-bold">Notifications Center</h3>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-collapse>
                    <div class="px-4 sm:px-6 pb-6">
                        <div class="grid grid-cols-2 gap-2 mb-3">
                            <button @click="isBroadcastModalOpen = true; broadcastAudience = 'all'" class="p-3 bg-white/60 rounded-xl border border-slate-100 hover:bg-white transition-all text-left">
                                <span class="material-symbols-outlined text-sky-600 text-lg">sms</span>
                                <p class="text-xs font-bold mt-1">SMS</p>
                            </button>
                            <button @click="isBroadcastModalOpen = true; broadcastAudience = 'all'" class="p-3 bg-white/60 rounded-xl border border-slate-100 hover:bg-white transition-all text-left">
                                <span class="material-symbols-outlined text-green-600 text-lg">mail</span>
                                <p class="text-xs font-bold mt-1">Email</p>
                            </button>
                            <button @click="isBroadcastModalOpen = true; broadcastAudience = 'all'" class="p-3 bg-white/60 rounded-xl border border-slate-100 hover:bg-white transition-all text-left">
                                <span class="material-symbols-outlined text-purple-600 text-lg">chat</span>
                                <p class="text-xs font-bold mt-1">WhatsApp</p>
                            </button>
                            <button @click="isBroadcastModalOpen = true" class="p-3 bg-white/60 rounded-xl border border-slate-100 hover:bg-white transition-all text-left">
                                <span class="material-symbols-outlined text-cyan-600 text-lg">campaign</span>
                                <p class="text-xs font-bold mt-1">Portal</p>
                            </button>
                        </div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Templates</p>
                        <div class="space-y-1.5">
                            <button @click="isBroadcastModalOpen = true; broadcastSubject = 'Admission Approved - Welcome to Basecamp!'" class="w-full text-left px-3 py-2 bg-white/60 rounded-lg border border-slate-100 text-[11px] font-medium text-slate-700 hover:bg-white">Admission Approved</button>
                            <button @click="isBroadcastModalOpen = true; broadcastSubject = 'Payment Received - Thank You'" class="w-full text-left px-3 py-2 bg-white/60 rounded-lg border border-slate-100 text-[11px] font-medium text-slate-700 hover:bg-white">Payment Received</button>
                            <button @click="isBroadcastModalOpen = true; broadcastSubject = 'Exam Fee Deadline Reminder'" class="w-full text-left px-3 py-2 bg-white/60 rounded-lg border border-slate-100 text-[11px] font-medium text-slate-700 hover:bg-white">Exam Fee Reminder</button>
                            <button @click="isBroadcastModalOpen = true; broadcastSubject = 'PCP Program Notification'" class="w-full text-left px-3 py-2 bg-white/60 rounded-lg border border-slate-100 text-[11px] font-medium text-slate-700 hover:bg-white">PCP Notification</button>
                            <button @click="isBroadcastModalOpen = true; broadcastSubject = 'TMA Submission Deadline Approaching'" class="w-full text-left px-3 py-2 bg-white/60 rounded-lg border border-slate-100 text-[11px] font-medium text-slate-700 hover:bg-white">TMA Deadline</button>
                            <button @click="isBroadcastModalOpen = true; broadcastSubject = 'Results Published - Check Your Score'" class="w-full text-left px-3 py-2 bg-white/60 rounded-lg border border-slate-100 text-[11px] font-medium text-slate-700 hover:bg-white">Result Published</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports & Analytics -->
            <div x-data="{ open: false }" class="glass-panel rounded-2xl overflow-hidden">
                <button @click="open = !open" class="w-full p-4 sm:p-5 flex items-center justify-between hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-violet-600 text-lg">analytics</span>
                        <h3 class="text-base sm:text-lg font-bold">Reports & Analytics</h3>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-collapse>
                    <div class="px-4 sm:px-6 pb-6">
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <a href="{{ route('admin.reports.admissions') }}" class="p-3 bg-white/60 rounded-xl border border-slate-100 hover:bg-white transition-all text-left block"><span class="material-symbols-outlined text-violet-600 text-lg">description</span><p class="text-[11px] font-bold mt-1">Admission Reports</p></a>
                            <a href="{{ route('admin.reports.revenue') }}" class="p-3 bg-white/60 rounded-xl border border-slate-100 hover:bg-white transition-all text-left block"><span class="material-symbols-outlined text-emerald-600 text-lg">payments</span><p class="text-[11px] font-bold mt-1">Revenue Reports</p></a>
                            <a href="{{ route('admin.reports.revenue') }}" class="p-3 bg-white/60 rounded-xl border border-slate-100 hover:bg-white transition-all text-left block"><span class="material-symbols-outlined text-amber-600 text-lg">quiz</span><p class="text-[11px] font-bold mt-1">Exam Reports</p></a>
                            <a href="{{ route('admin.reports.admissions') }}" class="p-3 bg-white/60 rounded-xl border border-slate-100 hover:bg-white transition-all text-left block"><span class="material-symbols-outlined text-blue-600 text-lg">group</span><p class="text-[11px] font-bold mt-1">Student Reports</p></a>
                        </div>
                        <div class="h-24 bg-white/40 rounded-xl border border-dashed border-slate-200 flex items-center justify-center">
                            <span class="text-[10px] text-slate-400 font-medium">Chart: Monthly Admissions / Revenue Growth / Completion Rate</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Public Exam & PCP Management Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div x-data="{ open: false }" class="glass-panel rounded-2xl overflow-hidden">
                <button @click="open = !open" class="w-full p-4 sm:p-5 flex items-center justify-between hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-purple-600 text-lg">assignment</span>
                        <h3 class="text-base sm:text-lg font-bold">Public Examination Management</h3>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-collapse>
                    <div class="px-4 sm:px-6 pb-6">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100"><span class="text-xs font-semibold">Post Exam Notifications</span><button @click="openModal('examNotification', 'Post Exam Notification')" class="px-3 py-1.5 bg-purple-600 text-white rounded-lg text-[10px] font-bold">Post</button></div>
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100"><span class="text-xs font-semibold">Update Exam Fee Deadlines</span><button @click="openModal('examFeeDeadline', 'Update Exam Fee Deadline')" class="px-3 py-1.5 bg-purple-600 text-white rounded-lg text-[10px] font-bold">Update</button></div>
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100"><span class="text-xs font-semibold">Generate Eligible Student List</span><a href="{{ route('admin.exams.eligible') }}" class="px-3 py-1.5 bg-purple-600 text-white rounded-lg text-[10px] font-bold inline-block hover:bg-purple-700">Generate</a></div>
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100"><span class="text-xs font-semibold">Upload Hall Ticket</span><button @click="openModal('examHallTicket', 'Upload Hall Ticket')" class="px-3 py-1.5 bg-purple-600 text-white rounded-lg text-[10px] font-bold">Upload</button></div>
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100"><span class="text-xs font-semibold">Publish Exam Instructions</span><button @click="openModal('examNotification', 'Publish Exam Instructions')" class="px-3 py-1.5 bg-purple-600 text-white rounded-lg text-[10px] font-bold">Publish</button></div>
                        </div>
                    </div>
                </div>
            </div>
            <div x-data="{ open: false }" class="glass-panel rounded-2xl overflow-hidden">
                <button @click="open = !open" class="w-full p-4 sm:p-5 flex items-center justify-between hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-orange-600 text-lg">calendar_month</span>
                        <h3 class="text-base sm:text-lg font-bold">PCP Management</h3>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-collapse>
                    <div class="px-4 sm:px-6 pb-6">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100"><span class="text-xs font-semibold">Upload PCP Hall Ticket</span><button @click="openModal('pcpHallTicket', 'Upload PCP Hall Ticket')" class="px-3 py-1.5 bg-orange-600 text-white rounded-lg text-[10px] font-bold">Upload</button></div>
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100"><span class="text-xs font-semibold">Send PCP Notifications</span><button @click="isBroadcastModalOpen = true" class="px-3 py-1.5 bg-orange-600 text-white rounded-lg text-[10px] font-bold">Send</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Study Material & Result Management Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div x-data="{ open: false }" class="glass-panel rounded-2xl overflow-hidden">
                <button @click="open = !open" class="w-full p-4 sm:p-5 flex items-center justify-between hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-600 text-lg">library_books</span>
                        <h3 class="text-base sm:text-lg font-bold">Study Material Management</h3>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-collapse>
                    <div class="px-4 sm:px-6 pb-6">
                        <div class="flex gap-2 mb-3">
                            <span class="px-3 py-1.5 bg-cyan-50 text-cyan-700 rounded-lg text-[10px] font-bold border border-cyan-200">Secondary</span>
                            <span class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-[10px] font-bold border border-indigo-200">Senior Secondary</span>
                            <span class="px-3 py-1.5 bg-slate-50 text-slate-700 rounded-lg text-[10px] font-bold border border-slate-200">Subject-wise</span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100"><span class="text-xs font-semibold">Upload Subject-wise PDFs</span><button @click="openModal('studyUpload', 'Upload Study Material')" class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-[10px] font-bold">Upload</button></div>
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100"><span class="text-xs font-semibold">Upload Notes</span><button @click="openModal('studyUpload', 'Upload Notes')" class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-[10px] font-bold">Upload</button></div>
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100"><span class="text-xs font-semibold">Previous Year Questions</span><button @click="openModal('studyUpload', 'Upload Previous Year Questions')" class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-[10px] font-bold">Upload</button></div>
                        </div>
                        <a href="{{ route('admin.products') }}" class="mt-3 block text-center py-2 bg-indigo-50 text-indigo-700 rounded-xl text-[10px] font-bold hover:bg-indigo-100 transition-colors">Manage All Materials</a>
                    </div>
                </div>
            </div>
            <div x-data="{ open: false }" class="glass-panel rounded-2xl overflow-hidden">
                <button @click="open = !open" class="w-full p-4 sm:p-5 flex items-center justify-between hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-teal-600 text-lg">leaderboard</span>
                        <h3 class="text-base sm:text-lg font-bold">Result Management</h3>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-collapse>
                    <div class="px-4 sm:px-6 pb-6">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100"><span class="text-xs font-semibold">Upload Result Links</span><button @click="openModal('resultUpload', 'Publish Result')" class="px-3 py-1.5 bg-teal-600 text-white rounded-lg text-[10px] font-bold">Upload</button></div>
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100"><span class="text-xs font-semibold">Publish Result Announcements</span><button @click="isBroadcastModalOpen = true" class="px-3 py-1.5 bg-teal-600 text-white rounded-lg text-[10px] font-bold">Publish</button></div>
                            <div class="flex items-center justify-between p-3 bg-white/60 rounded-xl border border-slate-100"><span class="text-xs font-semibold">Student Result Verification</span><button @click="openModal('resultVerify', 'Verify Student Result')" class="px-3 py-1.5 bg-teal-600 text-white rounded-lg text-[10px] font-bold">Verify</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="space-y-6 mb-6">

        <!-- Newly Enrolled -->
        <div class="glass-panel rounded-2xl !overflow-visible">
            <div class="overflow-hidden rounded-t-2xl border-b border-slate-200">
                <div class="p-4 sm:p-5 flex items-center justify-between">
                <div>
                    <h3 class="text-base sm:text-lg font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-600 text-lg">person_add</span>
                        Newly Enrolled
                    </h3>
                    <p class="text-xs text-slate-400 font-medium">Recently approved admissions</p>
                </div>
                <a href="{{ route('admin.admissions') }}" class="text-xs font-bold text-cyan-600 hover:underline">View All</a>
            </div>
        </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[480px] sm:min-w-0">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-3 sm:px-5 py-3 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">Name</th>
                            <th class="px-3 sm:px-5 py-3 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">Course</th>
                            <th class="px-3 sm:px-5 py-3 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">Date</th>
                            <th class="px-3 sm:px-5 py-3 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">Documents</th>
                            <th class="px-3 sm:px-5 py-3 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($newEnrollments as $admission)
                            <tr class="border-t border-slate-100 hover:bg-slate-50/50 transition-colors">
                                <td class="px-3 sm:px-5 py-3">
                                    <p class="text-sm font-semibold text-slate-800">{{ $admission->full_name }}</p>
                                    <p class="text-xs text-slate-400">{{ $admission->user?->email ?? $admission->email }}</p>
                                </td>
                                <td class="px-3 sm:px-5 py-3">
                                    <span class="text-xs font-bold px-2 py-1 rounded-full bg-blue-50 text-blue-700">
                                        {{ $admission->course_type === '10th' ? '10th Grade' : '12th Grade' }}
                                    </span>
                                </td>
                                <td class="px-3 sm:px-5 py-3 text-sm text-slate-500">{{ $admission->updated_at->format('d M Y') }}</td>
                                <td class="px-3 sm:px-5 py-3">
                                    <button @click="viewDocuments('{{ json_encode($admission->documents ?? []) }}', '{{ $admission->full_name }}')"
                                        class="text-xs font-bold text-cyan-600 hover:underline flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">folder_open</span>
                                        View
                                    </button>
                                </td>
                                <td class="px-3 sm:px-5 py-3 relative">
                                    <div class="flex items-center gap-1">
                                        <button @click="openStudentMsg({{ $admission->id }}, '{{ $admission->full_name }}', '{{ $admission->user?->email ?? $admission->email }}')"
                                            class="text-xs font-bold text-cyan-600 hover:text-cyan-700 hover:bg-cyan-50 px-2 py-1 rounded-lg transition-all flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">mail</span>
                                            Message
                                        </button>
                                        <button @click="
                                            const rect = $el.getBoundingClientRect();
                                            actionDropdownRect = { top: rect.bottom + 4, left: rect.right - 208 };
                                            actionDropdown = (actionDropdown === {{ $admission->id }} ? null : {{ $admission->id }});
                                            actionAdmission = {{ $admission->id }};
                                        " @click.outside="actionDropdown = null"
                                            class="text-xs font-bold text-slate-600 hover:text-cyan-600 hover:bg-slate-100 px-2 py-1 rounded-lg transition-all flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">more_vert</span>
                                            Status
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2 text-slate-400">
                                        <span class="material-symbols-outlined text-3xl">person_add</span>
                                        <p class="text-sm font-medium">No approved enrollments yet</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Active Students -->
        <div class="glass-panel rounded-2xl overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-base sm:text-lg font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-green-600 text-lg">group</span>
                        Active Students
                    </h3>
                    <p class="text-xs text-slate-400 font-medium">Students with approved admissions</p>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="isBroadcastModalOpen = true"
                        class="text-xs font-bold text-cyan-600 hover:text-cyan-700 hover:bg-cyan-50 px-3 py-1.5 rounded-lg transition-all flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">notifications</span>
                        Broadcast
                    </button>
                    <button @click="(function() {
                        const rows = document.querySelectorAll('#active-students-table tbody tr');
                        let csv = 'Student,Email,Enrollment Number,Course\\n';
                        rows.forEach(row => {
                            const cells = row.querySelectorAll('td');
                            if (cells.length >= 4) {
                                const name = cells[0].querySelector('p:first-child')?.textContent?.trim() || '';
                                const email = cells[0].querySelector('p:last-child')?.textContent?.trim() || '';
                                const enroll = cells[1]?.textContent?.trim() || '';
                                const course = cells[2]?.textContent?.trim() || '';
                                csv += name + ',' + email + ',' + enroll + ',' + course + '\\n';
                            }
                        });
                        const blob = new Blob([csv], { type: 'text/csv' });
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'active-students.csv';
                        a.click();
                        URL.revokeObjectURL(url);
                    })()"
                        class="text-xs font-bold text-slate-600 hover:text-cyan-600 hover:bg-slate-50 px-3 py-1.5 rounded-lg transition-all flex items-center gap-1 border border-slate-200">
                        <span class="material-symbols-outlined text-sm">download</span>
                        Export CSV
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table id="active-students-table" class="w-full text-left">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-3 sm:px-5 py-3 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">Student</th>
                            <th class="px-3 sm:px-5 py-3 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">Enrollment</th>
                            <th class="px-3 sm:px-5 py-3 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">Course</th>
                            <th class="px-3 sm:px-5 py-3 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activeStudentsList as $student)
                            @php
                                $approvedAdmission = $student->admissions->first();
                                $courseLabel = $approvedAdmission?->course_type === '10th' ? '10th Grade' : ($approvedAdmission?->course_type === '12th' ? '12th Grade' : 'N/A');
                            @endphp
                            <tr class="border-t border-slate-100 hover:bg-slate-50/50 transition-colors">
                                <td class="px-3 sm:px-5 py-3">
                                    <p class="text-sm font-semibold text-slate-800">{{ $student->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $student->email }}</p>
                                </td>
                                <td class="px-3 sm:px-5 py-3">
                                    <span class="text-xs font-bold text-slate-600">{{ $student->enrollment_number ?? 'N/A' }}</span>
                                </td>
                                <td class="px-3 sm:px-5 py-3">
                                    <span class="text-xs font-bold px-2 py-1 rounded-full bg-green-50 text-green-700">{{ $courseLabel }}</span>
                                </td>
                                <td class="px-3 sm:px-5 py-3">
                                    <div class="flex items-center gap-1">
                                        <button @click="openStudentMsg({{ $student->id }}, '{{ $student->name }}', '{{ $student->email }}')"
                                            class="text-xs font-bold text-cyan-600 hover:text-cyan-700 hover:bg-cyan-50 px-2 py-1 rounded-lg transition-all flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">mail</span>
                                            Message
                                        </button>
                                        <a href="{{ route('admin.students') }}"
                                           class="text-xs font-bold text-slate-600 hover:text-cyan-600 hover:bg-slate-50 px-2 py-1 rounded-lg transition-all flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2 text-slate-400">
                                        <span class="material-symbols-outlined text-3xl">group_off</span>
                                        <p class="text-sm font-medium">No active students yet</p>
                                        <a href="{{ route('admin.admissions.create') }}" class="text-xs font-bold text-cyan-600 hover:underline mt-1">Enroll a new student</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Recent Activity -->
    <div class="glass-panel rounded-2xl overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="text-base sm:text-lg font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-slate-600 text-lg">history</span>
                    Recent Admissions
                </h3>
                <p class="text-xs text-slate-400 font-medium">Latest admission applications (all statuses)</p>
            </div>
            <a href="{{ route('admin.admissions') }}" class="text-xs font-bold text-cyan-600 hover:underline">Manage Admissions</a>
        </div>
        <div class="overflow-x-auto -mx-3 sm:mx-0">
            <table class="w-full text-left min-w-[480px] sm:min-w-0">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">Name</th>
                        <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">Status</th>
                        <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">Course</th>
                        <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentAdmissions as $admission)
                        <tr class="border-t border-slate-100 hover:bg-slate-50/50 transition-colors">
                            <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4">
                                <p class="text-sm font-medium text-slate-800">{{ $admission->full_name }}</p>
                                <p class="text-xs text-slate-400">{{ $admission->email }}</p>
                            </td>
                            <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4">
                                @php
                                    $statusColors = [
                                        'Approved' => 'bg-green-100 text-green-700',
                                        'Pending' => 'bg-amber-100 text-amber-700',
                                        'Rejected' => 'bg-red-100 text-red-700',
                                        'Document Error' => 'bg-orange-100 text-orange-700',
                                        'Need to Pay Fees' => 'bg-purple-100 text-purple-700',
                                    ];
                                    $color = $statusColors[$admission->status] ?? 'bg-slate-100 text-slate-700';
                                @endphp
                                <span class="px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-bold {{ $color }}">
                                    {{ $admission->status }}
                                </span>
                            </td>
                            <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-sm text-slate-600">
                                {{ $admission->course_type === '10th' ? '10th Grade' : '12th Grade' }}
                            </td>
                            <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-sm text-slate-500">
                                {{ $admission->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-2 text-slate-400">
                                    <span class="material-symbols-outlined text-3xl">inbox</span>
                                    <p class="text-sm font-medium">No admission applications yet</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Per-Student Message Modal -->
    <div x-show="studentMsg.show" x-cloak class="fixed inset-0 z-[160] flex items-center justify-center px-4">
        <div @click="studentMsg.show = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-lg bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-2xl z-10">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-extrabold tracking-tight text-cyan-700">Send Message</h2>
                    <p class="text-sm text-slate-500 mt-1" x-text="'To: ' + studentMsg.name"></p>
                </div>
                <button @click="studentMsg.show = false" class="p-2 hover:bg-slate-100 rounded-full text-slate-500 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold tracking-wide uppercase text-slate-500 mb-2">Subject</label>
                    <input type="text" x-model="studentMsg.subject" required maxlength="255"
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500/20 outline-none text-slate-700 font-medium placeholder:text-slate-400 text-sm"
                        placeholder="Enrollment Credentials / Update..." />
                </div>
                <div>
                    <label class="block text-xs font-bold tracking-wide uppercase text-slate-500 mb-2">Message</label>
                    <textarea x-model="studentMsg.message" required rows="5" maxlength="5000"
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500/20 outline-none text-slate-700 font-medium placeholder:text-slate-400 text-sm resize-none"
                        placeholder="Type your message here..."></textarea>
                </div>
                <button @click="sendStudentMsg()" :disabled="studentMsg.sending || !studentMsg.subject.trim() || !studentMsg.message.trim()"
                    class="w-full py-4 rounded-xl signature-gradient text-white font-bold text-sm shadow-lg hover:opacity-90 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <span x-show="studentMsg.sending" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                    <span x-text="studentMsg.sending ? 'Sending...' : 'Send Message'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Global Status Dropdown (fixed position, not clipped by overflow) -->
    <div x-show="actionDropdown" x-cloak
         :style="'position:fixed;top:' + (actionDropdownRect?.top || 0) + 'px;left:' + (actionDropdownRect?.left || 0) + 'px'"
         @click.outside="actionDropdown = null"
         class="w-52 bg-white border border-slate-200 rounded-xl shadow-xl z-[150] py-1 overflow-hidden">
        <button @click="actionAdmission && updateStatus(actionAdmission, 'Approved')" :disabled="sendingStatus"
            class="w-full text-left px-4 py-2.5 text-sm font-medium text-green-700 hover:bg-green-50 flex items-center gap-2 transition-colors disabled:opacity-50">
            <span class="material-symbols-outlined text-sm">check_circle</span> Approved
        </button>
        <button @click="actionAdmission && updateStatus(actionAdmission, 'Rejected')" :disabled="sendingStatus"
            class="w-full text-left px-4 py-2.5 text-sm font-medium text-red-700 hover:bg-red-50 flex items-center gap-2 transition-colors disabled:opacity-50">
            <span class="material-symbols-outlined text-sm">cancel</span> Rejected
        </button>
        <button @click="actionAdmission && updateStatus(actionAdmission, 'Document Error')" :disabled="sendingStatus"
            class="w-full text-left px-4 py-2.5 text-sm font-medium text-orange-700 hover:bg-orange-50 flex items-center gap-2 transition-colors disabled:opacity-50">
            <span class="material-symbols-outlined text-sm">description</span> Document Error
        </button>
        <button @click="actionAdmission && updateStatus(actionAdmission, 'Need to Pay Fees')" :disabled="sendingStatus"
            class="w-full text-left px-4 py-2.5 text-sm font-medium text-amber-700 hover:bg-amber-50 flex items-center gap-2 transition-colors disabled:opacity-50">
            <span class="material-symbols-outlined text-sm">payments</span> Need to Pay Fees
        </button>
    </div>

    <!-- Document Viewer Modal -->
    <div x-show="documentData" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center px-4">
        <div @click="documentData = null" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-2xl bg-white p-4 sm:p-8 rounded-3xl border border-slate-200 shadow-2xl z-10 max-h-[85dvh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-extrabold tracking-tight text-cyan-700">Student Documents</h2>
                    <p class="text-sm text-slate-500 mt-1" x-text="documentName"></p>
                </div>
                <button @click="documentData = null" class="p-2 hover:bg-slate-100 rounded-full text-slate-500 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="flex items-center justify-between mb-4">
                <p class="text-xs text-slate-500">Click to view or download each document</p>
                <button @click="
                    documentData && Object.keys(documentData).forEach(k => {
                        const url = documentData[k];
                        if (url && typeof url === 'string' && url.startsWith('admissions/')) {
                            const a = document.createElement('a');
                            a.href = '/storage/' + url;
                            a.download = url.split('/').pop();
                            a.click();
                        }
                    });
                " class="text-xs font-bold text-cyan-600 hover:text-cyan-700 hover:bg-cyan-50 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">download</span>
                    Download All
                </button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <template x-for="(url, key) in documentData" :key="key">
                    <div x-show="url && typeof url === 'string' && url.startsWith('admissions/')" class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2" x-text="key.replace(/([A-Z])/g, ' $1').replace(/^./, s => s.toUpperCase())"></p>
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2 min-w-0">
                                <span class="material-symbols-outlined text-slate-400 text-lg shrink-0">description</span>
                                <a :href="'/storage/' + url" target="_blank"
                                   class="text-xs font-bold text-cyan-600 hover:underline truncate">View</a>
                            </div>
                            <a :href="'/storage/' + url" download target="_blank"
                               class="text-xs font-bold text-slate-600 hover:text-cyan-600 hover:bg-white px-2 py-1 rounded-lg transition-colors flex items-center gap-1 shrink-0 border border-slate-200">
                                <span class="material-symbols-outlined text-sm">download</span>
                                Download
                            </a>
                        </div>
                    </div>
                </template>
                <div x-show="!documentData || Object.keys(documentData).filter(k => documentData[k] && typeof documentData[k] === 'string' && documentData[k].startsWith('admissions/')).length === 0"
                     class="col-span-full text-center py-8 text-slate-400">
                    <span class="material-symbols-outlined text-3xl block mb-2">folder_off</span>
                    <p class="text-sm font-medium">No documents uploaded yet</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Broadcast Message Modal -->
        <div x-show="isBroadcastModalOpen" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center px-4">
            <div x-show="isBroadcastModalOpen" @click="isBroadcastModalOpen = false"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div x-show="isBroadcastModalOpen"
                x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-10 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-10 scale-95"
                class="w-full max-w-xl bg-white p-8 rounded-3xl border border-slate-200 shadow-2xl relative z-10">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-extrabold tracking-tight text-cyan-700">Broadcast Message</h2>
                    <button @click="isBroadcastModalOpen = false" class="p-2 hover:bg-slate-100 rounded-full text-slate-500 transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <form @submit.prevent="sendBroadcast" class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold tracking-wide uppercase text-slate-500 mb-2">Audience</label>
                        <select x-model="broadcastAudience" required
                            class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500/20 outline-none text-slate-700 font-medium text-sm">
                            <option value="all">All Students</option>
                            <option value="active">Active Students</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold tracking-wide uppercase text-slate-500 mb-2">Subject</label>
                        <input type="text" x-model="broadcastSubject" required
                            class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500/20 outline-none text-slate-700 font-medium placeholder:text-slate-400 text-sm"
                            placeholder="Important Announcement..." />
                    </div>
                    <div>
                        <label class="block text-xs font-bold tracking-wide uppercase text-slate-500 mb-2">Message</label>
                        <textarea x-model="broadcastMessage" required rows="5"
                            class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500/20 outline-none text-slate-700 font-medium placeholder:text-slate-400 text-sm resize-none"
                            placeholder="Type your message here..."></textarea>
                    </div>
                    <button type="submit"
                        class="w-full py-4 rounded-xl signature-gradient text-white font-bold text-sm shadow-lg hover:opacity-90 transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-sm">send</span>
                        Send Message
                    </button>
                </form>
            </div>
        </div>

        <!-- Generic Action Modal -->
        <div x-show="activeModal" x-cloak class="fixed inset-0 z-[170] flex items-center justify-center px-4">
            <div @click="closeModal()" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div class="relative w-full max-w-lg bg-white p-4 sm:p-8 rounded-3xl border border-slate-200 shadow-2xl z-10 max-h-[85dvh] overflow-y-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-extrabold tracking-tight text-cyan-700" x-text="modalTitle"></h2>
                    <button @click="closeModal()" class="p-2 hover:bg-slate-100 rounded-full text-slate-500"><span class="material-symbols-outlined">close</span></button>
                </div>

                <!-- Document Verify -->
                <form x-show="activeModal === 'docVerify'" @submit.prevent="submitAction('{{ route('admin.documents.verify') }}', formData)" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Admission ID</label>
                        <input type="number" x-model="formData.admission_id" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Enter admission ID">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Document Type</label>
                        <select x-model="formData.document" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                            <option value="Aadhaar">Aadhaar</option>
                            <option value="Transfer Certificate">Transfer Certificate</option>
                            <option value="Passport Photo">Passport Photo</option>
                            <option value="Signature">Signature</option>
                            <option value="Previous Marksheets">Previous Marksheets</option>
                            <option value="Category Certificate">Category Certificate</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Action</label>
                        <select x-model="formData.action" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                            <option value="approve">Approve</option>
                            <option value="reject">Reject</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm">Submit</button>
                </form>

                <!-- Document Re-upload -->
                <form x-show="activeModal === 'docReupload'" @submit.prevent="submitAction('{{ route('admin.documents.reupload') }}', formData)" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Admission ID</label>
                        <input type="number" x-model="formData.admission_id" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Enter admission ID">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Documents to Re-upload</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm"><input type="checkbox" value="Aadhaar" x-model="formData.documents" class="rounded"> Aadhaar</label>
                            <label class="flex items-center gap-2 text-sm"><input type="checkbox" value="Transfer Certificate" x-model="formData.documents" class="rounded"> Transfer Certificate</label>
                            <label class="flex items-center gap-2 text-sm"><input type="checkbox" value="Passport Photo" x-model="formData.documents" class="rounded"> Passport Photo</label>
                            <label class="flex items-center gap-2 text-sm"><input type="checkbox" value="Signature" x-model="formData.documents" class="rounded"> Signature</label>
                            <label class="flex items-center gap-2 text-sm"><input type="checkbox" value="Previous Marksheets" x-model="formData.documents" class="rounded"> Previous Marksheets</label>
                            <label class="flex items-center gap-2 text-sm"><input type="checkbox" value="Category Certificate" x-model="formData.documents" class="rounded"> Category Certificate</label>
                        </div>
                    </div>
                    <button type="submit" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm">Request Re-upload</button>
                </form>

                <!-- TMA Upload (file) -->
                <form x-show="activeModal === 'tmaUpload'" id="tmaUploadForm" @submit.prevent="submitFormData('{{ route('admin.tma.upload') }}', 'tmaUploadForm')" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Assignment Title</label>
                        <input type="text" name="title" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. TMA-01 Mathematics">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Submission Deadline</label>
                        <input type="date" name="deadline" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">PDF File</label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                    </div>
                    <button type="submit" :disabled="isFormUploading" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm disabled:opacity-50" x-text="isFormUploading ? 'Uploading...' : 'Upload'"></button>
                </form>

                <!-- TMA Set Deadline -->
                <form x-show="activeModal === 'tmaSetDeadline'" @submit.prevent="submitAction('{{ route('admin.tma.upload') }}', formData)" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Assignment Title</label>
                        <input type="text" x-model="formData.title" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. TMA-01 Mathematics">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">New Deadline</label>
                        <input type="date" x-model="formData.deadline" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                    </div>
                    <button type="submit" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm">Set Deadline</button>
                </form>

                <!-- TMA Publish Marks -->
                <form x-show="activeModal === 'tmaPublish'" @submit.prevent="submitAction('{{ route('admin.tma.upload') }}', formData)" class="space-y-4">
                    <p class="text-xs text-slate-500">Enter marks for student TMA submissions. Use the TMA Management page for detailed entry.</p>
                    <button type="submit" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm">Proceed to TMA Page</button>
                </form>

                <!-- Exam Notification -->
                <form x-show="activeModal === 'examNotification'" @submit.prevent="submitAction('{{ route('admin.exams.notification') }}', formData)" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Title</label>
                        <input type="text" x-model="formData.title" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. Public Exam 2025 Schedule">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Message</label>
                        <textarea x-model="formData.message" required rows="4" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm resize-none" placeholder="Notification details..."></textarea>
                    </div>
                    <button type="submit" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm">Send Notification</button>
                </form>

                <!-- Exam Fee Deadline -->
                <form x-show="activeModal === 'examFeeDeadline'" @submit.prevent="submitAction('{{ route('admin.exams.notification') }}', formData)" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Deadline Title</label>
                        <input type="text" x-model="formData.title" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. Public Exam Fee">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Message with Deadline</label>
                        <textarea x-model="formData.message" required rows="4" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm resize-none" placeholder="Include deadline date and instructions..."></textarea>
                    </div>
                    <button type="submit" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm">Update Deadline</button>
                </form>

                <!-- Exam Hall Ticket (file) -->
                <form x-show="activeModal === 'examHallTicket'" id="hallTicketForm" @submit.prevent="submitFormData('{{ route('admin.exams.hallticket') }}', 'hallTicketForm')" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Exam Name</label>
                        <input type="text" name="exam_name" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. Public Exam April 2025">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Hall Ticket PDF</label>
                        <input type="file" name="file" accept=".pdf" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                    </div>
                    <button type="submit" :disabled="isFormUploading" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm disabled:opacity-50" x-text="isFormUploading ? 'Uploading...' : 'Upload'"></button>
                </form>

                <!-- PCP Hall Ticket (file) -->
                <form x-show="activeModal === 'pcpHallTicket'" id="pcpHallTicketForm" @submit.prevent="submitFormData('{{ route('admin.exams.hallticket') }}', 'pcpHallTicketForm')" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">PCP Program Name</label>
                        <input type="text" name="exam_name" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. PCP Session 1">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Hall Ticket PDF</label>
                        <input type="file" name="file" accept=".pdf" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                    </div>
                    <button type="submit" :disabled="isFormUploading" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm disabled:opacity-50" x-text="isFormUploading ? 'Uploading...' : 'Upload'"></button>
                </form>

                <!-- Study Material Upload (file) -->
                <form x-show="activeModal === 'studyUpload'" id="studyUploadForm" @submit.prevent="submitFormData('{{ route('admin.study.upload') }}', 'studyUploadForm')" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Title</label>
                        <input type="text" name="title" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. Chapter 1 - Physics">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Level</label>
                        <select name="level" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                            <option value="secondary">Secondary (10th)</option>
                            <option value="senior_secondary">Senior Secondary (12th)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Subject</label>
                        <input type="text" name="subject" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. Physics, Mathematics">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">PDF File</label>
                        <input type="file" name="file" accept=".pdf" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                    </div>
                    <button type="submit" :disabled="isFormUploading" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm disabled:opacity-50" x-text="isFormUploading ? 'Uploading...' : 'Upload'"></button>
                </form>

                <!-- Result Upload -->
                <form x-show="activeModal === 'resultUpload'" @submit.prevent="submitAction('{{ route('admin.results.publish') }}', formData)" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Exam Name</label>
                        <input type="text" x-model="formData.exam_name" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. Public Exam April 2025">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Result Link (URL)</label>
                        <input type="url" x-model="formData.link" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="https://results.nios.ac.in/...">
                    </div>
                    <button type="submit" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm">Publish Result</button>
                </form>

                <!-- Result Verify -->
                <form x-show="activeModal === 'resultVerify'" @submit.prevent="submitAction('{{ route('admin.results.publish') }}', formData)" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Enrollment Number</label>
                        <input type="text" x-model="formData.enrollment" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. TBC-2025-XXXXXX">
                    </div>
                    <button type="submit" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm">Verify</button>
                </form>
            </div>
        </div>

        <!-- Broadcast confirmation toast -->
        <div x-show="showToast"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-4"
             class="fixed top-6 left-4 right-4 sm:left-auto sm:right-6 z-[200] bg-green-600 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 text-sm font-bold">
            <span class="material-symbols-outlined text-lg">check_circle</span>
            <span x-text="toastMessage"></span>
        </div>
    </div>
</x-admin-layout>