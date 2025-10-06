import React, { Fragment, useEffect, useState } from "react";
import { CardBody, Col, Row, Table } from "reactstrap";
import { Link } from "react-router-dom";

import {
  Column,
  Table as ReactTable,
  ColumnFiltersState,
  FilterFn,
  useReactTable,
  getCoreRowModel,
  getFilteredRowModel,
  getPaginationRowModel,
  getSortedRowModel,
  flexRender
} from '@tanstack/react-table';

import { rankItem } from '@tanstack/match-sorter-utils';

// Column Filter
const Filter = ({
  column,
  table
}) => {
  const columnFilterValue = column.getFilterValue();

  return (
    <>
      <DebouncedInput
        type="text"
        value= {(columnFilterValue ?? '') }
        onChange={value => column.setFilterValue(value)}
        placeholder="Search..."
        className="w-36 border shadow rounded"
        list={column.id + 'list'}
      />
      <div className="h-1" />
    </>
  );
};

// Global Filter
const DebouncedInput = ({
  value: initialValue,
  onChange,
  debounce = 500,
  ...props
}) => {
  const [value, setValue] = useState(initialValue);

  useEffect(() => {
    setValue(initialValue);
  }, [initialValue]);

  useEffect(() => {
    const timeout = setTimeout(() => {
      onChange(value);
    }, debounce);

    return () => clearTimeout(timeout);
  }, [debounce, onChange, value]);

  return (
    <input {...props} value={value} id="search-bar-0" className="form-control border-0 search" onChange={e => setValue(e.target.value)} />
  );
};

const TableContainer = ({
  columns,
  data,
  isGlobalFilter,
  customPageSize,
  tableClass,
  theadClass,
  trClass,
  thClass,
  divClass,
  SearchPlaceholder,
  searchActions, // new prop
  rowSelection,
  onRowSelectionChange,
  onPageSizeChange, // new prop
  totalRecords, // new prop
  currentPage, // new prop
  onPageChange, // new prop
}) => {
  const [columnFilters, setColumnFilters] = useState([]);
  const [globalFilter, setGlobalFilter] = useState('');
  const [pageSize, setPageSizeState] = useState(customPageSize || 10);

  const fuzzyFilter = (row, columnId, value, addMeta) => {
    const itemRank = rankItem(row.getValue(columnId), value);
    addMeta({
      itemRank
    });
    return itemRank.passed;
  };

  const table = useReactTable({
    columns,
    data,
    filterFns: {
      fuzzy: fuzzyFilter,
    },
    state: {
      columnFilters,
      globalFilter,
      rowSelection,
    },
    onColumnFiltersChange: setColumnFilters,
    onGlobalFilterChange: setGlobalFilter,
    onRowSelectionChange,
    globalFilterFn: fuzzyFilter,
    getCoreRowModel: getCoreRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    enableRowSelection: true,
  });

  const {
    getHeaderGroups,
    getRowModel,
    getCanPreviousPage,
    getCanNextPage,
    getPageOptions,
    setPageIndex,
    nextPage,
    previousPage,
    setPageSize,
    getState
  } = table;

  useEffect(() => {
    if (customPageSize) setPageSize(customPageSize);
  }, [customPageSize, setPageSize]);

  const handlePageSizeChange = (e) => {
    const value = e.target.value === 'All' ? data.length : Number(e.target.value);
    setPageSize(value);
    setPageSizeState(value);
    if (onPageSizeChange) onPageSizeChange(value);
  };
  
  // Calculate total pages for server-side pagination
  const totalPages = totalRecords && customPageSize ? Math.ceil(totalRecords / customPageSize) : 1;

  return (
    <Fragment>
      {isGlobalFilter && <Row className="mb-3">
        <CardBody className="border border-dashed border-end-0 border-start-0">
          <form>
            <Row className="align-items-center">
              <Col sm={5} className="d-flex align-items-center">
                <div className="search-box me-2 mb-2 d-inline-block col-12 d-flex align-items-center">
                  <div style={{ flex: 1, display: 'flex', alignItems: 'center' }}>
                    <DebouncedInput
                      value={globalFilter ?? ''}
                      onChange={value => setGlobalFilter((value))}
                      placeholder={SearchPlaceholder}
                    />
                    <i className="bx bx-search-alt search-icon"></i>
                  </div>
                  {searchActions && (
                    <div style={{ marginLeft: 12 }}>
                      {searchActions}
                    </div>
                  )}
                </div>
                <div className="ms-3">
                  <select className="form-select" style={{ width: 100 }} value={pageSize} onChange={handlePageSizeChange}>
                    <option value={10}>10</option>
                    <option value={25}>25</option>
                    <option value={50}>50</option>
                    <option value={100}>100</option>
                    <option value={data.length}>All</option>
                  </select>
                </div>
              </Col>
            </Row>
          </form>
        </CardBody>
      </Row>}


      <div className={divClass}>
        <Table hover className={tableClass}>
          <thead className={theadClass}>
            {getHeaderGroups().map((headerGroup) => (
              <tr className={trClass} key={headerGroup.id}>
                {headerGroup.headers.map((header) => (
                  <th key={header.id} className={thClass}  {...{
                    onClick: header.column.getToggleSortingHandler(),
                  }}>
                    {header.isPlaceholder ? null : (
                      <React.Fragment>
                        {flexRender(
                          header.column.columnDef.header,
                          header.getContext()
                        )}
                        {{
                          asc: ' ',
                          desc: ' ',
                        }
                        [header.column.getIsSorted()] ?? null}
                        {header.column.getCanFilter() ? (
                          <div>
                            <Filter column={header.column} table={table} />
                          </div>
                        ) : null}
                      </React.Fragment>
                    )}
                  </th>
                ))}
              </tr>
            ))}
          </thead>

          <tbody>
            {getRowModel().rows.map((row) => {
              return (
                <tr key={row.id}>
                  {row.getVisibleCells().map((cell) => {
                    return (
                      <td key={cell.id}>
                        {flexRender(
                          cell.column.columnDef.cell,
                          cell.getContext()
                        )}
                      </td>
                    );
                  })}
                </tr>
              );
            })}
          </tbody>
        </Table>
      </div>

      {/* Server-side pagination controls */}
      <Row className="align-items-center mt-2 g-3 text-center text-sm-start">
        <div className="col-sm">
          <div className="text-muted">
            Showing <span className="fw-semibold ms-1">{data.length}</span> of <span className="fw-semibold">{totalRecords}</span> Results
          </div>
        </div>
        <div className="col-sm-auto">
          <ul className="pagination pagination-separated pagination-md justify-content-center justify-content-sm-start mb-0">
            <li className={currentPage <= 1 ? "page-item disabled" : "page-item"}>
              <Link to="#" className="page-link" onClick={e => { e.preventDefault(); if (currentPage > 1) onPageChange(currentPage - 1); }}>Previous</Link>
            </li>
            {Array.from({ length: totalPages }, (_, i) => (
              <li key={i + 1} className={currentPage === i + 1 ? "page-item active" : "page-item"}>
                <Link to="#" className="page-link" onClick={e => { e.preventDefault(); onPageChange(i + 1); }}>{i + 1}</Link>
              </li>
            ))}
            <li className={currentPage >= totalPages ? "page-item disabled" : "page-item"}>
              <Link to="#" className="page-link" onClick={e => { e.preventDefault(); if (currentPage < totalPages) onPageChange(currentPage + 1); }}>Next</Link>
            </li>
          </ul>
        </div>
      </Row>
    </Fragment>
  );
};

export default TableContainer;