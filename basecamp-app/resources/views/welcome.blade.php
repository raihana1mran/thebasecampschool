<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>The Basecamp School | NIOS Open School — Affordable, Flexible & Recognized</title>
<meta name="description" content="Study 10th & 12th via NIOS with The Basecamp School. Affordable fees, personalized subjects, valid for NEET/JEE, flexible learning, and expert support. Admissions Open 2026."/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
  tailwind.config = {
    darkMode: "class",
    theme: {
      extend: {
        "colors": {
          "tertiary-fixed": "#80b2ff","surface-bright": "#f2f7f9","on-secondary-fixed-variant": "#005f6b",
          "tertiary-fixed-dim": "#65a4ff","surface": "#f2f7f9","primary": "#006479",
          "outline-variant": "#a8aeb0","surface-container-lowest": "#ffffff","on-secondary": "#d8f8ff",
          "inverse-on-surface": "#989ea0","on-primary-fixed": "#002a34","surface-container-high": "#dce4e6",
          "tertiary": "#005bae","tertiary-container": "#80b2ff","secondary-fixed-dim": "#88d8e7",
          "surface-dim": "#cdd6d9","surface-container-low": "#ecf2f4","surface-container-highest": "#d6dee1",
          "surface-tint": "#006479","primary-fixed": "#40cef3","on-error": "#ffefee",
          "on-surface-variant": "#575c5e","on-primary": "#e0f6ff","inverse-primary": "#40cef3",
          "inverse-surface": "#0a0f11","secondary-dim": "#005863","secondary-fixed": "#96e6f6",
          "secondary-container": "#96e6f6","on-tertiary": "#eff2ff","on-tertiary-fixed-variant": "#003971",
          "tertiary-dim": "#004f98","error-dim": "#9f0519","primary-dim": "#00576a",
          "surface-container": "#e3e9ec","on-tertiary-container": "#003061","on-secondary-container": "#005560",
          "on-primary-fixed-variant": "#004a5a","on-primary-container": "#00414f","on-tertiary-fixed": "#001835",
          "primary-container": "#40cef3","on-error-container": "#570008","primary-fixed-dim": "#28c0e4",
          "on-surface": "#2a3031","outline": "#72787a","secondary": "#006572",
          "error-container": "#fb5151","error": "#b31b25","on-secondary-fixed": "#004049",
          "background": "#f2f7f9","surface-variant": "#d6dee1"
        },
        "borderRadius": {"DEFAULT": "0.25rem","lg": "0.5rem","xl": "1.5rem","full": "9999px"},
        "fontFamily": {"headline": ["Space Grotesk"],"display": ["Space Grotesk"],"body": ["Space Grotesk"],"label": ["Space Grotesk"]}
      },
    },
  }
</script>
<style>
  body { font-family: 'Space Grotesk', sans-serif; scroll-behavior: smooth; }
  .glass-panel { background: rgba(255,255,255,0.85); backdrop-filter: blur(24px); border: 1px solid rgba(255,255,255,0.35); }
  .glass-dark { background: rgba(0,100,121,0.08); backdrop-filter: blur(20px); border: 1px solid rgba(0,100,121,0.12); }
  .signature-gradient { background: linear-gradient(135deg, #006479 0%, #00a8c8 60%, #40cef3 100%); }
  .text-gradient { background: linear-gradient(135deg, #006479 0%, #40cef3 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
  .floating { animation: floating 6s ease-in-out infinite; }
@media (max-width: 1023px) { .floating { animation: none; } }
  @keyframes floating { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-18px)} }
  .card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
  .card-hover:hover { transform: translateY(-6px); box-shadow: 0 20px 60px rgba(0,100,121,0.12); }
  .tag-pill { background: linear-gradient(135deg, rgba(0,100,121,0.1), rgba(64,206,243,0.1)); border: 1px solid rgba(0,100,121,0.15); }
  .benefit-line::before { content: ''; display: block; width: 3px; height: 100%; background: linear-gradient(180deg,#006479,#40cef3); border-radius: 4px; position: absolute; left: 0; top: 0; }
  .shimmer { background: linear-gradient(90deg,#f2f7f9 25%,#e3e9ec 50%,#f2f7f9 75%); background-size: 200% 100%; animation: shimmer 2s infinite; }
  @keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }
  .material-symbols-outlined { font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24; }
  .icon-filled { font-variation-settings:'FILL' 1,'wght' 500,'GRAD' 0,'opsz' 24; }
  @keyframes fadeInUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
  .animate-in { animation: fadeInUp 0.7s ease both; }

  .glass-card { background: rgba(255,255,255,0.72); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.3); }
  .glass-card-strong { background: rgba(255,255,255,0.88); backdrop-filter: blur(32px); -webkit-backdrop-filter: blur(32px); border: 1px solid rgba(255,255,255,0.4); }
  .glass-card-dark { background: rgba(0,100,121,0.06); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(0,100,121,0.08); }

  .icon-spin { animation: icon-spin 3s linear infinite; }
  .icon-bounce { animation: icon-bounce 2s ease-in-out infinite; }
  .icon-pulse { animation: icon-pulse 2s ease-in-out infinite; }
  .icon-float { animation: icon-float 3s ease-in-out infinite; }
  .icon-shake { animation: icon-shake 0.5s ease-in-out infinite; }
  .icon-glow { filter: drop-shadow(0 0 8px currentColor); }

  @keyframes icon-spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
  @keyframes icon-bounce { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
  @keyframes icon-pulse { 0%,100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.15); opacity: 0.8; } }
  @keyframes icon-float { 0%,100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-8px) rotate(3deg); } }
  @keyframes icon-shake { 0%,100% { transform: rotate(0deg); } 25% { transform: rotate(-8deg); } 75% { transform: rotate(8deg); } }

  [data-aos] { opacity: 0; transition: opacity 0.7s ease, transform 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
  [data-aos].aos-animate { opacity: 1; transform: translateY(0) translateX(0) scale(1); }
  [data-aos="fade-up"] { transform: translateY(40px); }
  [data-aos="fade-down"] { transform: translateY(-40px); }
  [data-aos="fade-left"] { transform: translateX(-40px); }
  [data-aos="fade-right"] { transform: translateX(40px); }
  [data-aos="scale-up"] { transform: scale(0.85); }
  [data-aos="fade-up-scale"] { transform: translateY(40px) scale(0.92); }
  [data-aos="zoom-in"] { transform: scale(0.7); }

  .hover-lift { transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease; }
  .hover-lift:hover { transform: translateY(-8px); box-shadow: 0 24px 48px rgba(0,100,121,0.15); }
  .hover-glow:hover { box-shadow: 0 0 30px rgba(64,206,243,0.3); }
  .hover-expand { transition: transform 0.3s ease; }
  .hover-expand:hover { transform: scale(1.03); }
  .btn-shine { position: relative; overflow: hidden; }
  .btn-shine::after { content: ''; position: absolute; top: -50%; left: -60%; width: 40%; height: 200%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent); transform: rotate(25deg); transition: left 0.6s ease; }
  .btn-shine:hover::after { left: 120%; }
  .group-hover\:scale-110:hover .group-hover-child { transform: scale(1.1); }

  .fee-scroll-track { animation: fee-scroll 24s linear infinite; }
  .fee-scroll-track:hover { animation-play-state: paused; }
  @keyframes fee-scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

  .features-scroll-track { animation: features-scroll 30s linear infinite; }
  .features-scroll-track:hover { animation-play-state: paused; }
  @keyframes features-scroll { 0% { transform: translateX(-50%); } 100% { transform: translateX(0); } }
</style>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('aos-animate');
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });
    document.querySelectorAll('[data-aos]').forEach(function(el) { observer.observe(el); });
  });
</script>
</head>
<body class="bg-surface text-on-surface min-h-screen flex flex-col selection:bg-primary-container selection:text-on-primary-container">

<!-- Background Blobs -->
<div class="fixed inset-0 overflow-hidden -z-10 pointer-events-none">
  <div class="absolute -top-[15%] -left-[10%] w-[45%] h-[45%] bg-primary-container/20 rounded-full blur-[100px] md:blur-[140px]"></div>
  <div class="absolute top-[35%] -right-[8%] w-[35%] h-[35%] bg-tertiary-container/15 rounded-full blur-[80px] md:blur-[110px]"></div>
  <div class="hidden sm:block absolute -bottom-[12%] left-[15%] w-[55%] h-[45%] bg-secondary-fixed/12 rounded-full blur-[120px] md:blur-[160px]"></div>
</div>

@include('components.header-nav')

<!-- ============================================================
     HERO SECTION
     ============================================================ -->
<main class="flex-grow flex items-center pt-16 pb-8" id="home">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

      <!-- Hero Content -->
      <div class="space-y-8 animate-in" data-aos="fade-right">
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full tag-pill text-primary font-bold text-xs tracking-[0.2em] uppercase">
          <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
          Admissions Open · 2026–27
        </span>
        <h1 class="text-[clamp(2.4rem,6.5vw,4.5rem)] font-black tracking-tighter leading-[1.08]">
          Learn Your Way,<br>
          <span class="text-gradient">Grow Your Future</span>
        </h1>
        <p class="text-lg text-on-surface-variant leading-relaxed max-w-xl">
          The Basecamp School makes <strong class="text-on-surface font-bold">NIOS 10th &amp; 12th</strong> education affordable, flexible, and future-ready — with personalized subjects, expert mentors, and recognition for NEET, JEE &amp; beyond.
        </p>
        <!-- Key Badges -->
        <div class="flex flex-wrap gap-3">
          <span class="flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-full text-xs font-bold" data-aos="fade-up" data-aos-delay="100">
            <span class="material-symbols-outlined text-sm icon-filled">verified</span> NIOS Recognized Board
          </span>
          <span class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 border border-blue-200 text-blue-700 rounded-full text-xs font-bold" data-aos="fade-up" data-aos-delay="200">
            <span class="material-symbols-outlined text-sm icon-filled">science</span> Valid for NEET &amp; JEE
          </span>
          <span class="flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 border border-amber-200 text-amber-700 rounded-full text-xs font-bold" data-aos="fade-up" data-aos-delay="300">
            <span class="material-symbols-outlined text-sm icon-filled">payments</span> Affordable Fees
          </span>
        </div>
        <div class="flex flex-wrap gap-4">
          <a class="signature-gradient text-white px-8 py-4 rounded-full font-bold text-base shadow-xl shadow-primary/25 hover:scale-105 active:scale-95 transition-all flex items-center gap-2 btn-shine" href="{{ route('register') }}">
            <span class="material-symbols-outlined icon-bounce">school</span>
            Apply Now
          </a>
          <a class="bg-white/70 backdrop-blur-sm px-8 py-4 rounded-full font-bold text-base border border-white/50 hover:bg-white/90 hover:scale-105 transition-all flex items-center gap-2 text-on-surface" href="#features">
            Learn More
            <span class="material-symbols-outlined icon-bounce">arrow_downward</span>
          </a>
        </div>
      </div>

      <!-- Hero Stats Card -->
      <div class="relative" data-aos="fade-left" data-aos-delay="200">
        <div class="absolute inset-0 signature-gradient rounded-3xl blur-3xl opacity-15"></div>
        <div class="relative glass-card-strong rounded-3xl p-4 sm:p-6 md:p-8 shadow-2xl shadow-primary/10 hover-lift">
          <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="h-20 rounded-2xl bg-primary/10 flex flex-col items-center justify-center gap-1" data-aos="fade-up" data-aos-delay="100">
              <span class="material-symbols-outlined text-2xl text-primary icon-filled icon-float">biotech</span>
              <span class="text-[10px] font-bold text-primary uppercase tracking-wider">NEET</span>
            </div>
            <div class="h-20 rounded-2xl bg-tertiary/10 flex flex-col items-center justify-center gap-1" data-aos="fade-up" data-aos-delay="200">
              <span class="material-symbols-outlined text-2xl text-tertiary icon-filled icon-float">calculate</span>
              <span class="text-[10px] font-bold text-tertiary uppercase tracking-wider">JEE</span>
            </div>
            <div class="h-20 rounded-2xl bg-secondary/10 flex flex-col items-center justify-center gap-1" data-aos="fade-up" data-aos-delay="300">
              <span class="material-symbols-outlined text-2xl text-secondary icon-filled icon-float">menu_book</span>
              <span class="text-[10px] font-bold text-secondary uppercase tracking-wider">NIOS</span>
            </div>
          </div>
          <div class="space-y-3">
            <div class="flex justify-between items-center p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/10" data-aos="fade-left" data-aos-delay="100">
              <span class="text-sm font-semibold text-on-surface-variant">Active Students</span>
              <span class="text-xl font-black text-primary">2,450+</span>
            </div>
            <div class="flex justify-between items-center p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/10" data-aos="fade-left" data-aos-delay="200">
              <span class="text-sm font-semibold text-on-surface-variant">Subject Choices</span>
              <span class="text-xl font-black text-primary">30+</span>
            </div>
            <div class="flex justify-between items-center p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/10" data-aos="fade-left" data-aos-delay="300">
              <span class="text-sm font-semibold text-on-surface-variant">Pass Rate</span>
              <span class="text-xl font-black text-emerald-600">98.5%</span>
            </div>
            <div class="flex justify-between items-center p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/10" data-aos="fade-left" data-aos-delay="400">
              <span class="text-sm font-semibold text-on-surface-variant">Min. Fees (Annual)</span>
              <span class="text-xl font-black text-primary">₹3,999+</span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</main>

<!-- ============================================================
     WHY BASECAMP — FEATURES STRIP
     ============================================================ -->
<section class="py-6 bg-primary/5 border-y border-primary/10 overflow-hidden" id="features">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="features-scroll-track flex gap-10 w-max">
      @foreach([
        ['payments','Affordable Fees'],
        ['headset_mic','24/7 Support'],
        ['schedule','Flexible Timing'],
        ['tune','Personalized Subjects'],
        ['biotech','NEET / JEE Valid'],
        ['verified','NIOS Certified'],
      ] as [$icon, $label])
      <div class="flex items-center gap-3 text-primary font-bold text-base shrink-0 hover-expand">
        <span class="material-symbols-outlined text-xl icon-filled icon-bounce">{{ $icon }}</span>
        {{ $label }}
      </div>
      @endforeach
      @foreach([
        ['payments','Affordable Fees'],
        ['headset_mic','24/7 Support'],
        ['schedule','Flexible Timing'],
        ['tune','Personalized Subjects'],
        ['biotech','NEET / JEE Valid'],
        ['verified','NIOS Certified'],
      ] as [$icon, $label])
      <div class="flex items-center gap-3 text-primary font-bold text-base shrink-0 hover-expand">
        <span class="material-symbols-outlined text-xl icon-filled icon-bounce">{{ $icon }}</span>
        {{ $label }}
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- ============================================================
     AFFORDABLE FEES SECTION
     ============================================================ -->
<section class="pt-16 pb-24" id="fees">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
      <!-- Content -->
      <div data-aos="fade-right">
        <span class="inline-block text-primary font-bold text-xs tracking-[0.2em] uppercase mb-4">Affordable Fees</span>
        <h2 class="text-3xl sm:text-3xl sm:text-4xl md:text-5xl font-black tracking-tighter mb-6">Quality Education<br><span class="text-gradient">Without the Price Tag</span></h2>
        <p class="text-on-surface-variant text-lg leading-relaxed mb-8">
          We believe financial constraints should never stop a student from pursuing their dreams. The Basecamp School offers <strong class="text-on-surface">India's most affordable NIOS coaching</strong> — transparent pricing, zero hidden charges, and EMI-friendly options.
        </p>
        <div class="space-y-4 mb-8">
          @foreach([
            ['check_circle','One-time registration, no recurring surprises'],
            ['check_circle','Government scholarship & fee waiver guidance'],
            ['check_circle','Instalment-friendly fee structure available'],
            ['check_circle','Free digital study materials included'],
            ['check_circle','No exam centre travel costs — online tests'],
          ] as [$icon, $point])
          <div class="flex items-center gap-3 text-sm font-medium text-on-surface" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
            <span class="material-symbols-outlined text-emerald-500 icon-filled text-lg">{{ $icon }}</span>
            {{ $point }}
          </div>
          @endforeach
        </div>
        <a href="{{ route('admissions.public') }}" class="inline-flex items-center gap-2 signature-gradient text-white px-7 py-3.5 rounded-full font-bold text-sm shadow-lg shadow-primary/20 hover:scale-105 transition-all btn-shine">
          <span class="material-symbols-outlined text-sm icon-pulse">payments</span> Check Fee Structure
        </a>
      </div>
      <!-- Fee Cards -->
      <div class="overflow-hidden" data-aos="fade-left">
        <div class="fee-scroll-track flex gap-5 w-max">
          @foreach([
            ['10th Grade','Secondary','₹5,500','/ year','primary','school','Most Popular'],
            ['12th Grade','Sr. Secondary','₹6,500','/ year','tertiary','auto_stories','All Streams'],
            ['Science PCB','For NEET Prep','₹6,500','/ year','secondary','biotech','NEET Valid'],
            ['Science PCM','For JEE Prep','₹6,500','/ year','secondary','calculate','JEE Valid'],
          ] as [$title,$sub,$price,$per,$color,$icon,$badge])
          <div class="glass-card rounded-2xl p-6 card-hover hover-lift relative overflow-hidden shrink-0 w-[220px] sm:w-[240px]">
            <div class="absolute top-3 right-3">
              <span class="px-2 py-0.5 rounded-full bg-{{ $color }}/10 text-{{ $color }} text-[10px] font-bold border border-{{ $color }}/20">{{ $badge }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-{{ $color }}/10 flex items-center justify-center mb-4 group">
              <span class="material-symbols-outlined text-{{ $color }} icon-filled icon-float group-hover:scale-110 transition-transform">{{ $icon }}</span>
            </div>
            <h3 class="font-black text-on-surface text-lg leading-tight">{{ $title }}</h3>
            <p class="text-xs text-on-surface-variant font-medium mb-3">{{ $sub }}</p>
            <div class="flex items-baseline gap-1">
              <span class="text-2xl font-black text-{{ $color }}">{{ $price }}</span>
              <span class="text-xs text-on-surface-variant font-medium">{{ $per }}</span>
            </div>
          </div>
          @endforeach
          @foreach([
            ['10th Grade','Secondary','₹5,500','/ year','primary','school','Most Popular'],
            ['12th Grade','Sr. Secondary','₹6,500','/ year','tertiary','auto_stories','All Streams'],
            ['Science PCB','For NEET Prep','₹6,500','/ year','secondary','biotech','NEET Valid'],
            ['Science PCM','For JEE Prep','₹6,500','/ year','secondary','calculate','JEE Valid'],
          ] as [$title,$sub,$price,$per,$color,$icon,$badge])
          <div class="glass-card rounded-2xl p-6 card-hover hover-lift relative overflow-hidden shrink-0 w-[220px] sm:w-[240px]">
            <div class="absolute top-3 right-3">
              <span class="px-2 py-0.5 rounded-full bg-{{ $color }}/10 text-{{ $color }} text-[10px] font-bold border border-{{ $color }}/20">{{ $badge }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-{{ $color }}/10 flex items-center justify-center mb-4 group">
              <span class="material-symbols-outlined text-{{ $color }} icon-filled icon-float group-hover:scale-110 transition-transform">{{ $icon }}</span>
            </div>
            <h3 class="font-black text-on-surface text-lg leading-tight">{{ $title }}</h3>
            <p class="text-xs text-on-surface-variant font-medium mb-3">{{ $sub }}</p>
            <div class="flex items-baseline gap-1">
              <span class="text-2xl font-black text-{{ $color }}">{{ $price }}</span>
              <span class="text-xs text-on-surface-variant font-medium">{{ $per }}</span>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     CUSTOMER SUPPORT SECTION
     ============================================================ -->
<section class="pt-16 pb-24 bg-white/40 backdrop-blur-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16" data-aos="fade-up">
      <span class="inline-block text-primary font-bold text-xs tracking-[0.2em] uppercase mb-4">Customer Support</span>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tighter mb-4">We're Always<br><span class="text-gradient">Here for You</span></h2>
      <p class="text-on-surface-variant text-lg max-w-2xl mx-auto">From enrollment to exam day, our dedicated support team is available round the clock to guide every student and parent.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach([
        ['headset_mic','24/7 Chat Support','Chat with our mentors anytime — no waiting queues, instant answers to your queries.','primary'],
        ['call','Phone Helpline','Call our dedicated student helpline during business hours for detailed guidance.','tertiary'],
        ['mail','Email Support','Get detailed written responses within 2 hours for all academic and admin queries.','secondary'],
        ['groups','Personal Mentor','Every student gets a personal academic mentor assigned from Day 1.','primary'],
      ] as [$icon,$title,$desc,$color])
      <div class="glass-card rounded-2xl p-5 sm:p-7 card-hover hover-lift text-center" data-aos="fade-up-scale">
        <div class="w-14 h-14 rounded-2xl bg-{{ $color }}/10 flex items-center justify-center mx-auto mb-5 group">
          <span class="material-symbols-outlined text-2xl text-{{ $color }} icon-filled icon-bounce group-hover:scale-125 transition-transform">{{ $icon }}</span>
        </div>
        <h3 class="font-black text-on-surface text-lg mb-2">{{ $title }}</h3>
        <p class="text-sm text-on-surface-variant leading-relaxed">{{ $desc }}</p>
      </div>
      @endforeach
    </div>
    <!-- Support Hours Banner -->
    <div class="mt-12 rounded-2xl signature-gradient p-5 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 text-white" data-aos="fade-up">
      <div data-aos="fade-right">
        <h3 class="text-2xl font-black tracking-tight mb-1">Need Help Right Now?</h3>
        <p class="opacity-90 text-sm">Our support team responds in under 5 minutes during active hours.</p>
      </div>
      <div class="flex flex-wrap gap-6 text-center">
        <div data-aos="zoom-in" data-aos-delay="100"><p class="text-3xl font-black">24/7</p><p class="text-xs opacity-80 uppercase tracking-wider">Chat Support</p></div>
        <div data-aos="zoom-in" data-aos-delay="200"><p class="text-3xl font-black">&lt; 5 min</p><p class="text-xs opacity-80 uppercase tracking-wider">Response Time</p></div>
        <div data-aos="zoom-in" data-aos-delay="300"><p class="text-3xl font-black">99%</p><p class="text-xs opacity-80 uppercase tracking-wider">Satisfaction Rate</p></div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     FLEXIBLE LEARNING SECTION
     ============================================================ -->
<section class="pt-16 pb-24">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
      <!-- Visual -->
      <div class="relative order-2 lg:order-1" data-aos="fade-right">
        <div class="absolute inset-0 signature-gradient rounded-3xl blur-3xl opacity-10"></div>
        <div class="relative glass-card-strong rounded-3xl p-4 sm:p-6 md:p-8 shadow-xl hover-lift">
          <h4 class="font-black text-on-surface text-lg mb-6 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary icon-filled">schedule</span>
            Your Study Schedule — Your Rules
          </h4>
          <div class="space-y-3">
            @foreach([
              ['6 AM – 8 AM','Morning Revision','primary',80],
              ['10 AM – 12 PM','Live Doubt Session','tertiary',60],
              ['2 PM – 4 PM','Self-Study / TMA','secondary',90],
              ['7 PM – 9 PM','Video Lectures','primary',70],
              ['Anytime','Practice Tests','tertiary',100],
            ] as [$time,$label,$color,$pct])
            <div class="flex items-center gap-4" data-aos="fade-right" data-aos-delay="{{ $loop->index * 80 }}">
              <div class="w-28 text-right text-xs font-bold text-on-surface-variant shrink-0">{{ $time }}</div>
              <div class="flex-1">
                <div class="flex items-center justify-between mb-1">
                  <span class="text-xs font-bold text-on-surface">{{ $label }}</span>
                </div>
                <div class="h-2 bg-surface-container rounded-full overflow-hidden">
                  <div class="h-full bg-{{ $color }} rounded-full" style="width:{{ $pct }}%"></div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          <div class="mt-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center gap-3" data-aos="fade-up" data-aos-delay="400">
            <span class="material-symbols-outlined text-emerald-600 icon-filled icon-pulse">check_circle</span>
            <p class="text-xs font-bold text-emerald-700">No rigid class timings. Study at your own pace, from anywhere in India.</p>
          </div>
        </div>
      </div>
      <!-- Content -->
      <div class="order-1 lg:order-2" data-aos="fade-left">
        <span class="inline-block text-primary font-bold text-xs tracking-[0.2em] uppercase mb-4">Flexible Learning</span>
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tighter mb-6">Study on Your<br><span class="text-gradient">Own Schedule</span></h2>
        <p class="text-on-surface-variant text-lg leading-relaxed mb-8">
          Whether you're a working student, a homemaker, or re-appearing — The Basecamp School fits your life. NIOS allows <strong class="text-on-surface">On-Demand Examination (ODE)</strong>, meaning you can appear for exams when you're ready.
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          @foreach([
            ['home','Study from Home','No daily commute. Learn from any device, anywhere.'],
            ['video_library','Recorded Lectures','Re-watch any lecture unlimited times — no pressure.'],
            ['quiz','Attempt Exams When Ready','NIOS ODE lets you appear 3 times a year — April, October, January.'],
            ['wifi','Online + Offline','Download materials and study even without the internet.'],
          ] as [$icon,$title,$desc])
          <div class="p-4 rounded-2xl bg-white/60 backdrop-blur-sm border border-white/50 card-hover hover-lift" data-aos="fade-up-scale">
            <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center mb-3 group">
              <span class="material-symbols-outlined text-primary text-sm icon-filled icon-bounce group-hover:scale-125 transition-transform">{{ $icon }}</span>
            </div>
            <h4 class="font-bold text-on-surface text-sm mb-1">{{ $title }}</h4>
            <p class="text-xs text-on-surface-variant leading-relaxed">{{ $desc }}</p>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     PERSONALIZED SUBJECTS SECTION
     ============================================================ -->
<section class="pt-16 pb-24 bg-white/40 backdrop-blur-sm" id="programs">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16" data-aos="fade-up">
      <span class="inline-block text-primary font-bold text-xs tracking-[0.2em] uppercase mb-4">Personalized Subjects</span>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tighter mb-4">You Choose<br><span class="text-gradient">Your Subjects</span></h2>
      <p class="text-on-surface-variant text-lg max-w-2xl mx-auto">NIOS gives you the freedom to pick from 30+ subjects. Mix and match to build your ideal academic profile — no stream restrictions.</p>
    </div>
    <!-- Subject Groups -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
      <!-- Science -->
      <div class="glass-card rounded-2xl p-5 sm:p-8 card-hover hover-lift" data-aos="fade-up" data-aos-delay="0">
        <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center mb-5 group">
          <span class="material-symbols-outlined text-3xl text-primary icon-filled icon-float group-hover:scale-110 transition-transform">biotech</span>
        </div>
        <h3 class="text-2xl font-black tracking-tight mb-3">Science</h3>
        <p class="text-on-surface-variant text-sm mb-5">Ideal for NEET, JEE, engineering, and medical aspirants.</p>
        <div class="flex flex-wrap gap-2 mb-6">
          @foreach(['Physics','Chemistry','Biology','Mathematics','Computer Science','Biotechnology'] as $sub)
          <span class="px-2.5 py-1 bg-primary/8 text-primary border border-primary/15 rounded-full text-xs font-bold">{{ $sub }}</span>
          @endforeach
        </div>
        <a class="inline-flex items-center gap-2 text-primary font-bold text-sm hover:underline" href="{{ route('register') }}">Enroll in Science <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
      </div>
      <!-- Commerce -->
      <div class="glass-card rounded-2xl p-5 sm:p-8 card-hover hover-lift" data-aos="fade-up" data-aos-delay="100">
        <div class="w-14 h-14 rounded-2xl bg-tertiary/10 flex items-center justify-center mb-5 group">
          <span class="material-symbols-outlined text-3xl text-tertiary icon-filled icon-float group-hover:scale-110 transition-transform">trending_up</span>
        </div>
        <h3 class="text-2xl font-black tracking-tight mb-3">Commerce</h3>
        <p class="text-on-surface-variant text-sm mb-5">Perfect for CA, MBA, finance, and entrepreneurship pathways.</p>
        <div class="flex flex-wrap gap-2 mb-6">
          @foreach(['Accountancy','Business Studies','Economics','Mathematics','Banking','Taxation'] as $sub)
          <span class="px-2.5 py-1 bg-tertiary/8 text-tertiary border border-tertiary/15 rounded-full text-xs font-bold">{{ $sub }}</span>
          @endforeach
        </div>
        <a class="inline-flex items-center gap-2 text-tertiary font-bold text-sm hover:underline" href="{{ route('register') }}">Enroll in Commerce <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
      </div>
      <!-- Arts -->
      <div class="glass-card rounded-2xl p-5 sm:p-8 card-hover hover-lift" data-aos="fade-up" data-aos-delay="200">
        <div class="w-14 h-14 rounded-2xl bg-secondary/10 flex items-center justify-center mb-5 group">
          <span class="material-symbols-outlined text-3xl text-secondary icon-filled icon-float group-hover:scale-110 transition-transform">palette</span>
        </div>
        <h3 class="text-2xl font-black tracking-tight mb-3">Arts / Humanities</h3>
        <p class="text-on-surface-variant text-sm mb-5">For law, civil services, journalism, and creative pursuits.</p>
        <div class="flex flex-wrap gap-2 mb-6">
          @foreach(['History','Political Science','Geography','Sociology','Psychology','English'] as $sub)
          <span class="px-2.5 py-1 bg-secondary/8 text-secondary border border-secondary/15 rounded-full text-xs font-bold">{{ $sub }}</span>
          @endforeach
        </div>
        <a class="inline-flex items-center gap-2 text-secondary font-bold text-sm hover:underline" href="{{ route('register') }}">Enroll in Arts <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
      </div>
    </div>
    <!-- Mix & Match Banner -->
    <div class="glass-card rounded-2xl p-5 sm:p-7 flex flex-col md:flex-row items-center gap-5 sm:gap-6 border border-primary/10 hover-lift" data-aos="fade-up-scale">
      <div class="w-14 h-14 rounded-2xl signature-gradient flex items-center justify-center shrink-0 group">
        <span class="material-symbols-outlined text-white text-2xl icon-filled icon-spin group-hover:scale-125 transition-transform">tune</span>
      </div>
      <div class="flex-1">
        <h3 class="font-black text-on-surface text-xl mb-1">Mix Subjects Across Streams</h3>
        <p class="text-on-surface-variant text-sm">NIOS uniquely allows you to combine subjects from Science + Commerce + Arts — for example, take Biology with Business Studies. Build a profile tailored to YOUR goals.</p>
      </div>
      <a href="{{ route('register') }}" class="shrink-0 signature-gradient text-white px-6 py-3 rounded-full font-bold text-sm shadow-md hover:scale-105 hover-glow transition-all btn-shine" data-aos="zoom-in">
        Design My Course
      </a>
    </div>
  </div>
</section>

<!-- ============================================================
     NEET & JEE VALIDITY SECTION
     ============================================================ -->
<section class="pt-16 pb-24">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
      <!-- Content -->
      <div data-aos="fade-right">
        <span class="inline-block text-primary font-bold text-xs tracking-[0.2em] uppercase mb-4">NEET &amp; JEE Validity</span>
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tighter mb-6">NIOS is Fully Valid<br><span class="text-gradient">for NEET &amp; JEE</span></h2>
        <p class="text-on-surface-variant text-lg leading-relaxed mb-8">
          A common myth — busted. NIOS (National Institute of Open Schooling) certificates are <strong class="text-on-surface">100% accepted by NTA</strong> for both NEET and JEE eligibility. Thousands of NIOS students qualify every year.
        </p>
        <div class="space-y-5">
          @foreach([
            ['biotech','NEET Eligibility','NIOS 12th with Physics, Chemistry &amp; Biology qualifies you to appear for NEET-UG. No restrictions.','emerald'],
            ['calculate','JEE Eligibility','NIOS 12th with Physics, Chemistry &amp; Mathematics meets JEE Main &amp; Advanced criteria fully.','blue'],
            ['gavel','Government Recognised','NIOS is a government board under the Ministry of Education — equivalent to CBSE &amp; state boards.','amber'],
            ['person_check','College Admissions','NIOS certificates are accepted by all central and state universities, IITs, NITs, and AIIMS.','purple'],
          ] as [$icon,$title,$desc,$c])
          <div class="flex gap-4 p-5 rounded-2xl bg-{{ $c }}-50 border border-{{ $c }}-100 card-hover hover-lift" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
            <div class="w-10 h-10 rounded-xl bg-{{ $c }}-100 flex items-center justify-center shrink-0 mt-0.5 group">
              <span class="material-symbols-outlined text-{{ $c }}-600 icon-filled text-lg icon-pulse group-hover:scale-125 transition-transform">{{ $icon }}</span>
            </div>
            <div>
              <h4 class="font-black text-on-surface text-sm mb-1">{{ $title }}</h4>
              <p class="text-xs text-on-surface-variant leading-relaxed">{!! $desc !!}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <!-- Stats Visual -->
      <div class="relative" data-aos="fade-left">
        <div class="absolute inset-0 signature-gradient rounded-3xl blur-3xl opacity-10"></div>
        <div class="relative glass-panel rounded-3xl p-4 sm:p-6 md:p-8 shadow-xl">
          <h4 class="font-black text-on-surface text-lg mb-2 text-center">NIOS Students Clearing Competitive Exams</h4>
          <p class="text-center text-xs text-on-surface-variant mb-8">Nationally recognised performance data</p>
          <div class="grid grid-cols-2 gap-5">
            @foreach([
              ['biotech','NEET Qualifiers','primary','12,000+','From NIOS Background'],
              ['calculate','JEE Qualifiers','tertiary','8,500+','From NIOS Background'],
              ['emoji_events','Top College Seats','secondary','95%','Acceptance Rate'],
              ['school','NIOS Pass Rate','primary','98.5%','Nationwide Average'],
            ] as [$icon,$label,$color,$number,$sub])
            <div class="text-center p-5 rounded-2xl bg-surface-container-low border border-outline-variant/10" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 80 }}">
              <span class="material-symbols-outlined text-{{ $color }} text-2xl icon-filled block mb-2 icon-bounce">{{ $icon }}</span>
              <p class="text-2xl font-black text-{{ $color }} mb-0.5">{{ $number }}</p>
              <p class="text-xs font-bold text-on-surface leading-tight">{{ $label }}</p>
              <p class="text-[10px] text-on-surface-variant mt-0.5">{{ $sub }}</p>
            </div>
            @endforeach
          </div>
          <div class="mt-6 p-4 rounded-2xl signature-gradient text-white text-center" data-aos="fade-up" data-aos-delay="400">
            <p class="text-sm font-bold">🏆 NIOS + The Basecamp School = Your Competitive Edge</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     NIOS BOARD BENEFITS SECTION
     ============================================================ -->
<section class="pt-16 pb-24 bg-white/40 backdrop-blur-sm" id="nios-benefits">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16" data-aos="fade-up">
      <span class="inline-block text-primary font-bold text-xs tracking-[0.2em] uppercase mb-4">NIOS Board Benefits</span>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tighter mb-4">Why NIOS with<br><span class="text-gradient">The Basecamp School?</span></h2>
      <p class="text-on-surface-variant text-lg max-w-2xl mx-auto">NIOS (National Institute of Open Schooling) is India's largest open schooling board — offering unmatched advantages over conventional boards.</p>
    </div>
    <!-- Benefits Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
      @foreach([
        ['emoji_events','Grade Improvement','Failed in regular board? NIOS lets you transfer previous marks and improve with fresh attempts — no year wasted.','primary'],
        ['calendar_month','Exam 3× a Year','Appear in April/May, October/November, or January — choose when you\'re ready, not when the board decides.','tertiary'],
        ['assignment_turned_in','Credit Transfer (TOC)','Transfer of Credits: use your best subject marks from previous boards. Combine CBSE &amp; NIOS scores.','secondary'],
        ['support_agent','Personal Contact Programme','NIOS PCPs are live sessions where tutors explain key concepts — included in your Basecamp School fee.','primary'],
        ['diversity_3','For Everyone','Dropouts, working professionals, special needs students, homemakers — NIOS has no age bar.','tertiary'],
        ['workspace_premium','Govt. Scholarships','NIOS students qualify for SC/ST/OBC scholarships and National Means-cum-Merit Scholarship.','secondary'],
        ['psychology','Reduced Exam Stress','Attempt one subject at a time if needed. No pressure to clear all 5 subjects in one go.','primary'],
        ['language','English + Regional','Study in your preferred language — Hindi, English, or regional medium options available.','tertiary'],
        ['military_tech','Board Equivalence','NIOS certificates are equivalent to CBSE, ICSE, and all state boards — accepted globally.','secondary'],
      ] as [$icon,$title,$desc,$color])
      <div class="glass-card rounded-2xl p-4 sm:p-6 card-hover hover-lift" data-aos="fade-up-scale">
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 rounded-2xl bg-{{ $color }}/10 group-hover:bg-{{ $color }}/20 flex items-center justify-center shrink-0 transition-colors group">
            <span class="material-symbols-outlined text-{{ $color }} icon-filled icon-bounce group-hover:scale-125 transition-transform" style="animation-delay: calc(0.1s * {{ $loop->index ?? 0 }})">{{ $icon }}</span>
          </div>
          <div>
            <h3 class="font-black text-on-surface text-base mb-2">{{ $title }}</h3>
            <p class="text-sm text-on-surface-variant leading-relaxed">{!! $desc !!}</p>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- NIOS vs Regular Board Comparison -->
    <div class="glass-card-strong rounded-3xl overflow-hidden shadow-xl hover-lift" data-aos="fade-up">
      <div class="px-8 py-6 border-b border-outline-variant/15">
        <h3 class="font-black text-on-surface text-xl text-center">NIOS vs. Regular Board</h3>
        <p class="text-center text-sm text-on-surface-variant mt-1">See why thousands choose NIOS through The Basecamp School</p>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-surface-container-low/60">
            <tr>
              <th class="text-left px-6 py-4 text-xs font-extrabold uppercase tracking-widest text-on-surface-variant">Feature</th>
              <th class="px-6 py-4 text-xs font-extrabold uppercase tracking-widest text-primary text-center">NIOS + Basecamp</th>
              <th class="px-6 py-4 text-xs font-extrabold uppercase tracking-widest text-on-surface-variant text-center">Regular Board</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-outline-variant/8">
            @foreach([
              ['Exam Timing Flexibility','3 times a year','Once a year only'],
              ['Subject Choices','30+ subjects, any combo','Fixed stream subjects'],
              ['Age Bar for Admission','No age limit','Typically up to 18–20'],
              ['Repeat Attempt Cost','Only failed subjects','All subjects again'],
              ['Study from Home','Yes, fully supported','Mandatory attendance'],
              ['NEET / JEE Valid','Yes, fully recognised','Yes'],
              ['Credit Transfer (TOC)','Yes','No'],
              ['Exam Stress','Low — attempt when ready','High — one chance/year'],
              ['Fee Structure','Highly affordable','Moderate to high'],
            ] as [$feature,$nios,$regular])
            <tr class="hover:bg-surface-container-low/30 transition-colors" data-aos="fade-left" data-aos-delay="{{ $loop->index * 50 }}">
              <td class="px-6 py-4 text-sm font-semibold text-on-surface">{{ $feature }}</td>
              <td class="px-6 py-4 text-center">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">
                  <span class="material-symbols-outlined text-sm icon-filled">check_circle</span> {{ $nios }}
                </span>
              </td>
              <td class="px-6 py-4 text-center text-sm text-on-surface-variant font-medium">{{ $regular }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     TESTIMONIALS / TRUST STRIP
     ============================================================ -->
<section class="py-16 bg-primary/5 border-y border-primary/8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10" data-aos="fade-up">
      <span class="inline-block text-primary font-bold text-xs tracking-[0.2em] uppercase mb-3">Student Stories</span>
      <h2 class="text-3xl font-black tracking-tighter">What Our Students Say</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @foreach([
        ['Anjali Sharma','12th Science · NEET Qualifier','I studied PCB through NIOS via Basecamp School and cleared NEET in my first attempt! The flexible timing let me self-study without pressure.','AS'],
        ['Ravi Kumar','10th Grade · Repeat Candidate','I had failed 10th from regular board. NIOS gave me another chance and Basecamp School\'s mentors guided me step by step. I scored 82%!','RK'],
        ['Priya Nair','12th Commerce · CA Aspirant','The personalized subject selection was a game changer. I combined Economics + Maths from different streams. Highly recommend Basecamp!','PN'],
      ] as [$name,$tag,$quote,$initials])
      <div class="glass-card rounded-2xl p-5 sm:p-7 card-hover hover-lift" data-aos="fade-up-scale">
        <div class="flex items-center gap-3 mb-4">
          <div class="w-11 h-11 rounded-full signature-gradient flex items-center justify-center text-white font-black text-sm">{{ $initials }}</div>
          <div>
            <p class="font-black text-on-surface text-sm">{{ $name }}</p>
            <p class="text-xs text-primary font-bold">{{ $tag }}</p>
          </div>
        </div>
        <p class="text-sm text-on-surface-variant leading-relaxed italic">"{{ $quote }}"</p>
        <div class="flex gap-0.5 mt-4">
          @for($i=0;$i<5;$i++)
          <span class="material-symbols-outlined text-amber-400 text-sm icon-filled" data-aos="zoom-in" data-aos-delay="{{ $i * 100 }}">star</span>
          @endfor
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- ============================================================
     CTA SECTION
     ============================================================ -->
<section class="pt-16 pb-24">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="signature-gradient rounded-2xl sm:rounded-3xl p-6 sm:p-10 lg:p-16 text-center text-white relative overflow-hidden hover-lift" data-aos="fade-up">
      <!-- Decorative circles -->
      <div class="absolute -top-16 -right-16 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
      <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-white/8 rounded-full blur-2xl pointer-events-none"></div>
      <div class="relative">
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 text-white font-bold text-xs tracking-[0.2em] uppercase mb-6" data-aos="fade-up" data-aos-delay="100">
          <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
          Limited Seats · Enroll Before They Fill
        </span>
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tighter mb-4" data-aos="fade-up" data-aos-delay="200">Ready to Begin<br>Your Journey?</h2>
        <p class="text-xl opacity-90 mb-2 max-w-xl mx-auto" data-aos="fade-up" data-aos-delay="300">Join 2,450+ students building their futures through NIOS with The Basecamp School.</p>
        <p class="text-sm opacity-75 mb-10 max-w-lg mx-auto" data-aos="fade-up" data-aos-delay="400">Affordable fees · Flexible learning · Personalized subjects · Valid for NEET &amp; JEE</p>
        <div class="flex flex-wrap gap-4 justify-center">
          <a class="bg-white text-primary px-10 py-4 rounded-full font-bold text-lg shadow-2xl hover:scale-105 active:scale-95 transition-all flex items-center gap-2 btn-shine" href="{{ route('register') }}">
            <span class="material-symbols-outlined icon-filled icon-bounce">school</span>
            Apply Now
          </a>
          <a class="bg-white/15 backdrop-blur-sm border border-white/30 text-white px-8 py-4 rounded-full font-bold text-base hover:bg-white/25 hover:scale-105 active:scale-95 transition-all flex items-center gap-2" href="{{ route('courses') }}">
            Browse Courses
            <span class="material-symbols-outlined">arrow_forward</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

@include('layouts.footer')
</body>
</html>