<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Contact Us | thebasecampschool</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .signature-gradient {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .bg-mesh {
            background-color: #f2f7f9;
            background-image: 
                radial-gradient(at 0% 0%, rgba(64, 206, 243, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(0, 100, 121, 0.1) 0px, transparent 50%);
        }
    </style>
</head>
<body class="bg-mesh text-on-background min-h-screen">
@include('components.header-nav')
<main class="pt-24 pb-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto relative">
<!-- Floating Accent Blobs -->
<div class="absolute top-20 -left-20 w-96 h-96 bg-primary-container/20 rounded-full blur-[100px] -z-10"></div>
<div class="absolute bottom-0 -right-20 w-80 h-80 bg-tertiary-container/10 rounded-full blur-[100px] -z-10"></div>
<header class="mb-16 text-center md:text-left">
<span class="label-md uppercase tracking-[0.1em] text-primary font-bold mb-4 block">Get In Touch</span>
<h1 class="text-[clamp(2.25rem,6vw,4.5rem)] font-bold tracking-tight text-on-background mb-6">Contact <span class="text-primary">The Basecamp School</span> For Any Kind Of Support.</h1>
<p class="text-lg text-on-surface-variant max-w-2xl leading-relaxed">We provide atmospheric clarity for medical aspirants. Reach out through our ethereal channels for simulation support, course inquiries, or technical assistance.</p>
</header>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
<!-- Form Section -->
<div class="lg:col-span-7 glass-card p-6 sm:p-10 rounded-[2rem] shadow-[0_40px_60px_-15px_rgba(42,48,49,0.06)]">
<h2 class="text-3xl font-bold mb-8">Send a Message</h2>
<form class="space-y-6">
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="space-y-2">
<label class="label-md uppercase tracking-wider text-xs font-bold text-on-surface-variant px-1">Full Name</label>
<input class="w-full bg-surface-container-low/50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary/50 transition-all outline-none" placeholder="Dr. Jane Smith" type="text"/>
</div>
<div class="space-y-2">
<label class="label-md uppercase tracking-wider text-xs font-bold text-on-surface-variant px-1">Email Address</label>
<input class="w-full bg-surface-container-low/50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary/50 transition-all outline-none" placeholder="jane@medical.edu" type="email"/>
</div>
</div>
<div class="space-y-2">
<label class="label-md uppercase tracking-wider text-xs font-bold text-on-surface-variant px-1">Subject</label>
<select class="w-full bg-surface-container-low/50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary/50 transition-all outline-none">
<option>Exam Simulation Support</option>
<option>Course Access Issue</option>
<option>Billing &amp; Accreditation</option>
<option>General Inquiry</option>
</select>
</div>
<div class="space-y-2">
<label class="label-md uppercase tracking-wider text-xs font-bold text-on-surface-variant px-1">Message</label>
<textarea class="w-full bg-surface-container-low/50 border-none rounded-xl p-4 focus:ring-2 focus:ring-primary/50 transition-all outline-none resize-none" placeholder="How can our Atmospheric Clarity System assist you today?" rows="5"></textarea>
</div>
<button class="w-full signature-gradient text-on-primary py-4 rounded-xl font-bold text-lg shadow-lg shadow-primary-fixed-dim/20 active:scale-[0.99] transition-transform">
                        Dispatch Message
                    </button>
</form>
</div>
<!-- Side Info Cards -->
<div class="lg:col-span-5 space-y-8">
<!-- WhatsApp Integrated Card -->
<div class="glass-card p-8 rounded-[2rem] relative overflow-hidden group">
<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-8xl">chat</span>
</div>
<h3 class="text-2xl font-bold mb-2">WhatsApp Support</h3>
<p class="text-on-surface-variant mb-6">Instant response for medical aspirants on the go.</p>
<a class="inline-flex items-center gap-3 bg-emerald-500 text-white px-6 py-3 rounded-full font-bold hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-500/20" href="https://wa.me/1234567890">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">chat_bubble</span>
                        Chat on WhatsApp
                    </a>
</div>
<!-- Office Location / Map -->
<div class="glass-card p-2 rounded-[2rem] overflow-hidden">
<div class="relative h-64 w-full rounded-[1.8rem] overflow-hidden">
<img class="w-full h-full object-cover" data-alt="minimalist aesthetic map of central london medical district with soft blue markers and translucent overlays" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCwWuUouRvbLDKAkn7462noB6zP5WqVeUyiDnb5O1_YZrkYT7oLeXqaK5qC-KZcTGgh4NO9y0DluHq4PRUbiFaa0iPQxnP6TWWTh385Ibqi21ntg29dVv7klRx9xcSo5jSiG7TkxP-Alf4kShZG4odBP8xM0aUicibQpMBETEvfJ73WhQdT9IrCGADn6H4R2IxN7qquokO_SS_za69LkANomhfhozBB8Z0uA1_n7ZBiRLin6QDemZV5K7Byj-km5ZoiI5UWsIOEODI"/>
<div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
<div class="absolute bottom-4 left-4 text-white">
<p class="font-bold">Medical Plaza, Level 4</p>
<p class="text-sm opacity-90">Harley St, London, UK</p>
</div>
<div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md p-3 rounded-2xl">
<span class="material-symbols-outlined text-primary">location_on</span>
</div>
</div>
<div class="p-6">
<div class="flex justify-between items-center mb-4">
<span class="label-md font-bold text-primary">OFFICE LOCATION</span>
<a class="text-sm font-medium text-cyan-600 flex items-center gap-1 hover:underline" href="#">
                                Get Directions <span class="material-symbols-outlined text-xs">north_east</span>
</a>
</div>
<p class="text-on-surface-variant leading-relaxed">
                            Visit our Atmospheric Clarity Hub for in-person medical board registry consultations and simulation walkthroughs.
                        </p>
</div>
</div>
<!-- Hours & Direct Contact -->
<div class="glass-card p-8 rounded-[2rem]">
<div class="flex items-center gap-4 mb-6">
<div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center">
<span class="material-symbols-outlined text-primary">schedule</span>
</div>
<div>
<h4 class="font-bold text-lg">Operational Hours</h4>
<p class="text-sm text-on-surface-variant">Medical Aspirant Standard Time</p>
</div>
</div>
<div class="space-y-3">
<div class="flex justify-between items-center p-3 rounded-xl bg-surface-container-low/40">
<span class="font-medium text-on-surface">Mon — Fri</span>
<span class="text-primary font-bold">08:00 - 20:00</span>
</div>
<div class="flex justify-between items-center p-3 rounded-xl bg-surface-container-low/40">
<span class="font-medium text-on-surface">Sat — Sun</span>
<span class="text-primary font-bold">10:00 - 16:00</span>
</div>
</div>
<div class="mt-8 pt-8 border-t border-on-surface/5">
<div class="flex items-center gap-3 text-on-surface-variant">
<span class="material-symbols-outlined text-primary">mail</span>
<a class="hover:text-primary transition-colors" href="mailto:support@peakperformance.com">support@peakperformance.com</a>
</div>
</div>
</div>
</div>
</div>
</main>
<!-- Footer -->
@include('layouts.footer')
</body></html>
