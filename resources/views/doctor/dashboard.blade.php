@extends('layouts.admin')

@section('page-title')
    {{ __('Doctor Dashboard') }}
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/doctor/styles.css') }}">
@endpush

@push('script-page')
    <script>
        const samplePatients = @json($recentPatients);
        const sampleSchedule = @json($todayAppointments);
        const surgicalSchedule = @json($surgicalSchedule);
        const inventoryData = @json($inventoryData);
    </script>
    <script src="{{ asset('js/doctor/script.js') }}"></script>
@endpush

@section('content')
    <div class="tab-navigation">
        <button class="tab-btn active" data-content="overview">Overview</button>
        <button class="tab-btn" data-content="patients">Patients</button>
        <button class="tab-btn" data-content="surgical">Surgical</button>
        <button class="tab-btn" data-content="inventory">Inventory</button>
    </div>

    @include('doctor.partials.overview')
    @include('doctor.partials.patients')
    @include('doctor.partials.surgical')
    @include('doctor.partials.inventory')
@endsection
