import React, { useEffect, useMemo, useState } from 'react';
import { Col, Container, Row, Card, CardBody, CardHeader, Button, Modal, ModalHeader, ModalBody, ModalFooter, Form, FormGroup, Label, Input } from 'reactstrap';
import BreadCrumb from '../../../Components/Common/BreadCrumb';
import TableContainer from '../../../Components/Common/TableContainerReactTable';
import { Link, useNavigate } from 'react-router-dom';
import API from '../../../helpers/api';
import { IndeterminateCheckbox } from '../../../Components/Common/IndeterminateCheckbox';
import DeleteModal from '../../../Components/Common/DeleteModal';

const SpecializationsIndex = () => {
  document.title = 'Specializations | Medical Management';
  const navigate = useNavigate();
  const [data, setData] = useState([]);
  const [meta, setMeta] = useState({ current_page: 1, last_page: 1, per_page: 10, total: 0 });
  const [loading, setLoading] = useState(false);
  const [search, setSearch] = useState('');
  const [selected, setSelected] = useState([]);
  const [rowSelection, setRowSelection] = useState({});
  const [addModalOpen, setAddModalOpen] = useState(false);
  const [newName, setNewName] = useState('');
  const [addLoading, setAddLoading] = useState(false);
  const [addError, setAddError] = useState('');
  const [deleteModalOpen, setDeleteModalOpen] = useState(false);
  const [deleteId, setDeleteId] = useState(null);

  const fetchData = async (page = 1, perPage = 10, searchValue = '') => {
    setLoading(true);
    try {
      const params = { page, per_page: perPage };
      if (searchValue) params.q = searchValue;
      const url = searchValue
        ? `/medical/specializations/search?q=${encodeURIComponent(searchValue)}`
        : `/medical/specializations?page=${page}&per_page=${perPage}`;
      const response = await API.get(url);
      if (searchValue && response.data.data) {
        setData(response.data.data);
        setMeta({
          current_page: 1,
          last_page: 1,
          per_page: perPage,
          total: response.data.data.length,
        });
      } else {
        setData(response.data.data);
        setMeta(response.data.meta);
      }
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchData();
  }, []);

  const columns = useMemo(
    () => [
      {
        id: 'select',
        header: ({ table }) => (
          <IndeterminateCheckbox
            {...{
              checked: table.getIsAllPageRowsSelected(),
              indeterminate: table.getIsSomePageRowsSelected(),
              onChange: table.getToggleAllPageRowsSelectedHandler(),
            }}
          />
        ),
        cell: ({ row }) => (
          <IndeterminateCheckbox
            {...{
              checked: row.getIsSelected(),
              disabled: !row.getCanSelect(),
              indeterminate: row.getIsSomeSelected(),
              onChange: row.getToggleSelectedHandler(),
            }}
          />
        ),
        enableSorting: false,
        enableColumnFilter: false,
      },
      {
        header: 'ID',
        accessorKey: 'id',
        enableColumnFilter: false,
        cell: info => info.getValue(),
      },
      {
        header: 'Name',
        accessorKey: 'name',
        enableColumnFilter: false,
        cell: info => info.getValue(),
      },
      {
        header: 'Actions',
        id: 'actions',
        enableColumnFilter: false,
        cell: ({ row }) => renderActions(row.original),
      },
    ],
    []
  );

  const renderActions = (specialization) => (
    <div className="d-flex gap-2">
      <Button size="sm" color="info" onClick={() => navigate(`/medical/specializations/${specialization.id}/doctors`)}>
        Show Doctors
      </Button>
      <Button size="sm" color="primary" onClick={() => navigate(`/medical/specializations/${specialization.id}/edit`)}>
        Edit
      </Button>
      <Button size="sm" color="danger" onClick={() => handleDelete(specialization.id)}>
        Delete
      </Button>
    </div>
  );

  const handleDelete = (id) => {
    setDeleteId(id);
    setDeleteModalOpen(true);
  };

  const confirmDelete = async () => {
    if (!deleteId) return;
    await API.delete(`/medical/specializations/${deleteId}`);
    setDeleteModalOpen(false);
    setDeleteId(null);
    fetchData(meta.current_page, meta.per_page, search);
  };

  const cancelDelete = () => {
    setDeleteModalOpen(false);
    setDeleteId(null);
  };

  const handlePageChange = (page) => {
    fetchData(page, meta.per_page, search);
  };

  const handleSearch = (value) => {
    setSearch(value);
    fetchData(1, meta.per_page, value);
  };

  const handleBulkDelete = async () => {
    const ids = Object.keys(rowSelection);
    if (ids.length === 0) return;
    if (window.confirm('Are you sure you want to delete the selected specializations?')) {
      await Promise.all(ids.map(id => API.delete(`/medical/specializations/${id}`)));
      setRowSelection({});
      fetchData(meta.current_page, meta.per_page, search);
    }
  };

  const handleAddSpecialization = async (e) => {
    e.preventDefault();
    setAddLoading(true);
    setAddError('');
    try {
      await API.post('/medical/specializations', { name: newName });
      setAddModalOpen(false);
      setNewName('');
      fetchData(meta.current_page, meta.per_page, search);
    } catch (err) {
      setAddError(err.response?.data?.message || 'Failed to add specialization');
    } finally {
      setAddLoading(false);
    }
  };

  const handlePageSizeChange = (newPageSize) => {
    fetchData(1, newPageSize, search);
    setMeta((prev) => ({ ...prev, per_page: newPageSize }));
  };

  const isGlobalFilter = true; // Assuming global filter is always present

  return (
    <React.Fragment>
      <div className="page-content">
        <Container fluid>
          <BreadCrumb title="Specializations" pageTitle="Medical Management" />
          <Row className="mb-3">
            <Col xs="auto">
              <Button color="success" onClick={() => setAddModalOpen(true)}>
                <i className="ri-add-line align-bottom me-1"></i> Add
              </Button>
            </Col>
          </Row>
          <Row>
            <Col xs={12}>
              <Card>
                <CardHeader>
                  <h5 className="card-title mb-0">Specializations</h5>
                </CardHeader>
                <CardBody>
                  <TableContainer
                    columns={columns}
                    data={data}
                    customPageSize={meta.per_page}
                    isGlobalFilter={true}
                    SearchPlaceholder="Search Specializations..."
                    loading={loading}
                    totalRecords={meta.total}
                    currentPage={meta.current_page}
                    onPageChange={(page) => fetchData(page, meta.per_page, search)}
                    onPageSizeChange={(perPage) => fetchData(1, perPage, search)}
                    onSearch={(searchValue) => fetchData(1, meta.per_page, searchValue)}
                    rowSelection={rowSelection}
                    onRowSelectionChange={setRowSelection}
                    searchActions={
                      Object.keys(rowSelection).length > 0 && (
                        <Button color="danger" className="ms-2" onClick={handleBulkDelete}>
                          Bulk Delete
                        </Button>
                      )
                    }
                  />
                  <DeleteModal
                    show={deleteModalOpen}
                    onDeleteClick={confirmDelete}
                    onCloseClick={cancelDelete}
                  />
                  <Modal isOpen={addModalOpen} toggle={() => setAddModalOpen(!addModalOpen)} centered>
                    <ModalHeader toggle={() => setAddModalOpen(!addModalOpen)}>Add Specialization</ModalHeader>
                    <Form onSubmit={handleAddSpecialization}>
                      <ModalBody>
                        <FormGroup>
                          <Label for="specializationName">Name</Label>
                          <Input
                            id="specializationName"
                            value={newName}
                            onChange={e => setNewName(e.target.value)}
                            required
                            placeholder="Enter specialization name"
                            disabled={addLoading}
                          />
                        </FormGroup>
                        {addError && <div className="text-danger mt-2">{addError}</div>}
                      </ModalBody>
                      <ModalFooter>
                        <Button color="secondary" onClick={() => setAddModalOpen(false)} disabled={addLoading}>Cancel</Button>
                        <Button color="success" type="submit" disabled={addLoading}>
                          {addLoading ? 'Adding...' : 'Add'}
                        </Button>
                      </ModalFooter>
                    </Form>
                  </Modal>
                </CardBody>
              </Card>
            </Col>
          </Row>
        </Container>
      </div>
    </React.Fragment>
  );
};

export default SpecializationsIndex; 