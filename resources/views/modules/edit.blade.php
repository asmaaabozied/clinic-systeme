@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow">
    <h1>Edit Module</h1>
    <form action="{{ route('modules.update', $module) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $module->name) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('modules.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
