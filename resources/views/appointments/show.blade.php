@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 rounded shadow">
    <h1 class="mb-4">Appointment Details</h1>

    <a href="{{ route('appointments.index') }}" class="btn btn-secondary mb-3">Back to Appointments</a>

    {{-- Appointment Info --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Appointment Info</div>
        <div class="card-body">
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</p>
            <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
            <p><strong>Note:</strong> {{ $appointment->note ?? '-' }}</p>
        </div>
    </div>

    {{-- Patient Info --}}
    <div class="card mb-4">
        <div class="card-header bg-success text-white">Patient Info</div>
        <div class="card-body">
            <p><strong>Full Name:</strong> {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</p>
            <p><strong>Email:</strong> {{ $appointment->patient->email }}</p>
            <p><strong>Phone:</strong> {{ $appointment->patient->phone }}</p>
            <p><strong>Gender:</strong> {{ ucfirst($appointment->patient->gender) }}</p>
            <p><strong>Birth Date:</strong> {{ $appointment->patient->birth_date }}</p>
            <p><strong>Address:</strong> {{ $appointment->patient->address }}</p>
            <p><strong>Blood Type:</strong> {{ $appointment->patient->blood_type }}</p>
            <p><strong>Note:</strong> {{ $appointment->patient->note ?? '-' }}</p>
        </div>
    </div>

    {{-- Doctor Info --}}
    <div class="card">
        <div class="card-header bg-info text-white">Doctor Info</div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $appointment->doctor->user->name }}</p>
            <p><strong>Email:</strong> {{ $appointment->doctor->user->email }}</p>
            <p><strong>Phone:</strong> {{ $appointment->doctor->phone }}</p>
            <p><strong>Specialization:</strong> {{ $appointment->doctor->specialization->name ?? 'N/A' }}</p>
            <p><strong>Clinic Address:</strong> {{ $appointment->doctor->clinic_address }}</p>
            <p><strong>Experience Years:</strong> {{ $appointment->doctor->experience_years }}</p>
            <p><strong>Bio:</strong> {{ $appointment->doctor->bio ?? '-' }}</p>
        </div>
    </div>
</div>
@endsection
