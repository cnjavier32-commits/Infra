// ── SAMPLE DATA ──
const DATA = [
  { id:1, codigo:'MAT-0001', nombre:'Cable UTP Cat6 23AWG', categoria:'Redes y Cableado', marca:'Belden', unidad:'RLL', stock:85, min:10, status:'ok' },
  { id:2, codigo:'MAT-0002', nombre:'Switch PoE 24 Puertos', categoria:'Redes y Cableado', marca:'Nexxt', unidad:'UND', stock:12, min:3, status:'ok' },
  { id:3, codigo:'MAT-0003', nombre:'Conector RJ45 Cat6', categoria:'Redes y Cableado', marca:'AMP', unidad:'CJA', stock:7, min:10, status:'low' },
  { id:4, codigo:'MAT-0004', nombre:'Rack 19" 12U Piso', categoria:'Redes y Cableado', marca:'Nexxt', unidad:'UND', stock:0, min:1, status:'empty' },
  { id:5, codigo:'MAT-0005', nombre:'Bandeja Pasacables 1U', categoria:'Redes y Cableado', marca:'Dintek', unidad:'UND', stock:24, min:5, status:'ok' },
  { id:6, codigo:'MAT-0006', nombre:'Patch Panel Cat6 24P', categoria:'Redes y Cableado', marca:'Panduit', unidad:'UND', stock:3, min:5, status:'low' },
  { id:7, codigo:'MAT-0007', nombre:'Fibra Óptica SM 8H', categoria:'Redes y Cableado', marca:'Corning', unidad:'MT', stock:0, min:50, status:'empty' },
  { id:8, codigo:'MAT-0008', nombre:'Canaleta PVC 60×40mm', categoria:'Eléctrico', marca:'Dexson', unidad:'MT', stock:200, min:30, status:'ok' },
  { id:9, codigo:'MAT-0009', nombre:'Brida Plástica 20cm', categoria:'Consumibles', marca:'—', unidad:'CJA', stock:42, min:20, status:'ok' },
  { id:10, codigo:'MAT-0010', nombre:'Tarugo Fisher 8mm', categoria:'Herramientas', marca:'Fisher', unidad:'CJA', stock:8, min:15, status:'low' },
  { id:11, codigo:'MAT-0011', nombre:'Tornillo Autoperforante 3/4"', categoria:'Consumibles', marca:'—', unidad:'CJA', stock:55, min:10, status:'ok' },
  { id:12, codigo:'MAT-0012', nombre:'Keystone Cat6 Negro', categoria:'Redes y Cableado', marca:'AMP', unidad:'UND', stock:0, min:20, status:'empty' },
  { id:13, codigo:'MAT-0013', nombre:'Etiquetas de Cable', categoria:'Consumibles', marca:'Brady', unidad:'CJA', stock:15, min:5, status:'ok' },
  { id:14, codigo:'MAT-0014', nombre:'Herramienta Ponchadora', categoria:'Herramientas', marca:'Paladin', unidad:'UND', stock:4, min:2, status:'ok' },
  { id:15, codigo:'MAT-0015', nombre:'Probador de Red RJ45', categoria:'Herramientas', marca:'Klein', unidad:'UND', stock:2, min:5, status:'low' },
];
 
let filtered = [...DATA];
let currentPage = 1;
const PER_PAGE = 8;
 
const statusLabel = { ok:'Disponible', low:'Stock Bajo', empty:'Agotado' };
 
function renderTable() {
  const tbody = document.getElementById('tableBody');
  const start = (currentPage - 1) * PER_PAGE;
  const slice = filtered.slice(start, start + PER_PAGE);
 
  tbody.innerHTML = slice.map(m => `
    <tr>
      <td><span class="td-code">${m.codigo}</span></td>
      <td class="td-name">${m.nombre}</td>
      <td><span class="td-cat">${m.categoria}</span></td>
      <td style="font-size:.76rem;color:var(--s500)">${m.marca}</td>
      <td class="td-unit">${m.unidad}</td>
      <td class="td-stock">${m.stock.toLocaleString()}</td>
      <td class="td-min">${m.min.toLocaleString()}</td>
      <td><span class="status-badge ${m.status}">${statusLabel[m.status]}</span></td>
      <td>
        <div class="td-acts">
          <button class="btn-icon success" onclick="openDetail(${m.id})" data-tip="Ver detalle" title="Ver detalle">
            <i class="fas fa-eye"></i>
          </button>
          <button class="btn-icon" data-tip="Editar" title="Editar">
            <i class="fas fa-pen-to-square"></i>
          </button>
          <button class="btn-icon danger" onclick="confirmDelete('${m.nombre}')" data-tip="Eliminar" title="Eliminar">
            <i class="fas fa-trash-can"></i>
          </button>
        </div>
      </td>
    </tr>
  `).join('');
 
  renderPagination();
}
 
function renderPagination() {
  const total = Math.ceil(filtered.length / PER_PAGE);
  if (total <= 1) { document.getElementById('pagination').innerHTML = ''; return; }
  let html = `<button class="pag-btn" onclick="goPage(${currentPage-1})" ${currentPage===1?'disabled':''}><i class="fas fa-chevron-left" style="font-size:11px"></i></button>`;
  for (let i = 1; i <= total; i++) {
    html += `<button class="pag-btn ${i===currentPage?'active':''}" onclick="goPage(${i})">${i}</button>`;
  }
  html += `<button class="pag-btn" onclick="goPage(${currentPage+1})" ${currentPage===total?'disabled':''}><i class="fas fa-chevron-right" style="font-size:11px"></i></button>`;
  document.getElementById('pagination').innerHTML = html;
}
 
function goPage(n) {
  const total = Math.ceil(filtered.length / PER_PAGE);
  if (n < 1 || n > total) return;
  currentPage = n;
  renderTable();
}
 
function filterTable() {
  const q   = document.getElementById('searchInput').value.toLowerCase();
  const cat = document.getElementById('filterCat').value;
  const est = document.getElementById('filterEst').value;
  const und = document.getElementById('filterUnd').value;
  filtered = DATA.filter(m => {
    const matchQ = !q || m.codigo.toLowerCase().includes(q) || m.nombre.toLowerCase().includes(q) || m.marca.toLowerCase().includes(q);
    const matchC = !cat || m.categoria === cat;
    const matchE = !est || m.status === est;
    const matchU = !und || m.unidad === und;
    return matchQ && matchC && matchE && matchU;
  });
  currentPage = 1;
  renderTable();
}
 
// ── MODALS ──
function openModal(id) { document.getElementById(id).classList.add('open'); document.body.style.overflow='hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow=''; }
 
document.querySelectorAll('.modal-overlay').forEach(o => o.addEventListener('click', e => { if (e.target === o) closeModal(o.id); }));
 
function openDetail(id) {
  const m = DATA.find(x => x.id === id);
  if (!m) return;
  document.getElementById('detailModalTitle').textContent = m.nombre;
  document.getElementById('detailModalCode').textContent = m.codigo;
  document.getElementById('detailModalBody').innerHTML = `
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px">
      <div style="background:var(--s50);border-radius:10px;padding:14px;border:1px solid var(--s100)">
        <div style="font-size:11px;font-weight:600;letter-spacing:.05em;color:var(--s400);text-transform:uppercase;margin-bottom:8px">Identificación</div>
        <table style="width:100%;border-collapse:collapse;font-size:13px">
          <tr><td style="color:var(--s500);padding:4px 0">Código</td><td style="text-align:right;font-family:'DM Mono',monospace;font-weight:500;color:var(--bl)">${m.codigo}</td></tr>
          <tr><td style="color:var(--s500);padding:4px 0">Categoría</td><td style="text-align:right;color:var(--s700)">${m.categoria}</td></tr>
          <tr><td style="color:var(--s500);padding:4px 0">Marca</td><td style="text-align:right;color:var(--s700)">${m.marca}</td></tr>
          <tr><td style="color:var(--s500);padding:4px 0">Unidad</td><td style="text-align:right;color:var(--s700)">${m.unidad}</td></tr>
        </table>
      </div>
      <div style="background:var(--s50);border-radius:10px;padding:14px;border:1px solid var(--s100)">
        <div style="font-size:11px;font-weight:600;letter-spacing:.05em;color:var(--s400);text-transform:uppercase;margin-bottom:8px">Inventario</div>
        <table style="width:100%;border-collapse:collapse;font-size:13px">
          <tr><td style="color:var(--s500);padding:4px 0">Stock Actual</td><td style="text-align:right;font-weight:700;font-size:18px;color:var(--s800)">${m.stock}</td></tr>
          <tr><td style="color:var(--s500);padding:4px 0">Stock Mínimo</td><td style="text-align:right;color:var(--s700)">${m.min}</td></tr>
          <tr><td style="color:var(--s500);padding:4px 0">Estado</td><td style="text-align:right"><span class="status-badge ${m.status}">${statusLabel[m.status]}</span></td></tr>
        </table>
      </div>
    </div>
    <div style="background:var(--gp);border:1px solid rgba(93,179,71,.2);border-radius:10px;padding:14px;display:flex;align-items:center;gap:12px">
      <i class="fas fa-chart-line" style="color:var(--gm);font-size:20px;flex-shrink:0"></i>
      <div>
        <div style="font-size:12.5px;font-weight:600;color:var(--gd);margin-bottom:2px">Historial de movimientos</div>
        <div style="font-size:12px;color:var(--s600)">Últimos 30 días: <strong>+45 ingresos</strong> · <strong>−28 salidas</strong></div>
      </div>
    </div>
  `;
  openModal('matDetailModal');
}
 
function confirmDelete(name) {
  if (confirm(`¿Eliminar "${name}"?`)) alert('Eliminado ✓');
}
 
// ── COUNTER ANIMATION ──
function animateCounter(el, target, duration = 1200) {
  const start = performance.now();
  function step(now) {
    const elapsed = now - start;
    const progress = Math.min(elapsed / duration, 1);
    const eased = 1 - Math.pow(1 - progress, 3);
    el.textContent = Math.round(target * eased).toLocaleString();
    if (progress < 1) requestAnimationFrame(step);
  }
  requestAnimationFrame(step);
}
 
// ── STAT BAR ANIMATION ──
function animateBars() {
  document.querySelectorAll('.stat-fill').forEach(el => {
    const w = el.dataset.w;
    setTimeout(() => { el.style.width = w; }, 400);
  });
}
 
// ── INIT ──
window.addEventListener('DOMContentLoaded', () => {
  renderTable();
 
  const counters = document.querySelectorAll('[data-target]');
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        animateCounter(e.target, +e.target.dataset.target);
        obs.unobserve(e.target);
      }
    });
  }, { threshold: .1 });
  counters.forEach(c => obs.observe(c));
 
  animateBars();
 
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') document.querySelectorAll('.modal-overlay.open').forEach(m => closeModal(m.id));
  });
});
