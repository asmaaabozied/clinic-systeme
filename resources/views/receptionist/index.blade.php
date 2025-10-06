@extends('layouts.admin')

@section('page-title')
    {{ __('Patients') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Receptionist') }}</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-end">
            <a href="{{ route('receptionist.create') }}" class="btn btn-sm btn-primary">{{ __('Add Patient') }}</a>
        </div>
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Phone') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($patients as $patient)
                        <tr>
                            <td>{{ $patient->patient_code }}</td>
                            <td>{{ $patient->name }}</td>
                            <td>{{ $patient->phone }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $patients->links() }}
            </div>
        </div>
    </div>
@endsection
