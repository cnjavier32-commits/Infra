{{-- ============================================================
     resources/views/layouts/app.blade.php — InfraEnercom v2.0
     Bibliotecas: GSAP 3 · Lucide · SweetAlert2 · Plus Jakarta Sans · Syne
     ============================================================ --}}
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') — InfraEnercom S.A.C.</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    @php
        $cssFile = '';

        switch (request()->route()->getName()) {
            case 'income.index':
                $cssFile = asset('resources/css/income/income.css');
                break;

            case 'material.index':
                $cssFile = asset('resources/css/material/material.css');
                break;
                
        }
    @endphp

    <link rel="stylesheet" href="{{ asset('resources/css/admin/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/income/income.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/material/material.css') }}">


    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Syne:wght@600;700;800&display=swap"
        rel="stylesheet" />

    <!-- TABLER ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

</head>

<body class="layout-body">

    {{-- ══ SIDEBAR ══ --}}
    @include('layouts.partials.sidebar')

    {{-- ══ MAIN WRAPPER ══ --}}
    <div class="layout-main" id="layoutMain">

        {{-- ══ HEADER ══ --}}
        @include('layouts.partials.header')

        {{-- ══ CONTENT ══ --}}
        <main class="layout-content" id="layoutContent">
            @yield('content')
        </main>

    </div>

    {{-- ── GSAP 3 ──────────────────────────────────────────── --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    {{-- ── JS del proyecto ────────────────────────────────── --}}
    <script src="{{ asset('resources/js/admin/admin.js') }}"></script>
    <script src="{{ asset('resources/js/material/material.js') }}"></script>
    <script src="{{ asset('resources/js/income/income.js') }}"></script>


    @stack('scripts')
</body>

</html>
