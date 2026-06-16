<!-- TopNavBar -->
<nav class="sticky top-2 sm:top-4 z-50 flex justify-between items-center px-4 sm:px-6 md:px-8 py-3 rounded-full mt-2 sm:mt-4 mx-auto w-[96%] sm:w-[95%] max-w-7xl border border-white/20 bg-white/70 backdrop-blur-2xl shadow-[0_20px_50px_rgba(0,0,0,0.05)]">
<div class="flex items-center gap-4 sm:gap-8">
<span class="text-sm sm:text-base md:text-xl font-bold tracking-tighter text-cyan-700 font-headline truncate max-w-[140px] sm:max-w-none">thebasecampschool</span>
<div class="hidden md:flex items-center gap-6">
<a class="font-['Space_Grotesk'] font-medium tracking-tight text-sm {{ Request::is('/') ? 'text-cyan-600 border-b-2 border-cyan-500 pb-1' : 'text-slate-500 hover:text-cyan-500 transition-colors' }}" href="{{ url('/') }}">Home</a>
@guest
<a class="font-['Space_Grotesk'] font-medium tracking-tight text-sm {{ Request::is('admissions*') ? 'text-cyan-600 border-b-2 border-cyan-500 pb-1' : 'text-slate-500 hover:text-cyan-500 transition-colors' }}" href="{{ url('/admissions') }}">Admissions</a>
<a class="font-['Space_Grotesk'] font-medium tracking-tight text-sm {{ Request::is('admission-status*') ? 'text-cyan-600 border-b-2 border-cyan-500 pb-1' : 'text-slate-500 hover:text-cyan-500 transition-colors' }}" href="{{ url('/admission-status') }}">Check Status</a>
@endguest
<a class="font-['Space_Grotesk'] font-medium tracking-tight text-sm {{ Request::is('contact*') ? 'text-cyan-600 border-b-2 border-cyan-500 pb-1' : 'text-slate-500 hover:text-cyan-500 transition-colors' }}" href="{{ url('/contact') }}">Contact Us</a>
</div>
</div>
<div class="flex items-center gap-3">
@if (Route::has('login'))
    @auth
        <a href="{{ url('/dashboard') }}" class="hidden md:inline-flex bg-gradient-to-r from-cyan-600 to-cyan-500 text-white px-5 py-2 rounded-full text-sm font-headline font-bold hover:from-cyan-700 hover:to-cyan-600 transition-all shadow-lg shadow-cyan-500/25">
            Dashboard
        </a>
    @else
        <a href="{{ route('login') }}" class="hidden md:inline-block text-slate-600 px-4 py-2 rounded-full text-sm font-medium hover:text-cyan-600 transition-colors">
            Login
        </a>
        <a href="{{ route('register') }}" class="hidden md:inline-flex bg-gradient-to-r from-cyan-600 to-cyan-500 text-white px-5 py-2 rounded-full text-sm font-headline font-bold hover:from-cyan-700 hover:to-cyan-600 transition-all shadow-lg shadow-cyan-500/25">
            Apply Now
        </a>
    @endauth
@endif
<!-- Mobile Menu Button -->
<button id="mobile-menu-btn" class="md:hidden p-2 rounded-full bg-white/40 hover:bg-white/60 transition-all" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
    <span class="material-symbols-outlined text-slate-700 text-xl">menu</span>
</button>
</div>
</nav>
<!-- Mobile Dropdown Menu -->
<div id="mobile-menu" class="hidden md:hidden fixed top-20 left-4 right-4 z-50 bg-white/90 backdrop-blur-2xl rounded-2xl border border-white/30 shadow-xl p-6">
<div class="flex flex-col gap-4">
<a class="font-medium text-cyan-600 border-b border-slate-100 pb-3" href="{{ url('/') }}">Home</a>
@guest
<a class="font-medium text-slate-600 hover:text-cyan-600 transition-colors border-b border-slate-100 pb-3" href="{{ url('/admissions') }}">Admissions</a>
<a class="font-medium text-slate-600 hover:text-cyan-600 transition-colors border-b border-slate-100 pb-3" href="{{ url('/admission-status') }}">Check Status</a>
@endguest
<a class="font-medium text-slate-600 hover:text-cyan-600 transition-colors border-b border-slate-100 pb-3" href="{{ url('/contact') }}">Contact Us</a>
@if (Route::has('login'))
    @auth
        <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-cyan-600 to-cyan-500 text-white px-5 py-3 rounded-xl text-sm font-bold text-center shadow-lg">Dashboard</a>
    @else
        <a href="{{ route('login') }}" class="text-slate-600 px-5 py-3 rounded-xl text-sm font-bold text-center">Login</a>
        <a href="{{ route('register') }}" class="bg-gradient-to-r from-cyan-600 to-cyan-500 text-white px-5 py-3 rounded-xl text-sm font-bold text-center shadow-lg">Apply Now</a>
    @endauth
@endif
</div>
</div>