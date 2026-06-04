/* ============================================
   InfraEnercom S.A.C. — Login Logic
   ============================================ */

(function () {
  'use strict';

  /* ── Estado global del flujo de recuperación ── */
  let timerID   = null;
  let resetEmail = null;
  let resetCode  = null;

  /* ══════════════════════════════════════════
     Helpers
  ══════════════════════════════════════════ */

  function showPanel(id) {
    document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
    const panel = document.getElementById(id);
    if (panel) {
      panel.classList.add('active');
      const first = panel.querySelector('input');
      if (first) setTimeout(() => first.focus(), 80);
    }
    clearAlerts();
  }

  function showAlert(panelId, type, message) {
    const alert = document.getElementById('alert-' + panelId);
    if (!alert) return;
    alert.className = 'alert ' + type;
    alert.querySelector('.alert-msg').textContent = message;
    alert.querySelector('.alert-icon').textContent =
      type === 'error' ? '✕' : type === 'success' ? '✓' : 'ℹ';
  }

  function clearAlerts() {
    document.querySelectorAll('.alert').forEach(a => (a.className = 'alert'));
  }

  function startTimer(secs) {
    stopTimer();
    const display = document.getElementById('timer-display');
    const btn     = document.getElementById('btn-resend');
    if (btn) { btn.dataset.disabled = 'true'; btn.style.opacity = '0.4'; }

    let remaining = secs;

    function tick() {
      if (!display) return;
      const m = Math.floor(remaining / 60);
      const s = remaining % 60;
      display.textContent = m + ':' + (s < 10 ? '0' : '') + s;
      if (remaining <= 0) {
        stopTimer();
        display.textContent = '';
        if (btn) { btn.dataset.disabled = 'false'; btn.style.opacity = ''; }
        return;
      }
      remaining--;
    }

    tick();
    timerID = setInterval(tick, 1000);
  }

  function stopTimer() {
    if (timerID) { clearInterval(timerID); timerID = null; }
  }

  /* ══════════════════════════════════════════
     PANEL 1 — Login
  ══════════════════════════════════════════ */

  function initLogin() {
    const form = document.getElementById('form-login');
    if (!form) return;

    form.addEventListener('submit', async function (e) {
      e.preventDefault();

      const btn      = document.getElementById('btn-login');
      const emailVal = document.getElementById('login-email').value.trim().toLowerCase();
      const passVal  = document.getElementById('login-pass').value;

      if (!emailVal || !passVal) {
        Swal.fire({ icon: 'warning', title: 'Campos requeridos', text: 'Debes ingresar correo y contraseña.' });
        return;
      }

      const originalHTML = btn.innerHTML;
      btn.disabled = true;
      btn.innerHTML = `
        <svg style="animation:spin 1s linear infinite;width:16px;height:16px"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
        </svg>
        Verificando...
      `;

      if (!document.getElementById('spin-style')) {
        const s = document.createElement('style');
        s.id = 'spin-style';
        s.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
        document.head.appendChild(s);
      }

      try {
        const csrf = document.querySelector('meta[name="csrf-token"]');
        if (!csrf) throw new Error('Token CSRF no encontrado. Recarga la página.');

        const response = await fetch('/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf.content,
          },
          body: JSON.stringify({ email: emailVal, password: passVal }),
        });

        let data = {};
        const contentType = response.headers.get('Content-Type') || '';

        if (contentType.includes('application/json')) {
          data = await response.json();
        } else {
          const text = await response.text();
          console.error('Respuesta no-JSON del servidor:', text);
          throw new Error('El servidor devolvió una respuesta inesperada. Revisa los logs.');
        }

        if (response.ok && data.success) {
          await Swal.fire({
            icon: 'success',
            title: '¡Bienvenido!',
            text: data.message || 'Acceso concedido.',
            timer: 1500,
            showConfirmButton: false,
          });

          if (!data.redirect) {
            Swal.fire({ icon: 'error', title: 'Error de configuración', text: 'El servidor no devolvió la URL de destino.' });
            return;
          }

          window.location.href = data.redirect;

        } else {
          Swal.fire({ icon: 'error', title: 'Acceso denegado', text: data.message || 'Error desconocido.' });
          document.getElementById('login-pass').value = '';
          document.getElementById('login-pass').focus();
        }

      } catch (error) {
        console.error('LOGIN ERROR:', error);
        Swal.fire({ icon: 'error', title: 'Error de conexión', text: error.message || 'No se pudo conectar con el servidor.' });

      } finally {
        btn.disabled = false;
        btn.innerHTML = originalHTML;
      }
    });
  }

  /* ══════════════════════════════════════════
     PANEL 2 — Forgot password
  ══════════════════════════════════════════ */

  function initForgot() {
    const form = document.getElementById('form-forgot');
    if (!form) return;

    form.addEventListener('submit', async function (e) {
      e.preventDefault();

      const email = document.getElementById('forgot-email').value.trim().toLowerCase();

      if (!email) {
        Swal.fire({ icon: 'warning', title: 'Correo requerido', text: 'Ingresa tu correo electrónico.' });
        return;
      }

      try {
        Swal.fire({
          title: 'Enviando código...',
          text: 'Por favor espera',
          allowOutsideClick: false,
          allowEscapeKey: false,
          didOpen: () => Swal.showLoading(),
        });

        const response = await fetch('/auth/forgot-password', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify({ email }),
        });

        const data = await response.json();
        Swal.close();

        if (response.ok && data.success) {
          resetEmail = email;

          const subtitle = document.getElementById('otp-subtitle');
          if (subtitle) subtitle.textContent = 'Código enviado a ' + email;

          await Swal.fire({ icon: 'success', title: 'Código enviado', text: data.message, confirmButtonText: 'Continuar' });

          showPanel('panel-otp');
          startTimer(120);

        } else {
          Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'No fue posible enviar el código.' });
        }

      } catch (error) {
        console.error(error);
        Swal.fire({ icon: 'error', title: 'Error de conexión', text: 'No se pudo conectar con el servidor.' });
      }
    });
  }

  /* ══════════════════════════════════════════
     PANEL 3 — OTP verification
  ══════════════════════════════════════════ */

  function initOTP() {
    const cells = document.querySelectorAll('.otp-wrap input');

    cells.forEach((cell, idx) => {
      cell.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 1);
        this.classList.toggle('filled', this.value !== '');
        if (this.value && idx < cells.length - 1) cells[idx + 1].focus();
      });

      cell.addEventListener('keydown', function (e) {
        if (e.key === 'Backspace' && !this.value && idx > 0) {
          cells[idx - 1].focus();
          cells[idx - 1].value = '';
          cells[idx - 1].classList.remove('filled');
        }
      });

      cell.addEventListener('paste', function (e) {
        e.preventDefault();
        const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
        pasted.split('').slice(0, 6).forEach((ch, i) => {
          if (cells[idx + i]) {
            cells[idx + i].value = ch;
            cells[idx + i].classList.add('filled');
          }
        });
        const next = cells[Math.min(idx + pasted.length, 5)];
        if (next) next.focus();
      });
    });

    const form = document.getElementById('form-otp');
    if (!form) return;

    form.addEventListener('submit', async function (e) {
      e.preventDefault();

      const code = Array.from(cells).map(c => c.value).join('');

      if (code.length !== 6) {
        Swal.fire({ icon: 'warning', title: 'Código incompleto', text: 'Ingresa los 6 dígitos.' });
        return;
      }

      try {
        Swal.fire({
          title: 'Verificando código...',
          allowOutsideClick: false,
          allowEscapeKey: false,
          didOpen: () => Swal.showLoading(),
        });

        const response = await fetch('/auth/verify-code', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify({ email: resetEmail, code }),
        });

        const data = await response.json();
        Swal.close();

        if (response.ok && data.success) {
          stopTimer();
          resetCode = code; // ✅ Guardar para el paso final

          await Swal.fire({ icon: 'success', title: 'Código válido', text: data.message });

          showPanel('panel-newpass');

        } else {
          Swal.fire({ icon: 'error', title: 'Código incorrecto', text: data.message });
          cells.forEach(c => { c.value = ''; c.classList.remove('filled'); });
          cells[0].focus();
        }

      } catch (error) {
        console.error(error);
        Swal.fire({ icon: 'error', title: 'Error', text: 'No fue posible validar el código.' });
      }
    });

    /* ── Botón reenvío ── */
    const resendBtn = document.getElementById('btn-resend');
    if (!resendBtn) return;

    resendBtn.addEventListener('click', async function (e) {
      e.preventDefault();

      if (this.dataset.disabled === 'true') return;

      try {
        Swal.fire({
          title: 'Reenviando código...',
          allowOutsideClick: false,
          allowEscapeKey: false,
          didOpen: () => Swal.showLoading(),
        });

        const response = await fetch('/auth/forgot-password', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify({ email: resetEmail }),
        });

        const data = await response.json();
        Swal.close();

        if (response.ok && data.success) {
          Swal.fire({ icon: 'success', title: 'Código reenviado', text: data.message });
          cells.forEach(c => { c.value = ''; c.classList.remove('filled'); });
          cells[0].focus();
          startTimer(120);

        } else {
          Swal.fire({ icon: 'error', title: 'Error', text: data.message });
        }

      } catch (error) {
        console.error(error);
        Swal.fire({ icon: 'error', title: 'Error', text: 'No fue posible reenviar el código.' });
      }
    });
  }

  /* ══════════════════════════════════════════
     PANEL 4 — New password
  ══════════════════════════════════════════ */

  function initNewPass() {
    /* Indicador de fortaleza */
    const passInput = document.getElementById('new-pass');
    const bars      = document.querySelector('.pass-strength');
    const label     = document.getElementById('pass-strength-label');

    if (passInput && bars) {
      passInput.addEventListener('input', function () {
        const v = this.value;
        let strength = 0;
        if (v.length >= 8)          strength++;
        if (/[A-Z]/.test(v))        strength++;
        if (/[0-9]/.test(v))        strength++;
        if (/[^A-Za-z0-9]/.test(v)) strength++;

        bars.className = 'pass-strength ' + (['', 'weak', 'fair', 'strong', 'great'][strength] || '');
        if (label) label.textContent = ['', 'Débil', 'Regular', 'Fuerte', 'Muy fuerte'][strength] || '';
      });
    }

    const form = document.getElementById('form-newpass');
    if (!form) return;

    form.addEventListener('submit', async function (e) {
      e.preventDefault();

      const p1 = document.getElementById('new-pass').value;
      const p2 = document.getElementById('confirm-pass').value;

      if (p1.length < 8) {
        showAlert('newpass', 'error', 'La contraseña debe tener al menos 8 caracteres.');
        return;
      }
      if (p1 !== p2) {
        showAlert('newpass', 'error', 'Las contraseñas no coinciden.');
        return;
      }

      try {
        Swal.fire({
          title: 'Guardando contraseña...',
          allowOutsideClick: false,
          allowEscapeKey: false,
          didOpen: () => Swal.showLoading(),
        });

        const response = await fetch('/auth/reset-password', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify({
            email:                 resetEmail,
            code:                  resetCode,
            password:              p1,
            password_confirmation: p2,
          }),
        });

        const data = await response.json();
        Swal.close();

        if (response.ok && data.success) {
          await Swal.fire({ icon: 'success', title: '¡Listo!', text: data.message });
          showPanel('panel-login');
          showAlert('login', 'success', 'Contraseña actualizada. Inicia sesión.');

        } else {
          Swal.fire({ icon: 'error', title: 'Error', text: data.message });
        }

      } catch (error) {
        console.error(error);
        Swal.fire({ icon: 'error', title: 'Error', text: 'No fue posible guardar la contraseña.' });
      }
    });
  }

  /* ══════════════════════════════════════════
     Toggle visibilidad de contraseña
  ══════════════════════════════════════════ */

  function initToggles() {
    document.querySelectorAll('.btn-toggle-pass').forEach(btn => {
      btn.addEventListener('click', function () {
        const target = document.getElementById(this.dataset.target);
        if (!target) return;
        const isHidden = target.type === 'password';
        target.type = isHidden ? 'text' : 'password';
        this.setAttribute('aria-label', isHidden ? 'Ocultar contraseña' : 'Mostrar contraseña');
        this.querySelector('.icon-eye').style.display     = isHidden ? 'none'  : 'block';
        this.querySelector('.icon-eye-off').style.display = isHidden ? 'block' : 'none';
      });
    });
  }

  /* ══════════════════════════════════════════
     Navegación entre paneles
  ══════════════════════════════════════════ */

  function initNavLinks() {
    document.querySelectorAll('[data-goto]').forEach(el => {
      el.addEventListener('click', function (e) {
        e.preventDefault();
        showPanel(this.dataset.goto);
      });
    });
  }

  /* ══════════════════════════════════════════
     Boot
  ══════════════════════════════════════════ */

  document.addEventListener('DOMContentLoaded', function () {
    initLogin();
    initForgot();
    initOTP();
    initNewPass();
    initToggles();
    initNavLinks();
  });

})();