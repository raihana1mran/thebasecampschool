<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Refund Policy - thebasecampschool</title>
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
                    <li><a class="flex items-center gap-3 text-cyan-700 font-bold border-l-2 border-primary pl-4 transition-all" href="#digital-products"><span class="material-symbols-outlined text-[20px]" data-icon="inventory_2">inventory_2</span> Digital Products</a></li>
                    <li><a class="flex items-center gap-3 text-on-surface-variant hover:text-cyan-600 hover:border-l-2 hover:border-primary/40 pl-4 transition-all" href="#mock-tests"><span class="material-symbols-outlined text-[20px]" data-icon="quiz">quiz</span> Mock Tests & Subscriptions</a></li>
                    <li><a class="flex items-center gap-3 text-on-surface-variant hover:text-cyan-600 hover:border-l-2 hover:border-primary/40 pl-4 transition-all" href="#admission-fees"><span class="material-symbols-outlined text-[20px]" data-icon="school">school</span> Admission Fees</a></li>
                    <li><a class="flex items-center gap-3 text-on-surface-variant hover:text-cyan-600 hover:border-l-2 hover:border-primary/40 pl-4 transition-all" href="#contact"><span class="material-symbols-outlined text-[20px]" data-icon="support_agent">support_agent</span> Contact Us</a></li>
                </ul>
            </div>
            <div class="mt-8 glass-panel p-6 rounded-xl bg-primary/5 border-primary/20">
                <p class="text-xs text-primary-dim leading-relaxed">
                    Last Updated: {{ date('F j, Y') }}<br/>
                    Revision: 1.5.0
                </p>
            </div>
        </aside>

        <div class="md:col-span-9 space-y-12">
            <header class="mb-16">
                <span class="inline-block px-3 py-1 bg-secondary-container/50 text-secondary-dim text-[10px] font-bold tracking-widest uppercase rounded-full mb-4">Financial Framework</span>
                <h1 class="text-[clamp(2.5rem,7vw,4.5rem)] font-bold tracking-[-0.03em] text-on-surface mb-6">Refund <span class="text-primary italic">Policy</span></h1>
                <p class="text-lg text-on-surface-variant max-w-2xl leading-relaxed">
                    Our policies regarding refunds and returns for digital products, subscriptions, and admission fees.
                </p>
            </header>

            <div class="bg-surface p-6 rounded-2xl border border-outline-variant/30 relative overflow-hidden shadow-sm space-y-2 mb-8">
                <div class="absolute inset-y-0 left-0 w-1.5 bg-primary rounded-l-2xl"></div>
                <h2 class="font-sans font-bold text-xl text-primary tracking-tight ml-2">Important Notice Regarding Admissions</h2>
                <p class="text-lg font-medium text-on-surface-variant ml-2 leading-relaxed">
                    If admission is not approved, your payment will be refunded.
                </p>
            </div>

            <section class="glass-panel p-10 rounded-2xl" id="digital-products">
                <h2 class="text-3xl font-bold mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary" data-icon="inventory_2">inventory_2</span> Digital Products
                </h2>
                <div class="prose prose-slate max-w-none text-on-surface-variant leading-[1.8] space-y-4">
                    <p>We do not issue refunds for digital products once the order is confirmed and the product is sent. We recommend contacting us for assistance if you experience any issues receiving or downloading our products.</p>
                </div>
            </section>

            <section class="p-10 border-l-4 border-primary" id="mock-tests">
                <h2 class="text-3xl font-bold mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary" data-icon="quiz">quiz</span> Mock Tests & Subscriptions
                </h2>
                <p class="text-on-surface-variant mb-6 leading-relaxed">Subscriptions to mock tests and other timed services are non-refundable. You may cancel your subscription at any time, and you will continue to have access to the service through the end of your billing period.</p>
            </section>

            <section class="glass-panel p-10 rounded-2xl" id="admission-fees">
                <h2 class="text-3xl font-bold mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary" data-icon="school">school</span> Admission Fees
                </h2>
                <p class="text-on-surface-variant mb-6 leading-relaxed">Admission fees include a non-refundable processing fee. The remainder of the admission fee is refundable only under the condition stated above—if the school explicitly denies or does not approve the admission application. Voluntary withdrawal by the student or parent does not qualify for a refund.</p>
            </section>

            <section class="p-10 border border-outline-variant/10 rounded-2xl bg-surface-container-low/30" id="contact">
                <h2 class="text-3xl font-bold mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary" data-icon="support_agent">support_agent</span> Contact Us
                </h2>
                <p class="text-on-surface-variant leading-relaxed">
                    If you have any questions about our Returns and Refunds Policy, please contact us by email: <a href="mailto:support@basecampschool.com" class="text-primary font-bold hover:underline underline-offset-4 decoration-primary/30 transition-all">support@basecampschool.com</a>
                </p>
            </section>
        </div>
    </div>
</main>

@include('layouts.footer')

</body>
</html>
