@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow">
    <h1>Add Module</h1>
    <form action="{{ route('modules.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('modules.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
