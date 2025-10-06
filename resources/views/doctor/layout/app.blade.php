<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MedClinic Pro - Plastic Surgery Management')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/doctor/styles.css') }}">
    @stack('styles')
</head>

<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo-container">
                    <div class="logo-icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div class="logo-text">
                        <h2>MedClinic Pro</h2>
                        <p>Plastic Surgery</p>
                    </div>
                </div>
            </div>

            <nav class="sidebar-nav">
                <ul class="nav-menu">
                    <li class="nav-item {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('doctor.patients.*') ? 'active' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Patient Management</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('doctor.surgical.*') ? 'active' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="fas fa-cut"></i>
                            <span>Surgical Planning</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('doctor.imaging.*') ? 'active' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="fas fa-camera"></i>
                            <span>Imaging & Labs</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('doctor.inventory.*') ? 'active' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Inventory & Pharmacy</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('doctor.scheduling.*') ? 'active' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="fas fa-calendar"></i>
                            <span>Scheduling</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('doctor.billing.*') ? 'active' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Billing & Insurance</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('doctor.communication.*') ? 'active' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="fas fa-comments"></i>
                            <span>Communication</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <div class="user-profile" onclick="toggleUserMenu()">
                    <div class="user-avatar">
                        <img
                            src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=40&h=40&fit=crop&crop=face">
                    </div>
                    <span class="user-name">malek</span>
                    <i class="fas fa-chevron-up"></i>
                </div>
                <div class="user-menu" id="userMenu">
                    <a href="#" class="menu-item">
                        <i class="fas fa-user"></i>
                        Profile
                    </a>
                    <a href="#" class="menu-item">
                        <i class="fas fa-cog"></i>
                        Settings
                    </a>
                    <hr>
                    <form method="POST" action="#">
                        @csrf
                        <button type="submit" class="menu-item">
                            <i class="fas fa-sign-out-alt"></i>
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <button class="sidebar-toggle" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="header-title">
                        <h1>@yield('header_title', 'Dashboard')</h1>
                        <p>@yield('header_subtitle', 'Welcome back, ' . 'malek')</p>
                    </div>
                </div>

                <div class="header-right">
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" placeholder="Search patients..." class="search-input">
                    </div>
                    <button class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        New Consultation
                    </button>
                    <button class="btn btn-emergency">
                        <i class="fas fa-exclamation-triangle"></i>
                        Emergency
                    </button>
                    <button class="btn btn-icon">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Dropdown Menu (Hidden by default) -->
    <div class="dropdown-menu" id="dropdownMenu">
        <a href="#" class="dropdown-item">View Details</a>
        <a href="#" class="dropdown-item">Edit Record</a>
        <a href="#" class="dropdown-item">Schedule Follow-up</a>
        <a href="#" class="dropdown-item">View Images</a>
    </div>

    <script src="{{ asset('js/doctor/script.js') }}"></script>
    @stack('scripts')
</body>

</html>
