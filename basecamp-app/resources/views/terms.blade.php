<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Terms of Service - thebasecampschool</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "surface-container-lowest": "#ffffff",
                    "surface-tint": "#006479",
                    "primary-fixed": "#40cef3",
                    "on-primary": "#e0f6ff",
                    "tertiary-fixed": "#80b2ff",
                    "primary-container": "#40cef3",
                    "background": "#f2f7f9",
                    "tertiary-container": "#80b2ff",
                    "primary": "#006479",
                    "secondary-container": "#96e6f6",
                    "primary-dim": "#00576a",
                    "on-secondary": "#d8f8ff",
                    "secondary-fixed": "#96e6f6",
                    "surface": "#f2f7f9",
                    "on-background": "#2a3031",
                    "on-tertiary-fixed": "#001835",
                    "on-tertiary-container": "#003061",
                    "on-secondary-fixed-variant": "#005f6b",
                    "tertiary-fixed-dim": "#65a4ff",
                    "on-tertiary-fixed-variant": "#003971",
                    "on-primary-fixed-variant": "#004a5a",
                    "surface-container": "#e3e9ec",
                    "secondary-dim": "#005863",
                    "on-surface-variant": "#575c5e",
                    "error-container": "#fb5151",
                    "inverse-on-surface": "#989ea0",
                    "surface-dim": "#cdd6d9",
                    "inverse-surface": "#0a0f11",
                    "surface-variant": "#d6dee1",
                    "primary-fixed-dim": "#28c0e4",
                    "on-surface": "#2a3031",
                    "inverse-primary": "#40cef3",
                    "outline": "#72787a",
                    "tertiary-dim": "#004f98",
                    "on-error-container": "#570008",
                    "error-dim": "#9f0519",
                    "tertiary": "#005bae",
                    "on-primary-container": "#00414f",
                    "error": "#b31b25",
                    "on-tertiary": "#eff2ff",
                    "surface-container-high": "#dce4e6",
                    "outline-variant": "#a8aeb0",
                    "secondary-fixed-dim": "#88d8e7",
                    "secondary": "#006572",
                    "on-error": "#ffefee",
                    "surface-bright": "#f2f7f9",
                    "surface-container-low": "#ecf2f4",
                    "on-secondary-fixed": "#004049",
                    "on-secondary-container": "#005560",
                    "on-primary-fixed": "#002a34",
                    "surface-container-highest": "#d6dee1"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "fontFamily": {
                    "headline": ["Space Grotesk"],
                    "body": ["Space Grotesk"],
                    "label": ["Space Grotesk"]
            }
          },
        },
      }
    </script>
<style>
        body { font-family: 'Space Grotesk', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f2f7f9; }
        ::-webkit-scrollbar-thumb { background: #006479; border-radius: 10px; }
    </style>
</head>
<body class="bg-surface text-on-surface selection:bg-primary-container selection:text-on-primary-container">
@include('components.header-nav')
<main class="pt-24 pb-20 px-4 sm:px-6 lg:px-8 max-w-screen-2xl mx-auto min-h-screen relative overflow-hidden">
<!-- Background decorative blobs -->
<div class="absolute -top-20 -right-20 w-96 h-96 bg-primary-container/20 rounded-full blur-[100px] -z-10 animate-pulse"></div>
<div class="absolute top-1/2 -left-20 w-64 h-64 bg-secondary-container/30 rounded-full blur-[80px] -z-10"></div>
<div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-start">
<!-- Sticky Sidebar Navigation -->
<aside class="md:col-span-3 sticky top-32 hidden md:block">
<div class="glass-panel p-6 rounded-xl border border-outline-variant/15">
<h3 class="text-sm font-bold tracking-[0.1em] text-on-surface-variant mb-6 uppercase">Document Sections</h3>
<ul class="space-y-4">
<li>
<a class="flex items-center gap-3 text-cyan-700 font-bold border-l-2 border-primary pl-4 transition-all" href="#introduction">
<span class="material-symbols-outlined text-[20px]" data-icon="info">info</span> Introduction
                            </a>
</li>
<li>
<a class="flex items-center gap-3 text-on-surface-variant hover:text-cyan-600 hover:border-l-2 hover:border-primary/40 pl-4 transition-all" href="#refer-earn">
<span class="material-symbols-outlined text-[20px]" data-icon="group_add">group_add</span> Refer &amp; Earn
                            </a>
</li>
<li>
<a class="flex items-center gap-3 text-on-surface-variant hover:text-cyan-600 hover:border-l-2 hover:border-primary/40 pl-4 transition-all" href="#nios-fees">
<span class="material-symbols-outlined text-[20px]" data-icon="payments">payments</span> NIOS Fee Deadlines
                            </a>
</li>
<li>
<a class="flex items-center gap-3 text-on-surface-variant hover:text-cyan-600 hover:border-l-2 hover:border-primary/40 pl-4 transition-all" href="#integrity">
<span class="material-symbols-outlined text-[20px]" data-icon="verified_user">verified_user</span> Academic Integrity
                            </a>
</li>
<li>
<a class="flex items-center gap-3 text-on-surface-variant hover:text-cyan-600 hover:border-l-2 hover:border-primary/40 pl-4 transition-all" href="#refunds">
<span class="material-symbols-outlined text-[20px]" data-icon="settings_backup_restore">settings_backup_restore</span> Refund Policy
                            </a>
</li>
</ul>
</div>
<div class="mt-8 glass-panel p-6 rounded-xl bg-primary/5 border-primary/20">
<p class="text-xs text-primary-dim leading-relaxed">
                        Last Updated: October 24, 2024<br/>
                        Revision: 4.2.0-Alpha
                    </p>
</div>
</aside>
<!-- Main Content Canvas -->
<div class="md:col-span-9 space-y-12">
<!-- Hero Header -->
<header class="mb-16">
<span class="inline-block px-3 py-1 bg-secondary-container/50 text-secondary-dim text-[10px] font-bold tracking-widest uppercase rounded-full mb-4">Legal Framework</span>
<h1 class="text-[clamp(2.5rem,7vw,4.5rem)] font-bold tracking-[-0.03em] text-on-surface mb-6">Terms of <span class="text-primary italic">Service</span></h1>
<p class="text-lg text-on-surface-variant max-w-2xl leading-relaxed">
                        These terms govern your access to and use of thebasecampschool. By using our platform, you agree to comply with our academic standards and operational protocols.
                    </p>
</header>
<!-- Introduction -->
<section class="glass-panel p-10 rounded-2xl" id="introduction">
<h2 class="text-3xl font-bold mb-6 flex items-center gap-3">
<span class="material-symbols-outlined text-primary" data-icon="sticky_note_2">sticky_note_2</span>
                        General Provisions
                    </h2>
<div class="prose prose-slate max-w-none text-on-surface-variant leading-[1.8] space-y-4">
<p>Welcome to thebasecampschool (the "Service"). This document outlines the contractual obligations between you ("User") and thebasecampschool regarding enrollment, financial transactions, and academic conduct.</p>
<p>We provide specialized coaching and administrative assistance for NIOS (National Institute of Open Schooling) board exams. These terms ensure a transparent and high-standard educational environment for all students.</p>
</div>
</section>
<!-- Refer & Earn Section -->
<section class="relative group" id="refer-earn">
<div class="absolute inset-0 bg-gradient-to-r from-primary/5 to-transparent rounded-2xl -z-10 group-hover:from-primary/10 transition-colors"></div>
<div class="p-10 border-l-4 border-primary">
<h2 class="text-3xl font-bold mb-8 flex items-center gap-3">
<span class="material-symbols-outlined text-primary" data-icon="loyalty">loyalty</span>
                            The "Ambassador" Program
                        </h2>
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
<div class="bg-surface-container-lowest p-8 rounded-2xl border border-outline-variant/15 shadow-sm">
<h3 class="text-xl font-bold mb-4 text-primary">100% Refund Policy</h3>
<p class="text-on-surface-variant mb-6 leading-relaxed">Refer 10 Students = 100% Course Fee Refund. This program is designed to reward our most active community members who help maintain our growth.</p>
<ul class="space-y-3">
<li class="flex items-start gap-3 text-sm">
<span class="material-symbols-outlined text-green-600" data-icon="check_circle">check_circle</span>
<span>Referrals must successfully complete full enrollment and fee payment.</span>
</li>
<li class="flex items-start gap-3 text-sm">
<span class="material-symbols-outlined text-green-600" data-icon="check_circle">check_circle</span>
<span>Refund applies to the "Coaching Fee" component only.</span>
</li>
</ul>
</div>
<div class="relative rounded-2xl overflow-hidden min-h-[250px]">
<img alt="Diverse group of cheerful students collaborating in a modern glass-walled university lounge with soft natural lighting and cyan accents" class="absolute inset-0 w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAqULFmgiBslMO6SJfBkn9dGhoVRR1M4BRVRtpI_TXydgUO_CsXncCVyiSG-a2IMFjoXX5k4mDIm9LIy3735ygLoheMHTrgBt2AVffjoADWI9Dp8Gr-tbN88xQLuBzK-fS2jgfUs8Sa6DjAui_OCtXmRkLkdapkBDQyvNkN2_ZM2YRs4Jqg0ZvglY2YwjhgUx5EQgL2r2CRBTqN16SguPRWapmEK4l8G9ZkoKBcB9G0mLDEE7WlB7XkOf14VkraCo_wx8lqnIG_rZI"/>
<div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent flex flex-col justify-end p-6">
<span class="text-white/80 text-xs font-bold uppercase tracking-widest mb-1">Impact</span>
<p class="text-white font-medium text-lg">Join 400+ students already learning for free through the referral system.</p>
</div>
</div>
</div>
</div>
</section>
<!-- NIOS Fees Bento Grid -->
<section class="space-y-8" id="nios-fees">
<div class="flex flex-col md:flex-row justify-between items-end gap-4">
<div>
<h2 class="text-3xl font-bold mb-2">NIOS Fee Deadlines</h2>
<p class="text-on-surface-variant">Academic Session Timelines for Block 1 and Block 2</p>
</div>
<div class="px-4 py-2 bg-error-container/10 text-error text-xs font-bold rounded-lg flex items-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="warning">warning</span>
                            Avoid Penalties: Pay on Schedule
                        </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<!-- Fee Card 1 -->
<div class="glass-panel p-8 rounded-2xl border-t-4 border-primary shadow-xl">
<div class="flex justify-between items-start mb-6">
<span class="material-symbols-outlined text-primary text-4xl" data-icon="schedule">schedule</span>
<span class="bg-primary/10 text-primary text-[10px] font-bold px-2 py-1 rounded">PHASE I</span>
</div>
<h4 class="font-bold text-lg mb-2">Standard Entry</h4>
<p class="text-sm text-on-surface-variant mb-6">Standard exam fees apply with no additional surcharges.</p>
<div class="text-2xl font-bold text-primary">₹0 <span class="text-sm font-normal text-on-surface-variant">late fee</span></div>
</div>
<!-- Fee Card 2 -->
<div class="glass-panel p-8 rounded-2xl border-t-4 border-secondary-fixed shadow-xl">
<div class="flex justify-between items-start mb-6">
<span class="material-symbols-outlined text-secondary text-4xl" data-icon="alarm">alarm</span>
<span class="bg-secondary-container/50 text-secondary text-[10px] font-bold px-2 py-1 rounded">PHASE II</span>
</div>
<h4 class="font-bold text-lg mb-2">Extended Window</h4>
<p class="text-sm text-on-surface-variant mb-6">Applicable for late registrations within the first 15 days of deadline lapse.</p>
<div class="text-2xl font-bold text-secondary">+₹260 <span class="text-sm font-normal text-on-surface-variant">per subject</span></div>
</div>
<!-- Fee Card 3 -->
<div class="glass-panel p-8 rounded-2xl border-t-4 border-error shadow-xl">
<div class="flex justify-between items-start mb-6">
<span class="material-symbols-outlined text-error text-4xl" data-icon="emergency">emergency</span>
<span class="bg-error-container/20 text-error text-[10px] font-bold px-2 py-1 rounded">CRITICAL</span>
</div>
<h4 class="font-bold text-lg mb-2">Final Call</h4>
<p class="text-sm text-on-surface-variant mb-6">Final opportunity for registration before session portal closure.</p>
<div class="space-y-1">
<div class="text-2xl font-bold text-error">+₹520 <span class="text-xs font-normal">Next 15 days</span></div>
<div class="text-3xl font-extrabold text-error-dim">+₹910 <span class="text-xs font-normal">Final Consolidation</span></div>
</div>
</div>
</div>
</section>
<!-- Academic Integrity Section -->
<section class="glass-panel overflow-hidden rounded-3xl" id="integrity">
<div class="grid grid-cols-1 md:grid-cols-5">
<div class="md:col-span-2 relative min-h-[300px]">
<img alt="High-concept abstract visual of transparent crystal blocks perfectly aligned with beams of blue light passing through them, representing clarity and structure" class="absolute inset-0 w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC8UIuMuAo_sWqPnwDkdMgyHEh1gSYSzryJ8uta3DR-aH-1C-D3n1n7feLCyKO1AGquwvQ8PQWSJjkGr5wWy0uiCvTkwa9AlttYrrdM2M8-qJTCxV2sm8_z72ks6WITjKBo4wkHTg0Q2lJpGB865SF6Y3K5nlTPhNTYEtFDzBDgq4gpZn3lL3snhcHalyNIpCBEAQ3Y-WLQUn8JGjTzFbmei-WkPLDiI2tTJ86-_f-eJywldV1zJL5wQXz8PrTa4oa_rrqZDL4Ec-s"/>
</div>
<div class="md:col-span-3 p-10 flex flex-col justify-center">
<h2 class="text-3xl font-bold mb-6">Academic Integrity</h2>
<div class="space-y-6">
<div class="flex gap-4">
<div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-primary" data-icon="edit_note">edit_note</span>
</div>
<div>
<h5 class="font-bold text-on-surface">Original TMA Policy</h5>
<p class="text-sm text-on-surface-variant">Tutor Marked Assignments (TMAs) must be original works. Plagiarism or AI-generated content without attribution is strictly prohibited and may result in disqualification.</p>
</div>
</div>
<div class="flex gap-4">
<div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-primary" data-icon="gavel">gavel</span>
</div>
<div>
<h5 class="font-bold text-on-surface">Exam Conduct</h5>
<p class="text-sm text-on-surface-variant">Candidates must adhere to NIOS examination hall regulations. thebasecampschool does not tolerate or assist in any form of malpractice during physical examinations.</p>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- Refund & Cancellation -->
<section class="p-10 border border-outline-variant/10 rounded-2xl bg-surface-container-low/30" id="refunds">
<h2 class="text-3xl font-bold mb-6">Refund &amp; Cancellation</h2>
<div class="space-y-4 text-on-surface-variant leading-relaxed">
<p>Registration fees are non-refundable once the NIOS admission portal has processed the application. Coaching fees may be partially refundable (50%) if requested within 48 hours of enrollment, provided no digital assets have been accessed.</p>
<div class="p-4 bg-primary/5 rounded-xl border border-primary/20 flex items-center gap-4">
<span class="material-symbols-outlined text-primary" data-icon="help">help</span>
<span class="text-sm">Questions about these terms? Contact our <a class="text-primary font-bold underline decoration-2 underline-offset-4" href="{{ url('/contact') }}">Legal Support Team</a>.</span>
</div>
</div>
</section>
</div>
</div>
</main>
<!-- Footer Component -->
@include('layouts.footer')
</body></html>
