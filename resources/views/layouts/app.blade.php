<!DOCTYPE html>
<html>
    <head>
        @if(App::environment('production'))
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-21202464-7"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{ env("GOOGLE_ANALYTICS_CODE") }}');
        </script>
        @endif
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Protocolo de Retorno a la Presencialidad</title>

        @stack('head-scripts')
        <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="{{ asset('/css/site.css') }}" />
        @stack('head-links')
    </head>
    <body>
        <nav class="navbar navbar-expand-md bg-primary navbar-dark fixed-top">
            <div class="container">
                <!-- Brand -->
                <a class="navbar-brand" href="#">
                    <img src="/images/logo.png" height="30" alt="">
                </a>

                <!-- Toggler/collapsibe Button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar links -->
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                        <a class="nav-link" href="/">Inicio</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu">
                                    @if (Auth::user()->can_scan_qr)
                                    <a class="dropdown-item" href="{{ route('qrScanner') }}">Scan QR</a>
                                    @endif
                                    @if (Auth::user()->can_enter_test_results)
                                        <a class="dropdown-item" href="{{ route('enterTestResults') }}">Ingresar Resultados</a>
                                        <a class="dropdown-item" href="{{ route('trackedaccounts_index') }}">Cuentas habilitadas</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}">Cerrar sesión</a>
                                </div>
                            </li>
                        @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>

          </nav>
    <div class="container body-content">
        @yield('main-content')
    </div>
    @yield('after-main-content')

    </body>
    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <!-- Scripts adicionales publicados por vistas bajo demanda -->
    @stack('js')
</html>
