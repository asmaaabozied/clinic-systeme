@extends('doctor.specialization.dermatology.layout.main')

@section('title', 'Treatment Plan - Dermatology')

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
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                    Treatment Plan
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
            <p class="text-gray-600">Please select a patient to view or create a treatment plan.</p>
        </div>
    </div>
    @endif

    @if($patient)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Treatment Plan</h2>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors" id="open-treatment-modal">
                Create New Plan
            </button>
        </div>

        <!-- Treatment Timeline (static example, can be made dynamic if needed) -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Treatment Timeline</h3>
            <div class="relative">
                <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-300"></div>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold">1</div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800">Initial Consultation</h4>
                            <p class="text-gray-600 text-sm">Complete assessment and treatment planning</p>
                            <p class="text-blue-600 text-sm font-medium">Completed - Jan 15, 2024</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-white text-sm font-bold">2</div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800">Pre-operative Preparation</h4>
                            <p class="text-gray-600 text-sm">Medical clearance and pre-op instructions</p>
                            <p class="text-yellow-600 text-sm font-medium">In Progress - Due Jan 30, 2024</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-sm font-bold">3</div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800">Surgical Procedure</h4>
                            <p class="text-gray-600 text-sm">Rhinoplasty procedure</p>
                            <p class="text-gray-500 text-sm">Scheduled - Feb 15, 2024</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-sm font-bold">4</div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800">Post-operative Care</h4>
                            <p class="text-gray-600 text-sm">Recovery monitoring and follow-up</p>
                            <p class="text-gray-500 text-sm">Planned - Feb 16 - Mar 15, 2024</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dynamic Treatment Plans Table -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Previous Treatment Plans</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
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
                            <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($recommendation->description, 50) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 view-plan" data-id="{{ $recommendation->id }}">View</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No treatment plans found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<!-- Modal for New Treatment Plan -->
<div id="treatment-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Create New Treatment Plan</h3>
                <button class="text-gray-400 hover:text-gray-600" onclick="closeTreatmentModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="treatment-form" class="space-y-6">
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
                    <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Detailed treatment plan description..." required></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Expected Outcome</label>
                    <textarea name="expected_outcome" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Expected results and outcomes..." required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition-colors font-medium">
                        Save Treatment Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script-page')
<script>
$(document).ready(function() {
    $('#open-treatment-modal').click(function() {
        $('#treatment-modal').removeClass('hidden');
    });
    
    window.closeTreatmentModal = function() {
        $('#treatment-modal').addClass('hidden');
    }

    $('#treatment-form').submit(function(e) {
        e.preventDefault();
        submitTreatmentPlan($(this));
    });

    $('.view-plan').click(function() {
        const id = $(this).data('id');
        // You can implement AJAX to fetch and show plan details in a modal
        showAlert('info', 'Viewing plan #' + id);
    });
});

function submitTreatmentPlan(form) {
    const formData = new FormData(form[0]);
    
    $.ajax({
        url: '{{ route("doctor.dermatology.recommendation.store") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                form[0].reset();
                closeTreatmentModal();
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

function showAlert(type, message) {
    let alertClass = 'bg-green-100 text-green-800';
    if (type === 'error') alertClass = 'bg-red-100 text-red-800';
    if (type === 'info') alertClass = 'bg-blue-100 text-blue-800';
    const alertHtml = `
        <div class="fixed top-4 right-4 z-50 p-4 rounded-lg ${alertClass} shadow-lg">
            <div class="flex items-center">
                <span class="mr-2">${type === 'success' ? '✓' : (type === 'info' ? 'ℹ️' : '✗')}</span>
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