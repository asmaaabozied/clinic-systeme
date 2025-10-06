@extends('layouts.admin')

@section('page-title')
    {{ __('Today Appointments') }}
@endsection
@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/opd/style.css') }}">
@endpush
@push('script-page')
    <script src="{{ asset('js/opd/script.js') }}"></script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Nurse') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table id="visitsTable" class="table datatable">
                            <thead>
                            <tr>
                                <th>OPD No</th>
                                <th>Patient Name</th>
                                <th>Appointment Date</th>
                                <th>Consultant Doctor</th>
                                <th>Reference</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($appointments as $appointment)
                                @php $patient = $appointment->patient; @endphp
                                <tr class="visit-row" data-visit-id="{{ $appointment->id }}">
                                    <td><a href="{{ route('nurse.visit-details', ['id' => $appointment->id]) }}" class="visit-link">{{ $appointment->opd_no }}</a></td>
                                    <td>{{ $appointment?->patient?->name }}</td>
                                    <td>{{ $appointment->appointment_date->format('m/d/Y h:i A') }}</td>
                                    <td>{{ $appointment?->doctor?->user?->name ?? '-'  }}</td>
                                    <td>{{ $appointment->reference ?? '-' }}</td>
                                    <td>
                                        <button class="action-btn view-appointment" title="View Details"
                                                data-opd="{{ $appointment->opd_no }}"
                                                data-case="{{ $appointment->case_id }}"
                                                data-name="{{ $patient->name }}"
                                                data-gender="{{ $patient->gender }}"
                                                data-phone="{{ $patient->phone }}"
                                                data-email="{{ $patient->email ?? '-' }}"
                                                data-date="{{ $appointment->appointment_date->format('m/d/Y h:i A') }}"
                                                data-doctor="{{ $appointment?->doctor?->user?->name ?? '-' }}">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('opd.partials.appointment_view_modal')
