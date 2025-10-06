<div class="tab-content" id="charges">
    <div class="medical-section">
        <div class="stats-grid">
            <div class="card">
                <h3>Total Charges</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #4A90E2;">
                    {{ number_format($totalChargeAmount, 2) }}
                </div>
            </div>
            <div class="card">
                <h3>Paid Amount</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #28a745;">
                    {{ number_format($totalChargePaid, 2) }}
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-title">DETAILED CHARGES</div>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Service Name</th>
                        <th>Charge Type</th>
                        <th>Standard Charge ($)</th>
                        <th>Tax (%)</th>
                        <th>Tax Amount ($)</th>
                        <th>Applied Charge ($)</th>
                        <th>Total Amount ($)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patientCharges as $c)
                        @php
                            $discountAmount = $c->applied_charge * ($c->discount / 100);
                            $taxAmount = ($c->applied_charge - $discountAmount) * ($c->tax / 100);
                        @endphp
                        <tr>
                            <td>{{ $c->created_at->format('d/m/Y') }}</td>
                            <td>{{ $c->charge?->charge_name }}</td>
                            <td>{{ $c->charge?->chargeType?->name }}</td>
                            <td>{{ number_format($c->standard_charge, 2) }}</td>
                            <td>{{ number_format($c->tax, 2) }}</td>
                            <td>{{ number_format($taxAmount, 2) }}</td>
                            <td>{{ number_format($c->applied_charge, 2) }}</td>
                            <td>{{ number_format($c->amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No charges found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <div class="table-title">CHARGE CATEGORIES</div>
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Number of Items</th>
                        <th>Subtotal ($)</th>
                        <th>Tax ($)</th>
                        <th>Total ($)</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($chargeCategoriesSummary as $category => $summary)
                        <tr>
                            <td>{{ $category }}</td>
                            <td>{{ $summary['count'] }}</td>
                            <td>{{ number_format($summary['subtotal'], 2) }}</td>
                            <td>{{ number_format($summary['tax'], 2) }}</td>
                            <td>{{ number_format($summary['total'], 2) }}</td>
                            <td>
                                {{ $totalChargeAmount > 0 ? number_format(($summary['total'] / $totalChargeAmount) * 100, 2) : '0' }}%
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No charge data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3>Add New Charge</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1rem;">
                <div class="form-group">
                    <label class="form-label">Service Name</label>
                    <input type="text" class="form-input" placeholder="Enter service name">
                </div>
                <div class="form-group">
                    <label class="form-label">Charge Type</label>
                    <select class="form-input">
                        <option>Consultation</option>
                        <option>Surgery</option>
                        <option>Laboratory</option>
                        <option>Pharmacy</option>
                        <option>Emergency</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Standard Charge ($)</label>
                    <input type="number" class="form-input" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label class="form-label">Tax Rate (%)</label>
                    <input type="number" class="form-input" placeholder="0">
                </div>
            </div>
            <button class="btn btn-primary" style="margin-top: 1rem;">Add Charge</button>
        </div>
    </div>
</div>
