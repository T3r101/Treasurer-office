<x-guest-layout>
    <div class="w-full max-w-md px-8 py-10 rounded-[2rem] bg-white/95 shadow-[0_32px_120px_-55px_rgba(15,23,42,0.9)] border border-slate-200/80">
        <div class="text-center mb-8">
            <p class="text-xs uppercase tracking-[0.35em] text-slate-500 mb-3">Treasurer's Office</p>
            <h1 class="text-4xl font-extrabold text-slate-900">MALAYBALAY CITY</h1>
            <p class="mt-3 text-sm leading-6 text-slate-600">Secure portal for authorized treasury staff.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <button type="submit" class="w-full rounded-2xl bg-slate-900 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                Login
            </button>
        </form>
    </div>
</x-guest-layout>
