<div class="tab-content" id="lab-investigation">
    <div class="medical-section">
        <div class="stats-grid">
            <div class="card">
                <h3>Total Tests</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #4A90E2;">
                    {{ $labStats['total'] ?? 0 }}
                </div>
            </div>
            <div class="card">
                <h3>Pending Results</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #ffc107;">
                    {{ $labStats['pending'] ?? 0 }}
                </div>
            </div>
            <div class="card">
                <h3>Completed</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #28a745;">
                    {{ $labStats['completed'] ?? 0 }}
                </div>
            </div>
            <div class="card">
                <h3>Abnormal Results</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #dc3545;">
                    {{ $labStats['abnormal'] ?? 0 }}
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-title">RECENT LAB TESTS</div>
            <table>
                <thead>
                    <tr>
                        <th>Test Name</th>
                        <th>Test Date</th>
                        <th>Lab</th>
                        <th>Sample Collected</th>
                        <th>Expected Date</th>
                        <th>Status</th>
                        <th>Results</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($labInvestigations as $test)
                        <tr>
                            <td>{{ $test->test_name }}</td>
                            <td>{{ optional($test->test_date)->format('d/m/Y') }}</td>
                            <td>{{ $test->lab ?? '-' }}</td>
                            <td>{{ optional($test->sample_collected_at)->format('d/m/Y h:i A') }}</td>
                            <td>{{ optional($test->expected_date)->format('d/m/Y') }}</td>
                            <td><span class="status-badge status-{{ $test->status }}">{{ ucfirst($test->status) }}</span></td>
                            <td>
                                @if($test->result)
                                    <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">View</button>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No lab tests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <div class="table-title">LAB RESULTS SUMMARY</div>
            <table>
                <thead>
                    <tr>
                        <th>Parameter</th>
                        <th>Result</th>
                        <th>Normal Range</th>
                        <th>Unit</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($labResults as $result)
                        <tr>
                            <td>{{ $result->parameter }}</td>
                            <td>{{ $result->result }}</td>
                            <td>{{ $result->normal_range }}</td>
                            <td>{{ $result->unit }}</td>
                            <td><span class="status-badge status-{{ $result->status }}">{{ ucfirst($result->status) }}</span></td>
                            <td>{{ optional($result->date)->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No results found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3>Order New Lab Test</h3>
            <form action="{{ route('doctor.patient.lab-investigations.store', $patient->id) }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Test Name</label>
                        <input type="text" name="test_name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Lab</label>
                        <input type="text" name="lab" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Test Date</label>
                        <input type="date" name="test_date" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sample Collected At</label>
                        <input type="datetime-local" name="sample_collected_at" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Expected Date</label>
                        <input type="date" name="expected_date" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-input">
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <button class="btn btn-primary" style="margin-top: 1rem;">Order Test</button>
            </form>
        </div>
    </div>
</div>
