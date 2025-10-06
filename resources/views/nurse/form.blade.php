@extends('layouts.admin')

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/nurse.css') }}">
@endpush

@push('script-page')
    <script src="{{ asset('js/nurse.js') }}"></script>
@endpush

@section('page-title')
    {{ __('Patient Assessment') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('nurse.index') }}">{{ __('Nurse') }}</a></li>
    <li class="breadcrumb-item">{{ __('Assessment') }}</li>
@endsection

@section('content')
<form id="patientAssessmentForm" method="POST" action="{{ route('nurse.update', $patient->id) }}">
    @csrf
    <input type="hidden" name="appointment_id" value="{{ $appointmentId ?? request('appointment') }}">
    <section class="card" id="patientInfoSection">
        <h2>Patient Information</h2>
        <div class="form-grid">
            <div class="form-group">
                <label for="patientName">{{ __('Full Name') }}</label>
                <input type="text" id="patientName" name="patientName" value="{{ $patient->name }}" readonly>
            </div>
            <div class="form-group">
                <label for="patientId">{{ __('Patient ID') }}</label>
                <input type="text" id="patientId" name="patientId" value="{{ $patient->patient_code }}" readonly>
            </div>
            <div class="form-group">
                <label for="patientAge">{{ __('Age') }}</label>
                <input type="text" id="patientAge" name="patientAge" value="{{ $patient->age_display }}" readonly>
            </div>
            <div class="form-group">
                <label for="patientGender">{{ __('Gender') }}</label>
                <input type="text" id="patientGender" name="patientGender" value="{{ ucfirst($patient->gender) }}" readonly>
            </div>
            <div class="form-group">
                <label for="visitDate">{{ __('Visit Date') }}</label>
                <input type="date" id="visitDate" name="visitDate" value="{{ optional($patient->visits->last())->visit_date }}" readonly>
            </div>
            <div class="form-group">
                <label for="visitTime">{{ __('Visit Time') }}</label>
                <input type="time" id="visitTime" name="visitTime" value="{{ optional($patient->visits->last())->visit_time }}" readonly>
            </div>
        </div>
    </section>

    <section class="card" id="vitalSignsSection">
        <h2>{{ __('Vital Signs') }}</h2>
        <div class="form-grid">
            <div class="form-group">
                <label for="temperature">{{ __('Temperature') }}</label>
                <div class="input-with-unit">
                    <input type="number" id="temperature" name="temperature" step="0.1" value="{{ optional($patient->assessment)->temperature }}">
                    <select id="tempUnit" name="tempUnit">
                        <option value="celsius">°C</option>
                        <option value="fahrenheit">°F</option>
                    </select>
                </div>
                <div class="normal-range">{{ __('Normal: 36.1-37.2°C (97-99°F)') }}</div>
            </div>
            <div class="form-group blood-pressure">
                <label>{{ __('Blood Pressure') }}</label>
                <div class="bp-inputs">
                    <input type="number" id="systolic" name="blood_pressure_systolic" placeholder="{{ __('Systolic') }}" min="70" max="220" value="{{ optional($patient->assessment)->blood_pressure_systolic }}">
                    <span>/</span>
                    <input type="number" id="diastolic" name="blood_pressure_diastolic" placeholder="{{ __('Diastolic') }}" min="40" max="120" value="{{ optional($patient->assessment)->blood_pressure_diastolic }}">
                    <span>mmHg</span>
                </div>
                <div class="normal-range">{{ __('Normal: 90-120/60-80 mmHg') }}</div>
            </div>
            <div class="form-group">
                <label for="heartRate">{{ __('Heart Rate') }}</label>
                <div class="input-with-unit">
                    <input type="number" id="heartRate" name="heart_rate" min="40" max="220" value="{{ optional($patient->assessment)->heart_rate }}">
                    <span class="unit">BPM</span>
                </div>
                <div class="normal-range">{{ __('Normal: 60-100 BPM') }}</div>
            </div>
            <div class="form-group">
                <label for="respiratoryRate">{{ __('Respiratory Rate') }}</label>
                <div class="input-with-unit">
                    <input type="number" id="respiratoryRate" name="respiratory_rate" min="8" max="40" value="{{ optional($patient->assessment)->respiratory_rate }}">
                    <span class="unit">{{ __('breaths/min') }}</span>
                </div>
                <div class="normal-range">{{ __('Normal: 12-20 breaths/min') }}</div>
            </div>
            <div class="form-group">
                <label for="oxygenSaturation">{{ __('Oxygen Saturation') }}</label>
                <div class="input-with-unit">
                    <input type="number" id="oxygenSaturation" name="oxygen_saturation" min="70" max="100" step="1" value="{{ optional($patient->assessment)->oxygen_saturation }}">
                    <span class="unit">%</span>
                </div>
                <div class="normal-range">{{ __('Normal: ≥95%') }}</div>
            </div>
            <div class="form-group">
                <label for="weight">{{ __('Weight') }}</label>
                <div class="input-with-unit">
                    <input type="number" id="weight" name="weight" step="0.1" min="0" value="{{ optional($patient->assessment)->weight }}">
                    <select id="weightUnit" name="weightUnit">
                        <option value="kg">kg</option>
                        <option value="lb">lb</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="height">{{ __('Height') }}</label>
                <div class="input-with-unit">
                    <input type="number" id="height" name="height" step="0.01" min="0" value="{{ optional($patient->assessment)->height }}">
                    <select id="heightUnit" name="heightUnit">
                        <option value="m">m</option>
                        <option value="cm">cm</option>
                        <option value="ft">ft</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="bmi">BMI</label>
                <div class="input-with-unit">
                    <input type="number" id="bmi" name="bmi" step="0.1" value="{{ optional($patient->assessment)->bmi }}" readonly>
                    <span class="unit">kg/m²</span>
                </div>
                <div class="normal-range">{{ __('Normal: 18.5-24.9 kg/m²') }}</div>
            </div>
        </div>
    </section>

    <section class="card" id="riskAssessmentSection">
        <h2>{{ __('Risk Assessment') }}</h2>
        <div class="form-grid">
            <div class="form-group full-width">
                <label for="allergies">{{ __('Allergies') }}</label>
                <div class="input-with-dropdown">
                    <input type="text" id="allergiesInput" placeholder="{{ __('Type or select allergies') }}">
                    <select id="allergiesDropdown">
                        <option value="">{{ __('Select common allergy') }}</option>
                        <option value="Penicillin">Penicillin</option>
                        <option value="Latex">Latex</option>
                        <option value="Peanuts">Peanuts</option>
                        <option value="Shellfish">Shellfish</option>
                        <option value="Eggs">Eggs</option>
                        <option value="NSAIDs">NSAIDs</option>
                        <option value="Contrast Dye">Contrast Dye</option>
                    </select>
                </div>
                <div id="allergiesList" class="tags-container"></div>
                <input type="hidden" id="allergies" name="allergies" value="{{ optional($patient->assessment)->allergies }}">
            </div>
            <div class="form-group full-width">
                <label>{{ __('Fall Risk Assessment') }}</label>
                <div class="risk-scale">
                    <div class="risk-option">
                        <input type="radio" id="fallRiskLow" name="fall_risk" value="low" {{ optional($patient->assessment)->fall_risk === 'low' ? 'checked' : '' }}>
                        <label for="fallRiskLow" class="risk-label risk-low">{{ __('Low') }}</label>
                    </div>
                    <div class="risk-option">
                        <input type="radio" id="fallRiskModerate" name="fall_risk" value="moderate" {{ optional($patient->assessment)->fall_risk === 'moderate' ? 'checked' : '' }}>
                        <label for="fallRiskModerate" class="risk-label risk-moderate">{{ __('Moderate') }}</label>
                    </div>
                    <div class="risk-option">
                        <input type="radio" id="fallRiskHigh" name="fall_risk" value="high" {{ optional($patient->assessment)->fall_risk === 'high' ? 'checked' : '' }}>
                        <label for="fallRiskHigh" class="risk-label risk-high">{{ __('High') }}</label>
                    </div>
                </div>
            </div>
            <div class="form-group full-width">
                <label for="painLevel">{{ __('Pain Level (0-10)') }}</label>
                <div class="pain-scale-container">
                    <input type="range" id="painLevel" name="pain_level" min="0" max="10" value="{{ optional($patient->assessment)->pain_level ?? 0 }}" class="pain-slider">
                    <div class="pain-scale-labels">
                        <span>0</span>
                        <span>1</span>
                        <span>2</span>
                        <span>3</span>
                        <span>4</span>
                        <span>5</span>
                        <span>6</span>
                        <span>7</span>
                        <span>8</span>
                        <span>9</span>
                        <span>10</span>
                    </div>
                </div>
                <div class="pain-value">{{ __('Current') }}: <span id="painValue">0</span> - <span id="painText">{{ __('No Pain') }}</span></div>
            </div>
            <div class="form-group">
                <label>{{ __('Smoking Status') }}</label>
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" id="smokingNever" name="smoking_status" value="never" {{ optional($patient->assessment)->smoking_status === 'never' ? 'checked' : '' }}>
                        <label for="smokingNever">{{ __('Never') }}</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="smokingFormer" name="smoking_status" value="former" {{ optional($patient->assessment)->smoking_status === 'former' ? 'checked' : '' }}>
                        <label for="smokingFormer">{{ __('Former') }}</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="smokingCurrent" name="smoking_status" value="current" {{ optional($patient->assessment)->smoking_status === 'current' ? 'checked' : '' }}>
                        <label for="smokingCurrent">{{ __('Current') }}</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>{{ __('Alcohol Consumption') }}</label>
                <select id="alcoholUse" name="alcohol_consumption" required>
                    <option value="">{{ __('Select') }}</option>
                    <option value="none" {{ optional($patient->assessment)->alcohol_consumption === 'none' ? 'selected' : '' }}>{{ __('None') }}</option>
                    <option value="occasional" {{ optional($patient->assessment)->alcohol_consumption === 'occasional' ? 'selected' : '' }}>{{ __('Occasional (1-2 drinks/week)') }}</option>
                    <option value="moderate" {{ optional($patient->assessment)->alcohol_consumption === 'moderate' ? 'selected' : '' }}>{{ __('Moderate (3-7 drinks/week)') }}</option>
                    <option value="heavy" {{ optional($patient->assessment)->alcohol_consumption === 'heavy' ? 'selected' : '' }}>{{ __('Heavy (>7 drinks/week)') }}</option>
                </select>
            </div>
            <div class="form-group full-width">
                <label>{{ __('Chronic Conditions') }}</label>
                <div class="checkbox-grid">
                    @php $conditions = optional($patient->assessment)->chronic_conditions ? json_decode(optional($patient->assessment)->chronic_conditions, true) : []; @endphp
                    <div class="checkbox-option">
                        <input type="checkbox" id="conditionHypertension" name="chronic_conditions[]" value="Hypertension" {{ in_array('Hypertension', $conditions) ? 'checked' : '' }}>
                        <label for="conditionHypertension">{{ __('Hypertension') }}</label>
                    </div>
                    <div class="checkbox-option">
                        <input type="checkbox" id="conditionDiabetes" name="chronic_conditions[]" value="Diabetes" {{ in_array('Diabetes', $conditions) ? 'checked' : '' }}>
                        <label for="conditionDiabetes">{{ __('Diabetes') }}</label>
                    </div>
                    <div class="checkbox-option">
                        <input type="checkbox" id="conditionAsthma" name="chronic_conditions[]" value="Asthma" {{ in_array('Asthma', $conditions) ? 'checked' : '' }}>
                        <label for="conditionAsthma">{{ __('Asthma') }}</label>
                    </div>
                    <div class="checkbox-option">
                        <input type="checkbox" id="conditionCOPD" name="chronic_conditions[]" value="COPD" {{ in_array('COPD', $conditions) ? 'checked' : '' }}>
                        <label for="conditionCOPD">COPD</label>
                    </div>
                    <div class="checkbox-option">
                        <input type="checkbox" id="conditionCHF" name="chronic_conditions[]" value="CHF" {{ in_array('CHF', $conditions) ? 'checked' : '' }}>
                        <label for="conditionCHF">CHF</label>
                    </div>
                    <div class="checkbox-option">
                        <input type="checkbox" id="conditionCKD" name="chronic_conditions[]" value="CKD" {{ in_array('CKD', $conditions) ? 'checked' : '' }}>
                        <label for="conditionCKD">CKD</label>
                    </div>
                    <div class="checkbox-option">
                        <input type="checkbox" id="conditionCancer" name="chronic_conditions[]" value="Cancer" {{ in_array('Cancer', $conditions) ? 'checked' : '' }}>
                        <label for="conditionCancer">{{ __('Cancer') }}</label>
                    </div>
                    <div class="checkbox-option">
                        <input type="checkbox" id="conditionOther" name="chronic_conditions[]" value="Other" {{ in_array('Other', $conditions) ? 'checked' : '' }}>
                        <label for="conditionOther">{{ __('Other') }}</label>
                    </div>
                </div>
                <div id="otherConditionContainer" style="display: none; margin-top: 10px;">
                    <input type="text" id="otherCondition" placeholder="{{ __('Specify other condition') }}">
                </div>
            </div>
        </div>
    </section>

    <div id="alertsContainer"></div>
    <section class="action-buttons">
        <button type="button" id="resetButton" class="secondary-button">{{ __('Reset Form') }}</button>
        <button type="button" id="alertDoctorButton" class="warning-button" disabled>{{ __('Alert Doctor') }}</button>
        <button type="submit" id="submitButton" class="primary-button">{{ __('Save & Submit') }}</button>
    </section>
</form>
@endsection
