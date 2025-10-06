@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 rounded shadow">
    <h1>Edit Appointment</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- Doctor --}}
            <div class="col-md-6 mb-3">
                <label>Doctor</label>
                <input type="text" class="form-control" value="{{ $appointment->doctor->user->name }} ({{ $appointment->doctor->specialization->name }})" disabled>
                <input type="hidden" name="doctor_id" value="{{ $appointment->doctor_id }}">
            </div>

            {{-- Patient --}}
            <div class="col-md-6 mb-3">
                <label>Patient</label>
                <input type="text" class="form-control" value="{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }} - {{ $appointment->patient->phone }}" disabled>
                <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
            </div>

            {{-- Date --}}
            <div class="col-md-6 mb-3">
                <label>Date</label>
              <input type="date" name="appointment_date" class="form-control"
                value="{{ old('appointment_date', \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d')) }}" required>
                @error('appointment_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Time --}}
            <div class="col-md-6 mb-3">
                <label>Time</label>
                <input type="time" name="appointment_time" class="form-control @error('appointment_time') is-invalid @enderror"
                       value="{{ old('appointment_time', $appointment->appointment_time) }}" required>
                @error('appointment_time')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status --}}
            <div class="col-md-6 mb-3">
                <label>Status</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                    @php
                        $statuses = ['scheduled', 'completed', 'cancelled'];
                    @endphp
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ old('status', $appointment->status) == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Notes --}}
            <div class="col-md-12 mb-3">
                <label>Notes</label>
                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $appointment->notes) }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Appointment</button>
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
