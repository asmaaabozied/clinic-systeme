@extends('layouts.admin')
@section('content')
<div class="container bg-white p-4">
    <h1>Patients</h1>
    <div class="row mb-3">
        <div class="col-md-8">
            <input type="text" id="patient-search-input" class="form-control me-2" placeholder="Live search by name, email, or phone">
        </div>
        @can('create patient')
            <div class="col-md-4 text-end">
                <a href="{{ route('patients.create') }}" class="btn btn-primary mb-3">Add Patient</a>
            </div>
        @endcan
    </div>
    <div class="table-responsive">
   <table class="table table-striped table-bordered">
   
        <thead>
            <tr>
                <th> Name</th>
               
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Birth Date</th>
                <th>Address</th>
                <th>Blood Type</th>
              
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="patients-table-body">
            @forelse($patients as $patient)
           
            <tr>
               
                <td><a href="{{ route('patients.show', $patient->id) }}">{{ $patient->first_name . ' '.  $patient->last_name}}</a></td>
                <td><a href="{{ route('patients.show', $patient->id) }}">{{ $patient->email }}</a></td>
                <td><a href="{{ route('patients.show', $patient->id) }}">{{ $patient->phone }}</a></td>
                <td><a href="{{ route('patients.show', $patient->id) }}">{{ $patient->gender }}</a></td>
                <td><a href="{{ route('patients.show', $patient->id) }}">{{ $patient->birth_date }}</a></td>
                <td><a href="{{ route('patients.show', $patient->id) }}">{{ $patient->address }}</a></td>
                <td><a href="{{ route('patients.show', $patient->id) }}">{{ $patient->blood_type }}</a></td>
             
                <td>
                     @can('edit patient')
                     <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    @endcan
                    @can('delete patient')
                    <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                    @endcan
                </td>
                
            </tr>
            @empty
            <tr>
                <td colspan="11" class="text-center">No patients found</td>
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
    document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('patient-search-input');
    const tableBody = document.getElementById('patients-table-body');
    let timer = null;

    if (!searchInput) return;

    searchInput.addEventListener('input', function() {
        clearTimeout(timer);
        timer = setTimeout(function() {
            const query = searchInput.value;
            console.log(query);
           fetch(`{{ url('patients/livesearch') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';
                    if (data.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="11" class="text-center">No patients found</td></tr>`;
                        return;
                    }
     
                     data.patients.forEach(patient => {
                        tableBody.innerHTML += `
                        <tr>
                            <td>${patient.id}</td>
                            <td>${patient.first_name}</td>
                            <td>${patient.last_name}</td>
                            <td>${patient.email ?? ''}</td>
                            <td>${patient.phone ?? ''}</td>
                            <td>${patient.gender ?? ''}</td>
                            <td>${patient.birth_date ?? ''}</td>
                            <td>${patient.address ?? ''}</td>
                            <td>${patient.blood_type ?? ''}</td>
                            <td>${patient.note ?? ''}</td>
                            <td>
                                <a href="/patients/${patient.id}/edit" class="btn btn-sm btn-warning">Edit</a>
                                <form action="/patients/${patient.id}" method="POST" style="display:inline-block;">
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
