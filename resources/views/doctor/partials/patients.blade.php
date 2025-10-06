<div id="patients" class="tab-content">

    <div class="patients-table-container">
        <table class="table datatable patients-table">
            <thead>
            <tr>
                <th>Patient</th>
                <th>Age/Gender</th>
                <th>Contact</th>
                <th>Procedure</th>
                <th>Doctor</th>
                <th>Status</th>
                <th>Next Appointment</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($patients as $patient)
                <tr class="patient-row" data-patient-id="{{ $patient['id'] }}">
                    <td>
                        <div class="patient-cell">
                            <div class="patient-avatar">
                                <img src="{{ asset('storage/' . $patient['avatar']) }}" alt="{{ $patient['name'] }}"
                                     class="patient-avatar">
                            </div>
                            <div class="patient-info">
                                <div class="patient-name">{{ $patient['name'] }}</div>
                                <div class="patient-id">ID: {{ str_pad($patient['id'], 4, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="age-gender">
                            <div>{{ \Carbon\Carbon::parse($patient['date_of_birth'])->age }} years</div>
                            <div class="gender">{{ $patient['gender'] }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="contact-info">
                            <div class="phone">{{ $patient['phone'] }}</div>
                            <div class="email">{{ $patient['email'] }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="procedure-info">
                            <div class="procedure-name">{{ $patient['procedure'] }}</div>
                            <div class="procedure-date">{{ date('M d, Y', strtotime($patient['date'])) }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="doctor-name">{{ $patient['doctor'] }}</div>
                    </td>
                    <td>
                        <span class="status-badge">{{ $patient['status'] }}</span>
                    </td>
                    <td>
                        <div class="next-appointment">{{ date('M d, Y', strtotime($patient['date'])) }}</div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('doctor.patient.show', $patient['id']) }}" class="btn-icon" title="View Details">
                                <i class="fa fa-eye"></i>
                            </a>
{{--                            <button class="btn-icon" title="Edit" onclick="editPatient({{ $patient['id'] }})">--}}
{{--                                <i class="fa fa-edit"></i>--}}
{{--                            </button>--}}
{{--                            <button class="btn-icon" title="Schedule" onclick="scheduleAppointment({{ $patient['id'] }})">--}}
{{--                                <i class="fa fa-calendar-plus"></i>--}}
{{--                            </button>--}}
{{--                            <button class="btn-icon" title="Medical Records" onclick="viewMedicalRecords({{ $patient['id'] }})">--}}
{{--                                <i class="fa fa-file-medical"></i>--}}
{{--                            </button>--}}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
