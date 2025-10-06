<div id="overview" class="tab-content active">
    <div class="metrics-grid">
        <div class="metric-card" data-metric="patients">
            <div class="metric-icon"><i class="fa fa-users"></i></div>
            <div class="metric-content">
                <h3>Today's Patients</h3>
                <div class="metric-value">{{ $todayPatients }}</div>
{{--                <div class="metric-change positive"><i class="fa fa-arrow-up"></i> +2 from yesterday</div>--}}
            </div>
        </div>
{{--        <div class="metric-card" data-metric="surgeries">--}}
{{--            <div class="metric-icon"><i class="fa fa-procedures"></i></div>--}}
{{--            <div class="metric-content">--}}
{{--                <h3>Surgeries This Week</h3>--}}
{{--                <div class="metric-value">{{$weeklySurgeries}}</div>--}}
{{--                <div class="metric-change neutral">3 scheduled tomorrow</div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="metric-card" data-metric="revenue">--}}
{{--            <div class="metric-icon"><i class="fa fa-dollar-sign"></i></div>--}}
{{--            <div class="metric-content">--}}
{{--                <h3>Revenue This Month</h3>--}}
{{--                <div class="metric-value">${{ number_format($monthlyRevenue) }}</div>--}}
{{--                <div class="metric-change positive"><i class="fa fa-arrow-up"></i> +12% from last month</div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="metric-card" data-metric="satisfaction">--}}
{{--            <div class="metric-icon"><i class="fa fa-smile"></i></div>--}}
{{--            <div class="metric-content">--}}
{{--                <h3>Patient Satisfaction</h3>--}}
{{--                <div class="metric-value">{{$satisfactionRate}}%</div>--}}
{{--                <div class="metric-change positive"><i class="fa fa-arrow-up"></i> +1% from last month</div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>

    <div class="content-grid">
        <div class="content-section">
            <div class="section-header">
                <h2>Recent Patient Activity</h2>
                <p>Latest patient interactions and updates</p>
            </div>
            <div class="patient-list" id="patientList">
                @foreach($recentPatients as $patient)
                    <div class="patient-item" data-patient-id="{{ $patient['id'] }}">
                        <div class="patient-avatar">
                            <img src="{{ asset('storage/' . $patient['avatar']) }}" alt="{{ $patient['name'] }}"
                                 class="patient-avatar">
                        </div>
                        <div class="patient-info">
                            <div class="patient-name">{{ $patient['name'] }}</div>
                            <div class="patient-procedure">{{ $patient['last_visit'] }}</div>
                        </div>
                        <div class="patient-status">
                            <span class="status-badge {{ $patient['status'] }}">{{ ucfirst($patient['status']) }}</span>
                            <span class="patient-date">pre-checkup</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="content-section">
            <div class="section-header">
                <h2>Today's Schedule</h2>
                <p>Upcoming appointments</p>
            </div>
            <div class="schedule-list" id="scheduleList">
                @foreach($todayAppointments as $appointment)
                    <div class="schedule-item" data-appointment-id="{{ $appointment['id'] }}">
                        <div class="schedule-time">{{ $appointment['time'] }}</div>
                        <div class="schedule-info">
                            <div class="schedule-patient">{{ $appointment['patient_name'] }}</div>
                            <div class="schedule-type">{{ $appointment['type'] }}</div>
                        </div>
                        <div class="schedule-status {{ $appointment['status'] }}">
                            {{ ucfirst($appointment['status']) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
