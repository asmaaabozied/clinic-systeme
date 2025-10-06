import React, { useState, useEffect } from 'react';
import { Modal, ModalHeader, ModalBody, ModalFooter, Form, FormGroup, Label, Input, Row, Col, Button } from 'reactstrap';

const AddPatientModal = ({ isOpen, toggle, patientCode, onSave }) => {
    const [form, setForm] = useState({
        first_name: '',
        second_name: '',
        third_name: '',
        family_name: '',
        name: '',
        email: '',
        dob_hijri: '',
        date_of_birth: '',
        nationality: '',
        document_type: 'National Card',
        document_id: '',
        phone: '',
        marital_status: '',
        gender: '',
        blood_group: '',
        preferred_language: 'Arabic',
        remarks: '',
        addresses: [{ street: '', city: '', postal_code: '' }],
    });

    const [ageLabel, setAgeLabel] = useState('');
    const [showHijriPicker, setShowHijriPicker] = useState(false);

    // Improved Hijri date conversion functions
    const gregorianToHijri = (gregorianDate) => {
        const date = new Date(gregorianDate);
        const year = date.getFullYear();
        const month = date.getMonth() + 1;
        const day = date.getDate();
        
        // More accurate conversion algorithm
        const jd = Math.floor((year + 4716) * 365.25) + Math.floor((month + 1) * 30.6) + day - 1524.5;
        const l = jd + 68569;
        const n = Math.floor((4 * l) / 146097);
        const l1 = l - Math.floor((146097 * n + 3) / 4);
        const i = Math.floor((4000 * (l1 + 1)) / 1461001);
        const l2 = l1 - Math.floor((1461 * i) / 4) + 31;
        const j = Math.floor((80 * l2) / 2447);
        const l3 = l2 - Math.floor((2447 * j) / 80);
        const k = j - 1;
        const j1 = j + 12 - 12 * Math.floor(j / 12);
        const m = k + 2 - 12 * Math.floor(k / 12);
        const y = 100 * (n - 49) + i + Math.floor(j / 12);
        
        // Convert to Hijri
        const hijriYear = Math.floor((y - 622) * 1.0307);
        const hijriMonth = Math.floor(m * 1.0307);
        const hijriDay = Math.floor(l3 * 1.0307);
        
        return { year: hijriYear, month: hijriMonth, day: hijriDay };
    };

    const hijriToGregorian = (hijriYear, hijriMonth, hijriDay) => {
        // More accurate conversion algorithm
        const jd = Math.floor((hijriYear * 354.367) + (hijriMonth * 29.5) + hijriDay + 1948084.5);
        const l = jd + 68569;
        const n = Math.floor((4 * l) / 146097);
        const l1 = l - Math.floor((146097 * n + 3) / 4);
        const i = Math.floor((4000 * (l1 + 1)) / 1461001);
        const l2 = l1 - Math.floor((1461 * i) / 4) + 31;
        const j = Math.floor((80 * l2) / 2447);
        const l3 = l2 - Math.floor((2447 * j) / 80);
        const k = j - 1;
        const j1 = j + 12 - 12 * Math.floor(j / 12);
        const m = k + 2 - 12 * Math.floor(k / 12);
        const y = 100 * (n - 49) + i + Math.floor(j / 12);
        
        return { year: y, month: m, day: l3 };
    };

    // Update age calculation
    const updateAge = (date) => {
        const today = new Date();
        let years = today.getFullYear() - date.getFullYear();
        let months = today.getMonth() - date.getMonth();
        let days = today.getDate() - date.getDate();
        
        if (days < 0) {
            months--;
            days += new Date(today.getFullYear(), today.getMonth(), 0).getDate();
        }
        if (months < 0) {
            years--;
            months += 12;
        }
        setAgeLabel(`${years}Y ${months}M ${days}D`);
    };

    // Format Hijri date for display
    const formatHijriDate = (hijriDate) => {
        if (!hijriDate) return '';
        const [day, month, year] = hijriDate.split('/');
        return `${day.padStart(2, '0')}/${month.padStart(2, '0')}/${year}`;
    };

    // Custom Hijri Date Picker Component
    const HijriDatePicker = ({ value, onChange, onClose }) => {
        const [selectedYear, setSelectedYear] = useState(1410);
        const [selectedMonth, setSelectedMonth] = useState(10);
        const [selectedDay, setSelectedDay] = useState(27);

        useEffect(() => {
            if (value) {
                const [day, month, year] = value.split('/').map(Number);
                setSelectedDay(day);
                setSelectedMonth(month);
                setSelectedYear(year);
            }
        }, [value]);

        const hijriMonths = [
            'Muharram', 'Safar', 'Rabi al-Awwal', 'Rabi al-Thani',
            'Jumada al-Awwal', 'Jumada al-Thani', 'Rajab', 'Sha\'ban',
            'Ramadan', 'Shawwal', 'Dhu al-Qadah', 'Dhu al-Hijjah'
        ];

        const getDaysInMonth = (year, month) => {
            const daysInMonth = [30, 29, 30, 29, 30, 29, 30, 29, 30, 29, 30, 29];
            // Adjust for leap years
            if (month === 2 && (year % 30 === 2 || year % 30 === 5 || year % 30 === 7 || 
                               year % 30 === 10 || year % 30 === 13 || year % 30 === 16 || 
                               year % 30 === 18 || year % 30 === 21 || year % 30 === 24 || 
                               year % 30 === 26 || year % 30 === 29)) {
                return 30;
            }
            return daysInMonth[month - 1];
        };

        const handleDateSelect = (day) => {
            const formattedDate = `${String(day).padStart(2, '0')}/${String(selectedMonth).padStart(2, '0')}/${selectedYear}`;
            onChange(formattedDate);
            onClose();
        };

        const daysInMonth = getDaysInMonth(selectedYear, selectedMonth);
        const days = Array.from({ length: daysInMonth }, (_, i) => i + 1);

        return (
            <div className="hijri-date-picker" style={{
                position: 'absolute',
                top: '100%',
                left: 0,
                right: 0,
                backgroundColor: 'white',
                border: '1px solid #ddd',
                borderRadius: '4px',
                boxShadow: '0 2px 10px rgba(0,0,0,0.1)',
                zIndex: 1000,
                padding: '10px'
            }}>
                <div className="d-flex justify-content-between align-items-center mb-2">
                    <Button size="sm" onClick={() => setSelectedYear(prev => prev - 1)}>&lt;</Button>
                    <span className="fw-bold">{selectedYear}</span>
                    <Button size="sm" onClick={() => setSelectedYear(prev => prev + 1)}>&gt;</Button>
                </div>
                <div className="d-flex justify-content-between align-items-center mb-2">
                    <Button size="sm" onClick={() => setSelectedMonth(prev => prev === 1 ? 12 : prev - 1)}>&lt;</Button>
                    <span>{hijriMonths[selectedMonth - 1]}</span>
                    <Button size="sm" onClick={() => setSelectedMonth(prev => prev === 12 ? 1 : prev + 1)}>&gt;</Button>
                </div>
                <div style={{ display: 'grid', gridTemplateColumns: 'repeat(7, 1fr)', gap: '2px' }}>
                    {['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'].map(day => (
                        <div key={day} className="text-center fw-bold" style={{ fontSize: '12px' }}>{day}</div>
                    ))}
                    {days.map(day => (
                        <Button
                            key={day}
                            size="sm"
                            color={day === selectedDay ? 'primary' : 'light'}
                            onClick={() => handleDateSelect(day)}
                            style={{ fontSize: '12px', padding: '2px' }}
                        >
                            {day}
                        </Button>
                    ))}
                </div>
            </div>
        );
    };

    // Function to update dates and age
    const updateDatesAndAge = (hijriDate, gregorianDate) => {
        setForm(prev => ({
            ...prev,
            dob_hijri: hijriDate,
            date_of_birth: gregorianDate
        }));
        
        if (gregorianDate) {
            updateAge(new Date(gregorianDate));
        }
    };

    // Form field change handler
    const handleChange = (e) => {
        const { name, value } = e.target;
        const updatedForm = { ...form, [name]: value };
        setForm(updatedForm);

        // Auto-generate full name when name fields change
        if (['first_name', 'second_name', 'third_name', 'family_name'].includes(name)) {
            const fullName = [updatedForm.first_name, updatedForm.second_name, updatedForm.third_name, updatedForm.family_name]
                .filter(name => name.trim() !== '')
                .join(' ');
            setForm(prev => ({ ...prev, name: fullName }));
        }

        // Handle Hijri date input (manual typing)
        if (name === 'dob_hijri') {
            if (value.match(/^\d{2}\/\d{2}\/\d{4}$/)) {
                const [day, month, year] = value.split('/').map(Number);
                try {
                    const gregorianResult = hijriToGregorian(year, month, day);
                    const gregorianDate = `${gregorianResult.year}-${String(gregorianResult.month).padStart(2, '0')}-${String(gregorianResult.day).padStart(2, '0')}`;
                    updateDatesAndAge(value, gregorianDate);
                } catch (error) {
                    console.error('Error converting Hijri to Gregorian:', error);
                }
            }
        }

        // Handle Gregorian date input
        if (name === 'date_of_birth') {
            if (value) {
                try {
                    const hijriResult = gregorianToHijri(value);
                    const hijri = `${String(hijriResult.day).padStart(2, '0')}/${String(hijriResult.month).padStart(2, '0')}/${hijriResult.year}`;
                    updateDatesAndAge(hijri, value);
                } catch (error) {
                    console.error('Error converting Gregorian to Hijri:', error);
                }
            }
        }

        // Handle document type change
        if (name === 'document_type') {
            setForm(prev => ({ ...prev, document_id: '', document_type: value }));
        }
    };

    // Handle Hijri date picker selection
    const handleHijriDateSelect = (hijriDate) => {
        const [day, month, year] = hijriDate.split('/').map(Number);
        try {
            const gregorianResult = hijriToGregorian(year, month, day);
            const gregorianDate = `${gregorianResult.year}-${String(gregorianResult.month).padStart(2, '0')}-${String(gregorianResult.day).padStart(2, '0')}`;
            updateDatesAndAge(hijriDate, gregorianDate);
            setShowHijriPicker(false);
        } catch (error) {
            console.error('Error converting Hijri to Gregorian:', error);
        }
    };

    // Address change handler
    const handleAddressChange = (idx, e) => {
        const { name, value } = e.target;
        const addresses = [...form.addresses];
        addresses[idx][name] = value;
        setForm({ ...form, addresses });
    };

    // Add address
    const addAddress = () => {
        setForm({ ...form, addresses: [...form.addresses, { street: '', city: '', postal_code: '' }] });
    };

    // Remove address
    const removeAddress = (idx) => {
        const addresses = form.addresses.filter((_, i) => i !== idx);
        setForm({ ...form, addresses });
    };

    // Form validation
    const validateForm = () => {
        const requiredFields = [
            'first_name', 'dob_hijri', 'date_of_birth',
            'nationality', 'document_type', 'document_id',
            'phone', 'gender', 'email'
        ];

        // Validate required fields
        for (let fieldName of requiredFields) {
            if (!form[fieldName]?.trim()) {
                alert(`Please fill in the ${fieldName.replace('_', ' ')}`);
                return false;
            }
        }

        // Validate addresses
        for (let i = 0; i < form.addresses.length; i++) {
            const address = form.addresses[i];
            if (!address.street?.trim()) {
                alert(`Please fill in the Street Address for Address ${i + 1}`);
                return false;
            }
            if (!address.city?.trim()) {
                alert(`Please fill in the City for Address ${i + 1}`);
                return false;
            }
        }

        return true;
    };

    // Save handler
    const handleSave = () => {
        if (validateForm()) {
            if (onSave) onSave(form);
        }
    };

    // Initialize form with default values when modal opens
    useEffect(() => {
        if (isOpen) {
            setForm({
                first_name: '',
                second_name: '',
                third_name: '',
                family_name: '',
                name: '',
                email: '',
                dob_hijri: '27/10/1410',
                date_of_birth: '1989-10-27',
                nationality: '',
                document_type: 'National Card',
                document_id: '',
                phone: '',
                marital_status: '',
                gender: '',
                blood_group: '',
                preferred_language: 'Arabic',
                remarks: '',
                addresses: [{ street: '', city: '', postal_code: '' }],
            });
            updateAge(new Date('1989-10-27'));
        }
    }, [isOpen]);

    return (
        <Modal isOpen={isOpen} toggle={toggle} size="xl">
            <ModalHeader toggle={toggle} className="bg-primary text-white">
                Patient # {patientCode}
            </ModalHeader>
            <ModalBody>
                <Form>
                    <Row className="mb-3">
                        <Col md={3}>
                            <FormGroup>
                                <Label>* First Name</Label>
                                <Input name="first_name" value={form.first_name} onChange={handleChange} required />
                            </FormGroup>
                        </Col>
                        <Col md={3}>
                            <FormGroup>
                                <Label>Second Name</Label>
                                <Input name="second_name" value={form.second_name} onChange={handleChange} />
                            </FormGroup>
                        </Col>
                        <Col md={3}>
                            <FormGroup>
                                <Label>Third Name</Label>
                                <Input name="third_name" value={form.third_name} onChange={handleChange} />
                            </FormGroup>
                        </Col>
                        <Col md={3}>
                            <FormGroup>
                                <Label>Last Name</Label>
                                <Input name="family_name" value={form.family_name} onChange={handleChange} />
                            </FormGroup>
                        </Col>
                    </Row>
                    <Row className="mb-3">
                        <Col md={12}>
                            <FormGroup>
                                <Input name="name" value={form.name} onChange={handleChange} placeholder="Full Name (Auto-generated)" readOnly />
                            </FormGroup>
                        </Col>
                    </Row>
                    <Row className="mb-3">
                        <Col md={6}>
                            <FormGroup>
                                <Label>* Email</Label>
                                <Input type="email" name="email" value={form.email} onChange={handleChange} required />
                            </FormGroup>
                        </Col>
                    </Row>
                    <Row className="mb-3">
                        <Col md={3}>
                            <FormGroup style={{ position: 'relative' }}>
                                <Label>* Date of Birth - Hijri</Label>
                                <Input 
                                    name="dob_hijri" 
                                    value={form.dob_hijri} 
                                    onChange={handleChange} 
                                    placeholder="27/10/1410" 
                                    required 
                                    onClick={() => setShowHijriPicker(!showHijriPicker)}
                                    readOnly
                                />
                                {showHijriPicker && (
                                    <HijriDatePicker
                                        value={form.dob_hijri}
                                        onChange={handleHijriDateSelect}
                                        onClose={() => setShowHijriPicker(false)}
                                    />
                                )}
                            </FormGroup>
                        </Col>
                        <Col md={3}>
                            <FormGroup>
                                <Label>* Date of Birth {ageLabel && <span style={{fontWeight: 'normal', marginLeft: '10px'}}>{ageLabel}</span>}</Label>
                                <Input type="date" name="date_of_birth" value={form.date_of_birth} onChange={handleChange} required />
                            </FormGroup>
                        </Col>
                        <Col md={3}>
                            <FormGroup>
                                <Label>* Nationality</Label>
                                <Input name="nationality" value={form.nationality} onChange={handleChange} required />
                            </FormGroup>
                        </Col>
                        <Col md={3}>
                            <FormGroup>
                                <Label>* Document Type</Label>
                                <Input type="select" name="document_type" value={form.document_type} onChange={handleChange} required>
                                    <option value="National Card">National Card</option>
                                    <option value="Iqama">Iqama</option>
                                    <option value="Passport">Passport</option>
                                </Input>
                            </FormGroup>
                        </Col>
                    </Row>
                    <Row className="mb-3">
                        <Col md={3}>
                            <FormGroup>
                                <Label>* Document Id</Label>
                                <Input 
                                    name="document_id" 
                                    value={form.document_id} 
                                    onChange={handleChange} 
                                    placeholder={form.document_type === 'National Card' ? '1xxxxxxxxx' : form.document_type === 'Iqama' ? '2xxxxxxxxx' : ''}
                                    required 
                                />
                            </FormGroup>
                        </Col>
                        <Col md={3}>
                            <FormGroup>
                                <Label>* Contact Number</Label>
                                <Input name="phone" value={form.phone} onChange={handleChange} placeholder="00966 xxxxxxxxx" required />
                            </FormGroup>
                        </Col>
                        <Col md={3}>
                            <FormGroup>
                                <Label>Marital Status</Label>
                                <Input type="select" name="marital_status" value={form.marital_status} onChange={handleChange}>
                                    <option value="">Select Marital Status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </Input>
                            </FormGroup>
                        </Col>
                        <Col md={3}>
                            <FormGroup>
                                <Label>* Gender</Label>
                                <Input type="select" name="gender" value={form.gender} onChange={handleChange} required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </Input>
                            </FormGroup>
                        </Col>
                    </Row>
                    <Row className="mb-3">
                        <Col md={3}>
                            <FormGroup>
                                <Label>Blood Group</Label>
                                <Input type="select" name="blood_group" value={form.blood_group} onChange={handleChange}>
                                    <option value="">Select Group</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </Input>
                            </FormGroup>
                        </Col>
                        <Col md={3}>
                            <FormGroup>
                                <Label>Preferred Language</Label>
                                <Input type="select" name="preferred_language" value={form.preferred_language} onChange={handleChange}>
                                    <option value="Arabic">Arabic</option>
                                    <option value="English">English</option>
                                    <option value="French">French</option>
                                    <option value="Spanish">Spanish</option>
                                </Input>
                            </FormGroup>
                        </Col>
                    </Row>
                    {/* Address Section */}
                    <div className="address-section mt-4">
                        <div className="d-flex align-items-center mb-2">
                            <h5 className="mb-0">Address</h5>
                            <Button color="primary" size="sm" className="ms-2" onClick={addAddress}>+ Address</Button>
                        </div>
                        {form.addresses.map((address, idx) => (
                            <Row key={idx} className="mb-2">
                                <Col md={4}>
                                    <FormGroup>
                                        <Label>* Street</Label>
                                        <Input name="street" value={address.street} onChange={e => handleAddressChange(idx, e)} required />
                                    </FormGroup>
                                </Col>
                                <Col md={4}>
                                    <FormGroup>
                                        <Label>* City</Label>
                                        <Input name="city" value={address.city} onChange={e => handleAddressChange(idx, e)} required />
                                    </FormGroup>
                                </Col>
                                <Col md={3}>
                                    <FormGroup>
                                        <Label>Postal Code</Label>
                                        <Input name="postal_code" value={address.postal_code} onChange={e => handleAddressChange(idx, e)} />
                                    </FormGroup>
                                </Col>
                                <Col md={1} className="d-flex align-items-center">
                                    <Button color="danger" size="sm" onClick={() => removeAddress(idx)} disabled={form.addresses.length === 1}>Remove</Button>
                                </Col>
                            </Row>
                        ))}
                    </div>
                    <Row className="mb-3 mt-4">
                        <Col md={12}>
                            <FormGroup>
                                <Label>Notes</Label>
                                <Input type="textarea" name="remarks" value={form.remarks} onChange={handleChange} />
                            </FormGroup>
                        </Col>
                    </Row>
                </Form>
            </ModalBody>
            <ModalFooter>
                <Button color="secondary" onClick={toggle}>Cancel</Button>
                <Button color="primary" onClick={handleSave}>Save</Button>
            </ModalFooter>
        </Modal>
    );
};

export default AddPatientModal; 