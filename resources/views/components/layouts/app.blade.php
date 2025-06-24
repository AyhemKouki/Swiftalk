<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Swiftalk</title>

    <link rel="icon" href="{{asset('images/Web_Logo.png')}}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    @vite(['resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="min-vh-100 bg-body">
<!-- Mobile Header -->
<header class="d-lg-none bg-light p-3 border-bottom">
    <div class="d-flex justify-content-between align-items-center">
        <a href="#" class="text-decoration-none">
            <img src="{{asset('images/Swiftalk_Logo.png')}}" alt="Swiftalk logo" width="120">
        </a>
        <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
            <i class="bi bi-list" style="font-size: 1.5rem;"></i>
        </button>
    </div>
</header>

<div class="d-flex">
    <!-- Sidebar - Desktop -->
    <div class="d-none d-lg-flex flex-column flex-shrink-0 p-3 bg-light border-end" style="width: 280px; min-height: 100vh;">
        <!-- Brand -->
        <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
            <img src="{{asset('images/Swiftalk_Logo.png')}}" alt="Swiftalk logo" width="160">
        </a>

        <!-- Main Navigation -->
        <ul class="nav nav-pills flex-column mb-auto mt-4">
            <li class="nav-item">
                <a wire:navigate href="{{route('dashboard')}}"
                   class="nav-link @if(Route::is('dashboard')) active @endif" aria-current="page">
                    <i class="bi bi-house-door me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a wire:navigate href="{{route('chat')}}" class="nav-link @if(Route::is('chat')) active @endif">
                    <i class="bi bi-chat me-2"></i> Chat
                </a>
            </li>

            <li class="nav-item">
                <a wire:navigate href="{{route('groups')}}" class="nav-link @if(Route::is('groups')) active @endif">
                    <i class="bi bi-people me-2"></i> Group Chat
                </a>
            </li>

            <li class="nav-item">
                <a wire:navigate href="#" class="nav-link">
                    <i class="bi bi-calendar me-2"></i> Calendar
                </a>
            </li>
        </ul>

        <!-- Bottom Navigation -->
        <ul class="nav nav-pills flex-column mt-auto">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-gear me-2"></i> Settings
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-info-circle me-2"></i> Help
                </a>
            </li>
        </ul>

        <!-- Profile Dropdown -->
        <div class="dropdown mt-3">
            <button class="btn d-flex align-items-center text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{asset('images/male.jpg')}}" alt="Olivia Martin" width="32" height="32"
                     class="rounded-circle me-2">
                <strong>{{auth()->user()->name}}</strong>
            </button>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><h6 class="dropdown-header">Account</h6></li>
                <li><a wire:navigate class="dropdown-item active" href="{{route('profile', auth()->user()->id)}}">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Sidebar - Mobile (Offcanvas) -->
    <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="sidebarMobile" aria-labelledby="sidebarMobileLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMobileLabel">
                <img src="{{asset('images/Swiftalk_Logo.png')}}" alt="Swiftalk logo" width="120">
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-3 bg-light">
            <!-- Main Navigation -->
            <ul class="nav nav-pills flex-column mb-auto mt-2">
                <li class="nav-item">
                    <a wire:navigate href="{{route('dashboard')}}"
                       class="nav-link @if(Route::is('dashboard')) active @endif" aria-current="page">
                        <i class="bi bi-house-door me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a wire:navigate href="{{route('chat')}}" class="nav-link @if(Route::is('chat')) active @endif">
                        <i class="bi bi-chat me-2"></i> Chat
                    </a>
                </li>

                <li class="nav-item">
                    <a wire:navigate href="{{route('groups')}}" class="nav-link @if(Route::is('groups')) active @endif">
                        <i class="bi bi-people me-2"></i> Group Chat
                    </a>
                </li>

                <li class="nav-item">
                    <a wire:navigate href="#" class="nav-link">
                        <i class="bi bi-calendar me-2"></i> Calendar
                    </a>
                </li>
            </ul>

            <!-- Bottom Navigation -->
            <ul class="nav nav-pills flex-column mt-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-gear me-2"></i> Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-info-circle me-2"></i> Help
                    </a>
                </li>
            </ul>

            <!-- Profile Dropdown -->
            <div class="dropdown mt-3">
                <button class="btn d-flex align-items-center text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{asset('images/male.jpg')}}" alt="Olivia Martin" width="32" height="32"
                         class="rounded-circle me-2">
                    <strong>{{auth()->user()->name}}</strong>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><h6 class="dropdown-header">Account</h6></li>
                    <li><a wire:navigate class="dropdown-item active" href="{{route('profile', auth()->user()->id)}}">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-3 p-lg-4">
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
