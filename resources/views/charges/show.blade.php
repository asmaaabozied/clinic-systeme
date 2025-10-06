@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow"">
    <h1>Charge Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $charge->charge_name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">Type: {{ $charge->chargeType ? $charge->chargeType->name : '' }}</h6>
            <h6 class="card-subtitle mb-2 text-muted">Category: {{ $charge->chargeCategory ? $charge->chargeCategory->name : '' }}</h6>
            <h6 class="card-subtitle mb-2 text-muted">Unit: {{ $charge->unitType ? $charge->unitType->name : '' }}</h6>
            <h6 class="card-subtitle mb-2 text-muted">Tax: {{ $charge->tax ? $charge->tax->name : '' }}</h6>
            <p class="card-text">Tax Percentage: {{ $charge->tax_percentage }}</p>
            <p class="card-text">Standard Charge: {{ $charge->standard_charge }}</p>
            <p class="card-text">Description: {{ $charge->description }}</p>
            <a href="{{ route('charges.edit', $charge) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('charges.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
