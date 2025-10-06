<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('Plastic Surgery Diagnosis System'))</title>
    <link rel="stylesheet" href="{{ asset('css/dermatology/app.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    @stack('css-page')
</head>
<body class="bg-gray-50">
    <!-- Header with Navigation -->
    <header class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 11.172V5l-1-1z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h1 class="text-lg font-bold text-gray-800">PlasticCare</h1>
                        <p class="text-sm text-gray-500">Diagnosis System</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                @php
                    $patientId = request()->query('patient_id');
                    $query = $patientId ? ['patient_id' => $patientId] : [];
                @endphp
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('doctor.dashboard') }}" class="flex items-center text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors @if(Route::currentRouteName() === 'doctor.dashboard') border-b-2 border-blue-600 text-blue-600 @endif" title="Dashboard">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v6a2 2 0 002 2h4a2 2 0 002-2v-6m-6 0h6"/></svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('doctor.dermatology.index', $query) }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors @if(Route::currentRouteName() === 'doctor.dermatology.index') border-b-2 border-blue-600 text-blue-600 @endif">
                        Patient Overview
                    </a>
                    <a href="{{ route('doctor.dermatology.consultation', $query) }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors @if(Route::currentRouteName() === 'doctor.dermatology.consultation') border-b-2 border-blue-600 text-blue-600 @endif">
                        Consultation
                    </a>
                    {{-- <a href="{{ route('doctor.dermatology.imaging', $query) }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors @if(Route::currentRouteName() === 'doctor.dermatology.imaging') border-b-2 border-blue-600 text-blue-600 @endif">
                        Imaging
                    </a> --}}
                    <a href="{{ route('doctor.dermatology.image-analysis', $query) }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors @if(Route::currentRouteName() === 'doctor.dermatology.image-analysis') border-b-2 border-blue-600 text-blue-600 @endif">
                        Image Analysis
                    </a>
                    <a href="{{ route('doctor.dermatology.simulation', $query) }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors @if(Route::currentRouteName() === 'doctor.dermatology.simulation') border-b-2 border-blue-600 text-blue-600 @endif">
                        3D Simulation
                    </a>
                    <a href="{{ route('doctor.dermatology.treatment', $query) }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors @if(Route::currentRouteName() === 'doctor.dermatology.treatment') border-b-2 border-blue-600 text-blue-600 @endif">
                        Treatment Plan
                    </a>
                    <a href="{{ route('doctor.dermatology.history', $query) }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors @if(Route::currentRouteName() === 'doctor.dermatology.history') border-b-2 border-blue-600 text-blue-600 @endif">
                        Medical History
                    </a>
                    <a href="{{ route('doctor.dermatology.reports', $query) }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors @if(Route::currentRouteName() === 'doctor.dermatology.reports') border-b-2 border-blue-600 text-blue-600 @endif">
                        Reports
                    </a>
                </nav>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>
<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="{{ asset('js/dermatology/app.js') }}"></script>
    @stack('script-page')
</body>
</html>
