@extends('layouts.admin')

@section('content')
<div class="container  bg-white p-4">
    <h1>Symptom Type</h1>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <h5 class="card-title">{{ $symptomType->name }}</h5>
                </div>
                <div class="col-6">
                    <div class="float-lg-end">
                        <a href="{{ route('symptom-types.edit', $symptomType) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('symptom-types.index') }}" class="btn btn-secondary">Back to List</a>
                        <a href="{{ route('symptom-categories.create',$symptomType->id) }}"
                            class="btn btn-secondary">add new category</a>
                    </div>
                </div>
            </div>
            <div class="container mt-5 mb-3">
               
                <div class="table-responsive">
                     <h4 class="mb-1">Categories</h4>
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->title }}</td>
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

    </div>
</div>
@endsection