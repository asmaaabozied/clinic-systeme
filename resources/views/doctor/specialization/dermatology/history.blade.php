@extends('doctor.specialization.dermatology.layout.main')

@section('title', 'Medical History - Dermatology')

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
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    Medical History
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
            <p class="text-gray-600">Please select a patient to view their medical history.</p>
        </div>
    </div>
    @endif

    @if($patient)
    <!-- Medical History Content -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Medical History</h2>
        </div>
        
        <div class="p-6">
            <!-- Tab Navigation -->
            <div class="flex space-x-1 mb-6 bg-gray-100 p-1 rounded-lg">
                <button class="history-tab-btn px-4 py-2 rounded-md bg-blue-600 text-white font-medium" data-history-tab="consultations">
                    Consultations ({{ $consultations->count() }})
                </button>
                <button class="history-tab-btn px-4 py-2 rounded-md bg-gray-100 text-gray-600 font-medium" data-history-tab="assessments">
                    Assessments ({{ $assessments->count() }})
                </button>
                <button class="history-tab-btn px-4 py-2 rounded-md bg-gray-100 text-gray-600 font-medium" data-history-tab="recommendations">
                    Recommendations ({{ $recommendations->count() }})
                </button>
                <button class="history-tab-btn px-4 py-2 rounded-md bg-gray-100 text-gray-600 font-medium" data-history-tab="image-analyses">
                    Image Analyses ({{ $imageAnalyses->count() }})
                </button>
                <button class="history-tab-btn px-4 py-2 rounded-md bg-gray-100 text-gray-600 font-medium" data-history-tab="measurements">
                    Measurements ({{ $measurements->count() }})
                </button>
            </div>

            <!-- Tab Content -->
            <div id="consultations-history" class="history-table">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Chief Complaint</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Treatment Plan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($consultations as $consultation)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $consultation->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($consultation->chief_complaint, 50) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($consultation->diagnosis, 50) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($consultation->treatment_plan, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-blue-600 hover:text-blue-900 view-history-record" data-id="{{ $consultation->id }}" data-type="consultation">View</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No consultations found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="assessments-history" class="history-table hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Severity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Findings</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
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
                                <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($assessment->findings, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-blue-600 hover:text-blue-900 view-history-record" data-id="{{ $assessment->id }}" data-type="assessment">View</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No assessments found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="recommendations-history" class="history-table hidden">
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
                                    <button class="text-blue-600 hover:text-blue-900 view-history-record" data-id="{{ $recommendation->id }}" data-type="recommendation">View</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No recommendations found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="image-analyses-history" class="history-table hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Confidence</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Results</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($imageAnalyses as $analysis)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $analysis->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $analysis->image_type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $analysis->confidence_score }}%"></div>
                                        </div>
                                        <span class="text-sm text-gray-900">{{ $analysis->confidence_score }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($analysis->analysis_results, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-blue-600 hover:text-blue-900 view-history-record" data-id="{{ $analysis->id }}" data-type="image_analysis">View</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No image analyses found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="measurements-history" class="history-table hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Body Part</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($measurements as $measurement)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $measurement->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $measurement->measurement_type }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $measurement->value }} {{ $measurement->unit }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $measurement->body_part }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-blue-600 hover:text-blue-900 view-history-record" data-id="{{ $measurement->id }}" data-type="measurement">View</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No measurements found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- History Record Detail Modal -->
<div id="history-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="history-modal-title">Record Details</h3>
                <button class="text-gray-400 hover:text-gray-600" onclick="closeHistoryModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="history-modal-content" class="text-sm text-gray-600">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-page')
<script>
$(document).ready(function() {
    // History tab functionality
    $('.history-tab-btn').click(function() {
        const tabId = $(this).data('history-tab');
        
        // Update button styles
        $('.history-tab-btn').removeClass('bg-blue-600 text-white').addClass('bg-gray-100 text-gray-600');
        $(this).removeClass('bg-gray-100 text-gray-600').addClass('bg-blue-600 text-white');
        
        // Show/hide tables
        $('.history-table').addClass('hidden');
        $('#' + tabId + '-history').removeClass('hidden');
    });

    // View history record details
    $('.view-history-record').click(function() {
        const id = $(this).data('id');
        const type = $(this).data('type');
        viewHistoryRecord(id, type);
    });
});

function viewHistoryRecord(id, type) {
    // This would typically fetch record details via AJAX
    $('#history-modal-title').text(type.charAt(0).toUpperCase() + type.slice(1).replace('_', ' ') + ' Details');
    $('#history-modal-content').html('<p>Loading record details...</p>');
    $('#history-modal').removeClass('hidden');
}

function closeHistoryModal() {
    $('#history-modal').addClass('hidden');
}
</script>
@endpush 