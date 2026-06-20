<x-admin-layout>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(32px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 40px 60px rgba(42, 48, 49, 0.04);
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
        .cyan-glow {
            box-shadow: 0 0 20px rgba(64, 206, 243, 0.15);
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

    <div x-data="pcpManager" class="w-full space-y-8 pb-20">
        <!-- Header & Introduction -->
        <section class="flex flex-col gap-2">
            <p class="text-primary font-bold tracking-[0.2em] text-xs uppercase">Administrative Portal</p>
            <h3 class="font-display text-4xl font-extrabold text-on-surface tracking-tighter">Personal Contact Program (PCP) Management</h3>
        </section>

        <!-- KPI Bento Grid -->
        <section class="grid grid-cols-1 md:grid-cols-12 gap-6">
            <div class="col-span-12 md:col-span-4 glass-card p-8 rounded-[2rem] relative overflow-hidden group hover:scale-[1.01] transition-all duration-300">
                <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-6xl text-primary">apartment</span>
                </div>
                <p class="text-xs uppercase tracking-widest text-on-surface-variant font-bold mb-2">Total Centers</p>
                <h3 class="text-5xl font-bold text-primary">42</h3>
                <p class="text-xs text-on-surface-variant/60 mt-4 flex items-center">
                    <span class="material-symbols-outlined text-sm text-green-500 mr-1">trending_up</span>
                    +3 new venues added this month
                </p>
            </div>

            <div class="col-span-12 md:col-span-5 glass-card p-8 rounded-[2rem] relative overflow-hidden group hover:scale-[1.01] transition-all duration-300">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-on-surface-variant font-bold mb-1">Hall Tickets Status</p>
                        @php
                            $totalAdmissions = $admissions->count();
                            $uploadedCount = round($totalAdmissions * 0.85);
                        @endphp
                        <h3 class="text-4xl font-bold text-on-surface">85% <span class="text-lg font-medium text-on-surface-variant">Uploaded</span></h3>
                    </div>
                    <div class="w-16 h-16 rounded-full border-4 border-primary-container/30 flex items-center justify-center relative">
                        <svg class="w-full h-full transform -rotate-90">
                            <circle class="text-primary" cx="32" cy="32" fill="transparent" r="28" stroke="currentColor" stroke-dasharray="176" stroke-dashoffset="26.4" stroke-width="4"></circle>
                        </svg>
                        <span class="absolute text-xs font-bold text-primary">85%</span>
                    </div>
                </div>
                <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-primary to-primary-container w-[85%]"></div>
                </div>
                <p class="text-xs text-on-surface-variant/60 mt-4">
                    {{ $totalAdmissions > 0 ? $uploadedCount : '1,402' }} of {{ $totalAdmissions > 0 ? $totalAdmissions : '1,650' }} student tickets ready
                </p>
            </div>

            <div class="col-span-12 md:col-span-3 glass-card p-8 rounded-[2rem] bg-primary text-on-primary shadow-xl cyan-glow hover:scale-[1.01] transition-all duration-300">
                <p class="text-xs uppercase tracking-widest opacity-70 font-bold mb-2">Upcoming Sessions</p>
                <h3 class="text-5xl font-bold mb-4">12</h3>
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2 text-xs bg-white/10 p-2 rounded-lg">
                        <span class="material-symbols-outlined text-sm">calendar_today</span>
                        <span>Batch A starts in 48h</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs bg-white/10 p-2 rounded-lg">
                        <span class="material-symbols-outlined text-sm">location_on</span>
                        <span>8 Centers Active</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Core Management Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Panel (Guideline Uploader & Session Registry) -->
            <div class="col-span-12 lg:col-span-7 flex flex-col gap-8">
                <!-- Guideline Upload Card (Resolving the commented 'Hall Ticket Upload Center' placeholder) -->
                <section class="glass-card p-6 rounded-[2rem] border border-outline-variant/10">
                    <h4 class="text-xl font-bold tracking-tight text-on-surface mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-2xl">upload_file</span>
                        Upload PCP Guidelines & Schedules
                    </h4>
                    <p class="text-xs text-on-surface-variant/70 mb-5 leading-relaxed">
                        Distribute program structures, session guidelines, or center maps instantly to all registered students.
                    </p>

                    <!-- Drag and Drop Area -->
                    <div @click="openUploadGuidelinesModal()" class="border-dashed border-2 border-primary/20 hover:border-primary/50 bg-primary/5 hover:bg-primary/10 rounded-2xl p-8 flex flex-col items-center justify-center text-center cursor-pointer transition-all duration-300 group">
                        <span class="material-symbols-outlined text-4xl text-primary transition-transform group-hover:scale-110 mb-2">cloud_upload</span>
                        <p class="text-sm font-bold text-on-surface">Drag & Drop Guidelines File here</p>
                        <p class="text-[10px] text-on-surface-variant/60 mt-1">Or click to browse from device (PDF up to 10MB)</p>
                    </div>
                </section>

                <!-- Session Schedule Registry -->
                <section class="glass-card rounded-[2.5rem] overflow-hidden border border-outline-variant/10">
                    <div class="p-8 pb-4 flex justify-between items-center">
                        <h4 class="text-2xl font-bold tracking-tight">Session Schedule Registry</h4>
                        <div class="flex gap-2">
                            <button @click="alert('Filtered sessions')" class="p-2 rounded-lg bg-surface-container-high hover:bg-surface-container-highest transition-colors">
                                <span class="material-symbols-outlined text-xl">filter_list</span>
                            </button>
                            <button @click="alert('Downloaded sessions registry')" class="p-2 rounded-lg bg-surface-container-high hover:bg-surface-container-highest transition-colors">
                                <span class="material-symbols-outlined text-xl">download</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-xs uppercase tracking-wider text-on-surface-variant/60 bg-surface-container-low/50 border-b border-outline-variant/10">
                                    <th class="px-8 py-4 font-bold">Student Info</th>
                                    <th class="px-6 py-4 font-bold">Subject</th>
                                    <th class="px-6 py-4 font-bold">Venue/Date</th>
                                    <th class="px-6 py-4 font-bold">Ticket Status</th>
                                    <th class="px-8 py-4 font-bold">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                @forelse($admissions as $adm)
                                    @php
                                        $isClass12 = ($adm->course_type === '12th' || $adm->course_type === 'Senior Secondary');
                                        $subject = $isClass12 ? 'Physics (XII)' : 'Science (X)';
                                        $venue = ($adm->id % 2 === 0) ? 'Apex Center, Delhi' : 'Zonal Hub, Kochi';
                                        $date = 'Nov ' . (10 + ($adm->id % 15)) . ', 2026 • 10:00 AM';
                                        $status = ($adm->id % 3 === 0) ? 'UPLOADED' : 'PENDING';
                                    @endphp
                                    <tr class="hover:bg-white/40 transition-colors">
                                        <td class="px-8 py-5">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-on-surface text-sm">{{ $adm->full_name }}</span>
                                                <span class="text-xs text-on-surface-variant/60">ID: {{ $adm->user->enrollment_number ?? ('BS-2026-' . sprintf('%03d', $adm->id)) }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="px-3 py-1 bg-secondary-container/30 text-on-secondary-container text-xs rounded-full font-medium">{{ $subject }}</span>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex flex-col text-xs">
                                                <span class="font-medium">{{ $venue }}</span>
                                                <span class="text-on-surface-variant/60 text-[10px]">{{ $date }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            @if($status === 'UPLOADED')
                                                <div class="flex items-center gap-1.5 text-xs text-green-600 font-bold">
                                                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                                    <span>UPLOADED</span>
                                                </div>
                                            @else
                                                <div class="flex items-center gap-1.5 text-xs text-amber-600 font-bold">
                                                    <span class="material-symbols-outlined text-sm">hourglass_empty</span>
                                                    <span>PENDING</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-8 py-5">
                                            @if($status === 'UPLOADED')
                                                <button @click="alert('Viewing hall ticket for: ' + '{{ $adm->full_name }}')" class="text-primary hover:underline text-xs font-bold">View</button>
                                            @else
                                                <button @click="openHallTicketModal('{{ $adm->full_name }}')" class="text-primary hover:underline text-xs font-bold">Upload</button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="hover:bg-white/40 transition-colors">
                                        <td class="px-8 py-5">
                                            <div class="flex flex-col">
                                                <span class="font-bold">Aarav Sharma</span>
                                                <span class="text-xs text-on-surface-variant">ID: BS-2026-001</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="px-3 py-1 bg-secondary-container/30 text-on-secondary-container text-xs rounded-full font-medium">Physics (XII)</span>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex flex-col text-xs">
                                                <span class="font-medium">Apex Center, Delhi</span>
                                                <span class="text-on-surface-variant">Nov 12, 2026 • 10:00 AM</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-1.5 text-xs text-green-600 font-bold">
                                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                                <span>UPLOADED</span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5">
                                            <button @click="alert('Viewing hall ticket')" class="text-primary hover:underline text-xs font-bold">View</button>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            <!-- Right Panel (Notification Engine Sidebar) -->
            <div class="col-span-12 lg:col-span-5">
                <section class="glass-card p-8 rounded-[2.5rem] space-y-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-2xl">send_and_archive</span>
                        </div>
                        <h4 class="text-2xl font-bold tracking-tight">Send PCP Notifications</h4>
                    </div>

                    <div class="space-y-5">
                        <div class="space-y-1">
                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Notification Subject</label>
                            <input type="text" x-model="notifSubject" class="w-full bg-surface-container-low/50 border-0 rounded-2xl p-4 text-xs font-semibold focus:ring-2 focus:ring-primary/20 outline-none" placeholder="e.g., PCP Schedule Released - Batch Nov">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Target Audience</label>
                            <div class="grid grid-cols-2 gap-3">
                                <button @click="notifAudience = 'all'" :class="notifAudience === 'all' ? 'bg-primary text-on-primary border-primary' : 'bg-transparent text-on-surface-variant border-outline-variant/30'" class="px-4 py-3 rounded-xl border text-xs font-bold flex items-center justify-center gap-2 transition-all duration-300">
                                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">groups</span>
                                    All Registered
                                </button>
                                <button @click="notifAudience = 'active'" :class="notifAudience === 'active' ? 'bg-primary text-on-primary border-primary' : 'bg-transparent text-on-surface-variant border-outline-variant/30'" class="px-4 py-3 rounded-xl border text-xs font-bold flex items-center justify-center gap-2 transition-all duration-300">
                                    <span class="material-symbols-outlined text-sm">pin_drop</span>
                                    Active Students
                                </button>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Delivery Channels</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center group-hover:bg-primary-container/20 transition-colors">
                                        <span class="material-symbols-outlined text-sm">smartphone</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold">App Push</span>
                                        <span class="text-[9px] text-on-surface-variant/60">Real-time</span>
                                    </div>
                                    <input type="checkbox" checked class="rounded border-outline-variant/30 text-primary focus:ring-primary/20">
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center group-hover:bg-primary-container/20 transition-colors">
                                        <span class="material-symbols-outlined text-sm">mail</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold">Email</span>
                                        <span class="text-[9px] text-on-surface-variant/60">Official</span>
                                    </div>
                                    <input type="checkbox" checked class="rounded border-outline-variant/30 text-primary focus:ring-primary/20">
                                </label>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Message Content</label>
                            <textarea x-model="notifMessage" class="w-full bg-surface-container-low/50 border-0 rounded-3xl p-5 text-xs font-semibold focus:ring-2 focus:ring-primary/20 resize-none outline-none" placeholder="Draft your message here..." rows="4"></textarea>
                        </div>

                        <button @click="submitNotification()" class="w-full py-4 bg-gradient-to-r from-primary to-primary-dim text-on-primary rounded-[2rem] font-bold text-base shadow-xl hover:scale-[1.01] active:scale-95 transition-all flex items-center justify-center gap-3">
                            Broadcast Update
                            <span class="material-symbols-outlined">rocket_launch</span>
                        </button>
                    </div>

                    <div class="mt-10 pt-8 border-t border-outline-variant/10">
                        <h5 class="text-xs font-bold uppercase tracking-widest text-on-surface-variant/60 mb-4">Recent Notifications</h5>
                        <div class="space-y-4 max-h-[250px] overflow-y-auto custom-scrollbar">
                            @forelse($notifications->take(5) as $notif)
                                <div class="flex items-start gap-3">
                                    <div class="w-2 h-2 rounded-full bg-primary mt-1.5 shrink-0"></div>
                                    <div>
                                        <p class="text-xs font-bold text-on-surface">{{ $notif->subject }}</p>
                                        <p class="text-[10px] text-on-surface-variant/70 leading-relaxed">{{ Str::limit($notif->message, 120) }}</p>
                                        <p class="text-[9px] text-on-surface-variant/50 mt-0.5">{{ $notif->created_at->diffForHumans() }} • Audience: {{ $notif->audience }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="flex items-start gap-3">
                                    <div class="w-1.5 h-1.5 rounded-full bg-primary mt-1.5"></div>
                                    <div>
                                        <p class="text-xs font-bold">Venue Change: Delhi Sector 12</p>
                                        <p class="text-[10px] text-on-surface-variant/70">Sent 2 hours ago • 450 recipients</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-1.5 h-1.5 rounded-full bg-outline-variant mt-1.5"></div>
                                    <div>
                                        <p class="text-xs font-bold">Hall Tickets Live for Batch B</p>
                                        <p class="text-[10px] text-on-surface-variant/70">Sent yesterday • 1,200 recipients</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- ==================== SCHEDULE PCP SESSION MODAL ==================== -->
        <div x-show="isScheduleModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div @click="isScheduleModalOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div class="glass-card w-full max-w-lg bg-white p-8 rounded-2xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold font-display text-primary">Schedule New PCP Session</h3>
                    <button @click="isScheduleModalOpen = false" class="material-symbols-outlined text-slate-400 hover:text-slate-800">close</button>
                </div>
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Session Title</label>
                        <input type="text" x-model="scheduleTitle" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold" placeholder="e.g. Class 12 Chemistry Lab Day 1"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Date & Time</label>
                        <input type="datetime-local" x-model="scheduleDate" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Study Center / Venue</label>
                        <input type="text" x-model="scheduleVenue" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold" placeholder="e.g. Apex Center, New Delhi"/>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/10">
                        <button @click="isScheduleModalOpen = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl border border-slate-200">Cancel</button>
                        <button @click="submitSchedule()" class="px-5 py-2.5 cyan-glow-button text-on-primary text-xs font-bold rounded-xl">Schedule Session</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== UPLOAD HALL TICKET MODAL ==================== -->
        <div x-show="isHallTicketModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div @click="isHallTicketModalOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div class="glass-card w-full max-w-lg bg-white p-8 rounded-2xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold font-display text-primary">Upload PCP Hall Ticket</h3>
                    <button @click="isHallTicketModalOpen = false" class="material-symbols-outlined text-slate-400 hover:text-slate-800">close</button>
                </div>
                <div class="space-y-4">
                    <div class="p-3 bg-primary/5 rounded-xl flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-sm">info</span>
                        <p class="text-[10px] text-primary font-bold">Uploading hall tickets notifies the candidate immediately.</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Candidate / Exam Session</label>
                        <input type="text" x-model="hallTicketExamName" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold" placeholder="e.g. PCP Hall Ticket for Aarav Sharma"/>
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
                        <input type="text" x-model="guidelinesTitle" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold" placeholder="e.g. PCP Attendance Protocol"/>
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
                        <input type="text" x-model="guidelinesSubject" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold" placeholder="e.g. PCP / General"/>
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

        <!-- Floating Action Button -->
        <div class="fixed bottom-10 right-10 z-[60]">
            <button @click="isScheduleModalOpen = true" class="w-16 h-16 rounded-full bg-primary text-on-primary shadow-2xl cyan-glow flex items-center justify-center hover:scale-110 active:scale-95 transition-all group overflow-hidden">
                <span class="material-symbols-outlined text-3xl group-hover:rotate-90 transition-transform">add</span>
                <span class="absolute right-full mr-4 bg-inverse-surface text-on-surface px-4 py-2 rounded-xl text-xs font-bold opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Schedule New Session</span>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('pcpManager', () => ({
                isNotificationModalOpen: false,
                isHallTicketModalOpen: false,
                isUploadGuidelinesModalOpen: false,
                isScheduleModalOpen: false,

                notifSubject: '',
                notifMessage: '',
                notifAudience: 'all',

                hallTicketExamName: '',
                hallTicketFileName: '',

                guidelinesTitle: '',
                guidelinesLevel: 'secondary',
                guidelinesSubject: 'PCP',
                guidelinesFileName: '',

                scheduleTitle: '',
                scheduleDate: '',
                scheduleVenue: '',

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
                    this.hallTicketExamName = studentName ? 'PCP Hall Ticket for ' + studentName : '';
                    this.isHallTicketModalOpen = true;
                },

                submitHallTicket() {
                    if (!this.hallTicketExamName || !this.$refs.hallTicketFile.files[0]) {
                        alert('Exam Session Name and File are required.');
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
                            alert(data.message || 'Hall ticket uploaded successfully.');
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

                submitSchedule() {
                    if (!this.scheduleTitle || !this.scheduleDate || !this.scheduleVenue) {
                        alert('Session Title, Date, and Study Center/Venue are required.');
                        return;
                    }
                    fetch('{{ route("admin.pcp.schedule") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            title: this.scheduleTitle,
                            date: this.scheduleDate,
                            study_center: this.scheduleVenue
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message || 'PCP session scheduled successfully.');
                            this.isScheduleModalOpen = false;
                            location.reload();
                        } else {
                            alert('Error scheduling session.');
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
