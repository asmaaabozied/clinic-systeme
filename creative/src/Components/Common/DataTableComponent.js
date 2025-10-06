import React, { useRef, useEffect, useState } from 'react';
import DataTable from 'datatables.net-react';
import DT from 'datatables.net-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.css';
import 'datatables.net-buttons-bs5';
import 'datatables.net-select-bs5';
import 'datatables.net-responsive-bs5';
import API from '../../helpers/api';

// Register DataTables with Bootstrap 5 styling
DataTable.use(DT);

const DataTableComponent = ({
    columns,
    ajaxUrl,
    className = 'display',
    options = {},
    onRowClick,
    onSelectionChange,
    selectable = false,
    pageSize = 10,
    searchable = true,
    orderable = true,
    pagination = true,
    info = true,
    lengthMenu = [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
    dom = 'Bfrtip',
    buttons = ['copy', 'csv', 'excel', 'pdf', 'print'],
    responsive = true,
    language = {
        search: "Search:",
        lengthMenu: "Show _MENU_ entries",
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        infoEmpty: "Showing 0 to 0 of 0 entries",
        infoFiltered: "(filtered from _MAX_ total entries)",
        zeroRecords: "No matching records found",
        paginate: {
            first: "First",
            last: "Last",
            next: "Next",
            previous: "Previous"
        }
    },
    onInstanceReady // <-- new prop
}) => {
    const tableRef = useRef();
    const [tableInstance, setTableInstance] = useState(null);

    // Default DataTables options
    const defaultOptions = {
        processing: true,
        serverSide: true,
        ajax: function(data, callback) {
            API.get(ajaxUrl, { params: data })
                .then(response => {
                    callback(response.data);
                })
                .catch(() => {
                    callback({ data: [], recordsTotal: 0, recordsFiltered: 0 });
                });
        },
        columns: columns,
        pageLength: pageSize,
        lengthMenu: lengthMenu,
        searching: searchable,
        ordering: orderable,
        paging: pagination,
        info: info,
        dom: dom,
        buttons: buttons,
        responsive: responsive,
        language: language,
        select: selectable ? {
            style: 'multi',
            selector: 'td:first-child input[type="checkbox"]'
        } : false,
        order: [[0, 'asc']],
        ...options
    };

    useEffect(() => {
        if (tableRef.current && tableRef.current.dt) {
            const dt = tableRef.current.dt();
            setTableInstance(dt);
            if (typeof onInstanceReady === 'function') {
                onInstanceReady(dt);
            }
        }
    }, []);

    // Handle row click
    const handleRowClick = (event, data) => {
        if (onRowClick) {
            onRowClick(data);
        }
    };

    // Handle selection change
    const handleSelectionChange = (event, dt) => {
        if (onSelectionChange) {
            const selectedRows = dt.rows({ selected: true }).data().toArray();
            onSelectionChange(selectedRows);
        }
    };

    return (
        <div className="datatable-wrapper">
            <DataTable
                ref={tableRef}
                className={className}
                options={defaultOptions}
                onRowClick={handleRowClick}
                onSelect={handleSelectionChange}
            />
        </div>
    );
};

export default DataTableComponent; 