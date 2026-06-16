<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Mocktest Passed - thebasecampschool</title>
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
                        "primary-fixed-dim": "#28c0e4",
                        "on-secondary-container": "#005560",
                        "on-error-container": "#570008",
                        "secondary-fixed": "#96e6f6",
                        "secondary-dim": "#005863",
                        "surface-variant": "#d6dee1",
                        "tertiary-container": "#80b2ff",
                        "on-background": "#2a3031",
                        "on-tertiary-container": "#003061",
                        "on-secondary-fixed": "#004049",
                        "surface-container-lowest": "#ffffff",
                        "background": "#f2f7f9",
                        "surface-bright": "#f2f7f9",
                        "secondary-container": "#96e6f6",
                        "primary-container": "#40cef3",
                        "tertiary-dim": "#004f98",
                        "surface-container": "#e3e9ec",
                        "primary-dim": "#00576a",
                        "tertiary-fixed": "#80b2ff",
                        "inverse-surface": "#0a0f11",
                        "outline-variant": "#a8aeb0",
                        "on-primary-fixed": "#002a34",
                        "on-primary-container": "#00414f",
                        "primary-fixed": "#40cef3",
                        "secondary": "#006572",
                        "on-secondary-fixed-variant": "#005f6b",
                        "on-error": "#ffefee",
                        "outline": "#72787a",
                        "on-primary-fixed-variant": "#004a5a",
                        "on-surface-variant": "#575c5e",
                        "on-primary": "#e0f6ff",
                        "surface": "#f2f7f9",
                        "on-secondary": "#d8f8ff",
                        "error": "#b31b25",
                        "tertiary": "#005bae",
                        "on-tertiary": "#eff2ff",
                        "inverse-on-surface": "#989ea0",
                        "error-dim": "#9f0519",
                        "error-container": "#fb5151",
                        "surface-container-highest": "#d6dee1",
                        "surface-container-low": "#ecf2f4",
                        "surface-container-high": "#dce4e6",
                        "on-tertiary-fixed": "#001835",
                        "primary": "#006479",
                        "surface-dim": "#cdd6d9",
                        "on-tertiary-fixed-variant": "#003971",
                        "secondary-fixed-dim": "#88d8e7",
                        "on-surface": "#2a3031",
                        "surface-tint": "#006479",
                        "tertiary-fixed-dim": "#65a4ff",
                        "inverse-primary": "#40cef3"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "1.5rem",
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
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(32px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .signature-gradient {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
        }
        .ambient-shadow {
            box-shadow: 0 40px 60px -15px rgba(42, 48, 49, 0.06);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .badge-glow {
            filter: drop-shadow(0 0 20px rgba(64, 206, 243, 0.4));
        }
    </style>
</head>
<body class="bg-background font-body text-on-surface antialiased overflow-hidden">
<!-- Blurred Background Content (The Curriculum) -->
<main class="fixed inset-0 z-0 flex blur-[10px] scale-105 pointer-events-none opacity-40">
<!-- Sidebar Placeholder -->
<aside class="w-80 h-full bg-surface-container-low p-8 flex flex-col gap-8">
<div class="h-8 w-32 bg-surface-container-highest rounded-lg"></div>
<div class="space-y-4">
<div class="h-12 w-full bg-surface-container-highest rounded-xl"></div>
<div class="h-12 w-full bg-surface-container-highest rounded-xl"></div>
<div class="h-12 w-full bg-primary-container/20 rounded-xl"></div>
<div class="h-12 w-full bg-surface-container-highest rounded-xl"></div>
</div>
</aside>
<!-- Grid Content Placeholder -->
<section class="flex-1 p-12 overflow-hidden">
<div class="max-w-5xl mx-auto space-y-12">
<div class="flex justify-between items-end">
<div class="space-y-4">
<div class="h-4 w-24 bg-surface-container-highest rounded-full"></div>
<div class="h-12 w-64 bg-surface-container-highest rounded-xl"></div>
</div>
<div class="h-12 w-48 bg-surface-container-highest rounded-full"></div>
</div>
<div class="grid grid-cols-3 gap-6">
<div class="h-64 bg-surface-container-lowest rounded-xl ambient-shadow"></div>
<div class="h-64 bg-surface-container-lowest rounded-xl ambient-shadow"></div>
<div class="h-64 bg-surface-container-lowest rounded-xl ambient-shadow"></div>
</div>
<div class="h-96 w-full bg-surface-container-lowest rounded-xl ambient-shadow p-8 flex flex-col gap-6">
<div class="h-8 w-1/3 bg-surface-container-highest rounded-lg"></div>
<div class="space-y-3">
<div class="h-4 w-full bg-surface-container-high rounded-full"></div>
<div class="h-4 w-5/6 bg-surface-container-high rounded-full"></div>
<div class="h-4 w-4/6 bg-surface-container-high rounded-full"></div>
</div>
</div>
</div>
</section>
</main>
<!-- Success Modal Overlay -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-on-background/5 backdrop-blur-sm px-6">
<div class="glass-card max-w-2xl w-full rounded-xl ambient-shadow p-12 text-center relative overflow-hidden flex flex-col items-center">
<!-- Abstract background blobs for the modal depth -->
<div class="absolute -top-24 -right-24 w-64 h-64 bg-primary-container/10 rounded-full blur-3xl"></div>
<div class="absolute -bottom-24 -left-24 w-64 h-64 bg-secondary-container/10 rounded-full blur-3xl"></div>
<!-- Awarded Badge Container -->
<div class="relative mb-10">
<div class="absolute inset-0 bg-primary-container/20 blur-3xl rounded-full scale-150"></div>
<div class="relative w-48 h-48 flex items-center justify-center badge-glow">
<!-- 3D Glass Badge Effect -->
<div class="absolute inset-0 border border-white/40 rounded-full bg-white/20 backdrop-blur-xl rotate-45 shadow-lg"></div>
<div class="absolute inset-4 border border-primary-fixed-dim/30 rounded-full bg-white/10 backdrop-blur-md"></div>
<div class="relative flex flex-col items-center z-10">
<span class="material-symbols-outlined text-primary text-7xl font-light" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
<div class="mt-2 text-[10px] font-bold tracking-[0.2em] text-primary uppercase">Elite Tier</div>
</div>
</div>
</div>
<!-- Success Information -->
<div class="space-y-4 mb-12 relative z-10">
<span class="label-md font-bold text-primary tracking-[0.15em] uppercase text-xs">Achievement Unlocked</span>
<h1 class="font-headline text-5xl font-bold text-on-background -tracking-[0.03em]">Mocktest Passed!</h1>
<p class="body-lg text-on-surface-variant max-w-md mx-auto">
                    You have demonstrated exceptional understanding of structural clarity. The <span class="font-bold text-on-background">Bio-Specialist Mastery Badge</span> has been added to your profile.
                </p>
<div class="inline-flex items-center gap-2 px-6 py-2 bg-secondary-container/30 border border-secondary/10 rounded-full mt-4">
<span class="material-symbols-outlined text-secondary text-sm" style="font-variation-settings: 'FILL' 1;">lock_open</span>
<span class="text-secondary font-medium text-sm">Chapter 4.2 Unlocked</span>
</div>
</div>
<!-- CTA Actions -->
<div class="flex flex-col sm:flex-row gap-4 w-full max-w-md relative z-10">
<a href="{{ route('learning') }}" class="flex-1 signature-gradient text-on-primary font-bold h-14 rounded-full shadow-[0_10px_20px_rgba(0,100,121,0.2)] hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-2 group">
<span>Continue to Next Chapter</span>
<span class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform">arrow_forward</span>
</a>
<button class="flex-1 glass-card bg-white/30 text-on-surface font-semibold h-14 rounded-full border border-white/40 hover:bg-white/50 active:scale-95 transition-all flex items-center justify-center gap-2">
<span class="material-symbols-outlined text-xl">analytics</span>
<span>Review Performance</span>
</button>
</div>
<!-- Footer progress indicator -->
<div class="mt-12 flex items-center gap-4 w-full">
<div class="h-[1px] flex-1 bg-gradient-to-r from-transparent via-outline-variant/30 to-transparent"></div>
<div class="flex gap-2">
<div class="w-2 h-2 rounded-full bg-primary"></div>
<div class="w-2 h-2 rounded-full bg-surface-container-highest"></div>
<div class="w-2 h-2 rounded-full bg-surface-container-highest"></div>
</div>
<div class="h-[1px] flex-1 bg-gradient-to-r from-transparent via-outline-variant/30 to-transparent"></div>
</div>
</div>
</div>
<!-- Background Decoration Images (Low opacity architectural visuals) -->
<div class="fixed top-0 left-0 w-full h-full -z-10 overflow-hidden pointer-events-none opacity-5">
<img class="absolute top-1/4 -right-20 w-1/2" data-alt="abstract architectural forms with clean lines and soft lighting in a high-key ethereal white space" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBNsI_ZbSh_S-0JCyu1HELcInjxkObtc_O4kx_KMit338Aw-TYwwwHkSd5rka507pf4IBn3O4eMpvsenAVEWaTSPHNFgpX_Oe9fQsZ7uA3ajEXV6MJlMKKSElmmGLmaH8svR-F_W0p1GQwlod0pCqDD7_Ely5RppwviiDoaQ79MvNfW-XbwBMIZsk8-_uQvwUpq7ov9yIxHeMKdWXaIwfMnn_s4s1ZQPpIj6JRHS7p9fCRynRhxgyTwA_zJ9KCeLEuvhMNGW57D3zo"/>
<img class="absolute bottom-0 -left-20 w-1/2" data-alt="smooth glass refraction patterns with soft cyan and white light playing across geometric surfaces" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB5lPYxJ4BQohXw6yjjVKYqqY1XWhWo86-Wz42Zupu8ZcVJKIRJBwWPixLF2IpwEbqKQrrQsQcUiMWszwzV2SwvwvhzzVWm0GdbSXoLAkMJLjoSQFfk40LE7A5jwYL_LmxygsDUIMpoxkTtDy84wfASZdiOKJSSDpDw9z-FEvCL4Z-4tqNAdQC-sxuKLhc4oSCWhQw_NHm885a9NXFzh-6ix_P7T0-BhkOQLgZWHVdmnNzyFaQC8S5CeLJUnIxdSWwfFNdCx_k1Nbw"/>
</div>
</body></html>
