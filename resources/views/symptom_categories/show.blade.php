@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4">
    <h1>Symptom Category Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $category->title }}</h5>
            <p class="card-text"><strong>Type:</strong> {{ $category->symptom->name }}</p>
            <p class="card-text"><strong>Description:</strong> {{ $category->description }}</p>
            <a href="{{ route('symptom-categories.edit', $category) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('symptom-categories.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
