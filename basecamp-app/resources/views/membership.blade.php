<x-student-layout>
    <style>
        .mem-glass-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .mem-signature-gradient {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
        }
        .mem-text-glow {
            text-shadow: 0 0 20px rgba(64, 206, 243, 0.3);
        }
    </style>

    <div class="relative z-10 w-full overflow-x-hidden pb-20">
        <!-- Background Blobs for Atmospheric Depth -->
        <div class="absolute w-[500px] h-[500px] bg-primary-container/30 blur-[80px] top-[-5%] right-[-5%] rounded-full -z-10 pointer-events-none mix-blend-multiply"></div>
        <div class="absolute w-[600px] h-[600px] bg-secondary-container/30 blur-[80px] bottom-[10%] left-[-10%] rounded-full -z-10 pointer-events-none mix-blend-multiply"></div>

        <div class="max-w-7xl mx-auto space-y-20 px-4">
            <!-- Hero Section -->
            <section class="text-center max-w-4xl mx-auto pt-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-primary-container/20 text-primary font-semibold text-xs tracking-widest uppercase mb-4">
                    Tiered Ecosystem
                </span>
                <h1 class="text-[clamp(2.25rem,6vw,3.75rem)] font-bold tracking-tight text-on-surface mb-6 leading-tight">
                    Calibrate Your <span class="text-primary italic mem-text-glow">Learning Orbit.</span>
                </h1>
                <p class="text-lg text-slate-600 font-medium leading-relaxed max-w-2xl mx-auto">
                    Select the architectural node that aligns with your educational trajectory. Precision tools for Class 10, 12, and competitive aspirants.
                </p>
            </section>

            <!-- Pricing Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-end">
                <!-- Tier 1: Secondary -->
                <div class="mem-glass-card rounded-[2rem] p-6 sm:p-8 flex flex-col h-full hover:shadow-2xl hover:shadow-cyan-900/5 transition-all duration-500 border border-white/40">
                    <div class="mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-secondary-container/30 flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-primary">school</span>
                        </div>
                        <h3 class="text-2xl font-bold text-on-surface mb-2">Secondary</h3>
                        <p class="text-sm text-slate-500 font-medium">Class 10th Core</p>
                    </div>
                    <div class="mb-8 flex flex-col">
                        <span class="text-4xl font-bold text-on-surface">₹1,999</span>
                        <span class="text-slate-500 text-sm font-medium">/ year</span>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow font-medium">
                        <li class="flex items-center gap-3 text-sm text-on-surface-variant">
                            <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                            5 Foundation Subjects
                        </li>
                        <li class="flex items-center gap-3 text-sm text-on-surface-variant">
                            <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                            Standard TMA Support
                        </li>
                        <li class="flex items-center gap-3 text-sm text-on-surface-variant">
                            <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                            Digital Notes Access
                        </li>
                    </ul>
                    <button class="w-full py-4 rounded-xl border-2 border-primary text-primary font-bold hover:bg-primary hover:text-white transition-all duration-300">
                        Upgrade Your Node
                    </button>
                </div>

                <!-- Tier 2: Sr. Secondary (Featured) -->
                <div class="mem-glass-card rounded-[2rem] p-6 sm:p-10 flex flex-col h-full border-2 border-primary/40 relative transform lg:scale-105 shadow-2xl shadow-primary-container/20">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-primary text-white px-4 py-1 rounded-full text-xs font-bold tracking-widest uppercase">
                        Most Popular
                    </div>
                    <div class="mb-8">
                        <div class="w-14 h-14 rounded-2xl mem-signature-gradient flex items-center justify-center mb-4 shadow-lg shadow-primary/20">
                            <span class="material-symbols-outlined text-white">science</span>
                        </div>
                        <h3 class="text-3xl font-bold text-on-surface mb-2">Sr. Secondary</h3>
                        <p class="text-sm text-primary font-bold">Science Track (PCB/PCM)</p>
                    </div>
                    <div class="mb-8 flex flex-col">
                        <span class="text-5xl font-bold text-primary">₹4,499</span>
                        <span class="text-slate-500 font-medium">/ year</span>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow font-medium">
                        <li class="flex items-center gap-3 text-sm text-on-surface">
                            <span class="material-symbols-outlined text-primary text-lg">bolt</span>
                            Advanced Lab Resources
                        </li>
                        <li class="flex items-center gap-3 text-sm text-on-surface">
                            <span class="material-symbols-outlined text-primary text-lg">bolt</span>
                            NCERT Solutions Hub
                        </li>
                        <li class="flex items-center gap-3 text-sm text-on-surface">
                            <span class="material-symbols-outlined text-primary text-lg">bolt</span>
                            24/7 Doubt Resolution
                        </li>
                        <li class="flex items-center gap-3 text-sm text-on-surface">
                            <span class="material-symbols-outlined text-primary text-lg">bolt</span>
                            Recorded Expert Lectures
                        </li>
                    </ul>
                    <button class="w-full py-4 rounded-xl mem-signature-gradient text-white font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform">
                        Upgrade Your Node
                    </button>
                </div>

                <!-- Tier 3: Pro Aspirant -->
                <div class="mem-glass-card rounded-[2rem] p-6 sm:p-8 flex flex-col h-full hover:shadow-2xl hover:shadow-cyan-900/5 transition-all duration-500 border border-white/40">
                    <div class="mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-tertiary-container/30 flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-tertiary">auto_awesome</span>
                        </div>
                        <h3 class="text-2xl font-bold text-on-surface mb-2">Pro Aspirant</h3>
                        <p class="text-sm text-slate-500 font-medium">Entrance Focused</p>
                    </div>
                    <div class="mb-8 flex flex-col">
                        <span class="text-4xl font-bold text-on-surface">₹8,999</span>
                        <span class="text-slate-500 text-sm font-medium">/ year</span>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow font-medium">
                        <li class="flex items-center gap-3 text-sm text-on-surface-variant">
                            <span class="material-symbols-outlined text-tertiary text-lg">check_circle</span>
                            1-on-1 Personal Mentorship
                        </li>
                        <li class="flex items-center gap-3 text-sm text-on-surface-variant">
                            <span class="material-symbols-outlined text-tertiary text-lg">check_circle</span>
                            Bonus Mock JEE/NEET Tests
                        </li>
                        <li class="flex items-center gap-3 text-sm text-on-surface-variant">
                            <span class="material-symbols-outlined text-tertiary text-lg">check_circle</span>
                            Priority TMA Evaluation
                        </li>
                        <li class="flex items-center gap-3 text-sm text-on-surface-variant">
                            <span class="material-symbols-outlined text-tertiary text-lg">check_circle</span>
                            Career Mapping Session
                        </li>
                    </ul>
                    <button class="w-full py-4 rounded-xl border-2 border-tertiary text-tertiary font-bold hover:bg-tertiary hover:text-white transition-all duration-300">
                        Upgrade Your Node
                    </button>
                </div>
            </div>

            <!-- Benefits Matrix -->
            <section class="max-w-5xl mx-auto pt-10">
                <h2 class="text-3xl font-bold text-center mb-12 text-primary tracking-tight">Comparative Intelligence</h2>
                <div class="mem-glass-card rounded-[2.5rem] overflow-hidden shadow-xl border border-white/40">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[600px]">
                            <thead>
                                <tr class="bg-surface-container-low/50">
                                    <th class="p-6 text-sm font-bold uppercase tracking-widest text-slate-400">Core Features</th>
                                    <th class="p-6 text-center font-bold text-slate-600">Secondary</th>
                                    <th class="p-6 text-center font-bold text-primary">Sr. Secondary</th>
                                    <th class="p-6 text-center font-bold text-tertiary">Pro Aspirant</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                <tr class="hover:bg-white/40 transition-colors">
                                    <td class="p-6 text-sm font-medium">Subject Library</td>
                                    <td class="p-6 text-center text-slate-500 font-medium">5 Basics</td>
                                    <td class="p-6 text-center text-primary font-bold">Full Track</td>
                                    <td class="p-6 text-center text-tertiary font-bold">Unlimited</td>
                                </tr>
                                <tr class="hover:bg-white/40 transition-colors">
                                    <td class="p-6 text-sm font-medium">TMA Support</td>
                                    <td class="p-6 text-center">
                                        <span class="material-symbols-outlined text-slate-300">check_small</span>
                                    </td>
                                    <td class="p-6 text-center">
                                        <span class="material-symbols-outlined text-primary">check_circle</span>
                                    </td>
                                    <td class="p-6 text-center">
                                        <span class="material-symbols-outlined text-tertiary">verified</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-white/40 transition-colors">
                                    <td class="p-6 text-sm font-medium">Live Doubt Solving</td>
                                    <td class="p-6 text-center">
                                        <span class="material-symbols-outlined text-red-300">close</span>
                                    </td>
                                    <td class="p-6 text-center">
                                        <span class="material-symbols-outlined text-primary">check_circle</span>
                                    </td>
                                    <td class="p-6 text-center">
                                        <span class="material-symbols-outlined text-tertiary">check_circle</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-white/40 transition-colors">
                                    <td class="p-6 text-sm font-medium">1-on-1 Mentoring</td>
                                    <td class="p-6 text-center">
                                        <span class="material-symbols-outlined text-red-300">close</span>
                                    </td>
                                    <td class="p-6 text-center">
                                        <span class="material-symbols-outlined text-red-300">close</span>
                                    </td>
                                    <td class="p-6 text-center">
                                        <span class="material-symbols-outlined text-tertiary">check_circle</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-white/40 transition-colors">
                                    <td class="p-6 text-sm font-medium">Test Analytics</td>
                                    <td class="p-6 text-center text-slate-500 font-medium">Basic</td>
                                    <td class="p-6 text-center text-primary font-bold">Advanced</td>
                                    <td class="p-6 text-center text-tertiary font-extrabold flex items-center justify-center gap-1">
                                        <span class="material-symbols-outlined text-[16px]">smart_toy</span> AI-Predictive
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Asymmetric Detail Section -->
            <section class="mt-20 pt-10 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div class="relative group">
                    <div class="absolute -top-10 -left-10 w-32 h-32 bg-primary-container/30 blur-3xl transition-all duration-1000 group-hover:scale-150"></div>
                    <img alt="Students collaborating" class="rounded-[2.5rem] shadow-2xl relative z-10 w-full object-cover aspect-video md:aspect-auto border border-outline-variant/20 hover:scale-[1.02] transition-transform duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAiz_rE4ugzw6fRzcUXVi4lU8L1Cp9-Hklpgfhhq8KuxFmMpdIq4CQeLW6R2yFN-akr7cybedJ248S8FqGSpoGtpTSdAuCKdT0t3zSjdsf6oA3TCBmZdjDhYO0S-En0239mtx0UYC7tzC2qqSMBrpN1CGVQS-qmhgII9_KX2Yrkrag4ya3irs0iKmOE3prMuwu0KjbJ4dPMUR7umLRcSt4-kyHF3WaP9nX9RVwcFkg6o4ITxLw4825SfTs2_Cn3ZMyxuTlXIvuRu5c"/>
                    
                    <div class="absolute -bottom-6 -right-6 mem-glass-card p-6 rounded-[2rem] z-20 shadow-xl border border-white/60 group-hover:-translate-y-2 transition-transform duration-500">
                        <div class="flex items-center gap-4">
                            <div class="flex -space-x-2">
                                <img alt="User" class="w-8 h-8 rounded-full border-2 border-white" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDBXKbetgmwhQIqfvbwyNDZO_FnnWCFSiz8wDPsu37W8jNaEsPAChdpQggpJ10Y-uKw-Yof1EQNlxTNBklJWHF2z2Ewxc7Q34KoIwjt5ILt9OCoZyRB5L7Lrvw-VrVAwjxkS1kKQ4zF-Z4ms4kUND1PEYDE1zDDPX9zqLlPJ_yLluz3WES6zKFIpvSCUc_qJXdql4UeZ59VZW1_pJJtzzC620oVKiITNU0wj0-h_xQpeqSwH1u3mjrKDE4ZYIs4Gev5kvaqJfM4NcQ"/>
                                <img alt="User" class="w-8 h-8 rounded-full border-2 border-white" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDAbYaM2Daz22iRqjZcxBKaMwT-JhPOyryogrBQURMC4WKxSUPrqOM06dRj3zB9uE_T9pReHcI3cRCrwwrTfqeKgDSwRlE2lK2ep3aWINyki1XYU7RhpSaifPJrMQ8WTUwQs2ZYVjuK2tfv8rSHrcDB8sUbFVAY_06nNRcaFH3QBYfHmjGslcltKsX-LPRkFD-fL6Nma8k0WMpVrA314x6BB5YfqLLKApPmWMwPdaGkDBHe3iw7M64j8aIIzHFvkYipwZrNTsZu29g"/>
                                <img alt="User" class="w-8 h-8 rounded-full border-2 border-white" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCp6A5bIcJ05buUgcxh78jgBbb_vF6xiXxCFYrTmePpJNY9w-2z57q2KuAsHzPkvbtOvgfN7IKioR7EOZ9UiyBfYqgtpKOWKIu7uVCEoj01rwx68_wH6y6SjSpOEcK47gWCeNhB6vRmFWg3kcBunF-aBkRbmGmvv2zBtNsqYSW-_MSvlUv184Uww7rVAdPML9xatTT-lV4p3hLXfjxDFQm9jTf6cBxfC1g1aapt5mAdbjZXmdd9BESIgUJV1JUGIVJsN8gdVFAUX28"/>
                            </div>
                            <p class="text-[10px] font-bold text-primary tracking-widest uppercase mt-1">Join 12k+ Scholars</p>
                        </div>
                    </div>
                </div>
                
                <div class="px-4">
                    <h3 class="text-4xl font-bold mb-6 tracking-tight text-primary">Why upgrade your educational node?</h3>
                    <p class="text-slate-600 mb-8 text-lg font-medium leading-relaxed">
                        Base Camp Premium isn't just about static content. Our higher tiers unlock access to live data streams, real-time mentorship, and AI-driven performance tracking that adapts to your unique learning velocity.
                    </p>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="mt-1">
                                <span class="material-symbols-outlined text-primary text-3xl">hub</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-on-surface">Interconnected Resources</h4>
                                <p class="text-sm text-slate-500 font-medium">Cross-subject integration for better concept retention.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="mt-1">
                                <span class="material-symbols-outlined text-primary text-3xl">timeline</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-on-surface">Growth Trajectory</h4>
                                <p class="text-sm text-slate-500 font-medium">Visualize your path from foundation to entrance excellence.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-student-layout>
