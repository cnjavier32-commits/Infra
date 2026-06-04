/* ── Modal helpers ─────────────────────────────────────── */
function openModal(id) {
  document.getElementById(id)?.classList.add('open');
}
function closeModal(id) {
  document.getElementById(id)?.classList.remove('open');
}
 
// Cerrar al clicar fondo
document.querySelectorAll('.modal-overlay').forEach(bg => {
  bg.addEventListener('click', e => { if (e.target === bg) bg.classList.remove('open'); });
});
document.addEventListener('keydown', e => {
  if (e.key === 'Escape')
    document.querySelectorAll('.modal-overlay.open').forEach(m => m.classList.remove('open'));
});
 
/* ── Detalle vía AJAX ──────────────────────────────────── */
function openDetail(id) {
  openModal('matDetailModal');
  const body    = document.getElementById('detailModalBody');
  const editBtn = document.getElementById('detailEditBtn');
  body.innerHTML = '<div style="text-align:center;padding:2rem;color:var(--s400)">Cargando…</div>';
 
  fetch(`/materiales/${id}/detail`, {
    headers: {
      'Accept':        'application/json',
      'X-CSRF-TOKEN':  document.querySelector('meta[name="csrf-token"]').content,
    },
  })
  .then(r => r.json())
  .then(d => {
    document.getElementById('detailModalTitle').textContent = d.nombre;
    document.getElementById('detailModalCode').textContent  = d.codigo;
    editBtn.href = `/materiales/${id}/edit`;
 
    const statusMap = { ok: 'Disponible', low: 'Stock Bajo', empty: 'Agotado' };
    const statusCls = { ok: 'ok', low: 'low', empty: 'empty' };
 
    body.innerHTML = `
      <div class="det-section">
        <div class="det-section-hd">Información General</div>
        <div class="det-grid">
          <div class="det-field"><div class="det-lbl">Código</div><div class="det-val">${d.codigo}</div></div>
          <div class="det-field"><div class="det-lbl">Nombre</div><div class="det-val">${d.nombre}</div></div>
          <div class="det-field full"><div class="det-lbl">Descripción</div><div class="det-val">${d.descripcion ?? '—'}</div></div>
          <div class="det-field"><div class="det-lbl">Categoría</div><div class="det-val">${d.categoria ?? '—'}</div></div>
          <div class="det-field"><div class="det-lbl">Marca</div><div class="det-val">${d.marca ?? '—'}</div></div>
          <div class="det-field"><div class="det-lbl">Modelo</div><div class="det-val">${d.modelo ?? '—'}</div></div>
          <div class="det-field"><div class="det-lbl">Unidad de medida</div><div class="det-val">${d.unidad}</div></div>
        </div>
      </div>
      <div class="det-section">
        <div class="det-section-hd">Inventario</div>
        <div class="det-grid">
          <div class="det-field"><div class="det-lbl">Stock Actual</div><div class="det-val big">${Number(d.stock_actual).toLocaleString('es-PE')} ${d.unidad}</div></div>
          <div class="det-field"><div class="det-lbl">Stock Mínimo</div><div class="det-val">${Number(d.stock_minimo).toLocaleString('es-PE')} ${d.unidad}</div></div>
          <div class="det-field"><div class="det-lbl">Estado</div>
            <div class="det-val"><span class="status-badge ${statusCls[d.status]}">${statusMap[d.status]}</span></div>
          </div>
        </div>
      </div>
      <div class="det-section">
        <div class="det-section-hd">Auditoría</div>
        <div class="det-grid">
          <div class="det-field"><div class="det-lbl">Fecha de creación</div><div class="det-val">${d.created_at}</div></div>
          <div class="det-field"><div class="det-lbl">Última actualización</div><div class="det-val">${d.updated_at}</div></div>
          <div class="det-field"><div class="det-lbl">Usuario creador</div><div class="det-val">${d.created_by ?? '—'}</div></div>
        </div>
      </div>`;
 
    if (typeof gsap !== 'undefined') {
      gsap.fromTo(body.querySelectorAll('.det-section'),
        { y: 8, opacity: 0 },
        { y: 0, opacity: 1, duration: .25, stagger: .07, ease: 'power2.out' }
      );
    }
  })
  .catch(() => {
    body.innerHTML = '<div style="text-align:center;padding:2rem;color:#c53030">Error al cargar el detalle.</div>';
  });
}
 
/* ── Confirmar eliminación ─────────────────────────────── */
function confirmDelete(e, nombre) {
  e.preventDefault();
  const form = e.target;
  if (typeof Swal !== 'undefined') {
    Swal.fire({
      title:             '¿Eliminar material?',
      html:              `<strong>${nombre}</strong> será eliminado permanentemente.`,
      icon:              'warning',
      showCancelButton:  true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText:  'Cancelar',
      confirmButtonColor: '#c53030',
    }).then(r => { if (r.isConfirmed) form.submit(); });
  } else {
    if (confirm(`¿Eliminar "${nombre}"?`)) form.submit();
  }
  return false;
}
 
/* ── Filtro con debounce ───────────────────────────────── */
let debTimer;
function debounceFilter() {
  clearTimeout(debTimer);
  debTimer = setTimeout(() => document.getElementById('filterForm').submit(), 500);
}
 
/* ── GSAP page entrance ────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
  if (typeof gsap === 'undefined') return;
  const ease = 'power3.out';
 
  gsap.fromTo('#matPgHead', { y: -12, opacity: 0 }, { y: 0, opacity: 1, duration: .4, ease });
 
  const cards = document.querySelectorAll('.mat-sc');
  gsap.fromTo(cards, { y: 16, opacity: 0 }, { y: 0, opacity: 1, duration: .38, stagger: .07, delay: .18, ease });
 
  gsap.fromTo('#matCard', { y: 12, opacity: 0 }, { y: 0, opacity: 1, duration: .38, delay: .5, ease });
 
  // Barras de progreso
  document.querySelectorAll('.stat-fill[data-width]').forEach((el, i) => {
    gsap.to(el, { width: el.dataset.width, duration: 1.2, delay: .3 + i * .07, ease: 'power2.out' });
  });
 
  // Filas de tabla
  const rows = document.querySelectorAll('.mat-tbl tbody tr');
  gsap.fromTo(rows, { x: -8, opacity: 0 }, { x: 0, opacity: 1, duration: .3, stagger: .05, delay: .65, ease });
});