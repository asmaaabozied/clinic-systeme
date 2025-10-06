@extends('layouts.admin')

@section('page-title')
    {{ __('Visit Details') }}
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/opd/style.css') }}">
@endpush

@push('script-page')
    <script src="{{ asset('js/opd/script.js') }}"></script>
@endpush


@section('content')
<section class="page-section active" id="visit-details">
    <div class="breadcrumb">
        <a href="{{ route('opd.patient-profile', ['id' => $appointment->patient->id]) }}" class="breadcrumb-link" id="backToProfile">Patient Profile</a>
        <span class="breadcrumb-separator">></span>
        <span class="breadcrumb-current">Visit Details</span>
    </div>

    <div class="patient-profile-section">
        <div class="profile-header">
            <h2 class="patient-name">Visit {{ $appointment->opd_no }}</h2>
        </div>
        <div class="profile-details">
            <div class="details-grid">
                <div class="detail-item">
                    <label>Appointment Date</label>
                    <span>{{ $appointment->appointment_date->format('m/d/Y h:i A') }}</span>
                </div>
                <div class="detail-item">
                    <label>Consultant Doctor</label>
                    <span>{{ optional($appointment->doctor->user)->name }}</span>
                </div>
                <div class="detail-item">
                    <label>Reference</label>
                    <span>{{ $appointment->reference ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <label>Symptoms</label>
                    <span>{{ $appointment->symptoms_description ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <label>Previous Medical Issue</label>
                    <span>{{ $appointment->previous_medical_issues ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <label>Known Allergies</label>
                    <span>{{ $appointment->known_allergies ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <label>Note</label>
                    <span>{{ $appointment->note ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <label>Case</label>
                    <span>{{ $appointment->case ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="visits-section">
        <div class="section-header">
            <div class="tabs">
                <button class="tab active" data-tab="checkups">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 8px;">
                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                    </svg>
                    Visits
                </button>
                <button class="tab" data-tab="visit-charges">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 8px;">
                        <path d="M7,15H9C9,16.08 10.37,17 12,17C13.63,17 15,16.08 15,15C15,13.9 13.96,13.5 11.76,12.97C9.64,12.44 7,11.78 7,9C7,7.21 8.47,5.69 10.5,5.18V3H13.5V5.18C15.53,5.69 17,7.21 17,9H15C15,7.92 13.63,7 12,7C10.37,7 9,7.92 9,9C9,10.1 10.04,10.5 12.24,11.03C14.36,11.56 17,12.22 17,15C17,16.79 15.53,18.31 13.5,18.82V21H10.5V18.82C8.47,18.31 7,16.79 7,15Z"/>
                    </svg>
                    Charges
                </button>
                <button class="tab" data-tab="visit-invoices">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 8px;">
                        <path d="M20,8H4V6H20M20,18H4V12H20M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"/>
                    </svg>
                    Invoices
                </button>
            </div>
            <button class="btn-primary" id="recheckupBtn" data-appointment-id="{{ $appointment->id }}" data-doctor-id="{{ $appointment->consultant_doctor_id }}" data-patient-id="{{ $appointment->patient->id }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 8px;">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
                New Checkup
            </button>
        </div>

        <div class="tab-content active" id="checkups">
            <div class="checkups-section">
                <h3>Checkups</h3>
                <div class="current-opd">
                    <span class="opd-number">{{ $appointment->opd_no }}</span>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <table class="table datatable">
                                        <thead>
                                        <tr>
                                            <th>OPD Checkup ID</th>
                                            <th>Appointment Date</th>
                                            <th>Consultant Doctor</th>
                                            <th>Reference</th>
                                            <th>Symptoms</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($checkups as $checkup)
                                            <tr>
                                                <td>{{ $checkup->checkup_number }}</td>
                                                <td>{{ $checkup->checkup_date->format('m/d/Y h:i A') }}</td>
                                                <td>{{ $checkup->doctor?->name }}</td>
                                                <td>{{ $checkup->reference ?? '-' }}</td>
                                                <td>{{ $checkup->symptoms ?? '-' }}</td>
                                                <td>
                                                    <button class="action-btn view-checkup" title="View" data-url="{{ route('opd.checkup.details', $checkup->id) }}">
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
        </div>
        <div class="tab-content" id="visit-charges">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table datatable">
                                    <thead>
                                    <tr>
                                        <th>Service Name</th>
                                        <th>Amount</th>
                                        <th>Tax</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($appointment->chargeItems as $charge)
                                        <tr>
                                            <td>{{ $charge?->charge?->charge_name }}</td>
                                            <td>{{ $charge?->charge?->standard_charge }}</td>
                                            <td>{{ $charge?->charge?->tax?->rate }} % {{ $charge?->charge?->tax?->name }}</td>
                                            <td>{{ $charge->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $charge->is_paid ? 'Paid' : 'Unpaid' }}</td>
                                            <td>
{{--                                                <a href="{{ route('charge-item.invoice.view', $charge->id) }}" target="_blank">View</a>--}}
                                                @unless($charge->is_paid)
                                                    | <a href="{{ route('charge-item.mark-paid', $charge->id) }}">Mark as Paid</a>
                                                @endunless
                                            </td>
                                        </tr>
                                    @endforeach
                                    @foreach ($appointment->consultationServiceItems as $service)
                                        <tr class="bg-blue-400">
                                            <td>{{ $service?->charge?->charge_name }}</td>
                                            <td>{{ $service->applied_charge }}</td>
                                            <td>{{ $service->tax }} % {{ $service?->charge?->tax?->name }}</td>
                                            <td>{{ $service->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $service->is_paid ? 'Paid' : 'Unpaid' }}</td>
                                            <td>
{{--                                                <a href="{{ route('service-item.invoice.view', $service->id) }}" target="_blank">View</a>--}}
                                                @unless($service->is_paid)
                                                     <a href="{{ route('service-item.mark-paid', $service->id) }}">Mark as Paid</a>
                                                @endunless
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
        <div class="tab-content" id="visit-invoices">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Invoice No</th>
                                <th>Amount</th>
                                <th>Tax</th>
                                <th>Discount</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($appointment->invoices as $inv)
                                <tr>
                                    <td>{{ $inv->invoice_no }}</td>
                                    <td>{{ $inv->standardCharge }}</td>
                                    <td>{{ $inv->tax }}</td>
                                    <td>{{ $inv->discount }}</td>
                                    <td>{{ $inv->amount }}</td>
                                    <td>{{ $inv->is_paid ? 'Paid' : 'Unpaid' }}</td>
                                    <td>{{ $inv->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('invoice.view', $inv->id) }}" target="_blank">View</a>
                                        @unless($inv->is_paid)
                                            | <a href="{{ route('invoice.mark-paid', $inv->id) }}">Mark as Paid</a>
                                        @endunless
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
</section>

@include('opd.partials.checkup_view_modal')
@include('opd.partials.checkup_modal')
@endsection
