<div id="inventory" class="tab-content">
    <div class="inventory-dashboard">
        <div class="inventory-stats">
            <div class="stat-card">
                <div class="stat-icon"><i class="fa fa-boxes"></i></div>
                <div class="stat-content">
                    <h3>Total Items</h3>
                    <div class="stat-value">1,247</div>
                    <p>In stock</p>
                </div>
            </div>
            <div class="stat-card critical">
                <div class="stat-icon"><i class="fa fa-exclamation-triangle"></i></div>
                <div class="stat-content">
                    <h3>Low Stock</h3>
                    <div class="stat-value">23</div>
                    <p>Items need reorder</p>
                </div>
            </div>
            <div class="stat-card warning">
                <div class="stat-icon"><i class="fa fa-calendar-times"></i></div>
                <div class="stat-content">
                    <h3>Expiring Soon</h3>
                    <div class="stat-value">8</div>
                    <p>Within 30 days</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fa fa-dollar-sign"></i></div>
                <div class="stat-content">
                    <h3>Inventory Value</h3>
                    <div class="stat-value">$125K</div>
                    <p>Total value</p>
                </div>
            </div>
        </div>

        <div class="inventory-toolbar">
            <div class="toolbar-left">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inventoryActionsModal" onclick="addInventoryItem()">
                    <i class="fa fa-plus"></i> Add Item
                </button>
                <button class="btn btn-secondary" onclick="generateOrder()">
                    <i class="fa fa-shopping-cart"></i> Generate Order
                </button>
                <button class="btn btn-secondary">
                    <i class="fa fa-file-export"></i> Export Report
                </button>
            </div>
            <div class="toolbar-right">
                <input type="text" placeholder="Search inventory..." class="search-input" id="inventorySearch">
                <select class="filter-select" id="categoryFilter">
                    <option value="">All Categories</option>
                    <option value="PPE">PPE</option>
                    <option value="Surgical">Surgical</option>
                    <option value="Medication">Medication</option>
                    <option value="Anesthesia">Anesthesia</option>
                    <option value="Controlled">Controlled</option>
                </select>
                <select class="filter-select" id="stockFilter">
                    <option value="">All Stock Levels</option>
                    <option value="good">Good</option>
                    <option value="low">Low Stock</option>
                    <option value="critical">Critical</option>
                </select>
            </div>
        </div>

        <div class="inventory-table-container">
            <table class="table datatable inventory-table">
                <thead>
                <tr>
                    <th>Item Details</th>
                    <th>Category</th>
                    <th>Stock Level</th>
                    <th>Cost</th>
                    <th>Supplier</th>
                    <th>Expiry Date</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($inventory as $item)
                    <tr class="inventory-row" data-item-id="{{ $item['id'] }}">
                        <td>
                            <div class="item-details">
                                <div class="item-name">{{ $item['name'] }}</div>
                                <div class="item-specs">barand - size</div>
                            </div>
                        </td>
                        <td>
                            <span class="category-badge">category</span>
                        </td>
                        <td>
                            <div class="stock-info">
                                <div class="current-stock">quantity unit</div>
                                <div class="stock-range">Min: ## | Max: ##</div>
                                <div class="stock-bar">
                                    <div class="stock-fill" style="width: {{ ($item['quantity'] / $item['maxStock']) * 100 }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="cost-info">
                                <div class="unit-cost">${{ number_format($item['cost'], 2) }}</div>
                                <div class="total-value">Total: ${{ number_format($item['cost'] * $item['quantity'], 2) }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="supplier-info">
                                <div class="supplier-name">{{ $item['supplier'] }}</div>
                                <div class="last-ordered">Last: {{ date('M d, Y', strtotime($item['lastOrdered'])) }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="expiry-info {{ \App\Helpers\InventoryHelper::getExpiryStatus($item['expiryDate']) }}">
                                <div class="expiry-date">{{ date('M d, Y', strtotime($item['expiryDate'])) }}</div>
                                <div class="days-remaining">{{ \App\Helpers\InventoryHelper::getDaysUntilExpiry($item['expiryDate']) }} days</div>
                            </div>
                        </td>
                        <td>
                            <div class="location-info">
                                <i class="fa fa-map-marker-alt"></i> {{ $item['location'] }}
                            </div>
                        </td>
                        <td>
                            <span class="stock-status {{ $item['status'] }}">{{ $item['status'] }}</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon" title="Edit Item" data-bs-toggle="modal" data-bs-target="#inventoryActionsModal" onclick="editInventoryItem({{ $item['id'] }})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn-icon" title="Reorder" data-bs-toggle="modal" data-bs-target="#inventoryActionsModal" onclick="reorderItem({{ $item['id'] }})">
                                    <i class="fa fa-shopping-cart"></i>
                                </button>
                                <button class="btn-icon" title="Move Location" onclick="moveItem({{ $item['id'] }})">
                                    <i class="fa fa-arrows-alt"></i>
                                </button>
                                <button class="btn-icon" title="View History" onclick="viewItemHistory({{ $item['id'] }})">
                                    <i class="fa fa-history"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="quick-actions">
            <h3>Quick Actions</h3>
            <div class="action-cards">
                <div class="action-card critical" onclick="viewLowStock()">
                    <i class="fa fa-exclamation-triangle"></i>
                    <div class="action-content">
                        <h4>Low Stock Alert</h4>
                        <p>23 items need immediate attention</p>
                    </div>
                </div>
                <div class="action-card warning" onclick="viewExpiring()">
                    <i class="fa fa-calendar-times"></i>
                    <div class="action-content">
                        <h4>Expiring Items</h4>
                        <p>8 items expire within 30 days</p>
                    </div>
                </div>
                <div class="action-card info" onclick="viewControlled()">
                    <i class="fa fa-lock"></i>
                    <div class="action-content">
                        <h4>Controlled Substances</h4>
                        <p>Review controlled medication inventory</p>
                    </div>
                </div>
                <div class="action-card success" onclick="generateReport()">
                    <i class="fa fa-chart-bar"></i>
                    <div class="action-content">
                        <h4>Monthly Report</h4>
                        <p>Generate inventory usage report</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
