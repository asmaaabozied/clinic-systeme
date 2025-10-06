<div class="tab-content active" id="overview">
    <div class="medical-section">
        <!-- Payment Cards -->
        <div class="payment-grid">
            @php
                $billingModules = [
                    'opd' => 'OPD',
//                    'pharmacy' => 'Pharmacy',
//                    'pathology' => 'Pathology',
//                    'radiology' => 'Radiology',
//                    'blood_bank' => 'Blood Bank',
//                    'ambulance' => 'Ambulance'
                ];
            @endphp
            @foreach($billingModules as $key => $label)
                @php $info = $billing[$key] ?? ['paid' => 0, 'amount' => 0, 'percentage' => 0]; @endphp
                <div class="payment-card">
                    <div class="payment-title">{{ strtoupper($label) }} PAYMENT/BILLING</div>
                    <div class="payment-percentage">{{ number_format($info['percentage'], 2) }}%</div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $info['percentage'] }}%"></div>
                    </div>
                    <div class="payment-amount"> {{ number_format($totalPaid, 2) }} SAR</div>
                </div>
            @endforeach
        </div>

        <!-- Quick Summary Tables -->
        <div class="table-container">
            <div class="table-title">RECENT MEDICATION</div>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Medicine Name</th>
                        <th>Dose</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_medications as $medication)
                        <tr>
                            <td>{{ $medication->created_at->format('d/m/Y') }}</td>
                            <td>{{ $medication->medicine->name ?? '' }}</td>
                            <td>{{ $medication->dose->name ?? '' }}</td>
                            <td>{{ $medication->created_at->format('h:i A') }}</td>
                            <td>
                                <span class="status-badge status-completed">Completed</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No medication records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <div class="table-title">RECENT OPERATIONS</div>
            <table>
                <thead>
                    <tr>
                        <th>Reference No</th>
                        <th>Operation Date</th>
                        <th>Operation Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_operations as $operation)
                        <tr>
                            <td>{{ $operation->reference_no ?? $operation->reference ?? '' }}</td>
                            <td>{{ \Carbon\Carbon::parse($operation->operation_date)->format('d/m/Y h:i A') }}</td>
                            <td>{{ $operation->operation_name ?? $operation->name ?? '' }}</td>
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
    </div>
</div>
