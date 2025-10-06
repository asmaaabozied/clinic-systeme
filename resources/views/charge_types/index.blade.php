@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow">
    <h1>Charge Types</h1>
    <a href="{{ route('charge-types.create') }}" class="btn btn-primary mb-3">Add Charge Type</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Modules</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chargeTypes as $chargeType)
                <tr>
                    <td>{{ $chargeType->id }}</td>
                    <td>{{ $chargeType->name }}</td>
                    <td>
                        @foreach($chargeType->modules as $module)
                            <span class="badge bg-info">{{ $module->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('charge-types.show', $chargeType) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('charge-types.edit', $chargeType) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('charge-types.destroy', $chargeType) }}" method="POST" style="display:inline-block;">
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
