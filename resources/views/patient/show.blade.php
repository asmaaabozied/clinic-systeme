@extends('layouts.opd')
@section('content')
<div class="container">
    <h1>Patient Details</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $patient->name }}</p>
            <p><strong>Email:</strong> {{ $patient->email }}</p>
            <p><strong>Phone:</strong> {{ $patient->phone }}</p>
            <p><strong>Gender:</strong> {{ $patient->gender }}</p>
            <p><strong>Age :</strong> {{ $patient->age_display }}</p>
            <p><strong>Address:</strong> {{ $patient->address }}</p>
            <p><strong>Blood Type:</strong> {{ $patient->blood_group }}</p>
            <p><strong>Patient Code:</strong> {{ $patient->patient_code }}</p>
            <p><strong>Marital Status:</strong> {{ $patient->marital_status ?? '-' }}</p>
            <p><strong>Guardian Name:</strong> {{ $patient->guardian_name ?? '-' }}</p>
            <p><strong>Allergies:</strong> {{ $patient->allergies ?? '-' }}</p>
            <p><strong>National ID:</strong> {{ $patient->document_id ?? '-' }}</p>
            <p><strong>Note:</strong> {{ $patient->note }}</p>
        </div>
    </div>
{{--    <a href="{{ route('patients.index') }}" class="btn btn-secondary mt-3">Back to List</a>--}}
</div>
@endsection
