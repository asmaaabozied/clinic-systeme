@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow">
    <h1>Edit Unit Type</h1>
    <form action="{{ route('unit-types.update', $unit_type) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $unit_type->name) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('unit-types.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
