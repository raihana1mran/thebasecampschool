<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Check Admission Status | thebasecampschool</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#006479",
                        "on-primary": "#e0f6ff",
                        "surface": "#f2f7f9",
                        "on-surface": "#2a3031",
                        "on-surface-variant": "#575c5e",
                        "surface-container-low": "#ecf2f4",
                        "surface-container-lowest": "#ffffff",
                        "outline-variant": "#a8aeb0",
                        "error": "#b31b25",
                        "success": "#1b8245",
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface text-on-surface font-body min-h-screen flex flex-col items-center justify-center p-4">
    <div class="max-w-md w-full bg-surface-container-lowest rounded-3xl p-8 shadow-xl">
        <div class="flex items-center gap-3 mb-6 justify-center">
            <span class="material-symbols-outlined text-primary text-3xl">policy</span>
            <h1 class="text-2xl font-headline font-bold text-primary">Admission Status</h1>
        </div>

        <p class="text-on-surface-variant text-center mb-8 text-sm">Enter the Reference Number you received after submitting your admission form to check its current status.</p>

        @if(session('error'))
            <div class="bg-error/10 text-error p-4 rounded-xl text-sm font-bold mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">error</span>
                {{ session('error') }}
            </div>
        @endif

        @if(session('status_result'))
            <div class="bg-surface-container-low p-6 rounded-2xl mb-6 border border-outline-variant/30">
                <h3 class="font-bold text-lg mb-4 text-center">Result Found</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between border-b border-outline-variant/20 pb-2">
                        <span class="text-on-surface-variant">Applicant Name</span>
                        <span class="font-bold">{{ session('status_result')['full_name'] }}</span>
                    </div>
                    <div class="flex justify-between border-b border-outline-variant/20 pb-2">
                        <span class="text-on-surface-variant">Course Applied</span>
                        <span class="font-bold">{{ session('status_result')['course_type'] }}</span>
                    </div>
                    <div class="flex justify-between pt-2 items-center">
                        <span class="text-on-surface-variant">Current Status</span>
                        @php
                            $status = session('status_result')['status'];
                            $statusColor = match($status) {
                                'Approved' => 'bg-green-100 text-green-800',
                                'Pending' => 'bg-yellow-100 text-yellow-800',
                                'Rejected' => 'bg-red-100 text-red-800',
                                'Document Error' => 'bg-orange-100 text-orange-800',
                                'Need to Pay Fees' => 'bg-purple-100 text-purple-800',
                                default => 'bg-slate-100 text-slate-800',
                            };
                        @endphp
                        <span class="font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wider {{ $statusColor }}">
                            {{ $status }}
                        </span>
                    </div>
                </div>
            </div>

            @php $messages = session('status_result')['messages'] ?? null; @endphp
            @if($messages && count($messages) > 0)
            <div class="bg-white p-5 rounded-2xl mb-6 border border-cyan-200/50 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <span class="material-symbols-outlined text-primary text-lg">notifications_active</span>
                    <h3 class="font-bold text-sm text-slate-800">Messages from Administration</h3>
                </div>
                <div class="space-y-3 max-h-[260px] overflow-y-auto">
                    @foreach($messages as $msg)
                    <div class="p-3 bg-cyan-50/60 rounded-xl border border-cyan-100">
                        <div class="flex items-center justify-between gap-2 mb-1">
                            <h4 class="font-bold text-xs text-slate-800">{{ $msg->subject }}</h4>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider shrink-0">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-[11px] text-slate-600 leading-relaxed">{{ $msg->message }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endif

        <form method="POST" action="{{ route('admission.status.check') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block font-label text-xs uppercase tracking-wider text-on-surface-variant mb-2">Reference Number</label>
                <input type="text" name="reference_number" required placeholder="REF-2026-XXXXXX" class="w-full border border-outline-variant/50 rounded-xl px-4 py-3 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all uppercase">
            </div>
            <button type="submit" class="w-full bg-primary text-on-primary py-4 rounded-xl font-bold hover:bg-primary/90 transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">search</span> Check Status
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ url('/') }}" class="text-sm font-bold text-primary hover:underline transition-all">← Return to Homepage</a>
        </div>
    </div>
</body>
</html>
