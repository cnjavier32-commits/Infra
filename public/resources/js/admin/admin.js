/* ============================================================
   layout.js — InfraEnercom S.A.C. v2.0
   GSAP 3 + Lucide Icons + animaciones premium
   ============================================================ */

(function () {
  'use strict';

  /* ── Inicializar iconos Lucide ────────────────────────────── */
  if (typeof lucide !== 'undefined') {
    lucide.createIcons();
  }

  /* ── Elementos ──────────────────────────────────────────── */
  const sidebar = document.getElementById('appSidebar');
  const overlay = document.getElementById('sidebarOverlay');
  const toggleBtn = document.getElementById('sidebarToggle');
  const closeBtn = document.getElementById('sidebarClose');
  const userPill = document.getElementById('userPill');
  const notifWrap = document.getElementById('notifWrap');
  const searchWrap = document.querySelector('.search-wrap');
  const searchToggle = document.getElementById('searchToggle');
  const searchInput = document.getElementById('searchInput');

  /* ── GSAP helper ──────────────────────────────────────────── */
  const g = typeof gsap !== 'undefined' ? gsap : null;

  /* ─────────────────────────────────────────
     ANIMACIÓN DE ENTRADA (page load)
  ───────────────────────────────────────── */
  function runPageEntrance() {
    if (!g) return;

    const ease = 'power3.out';

    /* Sidebar entra desde la izquierda */
    g.fromTo('#appSidebar',
      { x: -20, opacity: 0 },
      { x: 0, opacity: 1, duration: .55, ease }
    );

    /* Header cae desde arriba */
    g.fromTo('#appHeader',
      { y: -16, opacity: 0 },
      { y: 0, opacity: 1, duration: .45, delay: .18, ease }
    );

    /* Stat cards en cascada */
    const statCards = document.querySelectorAll('.stat-card');
    if (statCards.length) {
      g.fromTo(statCards,
        { y: 18, opacity: 0 },
        { y: 0, opacity: 1, duration: .45, stagger: .07, delay: .3, ease }
      );
    }

    /* Sección de tabla */
    const sectionCards = document.querySelectorAll('.section-card');
    if (sectionCards.length) {
      g.fromTo(sectionCards,
        { y: 14, opacity: 0 },
        { y: 0, opacity: 1, duration: .45, delay: .6, ease }
      );
    }

    /* Filas de tabla */
    const rows = document.querySelectorAll('tbody tr');
    if (rows.length) {
      g.fromTo(rows,
        { x: -10, opacity: 0 },
        { x: 0, opacity: 1, duration: .35, stagger: .06, delay: .75, ease }
      );
    }

    /* Barras de progreso en stat cards */
    document.querySelectorAll('.stat-fill').forEach(fill => {
      const target = fill.dataset.width || '60%';
      g.to(fill, { width: target, duration: 1.3, delay: .5, ease: 'power2.out' });
    });

    /* Storage bar */
    const storFill = document.querySelector('.storage-fill');
    if (storFill) {
      const pct = storFill.dataset.width || '63%';
      g.to(storFill, { width: pct, duration: 1.2, delay: .8, ease: 'power2.out' });
    }

    /* Contadores animados */
    document.querySelectorAll('[data-counter]').forEach(el => {
      const target = parseInt(el.dataset.counter, 10) || 0;
      const proxy = { val: 0 };
      g.to(proxy, {
        val: target,
        duration: 1.4,
        delay: .5,
        ease: 'power2.out',
        onUpdate() {
          el.textContent = Math.round(proxy.val).toLocaleString('es-PE');
        },
      });
    });

    /* Atributos genéricos */
    const fadeEls = document.querySelectorAll('[data-gsap-fade]');
    const slideEls = document.querySelectorAll('[data-gsap-slide]');
    if (fadeEls.length) g.to(fadeEls, { opacity: 1, y: 0, duration: .45, stagger: .06, delay: .4, ease });
    if (slideEls.length) g.to(slideEls, { opacity: 1, x: 0, duration: .4, stagger: .05, delay: .45, ease });
  }

  /* ─────────────────────────────────────────
     SIDEBAR — abrir / cerrar
  ───────────────────────────────────────── */
  function openSidebar() {
    sidebar?.classList.add('open');
    overlay?.classList.add('visible');
    document.body.style.overflow = 'hidden';

    if (g && sidebar) {
      g.fromTo(sidebar, { x: -30 }, { x: 0, duration: .35, ease: 'power3.out' });
    }
  }

  function closeSidebar() {
    if (g && sidebar) {
      g.to(sidebar, {
        x: -20, opacity: .5, duration: .22, ease: 'power2.in',
        onComplete() {
          sidebar.classList.remove('open');
          g.set(sidebar, { x: 0, opacity: 1 });
          overlay?.classList.remove('visible');
          document.body.style.overflow = '';
        },
      });
    } else {
      sidebar?.classList.remove('open');
      overlay?.classList.remove('visible');
      document.body.style.overflow = '';
    }
  }

  toggleBtn?.addEventListener('click', openSidebar);
  closeBtn?.addEventListener('click', closeSidebar);
  overlay?.addEventListener('click', closeSidebar);

  /* ─────────────────────────────────────────
     SUBMENÚS
  ───────────────────────────────────────── */
  window.toggleSub = function (el) {
    const subId = el.dataset.sub;
    const sub = subId ? document.getElementById(subId) : el.nextElementSibling;
    const isOpen = el.classList.toggle('open');

    if (sub) {
      if (isOpen) {
        sub.classList.add('open');
        if (g) {
          const items = sub.querySelectorAll('.nav-item');
          g.fromTo(items,
            { x: -8, opacity: 0 },
            { x: 0, opacity: 1, duration: .25, stagger: .04, ease: 'power2.out' }
          );
        }
      } else {
        sub.classList.remove('open');
      }
    }
  };

  /* ─────────────────────────────────────────
     DROPDOWN: usuario
  ───────────────────────────────────────── */
  userPill?.addEventListener('click', function (e) {
    e.stopPropagation();
    const willOpen = !userPill.classList.contains('open');
    closeAllDropdowns();
    if (willOpen) userPill.classList.add('open');
  });

  /* ─────────────────────────────────────────
     DROPDOWN: notificaciones
  ───────────────────────────────────────── */
  document.getElementById('notifToggle')?.addEventListener('click', function (e) {
    e.stopPropagation();
    const willOpen = !notifWrap?.classList.contains('open');
    closeAllDropdowns();
    if (willOpen) {
      notifWrap?.classList.add('open');
      loadNotifications();
    }
  });

  /* ─────────────────────────────────────────
     DROPDOWN: búsqueda
  ───────────────────────────────────────── */
  searchToggle?.addEventListener('click', function (e) {
    e.stopPropagation();
    const willOpen = !searchWrap?.classList.contains('open');
    closeAllDropdowns();
    if (willOpen) {
      searchWrap?.classList.add('open');
      setTimeout(() => searchInput?.focus(), 60);
    }
  });

  searchInput?.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { searchWrap?.classList.remove('open'); searchToggle?.focus(); }
  });

  function closeAllDropdowns() {
    userPill?.classList.remove('open');
    notifWrap?.classList.remove('open');
    searchWrap?.classList.remove('open');
  }

  document.addEventListener('click', closeAllDropdowns);
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeSidebar(); closeAllDropdowns(); }
  });

  /* ─────────────────────────────────────────
     HOVER micro-animations en nav items
  ───────────────────────────────────────── */
  function initNavHovers() {
    if (!g) return;
    document.querySelectorAll('.app-sidebar .nav-item').forEach(item => {
      item.addEventListener('mouseenter', () => {
        if (!item.classList.contains('active')) {
          g.to(item, { x: 3, duration: .15, ease: 'power2.out' });
        }
      });
      item.addEventListener('mouseleave', () => {
        g.to(item, { x: 0, duration: .15, ease: 'power2.in' });
      });
    });
  }

  /* ─────────────────────────────────────────
     MARCAR NOTIFICACIONES
  ───────────────────────────────────────── */
  document.querySelector('.notif-mark-all')?.addEventListener('click', function (e) {
    e.preventDefault();
    fetch('/notifications/mark-all-read', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
        'Accept': 'application/json',
      },
    })
      .then(r => r.json())
      .then(() => {
        const dot = document.querySelector('.notif-dot');
        if (dot && g) {
          g.to(dot, { scale: 0, duration: .2, ease: 'back.in(1.7)', onComplete: () => dot.remove() });
        } else { dot?.remove(); }
        document.getElementById('notifList').innerHTML = `
        <div class="notif-empty">
          <svg data-lucide="bell-off"></svg>
          <span>Sin notificaciones</span>
        </div>`;
        if (typeof lucide !== 'undefined') lucide.createIcons();
      })
      .catch(err => console.warn('[NOTIF]', err));
  });

  /* ─────────────────────────────────────────
     CARGAR NOTIFICACIONES vía AJAX
  ───────────────────────────────────────── */
  function loadNotifications() {
    const list = document.getElementById('notifList');
    if (!list) return;

    fetch('/notifications', {
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
      },
    })
      .then(r => r.ok ? r.json() : null)
      .then(data => {
        if (!data || !data.length) {
          list.innerHTML = `
          <div class="notif-empty">
            <svg data-lucide="bell-off"></svg>
            <span>Sin notificaciones</span>
          </div>`;
          if (typeof lucide !== 'undefined') lucide.createIcons();
          return;
        }

        list.innerHTML = data.map(n => `
        <div class="notif-item ${n.read ? '' : 'unread'}" data-id="${n.id}">
          <div class="notif-icon"><svg data-lucide="${n.icon || 'bell'}"></svg></div>
          <div class="notif-body">
            <div class="notif-msg">${n.message}</div>
            <div class="notif-time">${n.time}</div>
          </div>
        </div>`
        ).join('');

        if (typeof lucide !== 'undefined') lucide.createIcons();

        if (g) {
          const items = list.querySelectorAll('.notif-item');
          g.fromTo(items,
            { x: -8, opacity: 0 },
            { x: 0, opacity: 1, duration: .25, stagger: .05, ease: 'power2.out' }
          );
        }
      })
      .catch(() => { });
  }

  /* ─────────────────────────────────────────
     LOGOUT con confirmación SweetAlert2
  ───────────────────────────────────────── */
  document
    .getElementById('logoutForm')
    ?.addEventListener('submit', function (e) {

      e.preventDefault();

      const form = this;

      Swal.fire({
        title: '¿Cerrar sesión?',
        text: 'Tu sesión actual será finalizada.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, salir',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#1a3a6b',
        cancelButtonColor: '#64748b'
      }).then((result) => {

        if (result.isConfirmed) {
          form.submit();
        }

      });

    });

  /* ─────────────────────────────────────────
     INIT
  ───────────────────────────────────────── */
  document.addEventListener('DOMContentLoaded', function () {
    runPageEntrance();
    initNavHovers();
    if (typeof lucide !== 'undefined') lucide.createIcons();
  });

})();