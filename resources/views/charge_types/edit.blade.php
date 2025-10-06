@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow">
    <h1>Edit Charge Type</h1>
    <form action="{{ route('charge-types.update', $charge_type) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $charge_type->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="module_ids" class="form-label">Modules</label>
            <select name="module_ids[]" class="form-control" multiple>
                @foreach($modules as $module)
                    <option value="{{ $module->id }}" @if(in_array($module->id, old('module_ids', $selectedModules))) selected @endif>{{ $module->name }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple modules.</small>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('charge-types.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
