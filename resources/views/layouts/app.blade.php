<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&family=Montserrat:wght@400;500;600&display=swap"
        rel="stylesheet">

    <!-- Personalized styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />

    <title>@yield('title', __('layout.site_title'))</title>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark py-3">
        <!-- Removed container padding to eliminate left border space -->
        <div class="container-fluid px-2">
            <a class="navbar-brand fw-bold" href="{{ route('home.index') }}">
                <img src="{{ asset('images/logo.png') }}" alt="{{ __('layout.app_name') }}" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false"
                aria-label="{{ __('layout.toggle_navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <!-- Reorganized navigation links with better spacing and centering -->
                <div class="navbar-nav me-auto d-flex justify-content-center">
                    <a class="nav-link px-3" href="{{ route('product.index') }}">{{ __('layout.nav_products') }}</a>
                    @auth
                        <a class="nav-link px-3"
                            href="{{ route('product.my-products') }}">{{ __('product.my_products') }}</a>
                        <a class="nav-link px-3" href="{{ route('orders.index') }}">
                            <i class="fas fa-receipt me-1"></i>{{ __('cart.order_details') }}
                        </a>
                        <a class="nav-link px-3" href="{{ route('swap-request.index') }}">{{ __('layout.nav_swap') }}</a>
                    @endauth
                    <a class="nav-link px-3" href="#">{{ __('layout.nav_reviews') }}</a>
                </div>

                <!-- Expanded search bar to take more space and removed max-width constraint -->
                <div class="d-flex align-items-center mx-3 flex-grow-1">
                    <form class="d-flex w-100" role="search" action="{{ route('product.search') }}" method="GET">
                        <input class="form-control me-2 flex-grow-1" type="search" name="search"
                            placeholder="{{ __('layout.search_placeholder') }}"
                            aria-label="{{ __('home.search_aria_label') }}" value="{{ request('search') }}"
                            style="min-width: 300px;">
                        <button class="btn btn-outline-light" type="submit">
                            <i class="bi bi-search"></i>
                            <span class="d-none d-md-inline ms-1">{{ __('layout.search_button') }}</span>
                        </button>
                    </form>
                </div>

                <div class="vr bg-white mx-2 d-none d-lg-block"></div>

                <!-- Better organized right-side elements with consistent spacing -->
                <div class="d-flex align-items-center">
                    <!-- Language Switcher -->
                    <div class="dropdown-language nav-item dropdown me-2">
                        <button class="btn btn-outline-light dropdown-toggle btn-sm" type="button"
                            id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $currentLocale === 'en' ? __('layout.language_english') : __('layout.language_spanish') }}
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end py-1 px-0" aria-labelledby="languageDropdown">
                            @if ($currentLocale !== 'en')
                                <li>
                                    <a class="dropdown-item btn btn-outline-light w-100 text-center rounded-0"
                                        href="{{ route('lang.switch', ['locale' => 'en']) }}">
                                        {{ __('layout.language_english') }}
                                    </a>
                                </li>
                            @endif

                            @if ($currentLocale !== 'es')
                                <li>
                                    <a class="dropdown-item btn btn-outline-light w-100 text-center rounded-0"
                                        href="{{ route('lang.switch', ['locale' => 'es']) }}">
                                        {{ __('layout.language_spanish') }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Auth -->
                    @guest('web')
                        <!-- Centered auth buttons with better spacing -->
                        <div class="d-flex align-items-center gap-2">
                            <a class="btn btn-outline-light btn-sm"
                                href="{{ route('login') }}">{{ __('layout.login') }}</a>
                            <a class="btn btn-outline-light btn-sm" href="{{ route('register') }}">{{ __('layout.register') }}</a>
                        </div>
                    @else
                        <!-- Better organized user actions with consistent spacing -->
                        <div class="d-flex align-items-center gap-2">
                            <!-- Shopping Cart -->
                            <a class="nav-link position-relative cart-icon p-2" href="{{ route('cart.index') }}">
                                <i class="bi bi-cart fs-5 text-white"></i>
                                @if ($cartCount > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>

                            <!-- Notifications Dropdown -->
                            <div class="nav-item dropdown">
                                <a id="notifDropdown" class="nav-link position-relative p-2" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-bell fs-5"></i>
                                    @if (count($notifications) > 0)
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm">
                                            {{ count($notifications) }}
                                        </span>
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notifDropdown"
                                    style="min-width:400px;">
                                    <h6 class="dropdown-header">{{ __('notification.title') }}</h6>

                                    <div class="notif-list">
                                        @forelse($notifications as $notification)
                                            <a class="dropdown-item small"
                                                href="{{ route('notifications.read', $notification->id) }}">
                                                @if ($notification->type === $notificationTypes['swap_request_created'])
                                                    <i class="bi bi-envelope-plus text-primary me-1"></i>
                                                    {{ __('notification.new_notification') }} —
                                                    "{{ $notification->data['desiredItemTitle'] ?? 'Product' }}"
                                                    <div class="text-muted small mt-1">
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </div>
                                                @elseif($notification->type === $notificationTypes['swap_request_responded'])
                                                    <i class="bi bi-arrow-repeat text-info me-1"></i>
                                                    {{ __('notification.new_notification') }}
                                                    <div class="text-muted small mt-1">
                                                        {{ __($notification->data['translation_key']) }}
                                                    </div>
                                                @elseif($notification->type === $notificationTypes['swap_request_finalized'])
                                                    <i class="bi bi-check-circle-fill text-success me-1"></i>
                                                    {{ __('notification.new_notification') }}
                                                    <div class="text-muted small mt-1">
                                                        {{ __($notification->data['translation_key'], $notification->data['translation_params']) }}
                                                    </div>
                                                @elseif($notification->type === $notificationTypes['product_sold'])
                                                    <i class="bi bi-cart-fill text-success me-1"></i>
                                                    {{ __('notification.new_notification') }}
                                                    <div class="text-muted small mt-1">
                                                        {{ __($notification->data['translation_key'], $notification->data['translation_params']) ?? '' }}
                                                    </div>
                                                @else
                                                    <i class="bi bi-bell-fill text-warning me-1"></i>
                                                    {{ $notification->data['message'] ?? __('notification.new_notification') }}
                                                @endif
                                            </a>
                                        @empty
                                            <div class="dropdown-item text-muted small">{{ __('notification.none') }}
                                            </div>
                                        @endforelse
                                    </div>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-center small"
                                        href="{{ route('notifications.index') }}">{{ __('layout.view_all') ?? 'See all' }}</a>
                                </div>
                            </div>

                            <!-- User Profile and Logout -->
                            <a class="btn btn-outline-light btn-sm"
                                href="{{ route('user.profile') }}">{{ __('layout.my_profile') }}</a>
                            <form id="logout" action="{{ route('logout') }}" method="POST" class="d-inline">
                                <button type="submit" class="btn btn-light btn-sm">{{ __('layout.logout') }}</button>
                                @csrf
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main content -->

    <!-- Session messages -->
    @if (session('status'))
        <div class="d-flex justify-content-center mt-3">
            <div class="alert alert-primary alert-dismissible fade show text-center w-50" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="{{ __('layout.close') }}"></button>
            </div>
        </div>
    @endif

    <div class="container my-4">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="copyright">
        <div class="container">
            <small>
                {{ __('layout.footer_text') }}
            </small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>

</html>
