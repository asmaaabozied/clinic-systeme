@extends('layouts.admin')
@section('content')
<div class="container bg-white p-4 rounded shadow">
    <h1>Doctor Specializations</h1>
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
            <input type="text" id="specialization-search-input" class="form-control me-2"
                placeholder="Live search by Specialization name">
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('doctor-specializations.create') }}" class="btn btn-primary mb-3">Add Specialization</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="specializations-table-body">
                @forelse($doctorSpecializations as $doctorSpecialization)
                <tr>
                    <td>
                        <a href="{{ route('doctor-specializations.show', $doctorSpecialization->id) }}">
                            {{ $doctorSpecialization->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('doctor-specializations.edit', $doctorSpecialization->id) }}"
                            class="btn btn-sm btn-primary">Edit</a>
                        <a href="{{ route('doctor-specializations.doctors', $doctorSpecialization->id) }}"
                            class="btn btn-sm btn-info">View Doctors</a>
                        <form action="{{ route('doctor-specializations.destroy', $doctorSpecialization->id) }}"
                            method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center">No specializations found</td>
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
    const searchInput = document.getElementById('specialization-search-input');
    const tableBody = document.getElementById('specializations-table-body');
    let timer = null;

    searchInput.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () {
            const query = searchInput.value;

            fetch(`{{ url('doctor-specializations/livesearch') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';

                    if (!data.specializations || data.specializations.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="2" class="text-center">No specializations found</td></tr>`;
                        return;
                    }

                    data.specializations.forEach(specialization => {
                        tableBody.innerHTML += `
                            <tr>
                                <td>${specialization.name}</td>
                                <td>
                                    <a href="/doctor-specializations/${specialization.id}/edit" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="/doctor-specializations/${specialization.id}" method="POST" style="display:inline-block;">
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