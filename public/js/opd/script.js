document.addEventListener('DOMContentLoaded', () => {
    $('.modal').modal('hide'); // Close any open modals on page load
    // Tab switching
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            const tabContentId = tab.dataset.tab;
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
                if (content.id === tabContentId) {
                    content.classList.add('active');
                }
            });
        });
    });

    // Open OPD modal from patient profile
    const newVisitBtn = document.getElementById('newVisitBtn');
    if (newVisitBtn) {
        newVisitBtn.addEventListener('click', () => {
            const patientId = newVisitBtn.dataset.patientId;
            if (typeof openOpdModal === 'function') {
                openOpdModal(patientId);
            }
        });
    }

    const recheckupBtn = document.getElementById('recheckupBtn');
    if (recheckupBtn) {
        recheckupBtn.addEventListener('click', () => {
            if (typeof openCheckupModal === 'function') {
                openCheckupModal(recheckupBtn.dataset.appointmentId, recheckupBtn.dataset.doctorId, recheckupBtn.dataset.patientId);
            }
        });
    }

    document.addEventListener('click', (event) => {
        const btn = event.target.closest('.view-appointment');
        if (btn) {
            document.getElementById('apOpdId').textContent = btn.dataset.opd;
            document.getElementById('apCaseId').textContent = btn.dataset.case;
            document.getElementById('apPatientName').textContent = btn.dataset.name;
            document.getElementById('apGender').textContent = btn.dataset.gender;
            document.getElementById('apPhone').textContent = btn.dataset.phone;
            document.getElementById('apEmail').textContent = btn.dataset.email;
            document.getElementById('apDate').textContent = btn.dataset.date;
            document.getElementById('apDoctor').textContent = btn.dataset.doctor;
            $("#appointmentDetailModal").modal('show');
        }
    });

    document.addEventListener('click', (event) => {
        const btn = event.target.closest('.view-checkup');
        if (btn) {
            const url = btn.dataset.url;
            if (!url) return;
            fetch(url)
                .then(r => r.json())
                .then(data => {
                    document.getElementById('viewChkId').textContent = data.checkup_number;
                    document.getElementById('viewOpdId').textContent = data.appointment.opd_no;
                    document.getElementById('viewCaseId').textContent = data.appointment.case_id;
                    document.getElementById('viewPatientName').textContent = data.appointment.patient.name;
                    const gender = data.appointment.patient.gender_id == 1 ? 'Male' : (data.appointment.patient.gender_id == 2 ? 'Female' : '-');
                    document.getElementById('viewGender').textContent = gender;
                    document.getElementById('viewPhone').textContent = data.appointment.patient.phone_number;
                    document.getElementById('viewEmail').textContent = data.appointment.patient.email ?? '-';
                    document.getElementById('viewDate').textContent = data.checkup_date;
                    document.getElementById('viewDoctor').textContent = data.doctor_name ?? '';
                    $("#checkupDetailModal").modal('show');
                })
                .catch(error => console.error('Fetch error:', error));
        }
    });

    document.addEventListener('click', (event) => {
        const btn = event.target.closest('.view-assessment');
        if (btn) {
            const url = btn.dataset.url;
            if (!url) return;
            fetch(url)
                .then(r => r.json())
                .then(data => {
                    document.getElementById('assId').textContent = data.id;
                    document.getElementById('assDate').textContent = data.created_at;
                    document.getElementById('assTemp').textContent = data.temperature ?? '-';
                    const bp = data.blood_pressure_systolic ? `${data.blood_pressure_systolic}/${data.blood_pressure_diastolic}` : '-';
                    document.getElementById('assBp').textContent = bp;
                    document.getElementById('assHr').textContent = data.heart_rate ?? '-';
                    document.getElementById('assRr').textContent = data.respiratory_rate ?? '-';
                    document.getElementById('assOs').textContent = data.oxygen_saturation ?? '-';
                    document.getElementById('assWeight').textContent = data.weight ?? '-';
                    document.getElementById('assHeight').textContent = data.height ?? '-';
                    document.getElementById('assBmi').textContent = data.bmi ?? '-';
                    document.getElementById('assAllergies').textContent = data.allergies ?? '-';
                    document.getElementById('assFallRisk').textContent = data.fall_risk ?? '-';
                    document.getElementById('assPain').textContent = data.pain_level ?? '-';
                    document.getElementById('assSmoking').textContent = data.smoking_status ?? '-';
                    document.getElementById('assAlcohol').textContent = data.alcohol_consumption ?? '-';
                    document.getElementById('assChronic').textContent = (data.chronic_conditions || []).join ? data.chronic_conditions.join(', ') : (data.chronic_conditions ?? '-');
                    $("#assessmentDetailModal").modal('show');
                })
                .catch(err => console.error('Fetch error:', err));
        }
    });

    // Placeholder for other action buttons
    // document.querySelectorAll('.action-btn').forEach(btn => {
    //     btn.addEventListener('click', () => {
    //         const action = btn.title;
    //         if (!btn.classList.contains('view-patient')) {
    //             alert(`Action: ${action} (Implement functionality)`);
    //         }
    //     });
    // });

    // Initialize Choices.js when the OPD modal is shown
    const fullScreenModal = document.getElementById('fullScreenModal');
    if (fullScreenModal) {
        fullScreenModal.addEventListener('shown.bs.modal', () => {
            if (window.Choices) {
                const chargeSelect = document.getElementById('charge');
                const typeSelect = document.getElementById('symptoms_type');
                const titleSelect = document.getElementById('symptoms_title');
                const doctorSelect = document.getElementById('consultantDoctor');

                if (chargeSelect && !chargeSelect.classList.contains('choices')) {
                    new Choices(chargeSelect, { searchEnabled: true });
                }
                if (typeSelect && !typeSelect.classList.contains('choices')) {
                    new Choices(typeSelect, { searchEnabled: true, removeItemButton: true });
                }
                if (titleSelect && !titleSelect.classList.contains('choices')) {
                    new Choices(titleSelect, { searchEnabled: true, removeItemButton: true });
                }
                if (doctorSelect && !doctorSelect.classList.contains('choices')) {
                    new Choices(doctorSelect, { searchEnabled: true, itemSelectText: '', placeholderValue: 'Select', shouldSort: false });
                }
            }
        });
    }
});
