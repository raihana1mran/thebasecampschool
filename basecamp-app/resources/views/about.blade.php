<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>About Us | thebasecampschool</title>
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
        body { font-family: 'Space Grotesk', sans-serif; background-color: #f2f7f9; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .signature-gradient {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
        }
        .text-glow {
            text-shadow: 0 0 20px rgba(64, 206, 243, 0.3);
        }
        .floating-blob {
            position: absolute;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.4;
        }
    </style>
</head>
<body class="text-on-background selection:bg-primary-container selection:text-on-primary-container">
<!-- Background Blobs -->
<div class="floating-blob w-[500px] h-[500px] bg-primary-container top-[-100px] left-[-100px] rounded-full"></div>
<div class="floating-blob w-[400px] h-[400px] bg-tertiary-container bottom-[-100px] right-[-100px] rounded-full"></div>
@include('components.header-nav')
<main class="pt-24 pb-20 px-4 sm:px-6 lg:px-8 max-w-screen-2xl mx-auto overflow-x-hidden">
<!-- Hero Section -->
<section class="relative mb-32">
<div class="grid lg:grid-cols-2 gap-16 items-center">
<div class="z-10">
<label class="label-md tracking-[0.15em] font-bold text-primary mb-4 block uppercase">The Atmospheric Clarity System</label>
<h1 class="text-[clamp(2.5rem,7vw,5rem)] font-bold tracking-tight text-on-background mb-8 leading-[0.9]">
                        Beyond the <br/><span class="text-transparent bg-clip-text signature-gradient">Threshold.</span>
</h1>
<p class="text-xl text-on-surface-variant max-w-lg leading-relaxed mb-10">
                        thebasecampschool isn't just a learning platform. It's a precision-engineered bridge for NIOS students aiming for the elite 195+ medical cutoff.
                    </p>
<div class="flex flex-wrap gap-4">
<a href="{{ url('/admissions') }}" class="signature-gradient text-on-primary px-8 py-4 rounded-xl font-bold shadow-lg shadow-primary/20 flex items-center gap-2">
    <span class="material-symbols-outlined text-sm">how_to_reg</span>
    Start Admission
</a>
</div>
</div>
<div class="relative">
<div class="glass-panel rounded-[2.5rem] p-4 rotate-3 transform shadow-2xl relative overflow-hidden">
<img alt="Medical visualization" class="rounded-[2rem] w-full h-[500px] object-cover" data-alt="3D abstract medical diagram of human DNA structure rendered in glass and frosted crystal with soft cyan lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBU2VKmpDgMP-0IomEMBHcqegDjiucoQ7QmexizSSTlXHUv-sKQdYZ_7pLk5wPiPeeP36UqcXuzgIXikTGTtWtMrBbc_jx7veDamNW7UsVcHst8TG8U46mf--wcicZDy5DoQVwFZIM-kEv1eOyMZkYoZvGQbvKD3PDn1kFJ5wFj7182sD0ASwXtRlxBinPOe9OyrsKE_G0Bqk_WFoFiyr88NWsYqgHfsUehGGdCdgbCCj3DzB9V1FzcQ36N_eOVpizRH-PMCl4EuDk"/>
<div class="absolute inset-0 bg-gradient-to-t from-primary/20 to-transparent"></div>
</div>
<!-- Asymmetric Floating Card -->
<div class="absolute -bottom-10 -left-10 glass-panel p-8 rounded-2xl shadow-xl max-w-xs border border-white/50 backdrop-blur-3xl">
<div class="flex items-center gap-4 mb-4">
<span class="material-symbols-outlined text-primary text-4xl" data-weight="fill">medical_services</span>
<div class="text-3xl font-bold text-on-background">195+</div>
</div>
<div class="text-sm font-medium text-on-surface-variant tracking-wide">THE MEDICAL ELITE CUTOFF TARGET</div>
</div>
</div>
</div>
</section>
<!-- Mission & Vision Bento Grid -->
<section class="mb-32">
<div class="grid md:grid-cols-12 gap-6">
<!-- Mission Card -->
<div class="md:col-span-7 glass-panel p-12 rounded-[2.5rem] flex flex-col justify-between relative overflow-hidden">
<div class="relative z-10">
<span class="material-symbols-outlined text-primary text-5xl mb-6">target</span>
<h2 class="text-4xl font-bold mb-6 tracking-tight">Our Mission</h2>
<p class="text-lg text-on-surface-variant leading-relaxed">
                            We exist to solve the "Science Paradox" for NIOS students. While others focus on mere completion, we focus on the **195+ Medical Cutoff**. Our curriculum is stripped of academic noise, laser-focused on the PCB (Physics, Chemistry, Biology) core required for India's top medical colleges.
                        </p>
</div>
<div class="mt-12 flex items-center gap-4 text-primary font-bold z-10">
<span>LEARN MORE ABOUT OUR TARGETING</span>
<span class="material-symbols-outlined">arrow_right_alt</span>
</div>
<!-- Abstract Background Graphic -->
<div class="absolute right-[-50px] bottom-[-50px] opacity-10">
<span class="material-symbols-outlined text-[300px]" style="font-variation-settings: 'FILL' 1;">biotech</span>
</div>
</div>
<!-- Vision Card -->
<div class="md:col-span-5 bg-surface-container-high/40 backdrop-blur-xl p-12 rounded-[2.5rem] border border-white/20">
<span class="material-symbols-outlined text-tertiary text-5xl mb-6">visibility</span>
<h2 class="text-4xl font-bold mb-6 tracking-tight">Our Vision</h2>
<p class="text-lg text-on-surface-variant leading-relaxed mb-8">
                        To redefine NIOS as the premium choice for future doctors. We envision a world where NIOS students lead the ranks in NEET, backed by the structural clarity of the thebasecampschool System.
                    </p>
<div class="space-y-4">
<div class="flex items-center gap-3 glass-panel p-4 rounded-xl">
<span class="material-symbols-outlined text-primary">check_circle</span>
<span class="font-medium text-sm">Democratizing Medical Entry</span>
</div>
<div class="flex items-center gap-3 glass-panel p-4 rounded-xl">
<span class="material-symbols-outlined text-primary">check_circle</span>
<span class="font-medium text-sm">Eliminating Admin Complexity</span>
</div>
</div>
</div>
</div>
</section>
<!-- Support Model (The Process) -->
<section class="mb-32">
<div class="text-center mb-16">
<label class="label-md tracking-[0.2em] font-bold text-primary mb-4 block uppercase">Precision Management</label>
<h2 class="text-5xl font-bold tracking-tight">The 360° Support Model</h2>
</div>
<div class="grid md:grid-cols-3 gap-8">
<!-- Step 1 -->
<div class="glass-panel p-10 rounded-[2rem] border-t-4 border-primary hover:translate-y-[-8px] transition-all duration-500">
<div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mb-8">
<span class="material-symbols-outlined text-primary text-3xl">description</span>
</div>
<h3 class="text-2xl font-bold mb-4">Documentation &amp; TMA</h3>
<p class="text-on-surface-variant leading-relaxed">
                        We handle the entire NIOS bureaucracy. From Tutor Marked Assignments (TMAs) to registration, our experts ensure your documentation is flawless.
                    </p>
</div>
<!-- Step 2 -->
<div class="glass-panel p-10 rounded-[2rem] border-t-4 border-primary hover:translate-y-[-8px] transition-all duration-500">
<div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mb-8">
<span class="material-symbols-outlined text-primary text-3xl">science</span>
</div>
<h3 class="text-2xl font-bold mb-4">Practical Excellence</h3>
<p class="text-on-surface-variant leading-relaxed">
                        Integrated lab guides and practical record-keeping support. We ensure your internal marks contribute maximally to your aggregate score.
                    </p>
</div>
<!-- Step 3 -->
<div class="glass-panel p-10 rounded-[2rem] border-t-4 border-primary hover:translate-y-[-8px] transition-all duration-500">
<div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mb-8">
<span class="material-symbols-outlined text-primary text-3xl">psychology</span>
</div>
<h3 class="text-2xl font-bold mb-4">Core PCB Mastery</h3>
<p class="text-on-surface-variant leading-relaxed">
                        With admin stress removed, you spend 100% of your energy on Physics, Chemistry, and Biology—the three pillars of your medical future.
                    </p>
</div>
</div>
</section>
<!-- Decorative Section with Asymmetry -->
<section class="relative glass-panel rounded-[2rem] sm:rounded-[3rem] p-6 sm:p-12 md:p-24 overflow-hidden mb-32">
<div class="absolute top-0 right-0 w-1/2 h-full opacity-20 pointer-events-none">
<img alt="Laboratory atmosphere" class="w-full h-full object-cover" data-alt="Modern high-tech medical laboratory with bright clinical lighting, microscopic glass slides, and translucent blue containers" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA5naYeyznWUt8IQpb83TdZaxEYtNj0MVFL0qEFwsRLKxJ-hiSAVxVeuRZww8jIyGLezcOHnQ7xDLASE05_sBMN_MaW7k8QUijO0j4k2rS4kZX1FXelU44IVQkGK76oG2piMPToe5e2OgLNsqWnNZgyMS7v5jv_scZwcDPYzs_ypNv6zl2-9fGhAo6G6-Cd22NfLfWZtCuOXs5q_YeThbUy3pJcQHHFTeXKM4tYXlJrvIUygZG_moCv2Uw0wS6ZSlu3c7eOF3kA79M"/>
</div>
<div class="relative z-10 max-w-2xl">
<h2 class="text-[clamp(2rem,5vw,3.75rem)] font-bold mb-8 leading-tight">Your medical seat starts with <span class="text-primary">thebasecampschool.</span></h2>
<p class="text-xl text-on-surface-variant mb-12">
                    Join the ranks of students who bypassed the traditional struggle and focused solely on what matters: The Cutoff.
                </p>
<a href="{{ url('/admissions') }}" class="inline-block signature-gradient text-on-primary px-10 py-5 rounded-2xl font-bold text-lg shadow-xl shadow-primary/30 active:scale-95 transition-all">
    Register for Admission
</a>
</div>
</section>
</main>
<!-- Footer -->
@include('layouts.footer')
</body></html>
