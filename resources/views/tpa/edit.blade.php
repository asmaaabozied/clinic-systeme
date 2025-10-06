@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4">
    <h1>Edit TPA</h1>
    <form action="{{ route('tpas.update', $tpa) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $tpa->name) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('tpas.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
