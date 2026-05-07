{{-- 
    Sunrise Navigation Bar Component
    Dark theme navigation with horizontal pill-style buttons
--}}
<nav class="w-full py-5 px-6 bg-[#1a1d29] rounded-xl border border-slate-700/50 overflow-hidden">
    <ul class="nav-menu flex items-center justify-center gap-3 list-none m-0 p-0">
        
        <!-- 1. Dashboard -->
        <li>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                {{ __('Dashboard') }}
            </a>
        </li>

        <!-- 2. Transactions -->
        <li>
            <a href="{{ route('transactions.index') }}" class="nav-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                {{ __('Transactions') }}
            </a>
        </li>

        <!-- 3. Deposits -->
        <li>
            <a href="{{ route('deposits.index') }}" class="nav-item {{ request()->routeIs('deposits.*') ? 'active' : '' }}">
                {{ __('Deposits') }}
            </a>
        </li>

        <!-- 4. Reports -->
        <li>
            <a href="{{ route('reports.index') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                {{ __('Reports') }}
            </a>
        </li>

        <!-- 5. Accounts (Admin only) -->
        <li>
            <a href="{{ route('user-management.index') }}" class="nav-item {{ request()->routeIs('user-management.*') ? 'active' : '' }}" 
               onclick="if('{{ Auth::user()->role ?? '' }}' !== 'admin') { alert('Warning: This module is restricted to Admin users only.'); return false; }">
                {{ __('Accounts') }}
            </a>
        </li>

        <!-- 6. Edit/Update (Admin only) -->
        <li>
            <a href="{{ route('edit-update.index') }}" class="nav-item {{ request()->routeIs('edit-update.*') ? 'active' : '' }}"
               onclick="if('{{ Auth::user()->role ?? '' }}' !== 'admin') { alert('Warning: This module is restricted to Admin users only.'); return false; }">
                {{ __('Admin') }}
            </a>
        </li>

    </ul>
</nav>

<style>
    /* Container background */
    .navbar {
        background-color: #1a1d29;
        padding: 20px;
        display: flex;
        justify-content: center;
    }

    .nav-menu {
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin: 0;
        padding: 0;
        justify-content: center;
    }

    /* The "Box" Button Style */
    .nav-item {
        text-decoration: none;
        color: #94a3b8;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        font-weight: 500;
        padding: 10px 20px;
        border-radius: 8px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
        display: block;
    }

    /* Hover State */
    .nav-item:hover {
        background-color: #2d3748;
        color: #ffffff;
    }

    /* Active/Selected State */
    .nav-item.active {
        background-color: #334155;
        color: #ffffff;
        border: 1px solid #475569;
    }
</style>
