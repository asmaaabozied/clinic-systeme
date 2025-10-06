<div id="patientDetailss" class="mt-4 mb-4 py-3 px-3 border rounded bg-light">
    <div class="row">
        <div class="col-9">
            <div class="col-md-12 mb-2">
                <span id="patientName" class="h4">{{ $patient->name }}</span>
                <span id="patient_code" class="h4">{{ $patient->patient_code ?? '' }}</span>
            </div>
            <div class="col-md-12 mb-2"><strong><i class="fas fa-user-secret" data-toggle="tooltip" data-placement="top" data-original-title="Guardian"></i></strong>
                <span id="patien-tGuardian">{{ $patient->guardian_name ?? '-' }}</span>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2"><i class="fas fa-venus-mars"></i> <span id="patient-Gender">{{ $patient->gender ?? '-' }}</span></div>
                <div class="col-md-4 mb-2"><i class="fas fa-tint"></i> <span id="patient-Blood">{{ $patient->blood_group ?? '-' }}</span></div>
                <div class="col-md-4 mb-2"><i class="fas fa-ring"></i> <span id="patient-Marital">{{ $patient->marital_status ?? '-' }}</span></div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-2"><i class="fas fa-hourglass-half"></i> <span id="patient-Age">{{ $patient->age_display ?? '-' }}</span></div>
                <div class="col-md-6 mb-2"><i class="fa fa-phone-square"></i> <span id="patient-Phone">{{ $patient->phone ?? '-' }}</span></div>
            </div>
            <div class="row">
                <div class="col-md-8 mb-2"><i class="fa fa-envelope"></i> <span id="patient-Email">{{ $patient->email ?? '-' }}</span></div>
                <div class="col-md-4 mb-2"><i class="fas fa-street-view"></i> <span id="patient-Address">{{ $patient->address ?? '-' }}</span></div>
            </div>
            <div class="row">
                <div class="col-md-9 mb-4"><span id="bar-code">@isset($barcode)<img src="{{ $barcode }}" alt="Barcode">@endisset</span></div>
                <div class="col-md-3 mb-2"><span id="qrI-mage">@isset($qr_code)<img src="{{ $qr_code }}" alt="QR">@endisset</span></div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-2"><strong>Any Known Allergies </strong> <span id="patient-Allergies">{{ $patient->allergies ?? '-' }}</span></div>
                <div class="col-md-6 mb-2"><strong>Remarks</strong> <span id="patient-Remarks">{{ $patient->remarks ?? '-' }}</span></div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2"><strong>TPA</strong> <span id="patient-TPA">{{ optional($patient->tpaPatient?->tpa)->name ?? '-' }}</span></div>
                <div class="col-md-4 mb-2"><strong>TPA ID</strong> <span id="patient-TPAID">{{ $patient->tpaPatient->number ?? '-' }}</span></div>
                <div class="col-md-4 mb-2"><strong>TPA Validity</strong> <span id="patient-TPAValidity">{{ optional($patient->tpaPatient)->validity_date ? \Carbon\Carbon::parse($patient->tpaPatient->validity_date)->format('d/m/Y') : '-' }}</span></div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-2"><strong>National ID</strong> <span id="patient-NationalId">{{ $patient->document_id ?? '-' }}</span></div>
                <div class="col-md-6 mb-2"><strong>Alternate Phone</strong> <span id="patient-AltPhone">{{ $patient->alternate_phone ?? '-' }}</span></div>
            </div>
        </div>
        <div class="col-3">
            <div class="float-end" id="patient-Img">
                @if(!empty($patient->photo))
                    <img src="{{ asset($patient->photo) }}" alt="Patient Photo" class="img-fluid rounded" />
                @else
                    <div class="no-image text-center">
                        <p>NO IMAGE</p>
                        <p>AVAILABLE</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
