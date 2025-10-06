<div class="tab-content" id="medication">
    <div class="medical-section">
        <div class="stats-grid">
            <div class="card">
                <h3>Active Medications</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #4A90E2;">
                    {{ $activeMedications }}
                </div>
            </div>
            <div class="card">
                <h3>Completed Today</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #28a745;">
                    {{ $completedToday }}
                </div>
            </div>
            <div class="card">
                <h3>Pending Today</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #ffc107;">
                    {{ $pendingToday }}
                </div>
            </div>
            <div class="card">
                <h3>Allergies</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #dc3545;">
                    {{ $patient->allergies ? 'Yes' : '0' }}
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-title">CURRENT MEDICATIONS</div>
            <table>
                <thead>
                    <tr>
                        <th>Medicine Name</th>
                        <th>Dosage</th>
                        <th>Frequency</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($medications as $med)
                        <tr>
                            <td>{{ $med->medicine_name }}</td>
                            <td>{{ $med->dosage }}</td>
                            <td>{{ $med->frequency }}</td>
                            <td>{{ optional($med->start_date)->format('d/m/Y') }}</td>
                            <td>{{ optional($med->end_date)->format('d/m/Y') }}</td>
                            <td>
                                <span class="status-badge status-{{ $med->status == 'active' ? 'active' : 'completed' }}">
                                    {{ ucfirst($med->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No medications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <div class="table-title">MEDICATION HISTORY</div>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Medicine Name</th>
                        <th>Dose</th>
                        <th>Time Taken</th>
                        <th>Prescribed By</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($medicationHistory as $history)
                        <tr>
                            <td>{{ optional($history->taken_at)->format('d/m/Y') }}</td>
                            <td>{{ $history->medication->medicine_name }}</td>
                            <td>{{ $history->medication->dosage }}</td>
                            <td>{{ optional($history->taken_at)->format('h:i A') }}</td>
                            <td>{{ optional($history->medication->doctor->user)->name ?? '-' }}</td>
                            <td>
                                <span class="status-badge status-{{ $history->status == 'taken' ? 'completed' : 'pending' }}">
                                    {{ ucfirst($history->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No history found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3>Add New Medication</h3>
            <form action="{{ route('doctor.patient.medications.store', $patient->id) }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Medicine Name</label>
                        <input type="text" name="medicine_name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Dosage</label>
                        <input type="text" name="dosage" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Frequency</label>
                        <input type="text" name="frequency" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Duration (Days)</label>
                        <input type="number" name="duration" class="form-input" required>
                    </div>
                </div>
                <button class="btn btn-primary" style="margin-top: 1rem;">Add Medication</button>
            </form>
        </div>
    </div>
</div>
