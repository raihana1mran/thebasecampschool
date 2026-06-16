<x-student-layout>
    <!-- Inject Custom CSS and Tailwind configuration for this page -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-tertiary-container": "#003061",
                        "secondary-fixed": "#96e6f6",
                        "on-secondary-container": "#005560",
                        "on-secondary-fixed-variant": "#005f6b",
                        "outline": "#72787a",
                        "secondary-dim": "#005863",
                        "surface-container-high": "#dce4e6",
                        "primary-fixed-dim": "#28c0e4",
                        "error-container": "#fb5151",
                        "primary-dim": "#00576a",
                        "inverse-surface": "#0a0f11",
                        "surface-variant": "#d6dee1",
                        "error-dim": "#9f0519",
                        "on-tertiary": "#eff2ff",
                        "surface-container-low": "#ecf2f4",
                        "tertiary-fixed-dim": "#65a4ff",
                        "on-primary": "#e0f6ff",
                        "on-secondary-fixed": "#004049",
                        "error": "#b31b25",
                        "primary-container": "#40cef3",
                        "tertiary-fixed": "#80b2ff",
                        "primary": "#006479",
                        "on-primary-fixed-variant": "#004a5a",
                        "secondary-fixed-dim": "#88d8e7",
                        "tertiary-dim": "#004f98",
                        "secondary-container": "#96e6f6",
                        "inverse-on-surface": "#989ea0",
                        "inverse-primary": "#40cef3",
                        "on-secondary": "#d8f8ff",
                        "tertiary-container": "#80b2ff",
                        "surface-container": "#e3e9ec",
                        "on-tertiary-fixed-variant": "#003971",
                        "surface-tint": "#006479",
                        "on-primary-container": "#00414f",
                        "on-surface-variant": "#575c5e",
                        "surface": "#f2f7f9",
                        "on-error-container": "#570008",
                        "surface-container-lowest": "#ffffff",
                        "primary-fixed": "#40cef3",
                        "surface-dim": "#cdd6d9",
                        "on-tertiary-fixed": "#001835",
                        "on-surface": "#2a3031",
                        "surface-bright": "#f2f7f9",
                        "outline-variant": "#a8aeb0",
                        "on-error": "#ffefee",
                        "tertiary": "#005bae",
                        "surface-container-highest": "#d6dee1",
                        "secondary": "#006572",
                        "on-background": "#2a3031",
                        "background": "#f2f7f9",
                        "on-primary-fixed": "#002a34"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "1.5rem",
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
            border: 1px solid rgba(168, 174, 176, 0.15);
        }
        .cyan-glow-button {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
            box-shadow: 0 10px 30px -10px rgba(40, 192, 228, 0.4);
        }
        .ghost-border {
            border: 1px solid rgba(168, 174, 176, 0.15);
        }
    </style>

    @php
        // Generate dynamic Unique ID
        $studentId = "BSP-" . ($user->created_at ? $user->created_at->format('Y') : '2026') . "-" . str_pad($user->id, 4, '0', STR_PAD_LEFT);
        
        // Dynamic Stream
        $stream = 'Pending';
        if ($admission) {
            if ($admission->course_type === '10th') {
                $stream = 'Foundation';
            } elseif ($admission->course_type === '12th') {
                $stream = ($user->id % 2 === 0) ? 'Engineering' : 'Medical';
            }
        }
    @endphp

    <div x-data="{
        isPasswordModalOpen: {{ $errors->updatePassword->any() ? 'true' : 'false' }},
        isDeleteModalOpen: {{ $errors->userDeletion->any() ? 'true' : 'false' }},
        showToast: false,
        toastMessage: '',
        courseType: '{{ $admission?->course_type ?? '12th' }}'
    }" class="w-full relative z-10">

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

        @if (session('status') === 'profile-updated')
            <div x-init="toastMessage = 'Profile saved successfully!'; showToast = true; setTimeout(() => showToast = false, 4000)" style="display: none;"></div>
        @endif
        @if (session('status') === 'password-updated')
            <div x-init="toastMessage = 'Password updated successfully!'; showToast = true; setTimeout(() => showToast = false, 4000)" style="display: none;"></div>
        @endif

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-8">
                <div>
                    <h2 class="font-display font-bold text-4xl lg:text-5xl text-on-surface tracking-tight leading-none mb-2">Student Profile</h2>
                    <p class="text-on-surface-variant/60 body-lg">Manage your academic identity and platform preferences.</p>
                </div>
                <div class="flex gap-3 w-full sm:w-auto">
                    <a href="/dashboard" class="px-6 py-3 rounded-xl border border-outline-variant/30 font-bold text-sm bg-white hover:bg-surface-container-high/40 transition-all active:scale-95 text-center flex-1 sm:flex-initial text-on-surface flex items-center justify-center">Discard Changes</a>
                    <button type="submit" class="px-6 py-3 rounded-xl cyan-glow-button text-white font-bold text-sm active:scale-95 transition-transform flex-1 sm:flex-initial flex items-center justify-center">Save Profile</button>
                </div>
            </div>

            <!-- Bento Layout Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left Column: Identity & Personal -->
                <div class="lg:col-span-8 space-y-6">
                    <!-- User Profile Glass Card -->
                    <section class="glass-card rounded-xl p-6 md:p-8 flex flex-col sm:flex-row gap-6 md:gap-8 items-center sm:items-start relative overflow-hidden group">
                        <div class="absolute -right-16 -top-16 w-64 h-64 bg-primary/5 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700"></div>
                        <div class="relative flex-shrink-0">
                            <div class="w-28 h-28 md:w-32 md:h-32 rounded-3xl overflow-hidden shadow-2xl rotate-3 group-hover:rotate-0 transition-transform duration-500">
                                <img alt="{{ $user->name }}" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=006479&color=fff&bold=true&size=128"/>
                            </div>
                        </div>
                        <div class="flex-grow space-y-4 text-center sm:text-left">
                            <div class="space-y-1">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                    <h3 class="text-2xl font-bold text-on-surface">{{ $user->name }}</h3>
                                    <span class="px-3 py-1 rounded-full bg-primary/10 text-primary font-label uppercase tracking-widest text-[10px] w-fit mx-auto sm:mx-0">Active Student</span>
                                </div>
                                <p class="text-on-surface-variant/70 font-medium text-sm">{{ $studentId }} • {{ $admission ? ($admission->course_type === '10th' ? 'Secondary Program' : 'Sr. Secondary Program') : 'Registering' }}</p>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-4 border-t border-outline-variant/10">
                                <div class="space-y-1">
                                    <p class="font-label uppercase text-[9px] tracking-widest text-on-surface-variant/50 font-bold">Stream</p>
                                    <p class="font-bold text-primary text-sm">{{ $stream }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="font-label uppercase text-[9px] tracking-widest text-on-surface-variant/50 font-bold">Batch</p>
                                    <p class="font-bold text-on-surface text-sm">Class of {{ $user->created_at ? $user->created_at->addYears(2)->format('Y') : '2028' }}</p>
                                </div>
                                <div class="hidden sm:block space-y-1">
                                    <p class="font-label uppercase text-[9px] tracking-widest text-on-surface-variant/50 font-bold">Joined</p>
                                    <p class="font-bold text-on-surface text-sm">{{ $user->created_at ? $user->created_at->format('M Y') : 'Jun 2026' }}</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Personal Details Card -->
                    <section class="glass-card rounded-xl p-6 md:p-8 space-y-6">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg">person</span>
                            <h3 class="font-display font-bold text-xl">Personal Details</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <div class="space-y-2">
                                <label class="font-label uppercase text-[10px] tracking-widest text-on-surface-variant/60 px-1 font-bold">Full Name</label>
                                <input class="w-full bg-surface-container-low/50 border border-outline-variant/30 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/50 text-on-surface font-medium transition-all" name="name" type="text" value="{{ old('name', $user->name) }}" required/>
                                <x-input-error class="mt-2 text-xs" :messages="$errors->get('name')" />
                            </div>
                            <div class="space-y-2">
                                <label class="font-label uppercase text-[10px] tracking-widest text-on-surface-variant/60 px-1 font-bold">Email Address</label>
                                <input class="w-full bg-surface-container-low/50 border border-outline-variant/30 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/50 text-on-surface font-medium transition-all" name="email" type="email" value="{{ old('email', $user->email) }}" required/>
                                <x-input-error class="mt-2 text-xs" :messages="$errors->get('email')" />
                            </div>
                            <div class="space-y-2">
                                <label class="font-label uppercase text-[10px] tracking-widest text-on-surface-variant/60 px-1 font-bold">Phone Number</label>
                                <input class="w-full bg-surface-container-low/50 border border-outline-variant/30 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/50 text-on-surface font-medium transition-all" name="phone" type="tel" value="{{ old('phone', $admission?->mobile_number ?? '') }}" placeholder="Enter mobile number"/>
                                <x-input-error class="mt-2 text-xs" :messages="$errors->get('phone')" />
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="font-label uppercase text-[10px] tracking-widest text-on-surface-variant/60 px-1 font-bold">Home Address</label>
                                <textarea class="w-full bg-surface-container-low/50 border border-outline-variant/30 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/50 text-on-surface font-medium transition-all resize-none" name="address" rows="3" placeholder="Enter home address">{{ old('address', $admission?->address ?? '') }}</textarea>
                                <x-input-error class="mt-2 text-xs" :messages="$errors->get('address')" />
                            </div>
                        </div>
                    </section>

                    <!-- Academic Preferences Card -->
                    <section class="glass-card rounded-xl p-6 md:p-8 space-y-6">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg">school</span>
                            <h3 class="font-display font-bold text-xl">Academic Preferences</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <p class="font-label uppercase text-[10px] tracking-widest text-on-surface-variant/60 font-bold px-1">Registered Standard</p>
                                <input type="hidden" name="course_type" x-model="courseType">
                                <div class="flex p-1 bg-surface-container-low/50 rounded-2xl w-full border border-outline-variant/20">
                                    <button type="button" @click="courseType = '10th'" :class="courseType === '10th' ? 'bg-white shadow-md text-primary ring-1 ring-primary/5' : 'text-on-surface-variant/60 hover:text-on-surface'" class="flex-1 py-3 rounded-xl text-sm font-bold transition-all">Class 10th</button>
                                    <button type="button" @click="courseType = '12th'" :class="courseType === '12th' ? 'bg-white shadow-md text-primary ring-1 ring-primary/5' : 'text-on-surface-variant/60 hover:text-on-surface'" class="flex-1 py-3 rounded-xl text-sm font-bold transition-all">Class 12th</button>
                                </div>
                                <p class="text-[10px] text-on-surface-variant/50 px-1 italic">Note: Changing grade levels updates your curriculum track in the portal.</p>
                            </div>
                            <div class="space-y-3">
                                <p class="font-label uppercase text-[10px] tracking-widest text-on-surface-variant/60 font-bold px-1">Career Stream Focus</p>
                                <div class="flex gap-4">
                                    <div class="p-4 rounded-2xl border border-outline-variant/15 bg-surface-container-low/30 flex-1 flex flex-col items-center justify-center text-center">
                                        <span class="material-symbols-outlined text-primary mb-2">medical_services</span>
                                        <p class="font-bold text-sm text-on-surface">Medical</p>
                                        <span class="text-[9px] font-bold text-on-surface-variant/50 uppercase mt-1">PCMB Track</span>
                                    </div>
                                    <div class="p-4 rounded-2xl border border-outline-variant/15 bg-surface-container-low/30 flex-1 flex flex-col items-center justify-center text-center">
                                        <span class="material-symbols-outlined text-primary mb-2">precision_manufacturing</span>
                                        <p class="font-bold text-sm text-on-surface">Engineering</p>
                                        <span class="text-[9px] font-bold text-on-surface-variant/50 uppercase mt-1">PCM Track</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Right Column: Notifications & Security -->
                <div class="lg:col-span-4 space-y-6">
                    <!-- Notifications Panel -->
                    <section class="glass-card rounded-xl p-6 space-y-6">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg">notifications_active</span>
                            <h3 class="font-display font-bold text-lg">Alert Center</h3>
                        </div>
                        <div class="space-y-5">
                            <div class="flex items-center justify-between group">
                                <div class="space-y-0.5">
                                    <p class="text-sm font-bold text-on-surface">New Resources</p>
                                    <p class="text-[11px] text-on-surface-variant/60">Email when content is uploaded</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input checked class="sr-only peer" type="checkbox"/>
                                    <div class="w-10 h-5 bg-surface-container-high rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between group">
                                <div class="space-y-0.5">
                                    <p class="text-sm font-bold text-on-surface">TMA Deadlines</p>
                                    <p class="text-[11px] text-on-surface-variant/60">Reminder 48h before due date</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input checked class="sr-only peer" type="checkbox"/>
                                    <div class="w-10 h-5 bg-surface-container-high rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between group">
                                <div class="space-y-0.5">
                                    <p class="text-sm font-bold text-on-surface">Mocktest Results</p>
                                    <p class="text-[11px] text-on-surface-variant/60">Instant performance reports</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input class="sr-only peer" type="checkbox"/>
                                    <div class="w-10 h-5 bg-surface-container-high rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                                </label>
                            </div>
                        </div>
                    </section>

                    <!-- Security & Privacy -->
                    <section class="glass-card rounded-xl p-6 space-y-6">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg">verified_user</span>
                            <h3 class="font-display font-bold text-lg">Trust &amp; Security</h3>
                        </div>
                        <div class="space-y-4">
                            <button type="button" @click="isPasswordModalOpen = true" class="w-full flex items-center justify-between p-4 rounded-xl bg-surface-container-low/35 hover:bg-surface-container-low/70 transition-all border border-outline-variant/10 group text-on-surface">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-on-surface-variant/50">lock_reset</span>
                                    <span class="text-sm font-bold">Change Password</span>
                                </div>
                                <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">chevron_right</span>
                            </button>
                            <button type="button" @click="isDeleteModalOpen = true" class="w-full flex items-center justify-between p-4 rounded-xl bg-red-500/5 hover:bg-red-500/10 transition-all border border-red-500/10 group text-red-600">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-red-400">delete_forever</span>
                                    <span class="text-sm font-bold text-left">Delete Account</span>
                                </div>
                                <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform text-red-400">chevron_right</span>
                            </button>
                        </div>
                        <div class="pt-2">
                            <p class="text-[11px] text-on-surface-variant/40 leading-relaxed">Your data is secured using industry-standard protocols. Read our <a class="text-primary underline underline-offset-4 decoration-primary/20" href="/privacy">Privacy Policy</a>.</p>
                        </div>
                    </section>

                    <!-- Visual Accent Block -->
                    <div class="relative overflow-hidden rounded-xl h-44 group shadow-md border border-outline-variant/10">
                        <img alt="Atmospheric Visual" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-[2s]" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCR-eNfZ0iXHXImj4c-NvPzwh-zpaZQtFHwUt4w1S1mj3dLnLHAYS1iLUTHtmVLwO_Ek4U2vvRhlTEdQd8T2ubPQprHADr6LaBfy-IhQrnYof_6TIaI-VOswq-GeVQu2sCbGs8UPJEz45gQvGDWh67wCqLridkUguR6j-fNU1f13fHtvFJHbQlXql8SGCHzA1tgwrbHeSc5yV3xNi8dCBw2ty14IINzOZ4eQIQjJv_qU9j1fmElrxMYOpu-w1bnno-28XkibIJSpg8"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/95 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <p class="text-on-primary font-bold text-sm">Need academic help?</p>
                            <p class="text-on-primary/80 text-xs mt-1">Connect with an AI mentor today.</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Change Password Modal -->
        <div x-show="isPasswordModalOpen" class="fixed inset-0 z-50 flex items-center justify-center px-4" style="display: none;">
            <div 
                x-show="isPasswordModalOpen"
                @click="isPasswordModalOpen = false"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
            ></div>
            
            <div 
                x-show="isPasswordModalOpen"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-10 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-10 scale-95"
                class="glass-card w-full max-w-md bg-white p-8 rounded-3xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface"
            >
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-extrabold tracking-tight text-primary">Change Password</h2>
                    <button @click="isPasswordModalOpen = false" class="p-2 hover:bg-surface-container rounded-full text-on-surface-variant transition-colors flex items-center justify-center">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    @method('put')
                    <div>
                        <label class="block text-xs font-bold tracking-wide uppercase text-on-surface-variant mb-2">Current Password</label>
                        <input
                            type="password"
                            name="current_password"
                            required
                            class="w-full p-4 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none text-primary font-medium placeholder:text-on-surface-variant/40 focus:border-primary/50 text-sm"
                            placeholder="••••••••"
                        />
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-xs" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold tracking-wide uppercase text-on-surface-variant mb-2">New Password</label>
                        <input
                            type="password"
                            name="password"
                            required
                            class="w-full p-4 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none text-primary font-medium placeholder:text-on-surface-variant/40 focus:border-primary/50 text-sm"
                            placeholder="••••••••"
                        />
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-xs" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold tracking-wide uppercase text-on-surface-variant mb-2">Confirm Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            class="w-full p-4 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none text-primary font-medium placeholder:text-on-surface-variant/40 focus:border-primary/50 text-sm"
                            placeholder="••••••••"
                        />
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-xs" />
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="isPasswordModalOpen = false" class="px-6 py-3 rounded-xl font-bold bg-surface-container hover:bg-surface-container-high text-primary transition-colors border border-outline-variant/30 text-sm">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-3 rounded-xl font-bold bg-primary hover:bg-primary/95 text-white shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all text-sm">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Account Modal -->
        <div x-show="isDeleteModalOpen" class="fixed inset-0 z-50 flex items-center justify-center px-4" style="display: none;">
            <div 
                x-show="isDeleteModalOpen"
                @click="isDeleteModalOpen = false"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
            ></div>
            
            <div 
                x-show="isDeleteModalOpen"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-10 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-10 scale-95"
                class="glass-card w-full max-w-md bg-white p-8 rounded-3xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface"
            >
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-extrabold tracking-tight text-red-600">Delete Account</h2>
                    <button @click="isDeleteModalOpen = false" class="p-2 hover:bg-surface-container rounded-full text-on-surface-variant transition-colors flex items-center justify-center">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                    @csrf
                    @method('delete')
                    
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                    </p>

                    <div>
                        <label class="block text-xs font-bold tracking-wide uppercase text-on-surface-variant mb-2">Password</label>
                        <input
                            type="password"
                            name="password"
                            required
                            class="w-full p-4 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none text-primary font-medium placeholder:text-on-surface-variant/40 focus:border-primary/50 text-sm"
                            placeholder="••••••••"
                        />
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-xs" />
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="isDeleteModalOpen = false" class="px-6 py-3 rounded-xl font-bold bg-surface-container hover:bg-surface-container-high text-primary transition-colors border border-outline-variant/30 text-sm">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-3 rounded-xl font-bold bg-red-600 hover:bg-red-700 text-white shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all text-sm">
                            Permanently Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-student-layout>
