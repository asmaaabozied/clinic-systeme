@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4">
    <h1>Add TPA</h1>
    <form action="{{ route('tpas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('tpas.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
