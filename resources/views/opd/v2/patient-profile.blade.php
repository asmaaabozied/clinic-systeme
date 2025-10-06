@extends('layouts.admin')

@section('page-title')
    {{ __('Patient Profile') }}
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/opd/style.css') }}">
@endpush

@push('script-page')
    <script src="{{ asset('js/opd/script.js') }}"></script>
    <script src="{{ asset('dist-assets/js/plugins/datatables.min.js') }}"></script>

@endpush


@section('content')
<section class="page-section active" id="patient-profile">
    <div class="breadcrumb">
        <a href="{{ route('opd.index') }}" class="breadcrumb-link" id="backToList">OPD Billing</a>
        <span class="breadcrumb-separator">></span>
        <span class="breadcrumb-current">Patient Profile</span>
    </div>

    <div class="patient-profile-section">
        @include('opd.partials.patient_details_block')
    </div>

    <div class="visits-section">
        <div class="section-header">
            <div class="tabs">
                <button class="tab active" data-tab="visits">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 8px;">
                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                    </svg>
                    Visits
                </button>
            </div>
            <button class="btn-primary" id="newVisitBtn" data-patient-id="{{ $patient->id }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 8px;">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
                New Visit
            </button>
        </div>

        <div class="tab-content active" id="visits">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body table-border-style">
                            <div class="table-responsive">
                                <table id="visitsTable" class="table datatable">
                                    <thead>
                                    <tr>
                                        <th>OPD No</th>
                                        <th>Case ID</th>
                                        <th>Appointment Date</th>
                                        <th>Consultant Doctor</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($appointments as $appointment)
                                        <tr class="visit-row" data-visit-id="{{ $appointment->id }}">
                                            <td><a href="{{ route('opd.visit-details', ['id' => $appointment->id]) }}" class="visit-link">{{ $appointment->opd_no }}</a></td>
                                            <td>{{ $appointment->case }}</td>
                                            <td>{{ $appointment->appointment_date->format('m/d/Y h:i A') }}</td>
                                            <td>{{ $appointment?->doctor?->user?->name ?? '-'  }}</td>
                                            <td>
                                                <button class="action-btn view-appointment" title="View Details"
                                                        data-opd="{{ $appointment->opd_no }}"
                                                        data-case="{{ $appointment->case_id }}"
                                                        data-name="{{ $patient->name }}"
                                                        data-gender="{{ $patient->gender }}"
                                                        data-phone="{{ $patient->phone_number }}"
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
        </div>
        <div class="tab-content" id="charges">
            <div class="empty-state">
                <h3>Charges Information</h3>
                <p>No charges recorded for this patient.</p>
            </div>
        </div>
        <div class="tab-content" id="payment">
            <div class="empty-state">
                <h3>Payment History</h3>
                <p>No payment history available.</p>
            </div>
        </div>
    </div>
</section>

@include('opd.partials.appointment_view_modal')
@include('opd.partials.opd_modal')

@push('script-page')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const params = new URLSearchParams(window.location.search);
            if (params.get('open_opd_modal') === '1' && typeof openOpdModal === 'function') {
                openOpdModal({{ $patient->id }});
            }
        });
    </script>
@endpush

@endsection
