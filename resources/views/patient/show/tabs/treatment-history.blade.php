<div class="tab-content" id="treatment-history">
    <div class="medical-section">
        <div class="stats-grid">
            <div class="card">
                <h3>Total Treatments</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #4A90E2;">
                    {{ $treatmentStats['total'] }}
                </div>
            </div>
            <div class="card">
                <h3>Active Treatments</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #28a745;">
                    {{ $treatmentStats['active'] }}
                </div>
            </div>
            <div class="card">
                <h3>Completed</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #6c757d;">
                    {{ $treatmentStats['completed'] }}
                </div>
            </div>
            <div class="card">
                <h3>Success Rate</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #28a745;">
                    {{ $treatmentStats['success_rate'] }}%
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-title">CURRENT TREATMENT PLANS</div>
            <table>
                <thead>
                    <tr>
                        <th>Treatment Plan</th>
                        <th>Condition</th>
                        <th>Start Date</th>
                        <th>Expected End</th>
                        <th>Progress</th>
                        <th>Assigned Doctor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($currentTreatments as $treatment)
                        <tr>
                            <td>{{ $treatment->name }}</td>
                            <td>{{ $treatment->condition }}</td>
                            <td>{{ optional($treatment->start_date)->format('d/m/Y') }}</td>
                            <td>{{ optional($treatment->expected_end_date)->format('d/m/Y') }}</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $treatment->progress }}%"></div>
                                </div>
                                {{ $treatment->progress }}%
                            </td>
                            <td>{{ optional($treatment->doctor->user)->name }}</td>
                            <td><span class="status-badge status-active">{{ ucfirst($treatment->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No current treatment plans found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <div class="table-title">TREATMENT HISTORY</div>
            <table>
                <thead>
                    <tr>
                        <th>Treatment</th>
                        <th>Condition</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Duration</th>
                        <th>Outcome</th>
                        <th>Doctor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pastTreatments as $treatment)
                        <tr>
                            <td>{{ $treatment->name }}</td>
                            <td>{{ $treatment->condition }}</td>
                            <td>{{ optional($treatment->start_date)->format('d/m/Y') }}</td>
                            <td>{{ optional($treatment->end_date)->format('d/m/Y') }}</td>
                            <td>
                                @if($treatment->start_date && $treatment->end_date)
                                    {{ $treatment->start_date->diffInDays($treatment->end_date) }} days
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $treatment->outcome }}</td>
                            <td>{{ optional($treatment->doctor->user)->name }}</td>
                            <td><span class="status-badge status-completed">{{ ucfirst($treatment->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No treatment history found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3>Treatment Effectiveness Chart</h3>
            <div class="chart-container">
                📊 Treatment Effectiveness Over Time
                <br><small>Chart showing patient response to various treatments</small>
            </div>
        </div>

        <div class="card">
            <h3>Create New Treatment Plan</h3>
            <form method="POST" action="{{ route('doctor.patient.treatments.store', $patient->id) }}">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Treatment Name</label>
                        <input type="text" name="name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Condition</label>
                        <input type="text" name="condition" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Expected Duration (Days)</label>
                        <input type="number" name="duration" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Assigned Doctor</label>
                        <select name="doctor_id" class="form-input">
                            @foreach($doctors as $doc)
                                <option value="{{ $doc->id }}">{{ $doc->user->name ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-input">
                            <option value="normal">Normal</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                            <option value="critical">Critical</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="margin-top: 1rem;">
                    <label class="form-label">Treatment Description</label>
                    <textarea name="description" class="form-input" rows="3"></textarea>
                </div>
                <button class="btn btn-primary" style="margin-top: 1rem;">Create Treatment Plan</button>
            </form>
        </div>
    </div>
</div>
