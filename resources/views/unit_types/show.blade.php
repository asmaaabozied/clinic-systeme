@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow">
    <h1>Unit Type Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $unit_type->name }}</h5>
            <a href="{{ route('unit-types.edit', $unit_type) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('unit-types.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
