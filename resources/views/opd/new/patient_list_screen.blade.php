@extends('layouts.admin')

@section('content')
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-icon {
            width: 32px;
            height: 32px;
            fill: currentColor;
        }

        .header-actions {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .btn-primary:hover {
            background: rgba(255,255,255,0.3);
        }

        .btn-success {
            background: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background: #229954;
        }

        .content {
            padding: 30px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
        }

        .patient-stats {
            display: flex;
            gap: 30px;
            font-size: 14px;
            color: #7f8c8d;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stat-number {
            font-weight: 600;
            color: #2c3e50;
        }

        .controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .search-controls {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .search-box {
            position: relative;
        }

        .search-input {
            padding: 12px 40px 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            width: 300px;
            transition: all 0.2s;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            fill: #999;
        }

        .filter-select {
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            cursor: pointer;
        }

        .filter-select:focus {
            outline: none;
            border-color: #667eea;
        }

        .view-controls {
            display: flex;
            gap: 10px;
        }

        .view-btn {
            padding: 8px 12px;
            border: 2px solid #ddd;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .view-btn.active {
            border-color: #667eea;
            background: #667eea;
            color: white;
        }

        .view-btn:hover {
            border-color: #667eea;
        }

        .patients-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #eee;
        }

        .table-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px 25px;
            border-bottom: 2px solid #dee2e6;
        }

        .table-title {
            font-size: 18px;
            font-weight: 600;
            color: #495057;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f8f9fa;
        }

        th {
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 18px 20px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
            vertical-align: middle;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .patient-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .patient-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .patient-details h4 {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 2px;
        }

        .patient-details p {
            color: #7f8c8d;
            font-size: 12px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.2s;
        }

        .btn-edit {
            background: #3498db;
            color: white;
        }

        .btn-edit:hover {
            background: #2980b9;
        }

        .btn-view {
            background: #95a5a6;
            color: white;
        }

        .btn-view:hover {
            background: #7f8c8d;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 25px;
            background: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        .pagination-info {
            font-size: 14px;
            color: #6c757d;
        }

        .pagination-controls {
            display: flex;
            gap: 5px;
        }

        .page-btn {
            padding: 8px 12px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .page-btn:hover {
            background: #f8f9fa;
        }

        .page-btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #7f8c8d;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            opacity: 0.3;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 1000;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .notification.success {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        }

        .notification.show {
            opacity: 1;
            transform: translateX(0);
        }

        @media (max-width: 1200px) {
            .search-input {
                width: 250px;
            }
        }

        @media (max-width: 768px) {
            .content {
                padding: 20px 15px;
            }

            .controls {
                flex-direction: column;
                gap: 15px;
            }

            .search-controls {
                flex-direction: column;
                width: 100%;
            }

            .search-input {
                width: 100%;
            }

            .patients-table {
                overflow-x: auto;
            }

            table {
                min-width: 800px;
            }
        }
    .hover-icon-cell {
        position: relative;
    }

    .hover-icon-cell .icon-value {
        display: none;
    }

    .hover-icon-cell:hover .text-value {
        display: none;
    }

    .hover-icon-cell:hover .icon-value {
        display: inline-block;
</style>

<div class="container">
    <div class="header">
        <div class="header-content">
            <h1>
                <svg class="header-icon" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                Healthcare Management System
            </h1>
            <div class="header-actions">
                <a href="{{ route('opd.register') }}" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    New Patient
                </a>
                <button class="btn btn-primary" onclick="exportPatients()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                    </svg>
                    Export
                </button>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="page-header">
            <h2 class="page-title">Patient Directory</h2>
            <div class="patient-stats">
                <div class="stat-item">
                    <span>Total Patients:</span>
                    <span class="stat-number" id="totalPatients">{{ $patients->total() }}</span>
                </div>
                <div class="stat-item">
                    <span>Active:</span>
                    <span class="stat-number" id="activePatients">{{ $patients->count() }}</span>
                </div>
                <div class="stat-item">
                    <span>New This Month:</span>
                    <span class="stat-number" id="newPatients">0</span>
                </div>
            </div>
        </div>

        <div class="controls">
            <div class="search-controls">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Search patients..." id="searchInput">
                    <svg class="search-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z"/>
                    </svg>
                </div>
                <select class="filter-select" id="statusFilter">
                    <option value="">All Patients</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="pending">Pending</option>
                </select>
                <select class="filter-select" id="genderFilter">
                    <option value="">All Genders</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
{{--            <div class="view-controls">--}}
{{--                <button class="view-btn active" onclick="setView('table')">Table</button>--}}
{{--                <button class="view-btn" onclick="setView('grid')">Grid</button>--}}
{{--            </div>--}}
        </div>

        <div class="patients-table">
            <div class="table-header">
                <h3 class="table-title">Registered Patients</h3>
            </div>
            <div id="patientsTableContainer">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Patient Id</th>
                            <th>Guardian Name</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Consultant</th>
                            <th>Last Visit</th>
                            <th>Total Recheckup</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $patient)
                        <tr>
                            <td>{{ $patient->name }}</td>
                            <td>{{ $patient->patient_code }}</td>
                            <td>{{ $patient->guardian_name }}</td>
                            <td>{{ $patient->gender }}</td>
                            <td>{{ $patient->phone }}</td>
                            <td>{{ optional($patient->appointments->last())->doctor?->user->name }}{{ optional($patient->appointments->last())->doctor?->doctor_code ? ' (' . optional($patient->appointments->last())->doctor?->doctor_code . ')' : ' - ' }}</td>
                            <td>{{ $patient->created_at }}</td>
                            <td>{{ $patient->appointments->count() }}</td>
                            <td>
                                <a href="#" onclick="openOpdModal({{ $patient->id }})" class="icon-value btn btn-sm btn-light" title="Show">
                                    <i class="fa fa-eye"></i>
                                </a>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $patients->links() }}
            </div>
        </div>
    </div>
</div>
@include('opd.partials.opd_modal')
@endsection
