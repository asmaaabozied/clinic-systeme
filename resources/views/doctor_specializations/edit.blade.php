@extends('layouts.admin')
@section('content')
<div class="container bg-white p-4 rounded shadow">
    <h1>Edit Doctor Specialization</h1>

    {{-- عرض الأخطاء لو موجودة --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('doctor-specializations.update', $specialization->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label> Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $specialization->name) }}" required>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('doctor-specializations.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
