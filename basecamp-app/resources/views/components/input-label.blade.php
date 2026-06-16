@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xs font-bold font-sans text-primary/80 mb-2 uppercase tracking-wider']) }}>
    {{ $value ?? $slot }}
</label>
