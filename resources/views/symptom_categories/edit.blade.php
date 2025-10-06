@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4">
    <h1>Edit Symptom Category</h1>
    <form action="{{ route('symptom-categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $category->title) }}" required>
        </div>
        <div class="mb-3">
            <label for="symptom_type_id" class="form-label">Symptom Type</label>
            <select name="symptom_type_id" class="form-control" required>
                <option value="">Select Type</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}" @if($type->id == old('symptom_type_id', $category->symptom_type_id)) selected @endif>{{ $type->name ?? $type->title ?? $type->id }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('symptom-categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
