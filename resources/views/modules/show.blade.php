@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow">
    <h1>Module Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $module->name }}</h5>
            <a href="{{ route('modules.edit', $module) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('modules.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
