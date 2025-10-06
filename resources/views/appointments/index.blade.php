@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 rounded shadow">
    <h1>Appointments</h1>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row mb-3">
        <div class="col-md-8">
            <input type="text" id="appointment-search-input" class="form-control me-2"
                placeholder="Search by patient or doctor name">
        </div>
        <div class="col-md-4 text-end">
            @can('create appointment')
            <a href="{{ route('appointments.create') }}" class="btn btn-primary mb-3">Add Appointment</a>
            @endcan
        </div>

    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="">
                <tr>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Specialization</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="appointments-table-body">
                @forelse($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                    <td>{{ $appointment->doctor->user->name }}</td>
                    <td>{{ $appointment->doctor->specialization->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                    <td>
                        @if($appointment->status == 'scheduled')
                        <span class="badge bg-warning text-dark">Scheduled</span>
                        @elseif($appointment->status == 'completed')
                        <span class="badge bg-success">Completed</span>
                        @elseif($appointment->status == 'cancelled')
                        <span class="badge bg-danger">Cancelled</span>
                        @else
                        <span class="badge bg-secondary">Unknown</span>
                        @endif
                    </td>
                    <td>{{ $appointment->notes ?? '-' }}</td>
                    <td>
                        @can('view appointment')
                        <a href="{{ route('appointments.show', $appointment->id) }}"
                            class="btn btn-sm btn-secondary">View</a>
                        @endcan
                        @can('edit appointment')
                        <a href="{{ route('appointments.edit', $appointment->id) }}"
                            class="btn btn-sm btn-primary">Edit</a>
                        @endcan

                        @can('delete appointment')
                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        @endcan
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No appointments found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    window.csrfToken = '{{ csrf_token() }}';
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('appointment-search-input');
    const tableBody = document.getElementById('appointments-table-body');
    let timer = null;

    searchInput.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () {
            const query = searchInput.value;

            fetch(`{{ url('appointments/livesearch') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';

                    if (!data.appointments || data.appointments.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="8" class="text-center">No appointments found</td></tr>`;
                        return;
                    }

                    data.appointments.forEach(app => {
                        let statusBadge = '';
                        switch (app.status) {
                            case 'scheduled':
                                statusBadge = '<span class="badge bg-warning text-dark">Scheduled</span>';
                                break;
                            case 'completed':
                                statusBadge = '<span class="badge bg-success">Completed</span>';
                                break;
                            case 'cancelled':
                                statusBadge = '<span class="badge bg-danger">Cancelled</span>';
                                break;
                            default:
                                statusBadge = '<span class="badge bg-secondary">Unknown</span>';
                        }

                        tableBody.innerHTML += `
                            <tr>
                                <td>${app.patient_name}</td>
                                <td>${app.doctor_name}</td>
                                <td>${app.specialization ?? '-'}</td>
                                <td>${app.appointment_date}</td>
                                <td>${app.appointment_time}</td>
                                <td>${statusBadge}</td>
                                <td>${app.notes ?? '-'}</td>
                                <td>
                                    <a href="/appointments/${app.id}" class="btn btn-sm btn-secondary">View</a>
                                    <a href="/appointments/${app.id}/edit" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="/appointments/${app.id}" method="POST" style="display:inline-block;">
                                        <input type="hidden" name="_token" value="${window.csrfToken}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        `;
                    });
                });
        }, 300);
    });
});
</script>
@endsection