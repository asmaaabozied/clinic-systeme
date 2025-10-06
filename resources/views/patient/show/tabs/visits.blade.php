<div class="tab-content" id="visits">
    <div class="medical-section">
        <div class="stats-grid">
            <div class="card">
                <h3>Total Visits</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #4A90E2;">
                    {{ $visitStats['total_visits'] ?? 0 }}
</div>
</div>

            <div class="card">
                <h3>This Month</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #28a745;">
                    {{ $visitStats['this_month'] ?? 0 }}
                </div>
            </div>
            <div class="card">
                <h3>Last Visit</h3>
                <div style="font-size: 1.2rem; font-weight: bold;">
                    {{ $visitStats['last_visit'] ?? '-' }}
                </div>
            </div>
            <div class="card">
                <h3>Next Appointment</h3>
                <div style="font-size: 1.2rem; font-weight: bold;">
                    {{ $visitStats['next_appointment'] ?? '-' }}
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-title">VISIT HISTORY</div>
            <div class="visit-tabs">
                <div class="visit-tab active" data-tab="past-visits">Past</div>
                <div class="visit-tab" data-tab="today-visits">Today</div>
                <div class="visit-tab" data-tab="upcoming-visits">Upcoming</div>
            </div>

            <div id="past-visits" class="visit-subtab-content active">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
{{--                            <th>Type</th>--}}
                            <th>Note</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pastVisits as $visit)
                            <tr>
                                <td>{{ optional($visit->appointment_date)->format('d/m/Y') }}</td>
{{--                                <td>{{ $visit->charge->charge_name ?? '-' }}</td>--}}
                                <td>{{ $visit->note ?? '-' }}</td>
                                <td><span class="status-badge status-completed">Completed</span></td>
                                @if($visit->consultation)
                                    <td>
                                        <button type="button" class="btn btn-info view-consult-btn" title="View Consultation"
                                                data-consult="{{ $visit->consultation->id ?? '' }}" {{ $visit->consultation ? '' : 'disabled' }}>
                                            <i class="fas fa-eye" style="margin-right: 4px;"></i> View
                                        </button>
                                    </td>
                                @else
                                    <td>
                                        -
                                    </td>
                                @endif

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No past visits found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="today-visits" class="visit-subtab-content">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
{{--                            <th>Type</th>--}}
                            <th>Doctor</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $doctor = auth()->user()->doctor;
                        $specialization = $doctor?->specialization?->name;
                    @endphp
                        @forelse($todayVisits as $visit)
                            <tr>
                                <td>{{ optional($visit->appointment_date)->format('d/m/Y') }}</td>
{{--                                <td>{{ $visit->charge->charge_name ?? '-' }}</td>--}}
                                <td>{{ $visit->doctor->user->name ?? '-' }}</td>
                                <td>{{ $visit->note ?? '-' }}</td>
                                <td><span class="status-badge status-active">Today</span></td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">

                                        @if($specialization === 'dental')
                                            <a href="{{ route('doctor.dental.dashboard',['patient_id' => $patient->id]) }}" class="btn btn-sm btn-primary mb-2" target="_blank">Dental Area</a>
                                            {{--                               <a href="{{ route('doctor.patient.procedure-planning', $patient->id) }}" class="btn btn-sm btn-primary mb-2">Procedure Planning Notes</a>--}}
                                        @elseif($specialization =='dermatology')
                                            <a href="{{ route('doctor.dermatology.index',['patient_id' => $patient->id]) }}" class="btn btn-sm btn-primary mb-2" target="_blank">Dermatology Area</a>
                                        @endif
{{--                                        <button type="button" class="btn btn-sm btn-primary consult-btn" title="Consult"--}}
{{--                                                data-appointment="{{ $visit->id }}" data-patient="{{ $patient->id }}"--}}
{{--                                                data-consult="{{ $visit->consultation->id ?? '' }}">--}}
{{--                                            <i class="fas fa-notes-medical" style="margin-right: 4px;"></i> Consult--}}
{{--                                        </button>--}}
                                        <button type="button" class="btn btn-sm btn-info view-consult-btn" title="View"
                                                data-consult="{{ $visit->consultation->id ?? '' }}" {{ $visit->consultation ? '' : 'disabled' }}>
                                            <i class="fas fa-eye" style="margin-right: 4px;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No visits today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="upcoming-visits" class="visit-subtab-content">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Doctor</th>
                            <th>Department</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upcomingVisits as $visit)
                            <tr>
                                <td>{{ optional($visit->appointment_date)->format('d/m/Y') }}</td>
                                <td>{{ $visit->charge->charge_name ?? '-' }}</td>
                                <td>{{ $visit->doctor->user->name ?? '-' }}</td>
                                <td>-</td>
                                <td>{{ $visit->note ?? '-' }}</td>
                                <td><span class="status-badge status-pending">Scheduled</span></td>
                                <td></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No upcoming visits found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <h3>Schedule New Appointment</h3>
            <form action="{{ route('doctor.patient.visits.store', $patient->id) }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Date</label>
                        <input type="date" name="visit_date" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Time</label>
                        <input type="time" name="visit_time" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Doctor</label>
                        <select name="doctor_id" class="form-input" required>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->user->name ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Visit Type</label>
                        <select name="visit_type_id" class="form-input" required>
                            @foreach($visitTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label">Specialization</label>
                        <select name="case" class="form-input" required>
                            @foreach($specializations  as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label">Diagnosis</label>
                        <input type="text" name="diagnosis" class="form-input">
                    </div>
                </div>
                <button class="btn btn-primary" style="margin-top: 1rem;">Schedule Appointment</button>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="medicalConsultationModal" tabindex="-1" aria-labelledby="medicalConsultationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="medicalConsultationForm">
            <input type="hidden" name="patient_id" id="consult_patient_id">
            <input type="hidden" name="appointment_id" id="consult_appointment_id">
            <input type="hidden" name="consultation_id" id="consult_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medicalConsultationModalLabel">Medical Consultation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h6>Chief Complaint & History</h6>
                        <textarea class="form-control" name="chief_complaint" placeholder="Chief Complaint"></textarea>
                        <textarea class="form-control mt-2" name="history_of_present_illness" placeholder="History of Present Illness"></textarea>
                    </div>
                    <div class="mb-3">
                        <h6>Diagnosis</h6>
                        <input type="text" class="form-control mb-2" name="provisional_diagnosis" placeholder="Provisional Diagnosis">
                        <input type="text" class="form-control" name="final_diagnosis" placeholder="Final Diagnosis">
                    </div>
                    <div class="mb-3">
                        <h6>Services</h6>
                        <select class="form-select" id="consult_charge" multiple></select>
                        <span class="text-danger fw-bolder error-charge_id d-none"></span>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered align-middle" id="consultChargesTable">
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
                                    <td><input type="number" class="form-control" id="consultPaidAmount" readonly></td>
                                    <td></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="mb-3">
                            @php
                                $doctor = auth()->user()->doctor;
                                $specialization = $doctor?->specialization?->name;
                            @endphp
                            @if($specialization === 'dental')
                                <a href="{{ route('doctor.dental.dashboard',['patient_id' => $patient->id]) }}" class="btn btn-sm btn-primary mb-2" target="_blank">Dental Area</a>
{{--                               <a href="{{ route('doctor.patient.procedure-planning', $patient->id) }}" class="btn btn-sm btn-primary mb-2">Procedure Planning Notes</a>--}}
                        @elseif($specialization =='dermatology')
                            <a href="{{ route('doctor.dermatology.index',['patient_id' => $patient->id]) }}" class="btn btn-sm btn-primary mb-2" target="_blank">Dermatology Area</a>

                           @endif
                        <h6>Follow-up & Advice</h6>
                        <textarea class="form-control" name="post_consultation_advice" placeholder="Post-consultation advice"></textarea>
                        <input type="date" class="form-control mt-2" name="next_appointment">
                        <select class="form-control mt-2" name="follow_up_type">
                            <option>Follow-up Type</option>
                            <option>Routine Check-up</option>
                            <option>Post-operative Care</option>
                            <option>Emergency Follow-up</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', function () {
    const fullScreenModal = document.getElementById('medicalConsultationModal');
    if (fullScreenModal) {
        fullScreenModal.addEventListener('shown.bs.modal', () => {
            if (window.Choices) {
                let chargeChoices = new Choices('#consult_charge', {searchEnabled: true, removeItemButton: true});
                chargeChoices.clearStore();
                chargeChoices.setChoices([{value:'',label:'Loading...',disabled:false,selected:true}], 'value', 'label', false);
                fetch('{{ url('/get-all-charges') }}')
                    .then(res => res.json())
                    .then(data => {
                        const choicesArray = data.map(charge => ({value: charge.id, label: charge.charge_name}));
                        chargeChoices.clearStore();
                        chargeChoices.setChoices(choicesArray, 'value', 'label', true);
                    })
                    .catch(() => {
                        chargeChoices.clearStore();
                        chargeChoices.setChoices([{value:'',label:'Error loading charges',disabled:true}], 'value','label', true);
                    });


            }
        });
    }
    const chargeSelect = document.getElementById('consult_charge');

    const tableBody = document.querySelector('#consultChargesTable tbody');

    chargeSelect.addEventListener('change', async function () {
        tableBody.innerHTML = '';
        const ids = Array.from(this.selectedOptions).map(opt => opt.value);
        for (const id of ids) {
            const res = await fetch('{{ url('/get-charge-details') }}/' + id);
            const data = await res.json();
            const row = document.createElement('tr');
            row.dataset.id = id;
            row.innerHTML = `
                <td>${data.charge_name}</td>
                <td><input type="number" class="form-control standard-charge" value="${data.standard_charge}" readonly></td>
                <td><input type="number" class="form-control applied-charge" value="${data.standard_charge}"></td>
                <td><input type="number" class="form-control discount" value="0"></td>
                <td><input type="number" class="form-control tax" value="${data.tax_percentage}"></td>
                <td><input type="number" class="form-control amount" value="${data.standard_charge}" readonly></td>
                <td><button type="button" class="btn btn-sm btn-danger remove-charge">X</button></td>`;
            tableBody.appendChild(row);
            attachCalc(row);
        }
        updateTotal();
    });

    document.querySelector('#consultChargesTable').addEventListener('click', function (e) {
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
            const t = parseFloat(tax.value) || 0;
            const sub = a - (a * d / 100);
            const total = sub + (sub * t / 100);
            amount.value = total.toFixed(2);
            updateTotal();
        }

        applied.addEventListener('input', calc);
        discount.addEventListener('input', calc);
        tax.addEventListener('input', calc);
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('#consultChargesTable tbody .amount').forEach(el => {
            total += parseFloat(el.value) || 0;
        });
        document.getElementById('consultPaidAmount').value = total.toFixed(2);
    }

    const form = document.getElementById('medicalConsultationForm');
    const modalEl = document.getElementById('medicalConsultationModal');
    const modal = new bootstrap.Modal(modalEl);
    const saveBtn = form.querySelector('button[type="submit"]');

    function resetForm() {
        form.reset();
        document.getElementById('consult_id').value = '';
        tableBody.innerHTML = '';
        updateTotal();
    }

    function setReadonly(isReadonly) {
        form.querySelectorAll('input, textarea, select').forEach(el => {
            if (isReadonly) {
                el.setAttribute('disabled', 'disabled');
            } else {
                el.removeAttribute('disabled');
            }
        });
        tableBody.querySelectorAll('.remove-charge').forEach(btn => {
            btn.style.display = isReadonly ? 'none' : '';
        });
        saveBtn.style.display = isReadonly ? 'none' : 'inline-block';
    }

    function populateCharges(services, isReadonly = false) {
        tableBody.innerHTML = '';
        services.forEach(item => {
            const row = document.createElement('tr');
            row.dataset.id = item.charge_id;
            row.innerHTML = `
                <td>${item.charge.charge_name}</td>
                <td><input type="number" class="form-control standard-charge" value="${item.standard_charge}" readonly></td>
                <td><input type="number" class="form-control applied-charge" value="${item.applied_charge}"></td>
                <td><input type="number" class="form-control discount" value="${item.discount}"></td>
                <td><input type="number" class="form-control tax" value="${item.tax}"></td>
                <td><input type="number" class="form-control amount" value="${item.amount}" readonly></td>
                <td><button type="button" class="btn btn-sm btn-danger remove-charge">X</button></td>`;
            tableBody.appendChild(row);
            if (!isReadonly) {
                attachCalc(row);
            }
        });
        setReadonly(isReadonly);
        updateTotal();
    }

    document.querySelectorAll('.consult-btn').forEach(btn => {
        btn.addEventListener('click', async function () {
            resetForm();
            setReadonly(false);
            document.getElementById('consult_patient_id').value = this.dataset.patient;
            document.getElementById('consult_appointment_id').value = this.dataset.appointment;
            const consultId = this.dataset.consult;
            if (consultId) {
                const res = await fetch(`/doctor/consultations/${consultId}`);
                const data = await res.json();
                document.getElementById('consult_id').value = data.id;
                form.chief_complaint.value = data.chief_complaint ?? '';
                form.history_of_present_illness.value = data.history_of_present_illness ?? '';
                form.provisional_diagnosis.value = data.provisional_diagnosis ?? '';
                form.final_diagnosis.value = data.final_diagnosis ?? '';
                form.post_consultation_advice.value = data.post_consultation_advice ?? '';
                if (data.next_appointment) form.next_appointment.value = data.next_appointment;
                form.follow_up_type.value = data.follow_up_type ?? '';
                populateCharges(data.services, false);
            } else {
                setReadonly(false);
            }
            modal.show();
        });
    });
    document.querySelectorAll('.view-consult-btn').forEach(btn => {
        btn.addEventListener('click', async function () {
            const id = this.dataset.consult;
            if (!id) return;
            resetForm();
            const res = await fetch(`/doctor/consultations/${id}`);
            const data = await res.json();
            document.getElementById('consult_id').value = data.id;
            form.chief_complaint.value = data.chief_complaint ?? '';
            form.history_of_present_illness.value = data.history_of_present_illness ?? '';
            form.provisional_diagnosis.value = data.provisional_diagnosis ?? '';
            form.final_diagnosis.value = data.final_diagnosis ?? '';
            form.post_consultation_advice.value = data.post_consultation_advice ?? '';
            if (data.next_appointment) form.next_appointment.value = data.next_appointment;
            form.follow_up_type.value = data.follow_up_type ?? '';
            populateCharges(data.services, true);
            modal.show();
        });
    });

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const consultId = document.getElementById('consult_id').value;
        const url = consultId ? `/doctor/consultations/${consultId}` : '/doctor/consultations';
        const method = consultId ? 'PUT' : 'POST';
        const services = [];
        document.querySelectorAll('#consultChargesTable tbody tr').forEach(row => {
            services.push({
                charge_id: row.dataset.id,
                applied_charge: row.querySelector('.applied-charge').value,
                discount: row.querySelector('.discount').value,
                tax: row.querySelector('.tax').value,
            });
        });
        const payload = {
            patient_id: document.getElementById('consult_patient_id').value,
            appointment_id: document.getElementById('consult_appointment_id').value,
            chief_complaint: form.chief_complaint.value,
            history_of_present_illness: form.history_of_present_illness.value,
            provisional_diagnosis: form.provisional_diagnosis.value,
            final_diagnosis: form.final_diagnosis.value,
            post_consultation_advice: form.post_consultation_advice.value,
            next_appointment: form.next_appointment.value,
            follow_up_type: form.follow_up_type.value,
            services: services
        };
        await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(payload)
        });
        modal.hide();
        location.reload();
    });
});
</script>
