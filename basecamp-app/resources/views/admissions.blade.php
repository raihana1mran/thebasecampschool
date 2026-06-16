<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Admissions | thebasecampschool - Fee Structure &amp; Timeline</title>
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
                    "primary-dim": "#00576a",
                    "surface-bright": "#f2f7f9",
                    "primary-fixed-dim": "#28c0e4",
                    "inverse-primary": "#40cef3",
                    "surface-container-lowest": "#ffffff",
                    "secondary": "#006572",
                    "primary-fixed": "#40cef3",
                    "tertiary-fixed": "#80b2ff",
                    "error-container": "#fb5151",
                    "background": "#f2f7f9",
                    "on-secondary-fixed": "#004049",
                    "on-tertiary-fixed": "#001835",
                    "primary-container": "#40cef3",
                    "primary": "#006479",
                    "outline": "#72787a",
                    "on-tertiary": "#eff2ff",
                    "on-error-container": "#570008",
                    "on-secondary-fixed-variant": "#005f6b",
                    "surface-variant": "#d6dee1",
                    "on-primary-fixed-variant": "#004a5a",
                    "on-error": "#ffefee",
                    "surface-tint": "#006479",
                    "on-secondary-container": "#005560",
                    "on-primary-fixed": "#002a34",
                    "on-secondary": "#d8f8ff",
                    "inverse-surface": "#0a0f11",
                    "error-dim": "#9f0519",
                    "surface-dim": "#cdd6d9",
                    "on-surface-variant": "#575c5e",
                    "tertiary-fixed-dim": "#65a4ff",
                    "secondary-dim": "#005863",
                    "on-tertiary-container": "#003061",
                    "secondary-container": "#96e6f6",
                    "outline-variant": "#a8aeb0",
                    "tertiary": "#005bae",
                    "tertiary-container": "#80b2ff",
                    "inverse-on-surface": "#989ea0",
                    "on-background": "#2a3031",
                    "surface-container-low": "#ecf2f4",
                    "surface-container-highest": "#d6dee1",
                    "surface-container": "#e3e9ec",
                    "on-tertiary-fixed-variant": "#003971",
                    "tertiary-dim": "#004f98",
                    "surface": "#f2f7f9",
                    "on-primary": "#e0f6ff",
                    "secondary-fixed-dim": "#88d8e7",
                    "on-surface": "#2a3031",
                    "on-primary-container": "#00414f",
                    "secondary-fixed": "#96e6f6",
                    "error": "#b31b25",
                    "surface-container-high": "#dce4e6"
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
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .signature-gradient {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
        }
        .ambient-glow {
            box-shadow: 0px 40px 60px rgba(42, 48, 49, 0.05);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .tonal-transition {
            background: linear-gradient(to bottom, #f2f7f9, #ecf2f4);
        }
    </style>
</head>
<body class="bg-surface-bright text-on-background selection:bg-primary-container selection:text-on-primary-container">
@include('components.header-nav')
@php
    $now = \Carbon\Carbon::now();
    $month = $now->month;
    $day = $now->day;
    
    // Check if we are in Block 1 (1st March to 15th September)
    $isBlock1 = false;
    if (($month > 3 && $month < 9) || ($month == 3 && $day >= 1) || ($month == 9 && $day <= 15)) {
        $isBlock1 = true;
    }
    
    if ($isBlock1) {
        $currentBlock = 'Block 1';
        $examSession = 'April/May ' . ($now->year + 1);
    } else {
        $currentBlock = 'Block 2';
        $examSession = 'October/November ' . (($month > 9) ? $now->year + 1 : $now->year);
    }
@endphp
<main class="relative min-h-screen overflow-hidden">
<!-- Atmospheric Background Elements -->
<div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-primary-container/10 blur-[120px] rounded-full pointer-events-none"></div>
<div class="absolute bottom-[-5%] right-[-5%] w-[40%] h-[40%] bg-secondary-container/10 blur-[100px] rounded-full pointer-events-none"></div>
<!-- Hero Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-12">
<div class="max-w-3xl">
<span class="inline-block label-md bg-primary-container/20 text-primary px-4 py-1.5 rounded-full font-bold tracking-widest uppercase mb-6">Enrollment Open</span>
<h1 class="text-[clamp(2.5rem,7vw,4.5rem)] font-bold tracking-tighter text-on-background leading-[0.9] mb-8">Official NIOS {{ $currentBlock }} Enrollment</h1>
<p class="text-xl text-on-surface-variant font-medium leading-relaxed mb-4">
                    thebasecampschool: Secure your academic future with the {{ $examSession }} session. Strategic preparation meets streamlined administrative excellence.
                </p>
<div class="flex items-center gap-3 text-primary font-semibold">
<span class="material-symbols-outlined">verified</span>
<span>Accredited Distance Learning Excellence</span>
</div>
</div>
</section>
<!-- Main Content: 2-Column Layout -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 pb-32">
<!-- Column 1: Fee Structure & Details (7 Columns) -->
<div class="lg:col-span-7 space-y-12">
<div class="glass-panel p-10 rounded-3xl ambient-glow">
<h2 class="text-3xl font-bold tracking-tight text-on-background mb-8">Category &amp; Fee Table</h2>
<div class="space-y-6">
<!-- Class 10 Card -->
<div class="group relative overflow-hidden bg-surface-container-low/50 hover:bg-surface-container-lowest/80 transition-all duration-500 rounded-2xl p-8 border border-white/20">
<div class="flex justify-between items-start mb-6">
<div>
<h3 class="text-2xl font-bold text-on-background">Secondary (Class 10)</h3>
<p class="text-on-surface-variant">Comprehensive enrollment package</p>
</div>
<div class="text-right">
<div class="text-3xl font-bold text-primary">₹5,500</div>
<div class="text-xs font-bold tracking-widest text-outline uppercase">One-time Fee</div>
</div>
</div>
<div class="grid grid-cols-2 gap-4">
<div class="flex items-center gap-2 text-on-surface-variant">
<span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
<span class="text-sm font-medium">Registration</span>
</div>
<div class="flex items-center gap-2 text-on-surface-variant">
<span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
<span class="text-sm font-medium">5 Core Subjects</span>
</div>
<div class="flex items-center gap-2 text-on-surface-variant">
<span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
<span class="text-sm font-medium">Documentation</span>
</div>
<div class="flex items-center gap-2 text-on-surface-variant">
<span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
<span class="text-sm font-medium">TMA Preparation</span>
</div>
</div>
</div>
<!-- Class 12 Card -->
<div class="group relative overflow-hidden bg-surface-container-low/50 hover:bg-surface-container-lowest/80 transition-all duration-500 rounded-2xl p-8 border border-white/20">
<div class="flex justify-between items-start mb-6">
<div>
<h3 class="text-2xl font-bold text-on-background">Sr. Secondary (Class 12)</h3>
<p class="text-on-surface-variant">Advanced Science Track (PCB)</p>
</div>
<div class="text-right">
<div class="text-3xl font-bold text-primary">₹6,500</div>
<div class="text-xs font-bold tracking-widest text-outline uppercase">One-time Fee</div>
</div>
</div>
<div class="grid grid-cols-2 gap-4">
<div class="flex items-center gap-2 text-on-surface-variant">
<span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
<span class="text-sm font-medium">Full Registration</span>
</div>
<div class="flex items-center gap-2 text-on-surface-variant">
<span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
<span class="text-sm font-medium">Science Track (PCB)</span>
</div>
<div class="flex items-center gap-2 text-on-surface-variant">
<span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
<span class="text-sm font-medium">Study Resources</span>
</div>
<div class="flex items-center gap-2 text-on-surface-variant">
<span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
<span class="text-sm font-medium">Practical Guidance</span>
</div>
</div>
</div>
</div>
</div>
<!-- Additional Fees Bento -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
<div class="glass-panel p-8 rounded-3xl ambient-glow">
<div class="flex items-center gap-4 mb-6">
<div class="p-3 bg-primary/10 rounded-xl">
<span class="material-symbols-outlined text-primary" data-icon="payments">payments</span>
</div>
<h3 class="text-xl font-bold">Exam Fees</h3>
</div>
<div class="space-y-4">
<div class="flex justify-between items-center py-2 border-b border-outline-variant/10">
<span class="text-on-surface-variant font-medium">Theory Subject</span>
<span class="text-lg font-bold text-primary">₹300</span>
</div>
<div class="flex justify-between items-center py-2">
<span class="text-on-surface-variant font-medium">Practical Subject</span>
<span class="text-lg font-bold text-primary">₹150</span>
</div>
</div>
</div>
<div class="glass-panel p-8 rounded-3xl ambient-glow">
<div class="flex items-center gap-4 mb-6">
<div class="p-3 bg-secondary/10 rounded-xl">
<span class="material-symbols-outlined text-secondary" data-icon="swap_horiz">swap_horiz</span>
</div>
<h3 class="text-xl font-bold">TOC Fees</h3>
</div>
<div class="flex justify-between items-center py-2">
<div class="max-w-[150px]">
<span class="text-on-surface-variant font-medium">Transfer of Credit</span>
<p class="text-[10px] text-outline uppercase font-bold tracking-tighter">Per Subject</p>
</div>
<span class="text-3xl font-bold text-secondary">₹180</span>
</div>
</div>
</div>
                <!-- NIOS Enrollment Blocks & Exam Timelines -->
                <div class="glass-panel p-10 rounded-3xl ambient-glow">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="material-symbols-outlined text-primary text-3xl">calendar_month</span>
                        <h2 class="text-3xl font-bold tracking-tight text-on-background">NIOS Enrollment Blocks</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Block 1 Card -->
                        <div class="bg-surface-container-low/50 rounded-2xl p-6 border border-outline-variant/15 hover:bg-surface-container-lowest/80 transition-all duration-300">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="material-symbols-outlined text-primary text-2xl" style="font-variation-settings: 'FILL' 1;">calendar_today</span>
                                <h3 class="text-lg font-bold text-on-background">Block 1 Session</h3>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-outline">Admission Period</span>
                                    <p class="text-sm font-bold text-on-surface">March – September</p>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-outline">Exams Held</span>
                                    <p class="text-sm font-bold text-primary">April / May (Next Year)</p>
                                </div>
                            </div>
                        </div>

                        <!-- Block 2 Card -->
                        <div class="bg-surface-container-low/50 rounded-2xl p-6 border border-outline-variant/15 hover:bg-surface-container-lowest/80 transition-all duration-300">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="material-symbols-outlined text-secondary text-2xl" style="font-variation-settings: 'FILL' 1;">calendar_month</span>
                                <h3 class="text-lg font-bold text-on-background">Block 2 Session</h3>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-outline">Admission Period</span>
                                    <p class="text-sm font-bold text-on-surface">September – March</p>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-outline">Exams Held</span>
                                    <p class="text-sm font-bold text-secondary">October / November</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!-- Column 2: Late Fee Timeline (5 Columns) -->
<div class="lg:col-span-5 relative">
<div class="sticky top-28 glass-panel p-10 rounded-3xl ambient-glow overflow-hidden">
<!-- High-tech pattern overlay -->
<div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, #006479 1px, transparent 0); background-size: 24px 24px;"></div>
<div class="relative z-10">
<div class="flex items-center gap-3 mb-8">
<span class="material-symbols-outlined text-error" data-icon="schedule" style="font-variation-settings: 'FILL' 1;">schedule</span>
<h2 class="text-2xl font-bold tracking-tight">Late Fee Alert Timeline</h2>
</div>
<div class="relative space-y-10 pl-6">
<!-- Timeline line -->
<div class="absolute left-[7px] top-2 bottom-2 w-[2px] bg-gradient-to-b from-primary via-primary-container/50 to-error/20"></div>
<!-- Current Stage -->
<div class="relative">
<div class="absolute -left-[24px] top-1.5 w-4 h-4 rounded-full bg-primary ring-4 ring-primary/20"></div>
<div class="bg-surface-container-lowest p-5 rounded-2xl border border-primary/20 shadow-xl shadow-primary/5">
<p class="text-[10px] font-bold text-primary tracking-[0.2em] uppercase mb-1">Active Now</p>
<h4 class="text-lg font-bold text-on-background">Phase 0: Standard Admission</h4>
<p class="text-sm text-on-surface-variant">Final days for admission without late fee.</p>
<div class="mt-3 text-xl font-bold text-primary">₹0 Additional</div>
</div>
</div>
<!-- Phase 1 -->
<div class="relative">
<div class="absolute -left-[24px] top-1.5 w-4 h-4 rounded-full bg-surface-variant border-4 border-surface-bright"></div>
<div class="p-5 rounded-2xl border border-outline-variant/10 group hover:bg-surface-container-low transition-colors duration-300">
<p class="text-[10px] font-bold text-outline tracking-[0.2em] uppercase mb-1">Upcoming</p>
<h4 class="text-lg font-bold text-on-surface-variant">Phase 1 Delay</h4>
<div class="mt-2 text-xl font-bold text-on-background">+₹260</div>
</div>
</div>
<!-- Phase 2 -->
<div class="relative">
<div class="absolute -left-[24px] top-1.5 w-4 h-4 rounded-full bg-surface-variant border-4 border-surface-bright"></div>
<div class="p-5 rounded-2xl border border-outline-variant/10 group hover:bg-surface-container-low transition-colors duration-300">
<p class="text-[10px] font-bold text-outline tracking-[0.2em] uppercase mb-1">Delayed</p>
<h4 class="text-lg font-bold text-on-surface-variant">Phase 2 Extension</h4>
<div class="mt-2 text-xl font-bold text-on-background">+₹520</div>
</div>
</div>
<!-- Final Phase -->
<div class="relative">
<div class="absolute -left-[24px] top-1.5 w-4 h-4 rounded-full bg-error/30 border-4 border-surface-bright"></div>
<div class="p-5 rounded-2xl border border-error/10 bg-error-container/5">
<p class="text-[10px] font-bold text-error tracking-[0.2em] uppercase mb-1">Critical</p>
<h4 class="text-lg font-bold text-on-surface-variant">Final Extension Phase</h4>
<div class="mt-2 text-xl font-bold text-error">+₹910</div>
</div>
</div>
</div>
<a href="{{ route('register') }}" class="w-full mt-12 py-4 rounded-2xl signature-gradient text-on-primary font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all duration-300 flex items-center justify-center gap-2">
    Enroll Now
    <span class="material-symbols-outlined text-sm">arrow_forward_ios</span>
</a>
</div>
</div>
</div>
</section>
<!-- Visual Anchor Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-32">
<div class="relative min-h-[450px] lg:h-[400px] rounded-[2rem] sm:rounded-[3rem] overflow-hidden group">
<img alt="modern academic setting" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" data-alt="futuristic university library with glass walls soft sunlight architectural geometric lines and high-end modern aesthetic" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAMiJz5rZYrFZlpp4f1cXSIcLs5ynZBlGMI_yrd4maN3hLTmddNv6zi2cuFYZro6GC8hYC_PwCgSVZHvBms1hVJAdCQhYGavwXWrC-2OBHg6RSkuGBQv7JOL7jYC2MoAUAFOPJLso-KBD7Fm9UN1AqnYj_U37DyLLZO6Xvt672zebeikUSrUSS8X9958S5O1iLokbM0vjv_jfwffNRD73ZsQw1xLEW-EIBsa7V9NKhvsC4o_hqL9m8R_e3z4bCoe-XxXHpl7cfJRWc"/>
<div class="absolute inset-0 bg-gradient-to-r from-primary-dim/90 via-primary-dim/40 to-transparent flex items-center px-6 sm:px-12 lg:px-16 py-12 lg:py-0 z-10">
<div class="max-w-md">
<h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-on-primary mb-6 leading-tight">Your gateway to architectural and medical excellence starts here.</h2>
<p class="text-on-primary/80 mb-8 font-medium">Join 50,000+ students who have streamlined their path to higher education with Aether's thebasecampschool system.</p>
<div class="flex gap-4">
<div class="flex -space-x-3">
<img alt="user" class="w-10 h-10 rounded-full border-2 border-primary-dim" data-alt="professional portrait of a young student in a modern educational environment" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCigvjzqxogrmJLGLJRIfgl_-mcjYnt5Gj8YlBWGsebj1ClBmNi0CNMsqzTzi1J9f836q3d0OZQOqLT4pHS9V-e1oxOF1wFXXiBT_C7ZBz4iYYylRZnyTRXcgPwfka_X414JpoA_4ZjmgpOkPF2ovyGA6eS3P4A74PLRZTWqTTNJclGi1lazntIbTsFoLBwj2dndgoLVrj5pTEQUw9fFsEcTRyX9MhEubQKQHkNpF0WXEj5nws5AKkMW8lbh0ytlYcP-NptHwh5WRk"/>
<img alt="user" class="w-10 h-10 rounded-full border-2 border-primary-dim" data-alt="professional portrait of a student researcher with neutral background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAh3Tu1V0PkVfbawLd8XwTUlquqV1gN42UJlCtwAiBkcIITHI5SobLWAYM0auFAQuCyPOLqYuR8A273ZoJEenOzUSCplZPG45GsXsIqEFHle4sGinSSyZzU0WYR759ml6gITmKnWtjGmcFhIpR6jifyBjzO6qwfqhvoSAVL-h8BLQqJovnk-j0UBPr91kPXlSTGpv0OvWtIdqbOolAzF_3R2TLoWR6FPjsKFvqI9N5konwFRwUL-r6CTRXAoRsBHimEBsRxUB_c1Wo"/>
<img alt="user" class="w-10 h-10 rounded-full border-2 border-primary-dim" data-alt="close-up portrait of a cheerful female academic student" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAGHjGBpjlI8FMJ1LSjGIq8aMr4NMixiQsKYZimySMdj7iLfsX5rdT-kKXo-U4Lpzti1sT1pazUn0vPruqq0i6-U5e-GdXPj4MsMOp8oj7TsSJ6EBAFr3ZvwF1VtD1Mpc67LOJxfkeAmI2jJZqoc_DtwYaigHU5yBrDVx0rq3H1xflgV_H2xmJEJ-Pbys98Hr-EorAX06-irfUFsLLRW9AzcdCP3BOZ-44bWlM5qT_N7eiA1kC3CY-ter8aqcjtWq5G_Owib1UKmaU"/>
</div>
<span class="text-on-primary text-sm self-center font-bold">Trusted by global scholars</span>
</div>
</div>
</div>
</div>
</section>
</main>
<!-- Footer -->
@include('layouts.footer')
</body></html>
