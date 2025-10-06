@extends('layouts.admin')

@section('content')

<style>
    .custom-tab {
        border: none;
        background: none;
        color: black;
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
        color: #0056b3;
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
</style>


<div class="container p-3 bg-white shadow">
    <ul class="nav border-0" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="custom-tab active" id="overView-tab" data-bs-toggle="tab" href="#overView" role="tab"
                aria-controls="overView" aria-selected="true">
                <i class="fa fa-th me-1"></i> Overview
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="custom-tab" id="visits-tab" data-bs-toggle="tab" href="#visits" role="tab" aria-controls="visits"
                aria-selected="false">
                <i class="far fa-caret-square-down me-1"></i> Visits
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="custom-tab" id="lab_investigation-tab" data-bs-toggle="tab" href="#lab_investigation" role="tab"
                aria-controls="lab_investigation" aria-selected="false">
                <i class="fas fa-diagnoses me-1"></i> Lab Investigation
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="custom-tab" id="radio_investigation-tab" data-bs-toggle="tab" href="#radio_investigation"
                role="tab" aria-controls="radio_investigation" aria-selected="false">
                <i class="fas fa-diagnoses me-1"></i> Radiology Investigation
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="custom-tab" id="finding_investigation-tab" data-bs-toggle="tab" href="#finding_investigation"
                role="tab" aria-controls="finding_investigation" aria-selected="false">
                <i class="fas fa-diagnoses me-1"></i> Finding Investgation
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="custom-tab" id="medicine_history-tab" data-bs-toggle="tab" href="#medicine_history" role="tab"
                aria-controls="medicine_history" aria-selected="false">
                <i class="fas fa-diagnoses me-1"></i> Medicine History
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="custom-tab" id="timeline-tab" data-bs-toggle="tab" href="#timeline" role="tab"
                aria-controls="timeline" aria-selected="false">
                <i class="far fa-calendar-check me-1"></i> Timeline
            </a>
        </li>
    </ul>


    <div class="tab-content pt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="overView" role="tabpanel" aria-labelledby="overView-tab">
            <div class="row my-3">
                <div class="col-5">
                    <h4>{{$patient->name}} ({{$patient->patient_code}})</h4>
                    <hr>
                    <div class="card shadow-sm p-4 mb-4">
                        <div class="row">
                            <div class="col-5">
                                <img src="{{$patient->photo ?? asset('assets/images/no_image.png')}}" width="150px" alt="">
                            </div>

                            <div class="col-6 g-3">
                                <div class="col-md-12 my-4"><strong class="me-3">Gender</strong> <span class="float-end">{{$patient->gender}}</span></div>
                                <div class="col-md-12 my-4"><strong class="me-3">Age</strong><span class="float-end">{{ $patient->date_of_birth ?
                                    \Carbon\Carbon::parse($patient->date_of_birth)->age . ' years' : 'N/A' }}</span></div>
                                <div class="col-md-12 my-4"><strong class="me-3">Guardian Name</strong> <span class="float-end">{{$patient->guardian_name??'—'}}</span>
                                </div>


                                <div class="col-md-12 my-4"><strong class="me-3">Phone</strong> <span class="float-end">{{$patient->phone}}</span></div>
                                 <div class="col-md-12 my-4"><strong class="me-3">Barcode</strong><span class="float-end"><img src="{{$barcode}}" alt=""></span></div>
                                <div class="col-md-12 my-4"><strong class="me-3">QR Code	</strong><span class="float-end"><img src="{{$qr_code}}" alt=""></span></div>
                                {{-- <div class="col-md-4"><strong>TPA:</strong> — </div>
                                <div class="col-md-4"><strong>TPA ID:</strong> —</div>

                                <div class="col-md-4"><strong>TPA Validity:</strong> —</div>
                                <div class="col-md-4"><strong>Barcode:</strong> <span
                                        class="badge bg-secondary">Generated</span></div>
                                <div class="col-md-4"><strong>QR Code:</strong> <span
                                        class="badge bg-secondary">Available</span></div> --}}
                            </div>
                        </div>
                        <hr>

                        <div class="mb-3">
                            <strong>Known Allergies:</strong><br>
                            @if (empty($appointment->known_allergies))
                            <span class="text-muted fst-italic">No known allergies specified.</span>
                            @else
                            <span class="text-muted fst-italic">{{$appointment->known_allergies}}</span>

                            @endif

                        </div>

                        <div class="mb-3">
                            <strong>Findings:</strong>
                            <p class="text-muted">
                                -
                        </div>

                        <div class="mb-2">
                            <strong>Symptoms:</strong><br>
                            @if (empty($appointment->symptoms_description))
                            <span class="text-muted">—</span>
                            @else
                            <span class="text-muted fst-italic">{{$appointment->symptoms_description}}</span>

                            @endif

                        </div>

                        <hr>

                        <div class="mb-2">
                            <strong>Consultant Doctor(s):</strong>
                            <ul class="list-unstyled mb-0">
                                <li><i class="fa fa-user-md text-primary me-2"></i>{{$appointment->doctor->user->name}}
                                    ({{$appointment->doctor->doctor_code}})</li>
                            </ul>
                        </div>

                        <hr>
                        <hr>
                        <h4>Timeline</h4>
                        <div id="timelineListCopy" class="table-responsive timelineList mt-4">
                            <div class="alert alert-info">No Record Found</div>
                        </div>

                    </div>

                </div>
                <div class="col-7">
                    <h4>Medical History</h4>
                    <hr>
                    <div id="curve_chart" style="width:100%;height:300px"></div>
                    <div class=" shadow-sm mb-4 mt-4">
                        <div class=" fs-4 mb-3  text-dark fw-bold">Visit Details</div>
                        <div class="table-responsive">


                            <table class="table table-bordered table-striped align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>OPD No</th>

                                        <th>Case ID</th>
                                        <th>Appointment Date</th>
                                        <th>Consultant</th>
                                        <th>Reference</th>
                                        <th style="width: 300px; max-width: 300px; word-break: break-word;">Symptoms
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appointments as $appointment)
                                    <tr>
                                        <td><a href="{{'opd/'.$appointment->id}}"
                                                class="text-linkedin fw-bolder ">OPD{{$appointment->id}}</a></td>

                                        <td>{{$appointment->case}}</td>
                                        <td>{{$appointment->appointment_date}}</td>
                                        <td>{{$appointment->doctor->user->name}}
                                            ({{$appointment->doctor->doctor_code}})
                                        </td>
                                        <td>{{$appointment->reference}}</td>
                                        <td
                                            style="min-width: 300px; word-break: break-word; white-space: normal;font-size: smaller;">
                                            {{$appointment->symptoms_description}}
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>


                    <h4>Lab Investigation</h4>
                    <p>No lab investigation data available yet.</p>

                    <h4>Medicine History</h4>
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>OPD No</th>
                                <th>Case ID</th>
                                <th>Appointment Date</th>
                                <th>Consultant</th>
                                <th>Symptoms</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>OPDN7086</td>
                                <td>7111</td>
                                <td>05/30/2025 04:00 PM</td>
                                <td>Sonia Bush (9002)</td>
                                <td>—</td>
                            </tr>
                            <tr>
                                <td>OPDN7028</td>
                                <td>7052</td>
                                <td>04/30/2025 04:00 PM</td>
                                <td>Sonia Bush (9002)</td>
                                <td>—</td>
                            </tr>
                            <tr>
                                <td>OPDN6969</td>
                                <td>6993</td>
                                <td>03/30/2025 04:00 PM</td>
                                <td>Sonia Bush (9002)</td>
                                <td>—</td>
                            </tr>
                            <tr>
                                <td>OPDN6861</td>
                                <td>6885</td>
                                <td>01/30/2025 04:00 PM</td>
                                <td>Sonia Bush (9002)</td>
                                <td>—</td>
                            </tr>
                            <tr>
                                <td>OPDN6803</td>
                                <td>6827</td>
                                <td>12/30/2024 04:00 PM</td>
                                <td>Sonia Bush (9002)</td>
                                <td>—</td>
                            </tr>
                        </tbody>
                    </table>


                </div>
            </div>

        </div>
        <div class="tab-pane fade" id="visits" role="tabpanel" aria-labelledby="visits-tab">
            <hr>
            <div class="row my-3">
                <div class="col-6">
                    <h4> Visits</h4>
                </div>
            </div>
            <hr>
            <div class="row py-3">
                <div class="col-6"> <input type="text" class="form-control custom-search w-50" placeholder="Search...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>OPD No</th>

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
                            <td>{{$appointment->case}}</td>
                            <td>{{$appointment->appointment_date}}</td>
                            <td>{{$appointment->doctor->user->name}} ({{$appointment->doctor->doctor_code}})</td>
                            <td>{{$appointment->reference}}</td>
                            <td
                                style="min-width: 300px; word-break: break-word; white-space: normal;font-size: smaller;">
                                {{$appointment->symptoms_description}}
                            </td>
                            <td>{{$appointment->previous_medical_issues}}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-light" title="Print Bill"><i
                                        class="fa fa-print"></i></a>
                                <a href="#" class="btn btn-sm btn-light" title="View Prescription"
                                    data-bs-toggle="modal" data-bs-target="#prescriptionModal"><i
                                        class="fas fa-file-prescription"></i></a>
                                <a href="#" class="btn btn-sm btn-light" title="Manual Prescription"><i
                                        class="fa fa-file"></i></a>
                                <a href="#" class="btn btn-sm btn-light" title="Show"><i class="fa fa-bars"></i></a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $appointments->links() }}
            </div>
        </div>
        <div class="tab-pane fade" id="lab_investigation" role="tabpanel" aria-labelledby="lab_investigation-tab">
            <hr>
            <div class="row my-3">
                <div class="col-6">
                    <h4>Lab Investigation</h4>
                </div>
            </div>
            <hr>


            <div class="row py-3">
                <div class="col-6"> <input type="text" class="form-control custom-search w-50" placeholder="Search...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Test Name</th>
                            <th>Case ID</th>
                            <th>Lab</th>
                            <th>Sample Collected</th>
                            <th>Expected Date</th>
                            <th>Approved By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">

                    </tbody>
                </table>
                <div class="text-center">
                    <p>
                        No data available in table
                    </p>
                    <img src="https://smart-hospital.in/shappresource/images/addnewitem.svg" alt="">

                    <p class="text-success fw-bold mt-2">
                        <- Add new record or search with different criteria.</p>
                </div>

            </div>

        </div>

        <div class="tab-pane fade" id="radio_investigation" role="tabpanel" aria-labelledby="radio_investigation-tab">
            <hr>
            <div class="row my-3">
                <div class="col-6">
                    <h4>Radiology Investigation</h4>
                </div>
            </div>
            <hr>


            <div class="row py-3">
                <div class="col-6"> <input type="text" class="form-control custom-search w-50" placeholder="Search...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Test Name</th>
                            <th>Case ID</th>
                            <th>Lab</th>
                            <th>Sample Collected</th>
                            <th>Expected Date</th>
                            <th>Approved By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">

                    </tbody>
                </table>
                <div class="text-center">
                    <p>
                        No data available in table
                    </p>
                    <img src="https://smart-hospital.in/shappresource/images/addnewitem.svg" alt="">

                    <p class="text-success fw-bold mt-2">
                        <- Add new record or search with different criteria.</p>
                </div>

            </div>

        </div>


        <div class="tab-pane fade" id="finding_investigation" role="tabpanel"
            aria-labelledby="finding_investigation-tab">
            <hr>
            <div class="row my-3">
                <div class="col-6">
                    <h4>Finding Investigation</h4>
                </div>
            </div>
            <hr>


            <div class="row py-3">
                <div class="col-6"> <input type="text" class="form-control custom-search w-50" placeholder="Search...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Test Name</th>
                            <th>Case ID</th>
                            <th>Lab</th>
                            <th>Sample Collected</th>
                            <th>Expected Date</th>
                            <th>Approved By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">

                    </tbody>
                </table>
                <div class="text-center">
                    <p>
                        No data available in table
                    </p>
                    <img src="https://smart-hospital.in/shappresource/images/addnewitem.svg" alt="">

                    <p class="text-success fw-bold mt-2">
                        <- Add new record or search with different criteria.</p>
                </div>

            </div>

        </div>
        <div class="tab-pane fade" id="medicine_history" role="tabpanel" aria-labelledby="medicine_history-tab">

            <hr>
            <div class="row my-3">
                <div class="col-6">
                    <h4>Medicine History</h4>
                </div>
            </div>
            <hr>


            <div class="row py-3">
                <div class="col-6"> <input type="text" class="form-control custom-search w-50" placeholder="Search...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>OPD No</th>
                            <th>Case ID</th>
                            <th>Appointment Date</th>
                            <th>Symptoms</th>
                            <th>Consultant</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @for ($i = 1; $i <= 11; $i++) <tr>
                            <td>OPDN{{ 7000 + $i * 10 + rand(0, 99) }}</td>
                            <td>{{ 7000 + $i }}</td>
                            <td>{{ now()->subMonths($i)->format('m/d/Y') }} {{ rand(8, 16) }}:{{ rand(0,59) < 10 ? '0'
                                    : '' }}{{ rand(0,59) }} {{ rand(0,1) ? 'AM' : 'PM' }}</td>
                            <td>
                                {{ rand(0, 1) ? 'Fever, Cold' : '---' }}
                            </td>
                            <td>
                                {{ ['Sonia Bush (9002)', 'Sansa Gomez (9008)', 'Reyan Jain (9011)', 'Amit Singh
                                (9009)'][$i % 4] }}
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary view-checkup-btn" data-bs-toggle="modal"
                                    data-bs-target="#opdCheckupModal" data-chkid="CHKID70{{ $i }}"
                                    data-opdid="OPDN70{{ $i }}" data-caseid="71{{ $i }}"
                                    data-name="Patient {{ $i }} (84{{ $i }})" data-gender="Male"
                                    data-phone="89355{{ rand(10000,99999) }}" data-email="robin{{ $i }}@gmail.com"
                                    data-date="{{ now()->addDays($i)->format('m/d/Y h:i A') }}"
                                    data-doctor="Sonia Bush (9002)">
                                    <i class="fas fa-bars"></i>
                                </button>
                            </td>
                            </tr>
                            @endfor
                    </tbody>
                </table>
            </div>

        </div>
        <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
            <div id="timelineContainer">

                <div class="row my-3">
                    <div class="col-6">
                        <h4>TimeLine</h4>
                    </div>
                    <div class="col-6"><a href="#" class="btn btn-gradient-info float-end " data-bs-toggle="modal"
                            data-bs-target="#timelineModal">Add Timeline</a></div>
                </div>
                <div id="timelineList" class="timelineList mt-4">
                    <div class="alert alert-info">No Record Found</div>
                </div>

            </div>

        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="timelineModal" tabindex="-1" aria-labelledby="timelineModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="timelineForm" enctype="multipart/form-data" onsubmit="event.preventDefault();">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Timeline</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="patient_id" value="{{$patient->id}}">
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="timelineTitle" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="timelineTitle" name="title">
                        <div class="text-danger error-msg" id="error-title"></div>
                    </div>

                    <!-- Date -->
                    <div class="mb-3">
                        <label for="timelineDate" class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" id="timelineDate" name="date">
                        <div class="text-danger error-msg" id="error-date"></div>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="timelineDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="timelineDescription" name="description" rows="3"></textarea>
                        <div class="text-danger error-msg" id="error-description"></div>
                    </div>

                    <!-- Attach Document -->
                    <div class="mb-3">
                        <label class="form-label">Attach Document</label>
                        <input class="form-control" type="file" name="document">
                        <div class="text-danger error-msg" id="error-document"></div>
                    </div>


                    <!-- Visible to this person -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="visibleToPerson" name="visible_to_patient">
                        <label class="form-check-label" for="visibleToPerson">
                            Visible to this person
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gradient-info">
                        <i class="fas fa-save me-1"></i> Save Timeline
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>




<div class="modal fade" id="opdCheckupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-behance">
                <h5 class="modal-title  text-white"><i class="fas fa-notes-medical me-2"></i>OPD Checkup Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-6"><strong>OPD Checkup ID:</strong> <span id="modal-chkid"></span></div>
                    <div class="col-md-6"><strong>OPD ID:</strong> <span id="modal-opdid"></span></div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6"><strong>Case ID:</strong> <span id="modal-caseid"></span></div>
                    <div class="col-md-6"><strong>Patient Name:</strong> <span id="modal-name"></span></div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6"><strong>Gender:</strong> <span id="modal-gender"></span></div>
                    <div class="col-md-6"><strong>Phone:</strong> <span id="modal-phone"></span></div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6"><strong>Email:</strong> <span id="modal-email"></span></div>
                    <div class="col-md-6"><strong>Appointment Date:</strong> <span id="modal-date"></span></div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12"><strong>Consultant Doctor:</strong> <span id="modal-doctor"></span></div>
                </div>
            </div>


        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.view-checkup-btn');
    buttons.forEach(button => {
      button.addEventListener('click', () => {
        document.getElementById('modal-chkid').textContent = button.dataset.chkid;
        document.getElementById('modal-opdid').textContent = button.dataset.opdid;
        document.getElementById('modal-caseid').textContent = button.dataset.caseid;
        document.getElementById('modal-name').textContent = button.dataset.name;
        document.getElementById('modal-gender').textContent = button.dataset.gender;
        document.getElementById('modal-phone').textContent = button.dataset.phone;
        document.getElementById('modal-email').textContent = button.dataset.email;
        document.getElementById('modal-date').textContent = button.dataset.date;
        document.getElementById('modal-doctor').textContent = button.dataset.doctor;
      });
    });
  });
</script>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

     
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Month',
        @foreach ($datasets as $d)
          '{{ $d["label"] }}'@if (!$loop->last),@endif
        @endforeach
      ],

      @foreach ($labels as $i => $month)
        [
          '{{ $month }}',
          @foreach ($datasets as $d)
            {{ $d['data'][$i] }}@if (!$loop->last),@endif
          @endforeach
        ]@if (!$loop->last),@endif
      @endforeach
    ]);

    var options = {
      title: 'Last year charges',
      curveType: 'function',
      legend: { position: 'bottom' },
       vAxis: {
    minValue: 0 
  }
    };

    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
    chart.draw(data, options);
  }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('timelineForm');
    const modal = document.getElementById('timelineModal');
    const timelineList = document.getElementsByClassName('timelineList');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function clearErrors() {
        document.querySelectorAll('.error-msg').forEach(el => {
            el.innerText = '';
        });
    }
    function displayErrors(errors) {
        for (const field in errors) {
            const errorDiv = document.getElementById(`error-${field}`);
            if (errorDiv) {
                errorDiv.innerText = errors[field][0]; 
            }
        }
    }

    // إرسال الفورم
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        clearErrors(); // امسح الأخطاء قبل الإرسال

        const formData = new FormData(form);

        fetch('{{ route("timelines.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async response => {
            if (!response.ok) {
                const data = await response.json();
                if (data.errors) {
                    displayErrors(data.errors);
                } else {
                    alert('Error: ' + (data.message || 'Something went wrong'));
                }
                throw new Error('Validation failed');
            }
            return response.json();
        })
        .then(data => {
            // إغلاق المودال
            const bootstrapModal = bootstrap.Modal.getInstance(modal);
            bootstrapModal.hide();

            form.reset();

            loadTimelines();
        })
        .catch(error => {
            console.error(error.message);
        });
    });
    function loadTimelines() {
        fetch('{{ route("timelines.index", $patient->id ?? 0) }}')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to load timelines');
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('timelineList').innerHTML = data.html;
                document.getElementById('timelineListCopy').innerHTML = data.html;
            })
            .catch(error => {
                const errorHtml = `<div class="alert alert-danger">${error.message}</div>`;
                document.getElementById('timelineList').innerHTML = errorHtml;
                document.getElementById('timelineListCopy').innerHTML = errorHtml;
            });
    }

    loadTimelines();

});
</script>


@endsection