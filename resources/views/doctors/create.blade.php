@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 rounded shadow">
    <h1>Add Doctor</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('doctors.store') }}" method="POST">
        @csrf

        <div class="row">
            {{-- اختيار الدكتور --}}
            <div class="col-md-6 mb-3">
                <label>Doctor</label>
                <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                    <option value="">Select a doctor</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->email }})</option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- التخصص --}}
            <div class="col-md-6 mb-3">
                <label>Specialization</label>
                <select name="specialization_id" class="form-control @error('specialization_id') is-invalid @enderror" required>
                    <option value="">Select specialization</option>
                    @foreach($specializations as $specialization)
                        <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                    @endforeach
                </select>
                @error('specialization_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- الهاتف --}}
            <div class="col-md-6 mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- عنوان العيادة --}}
            <div class="col-md-6 mb-3">
                <label>Clinic Address</label>
                <input type="text" name="clinic_address" class="form-control @error('clinic_address') is-invalid @enderror" value="{{ old('clinic_address') }}">
                @error('clinic_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- عدد سنوات الخبرة --}}
            <div class="col-md-6 mb-3">
                <label>Experience Years</label>
                <input type="number" name="experience_years" class="form-control @error('experience_years') is-invalid @enderror" value="{{ old('experience_years') }}">
                @error('experience_years')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- نبذة عن الدكتور --}}
            <div class="col-md-12 mb-3">
                <label>Bio</label>
                <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" rows="4">{{ old('bio') }}</textarea>
                @error('bio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
