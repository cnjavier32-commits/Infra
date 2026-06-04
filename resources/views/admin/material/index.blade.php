@extends('layouts.admin')

@section('title', 'Materiales')

@section('content')


{{-- ══ PAGE HEADER ══ --}}
<div class="pg-head" id="matPgHead">
  <div class="pg-title-block">
    <div class="pg-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
        <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
        <line x1="12" y1="22.08" x2="12" y2="12"/>
      </svg>
    </div>
    <div>
      <div class="pg-title">Materiales</div>
      <div class="pg-subtitle">Catálogo Maestro de Inventario</div>
      <div class="pg-desc">Registra y administra todos los materiales disponibles en el sistema de inventario.</div>
    </div>
  </div>
 
  <div class="pg-actions">
    <button class="tbl-btn" onclick="window.location=''">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
      Importar
    </button>
    <button class="tbl-btn" onclick="window.location=''">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
      Exportar
    </button>
    <button class="tbl-btn primary" onclick="openModal('matFormModal')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Nuevo Material
    </button>
  </div>
</div>
 
{{-- ══ STAT CARDS ══ --}}
<div class="mat-stats" id="matStats">
 
  <div class="mat-sc total" id="matSc0">
    <div class="mat-sc-body">
      <div>
        <div class="mat-sc-val" data-counter="{{ $stats['total'] ?? 0 }}">{{ $stats['total'] ?? 0 }}</div>
        <div class="mat-sc-lbl">Materiales Registrados</div>
      </div>
      <div class="mat-sc-icon blue">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
        </svg>
      </div>
    </div>
    <div class="mat-sc-bar">
      <div class="mat-sc-fill blue stat-fill" data-width="100%" style="width:0%"></div>
    </div>
  </div>
 
  <div class="mat-sc avail" id="matSc1">
    <div class="mat-sc-body">
      <div>
        <div class="mat-sc-val" data-counter="{{ $stats['disponibles'] ?? 0 }}">{{ $stats['disponibles'] ?? 0 }}</div>
        <div class="mat-sc-lbl">Disponibles</div>
      </div>
      <div class="mat-sc-icon green">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
      </div>
    </div>
    <div class="mat-sc-bar">
      @php $pctAvail = $stats['total'] > 0 ? round(($stats['disponibles'] / $stats['total']) * 100) : 0; @endphp
      <div class="mat-sc-fill green stat-fill" data-width="{{ $pctAvail }}%" style="width:0%"></div>
    </div>
  </div>
 
  <div class="mat-sc low" id="matSc2">
    <div class="mat-sc-body">
      <div>
        <div class="mat-sc-val" data-counter="{{ $stats['stock_bajo'] ?? 0 }}">{{ $stats['stock_bajo'] ?? 0 }}</div>
        <div class="mat-sc-lbl">Stock Bajo</div>
      </div>
      <div class="mat-sc-icon amber">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
          <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
        </svg>
      </div>
    </div>
    <div class="mat-sc-bar">
      @php $pctLow = $stats['total'] > 0 ? round(($stats['stock_bajo'] / $stats['total']) * 100) : 0; @endphp
      <div class="mat-sc-fill amber stat-fill" data-width="{{ $pctLow }}%" style="width:0%"></div>
    </div>
  </div>
 
  <div class="mat-sc empty" id="matSc3">
    <div class="mat-sc-body">
      <div>
        <div class="mat-sc-val" data-counter="{{ $stats['agotados'] ?? 0 }}">{{ $stats['agotados'] ?? 0 }}</div>
        <div class="mat-sc-lbl">Agotados</div>
      </div>
      <div class="mat-sc-icon red">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <circle cx="12" cy="12" r="10"/>
          <line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
        </svg>
      </div>
    </div>
    <div class="mat-sc-bar">
      @php $pctEmpty = $stats['total'] > 0 ? round(($stats['agotados'] / $stats['total']) * 100) : 0; @endphp
      <div class="mat-sc-fill red stat-fill" data-width="{{ $pctEmpty }}%" style="width:0%"></div>
    </div>
  </div>
 
</div>
 
{{-- ══ MAIN TABLE CARD ══ --}}
<div class="mat-card" id="matCard">
 
  <div class="mat-card-head">
    <div class="mat-card-title">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/>
        <line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/>
        <line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>
      </svg>
      <span>Catálogo de Materiales</span>
      <span class="mat-count">— {{ $materiales->total() }} registros</span>
    </div>
  </div>
 
  {{-- Filters --}}
  <div class="mat-filters">
    <form method="GET" action="" id="filterForm" style="display:contents">
      <div class="mat-search">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" name="q" value="{{ request('q') }}"
               placeholder="Buscar por código, nombre, marca o modelo…"
               oninput="debounceFilter()"/>
      </div>
      <select class="mat-select" name="categoria" onchange="this.form.submit()">
        <option value="">Todas las categorías</option>
        @foreach($categorias as $cat)
          <option value="{{ $cat->id }}" @selected(request('categoria') == $cat->id)>{{ $cat->nombre }}</option>
        @endforeach
      </select>
      <select class="mat-select" name="estado" onchange="this.form.submit()">
        <option value="">Todos los estados</option>
        <option value="ok"    @selected(request('estado') === 'ok')>Disponible</option>
        <option value="low"   @selected(request('estado') === 'low')>Stock Bajo</option>
        <option value="empty" @selected(request('estado') === 'empty')>Agotado</option>
      </select>
      <select class="mat-select" name="unidad" onchange="this.form.submit()">
        <option value="">Todas las unidades</option>
        @foreach($unidades as $u)
          <option value="{{ $u }}" @selected(request('unidad') === $u)>{{ $u }}</option>
        @endforeach
      </select>
    </form>
  </div>
 
  {{-- Table --}}
  <div class="mat-tbl-wrap">
    <table class="mat-tbl">
      <thead>
        <tr>
          <th>Código</th>
          <th>Nombre</th>
          <th>Categoría</th>
          <th>Marca</th>
          <th>Unidad</th>
          <th>Stock Actual</th>
          <th>Stock Mín.</th>
          <th>Estado</th>
          <th class="th-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($materiales as $mat)
          @php
            $statusClass = match(true) {
              $mat->stock_actual <= 0             => 'empty',
              $mat->stock_actual <= $mat->stock_minimo => 'low',
              default                              => 'ok',
            };
            $statusLabel = match($statusClass) {
              'empty' => 'Agotado',
              'low'   => 'Stock Bajo',
              default => 'Disponible',
            };
          @endphp
          <tr>
            <td><span class="td-code">{{ $mat->codigo }}</span></td>
            <td class="td-name">{{ $mat->nombre }}</td>
            <td><span class="td-cat">{{ $mat->categoria->nombre ?? '—' }}</span></td>
            <td style="font-size:.76rem;color:var(--s500)">{{ $mat->marca ?? '—' }}</td>
            <td class="td-unit">{{ $mat->unidad }}</td>
            <td class="td-stock">{{ number_format($mat->stock_actual) }}</td>
            <td class="td-min">{{ number_format($mat->stock_minimo) }}</td>
            <td><span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
            <td>
              <div class="td-acts">
                <button class="btn-icon success"
                        onclick="openDetail({{ $mat->id }})"
                        title="Ver detalle">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                  </svg>
                </button>
                <a href="" class="btn-icon" title="Editar">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                  </svg>
                </a>
                <form method="POST" action=""
                      onsubmit="return confirmDelete(event, '{{ $mat->nombre }}')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-icon danger" title="Eliminar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                      <polyline points="3 6 5 6 21 6"/>
                      <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                    </svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="9">
              <div class="mat-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                  <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <p>No se encontraron materiales con los filtros aplicados.</p>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
 
  {{-- Pagination --}}
  @if($materiales->hasPages())
    <div style="padding:14px 20px;border-top:1px solid var(--s100)">
      {{ $materiales->withQueryString()->links() }}
    </div>
  @endif
 
</div>{{-- /mat-card --}}
 
{{-- ══ MODAL DETALLE ══ --}}
<div class="modal-overlay" id="matDetailModal">
  <div class="modal-box">
    <div class="modal-hdr">
      <div class="modal-hdr-left">
        <div class="modal-hdr-icon blue">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
            <circle cx="12" cy="12" r="3"/>
          </svg>
        </div>
        <div>
          <div class="modal-hdr-title" id="detailModalTitle">Detalle del Material</div>
          <div class="modal-hdr-sub" id="detailModalCode">—</div>
        </div>
      </div>
      <button class="modal-x" onclick="closeModal('matDetailModal')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>
    <div class="modal-content" id="detailModalBody">
      <div style="text-align:center;padding:2rem;color:var(--s400)">Cargando…</div>
    </div>
    <div class="modal-ftr">
      <button class="tbl-btn" onclick="closeModal('matDetailModal')">Cerrar</button>
      <a id="detailEditBtn" href="#" class="tbl-btn primary">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
          <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
        </svg>
        Editar material
      </a>
    </div>
  </div>
</div>
 
{{-- ══ MODAL FORMULARIO NUEVO MATERIAL ══ --}}
<div class="modal-overlay" id="matFormModal">
  <div class="modal-box">
    <div class="modal-hdr">
      <div class="modal-hdr-left">
        <div class="modal-hdr-icon green">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
          </svg>
        </div>
        <div>
          <div class="modal-hdr-title">Nuevo Material</div>
          <div class="modal-hdr-sub">Completa todos los campos requeridos</div>
        </div>
      </div>
      <button class="modal-x" onclick="closeModal('matFormModal')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>
 
    <div class="modal-content">
      <form id="matNewForm" method="POST" action="">
        @csrf
 
        <div class="frm-section-hd">Identificación</div>
        <div class="frm-grid">
          <div class="frm-group">
            <label class="frm-label">Código <span class="req">*</span></label>
            <input class="frm-input" type="text" name="codigo"
                   value="{{ old('codigo') }}"
                   placeholder="Ej. MAT-0001" required/>
            <div class="frm-hint">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
              Se puede generar automáticamente
            </div>
          </div>
          <div class="frm-group">
            <label class="frm-label">Nombre <span class="req">*</span></label>
            <input class="frm-input" type="text" name="nombre"
                   value="{{ old('nombre') }}"
                   placeholder="Nombre comercial del material" required/>
          </div>
          <div class="frm-group full">
            <label class="frm-label">Descripción</label>
            <textarea class="frm-textarea" name="descripcion"
                      placeholder="Descripción técnica detallada del material…">{{ old('descripcion') }}</textarea>
          </div>
        </div>
 
        <div class="frm-section-hd">Clasificación</div>
        <div class="frm-grid">
          <div class="frm-group">
            <label class="frm-label">Categoría <span class="req">*</span></label>
            <select class="frm-select" name="categoria_id" required>
              <option value="">Seleccionar categoría…</option>
              @foreach($categorias as $cat)
                <option value="{{ $cat->id }}" @selected(old('categoria_id') == $cat->id)>
                  {{ $cat->nombre }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="frm-group">
            <label class="frm-label">Marca</label>
            <input class="frm-input" type="text" name="marca"
                   value="{{ old('marca') }}"
                   placeholder="Ej. Nexxt, Belden, 3M…"/>
          </div>
          <div class="frm-group full">
            <label class="frm-label">Modelo</label>
            <input class="frm-input" type="text" name="modelo"
                   value="{{ old('modelo') }}"
                   placeholder="Modelo o referencia del fabricante"/>
          </div>
        </div>
 
        <div class="frm-section-hd">Inventario</div>
        <div class="frm-grid">
          <div class="frm-group">
            <label class="frm-label">Unidad de medida <span class="req">*</span></label>
            <select class="frm-select" name="unidad" required>
              <option value="">Seleccionar unidad…</option>
              @foreach($unidades as $u)
                <option value="{{ $u }}" @selected(old('unidad') === $u)>{{ $u }}</option>
              @endforeach
            </select>
          </div>
          <div class="frm-group">
            <label class="frm-label">Stock mínimo <span class="req">*</span></label>
            <input class="frm-input" type="number" name="stock_minimo"
                   value="{{ old('stock_minimo', 0) }}"
                   min="0" placeholder="0" required/>
            <div class="frm-hint">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
              El stock se gestiona en Ingresos y Salidas
            </div>
          </div>
        </div>
 
      </form>
    </div>
 
    <div class="modal-ftr">
      <button class="tbl-btn" onclick="closeModal('matFormModal')">Cancelar</button>
      <button class="tbl-btn primary" onclick="document.getElementById('matNewForm').submit()">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/>
          <polyline points="17 21 17 13 7 13 7 21"/>
          <polyline points="7 3 7 8 15 8"/>
        </svg>
        Guardar material
      </button>
    </div>
  </div>
</div>

@endsection