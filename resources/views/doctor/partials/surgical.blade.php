<div id="surgical" class="tab-content">
    <div class="surgical-dashboard">
        <div class="surgical-stats">
            <div class="stat-card">
                <div class="stat-icon"><i class="fa fa-procedures"></i></div>
                <div class="stat-content">
                    <h3>Upcoming Surgeries</h3>
                    <div class="stat-value">8</div>
                    <p>This week</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fa fa-hospital"></i></div>
                <div class="stat-content">
                    <h3>Operating Rooms</h3>
                    <div class="stat-value">3</div>
                    <p>Available</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fa fa-chart-line"></i></div>
                <div class="stat-content">
                    <h3>Success Rate</h3>
                    <div class="stat-value">99.2%</div>
                    <p>Last 30 days</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fa fa-clock"></i></div>
                <div class="stat-content">
                    <h3>Avg Duration</h3>
                    <div class="stat-value">2.5h</div>
                    <p>Per surgery</p>
                </div>
            </div>
        </div>

        <div class="surgical-toolbar">
            <div class="toolbar-left">
                <button class="btn btn-primary" onclick="scheduleSurgery()">
                    <i class="fa fa-plus"></i> Schedule Surgery
                </button>
                <button class="btn btn-secondary">
                    <i class="fa fa-calendar-alt"></i> OR Calendar
                </button>
            </div>
            <div class="toolbar-right">
                <select class="filter-select">
                    <option value="">All Surgeons</option>
                    <option value="Dr. Rodriguez">Dr. Rodriguez</option>
                    <option value="Dr. Smith">Dr. Smith</option>
                    <option value="Dr. Johnson">Dr. Johnson</option>
                </select>
                <select class="filter-select">
                    <option value="">All Rooms</option>
                    <option value="OR-1">OR-1</option>
                    <option value="OR-2">OR-2</option>
                    <option value="OR-3">OR-3</option>
                </select>
            </div>
        </div>

        <div class="surgical-schedule">
            <h3>Surgical Schedule</h3>
            <div class="schedule-grid">
                @foreach($surgicalSchedule as $surgery)
                    <div class="surgery-card" data-surgery-id="{{ $surgery['id'] }}">
                        <div class="surgery-header">
                            <div class="surgery-date-time">
                                <div class="surgery-date">{{ date('M d, Y', strtotime($surgery['date'])) }}</div>
                                <div class="surgery-time">{{ $surgery['time'] }}</div>
                            </div>
                            <div class="surgery-status {{ $surgery['status'] }}">{{ $surgery['status'] }}</div>
                        </div>
                        <div class="surgery-main">
                            <div class="surgery-procedure">
                                <h4>{{ $surgery['procedure'] }}</h4>
                                <div class="surgery-patient">
                                    <i class="fa fa-user"></i> {{ $surgery['patient'] }}
                                </div>
                            </div>
                            <div class="surgery-details">
                                <div class="detail-item">
                                    <i class="fa fa-user-md"></i> <span>{{ $surgery['surgeon'] }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fa fa-hospital"></i> <span>{{ $surgery['room'] }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fa fa-clock"></i> <span>{{ $surgery['duration'] }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fa fa-syringe"></i> <span>{{ $surgery['anesthesia'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="surgery-team">
                            <div class="team-label">Team:</div>
                            <div class="team-members">
                                @foreach($surgery['assistants'] as $assistant)
                                    <span class="team-member">{{ $assistant }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="surgery-equipment">
                            <div class="equipment-label">Equipment:</div>
                            <div class="equipment-list">
                                @foreach($surgery['equipment'] as $item)
                                    <span class="equipment-item">{{ $item }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="surgery-notes">
                            <i class="fa fa-sticky-note"></i> <span>{{ $surgery['notes'] }}</span>
                        </div>
                        <div class="surgery-actions">
                            <button class="btn-icon" title="Edit Surgery" onclick="editSurgery({{ $surgery['id'] }})">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn-icon" title="View Details" data-bs-toggle="modal" data-bs-target="#surgeryDetailsModal" onclick="viewSurgeryDetails({{ $surgery['id'] }})">
                                <i class="fa fa-eye"></i>
                            </button>
                            <button class="btn-icon" title="Cancel Surgery" onclick="cancelSurgery({{ $surgery['id'] }})">
                                <i class="fa fa-times"></i>
                            </button>
                            <button class="btn-icon" title="Print Schedule" onclick="printSurgerySchedule({{ $surgery['id'] }})">
                                <i class="fa fa-print"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="or-availability">
            <h3>Operating Room Availability</h3>
            <div class="or-grid">
                <div class="or-room available">
                    <div class="room-header">
                        <h4>OR-1</h4>
                        <span class="room-status available">Available</span>
                    </div>
                    <div class="room-details">
                        <div class="next-surgery">Next: 08:00 - Rhinoplasty</div>
                        <div class="room-equipment">Equipment: Standard Surgical Set</div>
                    </div>
                </div>
                <div class="or-room occupied">
                    <div class="room-header">
                        <h4>OR-2</h4>
                        <span class="room-status occupied">In Use</span>
                    </div>
                    <div class="room-details">
                        <div class="current-surgery">Current: Emergency Surgery</div>
                        <div class="estimated-completion">Est. Completion: 16:30</div>
                    </div>
                </div>
                <div class="or-room maintenance">
                    <div class="room-header">
                        <h4>OR-3</h4>
                        <span class="room-status maintenance">Maintenance</span>
                    </div>
                    <div class="room-details">
                        <div class="maintenance-type">Type: Equipment Calibration</div>
                        <div class="available-time">Available: Tomorrow 08:00</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
