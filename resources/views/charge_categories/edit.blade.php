@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow">
    <h1>Edit Charge Category</h1>
    <form action="{{ route('charge-categories.update', $charge_category) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="charge_type_id" class="form-label">Charge Type</label>
            <select name="charge_type_id" class="form-control" required>
                <option value="">Select Charge Type</option>
                @foreach($chargeTypes as $type)
                    <option value="{{ $type->id }}" {{ $charge_category->charge_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $charge_category->name }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ $charge_category->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('charge-categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
