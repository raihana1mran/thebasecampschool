<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-4xl font-sans font-extrabold text-primary tracking-tight mb-2">Create <span class="italic text-on-surface-variant/80">Account</span></h2>
        <p class="text-on-surface-variant font-medium">Register with thebasecampschool to apply for admission</p>
    </div>

    {{-- Show selected course badge if coming from admissions page --}}
    @if(request('course'))
    <div class="mb-6 flex items-center gap-3 bg-primary/8 border border-primary/20 rounded-2xl px-5 py-4">
        <span class="material-symbols-outlined text-primary text-xl flex-shrink-0" style="font-variation-settings: 'FILL' 1;">school</span>
        <div class="min-w-0">
            <p class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Applying for</p>
            <p class="font-bold text-primary text-sm truncate">
                @if(request('course') === '10th' || request('course') === 'Secondary')
                    Secondary (Class 10) — ₹5,500
                @elseif(request('course') === '12th' || request('course') === 'Senior Secondary')
                    Sr. Secondary (Class 12) — ₹6,500
                @else
                    {{ request('course') }}
                @endif
            </p>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        {{-- Pass the selected course through the form --}}
        @if(request('course'))
            <input type="hidden" name="course" value="{{ request('course') }}">
        @endif

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Register & Apply') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm font-medium text-on-surface-variant">
                Already registered?
                <a href="{{ route('login') }}" class="text-primary font-bold hover:underline underline-offset-4 decoration-primary/30 transition-all">Sign in</a>
            </p>
            <p class="text-sm font-medium text-on-surface-variant mt-3">
                <a href="/admissions" class="text-primary font-bold hover:underline underline-offset-4">← Back to Admissions</a>
            </p>
        </div>
    </form>
</x-guest-layout>

