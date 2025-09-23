<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Reclo') }} - {{ __('admin.admin_panel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&family=Montserrat:wght@400;500;600&display=swap"
        rel="stylesheet">

    <!-- Personalized styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />

    <!-- Admin-specific styles -->
    <link href="{{ asset('/css/admin.css') }}" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="admin-body">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark admin-header shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-shield-alt me-2"></i>{{ config('app.name', 'Reclo') }}
                    {{ __('admin.admin_panel') }}
                </a>

                <div class="navbar-nav ms-auto d-flex align-items-center">
                    <!-- Language Selector -->
                    <div class="dropdown me-3">
                        <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button"
                            id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-globe me-1"></i>
                            @if (app()->getLocale() == 'es')
                                <span class="flag-icon flag-icon-es"></span> Español
                            @else
                                <span class="flag-icon flag-icon-us"></span> English
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                                    href="{{ route('lang.switch', 'en') }}">
                                    <span class="flag-icon flag-icon-us me-2"></span>English
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() == 'es' ? 'active' : '' }}"
                                    href="{{ route('lang.switch', 'es') }}">
                                    <span class="flag-icon flag-icon-es me-2"></span>Español
                                </a>
                            </li>
                        </ul>
                    </div>

                    @auth('admin')
                        <span class="nav-link text-white">
                            <i class="fas fa-user me-1"></i>{{ Auth::guard('admin')->user()->getName() }}
                        </span>
                        <form id="admin-logout" action="{{ route('admin.logout') }}" method="POST">
                            <a role="button" class="nav-link text-white"
                                onclick="document.getElementById('admin-logout').submit();">
                                <i class="fas fa-sign-out-alt me-1"></i>{{ __('admin.logout') }}
                            </a>
                            @csrf
                        </form>
                    @endauth
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>

</html>
