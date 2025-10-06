@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4">
    <h1>TPA List</h1>
    <a href="{{ route('tpas.create') }}" class="btn btn-primary mb-3">Add TPA</a>
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
            @foreach($tpas as $tpa)
                <tr>
                    <td>{{ $tpa->id }}</td>
                    <td>{{ $tpa->name }}</td>
                    <td>
                        <a href="{{ route('tpas.show', $tpa) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('tpas.edit', $tpa) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('tpas.destroy', $tpa) }}" method="POST" style="display:inline-block;">
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
