<header class="topbar">
      <button class="icon-btn only-mobile" id="menuBtn" aria-label="Abrir menú">
        <i data-lucide="menu"></i>
      </button>
 
      <div class="topbar-title">
        <h1 id="viewTitle">Panel general</h1>
        <p id="viewDate">Cargando fecha…</p>
      </div>
 
      <div class="topbar-search">
        <i data-lucide="search"></i>
        <input type="text" id="searchInput" placeholder="Buscar material, código o proveedor…">
        <kbd>⌘K</kbd>
      </div>
 
      <div class="topbar-actions">
        <button class="icon-btn" aria-label="Notificaciones">
          <i data-lucide="bell"></i>
          <span class="badge-dot"></span>
        </button>
        <button class="btn btn-ghost only-desktop">
          <i data-lucide="upload"></i> Exportar
        </button>
        <button class="btn btn-primary" id="newMovementBtn">
          <i data-lucide="plus"></i> <span class="only-desktop">Nuevo movimiento</span>
        </button>
      </div>
    </header>
 