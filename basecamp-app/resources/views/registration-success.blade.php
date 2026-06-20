<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Successful | thebasecampschool</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#006479",
                        "primary-dim": "#00576a",
                        "on-primary": "#e0f6ff",
                        "primary-container": "#40cef3",
                        "surface": "#f2f7f9",
                        "on-surface": "#2a3031",
                        "on-surface-variant": "#575c5e",
                        "surface-container-low": "#ecf2f4",
                        "surface-container-lowest": "#ffffff",
                        "outline-variant": "#a8aeb0",
                        "secondary": "#006572",
                        "secondary-container": "#96e6f6",
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
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        @keyframes celebrate {
            0% { transform: scale(0.5) rotate(-10deg); opacity: 0; }
            60% { transform: scale(1.1) rotate(3deg); opacity: 1; }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }
        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        .icon-animate { animation: celebrate 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s both; }
        .slide-up-1 { animation: slideUp 0.5s ease 0.4s both; }
        .slide-up-2 { animation: slideUp 0.5s ease 0.55s both; }
        .slide-up-3 { animation: slideUp 0.5s ease 0.7s both; }
        .slide-up-4 { animation: slideUp 0.5s ease 0.85s both; }
        .slide-up-5 { animation: slideUp 0.5s ease 1.0s both; }
        .ref-card {
            background: linear-gradient(135deg, #006479 0%, #28c0e4 100%);
            position: relative;
            overflow: hidden;
        }
        .ref-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.07) 1px, transparent 0);
            background-size: 20px 20px;
        }
        .shimmer-text {
            background: linear-gradient(90deg, rgba(255,255,255,0.7) 0%, #fff 40%, rgba(255,255,255,0.7) 80%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 3s linear infinite;
        }
        .confetti-dot {
            position: fixed;
            border-radius: 50%;
            animation: confettiFall 2.5s ease forwards;
            pointer-events: none;
        }
        @keyframes confettiFall {
            0% { transform: translateY(0) rotate(0deg); opacity: 1; }
            100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
        }
    </style>
</head>
<body class="bg-surface text-on-surface font-body min-h-screen flex flex-col items-center justify-center p-4 relative overflow-hidden">

    <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-container/20 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-secondary-container/20 rounded-full blur-[80px] pointer-events-none"></div>

    <div class="max-w-lg w-full relative z-10 py-8">

        {{-- Success Icon --}}
        <div class="icon-animate flex items-center justify-center mb-6">
            <div class="relative">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center shadow-2xl shadow-primary/30">
                    <span class="material-symbols-outlined text-white text-5xl" style="font-variation-settings: 'FILL' 1, 'wght' 400;">check_circle</span>
                </div>
                <div class="absolute inset-0 rounded-full border-2 border-primary/40 animate-ping"></div>
            </div>
        </div>

        {{-- Heading --}}
        <div class="slide-up-1 text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-headline font-bold tracking-tight text-on-surface mb-2">
                Registration Successful!
            </h1>
            <p class="text-on-surface-variant text-base font-medium">
                Welcome to <span class="text-primary font-bold">thebasecampschool</span>. Your application has been received.
            </p>
        </div>

        {{-- Reference Number Card --}}
        <div class="slide-up-2 ref-card rounded-3xl p-8 mb-4 relative">
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-white/70 text-lg">confirmation_number</span>
                    <p class="text-white/70 text-xs font-bold uppercase tracking-[0.2em]">Application Reference Number</p>
                </div>
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <p class="shimmer-text text-2xl md:text-3xl font-headline font-bold tracking-widest" id="ref-number-text">
                        {{ session('reference_number', 'REF-XXXXXX') }}
                    </p>
                    <button onclick="copyText('ref-number-text','copy-ref-icon')"
                        class="flex-shrink-0 flex items-center gap-1.5 bg-white/15 hover:bg-white/25 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all duration-200 active:scale-95">
                        <span class="material-symbols-outlined text-base" id="copy-ref-icon">content_copy</span>
                        Copy
                    </button>
                </div>
                <div class="mt-4 flex items-start gap-2 bg-white/10 rounded-xl px-4 py-3">
                    <span class="material-symbols-outlined text-yellow-300 text-base flex-shrink-0 mt-0.5" style="font-variation-settings: 'FILL' 1;">warning</span>
                    <p class="text-white/90 text-xs font-semibold">Save this number! Use it to check your admission status at the <a href="{{ url('/admission-status') }}" class="underline font-bold">Check Status</a> page.</p>
                </div>
            </div>
        </div>

        {{-- Enrollment Number (Pending) --}}
        <div class="slide-up-3 bg-surface-container-lowest rounded-3xl p-6 mb-4 border border-outline-variant/20 shadow-lg">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-xl">hourglass_empty</span>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Your Enrollment Number</p>
                    <p class="text-xs text-on-surface-variant/70 font-medium">To be assigned upon admission approval</p>
                </div>
            </div>
            <div class="flex items-center justify-between bg-surface rounded-xl px-4 py-3 border border-outline-variant/30 gap-2">
                <span class="font-headline font-bold text-on-surface-variant/50 text-sm tracking-wider uppercase">
                    Pending Admin Approval
                </span>
            </div>
        </div>

        {{-- Course Applied --}}
        @if(session('course_applied'))
        <div class="slide-up-3 bg-surface-container-lowest rounded-2xl px-6 py-4 mb-4 border border-primary/20 flex items-center gap-4">
            <div class="w-10 h-10 bg-secondary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-secondary text-xl">school</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Course Applied</p>
                <p class="font-bold text-on-surface text-base truncate">{{ session('course_applied') }}</p>
            </div>
            <span class="flex-shrink-0 bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Pending</span>
        </div>
        @endif

        {{-- What Happens Next --}}
        <div class="slide-up-4 bg-surface-container-lowest rounded-3xl p-6 mb-6 border border-outline-variant/20">
            <h2 class="font-headline font-bold text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">timeline</span>
                What happens next?
            </h2>
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-primary/15 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-primary font-bold text-xs">1</span>
                    </div>
                    <p class="text-sm text-on-surface-variant font-medium">Our team will review your application within <span class="text-on-surface font-bold">2–3 working days</span>.</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-primary/15 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-primary font-bold text-xs">2</span>
                    </div>
                    <p class="text-sm text-on-surface-variant font-medium">Track your status anytime using your <span class="text-on-surface font-bold">Reference Number</span> above.</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-primary/15 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-primary font-bold text-xs">3</span>
                    </div>
                    <p class="text-sm text-on-surface-variant font-medium">Once approved, log in to the portal using your <span class="text-on-surface font-bold">Enrollment Number</span> as your username.</p>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="slide-up-5 flex flex-col sm:flex-row gap-3">
            <a href="{{ url('/admission-status') }}"
               class="flex-1 flex items-center justify-center gap-2 bg-primary text-on-primary px-6 py-4 rounded-2xl font-headline font-bold text-sm hover:bg-primary-dim transition-all hover:scale-[1.02] active:scale-95 shadow-lg shadow-primary/25">
                <span class="material-symbols-outlined text-lg">manage_search</span>
                Check Application Status
            </a>
            <a href="{{ url('/') }}"
               class="flex-1 flex items-center justify-center gap-2 bg-surface-container-lowest border border-outline-variant/30 text-on-surface px-6 py-4 rounded-2xl font-headline font-bold text-sm hover:bg-surface-container-low transition-all hover:scale-[1.02] active:scale-95">
                <span class="material-symbols-outlined text-lg">home</span>
                Back to Home
            </a>
        </div>

        <p class="slide-up-5 text-center text-xs text-on-surface-variant/60 mt-6 font-medium">
            thebasecampschool &middot; Your reference number is confidential. Do not share it publicly.
        </p>

    </div>

    <script>
        function copyText(elId, iconId) {
            const text = document.getElementById(elId).textContent.trim();
            const icon = document.getElementById(iconId);
            navigator.clipboard.writeText(text).then(() => {
                const orig = icon.textContent;
                icon.textContent = 'done';
                setTimeout(() => { icon.textContent = orig; }, 2000);
            }).catch(() => {
                const el = document.createElement('textarea');
                el.value = text;
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
            });
        }

        // Confetti burst
        window.addEventListener('load', () => {
            const colors = ['#006479', '#40cef3', '#96e6f6', '#28c0e4', '#005bae', '#80b2ff', '#fbbf24'];
            for (let i = 0; i < 28; i++) {
                setTimeout(() => {
                    const dot = document.createElement('div');
                    dot.className = 'confetti-dot';
                    dot.style.cssText = `
                        left: ${Math.random() * 100}vw;
                        top: -10px;
                        width: ${6 + Math.random() * 8}px;
                        height: ${6 + Math.random() * 8}px;
                        background: ${colors[Math.floor(Math.random() * colors.length)]};
                        border-radius: ${Math.random() > 0.5 ? '50%' : '2px'};
                        animation-duration: ${1.5 + Math.random() * 1.5}s;
                        animation-delay: ${Math.random() * 0.5}s;
                    `;
                    document.body.appendChild(dot);
                    setTimeout(() => dot.remove(), 4000);
                }, i * 50);
            }
        });
    </script>
</body>
</html>
