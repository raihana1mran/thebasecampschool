<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-8 py-3.5 bg-primary hover:bg-primary/90 text-surface rounded-full font-bold uppercase tracking-wide text-sm transition-all duration-300 shadow-lg shadow-primary/20 focus:outline-none focus:ring-4 focus:ring-primary/20 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
