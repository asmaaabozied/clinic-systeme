@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow">
    <h1>Add Charge Type</h1>
    <form action="{{ route('charge-types.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="module_ids" class="form-label">Modules</label>
            <select name="module_ids[]" class="form-control" multiple>
                @foreach($modules as $module)
                    <option value="{{ $module->id }}">{{ $module->name }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple modules.</small>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('charge-types.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
