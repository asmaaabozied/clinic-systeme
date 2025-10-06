@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4">
    <h1>Symptom Categories</h1>
    <a href="{{ route('symptom-categories.create') }}" class="btn btn-primary mb-3">Add Category</a>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="container">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->title }}</td>
                        <td>{{ $category->symptom->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <a href="{{ route('symptom-categories.show', $category) }}"
                                class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('symptom-categories.edit', $category) }}"
                                class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('symptom-categories.destroy', $category) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection