<x-admin-layout>
<div x-data="{
    isBroadcastModalOpen: false,
    broadcastAudience: 'all',
    broadcastSubject: '',
    broadcastMessage: '',
    showToast: false,
    toastMessage: '',
    documentData: null,
    documentName: '',
    actionAdmission: null,
    actionDropdown: null,
    actionDropdownRect: null,
    sendingStatus: false,
    studentMsg: { show: false, id: null, name: '', email: '', subject: '', message: '', sending: false },
    activeModal: null,
    modalTitle: '',
    formData: {},
    isFormUploading: false,
    openModal(name, title) { this.activeModal = name; this.modalTitle = title; this.formData = {}; },
    closeModal() { this.activeModal = null; this.formData = {}; },
    async submitAction(route, data) {
        try {
            const resp = await fetch(route, {
                method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify(data)
            });
            const result = await resp.json();
            if (result.success) { this.toastMessage = result.message; this.showToast = true; this.closeModal(); setTimeout(() => this.showToast = false, 4000); }
            else { alert(result.message || 'Action failed.'); }
        } catch { alert('Network error.'); }
    },
    async submitFormData(route, formId) {
        const form = document.getElementById(formId); if (!form) return;
        this.isFormUploading = true;
        try {
            const fd = new FormData(form);
            const resp = await fetch(route, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }, body: fd });
            const result = await resp.json();
            if (result.success) { this.toastMessage = result.message; this.showToast = true; this.closeModal(); setTimeout(() => this.showToast = false, 4000); }
            else { alert(result.message || 'Action failed.'); }
        } catch { alert('Network error.'); } finally { this.isFormUploading = false; }
    },
    openStudentMsg(id, name, email) { this.studentMsg = { show: true, id, name, email, subject: '', message: '', sending: false }; },
    async sendStudentMsg() {
        if (!this.studentMsg.subject.trim() || !this.studentMsg.message.trim()) return;
        this.studentMsg.sending = true;
        try {
            const resp = await fetch('{{ route('admin.student.message') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ email: this.studentMsg.email, subject: this.studentMsg.subject, message: this.studentMsg.message }) });
            const data = await resp.json();
            if (data.success) { this.toastMessage = 'Message sent to ' + this.studentMsg.name; this.showToast = true; this.studentMsg.show = false; setTimeout(() => this.showToast = false, 4000); }
            else { alert('Failed to send message'); }
        } catch { alert('Network error'); } finally { this.studentMsg.sending = false; }
    },
    viewDocuments(docsJson, name) { this.documentData = JSON.parse(docsJson); this.documentName = name; },
    async updateStatus(admissionId, status) {
        this.sendingStatus = true;
        try {
            const resp = await fetch('/admin/admissions/' + admissionId + '/status', { method: 'PUT', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ status: status }) });
            const data = await resp.json();
            if (data.success) {
                if (data.credentials) { this.toastMessage = 'Student approved! Enrollment: ' + data.credentials.enrollment_number + ' | Password: ' + data.credentials.password; }
                else { this.toastMessage = 'Status updated to ' + status; }
                this.showToast = true; this.actionDropdown = null; this.actionAdmission = null; setTimeout(() => this.showToast = false, 6000);
            }
        } catch (e) { alert('Failed to update status'); } finally { this.sendingStatus = false; }
    },
    sendBroadcast() {
        fetch('/admin/message', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }, body: JSON.stringify({ audience: this.broadcastAudience, subject: this.broadcastSubject, message: this.broadcastMessage }) })
        .then(r => r.json()).then(data => {
            if(data.success) { this.isBroadcastModalOpen = false; this.toastMessage = 'Message sent successfully!'; this.showToast = true; this.broadcastSubject = ''; this.broadcastMessage = ''; setTimeout(() => this.showToast = false, 4000); }
            else { alert('Error: ' + (data.message || 'Something went wrong')); }
        }).catch(e => { console.error(e); alert('Failed to send broadcast'); });
    }
}">

    <!-- Enrollment Quick Action Banner -->
    <div class="max-w-7xl mx-auto mb-8">
        <div class="glass-panel p-4 rounded-xl flex items-center justify-between border border-white/20">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 signature-gradient rounded-lg flex items-center justify-center text-white shadow-md">
                    <span class="material-symbols-outlined text-lg">bolt</span>
                </div>
                <div>
                    <h2 class="font-display font-bold text-lg text-on-background">Enrollment Quick Action</h2>
                    <p class="text-xs text-on-surface-variant">Streamlined student registration portal</p>
                </div>
            </div>
            <a href="{{ route('admin.admissions.create') }}" class="signature-gradient text-white px-8 py-3 rounded-full flex items-center gap-3 shadow-lg hover:opacity-90 hover:scale-[1.02] transition-all duration-300 group">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span class="font-bold text-sm tracking-tight uppercase">New Enrollment</span>
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="max-w-7xl mx-auto space-y-10">

        <!-- Bento Hero Grid: Admission KPIs -->
        <section class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Total Admissions -->
            <div class="md:col-span-2 glass-panel p-8 rounded-xl flex flex-col justify-between overflow-hidden relative group">
                <div class="relative z-10">
                    <span class="font-label text-label-md tracking-[0.1em] uppercase text-on-surface-variant/60 block mb-2">Total Admissions Cycle 24</span>
                    <h2 class="text-display-lg font-bold text-6xl tracking-tight text-primary mb-4">{{ $studentCount }}</h2>
                    <div class="flex items-center gap-2 text-primary font-bold">
                        <span class="material-symbols-outlined text-sm">trending_up</span>
                        <span class="text-sm">+{{ $approvedAdmissions }} approved this cycle</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-[120px]">how_to_reg</span>
                </div>
            </div>

            <!-- Approved -->
            <div class="glass-panel p-6 rounded-xl ghost-border hover:bg-surface-container-lowest/90 transition-all">
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-6">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </div>
                <span class="font-label text-label-md tracking-[0.1em] uppercase text-on-surface-variant/60 block mb-1">Approved</span>
                <h3 class="text-3xl font-bold text-on-background">{{ $approvedAdmissions }}</h3>
                <div class="w-full bg-surface-variant h-1 rounded-full mt-6 overflow-hidden">
                    <div class="h-full bg-primary" style="width: {{ $studentCount > 0 ? ($approvedAdmissions / $studentCount) * 100 : 0 }}%;"></div>
                </div>
            </div>

            <!-- Pending -->
            <div class="glass-panel p-6 rounded-xl ghost-border hover:bg-surface-container-lowest/90 transition-all">
                <div class="w-12 h-12 rounded-full bg-secondary-container/30 flex items-center justify-center text-secondary mb-6">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">pending</span>
                </div>
                <span class="font-label text-label-md tracking-[0.1em] uppercase text-on-surface-variant/60 block mb-1">Pending</span>
                <h3 class="text-3xl font-bold text-on-background">{{ $pendingAdmissions }}</h3>
                <p class="text-xs text-on-surface-variant mt-4 italic">Awaiting review</p>
            </div>

            <!-- Rejected -->
            <div class="glass-panel p-6 rounded-xl ghost-border">
                <div class="w-12 h-12 rounded-full bg-error-container/10 flex items-center justify-center text-error mb-6">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">cancel</span>
                </div>
                <span class="font-label text-label-md tracking-[0.1em] uppercase text-on-surface-variant/60 block mb-1">Rejected</span>
                <h3 class="text-3xl font-bold text-on-background">{{ $rejectedAdmissions }}</h3>
                <p class="text-xs text-error mt-4">Manual override required</p>
            </div>

            <!-- Secondary Metrics Cards -->
            <div class="md:col-span-1 glass-panel p-6 rounded-xl ghost-border flex items-center gap-4">
                <div class="w-10 h-10 signature-gradient rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-[20px]">description</span>
                </div>
                <div>
                    <h4 class="text-2xl font-bold text-on-background leading-none">{{ $pendingAdmissions }}</h4>
                    <p class="text-xs text-on-surface-variant font-medium">Awaiting Docs</p>
                </div>
            </div>
            <div class="md:col-span-1 glass-panel p-6 rounded-xl ghost-border flex items-center gap-4">
                <div class="w-10 h-10 bg-secondary-container/50 rounded-lg flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[20px]">event</span>
                </div>
                <div>
                    <h4 class="text-2xl font-bold text-on-background leading-none">{{ $upcomingPcp }}</h4>
                    <p class="text-xs text-on-surface-variant font-medium">PCP Programs</p>
                </div>
            </div>
            <div class="md:col-span-1 glass-panel p-6 rounded-xl ghost-border flex items-center gap-4">
                <div class="w-10 h-10 bg-surface-container-high/60 rounded-lg flex items-center justify-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[20px]">assignment_late</span>
                </div>
                <div>
                    <h4 class="text-2xl font-bold text-on-background leading-none">{{ $upcomingExams }}</h4>
                    <p class="text-xs text-on-surface-variant font-medium">Public Exams</p>
                </div>
            </div>
            <div class="md:col-span-1 glass-panel p-6 rounded-xl ghost-border flex items-center gap-4">
                <div class="w-10 h-10 bg-primary/5 rounded-lg flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[20px]">edit_note</span>
                </div>
                <div>
                    <h4 class="text-2xl font-bold text-on-background leading-none">{{ $pendingTma }}</h4>
                    <p class="text-xs text-on-surface-variant font-medium">TMA Evaluations</p>
                </div>
            </div>
        </section>

        <!-- Revenue & Activity Section -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Revenue Chart Container -->
            <div class="lg:col-span-2 glass-panel p-8 rounded-xl relative overflow-hidden">
                <div class="flex justify-between items-start mb-8 relative z-10">
                    <div>
                        <span class="font-label text-label-md tracking-[0.1em] uppercase text-on-surface-variant/60 block mb-1">Total Revenue</span>
                        <h2 class="text-4xl font-bold text-on-background">₹{{ number_format($totalRevenue, 2) }}</h2>
                    </div>
                    <div class="flex items-center gap-2 bg-surface-container-low/50 px-3 py-1 rounded-full ghost-border">
                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                        <span class="text-xs font-bold text-primary">LIVE TREND</span>
                    </div>
                </div>
                
                <div class="h-64 flex items-end gap-2 relative">
                    @if($totalRevenue > 0)
                        <div class="w-full h-full flex items-end gap-4">
                            <div class="flex-1 bg-primary/10 rounded-t-lg h-[25%] relative group">
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 bg-on-background text-surface text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity mb-2">₹{{ number_format($totalRevenue * 0.25, 0) }}</div>
                            </div>
                            <div class="flex-1 bg-primary/20 rounded-t-lg h-[40%] relative group">
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 bg-on-background text-surface text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity mb-2">₹{{ number_format($totalRevenue * 0.4, 0) }}</div>
                            </div>
                            <div class="flex-1 bg-primary/30 rounded-t-lg h-[55%] relative group">
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 bg-on-background text-surface text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity mb-2">₹{{ number_format($totalRevenue * 0.55, 0) }}</div>
                            </div>
                            <div class="flex-1 bg-primary/50 rounded-t-lg h-[70%] relative group">
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 bg-on-background text-surface text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity mb-2">₹{{ number_format($totalRevenue * 0.7, 0) }}</div>
                            </div>
                            <div class="flex-1 signature-gradient rounded-t-lg h-[90%] relative group">
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 bg-on-background text-surface text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity mb-2">₹{{ number_format($totalRevenue, 0) }}</div>
                            </div>
                        </div>
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-on-surface-variant/20 font-bold tracking-widest uppercase text-xs">No data available for this period</div>
                    @endif
                </div>
                <div class="mt-6 flex justify-between text-[10px] uppercase tracking-widest text-on-surface-variant/40 font-bold">
                    <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span><span>Aug</span>
                </div>
            </div>
            <!-- Recent Activities Timeline -->
            <div class="lg:col-span-1 glass-panel p-8 rounded-xl flex flex-col">
                <h3 class="font-display font-bold text-xl mb-6">Recent Activity Logs</h3>
                <div class="space-y-6 flex-1 relative overflow-y-auto max-h-[300px] pr-2 custom-scrollbar">
                    @forelse($recentAdmissions as $adm)
                        <div class="flex gap-4 items-start relative pb-6 border-l border-slate-200/50 pl-4 last:border-0 last:pb-0">
                            <div class="absolute left-[-4px] top-1.5 w-2 h-2 rounded-full {{ $adm->status === 'Approved' ? 'bg-primary' : ($adm->status === 'Pending' ? 'bg-amber-500' : 'bg-error') }}"></div>
                            <div>
                                <p class="text-xs text-on-background font-semibold leading-tight">{{ $adm->full_name }}</p>
                                <p class="text-[10px] text-on-surface-variant mt-0.5">{{ $adm->course_type }} Admission Status: <strong class="{{ $adm->status === 'Approved' ? 'text-primary' : ($adm->status === 'Pending' ? 'text-amber-600' : 'text-error') }}">{{ $adm->status }}</strong></p>
                                <p class="text-[9px] text-on-surface-variant/50 font-bold uppercase mt-1">{{ $adm->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full text-center py-12">
                            <span class="material-symbols-outlined text-on-surface-variant/20 text-6xl mb-4">history</span>
                            <p class="text-sm font-medium text-on-surface-variant/60">No recent activity</p>
                            <p class="text-[10px] text-on-surface-variant/40 uppercase tracking-wider mt-1">System logs are currently empty</p>
                        </div>
                    @endforelse
                </div>
                <a href="{{ route('admin.admissions') }}" class="mt-8 w-full py-3 rounded-xl border border-outline-variant/30 text-center text-on-surface-variant text-sm font-bold hover:bg-surface-container-high/40 transition-all uppercase tracking-widest">
                    View Audit Log
                </a>
            </div>
        </section>



    </div>

    <!-- Per-Student Message Modal -->
    <div x-show="studentMsg.show" x-cloak class="fixed inset-0 z-[160] flex items-center justify-center px-4">
        <div @click="studentMsg.show = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-lg bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-2xl z-10">
            <div class="flex justify-between items-center mb-6">
                <div><h2 class="text-xl font-extrabold tracking-tight text-primary">Send Message</h2><p class="text-sm text-slate-500 mt-1" x-text="'To: ' + studentMsg.name"></p></div>
                <button @click="studentMsg.show = false" class="p-2 hover:bg-slate-100 rounded-full text-slate-500 transition-colors"><span class="material-symbols-outlined">close</span></button>
            </div>
            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold tracking-wide uppercase text-slate-500 mb-2">Subject</label>
                    <input type="text" x-model="studentMsg.subject" required maxlength="255" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none text-slate-700 font-medium text-sm" placeholder="Enrollment Credentials / Update..." />
                </div>
                <div>
                    <label class="block text-xs font-bold tracking-wide uppercase text-slate-500 mb-2">Message</label>
                    <textarea x-model="studentMsg.message" required rows="5" maxlength="5000" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none text-slate-700 font-medium text-sm resize-none" placeholder="Type your message here..."></textarea>
                </div>
                <button @click="sendStudentMsg()" :disabled="studentMsg.sending || !studentMsg.subject.trim() || !studentMsg.message.trim()" class="w-full py-4 rounded-xl signature-gradient text-white font-bold text-sm shadow-lg hover:opacity-90 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <span x-show="studentMsg.sending" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                    <span x-text="studentMsg.sending ? 'Sending...' : 'Send Message'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Status Dropdown -->
    <div x-show="actionDropdown" x-cloak :style="'position:fixed;top:' + (actionDropdownRect?.top || 0) + 'px;left:' + (actionDropdownRect?.left || 0) + 'px'" @click.outside="actionDropdown = null" class="w-52 bg-white border border-slate-200 rounded-xl shadow-xl z-[150] py-1 overflow-hidden">
        <button @click="actionAdmission && updateStatus(actionAdmission, 'Approved')" :disabled="sendingStatus" class="w-full text-left px-4 py-2.5 text-sm font-medium text-green-700 hover:bg-green-50 flex items-center gap-2 transition-colors disabled:opacity-50"><span class="material-symbols-outlined text-sm">check_circle</span> Approved</button>
        <button @click="actionAdmission && updateStatus(actionAdmission, 'Rejected')" :disabled="sendingStatus" class="w-full text-left px-4 py-2.5 text-sm font-medium text-red-700 hover:bg-red-50 flex items-center gap-2 transition-colors disabled:opacity-50"><span class="material-symbols-outlined text-sm">cancel</span> Rejected</button>
        <button @click="actionAdmission && updateStatus(actionAdmission, 'Document Error')" :disabled="sendingStatus" class="w-full text-left px-4 py-2.5 text-sm font-medium text-orange-700 hover:bg-orange-50 flex items-center gap-2 transition-colors disabled:opacity-50"><span class="material-symbols-outlined text-sm">description</span> Document Error</button>
        <button @click="actionAdmission && updateStatus(actionAdmission, 'Need to Pay Fees')" :disabled="sendingStatus" class="w-full text-left px-4 py-2.5 text-sm font-medium text-amber-700 hover:bg-amber-50 flex items-center gap-2 transition-colors disabled:opacity-50"><span class="material-symbols-outlined text-sm">payments</span> Need to Pay Fees</button>
    </div>

    <!-- Document Viewer Modal -->
    <div x-show="documentData" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center px-4">
        <div @click="documentData = null" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-2xl bg-white p-4 sm:p-8 rounded-3xl border border-slate-200 shadow-2xl z-10 max-h-[85dvh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <div><h2 class="text-xl font-extrabold tracking-tight text-primary">Student Documents</h2><p class="text-sm text-slate-500 mt-1" x-text="documentName"></p></div>
                <button @click="documentData = null" class="p-2 hover:bg-slate-100 rounded-full text-slate-500 transition-colors"><span class="material-symbols-outlined">close</span></button>
            </div>
            <div class="flex items-center justify-between mb-4">
                <p class="text-xs text-slate-500">Click to view or download each document</p>
                <button @click="documentData && Object.keys(documentData).forEach(k => { const url = documentData[k]; if (url && typeof url === 'string' && url.startsWith('admissions/')) { const a = document.createElement('a'); a.href = '/storage/' + url; a.download = url.split('/').pop(); a.click(); } });" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">download</span> Download All
                </button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <template x-for="(url, key) in documentData" :key="key">
                    <div x-show="url && typeof url === 'string' && url.startsWith('admissions/')" class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2" x-text="key.replace(/([A-Z])/g, ' $1').replace(/^./, s => s.toUpperCase())"></p>
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2 min-w-0">
                                <span class="material-symbols-outlined text-slate-400 text-lg shrink-0">description</span>
                                <a :href="'/storage/' + url" target="_blank" class="text-xs font-bold text-primary hover:underline truncate">View</a>
                            </div>
                            <a :href="'/storage/' + url" download target="_blank" class="text-xs font-bold text-slate-600 hover:text-primary hover:bg-white px-2 py-1 rounded-lg transition-colors flex items-center gap-1 shrink-0 border border-slate-200">
                                <span class="material-symbols-outlined text-sm">download</span> Download
                            </a>
                        </div>
                    </div>
                </template>
                <div x-show="!documentData || Object.keys(documentData).filter(k => documentData[k] && typeof documentData[k] === 'string' && documentData[k].startsWith('admissions/')).length === 0" class="col-span-full text-center py-8 text-slate-400">
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
                <h2 class="text-2xl font-extrabold tracking-tight text-primary">Broadcast Message</h2>
                <button @click="isBroadcastModalOpen = false" class="p-2 hover:bg-slate-100 rounded-full text-slate-500 transition-colors"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form @submit.prevent="sendBroadcast" class="space-y-5">
                <div>
                    <label class="block text-xs font-bold tracking-wide uppercase text-slate-500 mb-2">Audience</label>
                    <select x-model="broadcastAudience" required class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none text-slate-700 font-medium text-sm">
                        <option value="all">All Students</option>
                        <option value="active">Active Students</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold tracking-wide uppercase text-slate-500 mb-2">Subject</label>
                    <input type="text" x-model="broadcastSubject" required class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none text-slate-700 font-medium text-sm" placeholder="Important Announcement..." />
                </div>
                <div>
                    <label class="block text-xs font-bold tracking-wide uppercase text-slate-500 mb-2">Message</label>
                    <textarea x-model="broadcastMessage" required rows="5" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none text-slate-700 font-medium text-sm resize-none" placeholder="Type your message here..."></textarea>
                </div>
                <button type="submit" class="w-full py-4 rounded-xl signature-gradient text-white font-bold text-sm shadow-lg hover:opacity-90 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">send</span> Send Message
                </button>
            </form>
        </div>
    </div>

    <!-- Generic Action Modal -->
    <div x-show="activeModal" x-cloak class="fixed inset-0 z-[170] flex items-center justify-center px-4">
        <div @click="closeModal()" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-lg bg-white p-4 sm:p-8 rounded-3xl border border-slate-200 shadow-2xl z-10 max-h-[85dvh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-extrabold tracking-tight text-primary" x-text="modalTitle"></h2>
                <button @click="closeModal()" class="p-2 hover:bg-slate-100 rounded-full text-slate-500"><span class="material-symbols-outlined">close</span></button>
            </div>

            <form x-show="activeModal === 'docVerify'" @submit.prevent="submitAction('{{ route('admin.documents.verify') }}', formData)" class="space-y-4">
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Admission ID</label><input type="number" x-model="formData.admission_id" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Enter admission ID"></div>
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Document Type</label><select x-model="formData.document" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm"><option value="Aadhaar">Aadhaar</option><option value="Transfer Certificate">Transfer Certificate</option><option value="Passport Photo">Passport Photo</option><option value="Signature">Signature</option><option value="Previous Marksheets">Previous Marksheets</option><option value="Category Certificate">Category Certificate</option></select></div>
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Action</label><select x-model="formData.action" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm"><option value="approve">Approve</option><option value="reject">Reject</option></select></div>
                <button type="submit" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm">Submit</button>
            </form>

            <form x-show="activeModal === 'docReupload'" @submit.prevent="submitAction('{{ route('admin.documents.reupload') }}', formData)" class="space-y-4">
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Admission ID</label><input type="number" x-model="formData.admission_id" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="Enter admission ID"></div>
                <div><label class="block text-xs font-bold text-slate-500 mb-2">Documents to Re-upload</label><div class="space-y-2"><label class="flex items-center gap-2 text-sm"><input type="checkbox" value="Aadhaar" x-model="formData.documents" class="rounded"> Aadhaar</label><label class="flex items-center gap-2 text-sm"><input type="checkbox" value="Transfer Certificate" x-model="formData.documents" class="rounded"> Transfer Certificate</label><label class="flex items-center gap-2 text-sm"><input type="checkbox" value="Passport Photo" x-model="formData.documents" class="rounded"> Passport Photo</label><label class="flex items-center gap-2 text-sm"><input type="checkbox" value="Signature" x-model="formData.documents" class="rounded"> Signature</label><label class="flex items-center gap-2 text-sm"><input type="checkbox" value="Previous Marksheets" x-model="formData.documents" class="rounded"> Previous Marksheets</label><label class="flex items-center gap-2 text-sm"><input type="checkbox" value="Category Certificate" x-model="formData.documents" class="rounded"> Category Certificate</label></div></div>
                <button type="submit" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm">Request Re-upload</button>
            </form>

            <form x-show="activeModal === 'tmaUpload'" id="tmaUploadForm" @submit.prevent="submitFormData('{{ route('admin.tma.upload') }}', 'tmaUploadForm')" class="space-y-4">
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Assignment Title</label><input type="text" name="title" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. TMA-01 Mathematics"></div>
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Submission Deadline</label><input type="date" name="deadline" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm"></div>
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">PDF File</label><input type="file" name="file" accept=".pdf,.doc,.docx" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm"></div>
                <button type="submit" :disabled="isFormUploading" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm disabled:opacity-50" x-text="isFormUploading ? 'Uploading...' : 'Upload'"></button>
            </form>

            <form x-show="activeModal === 'tmaSetDeadline'" @submit.prevent="submitAction('{{ route('admin.tma.upload') }}', formData)" class="space-y-4">
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Assignment Title</label><input type="text" x-model="formData.title" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. TMA-01 Mathematics"></div>
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">New Deadline</label><input type="date" x-model="formData.deadline" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm"></div>
                <button type="submit" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm">Set Deadline</button>
            </form>

            <form x-show="activeModal === 'examNotification'" @submit.prevent="submitAction('{{ route('admin.exams.notification') }}', formData)" class="space-y-4">
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Title</label><input type="text" x-model="formData.title" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. Public Exam 2025 Schedule"></div>
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Message</label><textarea x-model="formData.message" required rows="4" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm resize-none" placeholder="Notification details..."></textarea></div>
                <button type="submit" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm">Send Notification</button>
            </form>

            <form x-show="activeModal === 'examFeeDeadline'" @submit.prevent="submitAction('{{ route('admin.exams.notification') }}', formData)" class="space-y-4">
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Deadline Title</label><input type="text" x-model="formData.title" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. Public Exam Fee"></div>
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Message with Deadline</label><textarea x-model="formData.message" required rows="4" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm resize-none" placeholder="Include deadline date and instructions..."></textarea></div>
                <button type="submit" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm">Update Deadline</button>
            </form>

            <form x-show="activeModal === 'examHallTicket'" id="hallTicketForm" @submit.prevent="submitFormData('{{ route('admin.exams.hallticket') }}', 'hallTicketForm')" class="space-y-4">
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Exam Name</label><input type="text" name="exam_name" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. Public Exam April 2025"></div>
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Hall Ticket PDF</label><input type="file" name="file" accept=".pdf" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm"></div>
                <button type="submit" :disabled="isFormUploading" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm disabled:opacity-50" x-text="isFormUploading ? 'Uploading...' : 'Upload'"></button>
            </form>

            <form x-show="activeModal === 'pcpHallTicket'" id="pcpHallTicketForm" @submit.prevent="submitFormData('{{ route('admin.exams.hallticket') }}', 'pcpHallTicketForm')" class="space-y-4">
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">PCP Program Name</label><input type="text" name="exam_name" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. PCP Session 1"></div>
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Hall Ticket PDF</label><input type="file" name="file" accept=".pdf" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm"></div>
                <button type="submit" :disabled="isFormUploading" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm disabled:opacity-50" x-text="isFormUploading ? 'Uploading...' : 'Upload'"></button>
            </form>

            <form x-show="activeModal === 'studyUpload'" id="studyUploadForm" @submit.prevent="submitFormData('{{ route('admin.study.upload') }}', 'studyUploadForm')" class="space-y-4">
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Title</label><input type="text" name="title" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. Chapter 1 - Physics"></div>
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Level</label><select name="level" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm"><option value="secondary">Secondary (10th)</option><option value="senior_secondary">Senior Secondary (12th)</option></select></div>
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Subject</label><input type="text" name="subject" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. Physics, Mathematics"></div>
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">PDF File</label><input type="file" name="file" accept=".pdf" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm"></div>
                <button type="submit" :disabled="isFormUploading" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm disabled:opacity-50" x-text="isFormUploading ? 'Uploading...' : 'Upload'"></button>
            </form>

            <form x-show="activeModal === 'resultUpload'" @submit.prevent="submitAction('{{ route('admin.results.publish') }}', formData)" class="space-y-4">
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Exam Name</label><input type="text" x-model="formData.exam_name" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. Public Exam April 2025"></div>
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Result Link (URL)</label><input type="url" x-model="formData.link" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="https://results.nios.ac.in/..."></div>
                <button type="submit" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm">Publish Result</button>
            </form>

            <form x-show="activeModal === 'resultVerify'" @submit.prevent="submitAction('{{ route('admin.results.publish') }}', formData)" class="space-y-4">
                <div><label class="block text-xs font-bold uppercase text-slate-500 mb-2">Enrollment Number</label><input type="text" x-model="formData.enrollment" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm" placeholder="e.g. TBC-2025-XXXXXX"></div>
                <button type="submit" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm">Verify</button>
            </form>
        </div>
    </div>

    <!-- Toast -->
    <div x-show="showToast"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed top-6 left-4 right-4 sm:left-auto sm:right-6 z-[200] bg-green-600 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 text-sm font-bold">
        <span class="material-symbols-outlined text-lg">check_circle</span>
        <span x-text="toastMessage"></span>
    </div>

</div>
</x-admin-layout>
