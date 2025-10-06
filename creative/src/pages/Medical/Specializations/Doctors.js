import React, { useEffect, useMemo, useState } from 'react';
import { Col, Container, Row, Card, CardBody, CardHeader, Button } from 'reactstrap';
import BreadCrumb from '../../../Components/Common/BreadCrumb';
import TableContainer from '../../../Components/Common/TableContainerReactTable';
import { useParams, useNavigate } from 'react-router-dom';
import API from '../../../helpers/api';
import { IndeterminateCheckbox } from '../../../Components/Common/IndeterminateCheckbox';

const SpecializationDoctors = () => {
  document.title = 'Specialization Doctors | Medical Management';
  const { id } = useParams();
  const navigate = useNavigate();
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(false);
  const [rowSelection, setRowSelection] = useState({});
  const [specializationName, setSpecializationName] = useState('');

  const fetchDoctors = async () => {
    setLoading(true);
    try {
      const response = await API.get(`/medical/specializations/${id}/doctors`);
      setData(response.data.data);
    } finally {
      setLoading(false);
    }
  };

  const fetchSpecializationName = async () => {
    try {
      const response = await API.get(`/medical/specializations/${id}`);
      setSpecializationName(response.data.data.name);
    } catch {
      setSpecializationName('');
    }
  };

  useEffect(() => {
    fetchDoctors();
    fetchSpecializationName();
    // eslint-disable-next-line
  }, [id]);

  const columns = useMemo(() => [
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
  ], []);

  const handleBulkDelete = async () => {
    const ids = Object.keys(rowSelection);
    if (ids.length === 0) return;
    if (window.confirm('Are you sure you want to delete the selected doctors?')) {
      await Promise.all(ids.map(id => API.delete(`/api/doctors/${id}`)));
      setRowSelection({});
      fetchDoctors();
    }
  };

  return (
    <React.Fragment>
      <div className="page-content">
        <Container fluid>
          <BreadCrumb title="Doctors" pageTitle="Specializations" />
          <Row>
            <Col xs={12}>
              <Button color="secondary" onClick={() => navigate(-1)} className="mb-3">Back</Button>
              <Card>
                <CardHeader>
                  <h5 className="card-title mb-0">Doctors for Specialization: {specializationName || id}</h5>
                </CardHeader>
                <CardBody>
                  <TableContainer
                    columns={columns}
                    data={data}
                    loading={loading}
                    rowSelection={rowSelection}
                    onRowSelectionChange={setRowSelection}
                    isGlobalFilter={true}
                    SearchPlaceholder="Search Doctors..."
                    searchActions={
                      Object.keys(rowSelection).length > 0 && (
                        <Button color="danger" className="ms-2" onClick={handleBulkDelete}>
                          Bulk Delete
                        </Button>
                      )
                    }
                  />
                </CardBody>
              </Card>
            </Col>
          </Row>
        </Container>
      </div>
    </React.Fragment>
  );
};

export default SpecializationDoctors; 