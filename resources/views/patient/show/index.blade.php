@extends('patient.show.layout')

@section('patient-info')
<div class="patient-section">
    @include('opd.partials.patient_details_block', ['barcode' => $barcode, 'qr_code' => $qr_code])

{{--    <div class="barcode-section">--}}
{{--        <div>--}}
{{--            <div style="font-size: 0.8rem; margin-bottom: 0.5rem;">Barcode:</div>--}}
{{--            <img src="{{ $barcode }}" alt="Patient Barcode" class="barcode-image" />--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            <div style="font-size: 0.8rem; margin-bottom: 0.5rem;">QR Code:</div>--}}
{{--            <img src="{{ $qr_code }}" alt="Patient QR Code" class="barcode-image" />--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="case-info">
        <div class="detail-row">
            <span class="detail-label">Case ID:</span>
            <span class="detail-value">{{ $latestAppointment->case ?? '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">OPD No:</span>
            <span class="detail-value">
                {{ $latestAppointment->opd_no ?? '-' }}
            </span>
        </div>
    </div>

    <div class="collapsible-section">
        <div class="collapsible-header" onclick="toggleCollapsible(this)">
            <span>Known Allergies</span>
            <span>▼</span>
        </div>
        <div class="collapsible-content">
            {{ $latestAppointment->known_allergies ?? $patient->allergies ?? 'No known allergies recorded.' }}
        </div>
    </div>

    <div class="collapsible-section">
        <div class="collapsible-header" onclick="toggleCollapsible(this)">
            <span>Findings</span>
            <span>▼</span>
        </div>
        <div class="collapsible-content">
            {{ $latestAppointment->note ?? '-' }}
        </div>
    </div>

    <div class="collapsible-section">
        <div class="collapsible-header" onclick="toggleCollapsible(this)">
            <span>Symptoms</span>
            <span>▼</span>
        </div>
        <div class="collapsible-content">
            {{ $latestAppointment->symptoms_description ?? '-' }}
        </div>
    </div>

    <div class="consultant-doctor">
        <div class="doctor-photo"></div>
        <div>
            <div style="font-weight: 600;">Consultant Doctor</div>
            <div>
                {{ optional($latestAppointment->doctor->user)->name ?? '' }}
                @if(optional($latestAppointment->doctor)->doctor_code)
                    ({{ $latestAppointment->doctor->doctor_code }})
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('tab-content')
    @include('patient.show.tabs.overview')
    @include('patient.show.tabs.visits')
    @include('patient.show.tabs.medication')
    @include('patient.show.tabs.lab-investigation')
    @include('patient.show.tabs.operations')
    @include('patient.show.tabs.charges')
    @include('patient.show.tabs.payments')
    @include('patient.show.tabs.live-consultation')
    @include('patient.show.tabs.timeline')
    @include('patient.show.tabs.treatment-history')
@endsection
