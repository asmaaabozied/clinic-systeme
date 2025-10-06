@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow">
    <h1>Add Charge</h1>
    <form action="{{ route('charges.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="charge_type_id" class="form-label">Charge Type</label>
            <select name="charge_type_id" id="charge_type_id" class="form-control" required>
                <option value="">Select Charge Type</option>
                @foreach($chargeTypes as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="charge_category_id" class="form-label">Charge Category</label>
            <select name="charge_category_id" id="charge_category_id" class="form-control" required>
                <option value="">Select Charge Category</option>
                @foreach($chargeCategories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="unit_type_id" class="form-label">Unit Type</label>
            <select name="unit_type_id" class="form-control" required>
                <option value="">Select Unit Type</option>
                @foreach($unitTypes as $unit)
                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="charge_name" class="form-label">Charge Name</label>
            <input type="text" name="charge_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="tax_id" class="form-label">Tax</label>
            <select name="tax_id" class="form-control">
                <option value="">Select Tax</option>
                @foreach($taxes as $tax)
                <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tax_percentage" class="form-label">Tax Percentage</label>
            <input type="number" step="0.01" name="tax_percentage" id="tax_percentage" class="form-control" value="0"
                disabled>
        </div>
        <div class="mb-3">
            <label for="standard_charge" class="form-label">Standard Charge</label>
            <input type="number" step="0.01" name="standard_charge" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('charges.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@push('script-page')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('charge_type_id').addEventListener('change', function () {
            const typeId = this.value;
            const categorySelect = document.getElementById('charge_category_id');
            categorySelect.innerHTML = '<option value="">Loading...</option>';

            if (typeId) {
                fetch(`/get-categories-by-type/${typeId}`)
                    .then(res => res.json())
                    .then(data => {
                        categorySelect.innerHTML = '<option value="">Select Charge Category</option>';
                        data.forEach(cat => {
                            categorySelect.innerHTML += `<option value="${cat.id}">${cat.name}</option>`;
                        });
                    });
            } else {
                categorySelect.innerHTML = '<option value="">Select Charge Category</option>';
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // عند تغيير نوع الـ tax
        document.querySelector('[name="tax_id"]').addEventListener('change', function () {
            const taxId = this.value;
            const taxPercentageInput = document.getElementById('tax_percentage');

            if (taxId) {
                fetch(`/get-tax-rate/${taxId}`)
                    .then(res => res.json())
                    .then(data => {
                        taxPercentageInput.value = data.rate || 0;
                        taxPercentageInput.disabled = true;
                    });
            } else {
                taxPercentageInput.value = 0;
                taxPercentageInput.disabled = false;
            }
        });

        // عند تغيير نوع الـ charge_type
        document.getElementById('charge_type_id').addEventListener('change', function () {
            const typeId = this.value;
            const categorySelect = document.getElementById('charge_category_id');
            categorySelect.innerHTML = '<option value="">Loading...</option>';

            if (typeId) {
                fetch(`/get-categories-by-type/${typeId}`)
                    .then(res => res.json())
                    .then(data => {
                        categorySelect.innerHTML = '<option value="">Select Charge Category</option>';
                        data.forEach(cat => {
                            categorySelect.innerHTML += `<option value="${cat.id}">${cat.name}</option>`;
                        });
                    });
            } else {
                categorySelect.innerHTML = '<option value="">Select Charge Category</option>';
            }
        });
    });
</script>

@endpush

@endsection