<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
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
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home.index') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Reclo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false"
                aria-label="{{ __('layout.toggle_navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav me-auto">
                    <a class="nav-link" href="{{ route('home.index') }}">{{ __('layout.nav_home') }}</a>
                    <a class="nav-link" href="{{ route('product.index') }}">{{ __('layout.nav_products') }}</a>
                    @auth
                        <a class="nav-link" href="{{ route('product.my-products') }}">{{ __('product.my_products') }}</a>
                    @endauth
                    <a class="nav-link" href="#">{{ __('layout.nav_reviews') }}</a>
                    <a class="nav-link" href="{{ route('swap-request.test') }}">{{ __('layout.nav_swap') }}</a>
                </div>

                <!-- Search Bar -->
                <form class="d-flex" role="search" action="#" method="GET">
                    <input class="form-control me-2" type="search" name="q"
                        placeholder="{{ __('layout.search_placeholder') }}"
                        aria-label="{{ __('home.search_aria_label') }}">
                    <button class="btn btn-outline-light" type="submit">{{ __('layout.search_button') }}</button>
                </form>
                <div class="vr bg-white mx-2 d-none d-lg-block"></div>

                <!-- Language Switcher -->
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" id="languageDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ $currentLocale === 'en' ? __('layout.language_english') : __('layout.language_spanish') }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                        @if ($currentLocale !== 'en')
                            <li><a class="dropdown-item"
                                    href="{{ route('lang.switch', ['locale' => 'en']) }}">{{ __('layout.language_english') }}</a>
                            </li>
                        @endif
                        @if ($currentLocale !== 'es')
                            <li><a class="dropdown-item"
                                    href="{{ route('lang.switch', ['locale' => 'es']) }}">{{ __('layout.language_spanish') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="vr bg-white mx-2 d-none d-lg-block"></div>

                @guest('web')
                    <!-- Auth -->
          <a class="nav-link active" href="{{ route('login') }}">{{ __('layout.login') }}</a>
                    <a class="nav-link active" href="{{ route('register') }}">{{ __('layout.register') }}</a>
                @else
                    <!-- Notifications Dropdown -->
          <div class="nav-item dropdown me-3">
           <a id="notifDropdown"
              class="nav-link position-relative"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false">
                <i class="bi bi-bell" style="font-size: 1.4rem;"></i>
                @if(count($viewData['notifications']) > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ count($viewData['notifications']) }}
                    </span>
                @endif
            </a>

            <div class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notifDropdown" style="min-width:400px;">
              <h6 class="dropdown-header">Notifications</h6>

              <div class="notif-list">
                @forelse($viewData['notifications'] as $notification)
                  <a class="dropdown-item small" href="{{ route('notifications.read', $notification->id) }}">
                    @if($notification->type === 'App\Notifications\SwapRequestCreated')
                      <i class="bi bi-envelope-plus text-primary me-1"></i>
                      New swap request — "{{ $notification->data['desiredItemTitle'] ?? 'Producto' }}"
                      <div class="text-muted small mt-1">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</div>

                    @elseif($notification->type === 'App\Notifications\SwapRequestResponded')
                      <i class="bi bi-arrow-repeat text-info me-1"></i>
                      Swap request answered
                      <div class="text-muted small mt-1">{{ $notification->data['message'] ?? '' }}</div>

                    @elseif($notification->type === 'App\Notifications\SwapRequestFinalized')
                      <i class="bi bi-check-circle-fill text-success me-1"></i>
                      Swap completed
                      <div class="text-muted small mt-1">{{ $notification->data['message'] ?? '' }}</div>

                    @else
                      <i class="bi bi-bell-fill text-warning me-1"></i>
                      {{ $notification->data['message'] ?? 'Tienes una nueva notificación' }}
                    @endif
                  </a>
                @empty
                  <div class="dropdown-item text-muted small">No tienes notificaciones</div>
                @endforelse
            </div>


              <div class="dropdown-divider"></div>
              <a class="dropdown-item text-center small" href="{{ route('notifications.index') }}">See all</a>
            </div>
          </div>

          <!-- User Profile and Logout -->
          <a class="nav-link active" href="{{ route('user.profile') }}">{{ __('layout.my_profile') }}</a>
                    <form id="logout" action="{{ route('logout') }}" method="POST">
                        <a role="button" class="nav-link active"
                            onclick="document.getElementById('logout').submit();">{{ __('layout.logout') }}</a>
                        @csrf
                    </form>
                @endguest
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
