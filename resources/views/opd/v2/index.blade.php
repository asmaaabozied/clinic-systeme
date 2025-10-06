@extends('layouts.admin')

@section('page-title')
    {{ __('OPD Billing') }}
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/opd/style.css') }}">
@endpush

@push('script-page')
    <script src="{{ asset('js/opd/script.js') }}"></script>
    <script>
        @if ($errors->any())
            //show patient modal if there are validation errors
            $(document).ready(function() {
                $('#patientModal').modal('show');
            });
        @endif
    </script>
@endpush


@section('content')
<section class="page-section active" id="opd-list">
    <div class="page-header">
        <h2 class="page-title">OPD Billing</h2>
        <a href="#" class="btn-primary" id="addPatientBtn" data-bs-toggle="modal" data-bs-target="#patientModal">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 8px;">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
            </svg>
            Add Patient
        </a>
    </div>

{{--    <div class="table-controls">--}}
{{--        <div class="search-table">--}}
{{--            <input type="text" placeholder="Search..." class="table-search" id="patientSearch">--}}
{{--        </div>--}}
{{--        <div class="table-actions">--}}
{{--            <select class="records-select">--}}
{{--                <option value="100">100</option>--}}
{{--                <option value="50">50</option>--}}
{{--                <option value="25">25</option>--}}
{{--                <option value="10">10</option>--}}
{{--            </select>--}}
{{--            <button class="action-btn" title="Export">--}}
{{--                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">--}}
{{--                    <path d="M14,3V5H17.59L7.76,14.83L9.17,16.24L19,6.41V10H21V3M19,19H5V5H12V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V12H19V19Z"/>--}}
{{--                </svg>--}}
{{--            </button>--}}
{{--            <button class="action-btn" title="Copy">--}}
{{--                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">--}}
{{--                    <path d="M17,9H7V7H17M17,13H7V11H17M14,17H7V15H14M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z"/>--}}
{{--                </svg>--}}
{{--            </button>--}}
{{--            <button class="action-btn" title="PDF">--}}
{{--                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">--}}
{{--                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>--}}
{{--                </svg>--}}
{{--            </button>--}}
{{--            <button class="action-btn" title="Print">--}}
{{--                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">--}}
{{--                    <path d="M6,2A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2H6M6,4H13V9H18V20H6V4Z"/>--}}
{{--                </svg>--}}
{{--            </button>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Patient Id</th>
                                <th>Guardian Name</th>
                                <th>Gender</th>
                                <th>Phone</th>
{{--                                <th>Consultant Doctor</th>--}}
                                <th>Last Visit</th>
                                <th>Previous Medical Issue</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($patients as $patient)
                                <tr  data-patient-id="{{ $patient->id }}">
                                    <td class="Id"><a href="{{ route('opd.patient-profile', ['id' => $patient->id]) }}" class="btn btn-outline-primary">{{ $patient->name }}</a></td>
                                    <td>{{ $patient->id }}</td>
                                    <td>{{ $patient->guardian_name ?? '-' }}</td>
                                    <td>{{ $patient->gender}}</td>
                                    <td>{{ $patient->phone }}</td>
{{--                                    <td>{{ $patient?->doctor?->user?->name }}</td>--}}
                                    <td>{{ $patient->appointments ? $patient->appointments->last()?->created_at?->format('m/d/Y h:i A') : '-' }}</td>
                                    <td>{{ $patient->previous_medical_issue ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('opd.patient-profile', ['id' => $patient->id]) }}" class="action-btn" title="View">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/>
                                            </svg>
                                        </a>
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
    {{--    <div class="data-table">--}}
    {{--        <table id="patientsTable">--}}
    {{--            <thead>--}}
    {{--                <tr>--}}
    {{--                    <th>Name</th>--}}
    {{--                    <th>Patient Id</th>--}}
    {{--                    <th>Guardian Name</th>--}}
    {{--                    <th>Gender</th>--}}
    {{--                    <th>Phone</th>--}}
    {{--                    <th>Consultant Doctor</th>--}}
    {{--                    <th>Last Visit</th>--}}
    {{--                    <th>Previous Medical Issue</th>--}}
    {{--                    <th>Is Antenatal</th>--}}
    {{--                    <th>Action</th>--}}
    {{--                </tr>--}}
    {{--            </thead>--}}
    {{--            <tbody>--}}
    {{--                @foreach($patients as $patient)--}}
    {{--                <tr class="patient-row" data-patient-id="{{ $patient->id }}">--}}
    {{--                    <td><a href="{{ route('opd.patient-profile', ['id' => $patient->id]) }}" class="patient-link">{{ $patient->name }}</a></td>--}}
    {{--                    <td>{{ $patient->id }}</td>--}}
    {{--                    <td>{{ $patient->guardian_name ?? '-' }}</td>--}}
    {{--                    <td>{{ $patient->gender_id == 1 ? 'Male' : ($patient->gender_id == 2 ? 'Female' : '-') }}</td>--}}
    {{--                    <td>{{ $patient->phone_number }}</td>--}}
    {{--                    <td>{{ $patient->consultant_doctor }}</td>--}}
    {{--                    <td>{{ $patient->last_visit ? $patient->last_visit->format('m/d/Y h:i A') : '-' }}</td>--}}
    {{--                    <td>{{ $patient->previous_medical_issue ?? '-' }}</td>--}}
    {{--                    <td>{{ $patient->is_antenatal ? 'Yes' : 'No' }}</td>--}}
    {{--                    <td>--}}
    {{--                        <a href="{{ route('opd.patient-profile', ['id' => $patient->id]) }}" class="action-btn" title="View">--}}
    {{--                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">--}}
    {{--                                <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/>--}}
    {{--                            </svg>--}}
    {{--                        </a>--}}
    {{--                    </td>--}}
    {{--                </tr>--}}
    {{--                @endforeach--}}
    {{--            </tbody>--}}
    {{--        </table>--}}
    {{--    </div>--}}
    <div class="modal fade" id="patientModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body p-0">
                    @include('opd.new.partials.patient_registration_form')
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


{{--@include('opd.partials.opd_modal')--}}
