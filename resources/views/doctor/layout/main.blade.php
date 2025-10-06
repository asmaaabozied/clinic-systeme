<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
<div class="header">
    <div class="header-left">
        <div class="logo">
            <i class="fa fa-clinic-medical"></i>
            <span>MedClinic Pro</span>
        </div>
        <div class="header-title">
            <h1>Dashboard</h1>
            <p>Welcome back, {{ auth()->user()->name }}</p>
        </div>
    </div>
    <div class="header-center">
        <div class="search-bar">
            <i class="fa fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search patients, procedures...">
        </div>
    </div>
    <div class="header-right">
{{--        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#consultationModal">--}}
{{--            <i class="fa fa-plus"></i>--}}
{{--            New Consultation--}}
{{--        </button>--}}
{{--        <button class="btn btn-emergency">--}}
{{--            <i class="fa fa-exclamation-circle"></i>--}}
{{--            Emergency--}}
{{--            <span class="notification-badge">2</span>--}}
{{--        </button>--}}
        <div class="profile-section">
            <div class="notification-icon">
                <i class="fa fa-bell"></i>
            </div>
            <div class="profile-dropdown">
                <div class="profile-avatar" id="profileDropdownToggle">
                    <img src="{{ Auth::user()->img_image ?? 'https://via.placeholder.com/40' }}" alt="{{ Auth::user()->name }}">
                </div>
                <div class="profile-dropdown-menu" id="profileDropdownMenu">
                    <a href="{{ route('profile') }}">{{ __('Profile') }}</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">{{ __('Logout') }}</a>
                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        <button class="mobile-menu-toggle" id="mobileMenuToggle">
            <i class="fa fa-bars"></i>
        </button>
    </div>
</div>

<div class="main-container">
    <div class="sidebar" id="sidebar">
        <nav class="sidebar-nav">
            <ul>
                <li class="nav-item active"><a href="#"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
                <li class="nav-item"><a href="#"><i class="fa fa-users"></i> Patient Management</a></li>
                <li class="nav-item"><a href="#"><i class="fa fa-procedures"></i> Surgical Planning</a></li>
                <li class="nav-item"><a href="#"><i class="fa fa-x-ray"></i> Imaging & Labs</a></li>
                <li class="nav-item"><a href="#"><i class="fa fa-boxes"></i> Inventory & Pharmacy</a></li>
                <li class="nav-item"><a href="#"><i class="fa fa-calendar"></i> Scheduling</a></li>
                <li class="nav-item"><a href="#"><i class="fa fa-file-invoice-dollar"></i> Billing & Insurance</a></li>
                <li class="nav-item"><a href="#"><i class="fa fa-comments"></i> Communication</a></li>
            </ul>
        </nav>
    </div>

    <div class="main-content">
        @yield('content')
    </div>
</div>

<div class="modal fade" id="consultationModal" tabindex="-1" aria-labelledby="consultationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="consultationModalLabel">New Consultation</h3>
                <button type="button" class="modal-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="consultationForm">
                    <div class="form-group">
                        <label for="patientName">Patient Name</label>
                        <input type="text" id="patientName" name="patientName" required>
                    </div>
                    <div class="form-group">
                        <label for="consultationType">Consultation Type</label>
                        <select id="consultationType" name="consultationType" required>
                            <option value="">Select type</option>
                            <option value="Initial Consultation">Initial Consultation</option>
                            <option value="Follow-up">Follow-up</option>
                            <option value="Emergency">Emergency</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="appointmentDate">Date & Time</label>
                        <input type="datetime-local" id="appointmentDate" name="appointmentDate" required>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" id="cancelBtn" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Schedule Consultation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('doctor.partials.modals.patient-details')
@include('doctor.partials.modals.surgery-details')
@include('doctor.partials.modals.inventory-actions')
<script>
    const samplePatients = @json($recentPatients);
    const sampleSchedule = @json($todayAppointments);
    const surgicalSchedule = @json($surgicalSchedule);
    const inventoryData = @json($inventoryData);
</script>
<script src="{{ asset('js/doctor/script.js') }}"></script>
@stack('scripts')
</body>
</html>
