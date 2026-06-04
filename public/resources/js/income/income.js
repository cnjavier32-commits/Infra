/* ═══════════════════════════════════════════════
   INGRESOS.JS — InfraEnercom Sistema de Inventario
   Lógica completa: tabla, filtros, paginación,
   modales (nuevo/editar/detalle), toast, contadores
═══════════════════════════════════════════════ */

'use strict';

/* ──────────────────────────────────────────────
   DATOS DE MUESTRA
   En producción: reemplazar con llamadas a tu API
────────────────────────────────────────────── */
const SAMPLE_DATA = [
  { id: 'ING-0091', fecha: '2026-05-28', producto: 'Cable eléctrico THHN 12AWG', categoria: 'Conductores', proveedor: 'Electrodist SAC', cantidad: 500, unidad: 'm', almacen: 'Almacén Central', estado: 'Validado', obs: '' },
  { id: 'ING-0090', fecha: '2026-05-27', producto: 'Transformador 25 kVA', categoria: 'Transformadores', proveedor: 'Siemens Perú', cantidad: 4, unidad: 'und', almacen: 'Almacén Norte', estado: 'Pendiente', obs: 'Revisar documentación técnica' },
  { id: 'ING-0089', fecha: '2026-05-26', producto: 'Interruptor termomagnético 3x63A', categoria: 'Protecciones', proveedor: 'ABB Distribuidores', cantidad: 20, unidad: 'und', almacen: 'Almacén Central', estado: 'En tránsito', obs: '' },
  { id: 'ING-0088', fecha: '2026-05-25', producto: 'Medidor trifásico digital', categoria: 'Medición', proveedor: 'Electrodist SAC', cantidad: 10, unidad: 'und', almacen: 'Almacén Central', estado: 'Validado', obs: '' },
  { id: 'ING-0087', fecha: '2026-05-24', producto: 'Tubo conduit EMT 3/4"', categoria: 'Canalización', proveedor: 'Ferroindustrial', cantidad: 300, unidad: 'm', almacen: 'Almacén Norte', estado: 'Pendiente', obs: 'Esperar guía de remisión' },
  { id: 'ING-0086', fecha: '2026-05-23', producto: 'Interruptor diferencial 2x25A', categoria: 'Protecciones', proveedor: 'Schneider Electric', cantidad: 15, unidad: 'und', almacen: 'Almacén Central', estado: 'Validado', obs: '' },
  { id: 'ING-0085', fecha: '2026-05-22', producto: 'Caja de paso IP67 200x200mm', categoria: 'Cajas', proveedor: 'Ferroindustrial', cantidad: 8, unidad: 'und', almacen: 'Almacén Sur', estado: 'Validado', obs: '' },
  { id: 'ING-0084', fecha: '2026-05-21', producto: 'Cable de control 10x2.5mm²', categoria: 'Conductores', proveedor: 'Electrodist SAC', cantidad: 200, unidad: 'm', almacen: 'Almacén Norte', estado: 'En tránsito', obs: '' },
  { id: 'ING-0083', fecha: '2026-05-20', producto: 'Tablero eléctrico metálico 12 polos', categoria: 'Tableros', proveedor: 'ABB Distribuidores', cantidad: 6, unidad: 'und', almacen: 'Almacén Central', estado: 'Validado', obs: '' },
  { id: 'ING-0082', fecha: '2026-05-19', producto: 'Sensor de temperatura PT100', categoria: 'Instrumentación', proveedor: 'Siemens Perú', cantidad: 12, unidad: 'und', almacen: 'Almacén Sur', estado: 'Pendiente', obs: '' },
  { id: 'ING-0081', fecha: '2026-05-18', producto: 'Variador de frecuencia 15HP', categoria: 'Drives', proveedor: 'Schneider Electric', cantidad: 3, unidad: 'und', almacen: 'Almacén Central', estado: 'Validado', obs: '' },
  { id: 'ING-0080', fecha: '2026-05-17', producto: 'Cable XLPE 3x95mm² media tensión', categoria: 'Conductores', proveedor: 'Electrodist SAC', cantidad: 150, unidad: 'm', almacen: 'Almacén Norte', estado: 'Validado', obs: '' },
  { id: 'ING-0079', fecha: '2026-05-16', producto: 'Contactor tripolar 50A', categoria: 'Control', proveedor: 'ABB Distribuidores', cantidad: 10, unidad: 'und', almacen: 'Almacén Central', estado: 'Pendiente', obs: '' },
  { id: 'ING-0078', fecha: '2026-05-15', producto: 'Lámpara LED industrial 200W', categoria: 'Iluminación', proveedor: 'Ferroindustrial', cantidad: 24, unidad: 'und', almacen: 'Almacén Sur', estado: 'Validado', obs: '' },
  { id: 'ING-0077', fecha: '2026-05-14', producto: 'Relé de protección de motores', categoria: 'Protecciones', proveedor: 'Siemens Perú', cantidad: 5, unidad: 'und', almacen: 'Almacén Central', estado: 'En tránsito', obs: '' },
  { id: 'ING-0076', fecha: '2026-05-13', producto: 'Canaleta PVC ranurada 60x40mm', categoria: 'Canalización', proveedor: 'Ferroindustrial', cantidad: 100, unidad: 'm', almacen: 'Almacén Norte', estado: 'Validado', obs: '' },
  { id: 'ING-0075', fecha: '2026-05-12', producto: 'Fusible NH tipo gG 160A', categoria: 'Protecciones', proveedor: 'ABB Distribuidores', cantidad: 30, unidad: 'und', almacen: 'Almacén Central', estado: 'Validado', obs: '' },
  { id: 'ING-0074', fecha: '2026-05-11', producto: 'Transformador de corriente 400/5A', categoria: 'Medición', proveedor: 'Electrodist SAC', cantidad: 6, unidad: 'und', almacen: 'Almacén Sur', estado: 'Pendiente', obs: '' },
];

/* ──────────────────────────────────────────────
   ESTADO GLOBAL
────────────────────────────────────────────── */
const state = {
  data:       [...SAMPLE_DATA],
  filtered:   [...SAMPLE_DATA],
  page:       1,
  perPage:    8,
  sortCol:    'fecha',
  sortDir:    'desc',
  editId:     null,
};

/* ──────────────────────────────────────────────
   SELECTORES DOM
────────────────────────────────────────────── */
const $ = id => document.getElementById(id);

const tableBody      = $('tableBody');
const emptyState     = $('emptyState');
const paginInfo      = $('paginInfo');
const paginControls  = $('paginControls');
const searchInput    = $('searchInput');
const filterEstado   = $('filterEstado');
const filterFecha    = $('filterFecha');
const filterAlmacen  = $('filterAlmacen');

// Modal nuevo/editar
const modalBackdrop  = $('modalBackdrop');
const modal          = $('modal');
const modalTitle     = $('modalTitle');
const modalClose     = $('modalClose');
const modalCancel    = $('modalCancel');
const modalSave      = $('modalSave');

// Modal detalle
const detailBackdrop = $('detailBackdrop');
const detailBody     = $('detailBody');
const detailTitle    = $('detailTitle');
const detailClose    = $('detailClose');
const detailClose2   = $('detailClose2');
const detailEdit     = $('detailEdit');

// Toast
const toast    = $('toast');
const toastMsg = $('toastMsg');

/* ──────────────────────────────────────────────
   UTILIDADES
────────────────────────────────────────────── */
function formatFecha(iso) {
  if (!iso) return '—';
  const [y, m, d] = iso.split('-');
  const meses = ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'];
  return `${parseInt(d)} ${meses[parseInt(m)-1]} ${y}`;
}

function badgeClass(estado) {
  const map = { 'Validado': 'badge--validado', 'Pendiente': 'badge--pendiente', 'En tránsito': 'badge--transito' };
  return map[estado] || '';
}

function nextId() {
  const nums = state.data.map(d => parseInt(d.id.replace('ING-','')) || 0);
  return `ING-${String(Math.max(...nums, 0) + 1).padStart(4,'0')}`;
}

/* ──────────────────────────────────────────────
   ANIMACIÓN CONTADORES
────────────────────────────────────────────── */
function animateCount(el, target, duration = 800) {
  const start = performance.now();
  const update = now => {
    const t = Math.min((now - start) / duration, 1);
    const ease = 1 - Math.pow(1 - t, 3);
    el.textContent = Math.round(ease * target).toLocaleString('es-PE');
    if (t < 1) requestAnimationFrame(update);
    else { el.textContent = target.toLocaleString('es-PE'); el.classList.add('counted'); }
  };
  requestAnimationFrame(update);
}

function initCounters() {
  document.querySelectorAll('.metric-card__value[data-count]').forEach(el => {
    animateCount(el, parseInt(el.dataset.count));
  });
}

/* ──────────────────────────────────────────────
   TOAST
────────────────────────────────────────────── */
let toastTimer;
function showToast(msg, icon = 'success') {
  toastMsg.textContent = msg;
  toast.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => toast.classList.remove('show'), 3200);
}

/* ──────────────────────────────────────────────
   FILTRADO Y ORDENAMIENTO
────────────────────────────────────────────── */
function applyFilters() {
  const q      = searchInput.value.toLowerCase().trim();
  const estado = filterEstado.value;
  const fecha  = filterFecha.value;
  const almacen= filterAlmacen.value;

  state.filtered = state.data.filter(row => {
    const matchQ = !q || row.producto.toLowerCase().includes(q)
                       || row.id.toLowerCase().includes(q)
                       || row.proveedor.toLowerCase().includes(q)
                       || row.categoria.toLowerCase().includes(q);
    const matchE = !estado  || row.estado   === estado;
    const matchF = !fecha   || row.fecha    === fecha;
    const matchA = !almacen || row.almacen  === almacen;
    return matchQ && matchE && matchF && matchA;
  });

  applySorting();
  state.page = 1;
  renderTable();
  renderPagination();
}

function applySorting() {
  const { sortCol, sortDir } = state;
  state.filtered.sort((a, b) => {
    let va = a[sortCol], vb = b[sortCol];
    if (sortCol === 'cantidad') { va = +va; vb = +vb; }
    else { va = String(va).toLowerCase(); vb = String(vb).toLowerCase(); }
    if (va < vb) return sortDir === 'asc' ? -1 : 1;
    if (va > vb) return sortDir === 'asc' ?  1 : -1;
    return 0;
  });
}

/* ──────────────────────────────────────────────
   RENDER TABLA
────────────────────────────────────────────── */
function renderTable() {
  const { filtered, page, perPage } = state;
  const start = (page - 1) * perPage;
  const rows  = filtered.slice(start, start + perPage);

  tableBody.innerHTML = '';

  if (rows.length === 0) {
    emptyState.style.display = 'block';
    document.querySelector('.ing-table-wrap table').style.display = 'none';
    return;
  }
  emptyState.style.display = 'none';
  document.querySelector('.ing-table-wrap table').style.display = '';

  rows.forEach((row, i) => {
    const tr = document.createElement('tr');
    tr.style.animationDelay = `${i * 30}ms`;
    tr.innerHTML = `
      <td class="td-codigo">${row.id}</td>
      <td>${formatFecha(row.fecha)}</td>
      <td class="td-producto">
        ${row.producto}
        <span>${row.categoria}</span>
      </td>
      <td>${row.proveedor}</td>
      <td>${row.cantidad.toLocaleString('es-PE')} ${row.unidad}</td>
      <td>${row.almacen}</td>
      <td><span class="badge ${badgeClass(row.estado)}">${row.estado}</span></td>
      <td>
        <div class="td-actions">
          <button class="action-btn" title="Ver detalle" data-action="view" data-id="${row.id}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
          <button class="action-btn action-btn--edit" title="Editar" data-action="edit" data-id="${row.id}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          </button>
          <button class="action-btn action-btn--delete" title="Eliminar" data-action="delete" data-id="${row.id}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
          </button>
        </div>
      </td>
    `;
    tableBody.appendChild(tr);
  });
}

/* ──────────────────────────────────────────────
   PAGINACIÓN
────────────────────────────────────────────── */
function renderPagination() {
  const { filtered, page, perPage } = state;
  const total = filtered.length;
  const totalPages = Math.ceil(total / perPage);
  const start = Math.min((page - 1) * perPage + 1, total);
  const end   = Math.min(page * perPage, total);

  paginInfo.textContent = total === 0
    ? 'Sin resultados'
    : `Mostrando ${start}–${end} de ${total} registros`;

  paginControls.innerHTML = '';

  // Botón anterior
  const prev = makePageBtn('‹', page <= 1, () => { state.page--; renderTable(); renderPagination(); });
  prev.title = 'Anterior';
  paginControls.appendChild(prev);

  // Números de página (máximo 5 visibles)
  const range = pageRange(page, totalPages);
  range.forEach(p => {
    if (p === '…') {
      const dot = document.createElement('span');
      dot.textContent = '…';
      dot.style.cssText = 'padding:0 4px;color:var(--s400);font-size:13px;align-self:center;';
      paginControls.appendChild(dot);
    } else {
      const btn = makePageBtn(p, false, () => { state.page = p; renderTable(); renderPagination(); });
      if (p === page) btn.classList.add('active');
      paginControls.appendChild(btn);
    }
  });

  // Botón siguiente
  const next = makePageBtn('›', page >= totalPages, () => { state.page++; renderTable(); renderPagination(); });
  next.title = 'Siguiente';
  paginControls.appendChild(next);
}

function makePageBtn(label, disabled, onClick) {
  const btn = document.createElement('button');
  btn.className = 'page-btn';
  btn.textContent = label;
  btn.disabled = disabled;
  btn.addEventListener('click', onClick);
  return btn;
}

function pageRange(current, total) {
  if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
  if (current <= 4) return [1, 2, 3, 4, 5, '…', total];
  if (current >= total - 3) return [1, '…', total-4, total-3, total-2, total-1, total];
  return [1, '…', current-1, current, current+1, '…', total];
}

/* ──────────────────────────────────────────────
   ORDENAMIENTO POR COLUMNA
────────────────────────────────────────────── */
document.querySelectorAll('.ing-table thead th.sortable').forEach(th => {
  th.addEventListener('click', () => {
    const col = th.dataset.col;
    if (state.sortCol === col) {
      state.sortDir = state.sortDir === 'asc' ? 'desc' : 'asc';
    } else {
      state.sortCol = col;
      state.sortDir = 'asc';
    }
    document.querySelectorAll('.ing-table thead th').forEach(h => {
      h.classList.remove('sort-asc', 'sort-desc');
    });
    th.classList.add(state.sortDir === 'asc' ? 'sort-asc' : 'sort-desc');
    applySorting();
    renderTable();
  });
});

/* ──────────────────────────────────────────────
   FILTROS — listeners
────────────────────────────────────────────── */
searchInput.addEventListener('input',   applyFilters);
filterEstado.addEventListener('change', applyFilters);
filterFecha.addEventListener('change',  applyFilters);
filterAlmacen.addEventListener('change',applyFilters);

$('btnClearFilters').addEventListener('click', () => {
  searchInput.value = '';
  filterEstado.value = '';
  filterFecha.value = '';
  filterAlmacen.value = '';
  applyFilters();
});

/* ──────────────────────────────────────────────
   ACCIONES DE TABLA (delegación de eventos)
────────────────────────────────────────────── */
tableBody.addEventListener('click', e => {
  const btn = e.target.closest('[data-action]');
  if (!btn) return;
  const { action, id } = btn.dataset;
  const row = state.data.find(r => r.id === id);
  if (!row) return;

  if (action === 'view')   openDetailModal(row);
  if (action === 'edit')   openEditModal(row);
  if (action === 'delete') deleteRow(id);
});

function deleteRow(id) {
  if (!confirm('¿Eliminar este ingreso? Esta acción no se puede deshacer.')) return;
  state.data    = state.data.filter(r => r.id !== id);
  state.filtered = state.filtered.filter(r => r.id !== id);
  if ((state.page - 1) * state.perPage >= state.filtered.length && state.page > 1) state.page--;
  renderTable();
  renderPagination();
  showToast('Ingreso eliminado correctamente');
}

/* ──────────────────────────────────────────────
   MODAL NUEVO / EDITAR
────────────────────────────────────────────── */
function openNewModal() {
  state.editId = null;
  modalTitle.textContent = 'Nuevo Ingreso';
  clearForm();
  // Set today's date
  $('fFecha').value = new Date().toISOString().split('T')[0];
  openModal(modalBackdrop);
}

function openEditModal(row) {
  state.editId = row.id;
  modalTitle.textContent = `Editar — ${row.id}`;
  $('fProducto').value      = row.producto;
  $('fProveedor').value     = row.proveedor;
  $('fFecha').value         = row.fecha;
  $('fCantidad').value      = row.cantidad;
  $('fUnidad').value        = row.unidad;
  $('fAlmacen').value       = row.almacen;
  $('fEstado').value        = row.estado;
  $('fObservaciones').value = row.obs;
  openModal(modalBackdrop);
}

function clearForm() {
  ['fProducto','fProveedor','fFecha','fCantidad','fAlmacen','fObservaciones'].forEach(id => $( id).value = '');
  $('fUnidad').value  = 'und';
  $('fEstado').value  = 'Pendiente';
}

function saveModal() {
  const producto = $('fProducto').value.trim();
  const proveedor = $('fProveedor').value;
  const fecha     = $('fFecha').value;
  const cantidad  = parseFloat($('fCantidad').value);
  const almacen   = $('fAlmacen').value;

  if (!producto || !proveedor || !fecha || !cantidad || !almacen) {
    alert('Por favor completa todos los campos obligatorios (*).');
    return;
  }

  const newRow = {
    id:        state.editId || nextId(),
    fecha,
    producto,
    categoria: 'General',
    proveedor,
    cantidad,
    unidad:    $('fUnidad').value,
    almacen,
    estado:    $('fEstado').value,
    obs:       $('fObservaciones').value.trim(),
  };

  if (state.editId) {
    const idx = state.data.findIndex(r => r.id === state.editId);
    if (idx >= 0) state.data[idx] = newRow;
  } else {
    state.data.unshift(newRow);
  }

  closeModal(modalBackdrop);
  applyFilters();
  showToast(state.editId ? 'Ingreso actualizado correctamente' : 'Ingreso registrado correctamente');
}

$('btnNuevo').addEventListener('click',  openNewModal);
modalClose.addEventListener('click',    () => closeModal(modalBackdrop));
modalCancel.addEventListener('click',   () => closeModal(modalBackdrop));
modalSave.addEventListener('click',     saveModal);

/* ──────────────────────────────────────────────
   MODAL DETALLE
────────────────────────────────────────────── */
function openDetailModal(row) {
  detailTitle.textContent = `Detalle — ${row.id}`;
  detailBody.innerHTML = `
    <div class="detail-header">
      <div>
        <div class="detail-code">${row.id}</div>
        <div style="font-size:13px;color:var(--s500);margin-top:2px;">${formatFecha(row.fecha)}</div>
      </div>
      <span class="badge ${badgeClass(row.estado)}" style="margin-left:auto;">${row.estado}</span>
    </div>
    <div class="detail-grid">
      <div class="detail-item detail-item--full">
        <span class="detail-item__label">Producto / Descripción</span>
        <span class="detail-item__value">${row.producto}</span>
      </div>
      <div class="detail-item">
        <span class="detail-item__label">Categoría</span>
        <span class="detail-item__value">${row.categoria}</span>
      </div>
      <div class="detail-item">
        <span class="detail-item__label">Proveedor</span>
        <span class="detail-item__value">${row.proveedor}</span>
      </div>
      <div class="detail-item">
        <span class="detail-item__label">Cantidad</span>
        <span class="detail-item__value">${row.cantidad.toLocaleString('es-PE')} ${row.unidad}</span>
      </div>
      <div class="detail-item">
        <span class="detail-item__label">Almacén destino</span>
        <span class="detail-item__value">${row.almacen}</span>
      </div>
      ${row.obs ? `
      <div class="detail-item detail-item--full">
        <span class="detail-item__label">Observaciones</span>
        <span class="detail-item__value" style="color:var(--s600);">${row.obs}</span>
      </div>` : ''}
    </div>
  `;
  detailEdit.dataset.id = row.id;
  openModal(detailBackdrop);
}

detailClose.addEventListener('click',  () => closeModal(detailBackdrop));
detailClose2.addEventListener('click', () => closeModal(detailBackdrop));
detailEdit.addEventListener('click', () => {
  const row = state.data.find(r => r.id === detailEdit.dataset.id);
  closeModal(detailBackdrop);
  if (row) setTimeout(() => openEditModal(row), 120);
});

/* ──────────────────────────────────────────────
   ABRIR / CERRAR MODALES
────────────────────────────────────────────── */
function openModal(backdrop) {
  backdrop.classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeModal(backdrop) {
  backdrop.classList.remove('open');
  document.body.style.overflow = '';
}

// Cerrar al hacer clic fuera del modal
[modalBackdrop, detailBackdrop].forEach(backdrop => {
  backdrop.addEventListener('click', e => {
    if (e.target === backdrop) closeModal(backdrop);
  });
});

// Cerrar con Escape
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') {
    closeModal(modalBackdrop);
    closeModal(detailBackdrop);
  }
});

/* ──────────────────────────────────────────────
   EXPORTAR (CSV básico)
────────────────────────────────────────────── */
$('btnExport').addEventListener('click', () => {
  const headers = ['ID','Fecha','Producto','Categoría','Proveedor','Cantidad','Unidad','Almacén','Estado','Observaciones'];
  const rows = state.filtered.map(r => [
    r.id, r.fecha, r.producto, r.categoria, r.proveedor,
    r.cantidad, r.unidad, r.almacen, r.estado, r.obs
  ].map(v => `"${String(v).replace(/"/g,'""')}"`).join(','));

  const csv = [headers.join(','), ...rows].join('\n');
  const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
  const url  = URL.createObjectURL(blob);
  const a    = document.createElement('a');
  a.href     = url;
  a.download = `ingresos_${new Date().toISOString().slice(0,10)}.csv`;
  a.click();
  URL.revokeObjectURL(url);
  showToast('Archivo CSV exportado correctamente');
});

/* ──────────────────────────────────────────────
   INICIALIZACIÓN
────────────────────────────────────────────── */
function init() {
  // Ordenar por fecha desc por defecto
  applySorting();
  renderTable();
  renderPagination();
  initCounters();
}

init();