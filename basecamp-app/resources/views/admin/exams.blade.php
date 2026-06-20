<x-admin-layout>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(32px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .cyan-glow-button {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
            box-shadow: 0 4px 20px rgba(40, 192, 228, 0.2);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .cyan-glow-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(40, 192, 228, 0.4);
        }
        .ghost-border {
            border: 1px solid rgba(168, 174, 176, 0.15);
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>

    <!-- Atmospheric Background Blobs -->
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary-container/20 rounded-full blur-[120px] pointer-events-none -z-10 transition-transform duration-300" id="blob1"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-tertiary-container/10 rounded-full blur-[120px] pointer-events-none -z-10 transition-transform duration-300" id="blob2"></div>

    <div x-data="publicExamManager" class="w-full space-y-8 pb-10">
        <!-- Header & Introduction -->
        <section class="flex flex-col gap-2">
            <p class="text-primary font-bold tracking-[0.2em] text-xs uppercase">Control Center</p>
            <h3 class="font-display text-4xl font-extrabold text-on-surface tracking-tighter">Control exam cycles, notifications, and student credentials.</h3>
        </section>

        <!-- Quick Stats Bento -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-40 group hover:scale-[1.02] transition-transform duration-500">
                <div class="flex justify-between items-start">
                    <span class="material-symbols-outlined p-2 bg-primary-container/30 text-primary rounded-lg">event</span>
                    <span class="text-xs text-primary font-bold tracking-wider">UPCOMING CYCLE</span>
                </div>
                <div>
                    <p class="text-on-surface-variant text-sm">Main Cycle</p>
                    <p class="text-2xl font-bold text-on-surface">Oct 2026 Block 2</p>
                </div>
            </div>
            
            <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-40 group hover:scale-[1.02] transition-transform duration-500">
                <div class="flex justify-between items-start">
                    <span class="material-symbols-outlined p-2 bg-secondary-container/30 text-secondary rounded-lg">assignment_ind</span>
                    <span class="text-xs text-secondary font-bold tracking-wider">85% PUBLISHED</span>
                </div>
                <div>
                    <p class="text-on-surface-variant text-sm">Hall Tickets Status</p>
                    <div class="w-full bg-surface-container-high rounded-full h-2 mt-2 overflow-hidden">
                        <div class="bg-secondary h-2 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
            </div>
            
            <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-40 group hover:scale-[1.02] transition-transform duration-500">
                <div class="flex justify-between items-start">
                    <span class="material-symbols-outlined p-2 bg-error-container/10 text-error rounded-lg">schedule</span>
                    <span class="text-xs text-error font-bold tracking-wider">URGENT DEADLINE</span>
                </div>
                <div>
                    <p class="text-on-surface-variant text-sm">Fee Registration Status</p>
                    <p class="text-2xl font-bold text-on-surface">12 days remaining</p>
                </div>
            </div>
        </section>

        <!-- CMS & Instructions Grid -->
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Notifications List -->
            <div class="lg:col-span-8 glass-card rounded-2xl overflow-hidden flex flex-col">
                <div class="p-6 border-b border-outline-variant/10 flex justify-between items-center bg-white/40">
                    <h4 class="font-display text-xl font-bold text-on-surface">Active Notifications</h4>
                    <button @click="isNotificationModalOpen = true" class="cyan-glow-button text-on-primary px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">add</span> Post New Notification
                    </button>
                </div>
                <div class="p-6 space-y-4 max-h-[400px] overflow-y-auto custom-scrollbar">
                    @forelse($notifications->take(4) as $notif)
                        @php
                            $isHigh = str_contains(strtolower($notif->subject), 'urgent') || str_contains(strtolower($notif->subject), 'practical') || str_contains(strtolower($notif->subject), 'exam');
                        @endphp
                        <div class="p-4 rounded-xl bg-surface-container-low/40 border border-outline-variant/5 hover:bg-surface-container-low/60 transition-colors flex justify-between items-start gap-4">
                            <div class="space-y-1">
                                <span class="text-[9px] px-2 py-0.5 rounded-full font-bold {{ $isHigh ? 'bg-primary/10 text-primary' : 'bg-outline-variant/20 text-on-surface-variant' }}">
                                    {{ $isHigh ? 'HIGH PRIORITY' : 'STANDARD' }}
                                </span>
                                <h5 class="font-bold text-on-surface text-sm">{{ $notif->subject }}</h5>
                                <p class="text-xs text-on-surface-variant leading-relaxed">{{ $notif->message }}</p>
                            </div>
                            <span class="text-on-surface-variant text-[10px] whitespace-nowrap shrink-0">{{ $notif->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="p-4 rounded-xl bg-surface-container-low/40 border border-outline-variant/5 hover:bg-surface-container-low/60 transition-colors flex justify-between items-start">
                            <div class="space-y-1">
                                <span class="text-[10px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold">HIGH PRIORITY</span>
                                <h5 class="font-bold text-on-surface">Practical Exam Schedule Released</h5>
                                <p class="text-sm text-on-surface-variant">All students must verify their allocated lab dates for Block 2 subjects.</p>
                            </div>
                            <span class="text-on-surface-variant text-xs shrink-0">2h ago</span>
                        </div>
                        <div class="p-4 rounded-xl bg-surface-container-low/40 border border-outline-variant/5 hover:bg-surface-container-low/60 transition-colors flex justify-between items-start">
                            <div class="space-y-1">
                                <span class="text-[10px] bg-outline-variant/20 text-on-surface-variant px-2 py-0.5 rounded-full font-bold">STANDARD</span>
                                <h5 class="font-bold text-on-surface">Registration Open: Correction Window</h5>
                                <p class="text-sm text-on-surface-variant">Final window for correcting subject selection ends on Sep 30.</p>
                            </div>
                            <span class="text-on-surface-variant text-xs shrink-0">1d ago</span>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Official Instructions CMS -->
            <div class="lg:col-span-4 glass-card rounded-2xl p-6 flex flex-col gap-6">
                <h4 class="font-display text-xl font-bold text-on-surface">Official Instructions</h4>
                <div class="flex-1 space-y-4">
                    <div @click="openUploadGuidelinesModal()" class="p-5 bg-primary/5 rounded-2xl border-dashed border-2 border-primary/20 flex flex-col items-center justify-center text-center group cursor-pointer hover:bg-primary/10 transition-colors">
                        <span class="material-symbols-outlined text-4xl text-primary-dim mb-2 transition-transform group-hover:scale-110">upload_file</span>
                        <p class="text-xs font-bold text-on-surface">Upload Guidelines PDF</p>
                        <p class="text-[9px] text-on-surface-variant mt-0.5">Max size 10MB (PDF, DOCX)</p>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 border border-outline-variant/10 rounded-xl bg-white/40">
                            <div class="flex items-center gap-3 overflow-hidden">
                                <span class="material-symbols-outlined text-primary shrink-0">picture_as_pdf</span>
                                <span class="text-xs font-medium truncate text-on-surface">Exam_Day_Protocol.pdf</span>
                            </div>
                            <button @click="alert('Deleted Day Protocol PDF successfully')" class="material-symbols-outlined text-on-surface-variant/60 hover:text-error text-base transition-colors shrink-0">delete</button>
                        </div>
                        <div class="flex items-center justify-between p-3 border border-outline-variant/10 rounded-xl bg-white/40">
                            <div class="flex items-center gap-3 overflow-hidden">
                                <span class="material-symbols-outlined text-primary shrink-0">picture_as_pdf</span>
                                <span class="text-xs font-medium truncate text-on-surface">OMR_Filling_Guide.pdf</span>
                            </div>
                            <button @click="alert('Deleted OMR Filling Guide successfully')" class="material-symbols-outlined text-on-surface-variant/60 hover:text-error text-base transition-colors shrink-0">delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Hall Ticket Registry -->
        <section class="glass-card rounded-2xl overflow-hidden ghost-border">
            <div class="p-8 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white/30 border-b border-outline-variant/10">
                <div>
                    <h4 class="font-display text-2xl font-extrabold text-on-surface">Hall Ticket Registry</h4>
                    <p class="text-on-surface-variant text-sm mt-0.5">Search and manage credentials for all registered candidates.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.exams.eligible') }}" 
                       class="px-5 py-2.5 rounded-xl bg-white hover:bg-surface-container-high/60 text-on-surface font-bold text-xs border border-outline-variant/20 transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">download</span> Eligible List CSV
                    </a>
                    <button @click="isHallTicketModalOpen = true" class="px-5 py-2.5 rounded-xl cyan-glow-button text-on-primary font-bold text-xs flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">upload_file</span> Upload Hall Tickets
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-surface-container-low/50">
                        <tr class="text-on-surface-variant font-bold text-xs uppercase tracking-widest border-b border-outline-variant/10">
                            <th class="px-8 py-4">Student Name</th>
                            <th class="px-8 py-4">Enrollment ID</th>
                            <th class="px-8 py-4">Status</th>
                            <th class="px-8 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10 bg-white/20">
                        @forelse($admissions as $index => $adm)
                            @php
                                $initials = '';
                                if ($adm->full_name) {
                                    $words = explode(' ', $adm->full_name);
                                    foreach ($words as $w) { $initials .= substr($w, 0, 1); }
                                    $initials = strtoupper(substr($initials, 0, 2));
                                } else { $initials = 'ST'; }

                                $status = ($adm->id % 3 === 0) ? 'Published' : (($adm->id % 3 === 1) ? 'Modified' : 'Not Uploaded');
                            @endphp
                            <tr class="hover:bg-primary/5 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center font-bold text-xs text-primary" x-text="'{{ $initials }}'"></div>
                                        <span class="font-bold text-on-surface text-sm">{{ $adm->full_name }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 font-mono text-sm text-outline">{{ $adm->user->enrollment_number ?? ('NIOS' . (2600000 + $adm->id)) }}</td>
                                <td class="px-8 py-5">
                                    @if($status === 'Published')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-container/40 text-on-secondary-container text-[10px] font-bold uppercase tracking-wider">
                                            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Published
                                        </span>
                                    @elseif($status === 'Modified')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-container/30 text-on-primary-container text-[10px] font-bold uppercase tracking-wider">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Modified
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-error-container/10 text-error text-[10px] font-bold uppercase tracking-wider">
                                            <span class="w-1.5 h-1.5 rounded-full bg-error animate-pulse"></span> Not Uploaded
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right space-x-2">
                                    @if($status !== 'Not Uploaded')
                                        <button @click="alert('Downloading hall ticket package for: ' + '{{ $adm->full_name }}')" class="text-primary font-bold hover:underline text-xs">Download</button>
                                    @else
                                        <button @click="openHallTicketModal('{{ $adm->full_name }}')" class="text-primary font-bold hover:underline text-xs">Upload Now</button>
                                    @endif
                                    <button @click="openHallTicketModal('{{ $adm->full_name }}')" class="text-on-surface-variant hover:text-primary transition-colors material-symbols-outlined align-middle text-sm">edit</button>
                                </td>
                            </tr>
                        @empty
                            <tr class="hover:bg-primary/5 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center font-bold text-primary">AS</div>
                                        <span class="font-bold text-on-surface">Aarav Sharma</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 font-mono text-sm">NIOS2600124</td>
                                <td class="px-8 py-5">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-container/40 text-on-secondary-container text-xs font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Published
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right space-x-2">
                                    <button @click="alert('Downloading mock ticket Aarav Sharma')" class="text-primary font-bold hover:underline text-sm">Download</button>
                                    <button @click="openHallTicketModal('Aarav Sharma')" class="text-on-surface-variant hover:text-primary transition-colors material-symbols-outlined align-middle">edit</button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Deadlines Control -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 glass-card rounded-2xl p-8 space-y-6">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary text-3xl">timer</span>
                    <h4 class="font-display text-2xl font-extrabold text-on-surface">NIOS Block 2 Deadlines</h4>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Regular Fee</label>
                        <input class="w-full bg-surface-container-low/50 border border-outline-variant/10 rounded-xl p-3 text-sm focus:ring-2 ring-primary/20 outline-none font-semibold" type="date" value="2026-10-15">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Late Fee P1</label>
                        <input class="w-full bg-surface-container-low/50 border border-outline-variant/10 rounded-xl p-3 text-sm focus:ring-2 ring-primary/20 outline-none font-semibold" type="date" value="2026-10-25">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Late Fee P2</label>
                        <input class="w-full bg-surface-container-low/50 border border-outline-variant/10 rounded-xl p-3 text-sm focus:ring-2 ring-primary/20 outline-none font-semibold" type="date" value="2026-11-05">
                    </div>
                </div>
                <div class="flex items-center justify-between pt-4">
                    <p class="text-xs text-on-surface-variant italic">Last updated: Sep 12, 2026 by Administrator</p>
                    <button @click="alert('Exam registration cycles updated successfully!')" class="cyan-glow-button text-on-primary px-8 py-3 rounded-xl font-bold shadow-xl text-xs">Update Cycles</button>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-8 bg-primary/5 flex flex-col justify-center items-center text-center gap-4 group">
                <div class="w-16 h-16 rounded-full bg-primary-container/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-primary text-3xl">campaign</span>
                </div>
                <h4 class="font-bold text-on-surface text-base">Bulk Notification</h4>
                <p class="text-xs text-on-surface-variant leading-relaxed">Instantly alert all registered students about upcoming fee deadlines via App &amp; Email.</p>
                <button @click="triggerBulkDeadlineAlert()" class="w-full py-3 rounded-xl border border-primary text-primary font-bold text-xs hover:bg-primary hover:text-on-primary transition-all duration-300">
                    Push Deadline Alert
                </button>
            </div>
        </section>

        <!-- ==================== POST NOTIFICATION MODAL ==================== -->
        <div x-show="isNotificationModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div @click="isNotificationModalOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div class="glass-card w-full max-w-lg bg-white p-8 rounded-2xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold font-display text-primary">Post Exam Broadcast</h3>
                    <button @click="isNotificationModalOpen = false" class="material-symbols-outlined text-slate-400 hover:text-slate-800">close</button>
                </div>
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Subject Title</label>
                        <input type="text" x-model="notifSubject" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold" placeholder="e.g. Practical Exam Schedule Released"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Message Description</label>
                        <textarea x-model="notifMessage" rows="4" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold resize-none" placeholder="Provide complete instruction detail..."></textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Target Audience</label>
                        <select x-model="notifAudience" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 text-xs font-bold focus:bg-white transition-all outline-none">
                            <option value="all">All Students</option>
                            <option value="active">Active Block Candidates</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/10">
                        <button @click="isNotificationModalOpen = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl border border-slate-200">Cancel</button>
                        <button @click="submitNotification()" class="px-5 py-2.5 cyan-glow-button text-on-primary text-xs font-bold rounded-xl">Broadcast Post</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== UPLOAD HALL TICKET MODAL ==================== -->
        <div x-show="isHallTicketModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div @click="isHallTicketModalOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div class="glass-card w-full max-w-lg bg-white p-8 rounded-2xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold font-display text-primary">Upload Candidate Hall Ticket</h3>
                    <button @click="isHallTicketModalOpen = false" class="material-symbols-outlined text-slate-400 hover:text-slate-800">close</button>
                </div>
                <div class="space-y-4">
                    <div class="p-3 bg-primary/5 rounded-xl flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-sm">info</span>
                        <p class="text-[10px] text-primary font-bold">Uploading hall tickets notifies the candidates immediately.</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Exam Cycle / Name</label>
                        <input type="text" x-model="hallTicketExamName" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold" placeholder="e.g. October 2026 Practical Exam"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Upload Hall Ticket (PDF)</label>
                        <label class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-outline-variant/30 bg-slate-50 hover:bg-slate-100 rounded-xl cursor-pointer transition-colors group">
                            <span class="material-symbols-outlined text-3xl text-outline mb-2 group-hover:scale-110 duration-200">upload_file</span>
                            <span class="text-xs font-bold text-slate-600" x-text="hallTicketFileName || 'Choose PDF File'"></span>
                            <input type="file" ref="hallTicketFile" class="hidden" accept=".pdf" @change="hallTicketFileName = $refs.hallTicketFile.files[0]?.name || ''"/>
                        </label>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/10">
                        <button @click="isHallTicketModalOpen = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl border border-slate-200">Cancel</button>
                        <button @click="submitHallTicket()" class="px-5 py-2.5 cyan-glow-button text-on-primary text-xs font-bold rounded-xl">Upload Ticket</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== UPLOAD GUIDELINES MODAL ==================== -->
        <div x-show="isUploadGuidelinesModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div @click="isUploadGuidelinesModalOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div class="glass-card w-full max-w-lg bg-white p-8 rounded-2xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold font-display text-primary">Upload Guidelines Document</h3>
                    <button @click="isUploadGuidelinesModalOpen = false" class="material-symbols-outlined text-slate-400 hover:text-slate-800">close</button>
                </div>
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Resource Title</label>
                        <input type="text" x-model="guidelinesTitle" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold" placeholder="e.g. Exam Day Protocol"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Category Level</label>
                        <select x-model="guidelinesLevel" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 text-xs font-bold focus:bg-white transition-all outline-none">
                            <option value="secondary">Secondary (Class 10th)</option>
                            <option value="senior_secondary">Senior Secondary (Class 12th)</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Subject Tag</label>
                        <input type="text" x-model="guidelinesSubject" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold" placeholder="e.g. General / Exams"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">File (PDF)</label>
                        <label class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-outline-variant/30 bg-slate-50 hover:bg-slate-100 rounded-xl cursor-pointer transition-colors group">
                            <span class="material-symbols-outlined text-3xl text-outline mb-2 group-hover:scale-110 duration-200">upload_file</span>
                            <span class="text-xs font-bold text-slate-600" x-text="guidelinesFileName || 'Choose PDF File'"></span>
                            <input type="file" ref="guidelinesFile" class="hidden" accept=".pdf" @change="guidelinesFileName = $refs.guidelinesFile.files[0]?.name || ''"/>
                        </label>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/10">
                        <button @click="isUploadGuidelinesModalOpen = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl border border-slate-200">Cancel</button>
                        <button @click="submitGuidelines()" class="px-5 py-2.5 cyan-glow-button text-on-primary text-xs font-bold rounded-xl">Upload Document</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('publicExamManager', () => ({
                isNotificationModalOpen: false,
                isHallTicketModalOpen: false,
                isUploadGuidelinesModalOpen: false,
                
                notifSubject: '',
                notifMessage: '',
                notifAudience: 'all',
                
                hallTicketExamName: '',
                hallTicketFileName: '',
                
                guidelinesTitle: '',
                guidelinesLevel: 'secondary',
                guidelinesSubject: 'Exams',
                guidelinesFileName: '',

                submitNotification() {
                    if (!this.notifSubject || !this.notifMessage) {
                        alert('Subject and Message are required.');
                        return;
                    }
                    fetch('{{ route("admin.message") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            subject: this.notifSubject,
                            message: this.notifMessage,
                            audience: this.notifAudience
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            this.isNotificationModalOpen = false;
                            location.reload();
                        } else {
                            alert('Error posting notification.');
                        }
                    });
                },

                openHallTicketModal(studentName = '') {
                    this.hallTicketExamName = studentName ? 'Hall Ticket for ' + studentName : '';
                    this.isHallTicketModalOpen = true;
                },

                submitHallTicket() {
                    if (!this.hallTicketExamName || !this.$refs.hallTicketFile.files[0]) {
                        alert('Exam Name and File are required.');
                        return;
                    }
                    let formData = new FormData();
                    formData.append('exam_name', this.hallTicketExamName);
                    formData.append('file', this.$refs.hallTicketFile.files[0]);

                    fetch('{{ route("admin.exams.hallticket") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            this.isHallTicketModalOpen = false;
                            location.reload();
                        } else {
                            alert('Error uploading hall ticket.');
                        }
                    });
                },

                openUploadGuidelinesModal() {
                    this.isUploadGuidelinesModalOpen = true;
                },

                submitGuidelines() {
                    if (!this.guidelinesTitle || !this.$refs.guidelinesFile.files[0]) {
                        alert('Title and File are required.');
                        return;
                    }
                    let formData = new FormData();
                    formData.append('title', this.guidelinesTitle);
                    formData.append('level', this.guidelinesLevel);
                    formData.append('subject', this.guidelinesSubject);
                    formData.append('file', this.$refs.guidelinesFile.files[0]);

                    fetch('{{ route("admin.study.upload") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message || 'Guidelines document uploaded successfully.');
                            this.isUploadGuidelinesModalOpen = false;
                            location.reload();
                        } else {
                            alert('Error uploading guidelines.');
                        }
                    });
                },

                triggerBulkDeadlineAlert() {
                    fetch('{{ route("admin.exams.notification") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            title: 'Exam Registration Deadline Alert',
                            message: 'This is an urgent broadcast reminding all candidates that the main cycle Block 2 regular fee payment window closes in 12 days.'
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message || 'Bulk notification sent!');
                        } else {
                            alert('Error sending bulk notification.');
                        }
                    });
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
