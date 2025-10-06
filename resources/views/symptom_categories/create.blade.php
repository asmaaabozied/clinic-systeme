@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4">
    <h1>Add Symptom Category</h1>
    <form action="{{ route('symptom-categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="symptom_type_id" class="form-label">Symptom Type</label>
            @if ($symptomType !== null)
            <select class="form-control" disabled required>
                <option value="{{ $symptomType->id }}">{{ $symptomType->name }}</option>
            </select>
            <input type="hidden" name="symptom_type_id" value="{{ $symptomType->id }}">
            @else
            <select name="symptom_type_id" class="form-control" required>
                <option value="">-- Select Type --</option>
                @foreach($types as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            @endif

        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('symptom-categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection