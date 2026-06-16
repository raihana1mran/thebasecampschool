<x-student-layout>
    <div class="py-12 px-4 max-w-7xl mx-auto space-y-8 relative z-10">
        <header class="mb-12">
            <h1 class="text-4xl font-sans font-extrabold text-primary tracking-tight mb-2 reveal-text capitalize">{{ str_replace('-', ' ', $slug) }}</h1>
            <p class="text-lg text-on-surface-variant font-medium reveal-text">Student portal module access point.</p>
        </header>

        <div class="glass-panel p-16 text-center rounded-[2.5rem] flex flex-col items-center justify-center min-h-[500px] border border-outline-variant/20 shadow-[0_20px_40px_rgba(0,0,0,0.03)] bg-surface-container-highest relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
            
            <div class="w-24 h-24 bg-surface-container border border-outline-variant/30 rounded-full flex items-center justify-center mb-8 relative z-10 group-hover:scale-110 transition-transform duration-700 group-hover:border-primary/30">
                <span class="material-symbols-outlined text-primary text-4xl">construction</span>
            </div>
            
            <h2 class="text-3xl font-bold mb-4 text-primary tracking-tight relative z-10 reveal-text capitalize">{{ str_replace('-', ' ', $slug) }} Workspace</h2>
            <p class="text-on-surface-variant max-w-lg mx-auto mb-10 font-medium leading-relaxed relative z-10 reveal-text text-lg">
                This academic sub-page is currently under development. The full content architecture and dynamic data modules are being constructed.
            </p>
            
            <a href="{{ url('/dashboard') }}" class="btn-primary inline-flex items-center gap-2 px-8 py-3 rounded-full text-sm font-bold shadow-md relative z-10 hover:shadow-lg transition-all hover:-translate-y-1">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Return to Command Center
            </a>
        </div>
    </div>
</x-student-layout>
