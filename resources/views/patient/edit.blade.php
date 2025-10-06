@extends('layouts.admin')
@section('content')
<div class="container">
    <h1>Edit Patient</h1>
    <form action="{{ route('patients.update', $patient->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" value="{{ $patient->first_name }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" value="{{ $patient->last_name }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $patient->email }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $patient->phone }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Gender</label>
                <select name="gender" class="form-control">
                    <option value="Male" @if($patient->gender=='Male') selected @endif>Male</option>
                    <option value="Female" @if($patient->gender=='Female') selected @endif>Female</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Birth Date</label>
                <input type="date" name="birth_date" class="form-control" value="{{ $patient->birth_date }}">
            </div>
            <div class="col-md-12 mb-3">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="{{ $patient->address }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Blood Type</label>
                <input type="text" name="blood_type" class="form-control" value="{{ $patient->blood_type }}">
            </div>
            <div class="col-md-12 mb-3">
                <label>Note</label>
                <textarea name="note" class="form-control">{{ $patient->note }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
