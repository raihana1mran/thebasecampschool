<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Privacy Policy - thebasecampschool</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
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
                fontFamily: {
                    headline: ["Space Grotesk"],
                    body: ["Space Grotesk"],
                    label: ["Space Grotesk"]
                }
            }
        }
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
    <div class="absolute -top-20 -right-20 w-96 h-96 bg-primary-container/20 rounded-full blur-[100px] -z-10 animate-pulse"></div>
    <div class="absolute top-1/2 -left-20 w-64 h-64 bg-secondary-container/30 rounded-full blur-[80px] -z-10"></div>
    
    <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-start">
        <aside class="md:col-span-3 sticky top-32 hidden md:block">
            <div class="glass-panel p-6 rounded-xl border border-outline-variant/15">
                <h3 class="text-sm font-bold tracking-[0.1em] text-on-surface-variant mb-6 uppercase">Document Sections</h3>
                <ul class="space-y-4">
                    <li><a class="flex items-center gap-3 text-cyan-700 font-bold border-l-2 border-primary pl-4 transition-all" href="#introduction"><span class="material-symbols-outlined text-[20px]" data-icon="info">info</span> Introduction</a></li>
                    <li><a class="flex items-center gap-3 text-on-surface-variant hover:text-cyan-600 hover:border-l-2 hover:border-primary/40 pl-4 transition-all" href="#information-collection"><span class="material-symbols-outlined text-[20px]" data-icon="database">database</span> Information We Collect</a></li>
                    <li><a class="flex items-center gap-3 text-on-surface-variant hover:text-cyan-600 hover:border-l-2 hover:border-primary/40 pl-4 transition-all" href="#data-usage"><span class="material-symbols-outlined text-[20px]" data-icon="monitoring">monitoring</span> How We Use Your Data</a></li>
                    <li><a class="flex items-center gap-3 text-on-surface-variant hover:text-cyan-600 hover:border-l-2 hover:border-primary/40 pl-4 transition-all" href="#security"><span class="material-symbols-outlined text-[20px]" data-icon="shield">shield</span> Data Security</a></li>
                    <li><a class="flex items-center gap-3 text-on-surface-variant hover:text-cyan-600 hover:border-l-2 hover:border-primary/40 pl-4 transition-all" href="#rights"><span class="material-symbols-outlined text-[20px]" data-icon="gavel">gavel</span> Your Legal Rights</a></li>
                </ul>
            </div>
            <div class="mt-8 glass-panel p-6 rounded-xl bg-primary/5 border-primary/20">
                <p class="text-xs text-primary-dim leading-relaxed">
                    Last Updated: {{ date('F j, Y') }}<br/>
                    Revision: 2.1.0
                </p>
            </div>
        </aside>

        <div class="md:col-span-9 space-y-12">
            <header class="mb-16">
                <span class="inline-block px-3 py-1 bg-secondary-container/50 text-secondary-dim text-[10px] font-bold tracking-widest uppercase rounded-full mb-4">Legal Framework</span>
                <h1 class="text-[clamp(2.5rem,7vw,4.5rem)] font-bold tracking-[-0.03em] text-on-surface mb-6">Privacy <span class="text-primary italic">Policy</span></h1>
                <p class="text-lg text-on-surface-variant max-w-2xl leading-relaxed">
                    We respect your privacy and are committed to protecting your personal data. This privacy policy will inform you as to how we look after your personal data.
                </p>
            </header>

            <section class="glass-panel p-10 rounded-2xl" id="introduction">
                <h2 class="text-3xl font-bold mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary" data-icon="info">info</span> Introduction
                </h2>
                <div class="prose prose-slate max-w-none text-on-surface-variant leading-[1.8] space-y-4">
                    <p>Welcome to thebasecampschool. This document outlines how we collect and process your personal data through your use of this website, including any data you may provide through this website when you sign up for our services.</p>
                </div>
            </section>

            <section class="p-10 border-l-4 border-primary" id="information-collection">
                <h2 class="text-3xl font-bold mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary" data-icon="database">database</span> Information We Collect
                </h2>
                <p class="text-on-surface-variant mb-6 leading-relaxed">We may collect, use, store and transfer different kinds of personal data about you which we have grouped together as follows:</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/15 shadow-sm">
                        <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><span class="material-symbols-outlined text-sm">badge</span> Identity Data</h4>
                        <p class="text-sm text-on-surface-variant">Includes first name, last name, username or similar identifier.</p>
                    </div>
                    <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/15 shadow-sm">
                        <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><span class="material-symbols-outlined text-sm">contact_mail</span> Contact Data</h4>
                        <p class="text-sm text-on-surface-variant">Includes email address and telephone numbers.</p>
                    </div>
                    <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/15 shadow-sm">
                        <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><span class="material-symbols-outlined text-sm">computer</span> Technical Data</h4>
                        <p class="text-sm text-on-surface-variant">Includes internet protocol (IP) address, your login data, browser type and version.</p>
                    </div>
                    <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/15 shadow-sm">
                        <h4 class="font-bold text-primary mb-2 flex items-center gap-2"><span class="material-symbols-outlined text-sm">analytics</span> Usage Data</h4>
                        <p class="text-sm text-on-surface-variant">Includes information about how you use our website, products and services.</p>
                    </div>
                </div>
            </section>

            <section class="glass-panel p-10 rounded-2xl" id="data-usage">
                <h2 class="text-3xl font-bold mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary" data-icon="monitoring">monitoring</span> How We Use Your Data
                </h2>
                <p class="text-on-surface-variant mb-6 leading-relaxed">We will only use your personal data when the law allows us to. Most commonly, we will use your personal data in the following circumstances:</p>
                <ul class="space-y-4">
                    <li class="flex gap-4">
                        <span class="material-symbols-outlined text-primary" data-icon="check_circle">check_circle</span>
                        <div>
                            <p class="text-on-surface-variant">Where we need to perform the contract we are about to enter into or have entered into with you.</p>
                        </div>
                    </li>
                    <li class="flex gap-4">
                        <span class="material-symbols-outlined text-primary" data-icon="check_circle">check_circle</span>
                        <div>
                            <p class="text-on-surface-variant">Where it is necessary for our legitimate interests (or those of a third party) and your interests and fundamental rights do not override those interests.</p>
                        </div>
                    </li>
                    <li class="flex gap-4">
                        <span class="material-symbols-outlined text-primary" data-icon="check_circle">check_circle</span>
                        <div>
                            <p class="text-on-surface-variant">Where we need to comply with a legal obligation.</p>
                        </div>
                    </li>
                </ul>
            </section>

            <section class="p-10 border border-outline-variant/10 rounded-2xl bg-surface-container-low/30" id="security">
                <h2 class="text-3xl font-bold mb-6">Data Security</h2>
                <p class="text-on-surface-variant leading-relaxed">
                    We have put in place appropriate security measures to prevent your personal data from being accidentally lost, used, or accessed in an unauthorized way, altered, or disclosed.
                </p>
            </section>

            <section class="p-10 border border-outline-variant/10 rounded-2xl bg-surface-container-low/30" id="rights">
                <h2 class="text-3xl font-bold mb-6">Your Legal Rights</h2>
                <p class="text-on-surface-variant leading-relaxed">
                    Under certain circumstances, you have rights under data protection laws in relation to your personal data, including the right to request access, correction, erasure, restriction, transfer, to object to processing, to portability of data and (where the lawful ground of processing is consent) to withdraw consent.
                </p>
            </section>
        </div>
    </div>
</main>

@include('layouts.footer')

</body>
</html>
