{{-- ============================================================
     resources/views/layouts/partials/sidebar.blade.php
     ============================================================ --}}
@php
  $currentRoute = request()->route()->getName();
@endphp

<aside class="app-sidebar" id="appSidebar" aria-label="Menú de navegación">

  {{-- ── BRAND ── --}}
  <div class="sidebar-brand">
    <div class="brand-logo">
      <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <polygon points="24,2 46,24 24,46 2,24" fill="none" stroke="#5db347" stroke-width="2.5"/>
        <polygon points="24,8 38,24 24,40 10,24" fill="#1a3a6b" opacity=".9"/>
        <polygon points="24,8 38,24 24,24 10,24" fill="#3a8c2f" opacity=".85"/>
        <polygon points="24,22 28,24 24,26 20,24" fill="#f0c020"/>
      </svg>
    </div>
    <div class="brand-content">
      <div class="brand-name">
        <em>Infra</em>Enercom<sub class="brand-sac">S.A.C.</sub>
      </div>
      <div class="brand-tagline">Sistema de Inventario</div>
    </div>
    <button class="sidebar-close" id="sidebarClose" aria-label="Cerrar menú">
      <i class="ti ti-x" aria-hidden="true"></i>
    </button>
  </div>

  {{-- ── NAV CONTENT ── --}}
  <nav class="sidebar-nav" id="sidebarNav">

    {{-- GENERAL --}}
    <div class="nav-group">
      <div class="nav-group-label">General</div>

      <a href="{{ route('dashboard.index') }}"
         class="nav-item {{ str_starts_with($currentRoute, 'dashboard') ? 'active' : '' }}">
        <i class="ti ti-layout-dashboard" aria-hidden="true"></i>
        <span>Dashboard</span>
      </a>

      <a href=""
         class="nav-item {{ str_starts_with($currentRoute, 'reports') ? 'active' : '' }}">
        <i class="ti ti-chart-bar" aria-hidden="true"></i>
        <span>Traslados y/o Devoluciones</span>
        <span class="nav-badge green">Nuevo</span>
      </a>
    </div>

    {{-- INVENTARIO --}}
    <div class="nav-group">
      <div class="nav-group-label">Inventario</div>

      {{-- Ingresos --}}
      <div class="nav-item has-sub {{ str_starts_with($currentRoute, 'income') ? 'active open' : '' }}"
           data-sub="sub-ingresos" onclick="toggleSub(this)">
        <i class="ti ti-package-import" aria-hidden="true"></i>
        <span>Ingresos</span>
        <i class="ti ti-chevron-down sub-arrow" aria-hidden="true"></i>
      </div>
      <div class="nav-sub {{ str_starts_with($currentRoute, 'income') ? 'open' : '' }}" id="sub-ingresos">
        <a href="{{ route('income.index') }}"
           class="nav-item {{ $currentRoute === 'ingresos.index' ? 'active' : '' }}">
          <i class="ti ti-plus" aria-hidden="true"></i><span>Nuevo ingreso</span>
        </a>
        <a href=""
           class="nav-item {{ $currentRoute === 'ingresos.index' ? 'active' : '' }}">
          <i class="ti ti-list" aria-hidden="true"></i><span>Historial</span>
        </a>
        <a href=""
           class="nav-item {{ $currentRoute === 'ingresos.import' ? 'active' : '' }}">
          <i class="ti ti-file-import" aria-hidden="true"></i><span>Importar</span>
        </a>
      </div>

      {{-- Salidas --}}
      <div class="nav-item has-sub {{ str_starts_with($currentRoute, 'salidas') ? 'active open' : '' }}"
           data-sub="sub-salidas" onclick="toggleSub(this)">
        <i class="ti ti-package-export" aria-hidden="true"></i>
        <span>Salidas</span>
        <i class="ti ti-chevron-down sub-arrow" aria-hidden="true"></i>
      </div>
      <div class="nav-sub {{ str_starts_with($currentRoute, 'salidas') ? 'open' : '' }}" id="sub-salidas">
        <a href=""
           class="nav-item {{ $currentRoute === 'salidas.create' ? 'active' : '' }}">
          <i class="ti ti-minus" aria-hidden="true"></i><span>Nueva salida</span>
        </a>
        <a href=""
           class="nav-item {{ $currentRoute === 'salidas.index' ? 'active' : '' }}">
          <i class="ti ti-list" aria-hidden="true"></i><span>Historial</span>
        </a>
      </div>

      <a href="{{ route('material.index') }}"
         class="nav-item {{ str_starts_with($currentRoute, 'material.index') ? 'active' : '' }}">
        <i class="ti ti-transfer" aria-hidden="true"></i>
        <span>Materiales</span>
      </a>
    </div>

    {{-- ADMINISTRACIÓN --}}
    {{-- @if(auth()->user()->role === 'admin')
    <div class="nav-group">
      <div class="nav-group-label">Administración</div>

      <a href=""
         class="nav-item {{ str_starts_with($currentRoute, 'usuarios') ? 'active' : '' }}">
        <i class="ti ti-users" aria-hidden="true"></i>
        <span>Usuarios</span>
      </a>

      <a href=""
         class="nav-item {{ str_starts_with($currentRoute, 'permisos') ? 'active' : '' }}">
        <i class="ti ti-shield-lock" aria-hidden="true"></i>
        <span>Permisos</span>
      </a>

      <a href=""
         class="nav-item {{ str_starts_with($currentRoute, 'auditoria') ? 'active' : '' }}">
        <i class="ti ti-file-text" aria-hidden="true"></i>
        <span>Auditoría</span>
      </a>
    </div>
    @endif --}}

  </nav>{{-- /sidebar-nav --}}

</aside>

{{-- Overlay para móvil --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>