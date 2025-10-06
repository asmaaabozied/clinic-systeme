@extends('layouts.admin')

@section('content')
<style>
    .custom-tab {
        border: none;
        background: none;
        color: #007bff;
        border-bottom: 4px solid transparent;
        border-radius: 0;
        padding: 0.5rem 1rem;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
    }

    .custom-tab:hover {
        border-bottom: 4px solid #007bff;
        color: #0056b3;
    }

    .custom-tab.active {
        border-bottom: 4px solid #007bff;
        font-weight: bold;
    }

    .nav .nav-item .nav-link {
        position: relative;
        /* border-radius: 4px; */
        border-bottom: 2px solid #007bff;
    }

    .custom-search {
        border: none;
        border-bottom: 2px solid #007bff;
        border-radius: 0;
        outline: none;
        box-shadow: none;
    }

    .cke_notifications_area {
        pointer-events: none;
        display: none !important;
    }

    .custom-search:focus {
        border-bottom: 2px solid #0056b3;
        box-shadow: none;
    }

    .hover-icon-cell {
        position: relative;
    }

    .hover-icon-cell .icon-value {
        display: none;
    }

    .hover-icon-cell:hover .text-value {
        display: none;
    }

    .hover-icon-cell:hover .icon-value {
        display: inline-block;
    }

    .medicine-row {
        position: relative;
        margin-bottom: 20px;
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        border: 1px solid #dee2e6;
    }

    .remove-medicine {
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>
@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="container p-3 bg-white shadow">
    <ul class="nav border-0" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class=" custom-tab active" id="OPD-tab" data-bs-toggle="tab" href="#OPD" role="tab" aria-controls="OPD"
                aria-selected="true">ODP View</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class=" custom-tab" id="patient-tab" data-bs-toggle="tab" href="#patient" role="tab"
                aria-controls="patient" aria-selected="false">Patient View</a>
        </li>
    </ul>

    <div class="tab-content pt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="OPD" role="tabpanel" aria-labelledby="OPD-tab">

            <div class="row py-3">
                <div class="col-6"> <input type="text" class="form-control custom-search w-50" placeholder="Search...">
                </div>
                <div class="col-6"> <a href="#" class="btn btn-primary bg-behance border-body float-end"
                        data-bs-toggle="modal" data-bs-target="#fullScreenModal">Add patient</a></div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>OPD No</th>
                            <th>Patient Name</th>
                            <th>Case ID</th>
                            <th>Appointment Date</th>
                            <th>Consultant</th>
                            <th>Reference</th>
                            <th style="width: 300px; max-width: 300px; word-break: break-word;">Symptoms</th>
                            <th>Previous Medical Issue</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                        <tr>
                            <td><a href="{{'opd/'.$appointment->id}}"
                                    class="text-linkedin fw-bolder ">OPD{{$appointment->id}}</a></td>
                            <td>{{$appointment->patient->name  ?? ''}}</td>
                            <td>{{$appointment->case}}</td>
                            <td>{{$appointment->appointment_date}}</td>
                            <td>{{$appointment->doctor->user->name ?? ''}} ({{$appointment->doctor->doctor_code ?? ''}})</td>
                            <td>{{$appointment->reference}}</td>
                            <td
                                style="min-width: 300px; word-break: break-word; white-space: normal;font-size: smaller;">
                                {{$appointment->symptoms_description}}
                            </td>
                            <td>{{$appointment->previous_medical_issues}}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-light" title="Print Bill"
                                    onclick="showInvoice({{ $appointment->id }})">
                                    <i class="fa fa-print"></i>
                                </a>

                                <a href="#" class="btn btn-sm btn-light view-prescription" title="View Prescription"
                                    data-bs-toggle="modal" data-bs-target="#prescriptionModal"
                                    data-appointment-id="{{ $appointment->id }}"
                                    data-patient-id="{{ $appointment->patient->id ?? '' }}"
                                    data-doctor-id="{{ $appointment->consultant_doctor_id  }}"
                                    data-patient-name="{{ $appointment->patient->name ?? '' }}">
                                    <i class="fas fa-file-prescription"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-light" title="Manual Prescription"><i
                                        class="fa fa-file"></i> </a>
                                @if ($appointment->id)
                                <a href="{{route('opd.show',[$appointment->id])}}"
                                    class="icon-value btn btn-sm btn-light" title="Show">
                                    <i class="fa fa-bars"></i>
                                </a>
                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $appointments->links() }}
            </div>
        </div>
        <div class="tab-pane fade" id="patient" role="tabpanel" aria-labelledby="patient-tab">
            <div class="row py-3">
                <div class="col-10">
                    <input type="text" class="form-control custom-search w-25" placeholder="Search...">
                </div>
                <div class="col-2"> <a href="#" class="btn btn-primary bg-behance border-body float-end"
                        data-bs-toggle="modal" data-bs-target="#fullScreenModal">Add patient</a></div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Patient Id</th>
                            <th>Guardian Name</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Consultant</th>
                            <th>Last Visit</th>
                            <th>Total Recheckup</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $patient)
                        <tr>
                            <td>{{$patient->name}}</td>
                            <td>{{$patient->patient_code}}</td>
                            <td>{{$patient->guardian_name}}</td>
                            <td>{{$patient->gender}}</td>
                            <td>{{$patient->phone}}</td>
                            <td>{{ optional($patient->appointments->last())->doctor?->user->name }} {{
                                optional($patient->appointments->last())->doctor?->doctor_code?' (
                                '.optional($patient->appointments->last())->doctor?->doctor_code.' )':' - ' }}</td>
                            <td>{{$patient->created_at}}</td>
                            <td class="hover-icon-cell">
                                <span class="text-value">{{$patient->appointments->count()}}</span>
                                @if ($patient->appointments->last())
                                 
                                <a href="{{route('opd.show',[$patient->appointments->last()->id])}}"
                                    class="icon-value btn btn-sm btn-light" title="Show">
                                    <i class="fa fa-bars"></i>
                                </a>
                                @endif

                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $patients->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="fullScreenModal" tabindex="-1" aria-labelledby="fullScreenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <form id="appointmentForm" onsubmit="event.preventDefault();">
            <div class="modal-content">
                <div class="modal-header bg-behance ">
                    <div class="d-flex align-items-center gap-2">
                        <div>
                            <select class="form-select" name="patient_id" id="patient_id" style="WIDTH: 400PX;">
                                <option selected disabled>Select patient </option>

                                @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}" {{ session('patient') && session('patient')->id ==
                                    $patient->id ? 'selected' : '' }}>{{ $patient->name }}</option> @endforeach
                            </select>
                            <span class="text-danger fw-bolder error-patient_id d-none"></span>
                        </div>
                        <button type="button" class="btn btn-primary btn-light-light text-dark" data-bs-toggle="modal"
                            data-bs-target="#smallModal">
                            New Patient
                        </button>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-8 border-end">
                            <div class="row">
                                <div class="col-12">


                                    <div id="patientDetails" class="mt-4 mb-4 py-3 px-3 border rounded bg-light"
                                        style="display:none;">
                                        <div class="row">


                                            <div class="col-6">
                                                <div class="col-md-12 mb-2">
                                                    <span id="patientName" class="h4"></span>
                                                    <span id='patient_code' class="h4"></span>
                                                </div>
                                                <div class="col-md-12 mb-2"><strong> <i class="fas fa-user-secret"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Guardian"></i> </strong>
                                                    <span id="patientGuardian"></span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2"> <i class="fas fa-venus-mars"> </i> <span
                                                            id="patientGender"></span></div>
                                                    <div class="col-md-4 mb-2"><i class="fas fa-tint"></i> <span
                                                            id="patientBlood"></span></div>
                                                    <div class="col-md-4 mb-2"> <i class="fas fa-ring"></i> <span
                                                            id="patientMarital"></span></div>
                                                </div>
                                                <div class="col-md-12 mb-2"><i class="fas fa-hourglass-half"></i> <span
                                                        id="patientAge"></span>
                                                </div>
                                                <div class="col-md-12 mb-2"><i class="fa fa-phone-square"></i> <span
                                                        id="patientPhone"></span></div>
                                                <div class="col-md-12 mb-2"><i class="fa fa-envelope"></i> <span
                                                        id="patientEmail"></span></div>
                                                <div class="col-md-12 mb-2"><i class="fas fa-street-view"></i> <span
                                                        id="patientAddress"></span></div>

                                                <div class="col-md-12 mb-4"> <span id="barcode"></span>
                                                </div>
                                                <div class="col-md-12 mb-2"> <span id="qrImage"></span>
                                                </div>
                                                <div class="col-md-12 mb-2"><strong>Any Known Allergies </strong> <span
                                                        id="patientAllergies"></span></div>
                                                <div class="col-md-12 mb-2"><strong>Remarks</strong> <span
                                                        id="patientRemarks"></span></div>

                                                <div class="col-md-12 mb-2"><strong>TPA</strong> <span
                                                        id="patientTPA"></span>
                                                </div>
                                                <div class="col-md-12 mb-2"><strong>TPA ID</strong> <span
                                                        id="patientTPAID"></span></div>
                                                <div class="col-md-12 mb-2"><strong>TPA Validity</strong> <span
                                                        id="patientTPAValidity"></span></div>

                                                <div class="col-md-12 mb-2"><strong>National ID</strong> <span
                                                        id="patientNationalId"></span></div>
                                                <div class="col-md-12 mb-2"><strong>Alternate Phone</strong> <span
                                                        id="patientAltPhone"></span></div>

                                            </div>
                                            <div class="col-6">
                                                <div class="float-end" id="patientImg">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="symptoms_type" class="form-label">Symptoms Type</label>
                                        <select class="form-select" id="symptoms_type" name="symptoms_type_id[]"
                                            multiple>
                                            <option selected disabled>Select</option>
                                            @foreach ($symptoms as $symptom)
                                            <option value="{{ $symptom->id }}">{{ $symptom->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" id="symptoms_type_array" name="symptoms_type_array">
                                        <span class="text-danger fw-bolder error-symptoms_type d-none"></span>

                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="symptoms_title" class="form-label">Symptoms Title</label>
                                        <select class="form-select" id="symptoms_title" name="symptoms_title[]"
                                            multiple>
                                            <option selected disabled>Select</option>
                                            @foreach ($symptomCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" id="symptoms_title_array" name="symptoms_title_array">
                                        <span class="text-danger fw-bolder error-symptoms_title_array d-none"></span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="symptoms_description" class="form-label">Symptoms
                                            Description</label>
                                        <textarea class="form-control" id="symptoms_description" rows="3"></textarea>
                                        <span class="text-danger fw-bolder error-symptoms_description d-none"></span>
                                    </div>
                                </div>
                            </div>





                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="note" class="form-label">Note</label>
                                        <textarea class="form-control" id="note" name="note" rows="2"></textarea>
                                        <span class="text-danger fw-bolder error-note d-none"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="allergies" class="form-label">Any Known Allergies</label>
                                        <input type="text" class="form-control" id="allergies" name="allergies">
                                        <span class="text-danger fw-bolder error-allergies d-none"></span>
                                    </div>
                                </div>
                            </div>



                            <div class="mb-3">
                                <label for="previous_medical_issues" class="form-label">Previous Medical
                                    Issue</label>
                                <input type="text" class="form-control" id="previous_medical_issues"
                                    name="previous_medical_issues">
                                <span class="text-danger fw-bolder error-previous_medical_issues d-none"></span>
                            </div>
                        </div>

                        <div class="col-md-4 bg-light">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="appointment_date" class="form-label">Appointment Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="appointment_date"
                                            name="appointment_date" required>
                                        <span class="text-danger fw-bolder error-appointment_date d-none"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="case" class="form-label">Case</label>
                                        <input type="text" class="form-control" id="case" name="case">
                                        <span class="text-danger fw-bolder error-case d-none"></span>
                                    </div>
                                </div>



                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Casualty</label>
                                        <select class="form-select" name="casualty" id="casualty">
                                            <option value="0" selected>No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                        <span class="text-danger fw-bolder error-casualty d-none"></span>
                                    </div>


                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Old Patient</label>
                                        <select class="form-select" id="old_patient" name="old_patient">
                                            <option value="0" selected>No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                        <span class="text-danger fw-bolder error-old_patient d-none"></span>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="reference" class="form-label">Reference</label>
                                        <input type="text" class="form-control" id="reference" name="reference">
                                        <span class="text-danger fw-bolder error-reference d-none"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="consultantDoctor" class="form-label">Consultant Doctor <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="consultantDoctor" required>
                                            <option selected disabled>Select</option>
                                            @foreach ($doctors as $doctor)
                                            <option value="{{$doctor->id}}">{{$doctor->user->name}}</option>
                                            @endforeach

                                        </select>
                                        <input type="hidden" name="consultant_doctor_id" id="hiddenConsultantDoctor">
                                        <span class="text-danger fw-bolder error-consultant_doctor_id d-none"></span>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="apply_tpa">Apply TPA</label>
                                        <select class="form-select" id="apply_tpa">
                                            <option value="0" selected>No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                        <span class="text-danger fw-bolder error-apply_tpa d-none"></span>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="chargeCategory" class="form-label">Charge Category</label>
                                        <select class="form-select" id="chargeCategory" name="chargeCategory">
                                            <option selected disabled>Select</option>
                                            @foreach ($chargeCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="charge_category_id" id="hiddenChargeCategory">

                                        <span class="text-danger fw-bolder error-charge_category_id d-none"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="charge" class="form-label">Charges <span class="text-danger">*</span></label>
                                        <select class="form-select" id="charge" multiple></select>
                                        <span class="text-danger fw-bolder error-charge_id d-none"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mb-3">
                                <table class="table table-bordered align-middle" id="chargesTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Charge Name</th>
                                            <th>Standard Charge ($)</th>
                                            <th>Applied Charge ($)</th>
                                            <th>Discount (%)</th>
                                            <th>Tax (%)</th>
                                            <th>Amount ($)</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-end fw-bold">Total</td>
                                            <td><input type="number" class="form-control" id="paidAmount" readonly></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="payment_method" class="form-label">Payment Mode</label>
                                        <select class="form-select" id="payment_method" name="payment_method">
                                            <option value="Cash" selected>Cash</option>
                                            <option value="Card">Card</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                        </select>
                                        <span class="text-danger fw-bolder error-payment_method d-none"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="live_consultation">Live Consultation</label>
                                        <select class="form-select" id="live_consultation">
                                            <option value="0" selected>No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>

                    <div class="modal-footer mt-4">
                        <button type="button" class="btn btn-secondary bg-behance border-body" data-bs-dismiss="modal">
                            <i class="fa fa-print"></i> Save and print
                        </button>
                        <button type="submit" class="btn btn-primary bg-behance border-body">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="smallModal" tabindex="-1" aria-labelledby="smallModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-behance">
                <h5 class="modal-title text-light" id="smallModalLabel">Add Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="patientForm" enctype="multipart/form-data" onsubmit="event.preventDefault();">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter patient name">
                            <div class="invalid-feedback" id="error-name"></div>
                        </div>
                        <div class="col-6">
                            <label for="guardian_name" class="form-label">Guardian Name</label>
                            <input type="text" class="form-control" name="guardian_name" id="guardian_name"
                                placeholder="Guardian name">
                            <div class="invalid-feedback" id="error-guardian_name"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                            <select id="gender" name="gender" class="form-select">
                                <option selected disabled>Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <div class="invalid-feedback" id="error-gender"></div>
                        </div>
                        <div class="col-4">
                            <label for="date_of_birth" class="form-label">Date Of Birth <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date_of_birth" id="date_of_birth">
                            <div class="invalid-feedback" id="error-date_of_birth"></div>
                        </div>
                        <div class="row mb-3 col-4">
                            <div class="col-12 mb-2">
                                <label class="form-label">Age (yy-mm-dd) </label>
                            </div>
                            <div class="col-4">
                                <input type="number" disabled class="form-control" id="ageYear" placeholder="Year"
                                    min="0">
                            </div>
                            <div class="col-4">
                                <input type="number" disabled class="form-control" id="ageMonth" placeholder="Month"
                                    min="0" max="11">
                            </div>
                            <div class="col-4">
                                <input type="number" disabled class="form-control" id="ageDay" placeholder="Day" min="0"
                                    max="31">
                            </div>
                        </div>
                    </div>





                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="blood_group" class="form-label">Blood Group</label>
                            <select id="blood_group" name="blood_group" class="form-select">
                                <option selected disabled>Select</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                            <div class="invalid-feedback" id="error-blood_group"></div>
                        </div>
                        <div class="col-4">
                            <label for="marital_status" class="form-label">Marital Status</label>
                            <select name="marital_status" id="marital_status" class="form-select">
                                <option selected disabled>Select</option>
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="divorced">Divorced</option>
                                <option value="widowed">Widowed</option>
                            </select>
                            <div class="invalid-feedback" id="error-marital_status"></div>
                        </div>
                        <div class="col-4">
                            <label for="photo" class="form-label">Patient Photo</label>
                            <input class="form-control" type="file" name="photo" id="photo" accept="image/*">
                            <small class="form-text text-muted">Drop a file here or click</small>
                            <div class="invalid-feedback" id="error-photo"></div>
                        </div>
                    </div>



                    <div class="row mb-3">
                        <div class="col-2">
                            <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone number">
                            <div class="invalid-feedback" id="error-phone"></div>
                        </div>
                        <div class="col-4">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Email address">
                            <div class="invalid-feedback" id="error-email"></div>
                        </div>
                        <div class="col-6">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" name="address" id="address" rows="2"
                                placeholder="Patient address"></textarea>
                            <div class="invalid-feedback" id="error-address"></div>
                        </div>
                    </div>




                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" name="remarks" id="remarks" rows="2"
                                placeholder="Remarks"></textarea>
                            <div class="invalid-feedback" id="error-remarks"></div>
                        </div>
                        <div class="col-6">
                            <label for="allergies" class="form-label">Any Known Allergies</label>
                            <textarea class="form-control" name="allergies" id="allergies" rows="2"
                                placeholder="Known allergies"></textarea>
                            <div class="invalid-feedback" id="error-allergies"></div>
                        </div>
                    </div>



                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="tpa" class="form-label">TPA</label>
                            <select name="tpa" id="tpa" class="form-select">
                                <option selected disabled>Select</option>
                                @foreach ($tpas as $tpa)
                                <option value="{{$tpa->id}}">{{$tpa->name}}</option>
                                @endforeach


                            </select>
                            <div class="invalid-feedback" id="error-tpa"></div>
                        </div>
                        <div class="col-4">
                            <label for="tpaId" class="form-label">TPA ID</label>
                            <input type="text" class="form-control" name="tpaId" id="tpaId" placeholder="TPA ID">
                            <div class="invalid-feedback" id="error-tpaId"></div>
                        </div>
                        <div class="col-4">
                            <label for="tpaValidity" class="form-label">TPA Validity</label>
                            <input type="date" class="form-control" name="tpaValidity" id="tpaValidity">
                            <div class="invalid-feedback" id="error-tpaValidity"></div>
                        </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col-6">
                            <label for="document_id" class="form-label">Document Identification Number</label>
                            <input type="text" class="form-control" name="document_id" id="document_id"
                                placeholder="Document ID">
                            <div class="invalid-feedback" id="error-document_id"></div>
                        </div>
                        <div class="col-6">
                            <label for="alternate_phone" class="form-label">Alternate Number</label>
                            <input type="tel" class="form-control" name="alternate_phone" id="alternate_phone"
                                placeholder="Alternate phone number">
                            <div class="invalid-feedback" id="error-alternate_phone"></div>
                        </div>
                        <div>
                            <button type="submit"
                                class="btn btn-primary w-25 float-end mt-4  bg-behance border-0 ">Save</button>

                        </div>

                    </div>

                </form>
            </div>


        </div>

    </div>

</div>
</div>
<!-- Prescription Modal -->
<div class="modal fade" id="prescriptionModal" tabindex="-1" aria-labelledby="prescriptionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-behance text-white">
                <h5 class="modal-title text-light" id="prescriptionModalLabel">Add Prescription for <span
                        id="patientName"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('prescriptions.store') }}" method="POST" id="prescription-form"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="doctor_id" id="doctorId">
                    <input type="hidden" name="patient_id" id="patientId">

                    <div class="row">
                        <div class="col-8">
                            <!-- Header Note -->
                            <div class="mb-3">
                                <label for="headerNote" class="form-label">Header Note</label>
                                <textarea class="form-control" id="headerNote" name="header_note" rows="2"></textarea>
                            </div>

                            <!-- Finding Section -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="findingCategory" class="form-label">Finding Category</label>
                                    <select class="form-select findingCategory" id="findingCategory"
                                        name="finding_category_id">
                                        <option value="" selected>Select</option>
                                        @foreach($findingCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="findingList" class="form-label">Finding List</label>
                                    <select class="form-select finding-name" id="findingList" name="finding_id">
                                        <option value="" selected>Select</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="findingDescription" class="form-label">Finding Description</label>
                                <textarea class="form-control" id="findingDescription" name="finding_description"
                                    rows="2">{{ old('finding_description') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="findingPrint" class="form-label">Finding Print</label>
                                <input type="text" class="form-control" id="findingPrint" name="finding_print"
                                    placeholder="Print Note" value="{{ old('finding_print') }}">
                            </div>

                            <!-- Medicine Section -->
                            <div id="medicine-container">
                                <!-- Medicine rows will be added here dynamically -->
                            </div>

                            <button type="button" class="btn btn-primary mb-3" id="add-medicine">
                                <i class="fa fa-plus"></i> Add Medicine
                            </button>

                            <!-- Attachment -->
                            <div class="mb-3">
                                <label for="attachment" class="form-label">Attachment</label>
                                <input class="form-control" type="file" id="attachment" name="attachment">
                                <small class="form-text text-muted">Max file size: 2MB</small>
                            </div>

                            <!-- Footer Note -->
                            <div class="mb-3">
                                <label for="footerNote" class="form-label">Footer Note</label>
                                <textarea class="form-control" id="footerNote" name="footer_note"
                                    rows="2">{{ old('footer_note') }}</textarea>
                            </div>
                        </div>
                        <div class="col-4">
                            <!-- Pathology -->
                            <div class="mb-3">
                                <label for="pathology" class="form-label">Pathology</label>
                                <select class="form-select" id="pathology" name="pathology_id">
                                    <option value="" selected disabled>Select Pathology</option>
                                    @foreach($pathologies as $pathology)
                                    <option value="{{ $pathology->id }}">{{ $pathology->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Radiology -->
                            <div class="mb-3">
                                <label for="radiology" class="form-label">Radiology</label>
                                <select class="form-select" id="radiology" name="radiology_id">
                                    <option value="" selected disabled>Select Radiology</option>
                                    @foreach($radiologies as $radiology)
                                    <option value="{{ $radiology->id }}">{{ $radiology->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Notification To -->
                            <div class="mb-3">
                                <label class="form-label">Notification To</label>
                                <div class="row">
                                    @foreach($roles as $role)
                                    <div class="col-12 my-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                id="notification_{{ $role->id }}" name="notifications[]"
                                                value="{{ $role->id }}">
                                            <label class="form-check-label" for="notification_{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i> Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save Prescription
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace('headerNote');
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('patientForm');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        clearErrors();

        const formData = new FormData(form);

        fetch('patients', {
            method: 'POST',
            headers: {
            
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(async response => {
            if (!response.ok) {
                const data = await response.json();
                if (data.errors) {
                    showErrors(data.errors);
                }
                throw new Error('Validation failed');
            }
            return response.json();
        })
        .then(data => {
       if (data.status === 'success') {
    show_toastr('success', 'Patient added successfully');
    form.reset();
    clearErrors();
    bootstrap.Modal.getInstance(document.getElementById('smallModal')).hide();
    bootstrap.Modal.getInstance(document.getElementById('fullScreenModal')).show();

    fetch('/get-patients')
        .then(response => response.json())
        .then(patients => {
            const select = document.querySelector('select.form-select');
            select.innerHTML = '<option selected disabled>Select patient </option>';

            patients.forEach(patient => {
                const option = document.createElement('option');
                option.value = patient.id;
                option.textContent = patient.name;
                if (parseInt(patient.id) === parseInt(data.new_patient_id)) {
                    option.selected = true;
                }

                select.appendChild(option);
            });
        })
        .catch(err => console.error('Error fetching patients:', err));
}


        })
        
.catch(error => {
    // Clear previous errors
    document.querySelectorAll('.text-danger').forEach(el => el.textContent = '');

    // Display validation errors
    if (error.errors) {
        Object.keys(error.errors).forEach(field => {
            const errorDiv = document.getElementById(`error-${field}`);
            if (errorDiv) {
                errorDiv.textContent = error.errors[field][0];
            }
        });
    } else {
        console.error('Unknown error:', error);
    }
});

    });

    function clearErrors() {
      
        const errorElements = document.querySelectorAll('.invalid-feedback');
        errorElements.forEach(el => {
            el.textContent = '';
        });
       
        const inputs = form.querySelectorAll('.form-control, .form-select');
        inputs.forEach(input => {
            input.classList.remove('is-invalid');
        });
    }

    function showErrors(errors) {
        for (const [key, messages] of Object.entries(errors)) {
          
            const errorElement = document.getElementById('error-' + key);
            const inputElement = form.querySelector(`[name="${key}"]`);
            if (errorElement) {
                errorElement.textContent = messages[0];
                if (inputElement) {
                    inputElement.classList.add('is-invalid');
                }
            }
        }
    }
});

</script>

<script>
    document.getElementById('date_of_birth').addEventListener('change', function () {
    const dob = new Date(this.value);
    const today = new Date();

    let years = today.getFullYear() - dob.getFullYear();
    let months = today.getMonth() - dob.getMonth();
    let days = today.getDate() - dob.getDate();

    if (days < 0) {
        months -= 1;
        days += new Date(today.getFullYear(), today.getMonth(), 0).getDate(); 
    }
    if (months < 0) {
        years -= 1;
        months += 12;
    }

    document.getElementById('ageYear').value = years >= 0 ? years : 0;
    document.getElementById('ageMonth').value = months >= 0 ? months : 0;
    document.getElementById('ageDay').value = days >= 0 ? days : 0;
});

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('appointmentForm');

    const getValue = (id) => {
      const el = document.getElementById(id);
      if (!el) return '';
      if (el.type === 'checkbox') return el.checked;
      return el.value;
    };

    const getMultiValues = (name) => {
      return Array.from(document.querySelectorAll(`input[name="${name}[]"]:checked`)).map(el => el.value);
    };

    const showErrors = (errors) => {
      // Clear previous errors
      document.querySelectorAll('.text-danger').forEach(el => {
        el.textContent = '';
        el.classList.add('d-none');
      });

      Object.entries(errors).forEach(([field, messages]) => {
        const errorElement = document.querySelector(`.error-${field}`);
        if (errorElement) {
          errorElement.textContent = messages.join(', '); // عرض كل الرسائل
          errorElement.classList.remove('d-none');
        }
      });

      // Optional: scroll to first error
      const firstError = document.querySelector('.text-danger:not(.d-none)');
      if (firstError) firstError.scrollIntoView({ behavior: 'smooth' });
    };

    const clearForm = () => {
      form.reset();
      document.querySelectorAll('.text-danger').forEach(el => {
        el.textContent = '';
        el.classList.add('d-none');
      });
    };

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      const data = {
        symptoms_type_array: getValue('symptoms_type_array'),
        symptoms_title_array: getValue('symptoms_title_array'),
        symptoms_description: getValue('symptoms_description'),
        note: getValue('note'),
        allergies: getValue('allergies'),
        previous_medical_issues: getValue('previous_medical_issues'),
        appointment_date: getValue('appointment_date'),
        case: getValue('case'),
        casualty: getValue('casualty'),
        old_patient: getValue('old_patient'),
        reference: getValue('reference'),
        consultant_doctor_id: getValue('hiddenConsultantDoctor'),
        apply_tpa: getValue('apply_tpa'),
        charge_category_id: getValue('hiddenChargeCategory'),
        payment_method: getValue('payment_method'),
        paidAmount: getValue('paidAmount'),
        live_consultation: getValue('live_consultation'),
        patient_id: getValue('patient_id'),
        charges: Array.from(document.querySelectorAll('#chargesTable tbody tr')).map(row => ({
            charge_id: row.dataset.id,
            appliedCharge: row.querySelector('.applied-charge').value,
            discount: row.querySelector('.discount').value,
            tax: row.querySelector('.tax').value
        })),
        
      };

      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      fetch('/appointments/store', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
      })
        .then(response => {
          if (!response.ok) {
            return response.json().then(err => { throw err; });
          }
          return response.json();
        })
        .then(response => {
         show_toastr('success', 'Appointment added successfully');
         clearForm();
         bootstrap.Modal.getInstance(document.getElementById('fullScreenModal')).hide();
         window.location.reload();
        })
        .catch(error => {
          if (error.errors) {
            showErrors(error.errors);
          } else {
            alert('An error occurred while processing your request. Please try again later.');
            console.error('Unknown error:', error);
          }
        });
    });
  });
</script>

@push('script-page')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
    $(document).ready(function() {
    let medicineRowCount = 0;
    
    // When view prescription button is clicked
    $('[data-bs-target="#prescriptionModal"]').click(function() {
        const row = $(this).closest('tr');
        const appointmentId = row.find('a[href*="opd/"]').attr('href').split('/').pop();
        const patientName = row.find('td:nth-child(2)').text();
        const patientId = "{{ $appointment->patient->id ?? '' }}"; // You'll need to pass this
        
        // Set the values in the modal
        $('#patientId').val(patientId);
        $('#patientName').text(patientName);
        
        // Clear previous medicine rows and add a fresh one
        $('#medicine-container').empty();
        addMedicineRow();
    });
    
    // Add new medicine row
    function addMedicineRow() {
        const newRow = `
        <div class="medicine-row mb-4">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Medicine Category</label>
                    <select class="form-select medicine-category" name="medicines[${medicineRowCount}][category_id]" required>
                        <option value="" selected>Select</option>
                        @foreach($medicineCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Medicine</label>
                    <select class="form-select medicine-name" name="medicines[${medicineRowCount}][medicine_id]" required>
                        <option value="" selected>Select</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Dose</label>
                    <select class="form-select" name="medicines[${medicineRowCount}][dose_id]" required>
                        <option value="" selected>Select</option>
                        @foreach($doses as $dose)
                            <option value="{{ $dose->id }}">{{ $dose->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Dose Interval</label>
                    <select class="form-select" name="medicines[${medicineRowCount}][dose_interval_id]" required>
                        <option value="" selected>Select</option>
                        @foreach($doseIntervals as $interval)
                            <option value="{{ $interval->id }}">{{ $interval->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Dose Duration</label>
                    <select class="form-select" name="medicines[${medicineRowCount}][dose_duration_id]" required>
                        <option value="" selected>Select</option>
                        @foreach($doseDurations as $duration)
                            <option value="{{ $duration->id }}">{{ $duration->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Instruction</label>
                <textarea class="form-control" name="medicines[${medicineRowCount}][instruction]" rows="2"></textarea>
            </div>
            
            <button type="button" class="btn btn-danger btn-sm remove-medicine" ${medicineRowCount === 0 ? 'style="display: none;"' : ''}>
                <i class="fa fa-trash"></i> Remove
            </button>
        </div>
        `;
        
        $('#medicine-container').append(newRow);
        medicineRowCount++;
    }
    
    // Add medicine button
    $('#add-medicine').click(function() {
        addMedicineRow();
    });
    
    // Remove medicine row
    $(document).on('click', '.remove-medicine', function() {
        if($('.medicine-row').length > 1) {
            $(this).closest('.medicine-row').remove();
            medicineRowCount--;
        }
    });
    
    // Medicine category change - load medicines
    $(document).on('change', '.medicine-category', function() {
        const categoryId = $(this).val();
        const medicineSelect = $(this).closest('.row').find('.medicine-name');
        
        if(categoryId) {
            $.ajax({
                url: '/get-medicines/' + categoryId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    medicineSelect.empty();
                    medicineSelect.append('<option value="">Select</option>');
                    $.each(data, function(key, value) {
                        medicineSelect.append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                },
                error: function() {
                    medicineSelect.empty();
                    medicineSelect.append('<option value="">Error loading medicines</option>');
                }
            });
        } else {
            medicineSelect.empty();
            medicineSelect.append('<option value="">Select</option>');
        }
    });

    $(document).on('change', '.findingCategory', function() {
        const categoryId = $(this).val();
        const medicineSelect = $(this).closest('.row').find('.finding-name');
        
        if(categoryId) {
            $.ajax({
                url: '/get-findings/' + categoryId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    medicineSelect.empty();
                    medicineSelect.append('<option value="">Select</option>');
                    $.each(data, function(key, value) {
                        medicineSelect.append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                },
                error: function() {
                    medicineSelect.empty();
                    medicineSelect.append('<option value="">Error loading findings</option>');
                }
            });
        } else {
            medicineSelect.empty();
            medicineSelect.append('<option value="">Select</option>');
        }
    });
});
</script>
<script>
    // Update this part of your script
$(document).on('click', '.view-prescription', function() {
    const appointmentId = $(this).data('appointment-id');
    const patientId = $(this).data('patient-id');
    const doctorId = $(this).data('doctor-id');
    const patientName = $(this).data('patient-name');
    
    // Set the values in the modal
    $('#doctorId').val(doctorId);
    $('#patientId').val(patientId);
    $('#patientName').text(patientName);
    
    // Clear previous medicine rows and add a fresh one
    $('#medicine-container').empty();
    medicineRowCount = 0;
    addMedicineRow();
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('symptoms_type');
            const titleSelect = document.getElementById('symptoms_title');
            const descTextarea = document.getElementById('symptoms_description');

            let currentCategories = [];

            const typeChoices = new Choices(typeSelect, {
                searchEnabled: true,
                removeItemButton: true
            });

            const titleChoices = new Choices(titleSelect, {
                searchEnabled: true,
                removeItemButton: true
            });
           
        typeSelect.addEventListener('change', function () {
            const selectedTypes = typeChoices.getValue(true); 

            document.getElementById('symptoms_type_array').value = selectedTypes.join(',');

            titleChoices.clearChoices();
            titleChoices.setChoices(
                [{ value: '', label: 'Select', disabled: true }],
                'value',
                'label',
                true
            );

            currentCategories = [];

            selectedTypes.forEach(typeId => {
                fetch(`/get-symptom-categories/${typeId}`)
                    .then(response => response.json())
                    .then(data => {
                        currentCategories = [...currentCategories, ...data];

                        data.forEach(function (item) {
                            titleChoices.setChoices([{ value: item.id, label: item.title }], 'value', 'label', false);
                        });
                    });
            });

            descTextarea.value = ''; // clear description
        });


            titleSelect.addEventListener('change', function (event) {
             const selectedOptions = titleChoices.getValue(true);
    let descriptions = [];

    const cleaned = selectedOptions.filter(val => val !== ''); 

    document.getElementById('symptoms_title_array').value = cleaned.join(',');

                selectedOptions.forEach(id => {
                    const category = currentCategories.find(cat => parseInt(cat.id) === parseInt(id));
                    if (category && category.description) {
                        descriptions.push(category.description);
                    }
                });

                descTextarea.value = descriptions.join('\n\n');
            });
        });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const consultantDoctorSelect = document.getElementById('consultantDoctor');
        const hiddenInput = document.getElementById('hiddenConsultantDoctor');

        if (consultantDoctorSelect) {
            new Choices(consultantDoctorSelect, {
                searchEnabled: true,
                itemSelectText: '',
                placeholderValue: 'Select',
                shouldSort: false
            });

            consultantDoctorSelect.addEventListener('change', function () {
                hiddenInput.value = this.value;
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Apply Choices.js
        const chargeCategoryChoices = new Choices('#chargeCategory', { searchEnabled: true ,  allowHTML: true});
        let chargeChoices = new Choices('#charge', { searchEnabled: true });

        document.getElementById('chargeCategory').addEventListener('change', function () {
            const categoryId = this.value;
    document.getElementById('hiddenChargeCategory').value = categoryId;

            // Reset the Charge select
            chargeChoices.clearStore();
            chargeChoices.setChoices([{
                value: '',
                label: 'Loading...',
                disabled: false,
                selected: true
            }], 'value', 'label', false);

            fetch(`/get-charges-by-category/${categoryId}`)
                .then(res => res.json())
                .then(data => {
                    const choicesArray = data.map(charge => ({
                        value: charge.id,
                        label: charge.charge_name
                    }));

                    chargeChoices.clearStore();
                    chargeChoices.setChoices(choicesArray, 'value', 'label', true);
                        })
                .catch(err => {
                    chargeChoices.clearStore();
                    chargeChoices.setChoices([{
                        value: '',
                        label: 'Error loading charges',
                        disabled: true
                    }], 'value', 'label', true);
                });
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        const chargeSelect = document.getElementById('charge');
        const tableBody = document.querySelector('#chargesTable tbody');

        chargeSelect.addEventListener('change', async function () {
            tableBody.innerHTML = '';
            const ids = Array.from(this.selectedOptions).map(opt => opt.value);
            for (const id of ids) {
                const res = await fetch(`/get-charge-details/${id}`);
                const data = await res.json();
                const row = document.createElement('tr');
                row.dataset.id = id;
                row.innerHTML = `
                    <td>${data.charge_name}</td>
                    <td><input type="number" class="form-control standard-charge" value="${data.standard_charge}" readonly></td>
                    <td><input type="number" class="form-control applied-charge" value="${data.standard_charge}"></td>
                    <td><input type="number" class="form-control discount" value="0"></td>
                    <td><input type="number" class="form-control tax" value="${data.tax_percentage}" readonly></td>
                    <td><input type="number" class="form-control amount" value="${data.standard_charge}" readonly></td>
                    <td><button type="button" class="btn btn-sm btn-danger remove-charge">X</button></td>`;
                tableBody.appendChild(row);
                attachCalc(row);
            }
            updateTotal();
        });

        document.querySelector('#chargesTable').addEventListener('click', function(e){
            if(e.target.classList.contains('remove-charge')){
                e.target.closest('tr').remove();
                updateTotal();
            }
        });

        function attachCalc(row){
            const applied = row.querySelector('.applied-charge');
            const discount = row.querySelector('.discount');
            const tax = row.querySelector('.tax');
            const amount = row.querySelector('.amount');

            function calc(){
                const a = parseFloat(applied.value) || 0;
                const d = parseFloat(discount.value) || 0;
                const t = parseFloat(tax.value) || 0;
                const sub = a - (a * d / 100);
                const total = sub + (sub * t / 100);
                amount.value = total.toFixed(2);
                updateTotal();
            }

            applied.addEventListener('input', calc);
            discount.addEventListener('input', calc);
        }

        function updateTotal(){
            let total = 0;
            document.querySelectorAll('#chargesTable tbody .amount').forEach(el => {
                total += parseFloat(el.value) || 0;
            });
            document.getElementById('paidAmount').value = total.toFixed(2);
        }
    });
</script>

<script>
    document.getElementById('patient_id').addEventListener('change', function() {
    let patientId = this.value;
    if (!patientId) {
        document.getElementById('patientDetails').style.display = 'none';
        return;
    }

    fetch(`/patients/${patientId}/details`)
      .then(response => response.json())
      .then(data => {
        document.getElementById('patientName').textContent = data.patient.name;
        document.getElementById('patient_code').innerHTML = ' ('+ data.patient.patient_code + ')';
      
        document.getElementById('patientGuardian').textContent = data.patient.guardian_name;
        document.getElementById('patientGender').textContent = data.patient.gender;
         const age = calculateAge(data.patient.date_of_birth);
        document.getElementById('patientAge').textContent = age.years + " Year " + age.months + " Month " + age.days + " Day";
        document.getElementById('patientBlood').textContent = data.patient.blood_group;
        document.getElementById('patientMarital').textContent = data.patient.marital_status;
        document.getElementById('patientPhone').textContent = data.patient.phone;
        document.getElementById('patientEmail').textContent = data.patient.email;
        document.getElementById('patientAddress').textContent = data.patient.address;
        document.getElementById('patientRemarks').textContent = data.patient.remarks;
        document.getElementById('patientAllergies').textContent = data.patient.allergies;
        document.getElementById('patientTPA').textContent = data.patient.tpa;
        document.getElementById('patientTPAID').textContent = data.patient.tpa_id;
        document.getElementById('patientTPAValidity').textContent = data.patient.tpa_validity;
        document.getElementById('patientNationalId').textContent = data.patient.document_id;
        document.getElementById('patientAltPhone').textContent = data.patient.alternate_phone;
        document.getElementById('qrImage').innerHTML = '<img src="' + data.qr_code + '">';
        document.getElementById('barcode').innerHTML = '<img src="' + data.barcode + '">';
        document.getElementById('patientImg').innerHTML = '<img style="width:150px" src="' + (data.patient.photo || '/assets/images/no_image.png') + '" alt="Patient Photo">';

        document.getElementById('patientDetails').style.display = 'block';
      })
      .catch(error => {
        console.error('Error fetching patient data:', error);
        document.getElementById('patientDetails').style.display = 'none';
      });
});

function calculateAge(dobString) {
    const dob = new Date(dobString);
    const today = new Date();

    let years = today.getFullYear() - dob.getFullYear();
    let months = today.getMonth() - dob.getMonth();
    let days = today.getDate() - dob.getDate();

    if (days < 0) {
        months--;
        days += new Date(today.getFullYear(), today.getMonth(), 0).getDate(); 
    }

    if (months < 0) {
        years--;
        months += 12;
    }

    return { years, months, days };
}
</script>
<script>
    function showInvoice(appointmentId) {
        const invoiceContent = document.getElementById('invoice-content');
        invoiceContent.innerHTML = '<p class="text-center">Loading...</p>';

        fetch(`/appointments/${appointmentId}/invoice`) 
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network error');
                }
                  return response.json();
            })
            .then(data => {
                  console.log(data);
                if (data.error) {
                    invoiceContent.innerHTML = `<p class="text-danger">${data.error}</p>`;
                    return;
                }
                    const invoice = data.data; 

                invoiceContent.innerHTML = `
                <div class="mt-4 mb-4 py-3 px-3 border rounded bg-light">
                    <h5 class="mb-3">Patient Details:</h5>
                    <div class="row">
                          <div class="col-md-4 mb-2"><strong>OPD ID :</strong> <span>${invoice.opd}</span></div>
                            <div class="col-md-4 mb-2"><strong>OPD Date :</strong> <span>${invoice.opdDate}</span></div>
                        <div class="col-md-4 mb-2"><strong>Name:</strong> <span>${invoice.patient.name}</span></div>
                        <div class="col-md-4 mb-2"><strong>Guardian:</strong> <span
                              >${invoice.patient.guardian}</span></div>
                        <div class="col-md-4 mb-2"><strong>Gender:</strong> <span>${invoice.patient.gender}</span></div>

                        <div class="col-md-4 mb-2"><strong>Date of Birth:</strong> <span
                                id="patientDOB">${invoice.patient.dob}</span></div>
                        <div class="col-md-4 mb-2"><strong>Age:</strong> <span
                                id="patientAge">${invoice.patient.age}</span></div>
                        <div class="col-md-4 mb-2"><strong>Blood Group:</strong> <span
                                id="patientBlood">${invoice.patient.blood_group}</span></div>

                        <div class="col-md-4 mb-2"><strong>Marital Status:</strong> <span
                                id="patientMarital">${invoice.patient.marital_status}</span></div>
                        <div class="col-md-4 mb-2"><strong>Phone:</strong> <span
                                id="patientPhone">${invoice.patient.phone}</span></div>
                        <div class="col-md-4 mb-2"><strong>Email:</strong> <span
                                id="patientEmail">${invoice.patient.email}</span></div>

                        <div class="col-md-4 mb-2"><strong>Address:</strong> <span
                                id="patientAddress">${invoice.patient.address}</span></div>
                        <div class="col-md-4 mb-2"><strong>Remarks:</strong> <span
                                id="patientRemarks">${invoice.patient.remarks}</span></div>
                        <div class="col-md-4 mb-2"><strong>Allergies:</strong> <span
                                id="patientAllergies">${invoice.patient.allergies}</span></div>

                        <div class="col-md-4 mb-2"><strong>TPA:</strong> <span
                                id="patientTPA">${invoice.patient.tpa}</span></div>
                        <div class="col-md-4 mb-2"><strong>TPA ID:</strong> <span
                                id="patientTPAID">${invoice.patient.tpa_id}</span></div>
                        <div class="col-md-4 mb-2"><strong>TPA Validity:</strong> <span
                                id="patientTPAValidity">${invoice.patient.tpa_validity}</span></div>

                        <div class="col-md-4 mb-2"><strong>Document ID:</strong> <span
                                id="patientNationalId">${invoice.patient.document_id}</span></div>
                        <div class="col-md-4 mb-2"><strong>Alternate Phone:</strong> <span
                                id="patientAltPhone">${invoice.patient.alt_phone}</span></div>
                    </div>
                </div>
                    <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Tax (%)</th>
                        <th>Amount (SAR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${invoice.charges.map((c, index) => `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${c.description}</td>
                                <td>${c.tax} ( % ${c.tax_percent} ) </td>
                                <td>${c.total}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                    </table>
                    <div class="float-end">
                        <p><strong class="fw-bolder">Total:</strong> SAR ${invoice.paidAmount}</p>
                        <p><strong class="fw-bolder">Paid:</strong> SAR ${invoice.paidAmount}</p>
                    </div>
                `;

                const modalEl = document.getElementById('invoiceModal');
                const invoiceModal = new bootstrap.Modal(modalEl);
                invoiceModal.show();
                })
    }
</script>
<script>
    function printInvoice() {
    const content = document.getElementById('invoice-content').innerHTML;

    const printWindow = window.open('', '', 'width=900,height=700');
    printWindow.document.write(`
      <html>
        <head>
          <title>Print Invoice</title>
          <!-- Bootstrap 5 CSS -->
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
          <style>
            body {
              padding: 20px;
              font-family: 'Arial', sans-serif;
            }
          </style>
        </head>
        <body>
          ${content}
        </body>
      </html>
    `);
    printWindow.document.close();

    // نطبع بعد تحميل الصفحة
    printWindow.onload = function () {
      printWindow.focus();
      printWindow.print();
      printWindow.close();
    };
  }
</script>


@endpush



@endsection