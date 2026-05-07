{{-- 
    Sunrise Navigation Bar - Box Button Layout with Logo and User Info
    Deep Midnight header with rounded box navigation items
    Active state: Sunrise Gradient (Vibrant Orange to Fresh Yellow) with soft glow
--}}
<nav class="sunrise-nav-container">
    <!-- Left: Logo -->
    <div class="nav-logo">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
            <img src="{{ asset('image/logo1.png') }}" alt="Logo" class="block h-10 w-auto transition-transform group-hover:scale-110" />
            <span class="text-lg font-black tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-blue-500 to-orange-400">
                MALAYBALAY CITY
            </span>
        </a>
    </div>

    <!-- Center: Navigation Box Buttons -->
    <div class="nav-links">
        <!-- 1. Dashboard -->
        <a href="{{ route('dashboard') }}" class="nav-box {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span>
            <span class="nav-label">{{ __('Dashboard') }}</span>
        </a>

        <!-- 2. Transactions -->
        <a href="{{ route('transactions.index') }}" class="nav-box {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
            <span class="nav-icon">≡</span>
            <span class="nav-label">{{ __('Transactions') }}</span>
        </a>

        <!-- 3. Deposits -->
        <a href="{{ route('deposits.index') }}" class="nav-box {{ request()->routeIs('deposits.*') ? 'active' : '' }}">
            <span class="nav-icon">💰</span>
            <span class="nav-label">{{ __('Deposits') }}</span>
        </a>

        <!-- 4. Reports -->
        <a href="{{ route('reports.index') }}" class="nav-box {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <span class="nav-icon">📋</span>
            <span class="nav-label">{{ __('Reports') }}</span>
        </a>

        <!-- 5. Accounts (Admin only) -->
        @if(Auth::user()->role === 'admin')
        <a href="{{ route('user-management.index') }}" class="nav-box {{ request()->routeIs('user-management.*') ? 'active' : '' }}">
            <span class="nav-icon">👤</span>
            <span class="nav-label">{{ __('Accounts') }}</span>
        </a>

        <!-- 6. Edit/Update (Admin only) -->
        <a href="{{ route('edit-update.index') }}" class="nav-box {{ request()->routeIs('edit-update.*') ? 'active' : '' }}">
            <span class="nav-icon">⚙️</span>
<span class="nav-label">{{ __('Edit/Update') }}</span>
        </a>
        @endif
    </div>

    <!-- Right: User Info -->
    <div class="nav-user">
        <div class="user-dropdown">
            <button class="user-button">
                <span class="user-indicator"></span>
                <span class="user-name">{{ Auth::user()->name }}</span>
                <svg class="user-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div class="dropdown-menu">
                <a href="{{ route('profile.edit') }}" class="dropdown-item">{{ __('Profile') }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" class="dropdown-item logout" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Container - Deep Midnight Background */
    .sunrise-nav-container {
        background-color: #1a1d29;
        padding: 12px 24px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* Logo Section */
    .nav-logo {
        flex-shrink: 0;
    }

    .nav-logo a {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }

    /* Navigation Links - Center */
    .nav-links {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        flex: 1;
    }

    /* Box Button - Default State */
    .nav-box {
        text-decoration: none;
        color: #94a3b8;
        font-family: 'Figtree', sans-serif;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 10px 18px;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: transparent;
        display: flex;
        align-items: center;
        gap: 8px;
        position: relative;
    }

    /* Box Button - Hover State */
    .nav-box:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.2);
        color: #ffffff;
        transform: translateY(-2px);
    }

    /* Box Button - Active State (Sunrise Gradient + Glow) */
    .nav-box.active {
        background: linear-gradient(135deg, #FF6B35 0%, #FFD93D 100%);
        border: 1px solid rgba(255, 215, 0, 0.4);
        color: #1a1d29;
        font-weight: 600;
        box-shadow: 
            0 0 20px rgba(255, 107, 53, 0.4),
            0 0 40px rgba(255, 217, 61, 0.2),
            inset 0 0 15px rgba(255, 255, 255, 0.2);
    }

    /* Icon styling */
    .nav-icon {
        font-size: 1.1rem;
        line-height: 1;
    }

    /* Label styling */
    .nav-label {
        font-size: 0.95rem;
        letter-spacing: 0.01em;
    }

    /* Active icon adjust */
    .nav-box.active .nav-icon {
        filter: brightness(0.3);
    }

    /* User Section - Right */
    .nav-user {
        flex-shrink: 0;
    }

    .user-dropdown {
        position: relative;
    }

    .user-button {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.03);
        color: #94a3b8;
        font-family: 'Figtree', sans-serif;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .user-button:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff;
        border-color: rgba(255, 255, 255, 0.2);
    }

    .user-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 8px rgba(16, 185, 129, 0.5);
    }

    .user-arrow {
        width: 14px;
        height: 14px;
    }

    /* Dropdown Menu */
    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 8px;
        min-width: 160px;
        background: #1a1d29;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 6px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.2s ease;
        z-index: 100;
    }

    .user-dropdown:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-item {
        display: block;
        padding: 10px 14px;
        color: #94a3b8;
        text-decoration: none;
        font-size: 0.9rem;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff;
    }

    .dropdown-item.logout:hover {
        background: rgba(239, 68, 68, 0.15);
        color: #fca5a5;
    }

    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .nav-links {
            gap: 6px;
        }
        
        .nav-box {
            padding: 8px 12px;
            font-size: 0.85rem;
        }
        
        .nav-label {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .sunrise-nav-container {
            padding: 10px 16px;
            flex-wrap: wrap;
        }
        
        .nav-logo span {
            display: none;
        }
        
        .nav-user .user-name {
            display: none;
        }
    }
</style>
