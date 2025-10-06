@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow">
    <h1>Taxes</h1>
    <a href="{{ route('taxes.create') }}" class="btn btn-primary mb-3">Add Tax</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Rate (%)</th>
              
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($taxes as $tax)
                <tr>
                    <td>{{ $tax->id }}</td>
                    <td>{{ $tax->name }}</td>
                    <td>{{ $tax->rate }}</td>
                  
                    <td>
                        <a href="{{ route('taxes.show', $tax) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('taxes.edit', $tax) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('taxes.destroy', $tax) }}" method="POST" style="display:inline-block;">
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
