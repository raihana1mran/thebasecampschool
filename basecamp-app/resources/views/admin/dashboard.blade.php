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
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mb-6 sm:mb-8">
        <div class="glass-panel p-4 sm:p-5 md:p-6 rounded-2xl">
            <p class="text-[9px] sm:text-[10px] font-bold uppercase tracking-widest text-primary mb-1 sm:mb-2">TOTAL STUDENTS</p>
            <p class="text-xl sm:text-2xl md:text-4xl font-extrabold text-cyan-700">{{ $studentCount }}</p>
        </div>
        <div class="glass-panel p-4 sm:p-5 md:p-6 rounded-2xl">
            <p class="text-[9px] sm:text-[10px] font-bold uppercase tracking-widest text-green-600 mb-1 sm:mb-2">ACTIVE STUDENTS</p>
            <p class="text-xl sm:text-2xl md:text-4xl font-extrabold text-green-600">{{ $activeStudents }}</p>
        </div>
        <div class="glass-panel p-4 sm:p-5 md:p-6 rounded-2xl">
            <p class="text-[9px] sm:text-[10px] font-bold uppercase tracking-widest text-amber-600 mb-1 sm:mb-2">PENDING ADMISSIONS</p>
            <p class="text-xl sm:text-2xl md:text-4xl font-extrabold text-amber-600">{{ $pendingAdmissions }}</p>
        </div>
        <div class="glass-panel p-4 sm:p-5 md:p-6 rounded-2xl">
            <p class="text-[9px] sm:text-[10px] font-bold uppercase tracking-widest text-blue-600 mb-1 sm:mb-2">NEW ENROLLMENTS</p>
            <p class="text-xl sm:text-2xl md:text-4xl font-extrabold text-blue-600">{{ $newEnrollments->count() }}</p>
        </div>
    </div>

    <!-- Single column - Newly Enrolled -->
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
                <table class="w-full text-left min-w-[700px]">
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
        <div class="relative w-full max-w-2xl bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-2xl z-10 max-h-[90vh] overflow-y-auto">
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

        <!-- Broadcast confirmation toast -->
        <div x-show="showToast"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-4"
             class="fixed top-6 right-6 z-[200] bg-green-600 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 text-sm font-bold">
            <span class="material-symbols-outlined text-lg">check_circle</span>
            <span x-text="toastMessage"></span>
        </div>
    </div>
</x-admin-layout>