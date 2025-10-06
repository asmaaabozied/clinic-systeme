import React, { useState, useRef } from 'react';
import { Card, CardBody, CardHeader, Col, Container, Row, Button, Modal, ModalHeader, ModalBody, ModalFooter, Form, FormGroup, Label, Input } from 'reactstrap';
import DataTableComponent from '../../Components/Common/DataTableComponent';
import API from '../../helpers/api';
import { toast, ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import DeleteModal from '../../Components/Common/DeleteModal';

const DoseIntervalsDataTable = () => {
    const [modal, setModal] = useState(false);
    const [editModal, setEditModal] = useState(false);
    const [deleteModal, setDeleteModal] = useState(false);
    const [selectedDoseInterval, setSelectedDoseInterval] = useState(null);
    const [formData, setFormData] = useState({ name: '' });
    const dataTableInstanceRef = useRef(null);
    const [deleteModalOpen, setDeleteModalOpen] = useState(false);
    const [deleteId, setDeleteId] = useState(null);

    // DataTables columns configuration
    const columns = [
        {
            data: 'id',
            title: 'ID',
            width: '80px'
        },
        {
            data: 'name',
            title: 'Dose Interval Name',
            width: '200px'
        },
        {
            data: 'created_at',
            title: 'Created At',
            width: '150px',
            render: function(data) {
                return new Date(data).toLocaleDateString();
            }
        },
        {
            data: 'actions',
            title: 'Actions',
            width: '200px',
            orderable: false,
            searchable: false
        }
    ];

    const toggleModal = () => setModal(!modal);
    const toggleEditModal = () => setEditModal(!editModal);
    const toggleDeleteModal = () => setDeleteModal(!deleteModal);

    const handleInputChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const response = await API.post('/medical/dose-intervals', formData);
            toast.success(response.data.message || 'Dose interval created successfully');
            setFormData({ name: '' });
            toggleModal();
            // Refresh the DataTable
            if (dataTableInstanceRef.current) {
                dataTableInstanceRef.current.ajax.reload();
            }
        } catch (error) {
            toast.error(error.response?.data?.message || 'Error creating dose interval');
        }
    };

    const handleEdit = async (e) => {
        e.preventDefault();
        try {
            const response = await API.put(`/medical/dose-intervals/${selectedDoseInterval.id}`, formData);
            toast.success(response.data.message || 'Dose interval updated successfully');
            setFormData({ name: '' });
            setSelectedDoseInterval(null);
            toggleEditModal();
            // Refresh the DataTable
            if (dataTableInstanceRef.current) {
                dataTableInstanceRef.current.ajax.reload();
            }
        } catch (error) {
            toast.error(error.response?.data?.message || 'Error updating dose interval');
        }
    };

    const openDeleteModal = (id, name) => {
        setSelectedDoseInterval({ id, name });
        setDeleteId(id);
        setDeleteModalOpen(true);
    };

    const closeDeleteModal = () => {
        setDeleteModalOpen(false);
        setDeleteId(null);
        setSelectedDoseInterval(null);
    };

    const handleDelete = async () => {
        if (!deleteId) return;
        try {
            const response = await API.delete(`/medical/dose-intervals/${deleteId}`);
            toast.success(response.data.message || 'Dose interval deleted successfully');
            closeDeleteModal();
            setTimeout(() => {
                if (dataTableInstanceRef.current) {
                    dataTableInstanceRef.current.ajax.reload(null, false);
                }
            }, 300);
        } catch (error) {
            toast.error(error.response?.data?.message || 'Error deleting dose interval');
        }
    };

    const openEditModal = (id, name) => {
        setSelectedDoseInterval({ id, name });
        setFormData({ name });
        toggleEditModal();
    };

    const handleInstanceReady = (dt) => {
        dataTableInstanceRef.current = dt;
    };

    // Global functions for DataTables actions
    React.useEffect(() => {
        window.editDoseInterval = openEditModal;
        window.deleteDoseInterval = openDeleteModal;
    }, []);

    return (
        <div className="page-content">
            <ToastContainer position="top-right" autoClose={3000} hideProgressBar newestOnTop closeOnClick rtl={false} pauseOnFocusLoss draggable pauseOnHover />
            <Container fluid>
                <Row>
                    <Col lg={12}>
                        <Card>
                            <CardHeader className="d-flex justify-content-between align-items-center">
                                <h4 className="card-title mb-0">Dose Intervals (DataTables.net)</h4>
                                <Button color="primary" onClick={toggleModal}>
                                    <i className="ri-add-line align-bottom me-1"></i>
                                    Add Dose Interval
                                </Button>
                            </CardHeader>
                            <CardBody>
                                <DataTableComponent
                                    columns={columns.map(col =>
                                        col.data === 'actions'
                                            ? {
                                                ...col,
                                                render: (data, type, row) => (
                                                    `<div class='d-flex gap-2'>
                                                        <button class='btn btn-warning btn-sm' data-action='edit' data-id='${row.id}' data-name='${row.name}'>Edit</button>
                                                        <button class='btn btn-danger btn-sm' data-action='delete' data-id='${row.id}' data-name='${row.name}'>Delete</button>
                                                    </div>`
                                                )
                                            }
                                            : col
                                    )}
                                    ajaxUrl="/medical/dose-intervals-datatable"
                                    className="table table-bordered dt-responsive nowrap table-striped align-middle"
                                    selectable={true}
                                    pageSize={10}
                                    searchable={true}
                                    orderable={true}
                                    pagination={true}
                                    info={true}
                                    responsive={true}
                                    options={{
                                        dom: 'Bfrtip',
                                        buttons: [
                                            'copy', 'csv', 'excel', 'pdf', 'print'
                                        ],
                                        createdRow: (row, data) => {
                                            row.querySelectorAll('button[data-action]').forEach(btn => {
                                                btn.onclick = (e) => {
                                                    const action = btn.getAttribute('data-action');
                                                    const id = btn.getAttribute('data-id');
                                                    const name = btn.getAttribute('data-name');
                                                    if (action === 'edit') {
                                                        openEditModal(id, name);
                                                    } else if (action === 'delete') {
                                                        openDeleteModal(id, name);
                                                    }
                                                };
                                            });
                                        }
                                    }}
                                    onInstanceReady={handleInstanceReady}
                                />
                                <DeleteModal
                                    show={deleteModalOpen}
                                    onDeleteClick={handleDelete}
                                    onCloseClick={closeDeleteModal}
                                />
                            </CardBody>
                        </Card>
                    </Col>
                </Row>
            </Container>

            {/* Add Dose Interval Modal */}
            <Modal isOpen={modal} toggle={toggleModal} size="md">
                <ModalHeader toggle={toggleModal}>Add New Dose Interval</ModalHeader>
                <ModalBody>
                    <Form onSubmit={handleSubmit}>
                        <FormGroup>
                            <Label for="name">Dose Interval Name</Label>
                            <Input
                                id="name"
                                name="name"
                                type="text"
                                value={formData.name}
                                onChange={handleInputChange}
                                required
                            />
                        </FormGroup>
                    </Form>
                </ModalBody>
                <ModalFooter>
                    <Button color="secondary" onClick={toggleModal}>Cancel</Button>
                    <Button color="primary" onClick={handleSubmit}>Save</Button>
                </ModalFooter>
            </Modal>

            {/* Edit Dose Interval Modal */}
            <Modal isOpen={editModal} toggle={toggleEditModal} size="md">
                <ModalHeader toggle={toggleEditModal}>Edit Dose Interval</ModalHeader>
                <ModalBody>
                    <Form onSubmit={handleEdit}>
                        <FormGroup>
                            <Label for="editName">Dose Interval Name</Label>
                            <Input
                                id="editName"
                                name="name"
                                type="text"
                                value={formData.name}
                                onChange={handleInputChange}
                                required
                            />
                        </FormGroup>
                    </Form>
                </ModalBody>
                <ModalFooter>
                    <Button color="secondary" onClick={toggleEditModal}>Cancel</Button>
                    <Button color="primary" onClick={handleEdit}>Update</Button>
                </ModalFooter>
            </Modal>

            {/* Delete Confirmation Modal */}
            <Modal isOpen={deleteModal} toggle={toggleDeleteModal} size="sm">
                <ModalHeader toggle={toggleDeleteModal}>Confirm Delete</ModalHeader>
                <ModalBody>
                    Are you sure you want to delete "{selectedDoseInterval?.name}"?
                </ModalBody>
                <ModalFooter>
                    <Button color="secondary" onClick={toggleDeleteModal}>Cancel</Button>
                    <Button color="danger" onClick={handleDelete}>Delete</Button>
                </ModalFooter>
            </Modal>
        </div>
    );
};

export default DoseIntervalsDataTable;
