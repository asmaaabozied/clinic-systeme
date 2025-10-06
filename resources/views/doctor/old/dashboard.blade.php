@extends('doctor.layout.app')

@section('title', 'Dashboard - MedClinic Pro')

@section('header_title', 'Dashboard')
@section('header_subtitle', 'Welcome back, ' . auth()->user()?->name)

@section('content')
    <!-- Tab Navigation -->
    <div class="tab-navigation">
        <button class="tab-btn active" data-tab="overview">Overview</button>
        <button class="tab-btn" data-tab="patients">Patients</button>
        <button class="tab-btn" data-tab="surgical">Surgical</button>
        <button class="tab-btn" data-tab="inventory">Inventory</button>
    </div>

    <!-- Overview Tab -->
    <div class="tab-content active" id="overview">
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Today's Patients</span>
                    <i class="fas fa-users stat-icon" style="color: #3b82f6;"></i>
                </div>
                <div class="stat-value">{{ $todayPatients }}</div>
                <div class="stat-change">+2 from yesterday</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Surgeries This Week</span>
                    <i class="fas fa-cut stat-icon" style="color: #10b981;"></i>
                </div>
                <div class="stat-value">{{ $weeklySurgeries }}</div>
                <div class="stat-change">3 scheduled tomorrow</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Revenue This Month</span>
                    <i class="fas fa-dollar-sign stat-icon" style="color: #f59e0b;"></i>
                </div>
                <div class="stat-value">${{ number_format($monthlyRevenue) }}</div>
                <div class="stat-change">+12% from last month</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Patient Satisfaction</span>
                    <i class="fas fa-chart-line stat-icon" style="color: #8b5cf6;"></i>
                </div>
                <div class="stat-value">{{ $satisfactionRate }}%</div>
                <div class="stat-change">+1% from last month</div>
            </div>
        </div>

        <!-- Main Dashboard Grid -->
        <div class="dashboard-grid">
            <!-- Recent Patients -->
            <div class="card recent-patients">
                <div class="card-header">
                    <h3>Recent Patient Activity</h3>
                    <p>Latest patient interactions and updates</p>
                </div>
                <div class="card-content">
                    <div class="patient-list">
                        @forelse($recentPatients as $patient)
                            <div class="patient-item">
                                <div class="patient-info">
                                    <img src="{{ asset('storage/' . $patient['avatar']) }}" alt="{{ $patient['name'] }}"
                                        class="patient-avatar">
                                    <div class="patient-details">
                                        <h4>{{ $patient['name'] }}</h4>
                                        <p>{{ $patient['last_visit'] }}</p>
                                    </div>
                                </div>
                                <div class="patient-status {{ $patient['status'] }}">
                                    {{ ucfirst($patient['status']) }}
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">No recent patient activity</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Today's Schedule -->
            <div class="card schedule">
                <div class="card-header">
                    <h3>Today's Schedule</h3>
                    <p>Upcoming appointments</p>
                </div>
                <div class="card-content">
                    <div class="appointment-list">
                        @forelse($todayAppointments as $appointment)
                            <div class="appointment-item">
                                <div class="appointment-time">
                                    <i class="fas fa-clock"></i>
                                    {{ $appointment['time'] }}
                                </div>
                                <div class="appointment-details">
                                    <h4>{{ $appointment['patient_name'] }}</h4>
                                    <p>{{ $appointment['type'] }}</p>
                                </div>
                                <div class="appointment-status {{ $appointment['status'] }}">
                                    {{ ucfirst($appointment['status']) }}
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">No appointments scheduled for today</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventory Alerts -->
        <div class="card inventory-alerts">
            <div class="card-header">
                <h3>Inventory Alerts</h3>
                <p>Items requiring attention</p>
            </div>
            <div class="card-content">
                <div class="alert-list">
                    @forelse($inventoryAlerts as $alert)
                        <div class="alert-item {{ $alert['priority'] }}">
                            <div class="alert-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="alert-content">
                                <h4>{{ $alert['item_name'] }}</h4>
                                <p>{{ $alert['message'] }}</p>
                            </div>
                            <div class="alert-action">
                                <button class="btn btn-sm">Restock</button>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">No inventory alerts</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Patients Tab -->
    <div class="tab-content" id="patients">
        <div class="card">
            <div class="card-header">
                <h3>Patient List</h3>
                <p>Recent patients and their details</p>
            </div>
            <div class="card-content">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Last Visit</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patients as $patient)
                                <tr>
                                    <td>{{ $patient->name }}</td>
                                    <td>{{ $patient->appointments->first()?->appointment_date->diffForHumans() ?? 'No visits' }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $patient->appointments->first()?->case === 'emergency' ? 'danger' : 'success' }}">
                                            {{ ucfirst($patient->appointments->first()?->case ?? 'normal') }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">View Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No patients found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Surgical Tab -->
    <div class="tab-content" id="surgical">
        <div class="card">
            <div class="card-header">
                <h3>Surgical Cases</h3>
                <p>Emergency and surgical procedures</p>
            </div>
            <div class="card-content">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($surgicalCases as $case)
                                <tr>
                                    <td>{{ $case->patient->name }}</td>
                                    <td>{{ $case->appointment_date->format('M d, Y') }}</td>
                                    <td>{{ $case->charge->name ?? 'Emergency' }}</td>
                                    <td>
                                        <span class="badge bg-danger">Emergency</span>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">View Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No surgical cases found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Tab -->
    <div class="tab-content" id="inventory">
        <div class="card">
            <div class="card-header">
                <h3>Inventory Management</h3>
                <p>Medical supplies and equipment</p>
            </div>
            <div class="card-content">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inventory as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->category->name ?? 'Uncategorized' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->unit->name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($item->quantity < 5)
                                            <span class="badge bg-danger">Low Stock</span>
                                        @elseif($item->quantity < 10)
                                            <span class="badge bg-warning">Medium Stock</span>
                                        @else
                                            <span class="badge bg-success">In Stock</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">Manage</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No inventory items found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Tab switching functionality
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all tabs
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove(
                    'active'));

                // Add active class to clicked tab
                button.classList.add('active');
                document.getElementById(button.dataset.tab).classList.add('active');
            });
        });
    </script>
@endpush
