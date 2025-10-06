import React, { useState, useEffect } from 'react';
import { Card, CardBody, Col, Container, Row, Button } from 'reactstrap';
import DataTableComponent from '../../Components/Common/DataTableComponent';
import AddPatientModal from './AddPatientModal';
import API from '../../helpers/api';
import { toast, ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

const PatientsDataTable = () => {
    const [modal, setModal] = useState(false);
    const [nextPatientCode, setNextPatientCode] = useState('');
    const [dataTableInstance, setDataTableInstance] = useState(null);

    const columns = [
        { data: 'id', title: 'ID' },
        { data: 'code', title: 'Code' },
        { data: 'name', title: 'Name' },
        { data: 'guardian_name', title: 'Guardian Name' },
        { data: 'gender', title: 'Gender' },
        { data: 'phone', title: 'Phone' },
        { data: 'last_visit', title: 'Last Visit' },
        {
            data: 'action',
            title: 'Action',
            orderable: false,
            searchable: false,
        },
    ];

    const fetchNextPatientCode = async () => {
        try {
            const response = await API.get('/opd/patients/next-code');
            if (response.data.success) {
                setNextPatientCode(response.data.next_code);
            }
        } catch (error) {
            console.error('Error fetching next patient code:', error);
        }
    };

    const toggleModal = () => {
        if (!modal) {
            fetchNextPatientCode();
        }
        setModal(!modal);
    };

    const handleSavePatient = async (formData) => {
        try {
            const response = await API.post('/opd/patients', formData);
            toast.success(response.data.message || 'Patient created successfully');
            toggleModal();

            // Refresh the DataTable
            if (dataTableInstance) {
                dataTableInstance.ajax.reload();
            }
        } catch (error) {
            const errorMessage = error.response?.data?.message || 'Error creating patient';
            toast.error(errorMessage);
            console.error('Error saving patient:', error);
        }
    };

    const handleInstanceReady = (dt) => {
        setDataTableInstance(dt);
    };

    return (
        <div className="page-content">
            <ToastContainer position="top-right" autoClose={3000} hideProgressBar newestOnTop closeOnClick rtl={false} pauseOnFocusLoss draggable pauseOnHover />
            <Container fluid>
                <Row>
                    <Col lg={12}>
                        <Card>
                            <CardBody>
                                <div className="d-flex justify-content-end mb-4">
                                    <Button color="primary" onClick={toggleModal}>
                                        <i className="ri-add-line align-bottom me-1"></i>
                                        Add Patient
                                    </Button>
                                </div>
                                <h4 className="card-title mb-4">OPD Patients</h4>
                                <DataTableComponent
                                    columns={columns}
                                    ajaxUrl="/opd/patients-datatable"
                                    className="table table-bordered dt-responsive nowrap table-striped align-middle"
                                    exportButtons={true}
                                    searchable={true}
                                    pagination={true}
                                    responsive={true}
                                    onInstanceReady={handleInstanceReady}
                                />
                                <AddPatientModal
                                    isOpen={modal}
                                    toggle={toggleModal}
                                    patientCode={nextPatientCode}
                                    onSave={handleSavePatient}
                                />
                            </CardBody>
                        </Card>
                    </Col>
                </Row>
            </Container>
        </div>
    );
};

export default PatientsDataTable;
