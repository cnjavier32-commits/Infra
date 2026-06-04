@extends('layouts.admin')

@section('title', 'Ingresos')

@section('content')

    <main class="ing-page">

        <!-- ── Top bar ── -->
        <div class="ing-topbar">
            <div class="ing-topbar__left">
                <nav class="ing-breadcrumb">
                    <span>Inventario</span>
                    <i class="ing-icon">›</i>
                    <span class="active">Ingresos</span>
                </nav>
                <h1 class="ing-title">Registro de Ingresos</h1>
            </div>
            <div class="ing-topbar__right">
                <button class="btn btn--outline" id="btnExport">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    Exportar
                </button>
                <button class="btn btn--primary" id="btnNuevo">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Nuevo Ingreso
                </button>
            </div>
        </div>

        <!-- ── Métricas ── -->
        <div class="ing-metrics">
            <div class="metric-card">
                <div class="metric-card__icon metric-card__icon--green">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                </div>
                <div class="metric-card__body">
                    <span class="metric-card__label">Ingresos del mes</span>
                    <span class="metric-card__value" data-count="124">0</span>
                    <span class="metric-card__sub metric-card__sub--up">↑ 12% vs mes anterior</span>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-card__icon metric-card__icon--blue">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2" />
                        <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                    </svg>
                </div>
                <div class="metric-card__body">
                    <span class="metric-card__label">Unidades recibidas</span>
                    <span class="metric-card__value" data-count="3840">0</span>
                    <span class="metric-card__sub metric-card__sub--up">↑ 8% vs mes anterior</span>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-card__icon metric-card__icon--gold">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div class="metric-card__body">
                    <span class="metric-card__label">Proveedores activos</span>
                    <span class="metric-card__value" data-count="18">0</span>
                    <span class="metric-card__sub metric-card__sub--neutral">Sin cambios este mes</span>
                </div>
            </div>
            <div class="metric-card metric-card--alert">
                <div class="metric-card__icon metric-card__icon--amber">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                </div>
                <div class="metric-card__body">
                    <span class="metric-card__label">Pendientes de validar</span>
                    <span class="metric-card__value" data-count="7">0</span>
                    <span class="metric-card__sub metric-card__sub--warn">⚠ Requieren acción</span>
                </div>
            </div>
        </div>

        <!-- ── Filtros ── -->
        <div class="ing-filters">
            <div class="search-box">
                <svg class="search-box__icon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input type="text" id="searchInput" placeholder="Buscar por producto, código o proveedor…" />
            </div>
            <select id="filterEstado" class="filter-select">
                <option value="">Todos los estados</option>
                <option value="Validado">Validado</option>
                <option value="Pendiente">Pendiente</option>
                <option value="En tránsito">En tránsito</option>
            </select>
            <input type="date" id="filterFecha" class="filter-select" />
            <select id="filterAlmacen" class="filter-select">
                <option value="">Todos los almacenes</option>
                <option value="Almacén Central">Almacén Central</option>
                <option value="Almacén Norte">Almacén Norte</option>
                <option value="Almacén Sur">Almacén Sur</option>
            </select>
            <button class="btn btn--ghost" id="btnClearFilters">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
                Limpiar
            </button>
        </div>

        <!-- ── Tabla ── -->
        <div class="ing-table-wrap">
            <table class="ing-table" id="ingresosTable">
                <thead>
                    <tr>
                        <th data-col="codigo" class="sortable">
                            # Ingreso <span class="sort-icon">↕</span>
                        </th>
                        <th data-col="fecha" class="sortable">
                            Fecha <span class="sort-icon">↕</span>
                        </th>
                        <th data-col="producto">Producto / Descripción</th>
                        <th data-col="proveedor">Proveedor</th>
                        <th data-col="cantidad" class="sortable">
                            Cantidad <span class="sort-icon">↕</span>
                        </th>
                        <th data-col="almacen">Almacén destino</th>
                        <th data-col="estado">Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Filas generadas por JS -->
                </tbody>
            </table>

            <!-- Estado vacío -->
            <div class="ing-empty" id="emptyState" style="display:none">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <p>No se encontraron registros</p>
                <span>Intenta con otros filtros de búsqueda</span>
            </div>
        </div>

        <!-- ── Paginación ── -->
        <div class="ing-pagination">
            <span class="ing-pagination__info" id="paginInfo">Mostrando 1–10 de 124 registros</span>
            <div class="ing-pagination__controls" id="paginControls"></div>
        </div>

    </main>

    <!-- ══════════════════════════════════════════════
         MODAL — Nuevo / Editar Ingreso
    ══════════════════════════════════════════════ -->
    <div class="modal-backdrop" id="modalBackdrop">
        <div class="modal" id="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
            <div class="modal__header">
                <h2 class="modal__title" id="modalTitle">Nuevo Ingreso</h2>
                <button class="modal__close" id="modalClose" aria-label="Cerrar">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>
            <div class="modal__body">
                <div class="form-grid">
                    <div class="form-group form-group--full">
                        <label class="form-label">Producto / Descripción *</label>
                        <input type="text" class="form-input" id="fProducto"
                            placeholder="Ej. Cable eléctrico THHN 12AWG" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Proveedor *</label>
                        <select class="form-input" id="fProveedor">
                            <option value="">Seleccionar proveedor…</option>
                            <option>Electrodist SAC</option>
                            <option>Siemens Perú</option>
                            <option>ABB Distribuidores</option>
                            <option>Ferroindustrial</option>
                            <option>Schneider Electric</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Fecha de ingreso *</label>
                        <input type="date" class="form-input" id="fFecha" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cantidad *</label>
                        <div class="input-with-unit">
                            <input type="number" class="form-input" id="fCantidad" placeholder="0" min="0" />
                            <select class="form-input input-unit" id="fUnidad">
                                <option>und</option>
                                <option>m</option>
                                <option>kg</option>
                                <option>rollo</option>
                                <option>caja</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Almacén destino *</label>
                        <select class="form-input" id="fAlmacen">
                            <option value="">Seleccionar almacén…</option>
                            <option>Almacén Central</option>
                            <option>Almacén Norte</option>
                            <option>Almacén Sur</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Estado inicial</label>
                        <select class="form-input" id="fEstado">
                            <option value="Pendiente">Pendiente</option>
                            <option value="En tránsito">En tránsito</option>
                            <option value="Validado">Validado</option>
                        </select>
                    </div>
                    <div class="form-group form-group--full">
                        <label class="form-label">Observaciones</label>
                        <textarea class="form-input form-textarea" id="fObservaciones" placeholder="Notas adicionales sobre este ingreso…"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal__footer">
                <button class="btn btn--outline" id="modalCancel">Cancelar</button>
                <button class="btn btn--primary" id="modalSave">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Guardar ingreso
                </button>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════
         MODAL DETALLE — Vista de registro
    ══════════════════════════════════════════════ -->
    <div class="modal-backdrop" id="detailBackdrop">
        <div class="modal modal--detail" id="detailModal" role="dialog" aria-modal="true">
            <div class="modal__header">
                <h2 class="modal__title" id="detailTitle">Detalle de Ingreso</h2>
                <button class="modal__close" id="detailClose" aria-label="Cerrar">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>
            <div class="modal__body" id="detailBody">
                <!-- Contenido dinámico -->
            </div>
            <div class="modal__footer">
                <button class="btn btn--outline" id="detailClose2">Cerrar</button>
                <button class="btn btn--primary" id="detailEdit">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    Editar registro
                </button>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════
         TOAST NOTIFICATION
    ══════════════════════════════════════════════ -->
    <div class="toast" id="toast">
        <svg class="toast__icon" width="16" height="16" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12" />
        </svg>
        <span class="toast__msg" id="toastMsg">Ingreso guardado correctamente</span>
    </div>

@endsection
