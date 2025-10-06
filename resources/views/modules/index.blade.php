@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow">
    <h1>Modules</h1>
    <a href="{{ route('modules.create') }}" class="btn btn-primary mb-3">Add Module</a>
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
            @foreach($modules as $module)
                <tr>
                    <td>{{ $module->id }}</td>
                    <td>{{ $module->name }}</td>
                    <td>
                        <a href="{{ route('modules.show', $module) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('modules.edit', $module) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('modules.destroy', $module) }}" method="POST" style="display:inline-block;">
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
