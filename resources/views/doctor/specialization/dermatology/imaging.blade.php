@extends('doctor.specialization.dermatology.layout.main')

@section('title', 'Imaging & Analysis - Dermatology')

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
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                    Imaging & Analysis
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
            <p class="text-gray-600">Please select a patient to start imaging analysis.</p>
        </div>
    </div>
    @endif

    @if($patient)
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-2xl font-bold text-gray-900">Imaging & Analysis</h2>
        <p class="text-gray-600 mt-2">Upload and analyze images for comprehensive patient assessment</p>
    </div>

    <!-- Image Analysis Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">New Image Analysis</h3>
        </div>
        
        <div class="p-6">
            <form id="image-analysis-form" class="space-y-6">
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Image Type</label>
                        <select name="image_type" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Select image type</option>
                            <option value="Before Treatment">Before Treatment</option>
                            <option value="After Treatment">After Treatment</option>
                            <option value="Lesion Analysis">Lesion Analysis</option>
                            <option value="Skin Condition">Skin Condition</option>
                            <option value="Facial Analysis">Facial Analysis</option>
                            <option value="Body Analysis">Body Analysis</option>
                            <option value="Dermoscopy">Dermoscopy</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confidence Score (%)</label>
                        <input type="number" name="confidence_score" min="0" max="100" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="85" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Analysis Results</label>
                    <textarea name="analysis_results" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Detailed analysis findings..." required></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Additional notes and observations..."></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-colors font-medium">
                        Save Analysis
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Upload Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Image Upload & Comparison</h3>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Before Image Upload -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h4 class="text-lg font-medium text-gray-800 mb-4">Before Image</h4>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors">
                        <input type="file" id="before-image" accept="image/*" class="hidden">
                        <label for="before-image" class="cursor-pointer">
                            <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600 mb-2">Click to upload before image</p>
                            <p class="text-sm text-gray-400">PNG, JPG up to 10MB</p>
                        </label>
                    </div>
                    <div id="before-preview" class="mt-4 hidden">
                        <img id="before-img" class="w-full h-64 object-cover rounded-lg" alt="Before image">
                    </div>
                </div>

                <!-- After Image Upload -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h4 class="text-lg font-medium text-gray-800 mb-4">After Image</h4>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors">
                        <input type="file" id="after-image" accept="image/*" class="hidden">
                        <label for="after-image" class="cursor-pointer">
                            <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600 mb-2">Click to upload after image</p>
                            <p class="text-sm text-gray-400">PNG, JPG up to 10MB</p>
                        </label>
                    </div>
                    <div id="after-preview" class="mt-4 hidden">
                        <img id="after-img" class="w-full h-64 object-cover rounded-lg" alt="After image">
                    </div>
                </div>
            </div>

            <!-- Comparison View -->
            <div id="comparison-section" class="hidden">
                <h4 class="text-lg font-medium text-gray-800 mb-4">Before/After Comparison</h4>
                
                <div class="comparison-slider relative" style="height: 500px;">
                    <img id="comparison-after" class="absolute inset-0 w-full h-full object-cover rounded-lg" alt="After">
                    <img id="comparison-before" class="before-image absolute inset-0 w-full h-full object-cover rounded-lg" style="clip-path: inset(0 50% 0 0);" alt="Before">
                    <div class="comparison-handle absolute top-0 bottom-0 w-1 bg-white shadow-lg cursor-ew-resize" style="left: 50%;"></div>
                </div>

                <div class="mt-4 flex justify-between text-sm text-gray-600">
                    <span>Before</span>
                    <span>After</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Analysis Tools -->
    <div id="analysis-tools" class="bg-white rounded-lg shadow-sm border border-gray-200 hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Analysis Tools</h3>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <button class="annotation-tool p-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-center">
                    <svg class="w-6 h-6 mx-auto mb-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="text-sm font-medium">Add Annotation</span>
                </button>
                
                <button class="measurement-tool p-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-center">
                    <svg class="w-6 h-6 mx-auto mb-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21l3-3-3-3m8 6l3-3-3-3M4 4h16v16H4z"></path>
                    </svg>
                    <span class="text-sm font-medium">Measure</span>
                </button>
                
                <button class="filter-tool p-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-center">
                    <svg class="w-6 h-6 mx-auto mb-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                    </svg>
                    <span class="text-sm font-medium">Apply Filters</span>
                </button>
            </div>

            <!-- Image Filters -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Brightness</label>
                    <input type="range" class="filter-control w-full" data-filter="brightness" min="50" max="150" value="100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contrast</label>
                    <input type="range" class="filter-control w-full" data-filter="contrast" min="50" max="150" value="100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Saturation</label>
                    <input type="range" class="filter-control w-full" data-filter="saturation" min="0" max="200" value="100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Blur</label>
                    <input type="range" class="filter-control w-full" data-filter="blur" min="0" max="10" value="0">
                </div>
            </div>
        </div>
    </div>

    <!-- Previous Image Analyses -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Previous Image Analyses</h3>
        </div>
        <div class="p-6">
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
                                <button class="text-blue-600 hover:text-blue-900 view-analysis" data-id="{{ $analysis->id }}">View</button>
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
    </div>
    @endif
</div>

<!-- Analysis Detail Modal -->
<div id="analysis-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Image Analysis Details</h3>
                <button class="text-gray-400 hover:text-gray-600" onclick="closeAnalysisModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="analysis-modal-content" class="text-sm text-gray-600">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-page')
<script>
$(document).ready(function() {
    // Image upload functionality
    $('#before-image').change(function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#before-img').attr('src', e.target.result);
                $('#before-preview').removeClass('hidden');
                $('#comparison-before').attr('src', e.target.result);
                checkBothImages();
            };
            reader.readAsDataURL(file);
        }
    });

    $('#after-image').change(function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#after-img').attr('src', e.target.result);
                $('#after-preview').removeClass('hidden');
                $('#comparison-after').attr('src', e.target.result);
                checkBothImages();
            };
            reader.readAsDataURL(file);
        }
    });

    function checkBothImages() {
        if ($('#before-img').attr('src') && $('#after-img').attr('src')) {
            $('#comparison-section').removeClass('hidden');
            $('#analysis-tools').removeClass('hidden');
        }
    }

    // Comparison slider functionality
    let isDragging = false;
    const handle = $('.comparison-handle');
    const beforeImage = $('#comparison-before');

    handle.mousedown(function() {
        isDragging = true;
    });

    $(document).mousemove(function(e) {
        if (!isDragging) return;
        
        const container = $('.comparison-slider');
        const containerRect = container[0].getBoundingClientRect();
        const x = e.clientX - containerRect.left;
        const percentage = (x / containerRect.width) * 100;
        
        if (percentage >= 0 && percentage <= 100) {
            handle.css('left', percentage + '%');
            beforeImage.css('clip-path', `inset(0 ${100 - percentage}% 0 0)`);
        }
    });

    $(document).mouseup(function() {
        isDragging = false;
    });

    // Filter controls
    $('.filter-control').on('input', function() {
        const filter = $(this).data('filter');
        const value = $(this).val();
        const unit = filter === 'blur' ? 'px' : '%';
        
        $('#comparison-before, #comparison-after').css('filter', `${filter}(${value}${unit})`);
    });

    // Form submission
    $('#image-analysis-form').submit(function(e) {
        e.preventDefault();
        submitImageAnalysis($(this));
    });

    // View analysis details
    $('.view-analysis').click(function() {
        const id = $(this).data('id');
        viewAnalysisDetails(id);
    });
});

function submitImageAnalysis(form) {
    const formData = new FormData(form[0]);
    
    $.ajax({
        url: '{{ route("doctor.dermatology.image-analysis.store") }}',
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

function viewAnalysisDetails(id) {
    // This would typically fetch analysis details via AJAX
    $('#analysis-modal-content').html('<p>Loading analysis details...</p>');
    $('#analysis-modal').removeClass('hidden');
}

function closeAnalysisModal() {
    $('#analysis-modal').addClass('hidden');
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