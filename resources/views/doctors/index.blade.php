@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 rounded shadow">
    <h1>Doctors</h1>

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
            <input type="text" id="doctor-search-input" class="form-control"
                placeholder="Live search by Doctor name or email">
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('doctors.create') }}" class="btn btn-primary mb-3">Add Doctor</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Specialization</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="doctors-table-body">
                @forelse($doctors as $doctor)
                <tr>
                    <td>
                        <a href="{{ route('doctors.show', $doctor->id) }}">
                            {{ $doctor->user->name ?? 'N/A' }}
                        </a>
                    </td>
                    <td>{{ $doctor->specialization->name ?? 'N/A' }}</td>
                    <td>{{ $doctor->user->email ?? 'N/A' }}</td>
                    <td>{{ $doctor->phone }}</td>
                    <td>
                        <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">Delete</button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No doctors found</td>
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
    const searchInput = document.getElementById('doctor-search-input');
    const tableBody = document.getElementById('doctors-table-body');
    let timer = null;

    searchInput.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () {
            const query = searchInput.value;

            fetch(`{{ url('doctors-search/livesearch') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';

                    if (!data.doctors || data.doctors.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="5" class="text-center">No doctors found</td></tr>`;
                        return;
                    }

                    data.doctors.forEach(doctor => {
                        tableBody.innerHTML += `
                            <tr>
                                <td><a href="/doctors/${doctor.id}">${doctor.name}</a></td>
                                <td>${doctor.specialization_name ?? 'N/A'}</td>
                                <td>${doctor.email ?? '-'}</td>
                                <td>${doctor.phone ?? '-'}</td>
                                <td>
                                    <a href="/doctors/${doctor.id}/edit" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="/doctors/${doctor.id}" method="POST" style="display:inline-block;">
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