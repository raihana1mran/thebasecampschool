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
            box-shadow: 0 4px 20px rgba(64, 206, 243, 0.25);
            color: #e0f6ff;
        }
        .cyan-glow-button:hover {
            opacity: 0.92;
            transform: scale(1.02);
        }
        .active-tab-glow {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
        }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 100, 121, 0.1);
            border-radius: 10px;
        }
        .channel-card input:checked ~ div {
            border-color: #006479;
            background-color: rgba(0, 100, 121, 0.05);
        }
        [x-cloak] { display: none !important; }
    </style>

    <!-- Atmospheric Background Blobs -->
    <div class="fixed top-[-10%] right-[-5%] w-[40vw] h-[40vw] bg-primary-container/10 rounded-full blur-[120px] pointer-events-none -z-10"></div>
    <div class="fixed bottom-[-5%] left-[-5%] w-[30vw] h-[30vw] bg-secondary-container/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>

    <div x-data="notifCenter" class="w-full space-y-8 pb-20">

        <!-- Header -->
        <header class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-2">
            <div>
                <p class="text-primary font-bold tracking-[0.2em] text-xs uppercase">Administrative Portal</p>
                <h3 class="font-display text-4xl font-extrabold text-on-surface tracking-tighter mt-1">Notification Center</h3>
                <p class="text-on-surface-variant text-sm mt-1 font-medium">Unified communications and broadcast command center.</p>
            </div>
            <div class="flex gap-3">
                <button @click="showInsightsModal = true" class="bg-surface-container-lowest/50 backdrop-blur-lg border border-outline-variant/20 px-5 py-2.5 rounded-full font-semibold text-sm flex items-center gap-2 hover:bg-surface-container-high transition-all">
                    <span class="material-symbols-outlined text-primary text-[20px]">analytics</span>
                    View Insights
                </button>
            </div>
        </header>

        <!-- KPI Row -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            <div class="glass-card p-5 rounded-2xl flex flex-col gap-3 relative overflow-hidden group hover:-translate-y-1 transition-all duration-500">
                <div class="absolute top-0 right-0 w-20 h-20 bg-primary/5 rounded-full -mr-6 -mt-6 group-hover:scale-125 transition-transform duration-700"></div>
                <span class="material-symbols-outlined text-primary p-2 rounded-lg bg-primary-container/20 w-fit">send</span>
                <div>
                    <p class="text-2xl font-bold tracking-tight">{{ number_format($totalSent) }}</p>
                    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant/70 font-semibold mt-0.5">Total Sent</p>
                </div>
            </div>
            <div class="glass-card p-5 rounded-2xl flex flex-col gap-3 relative overflow-hidden group hover:-translate-y-1 transition-all duration-500">
                <span class="material-symbols-outlined text-secondary p-2 rounded-lg bg-secondary-container/20 w-fit">done_all</span>
                <div>
                    <p class="text-2xl font-bold tracking-tight">{{ $deliveryRate }}%</p>
                    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant/70 font-semibold mt-0.5">Delivery Rate</p>
                </div>
            </div>
            <div class="glass-card p-5 rounded-2xl flex flex-col gap-3 relative overflow-hidden group hover:-translate-y-1 transition-all duration-500">
                <span class="material-symbols-outlined text-primary p-2 rounded-lg bg-primary-container/20 w-fit">groups</span>
                <div>
                    <p class="text-2xl font-bold tracking-tight">{{ number_format($totalStudents) }}</p>
                    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant/70 font-semibold mt-0.5">Active Recipients</p>
                </div>
            </div>
            <div class="glass-card p-5 rounded-2xl flex flex-col gap-3 relative overflow-hidden group hover:-translate-y-1 transition-all duration-500">
                <span class="material-symbols-outlined text-primary p-2 rounded-lg bg-primary-container/20 w-fit">schedule</span>
                <div>
                    <p class="text-2xl font-bold tracking-tight">{{ $scheduledCount }}</p>
                    <p class="text-[10px] uppercase tracking-widest text-on-surface-variant/70 font-semibold mt-0.5">Scheduled</p>
                </div>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-12 gap-8">

            <!-- LEFT: Broadcast Engine -->
            <section class="col-span-12 lg:col-span-8 space-y-8">

                <!-- Broadcast Engine Card -->
                <div class="glass-card rounded-[2rem] p-8">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-primary text-2xl" style="font-variation-settings: 'FILL' 1;">campaign</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-on-surface">Broadcast Engine</h3>
                            <p class="text-xs text-on-surface-variant/60 mt-0.5">Compose and send notifications to your student audience.</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Channel Selector -->
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mb-3 block">Select Channels</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                @foreach([
                                    ['key' => 'sms', 'icon' => 'sms', 'label' => 'SMS'],
                                    ['key' => 'whatsapp', 'icon' => 'chat_bubble', 'label' => 'WhatsApp'],
                                    ['key' => 'email', 'icon' => 'mail', 'label' => 'Email'],
                                    ['key' => 'portal', 'icon' => 'notifications', 'label' => 'Portal'],
                                ] as $ch)
                                <label class="cursor-pointer group channel-card">
                                    <input x-model="channels" value="{{ $ch['key'] }}" type="checkbox" class="hidden peer" {{ in_array($ch['key'], ['sms','whatsapp','email']) ? 'checked' : '' }}/>
                                    <div class="flex flex-col items-center gap-2 p-4 rounded-2xl border border-outline-variant/20 peer-checked:border-primary peer-checked:bg-primary/5 transition-all group-hover:bg-surface-container-low">
                                        <span class="material-symbols-outlined text-on-surface-variant peer-checked:text-primary transition-colors">{{ $ch['icon'] }}</span>
                                        <span class="text-xs font-bold">{{ $ch['label'] }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Broadcast Type Tabs -->
                        <div class="flex gap-6 mb-6 border-b border-outline-variant/10 pb-3">
                            <button @click="broadcastType = 'text'" :class="broadcastType === 'text' ? 'text-primary border-b-2 border-primary font-bold' : 'text-on-surface-variant font-medium hover:text-primary'" class="pb-2 text-sm transition-all flex items-center gap-1.5 relative top-[13px]">
                                <span class="material-symbols-outlined text-[18px]">edit_document</span> Text Broadcast
                            </button>
                            <button @click="broadcastType = 'audio'" :class="broadcastType === 'audio' ? 'text-primary border-b-2 border-primary font-bold' : 'text-on-surface-variant font-medium hover:text-primary'" class="pb-2 text-sm transition-all flex items-center gap-1.5 relative top-[13px]">
                                <span class="material-symbols-outlined text-[18px]">graphic_eq</span> Audio Broadcast
                            </button>
                        </div>

                        <!-- Subject + Body (Text Mode) -->
                        <div x-show="broadcastType === 'text'" class="space-y-4">
                            <div>
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mb-2 block">Notification Subject</label>
                                <input x-model="subject" type="text" class="w-full bg-surface-container-low/50 border border-outline-variant/20 focus:ring-2 focus:ring-primary/30 rounded-xl px-5 py-3.5 text-sm outline-none font-semibold transition-all" placeholder="e.g., Important Update: Final Exam Schedule"/>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mb-2 block">Message Body</label>
                                <textarea x-model="body" class="w-full bg-surface-container-low/50 border border-outline-variant/20 focus:ring-2 focus:ring-primary/30 rounded-2xl px-5 py-4 text-sm outline-none font-semibold resize-none transition-all" placeholder="Compose your message here..." rows="5"></textarea>
                                <p class="text-[10px] text-on-surface-variant/50 mt-1.5 text-right" x-text="body.length + ' / 1000 characters'"></p>
                            </div>
                        </div>

                        <!-- Audio Mode -->
                        <div x-show="broadcastType === 'audio'" x-cloak class="space-y-4">
                            <div>
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mb-2 block">Target Language</label>
                                <select x-model="audioLanguage" class="w-full bg-surface-container-low/50 border border-outline-variant/20 focus:ring-2 focus:ring-primary/30 rounded-xl px-5 py-3.5 text-sm outline-none font-semibold transition-all">
                                    <option value="Hindi">Hindi (हिन्दी)</option>
                                    <option value="English">English</option>
                                    <option value="Urdu">Urdu (اردو)</option>
                                    <option value="Bengali">Bengali (বাংলা)</option>
                                    <option value="Telugu">Telugu (తెలుగు)</option>
                                    <option value="Marathi">Marathi (मराठी)</option>
                                    <option value="Tamil">Tamil (தமிழ்)</option>
                                    <option value="Gujarati">Gujarati (ગુજરાતી)</option>
                                    <option value="Kannada">Kannada (ಕನ್ನಡ)</option>
                                    <option value="Malayalam">Malayalam (മലയാളം)</option>
                                    <option value="Odia">Odia (ଓଡ଼ିଆ)</option>
                                    <option value="Punjabi">Punjabi (ਪੰਜਾਬੀ)</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mb-2 block">Upload Audio Message (MP3/WAV)</label>
                                <label class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-outline-variant/30 bg-slate-50 hover:bg-slate-100 rounded-xl cursor-pointer transition-colors group">
                                    <span class="material-symbols-outlined text-3xl text-outline mb-2 group-hover:scale-110 duration-200">audio_file</span>
                                    <span class="text-xs font-bold text-slate-600" x-text="audioFileName || 'Choose Audio File'"></span>
                                    <input type="file" x-ref="audioFile" class="hidden" accept="audio/*" @change="audioFileName = $refs.audioFile.files[0]?.name || ''"/>
                                </label>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70 mb-2 block">Internal Reference Subject</label>
                                <input x-model="subject" type="text" class="w-full bg-surface-container-low/50 border border-outline-variant/20 focus:ring-2 focus:ring-primary/30 rounded-xl px-5 py-3.5 text-sm outline-none font-semibold transition-all" placeholder="e.g., Hindi Audio: Exam Alert"/>
                            </div>
                        </div>

                        <!-- Audience Selector -->
                        <div class="p-5 bg-surface-container-low/30 rounded-2xl border border-outline-variant/10">
                            <div class="flex justify-between items-center mb-4">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/70">Target Audience</label>
                                <span class="text-primary font-bold text-xs" x-text="audienceLabel"></span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <button @click="audience = 'all'" :class="audience === 'all' ? 'border-primary text-primary bg-primary/5 font-bold' : 'border-outline-variant/30 text-on-surface-variant font-medium hover:bg-surface-container-high'" class="px-4 py-2 rounded-full border text-sm transition-all">All Students</button>
                                <button @click="audience = 'active'" :class="audience === 'active' ? 'border-primary text-primary bg-primary/5 font-bold' : 'border-outline-variant/30 text-on-surface-variant font-medium hover:bg-surface-container-high'" class="px-4 py-2 rounded-full border text-sm transition-all">Active Students</button>
                                <button @click="audience = 'block_1'" :class="audience === 'block_1' ? 'border-primary text-primary bg-primary/5 font-bold' : 'border-outline-variant/30 text-on-surface-variant font-medium hover:bg-surface-container-high'" class="px-4 py-2 rounded-full border text-sm transition-all">Block 1 (Apr–Sep)</button>
                                <button @click="audience = 'block_2'" :class="audience === 'block_2' ? 'border-primary text-primary bg-primary/5 font-bold' : 'border-outline-variant/30 text-on-surface-variant font-medium hover:bg-surface-container-high'" class="px-4 py-2 rounded-full border text-sm transition-all">Block 2 (Oct–Mar)</button>
                                <button x-show="broadcastType === 'audio'" @click="audience = 'medium_match'" :class="audience === 'medium_match' ? 'border-primary text-primary bg-primary/5 font-bold' : 'border-outline-variant/30 text-on-surface-variant font-medium hover:bg-surface-container-high'" class="px-4 py-2 rounded-full border text-sm transition-all flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">translate</span> Match Target Language</button>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-2 gap-4 flex-wrap">
                            <button @click="saveDraft()" class="px-6 py-3 rounded-xl font-bold text-sm text-on-surface-variant hover:bg-surface-container-high transition-all border border-outline-variant/20 flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">save</span>
                                Save Draft
                            </button>
                            <button @click="executeBroadcast()" class="cyan-glow-button px-8 py-3 rounded-xl font-bold text-sm flex items-center gap-2 transition-all">
                                <span class="material-symbols-outlined text-lg">send</span>
                                Execute Broadcast
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recent Broadcasts Log -->
                <div class="glass-card rounded-[2rem] p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-on-surface">Recent Activity Log</h3>
                        <button class="text-primary font-bold text-sm hover:underline flex items-center gap-1">
                            <span class="material-symbols-outlined text-lg">download</span>
                            Download Report
                        </button>
                    </div>

                    <div class="space-y-3">
                        @forelse($recentMessages as $msg)
                        <div class="flex items-center gap-5 p-5 rounded-2xl bg-surface-container-lowest hover:bg-surface-container-high/20 transition-all border border-outline-variant/5 group">
                            <div class="w-11 h-11 rounded-full bg-secondary-container/30 flex items-center justify-center text-secondary shrink-0">
                                <span class="material-symbols-outlined text-lg">done_all</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-sm text-on-surface truncate">{{ $msg->subject }}</h4>
                                <div class="flex flex-wrap gap-3 mt-1 text-[11px] text-on-surface-variant/60 font-medium">
                                    <span>Audience: {{ ucfirst($msg->audience) }}</span>
                                    <span>•</span>
                                    <span>{{ $msg->created_at->format('d M, Y h:i A') }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full uppercase">Sent</span>
                                <button @click="deleteBroadcast({{ $msg->id }})" class="p-2 hover:bg-error-container/10 rounded-lg text-error transition-colors" title="Delete Broadcast">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </div>
                        </div>
                        @empty
                        <!-- Placeholder rows -->
                        <div class="flex items-center gap-5 p-5 rounded-2xl bg-surface-container-lowest hover:bg-surface-container-high/20 transition-all border border-outline-variant/5">
                            <div class="w-11 h-11 rounded-full bg-secondary-container/30 flex items-center justify-center text-secondary shrink-0">
                                <span class="material-symbols-outlined text-lg">done_all</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-sm text-on-surface">Final Exam Reminder - Batch 2024</h4>
                                <div class="flex gap-3 mt-1 text-[11px] text-on-surface-variant/60">
                                    <span>2,100 sent</span><span>•</span><span>98.2% delivered</span><span>•</span><span>Oct 12, 10:30 AM</span>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full uppercase shrink-0">Success</span>
                        </div>
                        <div class="flex items-center gap-5 p-5 rounded-2xl bg-surface-container-lowest hover:bg-surface-container-high/20 transition-all border border-outline-variant/5">
                            <div class="w-11 h-11 rounded-full bg-primary-container/30 flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined text-lg">schedule</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-sm text-on-surface">PCP Notification - Group A</h4>
                                <div class="flex gap-3 mt-1 text-[11px] text-on-surface-variant/60">
                                    <span>450 scheduled</span><span>•</span><span>Oct 15, 09:00 AM</span>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-primary/10 text-primary text-[10px] font-bold rounded-full uppercase shrink-0">Scheduled</span>
                        </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <!-- RIGHT: Sidebar Context -->
            <aside class="col-span-12 lg:col-span-4 space-y-8">

                <!-- Template Library -->
                <div class="glass-card rounded-[2rem] p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                        <h3 class="text-lg font-bold">Template Library</h3>
                    </div>
                    <div class="space-y-2">
                        @foreach([
                            ['title' => 'Admission Approved', 'preview' => 'Welcome [student_name] to Basecamp...'],
                            ['title' => 'Payment Received', 'preview' => 'Receipt for [payment_amount] generated...'],
                            ['title' => 'Exam Fee Reminder', 'preview' => 'Deadline for exam fee is approaching...'],
                            ['title' => 'PCP Notification', 'preview' => 'New schedule released for PCP...'],
                            ['title' => 'TMA Deadline', 'preview' => 'Submit your assignments before...'],
                            ['title' => 'Result Published', 'preview' => 'Semester results are now live on portal...'],
                        ] as $tpl)
                        <button @click="applyTemplate('{{ $tpl['title'] }}', '{{ $tpl['preview'] }}')" class="group text-left w-full p-4 rounded-2xl border border-outline-variant/20 hover:border-primary/50 hover:bg-primary/5 transition-all">
                            <div class="flex justify-between items-start mb-1">
                                <span class="font-bold text-sm text-on-surface group-hover:text-primary transition-colors">{{ $tpl['title'] }}</span>
                                <span class="material-symbols-outlined text-[18px] text-on-surface-variant/40">chevron_right</span>
                            </div>
                            <p class="text-xs text-on-surface-variant/60 line-clamp-1">{{ $tpl['preview'] }}</p>
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- Channel Status -->
                <div class="glass-card rounded-[2rem] p-8">
                    <h3 class="text-lg font-bold mb-6">Channel Status</h3>
                    <div class="space-y-5">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                                <span class="font-medium text-sm">SMS Gateway</span>
                            </div>
                            <span class="text-[11px] text-on-surface-variant/60 font-medium">Operational</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                                <span class="font-medium text-sm">WhatsApp API</span>
                            </div>
                            <span class="text-[11px] text-on-surface-variant/60 font-medium">Operational</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                                <span class="font-medium text-sm">Portal Notifications</span>
                            </div>
                            <span class="text-[11px] text-on-surface-variant/60 font-medium">Operational</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-orange-400"></div>
                                <span class="font-medium text-sm">SMTP (Email)</span>
                            </div>
                            <span class="text-[11px] text-orange-500 font-bold">Latency Detected</span>
                        </div>
                    </div>
                </div>

                <!-- Hero Graphic -->
                <div class="relative overflow-hidden rounded-[2rem] h-60 glass-card group">
                    <div class="absolute inset-0 bg-gradient-to-tr from-primary/50 via-primary/20 to-transparent z-10"></div>
                    <div class="absolute inset-0 bg-gradient-to-br from-secondary-container/40 to-primary-container/20"></div>
                    <!-- Decorative circles -->
                    <div class="absolute top-4 right-4 w-32 h-32 bg-primary-container/30 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-4 left-4 w-24 h-24 bg-secondary-container/40 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700"></div>
                    <!-- Floating dots -->
                    <div class="absolute inset-0 z-10 flex items-center justify-center">
                        <div class="grid grid-cols-5 gap-3 opacity-20">
                            @for($i = 0; $i < 25; $i++)
                            <div class="w-1.5 h-1.5 bg-primary rounded-full"></div>
                            @endfor
                        </div>
                    </div>
                    <div class="absolute inset-0 z-20 p-8 flex flex-col justify-end">
                        <span class="material-symbols-outlined text-primary/60 text-5xl mb-2" style="font-variation-settings: 'FILL' 1;">hub</span>
                        <p class="text-xl font-bold text-primary-dim leading-tight">Deliver Clarity,<br/>Instantly.</p>
                        <p class="text-xs text-on-surface-variant/60 mt-1">Real-time broadcast to all channels</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <!-- ==================== BROADCAST CONFIRMATION MODAL ==================== -->
    <div x-data x-show="$store.notif.confirmOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
        <div @click="$store.notif.confirmOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="glass-card w-full max-w-md bg-white p-8 rounded-2xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface">
            <div class="flex flex-col items-center text-center gap-4 mb-6">
                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl text-primary" style="font-variation-settings: 'FILL' 1;">send</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold font-display text-primary">Confirm Broadcast</h3>
                    <p class="text-sm text-on-surface-variant mt-2" x-text="$store.notif.confirmMsg"></p>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/10">
                <button @click="$store.notif.confirmOpen = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl border border-slate-200">Cancel</button>
                <button @click="$store.notif.doSend()" class="px-5 py-2.5 cyan-glow-button text-xs font-bold rounded-xl">Send Now</button>
            </div>
        </div>
    </div>

    <!-- ==================== INSIGHTS MODAL ==================== -->
    <div x-show="$store.notif.insightsOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
        <div @click="$store.notif.insightsOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="glass-card w-full max-w-lg bg-white p-8 rounded-2xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold font-display text-primary">Broadcast Insights</h3>
                <button @click="$store.notif.insightsOpen = false" class="material-symbols-outlined text-slate-400 hover:text-slate-800">close</button>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="p-4 bg-primary/5 rounded-xl">
                    <p class="text-2xl font-bold text-primary">{{ number_format($totalSent) }}</p>
                    <p class="text-xs text-on-surface-variant/70 mt-0.5 font-semibold uppercase tracking-wider">Total Broadcasts</p>
                </div>
                <div class="p-4 bg-green-50 rounded-xl">
                    <p class="text-2xl font-bold text-green-600">{{ $deliveryRate }}%</p>
                    <p class="text-xs text-on-surface-variant/70 mt-0.5 font-semibold uppercase tracking-wider">Avg. Delivery Rate</p>
                </div>
                <div class="p-4 bg-secondary-container/20 rounded-xl">
                    <p class="text-2xl font-bold text-secondary">{{ number_format($totalStudents) }}</p>
                    <p class="text-xs text-on-surface-variant/70 mt-0.5 font-semibold uppercase tracking-wider">Active Recipients</p>
                </div>
                <div class="p-4 bg-surface-container rounded-xl">
                    <p class="text-2xl font-bold">{{ $scheduledCount }}</p>
                    <p class="text-xs text-on-surface-variant/70 mt-0.5 font-semibold uppercase tracking-wider">Scheduled Msgs</p>
                </div>
            </div>
            <div class="text-center pt-4 border-t border-outline-variant/10">
                <p class="text-xs text-on-surface-variant/50">Data refreshed live from broadcast history.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('notif', {
                confirmOpen: false,
                insightsOpen: false,
                confirmMsg: '',
                pendingSend: null,

                doSend() {
                    if (this.pendingSend) this.pendingSend();
                    this.confirmOpen = false;
                }
            });

            Alpine.data('notifCenter', () => ({
                broadcastType: 'text',
                audioLanguage: 'Hindi',
                audioFileName: '',
                channels: ['sms', 'whatsapp', 'email'],
                subject: '',
                body: '',
                audience: 'all',
                showInsightsModal: false,

                get audienceLabel() {
                    const map = {
                        'all': 'All Enrolled Students',
                        'active': 'Active Students Only',
                        'block_1': 'Block 1 Batch (Apr–Sep)',
                        'block_2': 'Block 2 Batch (Oct–Mar)',
                        'medium_match': `Medium: ${this.audioLanguage}`,
                    };
                    return map[this.audience] || this.audience;
                },

                applyTemplate(title, preview) {
                    this.subject = title;
                    this.body = preview.replace('...', ' — please log in to the portal for full details.');
                },

                saveDraft() {
                    if (!this.subject) {
                        alert('Please enter a subject before saving a draft.');
                        return;
                    }
                    alert('Draft saved: "' + this.subject + '"');
                },

                executeBroadcast() {
                    if (this.broadcastType === 'text' && (!this.subject || !this.body)) {
                        alert('Please fill in both Subject and Message before broadcasting text.');
                        return;
                    }
                    if (this.broadcastType === 'audio' && (!this.subject || !this.audioFileName)) {
                        alert('Please fill in the Subject and upload an Audio file before broadcasting audio.');
                        return;
                    }
                    if (this.channels.length === 0) {
                        alert('Please select at least one channel.');
                        return;
                    }
                    const channelList = this.channels.join(', ').toUpperCase();
                    const audioDetails = this.broadcastType === 'audio' ? ` as an Audio Broadcast (${this.audioLanguage})` : '';
                    Alpine.store('notif').confirmMsg = `Send "${this.subject}" to ${this.audienceLabel} via ${channelList}${audioDetails}?`;
                    Alpine.store('notif').pendingSend = () => this.sendNow();
                    Alpine.store('notif').confirmOpen = true;
                },

                sendNow() {
                    let formData = new FormData();
                    formData.append('audience', this.audience);
                    formData.append('subject', this.subject);
                    formData.append('broadcastType', this.broadcastType);
                    
                    if (this.broadcastType === 'text') {
                        formData.append('message', this.body);
                    } else if (this.broadcastType === 'audio') {
                        formData.append('audioLanguage', this.audioLanguage);
                        if (this.$refs.audioFile && this.$refs.audioFile.files[0]) {
                            formData.append('audioFile', this.$refs.audioFile.files[0]);
                        }
                    }

                    fetch('{{ route("admin.message") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Broadcast sent successfully!');
                            this.subject = '';
                            this.body = '';
                            location.reload();
                        } else {
                            alert('Error sending broadcast. Please try again.');
                        }
                    })
                    .catch(() => alert('Network error. Please try again.'));
                },
                deleteBroadcast(id) {
                    if (!confirm('Are you sure you want to delete this broadcast message?')) {
                        return;
                    }
                    fetch('/admin/broadcasts/' + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Broadcast message deleted successfully.');
                            location.reload();
                        } else {
                            alert('Error deleting broadcast: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(() => alert('Network error. Please try again.'));
                }
            }));
        });
    </script>
</x-admin-layout>
