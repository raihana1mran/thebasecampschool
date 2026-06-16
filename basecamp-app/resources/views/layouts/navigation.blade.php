<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 50) ? true : false"
     :class="scrolled ? 'glass-panel py-3' : 'bg-transparent py-5'"
     class="fixed top-0 w-full z-50 transition-all duration-[800ms] ease-[cubic-bezier(0.16,1,0.3,1)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-12">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="transform transition-transform duration-[800ms] group-hover:rotate-180">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                        <path d="M21.42 10.922a2 2 0 0 0-.019-3.315l-8-4.5a2 2 0 0 0-1.802 0l-8 4.5a2 2 0 0 0-.019 3.315l8 4.601a2 2 0 0 0 1.84 0l8-4.601z"/>
                        <path d="M22 10v6"/>
                        <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/>
                    </svg>
                </div>
                <span class="font-sans font-extrabold text-2xl tracking-tight text-primary">
                    thebasecampschool
                </span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-10">
                <a href="{{ url('/') }}" class="relative font-sans text-sm tracking-wide font-medium transition-colors hover:text-primary {{ request()->is('/') ? 'text-primary' : 'text-on-surface-variant' }}">
                    Home
                    @if(request()->is('/'))
                        <div class="absolute -bottom-1 left-0 right-0 h-px bg-primary width-full"></div>
                    @endif
                </a>
                <a href="{{ url('/admissions') }}" class="relative font-sans text-sm tracking-wide font-medium transition-colors hover:text-primary {{ request()->is('admissions') ? 'text-primary' : 'text-on-surface-variant' }}">
                    Admissions
                    @if(request()->is('admissions'))
                        <div class="absolute -bottom-1 left-0 right-0 h-px bg-primary width-full"></div>
                    @endif
                </a>
                <a href="{{ url('/mocktests') }}" class="relative font-sans text-sm tracking-wide font-medium transition-colors hover:text-primary {{ request()->is('mocktests') ? 'text-primary' : 'text-on-surface-variant' }}">
                    Mock Tests
                    @if(request()->is('mocktests'))
                        <div class="absolute -bottom-1 left-0 right-0 h-px bg-primary width-full"></div>
                    @endif
                </a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="relative font-sans text-sm tracking-wide font-medium transition-colors hover:text-primary {{ request()->is('dashboard') ? 'text-primary' : 'text-on-surface-variant' }}">
                        Dashboard
                        @if(request()->is('dashboard'))
                            <div class="absolute -bottom-1 left-0 right-0 h-px bg-primary width-full"></div>
                        @endif
                    </a>
                    <!-- Profile Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-4 py-2 border border-outline-variant text-sm leading-4 font-sans font-medium rounded-full text-primary bg-surface-container-highest backdrop-blur-sm hover:bg-surface-container-lowest transition ease-in-out duration-[800ms]">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-2">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')" class="font-sans">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="font-sans">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-on-surface-variant text-sm font-medium hover:text-primary transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="btn-primary px-6 py-2.5 text-sm tracking-wide rounded-full">Apply Now</a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-primary hover:bg-surface-container transition duration-300 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden glass-panel mt-2 mx-4 pb-4" x-transition>
        <div class="pt-4 pb-3 space-y-1">
            <x-responsive-nav-link :href="url('/')" :active="request()->is('/')">
                <span class="font-sans font-medium text-lg">Home</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/admissions')" :active="request()->is('admissions')">
                <span class="font-sans font-medium text-lg">Admissions</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/mocktests')" :active="request()->is('mocktests')">
                <span class="font-sans font-medium text-lg">Mock Tests</span>
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="url('/dashboard')" :active="request()->is('dashboard')">
                    <span class="font-sans font-medium text-lg">Dashboard</span>
                </x-responsive-nav-link>
            @endauth
        </div>

        @auth
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 mt-4">
                <div class="px-5">
                    <div class="font-sans font-medium text-lg text-primary">{{ Auth::user()->name }}</div>
                    <div class="font-sans font-medium text-sm text-on-surface-variant">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        <span class="font-sans">Profile</span>
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            <span class="font-sans">Log Out</span>
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 px-5 flex gap-3">
                <a href="{{ route('login') }}" class="flex-1 text-center py-3 border border-outline-variant rounded-xl text-sm font-medium text-primary">Login</a>
                <a href="{{ route('register') }}" class="flex-1 text-center btn-primary py-3 rounded-xl text-sm font-medium">Apply Now</a>
            </div>
        @endauth
    </div>
</nav>
