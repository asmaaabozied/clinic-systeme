@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow">
    <h1>Unit Types</h1>
    <a href="{{ route('unit-types.create') }}" class="btn btn-primary mb-3">Add Unit Type</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($unitTypes as $unitType)
                <tr>
                    <td>{{ $unitType->id }}</td>
                    <td>{{ $unitType->name }}</td>
                    <td>
                        <a href="{{ route('unit-types.show', $unitType) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('unit-types.edit', $unitType) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('unit-types.destroy', $unitType) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
