@extends('layouts.admin')
@section('content')
<div class="container bg-white p-4 rounded shadow">
    <h1>Doses</h1>
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
            <input type="text" id="category-search-input" class="form-control me-2"
                placeholder="Live search by Category name">
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('doses.create') }}" class="btn btn-primary mb-3">Add Dose</a>
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
            <tbody id="categories-table-body">
                @forelse($doses as $dose)
                <tr>
                    <td>
                        <a href="{{ route('doses.show', $dose->id) }}">
                            {{ $dose->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('doses.edit', $dose->id) }}"
                            class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('doses.destroy', $dose->id) }}"
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
                    <td colspan="2" class="text-center">No doses found</td>
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
    const searchInput = document.getElementById('category-search-input');
    const tableBody = document.getElementById('categories-table-body');
    let timer = null;

    searchInput.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () {
            const query = searchInput.value;

            fetch(`{{ url('doses/livesearch') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';

                    if (!data.specializations || data.specializations.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="2" class="text-center">No doses found</td></tr>`;
                        return;
                    }

                    data.specializations.forEach(specialization => {
                        tableBody.innerHTML += `
                            <tr>
                                <td>${specialization.name}</td>
                                <td>
                                    <a href="/doses/${specialization.id}/edit" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="/doses/${specialization.id}" method="POST" style="display:inline-block;">
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
