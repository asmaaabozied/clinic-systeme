@extends('doctor.specialization.dermatology.layout.main')

@section('title', 'Consultation - Dermatology')

@section('content')
<div class="space-y-6">
    @if($patient)
    <!-- Patient Info Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold">{{ substr($patient->name, 0, 1) }}</span>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">{{ $patient->name }}</h1>
                    <p class="text-gray-600">Patient ID: {{ $patient->id }} | Age: {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} years</p>
                </div>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    Consultation
                </span>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="text-center">
            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-900 mb-2">No Patient Selected</h2>
            <p class="text-gray-600">Please select a patient to start consultation.</p>
        </div>
    </div>
    @endif

    @if($patient)
    <!-- Consultation Management -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Consultation Management</h2>
        </div>
        
        <div class="p-6">
            <!-- Tab Navigation -->
            <div class="flex space-x-1 mb-6 bg-gray-100 p-1 rounded-lg">
                <button class="tab-btn px-4 py-2 rounded-md bg-blue-600 text-white font-medium" data-tab="consultation-notes">
                    Consultation Notes
                </button>
                <button class="tab-btn px-4 py-2 rounded-md bg-gray-100 text-gray-600 font-medium" data-tab="assessment">
                    Assessment
                </button>
                <button class="tab-btn px-4 py-2 rounded-md bg-gray-100 text-gray-600 font-medium" data-tab="recommendations">
                    Recommendations
                </button>
            </div>

            <!-- Tab Content -->
            <div id="consultation-notes" class="tab-content">
                <form id="consultation-form" class="space-y-6">
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Chief Complaint</label>
                            <textarea name="chief_complaint" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Patient's primary concern..." required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">History of Present Illness</label>
                            <textarea name="history_of_present_illness" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Detailed history of current condition..." required></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Past Medical History</label>
                            <textarea name="past_medical_history" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Previous medical conditions..."></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Family History</label>
                            <textarea name="family_history" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Family medical history..."></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Social History</label>
                            <textarea name="social_history" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Lifestyle, occupation, habits..."></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Medications</label>
                            <textarea name="medications" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Current medications and dosages..."></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Allergies</label>
                            <textarea name="allergies" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Known allergies..."></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Vital Signs</label>
                            <textarea name="vital_signs" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="BP, HR, Temp, etc..."></textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Physical Examination</label>
                        <textarea name="physical_examination" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Detailed physical examination findings..." required></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Diagnosis</label>
                            <textarea name="diagnosis" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Clinical diagnosis..." required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Treatment Plan</label>
                            <textarea name="treatment_plan" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Proposed treatment plan..." required></textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Follow-up Instructions</label>
                        <textarea name="follow_up" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Follow-up schedule and instructions..."></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            Save Consultation Notes
                        </button>
                    </div>
                </form>
            </div>

            <div id="assessment" class="tab-content hidden">
                <form id="assessment-form" class="space-y-6">
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Assessment Type</label>
                            <select name="assessment_type" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select assessment type</option>
                                <option value="Skin Condition">Skin Condition</option>
                                <option value="Lesion Analysis">Lesion Analysis</option>
                                <option value="Facial Assessment">Facial Assessment</option>
                                <option value="Body Assessment">Body Assessment</option>
                                <option value="Pre-treatment">Pre-treatment</option>
                                <option value="Post-treatment">Post-treatment</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Severity</label>
                            <select name="severity" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select severity</option>
                                <option value="mild">Mild</option>
                                <option value="moderate">Moderate</option>
                                <option value="severe">Severe</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Findings</label>
                        <textarea name="findings" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Detailed assessment findings..." required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Recommendations</label>
                        <textarea name="recommendations" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Assessment-based recommendations..." required></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors font-medium">
                            Save Assessment
                        </button>
                    </div>
                </form>
            </div>

            <div id="recommendations" class="tab-content hidden">
                <form id="recommendation-form" class="space-y-6">
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Recommendation Type</label>
                            <select name="recommendation_type" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select recommendation type</option>
                                <option value="Treatment">Treatment</option>
                                <option value="Procedure">Procedure</option>
                                <option value="Medication">Medication</option>
                                <option value="Lifestyle">Lifestyle</option>
                                <option value="Follow-up">Follow-up</option>
                                <option value="Referral">Referral</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                            <select name="priority" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select priority</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Detailed recommendation description..." required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Expected Outcome</label>
                        <textarea name="expected_outcome" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Expected results and outcomes..." required></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition-colors font-medium">
                            Save Recommendation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Previous Records -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Previous Records</h3>
        </div>
        <div class="p-6">
            <!-- Tabs for different record types -->
            <div class="flex space-x-1 mb-6 bg-gray-100 p-1 rounded-lg">
                <button class="record-tab-btn px-4 py-2 rounded-md bg-blue-600 text-white font-medium" data-record-tab="consultations">
                    Consultations ({{ $consultations->count() }})
                </button>
                <button class="record-tab-btn px-4 py-2 rounded-md bg-gray-100 text-gray-600 font-medium" data-record-tab="assessments">
                    Assessments ({{ \App\Models\DermatologyAssessment::where('patient_id', $patient->id)->count() }})
                </button>
                <button class="record-tab-btn px-4 py-2 rounded-md bg-gray-100 text-gray-600 font-medium" data-record-tab="recommendations">
                    Recommendations ({{ \App\Models\DermatologyRecommendation::where('patient_id', $patient->id)->count() }})
                </button>
            </div>

            <!-- Record Tables -->
            <div id="consultations-table" class="record-table">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Chief Complaint</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($consultations as $consultation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $consultation->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($consultation->chief_complaint, 50) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($consultation->diagnosis, 50) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 view-record" data-id="{{ $consultation->id }}" data-type="consultation">View</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No consultations found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="assessments-table" class="record-table hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Severity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $assessments = \App\Models\DermatologyAssessment::where('patient_id', $patient->id)->orderBy('created_at', 'desc')->get(); @endphp
                        @forelse($assessments as $assessment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $assessment->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $assessment->assessment_type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($assessment->severity === 'mild') bg-green-100 text-green-800
                                    @elseif($assessment->severity === 'moderate') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($assessment->severity) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 view-record" data-id="{{ $assessment->id }}" data-type="assessment">View</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No assessments found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="recommendations-table" class="record-table hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $recommendations = \App\Models\DermatologyRecommendation::where('patient_id', $patient->id)->orderBy('created_at', 'desc')->get(); @endphp
                        @forelse($recommendations as $recommendation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $recommendation->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $recommendation->recommendation_type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($recommendation->priority === 'low') bg-green-100 text-green-800
                                    @elseif($recommendation->priority === 'medium') bg-yellow-100 text-yellow-800
                                    @elseif($recommendation->priority === 'high') bg-orange-100 text-orange-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($recommendation->priority) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 view-record" data-id="{{ $recommendation->id }}" data-type="recommendation">View</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No recommendations found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Record Detail Modal -->
<div id="record-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="modal-title">Record Details</h3>
                <button class="text-gray-400 hover:text-gray-600" onclick="closeModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="modal-content" class="text-sm text-gray-600">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-page')
<script>
$(document).ready(function() {
    // Tab functionality
    $('.tab-btn').click(function() {
        const tabId = $(this).data('tab');
        
        // Update button styles
        $('.tab-btn').removeClass('bg-blue-600 text-white').addClass('bg-gray-100 text-gray-600');
        $(this).removeClass('bg-gray-100 text-gray-600').addClass('bg-blue-600 text-white');
        
        // Show/hide content
        $('.tab-content').addClass('hidden');
        $('#' + tabId).removeClass('hidden');
    });

    // Record tab functionality
    $('.record-tab-btn').click(function() {
        const tabId = $(this).data('record-tab');
        
        // Update button styles
        $('.record-tab-btn').removeClass('bg-blue-600 text-white').addClass('bg-gray-100 text-gray-600');
        $(this).removeClass('bg-gray-100 text-gray-600').addClass('bg-blue-600 text-white');
        
        // Show/hide tables
        $('.record-table').addClass('hidden');
        $('#' + tabId + '-table').removeClass('hidden');
    });

    // Form submissions
    $('#consultation-form').submit(function(e) {
        e.preventDefault();
        submitForm($(this), '{{ route("doctor.dermatology.consultation.store") }}', 'consultation');
    });

    $('#assessment-form').submit(function(e) {
        e.preventDefault();
        submitForm($(this), '{{ route("doctor.dermatology.assessment.store") }}', 'assessment');
    });

    $('#recommendation-form').submit(function(e) {
        e.preventDefault();
        submitForm($(this), '{{ route("doctor.dermatology.recommendation.store") }}', 'recommendation');
    });

    // View record details
    $('.view-record').click(function() {
        const id = $(this).data('id');
        const type = $(this).data('type');
        viewRecord(id, type);
    });
});

function submitForm(form, url, type) {
    const formData = new FormData(form[0]);
    
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                // Show success message
                showAlert('success', response.message);
                
                // Reset form
                form[0].reset();
                
                // Reload page to update tables
                setTimeout(() => {
                    location.reload();
                }, 1500);
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                let errorMessage = 'Please fix the following errors:\n';
                for (let field in errors) {
                    errorMessage += errors[field][0] + '\n';
                }
                showAlert('error', errorMessage);
            } else {
                showAlert('error', 'An error occurred. Please try again.');
            }
        }
    });
}

function viewRecord(id, type) {
    // This would typically fetch record details via AJAX
    // For now, we'll show a simple message
    $('#modal-title').text(type.charAt(0).toUpperCase() + type.slice(1) + ' Details');
    $('#modal-content').html('<p>Loading record details...</p>');
    $('#record-modal').removeClass('hidden');
}

function closeModal() {
    $('#record-modal').addClass('hidden');
}

function showAlert(type, message) {
    const alertClass = type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
    const alertHtml = `
        <div class="fixed top-4 right-4 z-50 p-4 rounded-lg ${alertClass} shadow-lg">
            <div class="flex items-center">
                <span class="mr-2">${type === 'success' ? '✓' : '✗'}</span>
                <span>${message}</span>
            </div>
        </div>
    `;
    
    $('body').append(alertHtml);
    setTimeout(() => {
        $('.fixed.top-4.right-4').remove();
    }, 5000);
}
</script>
@endpush