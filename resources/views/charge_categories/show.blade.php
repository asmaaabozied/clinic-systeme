@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow">
    <h1>Charge Category Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $charge_category->name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">Charge Type: {{ $charge_category->chargeType ? $charge_category->chargeType->name : '' }}</h6>
            <p class="card-text">Description: {{ $charge_category->description }}</p>
            <a href="{{ route('charge-categories.edit', $charge_category) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('charge-categories.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
