@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full bg-surface-container border border-outline-variant/40 rounded-xl px-4 py-3.5 text-on-surface font-medium placeholder:text-on-surface-variant/40 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300 shadow-sm']) }}>
