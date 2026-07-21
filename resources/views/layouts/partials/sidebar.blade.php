<aside class="sidebar" id="sidebar">
    <div class="sidebar-head">
      <div class="brand">
        <span class="brand-mark" aria-hidden="true">
          <svg viewBox="0 0 40 40" fill="none">
            <path d="M20 3 L34 11 V29 L20 37 L6 29 V11 Z" stroke="var(--gold)" stroke-width="2" fill="rgba(240,192,32,0.08)"/>
            <path d="M20 3 V37 M6 11 L34 29 M34 11 L6 29" stroke="var(--gold)" stroke-width="1" opacity="0.35"/>
            <circle cx="20" cy="20" r="4" fill="var(--gold)"/>
          </svg>
        </span>
        <div class="brand-text">
          <strong>InfraEnercom</strong>
          <span>Inventario S.A.C.</span>
        </div>
      </div>
      <button class="sidebar-collapse-btn" id="collapseBtn" aria-label="Contraer menú">
        <i data-lucide="panel-left-close"></i>
      </button>
    </div>
 
    <div class="nav-rail" aria-hidden="true">
      <svg width="100%" height="100%" preserveAspectRatio="none" id="railSvg"></svg>
    </div>
 
    <!-- Cada <a data-view="..."> define una página. El atributo data-view
         debe existir como clave en VIEW_TITLES dentro de script.js -->
    <nav class="nav" id="mainNav">
      <span class="nav-label">Operación</span>
      <a href="#" class="nav-item is-active" data-view="dashboard" data-node>
        <i data-lucide="layout-grid"></i><span>Panel general</span>
      </a>
      <a href="#" class="nav-item" data-view="entradas" data-node>
        <i data-lucide="arrow-down-to-line"></i><span>Entradas</span>
      </a>
      <a href="#" class="nav-item" data-view="salidas" data-node>
        <i data-lucide="arrow-up-from-line"></i><span>Salidas</span>
      </a>
      <a href="#" class="nav-item" data-view="inventario" data-node>
        <i data-lucide="boxes"></i><span>Materiales</span>
      </a>
 
      <span class="nav-label">Análisis</span>
      <a href="#" class="nav-item" data-view="reportes" data-node>
        <i data-lucide="bar-chart-3"></i><span>Reportes</span>
      </a>
      <a href="#" class="nav-item" data-view="alertas" data-node>
        <i data-lucide="triangle-alert"></i><span>Alertas de stock</span>
      </a>
 
      <span class="nav-label">Sistema</span>
      <a href="#" class="nav-item" data-view="config" data-node>
        <i data-lucide="settings-2"></i><span>Configuración</span>
      </a>
    </nav>
 
    <div class="sidebar-foot">
    <div class="status-chip">
        <span class="dot dot--pulse"></span>
        Sincronizado hace 2 min
    </div>

    <div class="user-dropdown">

        <button class="user-card" id="userMenuButton">
            <div class="avatar">
                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
            </div>

            <div class="user-meta">
                <strong>{{ auth()->user()->name }}</strong>
                <span>Almacén · Abancay</span>
            </div>

            <i data-lucide="chevrons-up"></i>
        </button>

        <div class="dropdown-menu" id="userDropdown">

            <a href="#">
                <i data-lucide="user-round"></i>
                <span>Perfil</span>
            </a>

            <a href="#">
                <i data-lucide="bell"></i>
                <span>Notificaciones</span>
            </a>

            <a href="#">
                <i data-lucide="settings-2"></i>
                <span>Configuración</span>
            </a>

            <div class="dropdown-divider"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <i data-lucide="log-out"></i>
                    <span>Cerrar sesión</span>
                </button>
            </form>

        </div>

    </div>
</div>
  </aside>