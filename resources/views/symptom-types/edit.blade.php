@extends('layouts.admin')

@section('content')
<div class="container  bg-white p-4">
    <h1>Edit Symptom</h1>
    <form action="{{ route('symptom-types.update', $symptomType) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="type" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $symptomType->name) }}" required>
        </div>
      
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('symptom-types.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
