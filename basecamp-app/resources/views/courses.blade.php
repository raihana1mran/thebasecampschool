<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          "colors": {
                  "on-primary-fixed-variant": "#004a5a",
                  "secondary": "#006572",
                  "on-background": "#2a3031",
                  "tertiary-fixed-dim": "#65a4ff",
                  "surface-variant": "#d6dee1",
                  "surface-dim": "#cdd6d9",
                  "on-error-container": "#570008",
                  "on-secondary-fixed-variant": "#005f6b",
                  "tertiary-fixed": "#80b2ff",
                  "secondary-fixed": "#96e6f6",
                  "on-tertiary-fixed-variant": "#003971",
                  "on-tertiary-fixed": "#001835",
                  "outline-variant": "#a8aeb0",
                  "inverse-primary": "#40cef3",
                  "on-primary-container": "#00414f",
                  "error": "#b31b25",
                  "primary-container": "#40cef3",
                  "on-secondary-container": "#005560",
                  "background": "#f2f7f9",
                  "outline": "#72787a",
                  "on-secondary-fixed": "#004049",
                  "on-secondary": "#d8f8ff",
                  "on-primary": "#e0f6ff",
                  "surface-tint": "#006479",
                  "surface-container-low": "#ecf2f4",
                  "secondary-fixed-dim": "#88d8e7",
                  "surface-container-high": "#dce4e6",
                  "primary": "#006479",
                  "tertiary-container": "#80b2ff",
                  "surface": "#f2f7f9",
                  "primary-dim": "#00576a",
                  "secondary-container": "#96e6f6",
                  "tertiary-dim": "#004f98",
                  "surface-container": "#e3e9ec",
                  "primary-fixed": "#40cef3",
                  "surface-container-lowest": "#ffffff",
                  "tertiary": "#005bae",
                  "on-tertiary-container": "#003061",
                  "on-surface-variant": "#575c5e",
                  "error-dim": "#9f0519",
                  "error-container": "#fb5151",
                  "inverse-on-surface": "#989ea0",
                  "primary-fixed-dim": "#28c0e4",
                  "on-tertiary": "#eff2ff",
                  "surface-container-highest": "#d6dee1",
                  "on-error": "#ffefee",
                  "surface-bright": "#f2f7f9",
                  "on-primary-fixed": "#002a34",
                  "secondary-dim": "#005863",
                  "inverse-surface": "#0a0f11",
                  "on-surface": "#2a3031"
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
    .glass-card {
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(24px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .signature-gradient {
      background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
    }
    .tonal-transition-no-lines {
      border: none !important;
    }
  </style>
</head>
<body class="text-on-background bg-background min-h-screen">
@include('components.header-nav')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
<!-- Hero Section -->
<section class="relative min-h-[716px] flex flex-col justify-center items-center text-center mb-24 overflow-hidden rounded-[3rem]">
<div class="absolute inset-0 z-0">
<img class="w-full h-full object-cover opacity-80" data-alt="Microscopic view of crystalline structures with ethereal blue lighting and glowing particles in a 3D medical environment" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCyRpjsy9AqKNBGZhBzjZxa8Ks2a7dxt2hptyy684F10h7m_kVLXd5mL472GgOlcdGFqmFeHvFIptYICNgxd3H8P_XLDwG1xwoSJykhyQl_OCU7FicyFfsATikdDTyejss7wYf541ri4bqkGoA-3s_QlpMKbp79eE6wHSUuQtQgs6og7mdeb6o6KXIXsZljpfNBfW9ioztPOfgEUKbwyN5A-HdxEqq8i0fn4xqaz7nx_nwKubZ7NVR_LwDxggYIh0Ddpi7AY9hpMTQ"/>
<div class="absolute inset-0 bg-gradient-to-b from-transparent via-background/20 to-background"></div>
</div>
<div class="relative z-10 space-y-6 max-w-4xl px-4">
<span class="inline-block px-4 py-1.5 glass-card rounded-full text-primary font-bold tracking-widest text-[10px] uppercase border border-primary/20">thebasecampschool</span>
<h1 class="text-[clamp(2.5rem,7vw,5rem)] font-black tracking-tighter text-on-background leading-none">
          The <span class="text-transparent bg-clip-text signature-gradient">Science</span><br/>Specialist
        </h1>
<p class="text-on-surface-variant text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
          The thebasecampschool of medical sciences. Mastering the foundations of life, matter, and motion through atmospheric clarity and precision.
        </p>
<div class="flex flex-wrap justify-center gap-4 pt-8">
<a href="{{ url('/admissions') }}" class="signature-gradient text-on-primary px-8 py-4 rounded-xl font-bold flex items-center gap-3 group transition-all duration-500">
    Start Enrolling
    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
</a>
<a href="{{ url('/downloads') }}" class="glass-card px-8 py-4 rounded-xl font-bold flex items-center gap-3 border border-outline-variant/15 hover:bg-white/60 transition-all">
    View Syllabus
    <span class="material-symbols-outlined">download</span>
</a>
</div>
</div>
</section>
<!-- Subject Deep-Dive (Bento-ish Grid) -->
<section class="mb-32">
<div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
<div>
<h2 class="text-4xl font-bold tracking-tight mb-2">Subject Deep-Dive</h2>
<p class="text-on-surface-variant">Three pillars of the medical entrance curriculum</p>
</div>
<div class="h-0.5 flex-1 mx-8 bg-surface-container-high opacity-50 hidden md:block"></div>
<div class="text-label-md font-bold text-primary tracking-widest uppercase">Curriculum 2024</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<!-- Physics Card -->
<div class="glass-card p-8 rounded-[2.5rem] relative group overflow-hidden hover:shadow-2xl transition-all duration-700">
<div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-8xl" data-icon="physics">science</span>
</div>
<div class="mb-12 inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary/10 text-primary">
<span class="material-symbols-outlined text-3xl" data-icon="precision_manufacturing">precision_manufacturing</span>
</div>
<span class="block text-xs font-black text-primary/60 tracking-widest uppercase mb-2">Subject Code: 312</span>
<h3 class="text-3xl font-bold mb-4">Physics</h3>
<p class="text-on-surface-variant leading-relaxed mb-8">Focus on core mechanics and electronics designed specifically for medical entrance aptitude.</p>
<ul class="space-y-4">
<li class="flex items-center gap-3 text-sm font-medium">
<span class="material-symbols-outlined text-primary text-lg" data-icon="check_circle" data-weight="fill">check_circle</span>
              Quantum Mechanics
            </li>
<li class="flex items-center gap-3 text-sm font-medium">
<span class="material-symbols-outlined text-primary text-lg" data-icon="check_circle" data-weight="fill">check_circle</span>
              Medical Electronics
            </li>
</ul>
</div>
<!-- Chemistry Card -->
<div class="glass-card p-8 rounded-[2.5rem] relative group overflow-hidden hover:shadow-2xl transition-all duration-700 md:-translate-y-6">
<div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-8xl" data-icon="chemistry">science</span>
</div>
<div class="mb-12 inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-secondary/10 text-secondary">
<span class="material-symbols-outlined text-3xl" data-icon="experiment">experiment</span>
</div>
<span class="block text-xs font-black text-secondary/60 tracking-widest uppercase mb-2">Subject Code: 313</span>
<h3 class="text-3xl font-bold mb-4">Chemistry</h3>
<p class="text-on-surface-variant leading-relaxed mb-8">Mastering organic mechanisms and inorganic foundations with molecular precision.</p>
<ul class="space-y-4">
<li class="flex items-center gap-3 text-sm font-medium">
<span class="material-symbols-outlined text-secondary text-lg" data-icon="check_circle" data-weight="fill">check_circle</span>
              Organic Pathways
            </li>
<li class="flex items-center gap-3 text-sm font-medium">
<span class="material-symbols-outlined text-secondary text-lg" data-icon="check_circle" data-weight="fill">check_circle</span>
              Inorganic Grids
            </li>
</ul>
</div>
<!-- Biology Card -->
<div class="glass-card p-8 rounded-[2.5rem] relative group overflow-hidden hover:shadow-2xl transition-all duration-700">
<div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-8xl" data-icon="biology">science</span>
</div>
<div class="mb-12 inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-tertiary/10 text-tertiary">
<span class="material-symbols-outlined text-3xl" data-icon="biotechnology">biotech</span>
</div>
<span class="block text-xs font-black text-tertiary/60 tracking-widest uppercase mb-2">Subject Code: 314</span>
<h3 class="text-3xl font-bold mb-4">Biology</h3>
<p class="text-on-surface-variant leading-relaxed mb-8">Dominant weightage focusing on complex human physiology and genetics evolution.</p>
<div class="flex items-center gap-4 p-4 bg-white/40 rounded-2xl border border-white/20">
<div class="text-3xl font-black text-primary">80%</div>
<div class="text-[10px] leading-tight font-bold uppercase text-on-surface-variant">Core Syllabus<br/>Weightage</div>
</div>
</div>
</div>
</section>
<!-- Assessment & Practicals -->
<section class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-32">
<div class="space-y-12">
<h2 class="text-[clamp(2rem,5vw,3rem)] font-black tracking-tighter leading-tight">Evaluation &amp; <br/><span class="text-primary">Hands-on Mastery</span></h2>
<div class="space-y-8">
<div class="flex gap-6 group">
<div class="w-14 h-14 shrink-0 rounded-2xl bg-white shadow-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
<span class="material-symbols-outlined text-primary" data-icon="assignment">assignment</span>
</div>
<div>
<h4 class="text-xl font-bold mb-1">TMA Weightage</h4>
<p class="text-on-surface-variant leading-relaxed">Secure 20% of your total marks through internal assessments. We provide expertly solved assignments to ensure top-tier performance.</p>
</div>
</div>
<div class="flex gap-6 group">
<div class="w-14 h-14 shrink-0 rounded-2xl bg-white shadow-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
<span class="material-symbols-outlined text-primary" data-icon="science">science</span>
</div>
<div>
<h4 class="text-xl font-bold mb-1">Practical Lab Sessions</h4>
<p class="text-on-surface-variant leading-relaxed">Guided manual preparation for mandatory medical exams. Hands-on training in state-of-the-art simulation labs.</p>
</div>
</div>
</div>
</div>
<div class="relative p-4 md:p-8">
<div class="absolute -top-12 -left-12 w-64 h-64 bg-primary/20 rounded-full blur-[100px] -z-10"></div>
<div class="absolute -bottom-12 -right-12 w-64 h-64 bg-tertiary/20 rounded-full blur-[100px] -z-10"></div>
<div class="glass-card rounded-[3rem] overflow-hidden p-2 shadow-2xl">
<img class="w-full aspect-[4/5] object-cover rounded-[2.5rem]" data-alt="Modern medical laboratory with clean white aesthetics, featuring high-tech microscopes and holographic data displays floating in the air" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBSqu4cvYHzkvUb97uwnnRDUWPc-9xxSi9gAh5PC_-rDZiXGWmkpNGzLEhbLjKc3Pzalf6ZmyC3Zx6kg5sPlcsgHLFUlL5mHopTsfZE-5BSZhOVT_jkFyz6yIJqcNnDlJJ_0voZSVzt6mCRCx5TVoC851gHZvrJZK7SoQm8pn2IM93l-jJuTh9GgUkzunQ1cztQb6cWt5P_8-dIaJd2_v7xo1MPgLuUmMGYriHRVmkTGmP5z5XyCk4XV-muPSin-nGtz0y8FRVdZeg"/>
<div class="absolute bottom-12 left-12 right-12 glass-card p-6 rounded-3xl border border-white/40">
<div class="flex items-center justify-between">
<div>
<p class="text-[10px] font-black uppercase text-primary tracking-widest mb-1">Next Session</p>
<h5 class="text-lg font-bold">Practical Anatomy Lab</h5>
</div>
<div class="bg-primary text-on-primary px-3 py-1 rounded-full text-xs font-bold">LIVE</div>
</div>
</div>
</div>
</div>
</section>
<!-- Stats Section -->
<section class="glass-card rounded-[2rem] sm:rounded-[4rem] p-6 sm:p-12 md:p-20 mb-32 text-center">
<div class="grid grid-cols-2 md:grid-cols-4 gap-12">
<div>
<div class="text-4xl md:text-6xl font-black text-on-background mb-2">12k+</div>
<div class="text-xs font-bold uppercase text-on-surface-variant tracking-widest">Medical Students</div>
</div>
<div>
<div class="text-4xl md:text-6xl font-black text-on-background mb-2">94%</div>
<div class="text-xs font-bold uppercase text-on-surface-variant tracking-widest">Pass Rate</div>
</div>
<div>
<div class="text-4xl md:text-6xl font-black text-on-background mb-2">450+</div>
<div class="text-xs font-bold uppercase text-on-surface-variant tracking-widest">Lab Hours</div>
</div>
<div>
<div class="text-4xl md:text-6xl font-black text-on-background mb-2">24/7</div>
<div class="text-xs font-bold uppercase text-on-surface-variant tracking-widest">Expert Support</div>
</div>
</div>
</section>
</main>
<!-- Footer Shell -->
@include('layouts.footer')
</body></html>
