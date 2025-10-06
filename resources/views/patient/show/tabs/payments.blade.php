<div class="tab-content" id="payments">
    <div class="medical-section">
        <div class="stats-grid">
            <div class="card">
                <h3>Total Payments</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #28a745;">$430.55</div>
            </div>
            <div class="card">
                <h3>Outstanding Balance</h3>
                <div style="font-size: 2rem; font-weight: bold; color: #dc3545;">$815.25</div>
            </div>
            <div class="card">
                <h3>Last Payment</h3>
                <div style="font-size: 1.2rem; font-weight: bold;">06/05/2025</div>
            </div>
            <div class="card">
                <h3>Payment Method</h3>
                <div style="font-size: 1.2rem; font-weight: bold;">Credit Card</div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-title">PAYMENT HISTORY</div>
            <table>
                <thead>
                    <tr>
                        <th>Payment Date</th>
                        <th>Receipt No</th>
                        <th>Payment Method</th>
                        <th>Amount ($)</th>
                        <th>For Services</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>06/05/2025</td>
                        <td>RCP001245</td>
                        <td>Credit Card</td>
                        <td>136.80</td>
                        <td>Consultation Fee</td>
                        <td><span class="status-badge status-completed">Completed</span></td>
                        <td><button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Receipt</button></td>
                    </tr>
                    <tr>
                        <td>01/05/2025</td>
                        <td>RCP001198</td>
                        <td>Cash</td>
                        <td>293.75</td>
                        <td>Pharmacy</td>
                        <td><span class="status-badge status-completed">Completed</span></td>
                        <td><button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Receipt</button></td>
                    </tr>
                    <tr>
                        <td>15/04/2025</td>
                        <td>RCP001156</td>
                        <td>Insurance</td>
                        <td>240.00</td>
                        <td>Emergency Consultation</td>
                        <td><span class="status-badge status-pending">Processing</span></td>
                        <td><button class="btn btn-secondary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Track</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <div class="table-title">OUTSTANDING INVOICES</div>
            <table>
                <thead>
                    <tr>
                        <th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Due Date</th>
                        <th>Services</th>
                        <th>Amount ($)</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>INV002456</td>
                        <td>06/05/2025</td>
                        <td>20/05/2025</td>
                        <td>Surgery - Tooth Extraction</td>
                        <td>531.00</td>
                        <td><span class="status-badge status-pending">Pending</span></td>
                        <td><button class="btn btn-success" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Pay Now</button></td>
                    </tr>
                    <tr>
                        <td>INV002445</td>
                        <td>05/05/2025</td>
                        <td>19/05/2025</td>
                        <td>Lab Tests</td>
                        <td>168.00</td>
                        <td><span class="status-badge status-pending">Pending</span></td>
                        <td><button class="btn btn-success" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Pay Now</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3>Make Payment</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1rem;">
                <div class="form-group">
                    <label class="form-label">Invoice Number</label>
                    <select class="form-input">
                        <option>INV002456 - $531.00</option>
                        <option>INV002445 - $168.00</option>
                        <option>Pay All Outstanding - $815.25</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Payment Method</label>
                    <select class="form-input">
                        <option>Credit Card</option>
                        <option>Debit Card</option>
                        <option>Cash</option>
                        <option>Insurance</option>
                        <option>Bank Transfer</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Amount ($)</label>
                    <input type="number" class="form-input" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label class="form-label">Reference Number</label>
                    <input type="text" class="form-input" placeholder="Optional">
                </div>
            </div>
            <button class="btn btn-success" style="margin-top: 1rem;">Process Payment</button>
        </div>
    </div>
</div>
