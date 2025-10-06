@extends('layouts.admin')
@section('content')
<div class="container bg-white p-4 rounded shadow">
    <h1>Patient Details</h1>
    <div class="card">
        <div class="card-body">
            <p><strong> Name:</strong> {{ $patient->first_name }}</p>
        </div>
    </div>
    <a href="{{ route('patients.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection
