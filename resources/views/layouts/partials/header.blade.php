{{-- ============================================================
     resources/views/layouts/partials/header.blade.php
     ============================================================ --}}
<header class="app-header" id="appHeader">

    {{-- Toggle sidebar (móvil) --}}
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Abrir menú">
        <i class="ti ti-menu-2" aria-hidden="true"></i>
    </button>

    {{-- Título de página dinámico --}}
    <div class="header-page">
        <div class="page-icon-wrap">
            <i class="ti ti-{{ $pageIcon ?? 'layout-dashboard' }}" aria-hidden="true"></i>
        </div>
        <div>
            <div class="page-title">@yield('page_title', 'Dashboard')</div>
            <div class="page-breadcrumb">
                <a href="{{ route('dashboard.index') }}">Inicio</a>
                @hasSection('breadcrumb')
                    <span>/</span> @yield('breadcrumb')
                @endif
            </div>
        </div>
    </div>

    <div class="header-actions">

        {{-- Búsqueda rápida --}}
        <div class="search-wrap">
            <button class="icon-btn" id="searchToggle" aria-label="Buscar">
                <i class="ti ti-search" aria-hidden="true"></i>
            </button>
            <div class="search-dropdown" id="searchDropdown">
                <div class="search-input-wrap">
                    <i data-lucide="bell"></i>
                    <input type="text" id="searchInput" placeholder="Buscar producto, código…" autocomplete="off" />
                </div>
                <div class="search-hint">Presiona <kbd>Esc</kbd> para cerrar</div>
            </div>
        </div>

        {{-- Notificaciones --}}
        <div class="notif-wrap" id="notifWrap">
            <button class="icon-btn" id="notifToggle" aria-label="Notificaciones">
                <i class="ti ti-bell" aria-hidden="true"></i>
                @if (isset($notifCount) && $notifCount > 0)
                    <span class="notif-badge">{{ $notifCount }}</span>
                @endif
            </button>
            <div class="notif-dropdown" id="notifDropdown">
                <div class="notif-head">
                    <span>Notificaciones</span>
                    <a href="#" class="notif-mark-all">Marcar todo como leído</a>
                </div>
                <div class="notif-list" id="notifList">
                    {{-- Se cargan dinámicamente via JS --}}
                    <div class="notif-empty">
                        <i class="ti ti-bell-off" aria-hidden="true"></i>
                        <span>Sin notificaciones</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Configuración rápida --}}
        <a href="" class="icon-btn" title="Configuración">
            <i data-lucide="settings"></i>
        </a>

        <div class="header-divider"></div>

        {{-- ── PERFIL DE USUARIO (datos del login) ── --}}
        <div class="user-pill" id="userPill">
            <div class="user-avatar" aria-hidden="true">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}{{ strtoupper(substr(auth()->user()->last_name ?? 'R', 0, 1)) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name ?? 'Administrador' }}
                    {{ auth()->user()->last_name ?? '' }}</div>
                <div class="user-role">{{ ucfirst(auth()->user()->role ?? 'admin') }}</div>
            </div>
            <i class="ti ti-chevron-down user-arrow" aria-hidden="true"></i>

            {{-- Dropdown de usuario --}}
            <div class="user-dropdown" id="userDropdown" role="menu">

                {{-- Info del usuario logueado --}}
                <div class="ud-profile">
                    <div class="ud-avatar-lg">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}{{ strtoupper(substr(auth()->user()->last_name ?? 'R', 0, 1)) }}
                    </div>
                    <div>
                        <div class="ud-fullname">{{ auth()->user()->name }} {{ auth()->user()->last_name }}</div>
                        <div class="ud-email">{{ auth()->user()->email }}</div>
                        <span class="ud-role-badge">{{ ucfirst(auth()->user()->role ?? 'admin') }}</span>
                    </div>
                </div>

                <div class="ud-sep"></div>

                <a href="" class="ud-item" role="menuitem">
                    <i class="ti ti-user" aria-hidden="true"></i> Mi perfil
                </a>
                <a href="" class="ud-item" role="menuitem">
                    <i class="ti ti-lock" aria-hidden="true"></i> Cambiar contraseña
                </a>
                <a href="" class="ud-item" role="menuitem">
                    <i class="ti ti-settings" aria-hidden="true"></i> Preferencias
                </a>

                <div class="ud-sep"></div>

                <div class="ud-last-login">
                    <i class="ti ti-clock" aria-hidden="true"></i>
                    Último acceso:
                    {{ auth()->user()->last_login_at ? \Carbon\Carbon::parse(auth()->user()->last_login_at)->format('d/m/Y H:i') : 'Primera sesión' }}
                </div>

                <div class="ud-sep"></div>

                {{-- Logout con método POST --}}
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">

                    @csrf

                    <button type="submit" class="ud-item danger" role="menuitem">

                        <i data-lucide="log-out"></i>
                        Cerrar sesión

                    </button>

                </form>

            </div>{{-- /user-dropdown --}}
        </div>{{-- /user-pill --}}

    </div>{{-- /header-actions --}}
</header>
