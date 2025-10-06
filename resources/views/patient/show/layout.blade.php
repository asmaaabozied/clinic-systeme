@extends('layouts.admin')

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/patient/show.css') }}">
@endpush

@push('script-page')
    <script src="{{ asset('js/patient/show.js') }}" defer></script>
@endpush

@section('content')
    <header class="header">
        <div class="secondary-nav">
            <div class="nav-tab active" data-tab="overview">Overview</div>
            <div class="nav-tab" data-tab="visits">Visits</div>
            <div class="nav-tab" data-tab="medication">Medication</div>
            <div class="nav-tab" data-tab="lab-investigation">Lab Investigation</div>
            <div class="nav-tab" data-tab="operations">Operations</div>
            <div class="nav-tab" data-tab="charges">Charges</div>
{{--            <div class="nav-tab" data-tab="payments">Payments</div>--}}
            <div class="nav-tab" data-tab="live-consultation">Live Consultation</div>
{{--            <div class="nav-tab" data-tab="timeline">Timeline</div>--}}
            <div class="nav-tab" data-tab="treatment-history">Treatment History</div>
        </div>
    </header>
    <div class="main-content">
        @yield('patient-info')
        <div class="tab-content-container">
            @yield('tab-content')
        </div>
    </div>
@endsection
