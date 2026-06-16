<x-student-layout>
    <div class="max-w-5xl mx-auto relative z-10">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Resource Hub</h1>
                <p class="text-slate-500">Access your PDF notes and TMA assignments.</p>
            </div>
            <div class="flex gap-2">
                <a href="/downloads" class="px-4 py-2 rounded-lg {{ !request()->query('category') ? 'bg-cyan-600 text-white font-bold' : 'text-slate-500 hover:bg-slate-100' }} text-sm">All</a>
                <a href="/downloads?category=pdf" class="px-4 py-2 rounded-lg {{ request()->query('category') === 'pdf' ? 'bg-cyan-600 text-white font-bold' : 'text-slate-500 hover:bg-slate-100' }} text-sm">PDF</a>
                <a href="/downloads?category=tma" class="px-4 py-2 rounded-lg {{ request()->query('category') === 'tma' ? 'bg-cyan-600 text-white font-bold' : 'text-slate-500 hover:bg-slate-100' }} text-sm">TMA</a>
            </div>
        </div>

        @if(Auth::user()->role === 'admin')
        <!-- Admin: Upload Section -->
        <div class="mb-8 p-6 bg-gradient-to-r from-cyan-600 to-cyan-500 rounded-xl text-white">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold">Manage Resources</h3>
                    <p class="text-sm text-cyan-100">Upload PDF notes and TMA assignments</p>
                </div>
                <a href="/admin/products" class="px-6 py-3 bg-white text-cyan-700 rounded-lg font-bold hover:bg-cyan-50 flex items-center gap-2 w-fit">
                    <span class="material-symbols-outlined">add</span>
                    Add Resource
                </a>
            </div>
        </div>
        @endif

        <!-- Resources Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
                @php
                    $isTma = strtolower($product->category) === 'tma';
                    $icon = $isTma ? 'assignment' : 'picture_as_pdf';
                    
                    // Cycle color schemes
                    if ($isTma) {
                        $colors = ['green', 'purple', 'teal'];
                        $colorScheme = $colors[$product->id % 3];
                    } else {
                        $colors = ['red', 'blue', 'orange'];
                        $colorScheme = $colors[$product->id % 3];
                    }

                    $bgClasses = [
                        'red' => 'bg-red-100', 'blue' => 'bg-blue-100', 'orange' => 'bg-orange-100',
                        'green' => 'bg-green-100', 'purple' => 'bg-purple-100', 'teal' => 'bg-teal-100'
                    ];
                    $textClasses = [
                        'red' => 'text-red-600', 'blue' => 'text-blue-600', 'orange' => 'text-orange-600',
                        'green' => 'text-green-600', 'purple' => 'text-purple-600', 'teal' => 'text-teal-600'
                    ];
                    $iconClasses = [
                        'red' => 'text-red-400', 'blue' => 'text-blue-400', 'orange' => 'text-orange-400',
                        'green' => 'text-green-400', 'purple' => 'text-purple-400', 'teal' => 'text-teal-400'
                    ];

                    $themeBg = $bgClasses[$colorScheme] ?? 'bg-red-100';
                    $themeText = $textClasses[$colorScheme] ?? 'text-red-600';
                    $iconColor = $iconClasses[$colorScheme] ?? 'text-red-400';

                    $fileUrls = $product->file_urls;
                    if (is_string($fileUrls)) {
                        $fileUrls = json_decode($fileUrls, true) ?: [];
                    }
                    $fileUrl = '#';
                    if (is_array($fileUrls) && count($fileUrls) > 0) {
                        $fileUrl = str_starts_with($fileUrls[0], 'http') ? $fileUrls[0] : asset('storage/' . $fileUrls[0]);
                    }
                @endphp
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-lg transition">
                    <div class="h-32 {{ $themeBg }} flex items-center justify-center">
                        <span class="material-symbols-outlined {{ $iconColor }} text-4xl">{{ $icon }}</span>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="{{ $themeBg }} {{ $themeText }} px-2 py-0.5 rounded text-xs font-bold">{{ strtoupper($product->category) }}</span>
                        </div>
                        <h3 class="font-bold text-slate-800 mb-1">{{ $product->title }}</h3>
                        <p class="text-xs text-slate-500 mb-3">{{ $product->description }}</p>
                        <a href="{{ $fileUrl }}" target="_blank" class="w-full py-2 bg-cyan-600 text-white rounded-lg font-bold text-sm hover:bg-cyan-700 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm">download</span>
                            Download
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center border-2 border-dashed border-slate-200 bg-white/40 rounded-3xl min-h-[300px] flex flex-col items-center justify-center">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <span class="material-symbols-outlined text-2xl">sentiment_dissatisfied</span>
                    </div>
                    <h5 class="text-base font-bold text-slate-700">No resources available</h5>
                    <p class="text-xs text-slate-400 mt-1">The administration has not uploaded any study materials in this category yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-student-layout>