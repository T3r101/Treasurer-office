<nav x-data="{ open: false }" class="bg-slate-950/90 backdrop-blur-md border-b border-white/5 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('image/logo1.png') }}" alt="Logo" class="block h-10 w-auto transition-transform group-hover:scale-110" />
                        <span class="text-xl font-black tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-blue-500 to-orange-400">
                            MALAYBALAY CITY
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-slate-400 hover:text-white transition-colors duration-200 active:text-white relative">
                        Dashboard
                    </x-nav-link>
                    <x-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')" class="text-slate-400 hover:text-white">
                        Transactions
                    </x-nav-link>
                    <x-nav-link :href="route('deposits.index')" :active="request()->routeIs('deposits.*')" class="text-slate-400 hover:text-white">
                        Deposits
                    </x-nav-link>
                    <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" class="text-slate-400 hover:text-white">
                        Reports
                    </x-nav-link>
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('user-management.index')" :active="request()->routeIs('user-management.*')" class="text-slate-400 hover:text-white">
                            Accounts
                        </x-nav-link>
                        <x-nav-link :href="route('edit-update.index')" :active="request()->routeIs('edit-update.*')" class="text-slate-400 hover:text-white">
                            Admin
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-white/10 text-sm font-bold rounded-full text-slate-300 bg-white/5 hover:text-white hover:bg-white/10 focus:outline-none transition duration-150">
                            <div class="h-2 w-2 rounded-full bg-emerald-400 me-2 shadow-[0_0_8px_rgba(52,211,153,0.5)]"></div>
                            {{ Auth::user()->name }}
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden text-white">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-[#152a4a]">
            <!-- 1. Dashboard (Cyan-Blue) -->
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <!-- 2. Transactions (Blue-Teal) -->
            <x-responsive-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.index')" class="text-white">
                {{ __('Transactions') }}
            </x-responsive-nav-link>

            <!-- 3. Deposits (Indigo-Purple) -->
            <x-responsive-nav-link :href="route('deposits.index')" :active="request()->routeIs('deposits.index')" class="text-white">
                {{ __('Deposits') }}
            </x-responsive-nav-link>

            <!-- 4. Summary Report (Purple-Yellow Transition) -->
            <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')" class="text-white">
                {{ __('Summary Report') }}
            </x-responsive-nav-link>

            <!-- 5. Accounts (Amber-Orange) -->
            <x-responsive-nav-link :href="route('user-management.index')" :active="request()->routeIs('user-management.index')"
                onclick="if('{{ Auth::user()->role }}' !== 'admin') { alert('Warning: This module is restricted to Admin users only.'); return false; }"
                title="Restricted to Admin"
                class="text-white">
                {{ __('Accounts') }}
            </x-responsive-nav-link>

            <!-- 6. Edit/Update (Apricot-Orange) -->
            <x-responsive-nav-link :href="route('edit-update.index')" :active="request()->routeIs('edit-update.index')"
                onclick="if('{{ Auth::user()->role }}' !== 'admin') { alert('Warning: This module is restricted to Admin users only.'); return false; }"
                title="Restricted to Admin"
                class="text-white">
                {{ __('Edit/Update') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/10 bg-[#152a4a]">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();" class="text-gray-300 hover:bg-gray-700 hover:text-white">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
