import React, { useEffect, useMemo, useState } from 'react';
import { Col, Container, Row, Card, CardBody, CardHeader, Button, Modal, ModalHeader, ModalBody, ModalFooter, Form, FormGroup, Label, Input } from 'reactstrap';
import BreadCrumb from '../../../Components/Common/BreadCrumb';
import TableContainer from '../../../Components/Common/TableContainerReactTable';
import { Link, useNavigate } from 'react-router-dom';
import API from '../../../helpers/api';
import { IndeterminateCheckbox } from '../../../Components/Common/IndeterminateCheckbox';
import DeleteModal from '../../../Components/Common/DeleteModal';

const MedicineCategoriesIndex = () => {
  document.title = 'Medicine Categories | Medical Management';
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
  const [editModalOpen, setEditModalOpen] = useState(false);
  const [editId, setEditId] = useState(null);
  const [editName, setEditName] = useState('');
  const [editLoading, setEditLoading] = useState(false);
  const [editError, setEditError] = useState('');

  const fetchData = async (page = 1, perPage = 10, searchValue = '') => {
    setLoading(true);
    try {
      const response = await API.get(`/medical/medicine-categories?page=${page}&per_page=${perPage}`);
      setData(response.data.data);
      setMeta(response.data.meta);
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

  const renderActions = (medicineCategory) => (
    <div className="d-flex gap-2">
      <Button size="sm" color="primary" onClick={() => handleEdit(medicineCategory.id, medicineCategory.name)}>
        Edit
      </Button>
      <Button size="sm" color="danger" onClick={() => handleDelete(medicineCategory.id)}>
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
    await API.delete(`/medical/medicine-categories/${deleteId}`);
    setDeleteModalOpen(false);
    setDeleteId(null);
    fetchData(meta.current_page, meta.per_page, search);
  };

  const cancelDelete = () => {
    setDeleteModalOpen(false);
    setDeleteId(null);
  };

  const handleEdit = (id, name) => {
    setEditId(id);
    setEditName(name);
    setEditModalOpen(true);
  };

  const handleUpdate = async (e) => {
    e.preventDefault();
    setEditLoading(true);
    setEditError('');
    try {
      await API.put(`/medical/medicine-categories/${editId}`, { name: editName });
      setEditModalOpen(false);
      setEditId(null);
      setEditName('');
      fetchData(meta.current_page, meta.per_page, search);
    } catch (err) {
      setEditError(err.response?.data?.message || 'Failed to update medicine category');
    } finally {
      setEditLoading(false);
    }
  };

  const handlePageChange = (page) => {
    fetchData(page, meta.per_page, search);
  };

  const handleSearch = (value) => {
    setSearch(value);
    // For now, we'll just filter client-side since we removed the search API
    // You can implement client-side filtering here if needed
  };

  const handleBulkDelete = async () => {
    const ids = Object.keys(rowSelection);
    if (ids.length === 0) return;
    if (window.confirm('Are you sure you want to delete the selected medicine categories?')) {
      await Promise.all(ids.map(id => API.delete(`/medical/medicine-categories/${id}`)));
      setRowSelection({});
      fetchData(meta.current_page, meta.per_page, search);
    }
  };

  const handleAddMedicineCategory = async (e) => {
    e.preventDefault();
    setAddLoading(true);
    setAddError('');
    try {
      await API.post('/medical/medicine-categories', { name: newName });
      setAddModalOpen(false);
      setNewName('');
      fetchData(meta.current_page, meta.per_page, search);
    } catch (err) {
      setAddError(err.response?.data?.message || 'Failed to add medicine category');
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
          <BreadCrumb title="Medicine Categories" pageTitle="Medical Management" />
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
                  <h5 className="card-title mb-0">Medicine Categories</h5>
                </CardHeader>
                <CardBody>
                  <TableContainer
                    columns={columns}
                    data={data}
                    customPageSize={meta.per_page}
                    tableClass="table-nowrap table-hover"
                    isGlobalFilter={isGlobalFilter}
                    isAddOptions={false}
                    isCustomPageSize={true}
                    isBordered={false}
                    isHover={true}
                    isResponsive={true}
                    isPagination={true}
                    isSelectable={true}
                    isSearched={true}
                    searchPlaceholder="Search for medicine categories..."
                    handleSearch={handleSearch}
                    handlePageChange={handlePageChange}
                    handlePageSizeChange={handlePageSizeChange}
                    paginationMeta={meta}
                    loading={loading}
                    rowSelection={rowSelection}
                    setRowSelection={setRowSelection}
                    bulkDelete={handleBulkDelete}
                  />
                </CardBody>
              </Card>
            </Col>
          </Row>
        </Container>
      </div>

      {/* Add Medicine Category Modal */}
      <Modal isOpen={addModalOpen} toggle={() => setAddModalOpen(!addModalOpen)}>
        <ModalHeader toggle={() => setAddModalOpen(!addModalOpen)}>
          Add Medicine Category
        </ModalHeader>
        <Form onSubmit={handleAddMedicineCategory}>
          <ModalBody>
            <FormGroup>
              <Label for="name">Name</Label>
              <Input
                id="name"
                name="name"
                type="text"
                value={newName}
                onChange={(e) => setNewName(e.target.value)}
                required
              />
            </FormGroup>
            {addError && <div className="text-danger">{addError}</div>}
          </ModalBody>
          <ModalFooter>
            <Button color="primary" type="submit" disabled={addLoading}>
              {addLoading ? 'Adding...' : 'Add'}
            </Button>
            <Button color="secondary" onClick={() => setAddModalOpen(false)}>
              Cancel
            </Button>
          </ModalFooter>
        </Form>
      </Modal>

      {/* Edit Medicine Category Modal */}
      <Modal isOpen={editModalOpen} toggle={() => setEditModalOpen(!editModalOpen)}>
        <ModalHeader toggle={() => setEditModalOpen(!editModalOpen)}>
          Edit Medicine Category
        </ModalHeader>
        <Form onSubmit={handleUpdate}>
          <ModalBody>
            <FormGroup>
              <Label for="editName">Name</Label>
              <Input
                id="editName"
                name="editName"
                type="text"
                value={editName}
                onChange={(e) => setEditName(e.target.value)}
                required
              />
            </FormGroup>
            {editError && <div className="text-danger">{editError}</div>}
          </ModalBody>
          <ModalFooter>
            <Button color="primary" type="submit" disabled={editLoading}>
              {editLoading ? 'Updating...' : 'Update'}
            </Button>
            <Button color="secondary" onClick={() => setEditModalOpen(false)}>
              Cancel
            </Button>
          </ModalFooter>
        </Form>
      </Modal>

      {/* Delete Confirmation Modal */}
      <DeleteModal
        show={deleteModalOpen}
        onDeleteClick={confirmDelete}
        onCloseClick={cancelDelete}
      />
    </React.Fragment>
  );
};

export default MedicineCategoriesIndex; 