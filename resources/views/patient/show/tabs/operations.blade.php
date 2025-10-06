<div class="tab-content" id="operations">
    <div class="medical-section">
        <div class="stats-grid">
            <div class="card">
                <h3>Total Operations</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #4A90E2;">{{ $operationStats['total'] }}</div>
            </div>
            <div class="card">
                <h3>Completed</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #28a745;">{{ $operationStats['completed'] }}</div>
            </div>
            <div class="card">
                <h3>Scheduled</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #ffc107;">{{ $operationStats['scheduled'] }}</div>
            </div>
            <div class="card">
                <h3>Success Rate</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #28a745;">{{ $operationStats['success_rate'] }}%</div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-title">OPERATION HISTORY</div>
            <table>
                <thead>
                    <tr>
                        <th>Reference No</th>
                        <th>Operation Date</th>
                        <th>Operation Name</th>
                        <th>Notes</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($operations as $operation)
                        <tr>
                            <td>{{ $operation->reference_no }}</td>
                            <td>{{ $operation->operation_date?->format('d/m/Y h:i A') }}</td>
                            <td>{{ $operation->operation_name }}</td>
                            <td>{{ $operation->details }}</td>
                            <td>
                                @php $status = $operation->status ?? 'completed'; @endphp
                                <span class="status-badge {{ $status == 'completed' ? 'status-completed' : 'status-pending' }}">{{ ucfirst($status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No operations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <div class="table-title">PRE-OPERATIVE CHECKLIST</div>
            <table>
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Status</th>
                    <th>Date Completed</th>
                    <th>Completed By</th>
                    <th>Notes</th>
                </tr>
                </thead>
                <tbody>
                @forelse($preOpChecklists as $item)
                    <tr>
                        <td>{{ $item->item }}</td>
                        <td>
                            <span class="status-badge {{ $item->status == 'completed' ? 'status-completed' : 'status-pending' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->date_completed?->format('d/m/Y') }}</td>
                        <td>{{ $item->completed_by }}</td>
                        <td>{{ $item->notes }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No checklist items found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card">
            <h3>Add Checklist Item</h3>
            <form method="POST" action="{{ route('doctor.patient.pre-operative-checklists.store', $patient) }}">
                @csrf
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-top: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Item</label>
                        <input type="text" name="item" class="form-input" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-input">
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date Completed</label>
                        <input type="date" name="date_completed" class="form-input" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Completed By</label>
                        <input type="text" name="completed_by" class="form-input" />
                    </div>
                </div>
                <div class="form-group" style="margin-top: 1rem;">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-input" rows="2"></textarea>
                </div>
                <button class="btn btn-primary" style="margin-top: 1rem;">Add Item</button>
            </form>
        </div>
        <div class="card">
            <h3>Schedule New Operation</h3>
            <form method="POST" action="{{ route('doctor.patient.operations.store', $patient) }}">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Reference No</label>
                        <input type="text" name="reference_no" class="form-input" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Operation Name</label>
                        <input type="text" name="operation_name" class="form-input" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date & Time</label>
                        <input type="datetime-local" name="operation_date" class="form-input" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-input">
                            <option value="scheduled">Scheduled</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="margin-top: 1rem;">
                    <label class="form-label">Operation Details</label>
                    <textarea name="details" class="form-input" rows="3" placeholder="Enter operation details and notes"></textarea>
                </div>
                <button class="btn btn-primary" style="margin-top: 1rem;">Schedule Operation</button>
            </form>
        </div>
    </div>
</div>
