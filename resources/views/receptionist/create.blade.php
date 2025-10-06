@extends('layouts.admin')

@section('page-title')
    {{ __('Add Patient') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('receptionist.index') }}">{{ __('Receptionist') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create') }}</li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('receptionist.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>{{ __('Name') }}</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>{{ __('Email') }}</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>{{ __('Phone') }}</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>{{ __('Gender') }}</label>
                    <select name="gender" class="form-control" required>
                        <option value="male">{{ __('Male') }}</option>
                        <option value="female">{{ __('Female') }}</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>{{ __('Date of Birth') }}</label>
                    <input type="date" name="date_of_birth" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>{{ __('Blood Group') }}</label>
                    <input type="text" name="blood_group" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>{{ __('Marital Status') }}</label>
                    <input type="text" name="marital_status" class="form-control">
                </div>
                <div class="col-md-12 mb-3">
                    <label>{{ __('Address') }}</label>
                    <input type="text" name="address" class="form-control">
                </div>
                <div class="col-md-12 mb-3">
                    <label>{{ __('Remarks') }}</label>
                    <textarea name="remarks" class="form-control"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
            <a href="{{ route('receptionist.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </form>
    </div>
</div>
@endsection
