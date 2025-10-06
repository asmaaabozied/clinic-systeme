@extends('layouts.admin')

@section('page-title')
    {{ __('Assessment History') }}
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/opd/style.css') }}">
@endpush

@push('script-page')
    <script src="{{ asset('js/opd/script.js') }}"></script>
@endpush

@section('content')
<section class="page-section active" id="nurse-visit-details">
    <div class="breadcrumb">
        <a href="{{ route('nurse.index') }}" class="breadcrumb-link">Today Appointments</a>
        <span class="breadcrumb-separator">></span>
        <span class="breadcrumb-current">Assessment History</span>
    </div>

    <div class="patient-profile-section">
        <div class="profile-header">
            <div class="profile-image">
                <div class="no-image">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="#9CA3AF">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <div class="no-image-text">
                        <p>NO IMAGE</p>
                        <p>AVAILABLE</p>
                    </div>
                </div>
                <h2 class="patient-name">{{ $appointment->patient->name }}</h2>
            </div>
            <div class="profile-details">
                <div class="details-grid">
                    <div class="detail-item">
                        <label>Patient Id</label>
                        <span>{{ $appointment->patient->id }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Blood Group</label>
                        <span>{{ $appointment->patient->blood_group ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Email</label>
                        <span>{{ $appointment->patient->email ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Age</label>
                        <span>{{ $appointment->patient->age_display ?? '(As Of Date)' }}</span>
                    </div>
                    <div class="detail-item">
                        <label>OPD No</label>
                        <span class="opd-number">{{ $appointment->opd_no }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Phone</label>
                        <span>{{ $appointment->patient->phone }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Consultant Doctor</label>
                        <span>{{ $appointment?->doctor?->user?->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="assessment-section">
        <div class="section-header d-flex justify-content-between">
            <h3>Assessments</h3>
            <a href="{{ route('nurse.form', $appointment->patient->id) }}?appointment={{ $appointment->id }}" class="btn-primary">Add Assessment</a>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Temperature</th>
                                        <th>Blood Pressure</th>
                                        <th>Pain Level</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($assessments as $assessment)
                                    <tr>
                                        <td>{{ $assessment->id }}</td>
                                        <td>{{ $assessment->created_at->format('m/d/Y h:i A') }}</td>
                                        <td>{{ $assessment->temperature ?? '-' }}</td>
                                        <td>
                                            @if($assessment->blood_pressure_systolic)
                                                {{ $assessment->blood_pressure_systolic }}/{{ $assessment->blood_pressure_diastolic }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $assessment->pain_level ?? '-' }}</td>
                                        <td>
                                            <button class="action-btn view-assessment" title="View" data-url="{{ route('nurse.assessment-details', $assessment->id) }}">
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
</section>
@include('nurse.partials.assessment_view_modal')
@endsection
