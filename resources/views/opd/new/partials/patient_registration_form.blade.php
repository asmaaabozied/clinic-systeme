    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: #6c5ce7;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 18px;
            font-weight: 600;
        }

        .read-card-btn {
            background: #a29bfe;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .read-card-btn:hover {
            background: #74b9ff;
        }

        .form-content {
            padding: 30px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-group {
            flex: 1;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            font-size: 14px;
        }

        .required {
            color: #e74c3c;
        }

        .form-input, .form-select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            background: white;
        }

        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #6c5ce7;
            box-shadow: 0 0 0 2px rgba(108, 92, 231, 0.1);
        }

        .name-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .full-name {
            grid-column: 1 / -1;
            margin-top: 10px;
        }

        .address-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .address-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .address-header h3 {
            font-size: 16px;
            font-weight: 600;
        }

        .add-address-btn {
            background: #3498db;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-left: 15px;
        }

        .add-address-btn:hover {
            background: #2980b9;
        }

        .notes-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .notes-textarea {
            width: 100%;
            min-height: 120px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            resize: vertical;
            font-family: inherit;
        }

        .notes-textarea:focus {
            outline: none;
            border-color: #6c5ce7;
            box-shadow: 0 0 0 2px rgba(108, 92, 231, 0.1);
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #6c5ce7;
            color: white;
        }

        .btn-primary:hover {
            background: #5a4fcf;
        }

        .btn-secondary {
            background: #3498db;
            color: white;
        }

        .btn-secondary:hover {
            background: #2980b9;
        }

        .btn-cancel {
            background: #95a5a6;
            color: white;
        }

        .btn-cancel:hover {
            background: #7f8c8d;
        }

        .text-danger {
            color: #e74c3c;
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .form-content {
                padding: 20px;
            }

            .name-row {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }
        }

        .remove-address-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 4px 8px; /* Reduced padding for a smaller button */
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px; /* Smaller font size */
            height: 34px; /* Match input height for vertical alignment */
            align-self: center; /* Center vertically in flex context */
            transition: background 0.2s;
        }

        .remove-address-btn:hover {
            background: #c0392b; /* Darker red on hover */
        }
    </style>

    <div class="container">
        <div class="header">
            <h1>
                Patient # {{ $patientCode }}
            </h1>
            <button class="read-card-btn" onclick="readCard()">Read Card</button>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>

        <div class="form-content">
            <form id="patientForm" method="POST" action="{{ route('opd.store') }}">
                @csrf
                <input type="hidden" name="redirect_to_profile" id="redirectToProfile" value="0">
                @if ($errors->any())
                    <div class="alert alert-danger mb-2">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="name-row">
                    <div class="form-group">
                        <label class="form-label">
                            <span class="required">*</span> First Name
                        </label>
                        <input type="text" class="form-input" placeholder="First:" id="firstName" name="first_name" required>
                        @error('first_name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <span class="required"></span> Second Name
                        </label>
                        <label class="form-label"> </label>
                        <input type="text" class="form-input" placeholder="Second:" id="secondName" name="second_name">
                        @error('second_name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <span class="required"></span> Third Name
                        </label>
                        <input type="text" class="form-input" placeholder="Third:" id="thirdName" name="third_name">
                        @error('third_name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <span class="required"></span> Last Name
                        </label>
                        <input type="text" class="form-input" placeholder="Family Name:" id="familyName" name="family_name">
                        @error('family_name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group full-width">
                    <input type="text" class="form-input" placeholder="Full Name (Optional)" id="fullName" name="name">
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <span class="required">*</span> Email
                    </label>
                    <input type="email" class="form-input" id="email" name="email" required>
                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <span class="required">*</span> Date of Birth - Hijri
                        </label>
                        <input type="text" class="form-input" placeholder="27/10/1410" id="dobHijri" name="dob_hijri" required>
                        @error('dob_hijri')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="required">*</span> Date of Birth
                            <span id="ageLabel" style="font-weight: normal; margin-left:10px;"></span>
                        </label>
                        <input type="date" class="form-input" id="dobGregorian" name="date_of_birth" required>
                        @error('date_of_birth')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <span class="required">*</span> Nationality
                        </label>
                        <select class="form-select" id="nationality" name="nationality" required>
                            <option value="">Select Nationality</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->nationality }}" {{ $country->name == 'Saudi Arabia' ? 'selected' : '' }}>
                                {{ $country->nationality }}
                            @endforeach

                        </select>
                        @error('nationality')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="required">*</span> Document Type
                        </label>
                        <select class="form-select" id="documentType" name="document_type" required>
                            <option value="">Select Document Type</option>
                            <option value="National Card" selected>National Card</option>
                            <option value="Iqama">Iqama</option>
                            <option value="Passport">Passport</option>
                        </select>
                        @error('document_type')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="required">*</span> Document Id
                        </label>
                        <input type="text" class="form-input" placeholder="1xxx xxx" id="documentId" name="document_id" required>
                        @error('document_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="required">*</span> Contact Number
                        </label>
                        <input type="tel" class="form-input" placeholder="00966 xxxxxxxxx" id="contactNumber" name="phone" required>
                        @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Marital Status
                        </label>
                        <select class="form-select" id="maritalStatus" name="marital_status">
                            <option value="">Select Marital Status</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                        @error('marital_status')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="required">*</span> Gender
                        </label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        @error('gender')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Blood Group
                        </label>
                        <select class="form-select" id="bloodGroup" name="blood_group">
                            <option value="">Select Group</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                        @error('blood_group')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Preferred Language
                        </label>
                        <select class="form-select" id="preferredLanguage" name="preferred_language">
                            <option value="">Select Language</option>
                            <option value="Arabic" selected>Arabic</option>
                            <option value="English">English</option>
                            <option value="French">French</option>
                            <option value="Spanish">Spanish</option>
                        </select>
                        @error('preferred_language')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="address-section">
                    <div class="address-header">
                        <h3>Address</h3>
                        <button type="button" class="add-address-btn" onclick="addAddress()">+ Address</button>
                    </div>
                    <div id="addressContainer"></div>
                </div>

                <div class="notes-section">
                    <h3>Notes</h3>
                    <textarea class="notes-textarea" placeholder="Notes..." id="notes" name="remarks"></textarea>
                    @error('remarks')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-cancel" onclick="cancelForm()">Cancel</button>
                    <button type="button" class="btn btn-secondary" onclick="createAndNew()">Create & New</button>
                    <button type="submit" id="createBtn" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-generate full name
        function updateFullName() {
            const firstName = document.getElementById('firstName').value;
            const secondName = document.getElementById('secondName').value;
            const thirdName = document.getElementById('thirdName').value;
            const familyName = document.getElementById('familyName').value;

            const fullName = [firstName, secondName, thirdName, familyName]
                .filter(name => name.trim() !== '')
                .join(' ');

            document.getElementById('fullName').value = fullName;
        }

        // Add event listeners to name fields
        ['firstName', 'secondName', 'thirdName', 'familyName'].forEach(id => {
            document.getElementById(id).addEventListener('input', updateFullName);
        });

        document.getElementById('documentType').addEventListener('change', function() {
            const docId = document.getElementById('documentId');
            if (this.value === 'National Card') {
                docId.pattern = '^1\\d{9}$';
                docId.placeholder = '1xxxxxxxxx';
            } else if (this.value === 'Iqama') {
                docId.pattern = '^2\\d{9}$';
                docId.placeholder = '2xxxxxxxxx';
            } else {
                docId.pattern = '';
                docId.placeholder = '';
            }
        });

        // Convert Hijri to Gregorian date (simplified)
        const hijriToJulian = (year, month, day) => {
            return (
                Math.floor((11 * year + 3) / 30) +
                Math.floor(354 * year) +
                Math.floor(30 * month) -
                Math.floor((month - 1) / 2) +
                day +
                1948440 -
                386
            );
        };

        const gregorianToJulian = (year, month, day) => {
            if (month < 3) {
                year -= 1;
                month += 12;
            }
            const a = Math.floor(year / 100.0);
            const b = year === 1582 && (month > 10 || (month === 10 && day > 4))
                ? -10 :
                year === 1582 && month === 10
                    ? 0 :
                    year < 1583
                        ? 0 :
                        2 - a + Math.floor(a / 4.0);
            return Math.floor(365.25 * (year + 4716)) + Math.floor(30.6001 * (month + 1)) + day + b - 1524;
        };

        const julianToHijri = (julianDay) => {
            const y = 10631.0 / 30.0;
            const epochAstro = 1948084;
            const shift1 = 8.01 / 60.0;
            let z = julianDay - epochAstro;
            const cyc = Math.floor(z / 10631.0);
            z -= 10631 * cyc;
            const j = Math.floor((z - shift1) / y);
            z -= Math.floor(j * y + shift1);
            const year = 30 * cyc + j;
            let month = Math.floor(parseInt((z + 28.5001) / 29.5));
            if (month === 13) {
                month = 12;
            }
            const day = z - Math.floor(29.5001 * month - 29);
            return { year: parseInt(year), month: parseInt(month), day: parseInt(day) };
        };

        const julianToGregorian = (julianDate) => {
            let b = 0;
            if (julianDate > 2299160) {
                const a = Math.floor((julianDate - 1867216.25) / 36524.25);
                b = 1 + a - Math.floor(a / 4.0);
            }
            const bb = julianDate + b + 1524;
            let cc = Math.floor((bb - 122.1) / 365.25);
            const dd = Math.floor(365.25 * cc);
            const ee = Math.floor((bb - dd) / 30.6001);
            const day = bb - dd - Math.floor(30.6001 * ee);
            let month = ee - 1;
            if (ee > 13) {
                cc += 1;
                month = ee - 13;
            }
            const year = cc - 4716;
            return { year: parseInt(year), month: parseInt(month), day: parseInt(day) };
        };

        // Helper functions for your form
        const gregorianToHijri = (gregorianDate) => {
            const date = new Date(gregorianDate);
            const julianDay = gregorianToJulian(date.getFullYear(), date.getMonth() + 1, date.getDate());
            return julianToHijri(julianDay);
        };

        const hijriToGregorian = (hijriYear, hijriMonth, hijriDay) => {
            const julianDay = hijriToJulian(hijriYear, hijriMonth, hijriDay);
            return julianToGregorian(julianDay);
        };

        // Updated event listeners for your form
        document.getElementById('dobHijri').addEventListener('input', function(e) {
            const hijriDate = e.target.value;
            if (hijriDate.match(/^\d{2}\/\d{2}\/\d{4}$/)) {
                const [day, month, year] = hijriDate.split('/').map(Number);
                try {
                    const gregorianResult = hijriToGregorian(year, month, day);
                    const gregorianDate = `${gregorianResult.year}-${String(gregorianResult.month).padStart(2, '0')}-${String(gregorianResult.day).padStart(2, '0')}`;
                    document.getElementById('dobGregorian').value = gregorianDate;
                    updateAge(new Date(gregorianDate));
                } catch (error) {
                    console.error('Error converting Hijri to Gregorian:', error);
                }
            }
        });

        document.getElementById('dobGregorian').addEventListener('input', function(e) {
            const val = this.value;
            const date = new Date(val);
            if (!isNaN(date)) {
                try {
                    const hijriResult = gregorianToHijri(val);
                    const hijri = `${String(hijriResult.day).padStart(2,'0')}/${String(hijriResult.month).padStart(2,'0')}/${hijriResult.year}`;
                    document.getElementById('dobHijri').value = hijri;
                    updateAge(date);
                } catch (error) {
                    console.error('Error converting Gregorian to Hijri:', error);
                }
            }
        });


        function updateAge(date) {
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
            document.getElementById('ageLabel').textContent = `${years}Y ${months}M ${days}D`;
        }

        // Phone number formatting
        // document.getElementById('contactNumber').addEventListener('input', function(e) {
        //     let value = e.target.value.replace(/\D/g, '');
        //     if (value.startsWith('966')) {
        //         value = '00' + value;
        //     }
        //     if (value.length > 13) {
        //         value = value.substring(0, 13);
        //     }
        //     if (value.length > 5) {
        //         value = value.substring(0, 5) + ' ' + value.substring(5);
        //     }
        //     e.target.value = value;
        //
        //     // Validate phone number format
        //     if (!value.match(/^00\d{3}\s\d{8}$/)) {
        //         e.target.setCustomValidity('Phone number must be in the format 00966 xxxxxxxxx');
        //     } else {
        //         e.target.setCustomValidity('');
        //     }
        // });

        // Add address field dynamically
        function addAddress() {
            const container = document.getElementById('addressContainer');
            const index = container.children.length;
            const addressDiv = document.createElement('div');
            addressDiv.className = 'form-group';
            addressDiv.innerHTML = `
        <div class="form-row">
            <div class="form-group">
                <label class="form-label"><span class="required">*</span> Street</label>
                <input type="text" class="form-input" name="addresses[${index}][street]" placeholder="Street Address" required />
                <small class="text-danger" id="error-addresses-${index}-street"></small>
            </div>
            <div class="form-group">
                <label class="form-label"><span class="required">*</span> City</label>
                <input type="text" class="form-input" name="addresses[${index}][city]" placeholder="City" required />
                <small class="text-danger" id="error-addresses-${index}-city"></small>
            </div>
            <div class="form-group">
                <label class="form-label">Postal Code</label>
                <input type="text" class="form-input" name="addresses[${index}][postal_code]" placeholder="Postal Code" />
                <small class="text-danger" id="error-addresses-${index}-postal_code"></small>
            </div>
            <button type="button" class="remove-address-btn" onclick="this.parentElement.parentElement.remove()" aria-label="Remove address">Remove</button>
        </div>
    `;
            container.appendChild(addressDiv);
        }

        // Clear form
        function cancelForm() {
            if (confirm('Are you sure you want to cancel? All entered data will be lost.')) {
                document.getElementById('patientForm').reset();
                document.getElementById('addressContainer').innerHTML = '';
            }
        }

        // Submit form and redirect to patient profile
        function createAndNew() {
            if (validateForm()) {
                document.getElementById('redirectToProfile').value = 1;
                document.getElementById('patientForm').submit();
            }
        }

        // Validate form
        function validateForm() {
            const requiredFields = [
                'firstName', 'dobHijri', 'dobGregorian',
                'nationality', 'documentType', 'documentId',
                'contactNumber', 'gender'
            ];

            // Validate non-address required fields
            for (let fieldId of requiredFields) {
                console.log(fieldId);
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    alert(`Please fill in the ${field.previousElementSibling.textContent.replace('*', '').trim()}`);
                    field.focus();
                    return false;
                }
            }

            // Validate address fields
            const addressContainer = document.getElementById('addressContainer');
            const addressRows = addressContainer.querySelectorAll('.form-row');
            for (let i = 0; i < addressRows.length; i++) {
                const streetInput = addressRows[i].querySelector(`input[name="addresses[${i}][street]"]`);
                const cityInput = addressRows[i].querySelector(`input[name="addresses[${i}][city]"]`);

                if (!streetInput.value.trim()) {
                    alert(`Please fill in the Street Address for Address ${i + 1}`);
                    streetInput.focus();
                    return false;
                }
                if (!cityInput.value.trim()) {
                    alert(`Please fill in the City for Address ${i + 1}`);
                    cityInput.focus();
                    return false;
                }
            }

            return true;
        }

        // Form submission
        document.getElementById('patientForm').addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });

        // Display server-side address errors
        @if ($errors->has('addresses.*.street') || $errors->has('addresses.*.city') || $errors->has('addresses.*.postal_code'))
        @foreach ($errors->get('addresses.*') as $index => $error)
        @foreach ($error as $field => $messages)
        @foreach ($messages as $message)
        const errorElement = document.getElementById('error-addresses-{{ $index }}-{{ $field }}');
        if (errorElement) {
            errorElement.innerText = '{{ $message }}';
        } else {
            // Add address dynamically if it doesn't exist
            addAddress();
            document.getElementById('error-addresses-{{ $index }}-{{ $field }}').innerText = '{{ $message }}';
        }
        @endforeach
        @endforeach
        @endforeach
        @endif

        // Initialize with default values
        document.getElementById('dobGregorian').value = '1989-10-27';
        document.getElementById('dobHijri').value = '27/10/1410';
        updateAge(new Date('1989-10-27'));

        // Initialize with one address field
        addAddress();

        // Ensure normal create submits without redirect
        const createBtn = document.getElementById('createBtn');
        if (createBtn) {
            createBtn.addEventListener('click', function () {
                document.getElementById('redirectToProfile').value = 0;
            });
        }
    </script>
