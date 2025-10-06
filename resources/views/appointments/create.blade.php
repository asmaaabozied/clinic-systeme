@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 rounded shadow">
    <h1>Add Appointment</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf
        <div class="row">
            {{-- Doctor Search --}}
            <div class="col-md-6 mb-3">
                <label>Doctor</label>
                <input type="text" id="doctor-search" class="form-control"
                    placeholder="Search by doctor or specialization"
                    value="{{ isset($doctorId) ? $doctors->find($doctorId)?->user->name . ' (' . $doctors->find($doctorId)?->specialization->name . ')' : '' }}"
                    {{ isset($doctorId) ? 'readonly' : '' }}>
                <input type="hidden" name="doctor_id" id="selected-doctor-id"
                    value="{{ old('doctor_id', $doctorId ?? '') }}">
                <div id="doctor-results" class="border rounded mt-1 p-2 bg-light"
                    style="display: none; max-height: 200px; overflow-y: auto;"></div>
                @error('doctor_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Patient Search --}}
            <div class="col-md-6 mb-3">
                <label>Patient</label>
                <input type="text" id="patient-search" class="form-control"
                    placeholder="Search patient by name or email">
                <input type="hidden" name="patient_id" id="selected-patient-id" value="{{ old('patient_id') }}">
                <div id="patient-results" class="border rounded mt-1 p-2 bg-light"
                    style="display: none; max-height: 200px; overflow-y: auto;"></div>
                @error('patient_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Date --}}
            <div class="col-md-6 mb-3">
                <label>Date</label>
                <input type="date" name="appointment_date"
                    class="form-control @error('appointment_date') is-invalid @enderror"
                    value="{{ old('appointment_date') }}" required>
                @error('appointment_date')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Time --}}
            <div class="col-md-6 mb-3">
                <label>Time</label>
                <input type="time" name="appointment_time"
                    class="form-control @error('appointment_time') is-invalid @enderror"
                    value="{{ old('appointment_time') }}" required>
                @error('appointment_time')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Notes --}}
            <div class="col-md-12 mb-3">
                <label>Notes (optional)</label>
                <textarea name="notes"
                    class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-success">Save Appointment</button>
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Doctor search
    const doctorInput = document.getElementById('doctor-search');
    const doctorResults = document.getElementById('doctor-results');
    const doctorHidden = document.getElementById('selected-doctor-id');

    // Patient search
    const patientInput = document.getElementById('patient-search');
    const patientResults = document.getElementById('patient-results');
    const patientHidden = document.getElementById('selected-patient-id');

    let doctorTimer = null;
    let patientTimer = null;

    function debounce(fn, delay) {
        let timerId;
        return function (...args) {
            clearTimeout(timerId);
            timerId = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    // Doctor search handler
    doctorInput.addEventListener('input', debounce(function () {
        const query = this.value.trim();
        doctorHidden.value = '';
        if (!query) {
            doctorResults.style.display = 'none';
            doctorResults.innerHTML = '';
            return;
        }

        fetch(`/appointments/doctor-search?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                doctorResults.innerHTML = '';
                if (data.length === 0) {
                    doctorResults.innerHTML = '<div>No doctors found</div>';
                } else {
                    data.forEach(doctor => {
                        const div = document.createElement('div');
                        div.classList.add('p-1', 'search-result-item');
                        div.style.cursor = 'pointer';
                        div.innerHTML = `<strong>${doctor.name}</strong> - ${doctor.specialization}`;
                        div.addEventListener('click', () => {
                            doctorInput.value = `${doctor.name} (${doctor.specialization})`;
                            doctorHidden.value = doctor.id;
                            doctorResults.style.display = 'none';
                        });
                        doctorResults.appendChild(div);
                    });
                }
                doctorResults.style.display = 'block';
            });
    }, 300));

    // Patient search handler
    patientInput.addEventListener('input', debounce(function () {
        const query = this.value.trim();
        patientHidden.value = '';
        if (!query) {
            patientResults.style.display = 'none';
            patientResults.innerHTML = '';
            return;
        }

        fetch(`/appointments/patient-search?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                patientResults.innerHTML = '';
                if (data.length === 0) {
                    patientResults.innerHTML = '<div>No patients found</div>';
                } else {
                    data.forEach(patient => {
                        const div = document.createElement('div');
                        div.classList.add('p-1', 'search-result-item');
                        div.style.cursor = 'pointer';
                        div.innerHTML = `<strong>${patient.name}</strong> - ${patient.email} - ${patient.phone}`;
                        div.addEventListener('click', () => {
                            patientInput.value = `${patient.name} (${patient.email})`;
                            patientHidden.value = patient.id;
                            patientResults.style.display = 'none';
                        });
                        patientResults.appendChild(div);
                    });
                }
                patientResults.style.display = 'block';
            });
    }, 300));
});
</script>
@endsection