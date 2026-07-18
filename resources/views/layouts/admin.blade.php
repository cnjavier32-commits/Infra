<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Panel') — InfraEnercom S.A.C.</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    
    <link rel="stylesheet" href="{{ asset('resources/css/admin/admin.css') }}">

</head>

<body>

    <div class="app" id="app">
        @include('layouts.partials.sidebar')
        <div class="sidebar-scrim" id="scrim"></div>

        <div class="main">
            @include('layouts.partials.header')
            <main class="content">
                @yield('content')
            </main>
        </div>

    </div>

    <nav class="bottom-nav" aria-label="Navegación móvil">
        <a href="#" class="is-active" data-view="dashboard" data-node><i data-lucide="layout-grid"></i><span>Panel</span></a>
        <a href="#" data-view="entradas" data-node><i data-lucide="arrow-down-to-line"></i><span>Entradas</span></a>
        <a href="#" class="bottom-nav-cta" data-fab><i data-lucide="plus"></i></a>
        <a href="#" data-view="salidas" data-node><i data-lucide="arrow-up-from-line"></i><span>Salidas</span></a>
        <a href="#" data-view="inventario" data-node><i data-lucide="boxes"></i><span>Stock</span></a>
    </nav>

    <div class="toast" id="toast"></div>


    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="{{ asset('resources/js/admin/admin.js') }}"></script>
</body>

</html>