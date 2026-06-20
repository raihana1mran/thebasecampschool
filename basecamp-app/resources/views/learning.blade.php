<x-student-layout>
<style>
  .glass-card {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(255, 255, 255, 0.2);
  }
  .gradient-text {
    background: linear-gradient(135deg, #006479, #40cef3);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  .signature-gradient {
    background: linear-gradient(135deg, #006479, #40cef3);
  }
  .locked-overlay {
    -webkit-backdrop-filter: blur(8px);
    backdrop-filter: blur(8px);
    background: rgba(242, 247, 249, 0.4);
  }
  ::-webkit-scrollbar {
    width: 6px;
  }
  ::-webkit-scrollbar-track {
    background: transparent;
  }
  ::-webkit-scrollbar-thumb {
    background: #dce4e6;
    border-radius: 10px;
  }
</style>

<!-- Background Decorative Elements -->
<div class="hidden sm:block fixed top-[-10%] right-[-10%] w-[500px] h-[500px] bg-[#40cef3]/20 rounded-full blur-[120px] -z-10 pointer-events-none"></div>
<div class="hidden sm:block fixed bottom-[-5%] left-[-5%] w-[400px] h-[400px] bg-[#80b2ff]/10 rounded-full blur-[100px] -z-10 pointer-events-none"></div>

<div class="p-3 sm:p-6 md:p-10 flex flex-col gap-4 sm:gap-8 relative z-10 w-full max-w-7xl mx-auto">
    
    <div class="mb-2">
        <a href="{{ route('subpage', '12th-class') }}" class="inline-flex items-center gap-2 text-[#006479] hover:text-[#40cef3] hover:-translate-x-1 font-bold text-sm transition-all">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Back to Dashboard
        </a>
    </div>

    <!-- Hero Header -->
    <header class="flex flex-col md:flex-row md:items-end justify-between gap-3 sm:gap-6">
    <div class="space-y-2">
    <div class="flex items-center gap-2">
    <div class="flex items-center gap-2">
    <span class="bg-cyan-50 text-cyan-700 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest border border-cyan-200 shadow-sm">{{ $lesson->class_level }}</span>
    <span class="bg-[#40cef3]/10 text-[#00414f] text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest border border-cyan-300 shadow-sm">Video Lessons</span>
    </div>
    <h1 class="text-[clamp(1.75rem,4vw,3rem)] font-bold tracking-tight text-slate-800">{{ $lesson->subject }}</h1>
    <p class="text-slate-500 max-w-lg leading-relaxed font-medium mt-2">Comprehensive video lectures and interactive study sessions for {{ $lesson->subject }}.</p>
    </div>
    <!-- Mastery Status -->
    <div class="glass-card p-3 sm:p-6 rounded-2xl flex items-center gap-6 shadow-sm min-w-0 w-full sm:min-w-[280px]">
    <div class="relative w-16 h-16">
    <svg class="w-full h-full transform -rotate-90" viewbox="0 0 36 36">
    <path class="text-slate-200" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3"></path>
    <path class="text-[#006479]" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="64, 100" stroke-linecap="round" stroke-width="3"></path>
    </svg>
    <div class="absolute inset-0 flex items-center justify-center text-xs font-bold text-[#006479]">64%</div>
    </div>
    <div>
    <h4 class="font-bold text-sm text-slate-800">Mastery Status</h4>
    <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest mt-1 mb-2">4/12 Units Completed</p>
    <div class="mt-2 flex gap-1.5">
    <span class="w-2 h-2 rounded-full bg-[#006479] shadow-[0_0_8px_rgba(0,100,121,0.5)]"></span>
    <span class="w-2 h-2 rounded-full bg-[#006479] shadow-[0_0_8px_rgba(0,100,121,0.5)]"></span>
    <span class="w-2 h-2 rounded-full bg-[#006479] shadow-[0_0_8px_rgba(0,100,121,0.5)]"></span>
    <span class="w-2 h-2 rounded-full bg-[#006479] shadow-[0_0_8px_rgba(0,100,121,0.5)]"></span>
    <span class="w-2 h-2 rounded-full bg-slate-200"></span>
    <span class="w-2 h-2 rounded-full bg-slate-200"></span>
    </div>
    </div>
    </div>
    </header>
    <!-- Main Learning Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-8">
    <!-- Left: Video Player & Resources -->
    <div class="col-span-1 flex flex-col gap-8">
    <!-- Video Player Section -->
    <div class="glass-card rounded-xl sm:rounded-[2rem] overflow-hidden shadow-2xl relative group border border-slate-200 bg-black">
        <div class="aspect-video w-full relative">
            @php
                $playlistId = '';
                parse_str(parse_url($lesson->playlist_url, PHP_URL_QUERY), $query);
                if (isset($query['list'])) {
                    $playlistId = $query['list'];
                } else {
                    // Try parsing short url or video watch with list
                    $path = parse_url($lesson->playlist_url, PHP_URL_PATH);
                    if ($path && strpos($path, '/playlist') !== false) {
                         $playlistId = ''; // Need 'list' query param generally
                    }
                }
                $embedUrl = $playlistId ? "https://www.youtube.com/embed/videoseries?list=" . $playlistId : $lesson->playlist_url;
            @endphp
            <iframe class="w-full h-full" src="{{ $embedUrl }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>
    <!-- Resources & Action Area -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6">
    <!-- Chapter Resources -->
    <section class="glass-card p-3 sm:p-6 rounded-2xl border border-slate-200 bg-white/50">
    <h3 class="text-lg font-bold mb-4 flex items-center gap-2 text-slate-800">
    <span class="material-symbols-outlined text-[#006479]">folder_open</span>
                  Chapter Resources
                </h3>
    <div class="space-y-3">
    <div class="p-3 bg-white/80 rounded-xl flex items-center justify-between group hover:bg-white transition-all cursor-pointer border border-slate-100 shadow-sm hover:shadow-md">
    <div class="flex items-center gap-3">
    <span class="material-symbols-outlined text-red-500">picture_as_pdf</span>
    <div>
    <p class="text-sm font-bold text-slate-700">Physiology_Notes_U4.pdf</p>
    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">12.4 MB • High Res</p>
    </div>
    </div>
    <span class="material-symbols-outlined text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity">download</span>
    </div>
    <div class="p-3 bg-white/80 rounded-xl flex items-center justify-between group hover:bg-white transition-all cursor-pointer border border-slate-100 shadow-sm hover:shadow-md">
    <div class="flex items-center gap-3">
    <span class="material-symbols-outlined text-blue-500">assignment</span>
    <div>
    <p class="text-sm font-bold text-slate-700">Weekly_Assignment.docx</p>
    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">2.1 MB • Editable</p>
    </div>
    </div>
    <span class="material-symbols-outlined text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity">download</span>
    </div>
    </div>
    </section>
    <!-- Test & Unlock -->
    <section class="signature-gradient p-4 sm:p-6 rounded-2xl flex flex-col justify-between text-white shadow-xl shadow-cyan-900/20">
    <div>
    <h3 class="text-xl font-bold mb-2">Knowledge Check</h3>
    <p class="text-sm text-white/90 font-medium">Complete the mock test for Unit 04 to unlock the Respiratory System module.</p>
    </div>
    <div class="mt-6">
    <button class="w-full bg-white text-[#006479] font-bold py-3.5 rounded-xl shadow-lg hover:bg-cyan-50 hover:scale-[1.02] transition-transform flex items-center justify-center gap-2 min-h-[44px]">
    <span class="material-symbols-outlined">quiz</span>
                    Take Mocktest
                  </button>
    </div>
    </section>
    </div>
    </div>

    </div>
    <!-- Asymmetric Bento Section for Extras -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 pb-12 sm:pb-20">
    <div class="md:col-span-2 glass-card p-4 sm:p-8 rounded-2xl flex items-center gap-8 relative overflow-hidden border border-slate-200 shadow-sm bg-white/60">
    <div class="relative z-10 space-y-4">
    <h2 class="text-[clamp(1.5rem,6vw,2rem)] sm:text-3xl font-bold tracking-tight text-slate-800">Deep Dive: <br/><span class="gradient-text">Medical Illustrations</span></h2>
    <p class="text-slate-500 max-w-sm text-sm font-medium leading-relaxed">Access high-resolution 3D anatomical models that accompany this module for spatial learning.</p>
    <button class="px-6 py-2.5 border-2 border-[#006479] text-[#006479] font-bold rounded-full hover:bg-[#006479] hover:text-white transition-all text-xs uppercase tracking-widest min-h-[44px]">Open 3D Viewer</button>
    </div>
    <div class="absolute right-[-20px] top-[-20px] w-64 h-64 opacity-[0.15] pointer-events-none mix-blend-multiply">
    <img alt="Graphic Element" class="w-full h-full object-cover rounded-full filter contrast-125 saturate-150" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDRm5Epg16aca3VUoFsznnYCfcnx1YKgU9hdsRyzihgq8b0ub8qgGcOt9tky6YhDSCx7zsbEEpc8hlB0WxoO4Yt_-zm5gPqclmNIUNY4jpg-iqkQuJp-sIKL85iayTY3VUL84s-ztoBV97W8G2HlyztX2tFwWT9E79VgCPfbl4BcgiO49hgIb-dvF4uXFNhCV3PVYAmJ24OKL99UcokfSwmbXTR357O-5Ku8Q5gqq_BD7UIV6fslbcLzuOJOLRRfpH0yOewnjdtjyA"/>
    </div>
    </div>
    <div class="glass-card p-4 sm:p-8 rounded-2xl bg-gradient-to-br from-[#40cef3]/10 to-transparent border border-cyan-200 flex flex-col justify-between shadow-sm">
    <div class="w-14 h-14 rounded-full bg-white flex items-center justify-center text-[#006479] shadow-md border border-slate-100 mb-6">
    <span class="material-symbols-outlined text-2xl">forum</span>
    </div>
    <div>
    <h3 class="text-lg sm:text-xl font-bold mb-2 text-slate-800">Subject Expert Chat</h3>
    <p class="text-xs text-slate-500 mb-6 font-medium leading-relaxed">Stuck on a concept? Connect with a specialist instantly to clear your doubts.</p>
    <button class="text-[#006479] font-bold text-xs uppercase tracking-widest flex items-center gap-2 group">
                Ask a Question
                <span class="material-symbols-outlined text-sm group-hover:translate-x-1.5 transition-transform">arrow_forward</span>
    </button>
    </div>
    </div>
    </section>
</div>
</x-student-layout>
