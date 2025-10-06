@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 rounded shadow">
    <h1 class="mb-4">Doctors in {{ $specialization->name }}</h1>

    <a href="{{ route('doctor-specializations.index') }}" class="btn btn-secondary mb-3">Back to Specializations</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Clinic Address</th>
                    <th>Experience Years</th>
                    <th>Bio</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($doctors as $doctor)
                    <tr>
                        <td>{{ $doctor->user->name }}</td>
                        <td>{{ $doctor->phone }}</td>
                        <td>{{ $doctor->clinic_address }}</td>
                        <td>{{ $doctor->experience_years }}</td>
                        <td>{{ $doctor->bio }}</td>
                        <td>
                            <a href="{{ route('appointments.create', ['doctor_id' => $doctor->id]) }}" class="btn btn-sm btn-success">Make Appointment</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No doctors found for this specialization</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
