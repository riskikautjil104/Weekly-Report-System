<x-guest-layout>
    <div class="space-y-6">
        <x-auth-session-status :status="session('status')" />

        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#b8c3ff]">Welcome back</p>
            <h2 class="mt-2 text-3xl font-bold tracking-tight text-white">Sign in to WeeklyReport</h2>
            <p class="mt-3 text-sm leading-6 text-white/70">
                Masuk untuk mengelola aktivitas harian, melihat report mingguan, dan mengunduh format perusahaan.
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5" id="login-form">
            @csrf

            <div class="space-y-2">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@perusahaan.com" />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="space-y-2">
                <x-input-label for="password" :value="__('Password')" />
                <div class="relative">
                    <x-text-input id="password" class="pr-20" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password" />
                    <button
                        type="button"
                        id="toggle-password"
                        class="absolute inset-y-0 right-2 my-2 inline-flex items-center rounded-xl border border-white/10 bg-white/5 px-3 text-xs font-semibold text-white/70 transition hover:bg-white/10 hover:text-white"
                    >
                        Show
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="flex items-center justify-between gap-4">
                <label for="remember_me" class="inline-flex items-center gap-3 text-sm text-white/70">
                    <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-white/20 bg-white/10 text-[#4d8aff] focus:ring-[#4d8aff]/30" name="remember">
                    <span>{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-[#b8c3ff] transition hover:text-white" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs leading-5 text-white/50">
                    Tip: gunakan akun kerja yang sudah terdaftar untuk mengakses dashboard dan weekly report.
                </p>

                <x-primary-button class="w-full sm:w-auto">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <script>
        (function () {
            const button = document.getElementById('toggle-password');
            const input = document.getElementById('password');

            if (!button || !input) {
                return;
            }

            button.addEventListener('click', function () {
                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                button.textContent = isHidden ? 'Hide' : 'Show';
            });
        })();
    </script>
</x-guest-layout>
