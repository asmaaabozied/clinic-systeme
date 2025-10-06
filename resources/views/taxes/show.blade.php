@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow">
    <h1>Tax Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $tax->name }}</h5>
            <p class="card-text"><strong>Rate:</strong> {{ $tax->rate }}%</p>
            <p class="card-text"><strong>Description:</strong> {{ $tax->description }}</p>
            <a href="{{ route('taxes.edit', $tax) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('taxes.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
