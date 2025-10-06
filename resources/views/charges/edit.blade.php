@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow"">
    <h1>Edit Charge</h1>
    <form action="{{ route('charges.update', $charge) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="charge_type_id" class="form-label">Charge Type</label>
            <select name="charge_type_id" class="form-control" required>
                <option value="">Select Charge Type</option>
                @foreach($chargeTypes as $type)
                    <option value="{{ $type->id }}" {{ $charge->charge_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="charge_category_id" class="form-label">Charge Category</label>
            <select name="charge_category_id" class="form-control" required>
                <option value="">Select Charge Category</option>
                @foreach($chargeCategories as $cat)
                    <option value="{{ $cat->id }}" {{ $charge->charge_category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="unit_type_id" class="form-label">Unit Type</label>
            <select name="unit_type_id" class="form-control" required>
                <option value="">Select Unit Type</option>
                @foreach($unitTypes as $unit)
                    <option value="{{ $unit->id }}" {{ $charge->unit_type_id == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="charge_name" class="form-label">Charge Name</label>
            <input type="text" name="charge_name" class="form-control" value="{{ $charge->charge_name }}" required>
        </div>
        <div class="mb-3">
            <label for="tax_id" class="form-label">Tax</label>
            <select name="tax_id" class="form-control">
                <option value="">Select Tax</option>
                @foreach($taxes as $tax)
                    <option value="{{ $tax->id }}" {{ $charge->tax_id == $tax->id ? 'selected' : '' }}>{{ $tax->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tax_percentage" class="form-label">Tax Percentage</label>
            <input type="number" step="0.01" name="tax_percentage" class="form-control" value="{{ $charge->tax_percentage }}">
        </div>
        <div class="mb-3">
            <label for="standard_charge" class="form-label">Standard Charge</label>
            <input type="number" step="0.01" name="standard_charge" class="form-control" value="{{ $charge->standard_charge }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ $charge->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('charges.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
