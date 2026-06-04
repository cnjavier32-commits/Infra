<!DOCTYPE html>
<html lang="es">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>InfraEnercom S.A.C. — Acceso Administrativo</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('resources/css/log/log.css') }}" />
</head>
<body>

  <!-- Background decorations -->
  <div class="bg-orb" aria-hidden="true"></div>
  <div class="bg-diamonds" aria-hidden="true">
    <span></span><span></span><span></span><span></span><span></span>
  </div>

  <main class="login-wrapper" role="main">
    <div class="card">

      <!-- ── Header ── -->
      <header class="card-header">
        <div class="brand">
          <!-- Diamond logo (SVG recreation based on brand) -->
          <div class="brand-logo">
            <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <!-- Outer diamond -->
              <polygon points="24,2 46,24 24,46 2,24"
                fill="none" stroke="#5db347" stroke-width="3"/>
              <!-- Inner diamonds split -->
              <polygon points="24,8 38,24 24,40 10,24"
                fill="#1a3a6b" opacity="0.9"/>
              <!-- Green half -->
              <polygon points="24,8 38,24 24,24 10,24"
                fill="#3a8c2f" opacity="0.85"/>
              <!-- Gold accent -->
              <polygon points="24,22 28,24 24,26 20,24"
                fill="#f0c020"/>
            </svg>
          </div>

          <div class="brand-text">
            <div class="brand-name">
              <em>Infra</em>Enercom<sub class="brand-sac">S.A.C.</sub>
            </div>
            <div class="brand-tagline">Infraestructura Energía y Comunicaciones</div>
          </div>
        </div>
        <p class="header-title">&#x1F512;&nbsp; Panel de Administración</p>
      </header>

      <!-- ── Body ── -->
      <div class="card-body">

        <!-- ════════════════════════════════
             PANEL 1 · Login
        ════════════════════════════════ -->
        <section id="panel-login" class="panel active" aria-label="Iniciar sesión">

          <h1 class="section-title">Iniciar sesión</h1>
          <p class="section-sub">Ingresa tus credenciales de administrador</p>

          <div class="alert" id="alert-login" role="alert">
            <span class="alert-icon" aria-hidden="true"></span>
            <span class="alert-msg"></span>
          </div>

          <form id="form-login" novalidate>

            <div class="field">
              <label for="login-email">Correo electrónico</label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" aria-hidden="true">
                  <rect x="2" y="4" width="20" height="16" rx="2"/>
                  <polyline points="2,4 12,13 22,4"/>
                </svg>
                <input type="email" id="login-email" name="email"
                       placeholder="admin@infraenercom.com"
                       autocomplete="username" required />
              </div>
            </div>

            <div class="field">
              <label for="login-pass">Contraseña</label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" aria-hidden="true">
                  <rect x="3" y="11" width="18" height="11" rx="2"/>
                  <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <input type="password" id="login-pass" name="password"
                       placeholder="••••••••"
                       autocomplete="current-password" required />
                <button type="button" class="btn-toggle-pass"
                        data-target="login-pass"
                        aria-label="Mostrar contraseña">
                  <!-- Eye open -->
                  <svg class="icon-eye" viewBox="0 0 24 24" fill="none"
                       stroke="currentColor" stroke-width="2" stroke-linecap="round"
                       stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                  </svg>
                  <!-- Eye off (hidden by default) -->
                  <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none"
                       stroke="currentColor" stroke-width="2" stroke-linecap="round"
                       stroke-linejoin="round" style="display:none">
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                    <line x1="1" y1="1" x2="23" y2="23"/>
                  </svg>
                </button>
              </div>
            </div>

            <div class="row-forgot">
              <a class="link" data-goto="panel-forgot" href="#" role="button">
                ¿Olvidaste tu contraseña?
              </a>
            </div>

            <button id="btn-login" type="submit" class="btn-primary">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                   aria-hidden="true">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                <polyline points="10 17 15 12 10 7"/>
                <line x1="15" y1="12" x2="3" y2="12"/>
              </svg>
              Ingresar al sistema
            </button>

          </form>

          <!-- Demo hint -->
          <p style="text-align:center; font-size:0.7rem; color:var(--gray-500); margin-top:1rem;">
            Demo: <strong>admin@infraenercom.com</strong> / <strong>Admin2024!</strong>
          </p>

        </section>

        <!-- ════════════════════════════════
             PANEL 2 · Recuperar contraseña
        ════════════════════════════════ -->
        <section id="panel-forgot" class="panel" aria-label="Recuperar contraseña">

          <h1 class="section-title">Recuperar contraseña</h1>
          <p class="section-sub">Te enviaremos un código de 6 dígitos a tu correo registrado</p>

          <div class="alert" id="alert-forgot" role="alert">
            <span class="alert-icon" aria-hidden="true"></span>
            <span class="alert-msg"></span>
          </div>

          <form id="form-forgot" novalidate>

            <div class="field">
              <label for="forgot-email">Correo electrónico</label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" aria-hidden="true">
                  <rect x="2" y="4" width="20" height="16" rx="2"/>
                  <polyline points="2,4 12,13 22,4"/>
                </svg>
                <input type="email" id="forgot-email" name="email"
                       placeholder="admin@infraenercom.com"
                       autocomplete="email" required />
              </div>
            </div>

            <button type="submit" class="btn-primary">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                   aria-hidden="true">
                <line x1="22" y1="2" x2="11" y2="13"/>
                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
              </svg>
              Enviar código de verificación
            </button>

          </form>

          <div class="divider"><span>o</span></div>
          <div class="row-back">
            <a class="link" data-goto="panel-login" href="#" role="button">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/>
                <polyline points="12 19 5 12 12 5"/>
              </svg>
              Volver al inicio de sesión
            </a>
          </div>

        </section>

        <!-- ════════════════════════════════
             PANEL 3 · Verificar código OTP
        ════════════════════════════════ -->
        <section id="panel-otp" class="panel" aria-label="Verificar código">

          <h1 class="section-title">Verificar código</h1>
          <p class="section-sub" id="otp-subtitle">
            Ingresa el código de 6 dígitos enviado a tu correo
          </p>

          <div class="alert" id="alert-otp" role="alert">
            <span class="alert-icon" aria-hidden="true"></span>
            <span class="alert-msg"></span>
          </div>

          <form id="form-otp" novalidate>

            <div class="otp-wrap" role="group" aria-label="Código de verificación">
              <input type="text" inputmode="numeric" pattern="[0-9]*"
                     maxlength="1" autocomplete="one-time-code" aria-label="Dígito 1" />
              <input type="text" inputmode="numeric" pattern="[0-9]*"
                     maxlength="1" aria-label="Dígito 2" />
              <input type="text" inputmode="numeric" pattern="[0-9]*"
                     maxlength="1" aria-label="Dígito 3" />
              <input type="text" inputmode="numeric" pattern="[0-9]*"
                     maxlength="1" aria-label="Dígito 4" />
              <input type="text" inputmode="numeric" pattern="[0-9]*"
                     maxlength="1" aria-label="Dígito 5" />
              <input type="text" inputmode="numeric" pattern="[0-9]*"
                     maxlength="1" aria-label="Dígito 6" />
            </div>

            <div class="resend-row">
              <span>¿No llegó?</span>
              <a id="btn-resend" class="link" href="#" role="button">Reenviar</a>
              <span id="timer-display"></span>
            </div>

            <button type="submit" class="btn-primary">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                   aria-hidden="true">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
              Verificar código
            </button>

          </form>

          <div class="divider"><span>o</span></div>
          <div class="row-back">
            <a class="link" data-goto="panel-forgot" href="#" role="button">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/>
                <polyline points="12 19 5 12 12 5"/>
              </svg>
              Cambiar correo electrónico
            </a>
          </div>

        </section>

        <!-- ════════════════════════════════
             PANEL 4 · Nueva contraseña
        ════════════════════════════════ -->
        <section id="panel-newpass" class="panel" aria-label="Nueva contraseña">

          <h1 class="section-title">Nueva contraseña</h1>
          <p class="section-sub">Elige una contraseña segura para tu cuenta de administrador</p>

          <div class="alert" id="alert-newpass" role="alert">
            <span class="alert-icon" aria-hidden="true"></span>
            <span class="alert-msg"></span>
          </div>

          <form id="form-newpass" novalidate>

            <div class="field">
              <label for="new-pass">Nueva contraseña</label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" aria-hidden="true">
                  <rect x="3" y="11" width="18" height="11" rx="2"/>
                  <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <input type="password" id="new-pass" name="new-pass"
                       placeholder="Mínimo 8 caracteres"
                       autocomplete="new-password" required />
                <button type="button" class="btn-toggle-pass"
                        data-target="new-pass"
                        aria-label="Mostrar contraseña">
                  <svg class="icon-eye" viewBox="0 0 24 24" fill="none"
                       stroke="currentColor" stroke-width="2" stroke-linecap="round"
                       stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                  </svg>
                  <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none"
                       stroke="currentColor" stroke-width="2" stroke-linecap="round"
                       stroke-linejoin="round" style="display:none">
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                    <line x1="1" y1="1" x2="23" y2="23"/>
                  </svg>
                </button>
              </div>
              <!-- Strength indicator -->
              <div class="pass-strength" aria-hidden="true">
                <span></span><span></span><span></span><span></span>
              </div>
              <p class="pass-label" id="pass-strength-label"></p>
            </div>

            <div class="field">
              <label for="confirm-pass">Confirmar contraseña</label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" aria-hidden="true">
                  <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                <input type="password" id="confirm-pass" name="confirm-pass"
                       placeholder="Repite tu contraseña"
                       autocomplete="new-password" required />
                <button type="button" class="btn-toggle-pass"
                        data-target="confirm-pass"
                        aria-label="Mostrar contraseña">
                  <svg class="icon-eye" viewBox="0 0 24 24" fill="none"
                       stroke="currentColor" stroke-width="2" stroke-linecap="round"
                       stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                  </svg>
                  <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none"
                       stroke="currentColor" stroke-width="2" stroke-linecap="round"
                       stroke-linejoin="round" style="display:none">
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                    <line x1="1" y1="1" x2="23" y2="23"/>
                  </svg>
                </button>
              </div>
            </div>

            <button type="submit" class="btn-primary">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                   aria-hidden="true">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/>
                <polyline points="17 21 17 13 7 13 7 21"/>
                <polyline points="7 3 7 8 15 8"/>
              </svg>
              Guardar nueva contraseña
            </button>

          </form>

        </section>

      </div><!-- /card-body -->

      <!-- ── Footer ── -->
      <footer class="card-footer">
        &copy; 2024 <span>InfraEnercom S.A.C.</span> &mdash; Infraestructura Energía y Comunicaciones
      </footer>

    </div><!-- /card -->
  </main>

  <!-- Scripts -->
  <script src="{{ asset('resources/js/log/log.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>