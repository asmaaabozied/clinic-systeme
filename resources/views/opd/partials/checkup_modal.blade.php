<div class="modal fade" id="checkupModal" tabindex="-1" aria-labelledby="checkupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <form id="checkupForm" onsubmit="event.preventDefault();">
            <input type="hidden" name="appointment_id" id="checkupAppointmentId">
            <div class="modal-content">
                <div class="modal-header bg-behance ">
                    <div class="d-flex align-items-center gap-2">
                        <div>
                            <select class="form-select" name="patient_id" id="patient_id" style="WIDTH: 400PX;" disabled>
                                <option selected disabled>Select patient</option>

                                @foreach ($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ session('patient') && session('patient')->id ==
                                    $patient->id ? 'selected' : '' }}>{{ $patient->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger fw-bolder error-patient_id d-none"></span>
                        </div>
{{--                        <button type="button" class="btn btn-primary btn-light-light text-dark" data-bs-toggle="modal"--}}
{{--                                data-bs-target="#smallModal">--}}
{{--                            New Patient--}}
{{--                        </button>--}}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-5 border-end">
                            <div class="row">
                                <div class="col-12">
                                    <div id="patientDetails" class="mt-4 mb-4 py-3 px-3 border rounded bg-light"
                                         style="display:none;">
                                        <div class="row">
                                            <div class="col-9">
                                                <div class="col-md-12 mb-2">
                                                    <span id="patientName" class="h4"></span>
                                                    <span id='patient_code' class="h4"></span>
                                                </div>
                                                <div class="col-md-12 mb-2"><strong> <i class="fas fa-user-secret"
                                                                                        data-toggle="tooltip"
                                                                                        data-placement="top" title=""
                                                                                        data-original-title="Guardian"></i>
                                                    </strong>
                                                    <span id="patientGuardian"></span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2"><i class="fas fa-venus-mars"> </i> <span
                                                            id="patientGender"></span></div>
                                                    <div class="col-md-4 mb-2"><i class="fas fa-tint"></i> <span
                                                            id="patientBlood"></span></div>
                                                    <div class="col-md-4 mb-2"><i class="fas fa-ring"></i> <span
                                                            id="patientMarital"></span></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2"><i class="fas fa-hourglass-half"></i> <span
                                                            id="patientAge"></span>
                                                    </div>
                                                    <div class="col-md-6 mb-2"><i class="fa fa-phone-square"></i> <span
                                                            id="patientPhone"></span></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2"><i class="fa fa-envelope"></i> <span
                                                            id="patientEmail"></span></div>

                                                    <div class="col-md-6 mb-2"><i class="fas fa-street-view"></i> <span
                                                            id="patientAddress"></span></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-4"><span id="barcode"></span>
                                                    </div>
                                                    <div class="col-md-6 mb-2"><span id="qrImage"></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2"><strong>Any Known Allergies </strong> <span
                                                            id="patientAllergies"></span></div>
                                                    <div class="col-md-6 mb-2"><strong>Remarks</strong> <span
                                                            id="patientRemarks"></span></div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 mb-2"><strong>TPA</strong> <span
                                                            id="patientTPA"></span>
                                                    </div>
                                                    <div class="col-md-4 mb-2"><strong>TPA ID</strong> <span
                                                            id="patientTPAID"></span>
                                                    </div>
                                                    <div class="col-md-4 mb-2"><strong>TPA Validity</strong> <span
                                                            id="patientTPAValidity"></span></div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-2"><strong>National ID</strong> <span
                                                            id="patientNationalId"></span></div>
                                                    <div class="col-md-6 mb-2"><strong>Alternate Phone</strong> <span
                                                            id="patientAltPhone"></span></div>
                                                </div>

                                            </div>
                                            <div class="col-3">
                                                <div class="float-end" id="patientImg">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
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
                                <div class="col-6">
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
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="symptoms_description" class="form-label">Symptoms
                                            Description</label>
                                        <textarea class="form-control" id="symptoms_description" rows="3"></textarea>
                                        <span class="text-danger fw-bolder error-symptoms_description d-none"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- To be in accordion -->
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
                            <!-- End  -->
                        </div>

                        <div class="col-md-7 bg-light">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="checkup_date" class="form-label">Appointment Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="checkup_date"
                                               name="checkup_date" required>
                                        <span class="text-danger fw-bolder error-checkup_date d-none"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="case" class="form-label">Case</label>
                                        <select class="form-select" id="case" name="case">
                                            <option value="" selected>Select</option>
                                            @foreach($specializations as $specialization)
                                                <option value="{{ $specialization->name }}">{{ $specialization->name }}</option>
                                            @endforeach
                                        </select>
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

                            <div class="row" id="oldPatientIdContainer" style="display:none;">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="old_patient_id" class="form-label">Old Patient ID</label>
                                        <input type="text" class="form-control" id="old_patient_id" name="old_patient_id">
                                        <span class="text-danger fw-bolder error-old_patient_id d-none"></span>
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
                                                <option value="{{$doctor->id}}" @if($appointment->consultant_doctor_id == $doctor->id) selected @endif>{{$doctor->user->name}}</option>
                                            @endforeach

                                        </select>
                                        <input type="hidden" name="consultant_doctor_id" id="hiddenConsultantDoctor">
                                        <span class="text-danger fw-bolder error-consultant_doctor_id d-none"></span>
                                    </div>
                                </div>
                            </div>


                            {{--                            <div class="row">--}}
                            {{--                                <div class="col-6">--}}
                            {{--                                    <div class="mb-3">--}}
                            {{--                                        <label class="form-label" for="apply_tpa">Apply TPA</label>--}}
                            {{--                                        <select class="form-select" id="apply_tpa">--}}
                            {{--                                            <option value="0" selected>No</option>--}}
                            {{--                                            <option value="1">Yes</option>--}}
                            {{--                                        </select>--}}
                            {{--                                        <span class="text-danger fw-bolder error-apply_tpa d-none"></span>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}

                            {{--                                <div class="col-6">--}}
                            {{--                                    <div class="mb-3">--}}
                            {{--                                        <label for="chargeCategory" class="form-label">Charge Category</label>--}}
                            {{--                                        <select class="form-select" id="chargeCategory" name="chargeCategory">--}}
                            {{--                                            <option selected disabled>Select</option>--}}
                            {{--                                            @foreach ($chargeCategories as $category)--}}
                            {{--                                                <option value="{{ $category->id }}">{{ $category->name }}</option>--}}
                            {{--                                            @endforeach--}}
                            {{--                                        </select>--}}
                            {{--                                        <input type="hidden" name="charge_category_id" id="hiddenChargeCategory">--}}

                            {{--                                        <span class="text-danger fw-bolder error-charge_category_id d-none"></span>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="charge" class="form-label">Services <span
                                                class="text-danger">*</span></label>
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
                                        <th>  Tax (15%)</th>
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
                        <button type="submit" class="btn btn-secondary bg-behance border-body">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>

                </div>
            </div>
        </form>
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
{{--                    <input type="hidden" name="patient_id" id="patientId">--}}

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

            <script>
                const today = new Date().toISOString().split('T')[0];
                document.getElementById('checkup_date').value = today;

                document.addEventListener('DOMContentLoaded', function () {
                    // Apply Choices.js
                    // const chargeCategoryChoices = new Choices('#chargeCategory', {
                    //     searchEnabled: true,
                    //     allowHTML: true
                    // });
                    let chargeChoices = new Choices('#charge', {searchEnabled: true});

                    chargeChoices.clearStore();
                    chargeChoices.setChoices([{
                        value: '',
                        label: 'Loading...',
                        disabled: false,
                        selected: true
                    }], 'value', 'label', false);

                    fetch(`/get-all-charges`)
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

                    // document.getElementById('chargeCategory').addEventListener('change', function () {
                    //     const categoryId = this.value;
                    //     document.getElementById('hiddenChargeCategory').value = categoryId;
                    //
                    //     // Reset the Charge select
                    //     chargeChoices.clearStore();
                    //     chargeChoices.setChoices([{
                    //         value: '',
                    //         label: 'Loading...',
                    //         disabled: false,
                    //         selected: true
                    //     }], 'value', 'label', false);
                    //
                    //     fetch(`/get-charges-by-category/${categoryId}`)
                    //         .then(res => res.json())
                    //         .then(data => {
                    //             const choicesArray = data.map(charge => ({
                    //                 value: charge.id,
                    //                 label: charge.charge_name
                    //             }));
                    //
                    //             chargeChoices.clearStore();
                    //             chargeChoices.setChoices(choicesArray, 'value', 'label', true);
                    //         })
                    //         .catch(err => {
                    //             chargeChoices.clearStore();
                    //             chargeChoices.setChoices([{
                    //                 value: '',
                    //                 label: 'Error loading charges',
                    //                 disabled: true
                    //             }], 'value', 'label', true);
                    //         });
                    // });
                });
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
                        let taxPercentage = parseFloat(data.tax_percentage) || 15;
                        let taxValue = parseFloat(taxPercentage * data.standard_charge / 100).toFixed(2);
                        let totalAmount = parseFloat(data.standard_charge) + parseFloat(taxValue);

                        row.innerHTML = `
                            <td class="charge-name-cell" title="${data.charge_name}">${data.charge_name}</td>
                            <td><input type="number" class="form-control standard-charge" value="${data.standard_charge}" readonly></td>
                            <td><input type="number" class="form-control applied-charge" value="${data.standard_charge}"></td>
                            <td><input type="number" class="form-control discount" value="0"></td>
                            <td><input type="number" class="form-control tax" value="${taxValue}" readonly></td>
                            <td><input type="number" class="form-control amount" value="${totalAmount}" readonly></td>
                            <td><button type="button" class="btn btn-sm btn-danger remove-charge">X</button></td>`;
                        tableBody.appendChild(row);
                        const nameCell = row.querySelector('.charge-name-cell');
                        if (nameCell) {
                            nameCell.addEventListener('click', () => nameCell.classList.toggle('expanded'));
                        }
                        attachCalc(row);
                    }
                    updateTotal();
                });

                document.querySelector('#chargesTable').addEventListener('click', function (e) {
                    if (e.target.classList.contains('remove-charge')) {
                        e.target.closest('tr').remove();
                        updateTotal();
                    }
                });

                function attachCalc(row) {
                    const applied = row.querySelector('.applied-charge');
                    const discount = row.querySelector('.discount');
                    const tax = row.querySelector('.tax');
                    const amount = row.querySelector('.amount');

                    function calc() {
                        const a = parseFloat(applied.value) || 0;
                        const d = parseFloat(discount.value) || 0;
                        const tax = parseFloat(taxValue.value) || 0;
                        const sub = a - (a * d / 100);
                        const total = sub + tax

                        amount.value = total.toFixed(2);
                        updateTotal();
                    }

                    applied.addEventListener('input', calc);
                    discount.addEventListener('input', calc);
                }

                function updateTotal() {
                    let total = 0;
                    document.querySelectorAll('#chargesTable tbody .amount').forEach(el => {
                        total += parseFloat(el.value) || 0;
                    });
                    document.getElementById('paidAmount').value = total.toFixed(2);
                }
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
                            [{value: '', label: 'Select', disabled: true}],
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
                                        titleChoices.setChoices([{
                                            value: item.id,
                                            label: item.title
                                        }], 'value', 'label', false);
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
                    document.getElementById('ageYear').value = years >= 0 ? years : 0;
                    document.getElementById('ageMonth').value = months >= 0 ? months : 0;
                    document.getElementById('ageDay').value = days >= 0 ? days : 0;
                });

            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const form = document.getElementById('checkupForm');
                    const oldPatientSelect = document.getElementById('old_patient');
                    const oldPatientIdContainer = document.getElementById('oldPatientIdContainer');

                    if (oldPatientSelect) {
                        oldPatientSelect.addEventListener('change', function () {
                            if (this.value === '1') {
                                oldPatientIdContainer.style.display = 'block';
                            } else {
                                oldPatientIdContainer.style.display = 'none';
                                document.getElementById('old_patient_id').value = '';
                            }
                        });
                        oldPatientSelect.dispatchEvent(new Event('change'));
                    }

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
                                errorElement.textContent = messages.join(', ');
                                errorElement.classList.remove('d-none');
                            }
                        });

                        // Optional: scroll to first error
                        const firstError = document.querySelector('.text-danger:not(.d-none)');
                        if (firstError) firstError.scrollIntoView({behavior: 'smooth'});
                    };

                    const clearForm = () => {
                        form.reset();
                        document.querySelectorAll('.text-danger').forEach(el => {
                            el.textContent = '';
                            el.classList.add('d-none');
                        });
                        if (oldPatientIdContainer) {
                            oldPatientIdContainer.style.display = 'none';
                        }
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
                            checkup_date: getValue('checkup_date'),
                            case: getValue('case'),
                            casualty: getValue('casualty'),
                            old_patient: getValue('old_patient'),
                            old_patient_id: getValue('old_patient_id'),
                            reference: getValue('reference'),
                            consultant_doctor_id: getValue('hiddenConsultantDoctor'),
                            apply_tpa: getValue('apply_tpa'),
                            charge_category_id: getValue('hiddenChargeCategory'),
                            charges: Array.from(document.querySelectorAll('#chargesTable tbody tr')).map(row => ({
                                charge_id: row.dataset.id,
                                appliedCharge: row.querySelector('.applied-charge').value,
                                discount: row.querySelector('.discount').value,
                                tax: row.querySelector('.tax').value
                            })),
                            payment_method: getValue('payment_method'),
                            paidAmount: getValue('paidAmount'),
                            live_consultation: getValue('live_consultation'),
                            appointment_id: getValue('checkupAppointmentId'),
                        };

                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        fetch("{{ route('opd.checkup.store') }}", {
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
                                    return response.json().then(err => {
                                        throw err;
                                    });
                                }
                                return response.json();
                            })
                            .then(response => {
                                show_toastr('success', 'Checkup added successfully');
                                clearForm();
                                bootstrap.Modal.getInstance(document.getElementById('checkupModal')).hide();
                                window.location.reload();
                            })
                            .catch(error => {
                                console.error('Error:', error);
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

            <script>
                document.getElementById('patient_id').addEventListener('change', function () {
                    let patientId = this.value;
                    if (!patientId) {
                        document.getElementById('patientDetails').style.display = 'none';
                        return;
                    }

                    fetch(`/patients/${patientId}/details`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('patientName').textContent = data.patient.name;
                            document.getElementById('patient_code').innerHTML = ' (' + data.patient.patient_code + ')';

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

                    return {years, months, days};
                }
            </script>
            <script>
                function openCheckupModal(appointmentId, doctorId, patientId) {
                    const modalEl = document.getElementById('checkupModal');
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    document.getElementById('checkupAppointmentId').value = appointmentId;
                    const doctorSelect = document.getElementById('consultantDoctor');
                    const hiddenDoctor = document.getElementById('hiddenConsultantDoctor');
                    if (doctorSelect) {
                        doctorSelect.value = doctorId;
                    }
                    if (hiddenDoctor) {
                        hiddenDoctor.value = doctorId;
                    }
                    const patientSelect = document.getElementById('patient_id');
                    if (patientSelect && patientId) {
                        patientSelect.value = patientId;
                        patientSelect.dispatchEvent(new Event('change'));
                    }
                    modal.show();
                }
            </script>
