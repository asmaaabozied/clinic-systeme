@extends('layouts.admin')

@section('content')
<div class="container  bg-white p-4">
    <h1>Symptoms Types</h1>
    <a href="{{ route('symptom-types.create') }}" class="btn btn-primary mb-3">Add new type</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($symptoms as $symptom)
                <tr>
                    <td>{{ $symptom->id }}</td>
                    <td>{{ $symptom->name }}</td>
                    <td>
                        <a href="{{ route('symptom-types.show', $symptom) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('symptom-types.edit', $symptom) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('symptom-types.destroy', $symptom) }}" method="POST" style="display:inline-block;">
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
