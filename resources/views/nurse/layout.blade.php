<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nurse')</title>
    <link rel="stylesheet" href="{{ asset('css/nurse.css') }}">
</head>
<body class="light-mode">
    <header>
        <div class="header-content">
            <h1>@yield('page-title', 'Patient Assessment')</h1>
            <div class="header-actions">
                <button id="darkModeToggle" class="icon-button" aria-label="Toggle dark mode">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <div id="notification" class="notification hidden">
        <div class="notification-content">
            <span id="notificationMessage"></span>
            <button id="notificationClose">&times;</button>
        </div>
    </div>
    <script src="{{ asset('js/nurse.js') }}"></script>
    @stack('scripts')
</body>
</html>
