<x-admin-layout>
    <div class="py-12 px-4 max-w-7xl mx-auto space-y-8 relative z-10">
        <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-12">
            <div>
                <h1 class="text-4xl font-sans font-extrabold text-primary tracking-tight mb-2 reveal-text">Settings</h1>
                <p class="text-lg text-on-surface-variant font-medium reveal-text">Manage application settings and integrations.</p>
            </div>
        </header>

        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)" class="glass-panel p-24 text-center rounded-[2.5rem] bg-surface-container border border-outline-variant/20 shadow-none flex flex-col items-center justify-center min-h-[500px] transition-all duration-1000 transform" :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
            <div class="w-24 h-24 bg-primary/5 rounded-full flex items-center justify-center mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-primary/50"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
            <h2 class="text-3xl font-bold tracking-tight text-primary mb-4">Settings are unavailable</h2>
            <p class="text-lg text-on-surface-variant font-medium max-w-lg mx-auto leading-relaxed">
                Settings configuration has been temporarily disabled. Check back later for updates.
            </p>
        </div>
    </div>
</x-admin-layout>
