/* ============================================================
   INFRAENERCOM · PLANTILLA DE LAYOUT — script.js
   Controla únicamente el shell (sidebar + topbar + responsive).
   El contenido de cada página se monta en #pageContent y puede
   escuchar los eventos que este shell dispara (ver abajo).
   ============================================================ */

lucide.createIcons();

const VIEW_TITLES = {
  dashboard:  ['Panel general',    'Resumen operativo del almacén'],
  entradas:   ['Entradas',         'Registro de ingresos de materiales'],
  salidas:    ['Salidas',          'Registro de despachos a obra'],
  inventario: ['Materiales',       'Catálogo completo de inventario'],
  reportes:   ['Reportes',         'Exporta y analiza periodos pasados'],
  alertas:    ['Alertas de stock', 'Materiales que requieren reposición'],
  config:     ['Configuración',    'Preferencias del sistema'],
};

/* ---------------- FECHA ---------------- */

(function setDate() {
  const el = document.getElementById('viewDate');
  const formatted = new Date().toLocaleDateString('es-PE', { weekday: 'long', day: 'numeric', month: 'long' });
  el.textContent = formatted.charAt(0).toUpperCase() + formatted.slice(1);
})();

/* ---------------- SIDEBAR: colapso (desktop) + drawer (mobile) ---------------- */

const app = document.getElementById('app');
const collapseBtn = document.getElementById('collapseBtn');
const menuBtn = document.getElementById('menuBtn');
const scrim = document.getElementById('scrim');

collapseBtn?.addEventListener('click', () => app.classList.toggle('is-collapsed'));

function openDrawer() {
  app.classList.add('is-drawer-open');
  document.body.style.overflow = 'hidden';
}
function closeDrawer() {
  app.classList.remove('is-drawer-open');
  document.body.style.overflow = '';
}
menuBtn?.addEventListener('click', openDrawer);
scrim?.addEventListener('click', closeDrawer);
document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeDrawer(); });

/* Mantiene el estado del layout coherente al cruzar breakpoints
   (evita drawers o colapsos "atascados" al redimensionar). */
const desktopQuery = window.matchMedia('(min-width: 769px)');
const tabletDownQuery = window.matchMedia('(max-width: 1024px)');

function reconcileLayout() {
  if (desktopQuery.matches) closeDrawer();
  if (tabletDownQuery.matches) app.classList.remove('is-collapsed');
}
desktopQuery.addEventListener('change', reconcileLayout);
tabletDownQuery.addEventListener('change', reconcileLayout);
window.addEventListener('resize', () => {
  clearTimeout(window.__resizeT);
  window.__resizeT = setTimeout(reconcileLayout, 120);
});

/* ---------------- NAVEGACIÓN ---------------- */

const allNodes = document.querySelectorAll('[data-node]');
const viewTitle = document.getElementById('viewTitle');
const viewDesc = document.querySelector('.topbar-title p');

function setActiveView(view) {
  allNodes.forEach(n => n.classList.toggle('is-active', n.dataset.view === view));
  const meta = VIEW_TITLES[view] || ['Página', ''];
  viewTitle.textContent = meta[0];
  viewDesc.textContent = meta[1];
  pulseRail();
  // Las páginas escuchan este evento para renderizar su propio contenido
  // en #pageContent según la vista seleccionada.
  document.dispatchEvent(new CustomEvent('app:navigate', { detail: { view } }));
}

allNodes.forEach(node => {
  node.addEventListener('click', (e) => {
    e.preventDefault();
    setActiveView(node.dataset.view);
    closeDrawer();
  });
});

document.querySelector('[data-fab]')?.addEventListener('click', (e) => {
  e.preventDefault();
  document.dispatchEvent(new CustomEvent('app:fab-click'));
});

/* ---------------- BUSCADOR Y ACCIONES DEL TOPBAR ----------------
   El shell no filtra nada por sí mismo: emite eventos para que el
   contenido de la página actual decida qué hacer. */

document.getElementById('searchInput')?.addEventListener('input', (e) => {
  document.dispatchEvent(new CustomEvent('app:search', { detail: { value: e.target.value } }));
});

document.getElementById('newMovementBtn')?.addEventListener('click', () => {
  document.dispatchEvent(new CustomEvent('app:action', { detail: { action: 'primary' } }));
});

/* ---------------- FIRMA VISUAL: riel de energía con pulso ---------------- */

function pulseRail() {
  const svg = document.getElementById('railSvg');
  if (!svg || svg.closest('.nav-rail').offsetParent === null) return; // oculto en tablet/mobile
  const h = svg.parentElement.clientHeight || 300;
  if (h < 10) return;
  svg.setAttribute('viewBox', `0 0 4 ${h}`);
  svg.innerHTML = `
    <line class="rail-line" x1="2" y1="0" x2="2" y2="${h}"></line>
    <circle class="rail-pulse" cx="2" cy="0" r="3"></circle>
  `;
  const pulse = svg.querySelector('.rail-pulse');
  if (window.gsap) {
    gsap.fromTo(pulse, { cy: 0 }, { cy: h, duration: 1.1, ease: 'power2.inOut' });
  } else {
    pulse.setAttribute('cy', h);
  }
}
window.addEventListener('resize', pulseRail);

/* ---------------- TOAST (utilidad reutilizable para todo el proyecto) ---------------- */

let toastTimer;
function showToast(msg) {
  const toast = document.getElementById('toast');
  toast.innerHTML = `<span class="dot"></span> ${msg}`;
  toast.classList.add('is-visible');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => toast.classList.remove('is-visible'), 2800);
}

/* API pública del shell para que los scripts de cada página lo usen */
window.AppShell = { showToast, setActiveView };

/* ---------------- INIT ---------------- */

const dropdown = document.querySelector(".user-dropdown");
const button = document.getElementById("userMenuButton");

button.addEventListener("click", function (e) {

    e.stopPropagation();

    dropdown.classList.toggle("active");

});

//Cerrar al hacer click fuera

document.addEventListener("click", function () {

    dropdown.classList.remove("active");

});

//Evitar que se cierre al hacer click dentro

document.getElementById("userDropdown")
.addEventListener("click", function(e){

    e.stopPropagation();

});

pulseRail();