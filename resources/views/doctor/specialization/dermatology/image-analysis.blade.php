@extends('doctor.specialization.dermatology.layout.main')

@section('title', 'Image Analysis - Dermatology')

@push('css-page')
<style>
    .comparison-slider {
        position: relative;
        overflow: hidden;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .comparison-handle {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 4px;
        background: white;
        cursor: ew-resize;
        z-index: 10;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }
    
    .comparison-handle::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 50%;
        border: 3px solid #3b82f6;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    .comparison-handle::after {
        content: '◀ ▶';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #3b82f6;
        font-size: 12px;
        font-weight: bold;
    }
    
    .filter-control {
        -webkit-appearance: none;
        appearance: none;
        height: 6px;
        border-radius: 3px;
        background: #e5e7eb;
        outline: none;
    }
    
    .filter-control::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #3b82f6;
        cursor: pointer;
    }
    
    .filter-control::-moz-range-thumb {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #3b82f6;
        cursor: pointer;
        border: none;
    }
    
    .annotation-tool:hover,
    .measurement-tool:hover,
    .filter-tool:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .border-dashed {
        border-style: dashed;
    }
    
    .border-dashed:hover {
        border-color: #3b82f6;
        background-color: #f8fafc;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Image Analysis</h2>
        <p class="text-gray-600 mt-2">Upload and analyze before/after images for comprehensive patient assessment</p>
    </div>

    @if($patient)
    <!-- Patient Info -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                <span class="text-white text-xl font-bold">{{ substr($patient->name, 0, 1) }}</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ $patient->name }}</h3>
                <p class="text-gray-600">Patient ID: {{ $patient->id }}</p>
                <p class="text-gray-600">Age: {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} years</p>
            </div>
        </div>
    </div>

    <!-- Image Upload Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Before Image Upload -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Before Image</h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors">
                <input type="file" id="before-image" accept="image/*" class="hidden">
                <label for="before-image" class="cursor-pointer">
                    <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
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
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">After Image</h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors">
                <input type="file" id="after-image" accept="image/*" class="hidden">
                <label for="after-image" class="cursor-pointer">
                    <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
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

    <!-- Analysis Form -->
    <div id="analysis-form" class="bg-white rounded-xl shadow-lg p-6 mb-8 hidden">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Image Analysis Details</h3>
        <form id="image-analysis-form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
            <input type="hidden" name="before_image_data" id="before-image-data">
            <input type="hidden" name="after_image_data" id="after-image-data">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image Type *</label>
                    <select name="image_type" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select image type</option>
                        <option value="facial_analysis">Facial Analysis</option>
                        <option value="skin_condition">Skin Condition</option>
                        <option value="lesion_analysis">Lesion Analysis</option>
                        <option value="before_after_comparison">Before/After Comparison</option>
                        <option value="treatment_progress">Treatment Progress</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confidence Score (%) *</label>
                    <input type="number" name="confidence_score" min="0" max="100" required 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Enter confidence score (0-100)">
                </div>
            </div>
            
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Analysis Results *</label>
                <textarea name="analysis_results" rows="4" required 
                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Enter detailed analysis results..."></textarea>
            </div>
            
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                <textarea name="notes" rows="3" 
                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Additional notes..."></textarea>
            </div>
            
            <div class="mt-6 flex justify-end space-x-4">
                <button type="button" id="reset-form" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Reset
                </button>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Save Analysis
                </button>
            </div>
        </form>
    </div>

    <!-- Comparison View -->
    <div id="comparison-section" class="bg-white rounded-xl shadow-lg p-6 mb-8 hidden">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Before/After Comparison</h3>
        <div class="comparison-slider relative" style="height: 500px;">
            <img id="comparison-after" class="absolute inset-0 w-full h-full object-cover rounded-lg" alt="After">
            <img id="comparison-before" class="before-image absolute inset-0 w-full h-full object-cover rounded-lg" style="clip-path: inset(0 50% 0 0);" alt="Before">
            <div class="comparison-handle absolute top-0 bottom-0 w-1 bg-white cursor-ew-resize" style="left: 50%;">
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-8 h-8 bg-white rounded-full border-2 border-gray-300 flex items-center justify-center">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="mt-4 flex justify-between text-sm text-gray-600">
            <span>Before</span>
            <span>After</span>
        </div>
    </div>

    <!-- Analysis Tools -->
    <div id="analysis-tools" class="bg-white rounded-xl shadow-lg p-6 mb-8 hidden">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Analysis Tools</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <button class="annotation-tool p-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-center">
                <svg class="w-6 h-6 mx-auto mb-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="text-sm font-medium">Add Annotation</span>
            </button>
            <button class="measurement-tool p-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-center">
                <svg class="w-6 h-6 mx-auto mb-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21l3-3-3-3m8 6l3-3-3-3M4 4h16v16H4z" />
                </svg>
                <span class="text-sm font-medium">Measure</span>
            </button>
            <button class="filter-tool p-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-center">
                <svg class="w-6 h-6 mx-auto mb-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z" />
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

    <!-- Previous Image Analyses -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Previous Image Analyses</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Analysis Results</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Confidence</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($imageAnalyses as $analysis)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $analysis->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ ucfirst(str_replace('_', ' ', $analysis->image_type)) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ Str::limit($analysis->analysis_results, 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $analysis->confidence_score >= 80 ? 'bg-green-100 text-green-800' : 
                                   ($analysis->confidence_score >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $analysis->confidence_score }}%
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 view-analysis" data-id="{{ $analysis->id }}">View</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No image analyses found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
            <p class="text-gray-600">Please select a patient to view their image analysis.</p>
        </div>
    </div>
    @endif
</div>

<!-- Analysis Modal -->
<div id="analysis-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Image Analysis Details</h3>
                <button id="close-modal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="modal-content">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

@push('script-page')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let beforeImageData = null;
    let afterImageData = null;
    let filterState = {
        brightness: 100,
        contrast: 100,
        saturation: 100,
        blur: 0
    };

    // Image upload functionality
    function validateImageFile(file) {
        const maxSize = 10 * 1024 * 1024; // 10MB
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (file.size > maxSize) {
            showNotification('Image file size must be less than 10MB', 'error');
            return false;
        }
        if (!allowedTypes.includes(file.type)) {
            showNotification('Please select a valid image file (JPG, PNG, GIF)', 'error');
            return false;
        }
        return true;
    }

    document.getElementById('before-image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (!validateImageFile(file)) {
                this.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('before-img').src = e.target.result;
                document.getElementById('before-preview').classList.remove('hidden');
                document.getElementById('comparison-before').src = e.target.result;
                beforeImageData = e.target.result;
                checkBothImages();
                showNotification('Before image uploaded successfully', 'success');
            };
            reader.onerror = function() {
                showNotification('Error reading before image file', 'error');
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('after-image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (!validateImageFile(file)) {
                this.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('after-img').src = e.target.result;
                document.getElementById('after-preview').classList.remove('hidden');
                document.getElementById('comparison-after').src = e.target.result;
                afterImageData = e.target.result;
                checkBothImages();
                showNotification('After image uploaded successfully', 'success');
            };
            reader.onerror = function() {
                showNotification('Error reading after image file', 'error');
            };
            reader.readAsDataURL(file);
        }
    });

    function checkBothImages() {
        const beforeImg = document.getElementById('before-img').src;
        const afterImg = document.getElementById('after-img').src;
        if (beforeImg && afterImg && beforeImg !== window.location.href && afterImg !== window.location.href) {
            document.getElementById('comparison-section').classList.remove('hidden');
            document.getElementById('analysis-tools').classList.remove('hidden');
            document.getElementById('analysis-form').classList.remove('hidden');
        }
    }

    // Comparison slider functionality
    const slider = document.querySelector('.comparison-slider');
    const handle = document.querySelector('.comparison-handle');
    const beforeImage = document.querySelector('.before-image');
    if (handle && beforeImage && slider) {
        let isDragging = false;
        handle.addEventListener('mousedown', () => { isDragging = true; });
        document.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            const rect = slider.getBoundingClientRect();
            const x = Math.max(0, Math.min(e.clientX - rect.left, rect.width));
            const percentage = (x / rect.width) * 100;
            handle.style.left = `${percentage}%`;
            beforeImage.style.clipPath = `inset(0 ${100 - percentage}% 0 0)`;
        });
        document.addEventListener('mouseup', () => { isDragging = false; });
    }

    // Store filter values but do not apply them live
    document.querySelectorAll('.filter-control').forEach(control => {
        control.addEventListener('input', function() {
            filterState[this.dataset.filter] = this.value;
        });
    });

    // Apply filters only when the button is clicked
    document.querySelector('.filter-tool').addEventListener('click', function() {
        const beforeImg = document.getElementById('before-img');
        const afterImg = document.getElementById('after-img');
        const filterString = `brightness(${filterState.brightness}%) contrast(${filterState.contrast}%) saturate(${filterState.saturation}%) blur(${filterState.blur}px)`;
        if (beforeImg) beforeImg.style.filter = filterString;
        if (afterImg) afterImg.style.filter = filterString;
        showNotification('Filters applied!', 'success');
    });

    // Form submission
    document.getElementById('image-analysis-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const formData = new FormData(form);
        
        // Add image data to form
        if (beforeImageData) {
            formData.set('before_image_data', beforeImageData);
        }
        if (afterImageData) {
            formData.set('after_image_data', afterImageData);
        }

        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Saving...';
        submitBtn.disabled = true;

        fetch("{{ route('doctor.dermatology.image-analysis.store') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showNotification('Image analysis saved successfully!', 'success');
                
                // Reset form
                form.reset();
                document.getElementById('before-preview').classList.add('hidden');
                document.getElementById('after-preview').classList.add('hidden');
                document.getElementById('comparison-section').classList.add('hidden');
                document.getElementById('analysis-tools').classList.add('hidden');
                document.getElementById('analysis-form').classList.add('hidden');
                
                // Reload page to show new analysis
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(data.message || 'Error saving analysis', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred. Please try again.', 'error');
        })
        .finally(() => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        });
    });

    // Reset form
    document.getElementById('reset-form').addEventListener('click', function() {
        if (confirm('Are you sure you want to reset the form? This will clear all uploaded images and form data.')) {
            document.getElementById('image-analysis-form').reset();
            document.getElementById('before-preview').classList.add('hidden');
            document.getElementById('after-preview').classList.add('hidden');
            document.getElementById('comparison-section').classList.add('hidden');
            document.getElementById('analysis-tools').classList.add('hidden');
            document.getElementById('analysis-form').classList.add('hidden');
            
            // Clear file inputs
            document.getElementById('before-image').value = '';
            document.getElementById('after-image').value = '';
            
            beforeImageData = null;
            afterImageData = null;
            
            // Reset filter controls
            document.querySelectorAll('.filter-control').forEach(control => {
                if (control.dataset.filter === 'brightness' || control.dataset.filter === 'contrast' || control.dataset.filter === 'saturation') {
                    control.value = 100;
                } else if (control.dataset.filter === 'blur') {
                    control.value = 0;
                }
                
                // Trigger the filter update
                const event = new Event('input');
                control.dispatchEvent(event);
            });
            
            showNotification('Form has been reset', 'info');
        }
    });

    // Modal functionality
    document.querySelectorAll('.view-analysis').forEach(button => {
        button.addEventListener('click', function() {
            const analysisId = this.dataset.id;
            
            // Show loading state
            document.getElementById('modal-content').innerHTML = `
                <div class="text-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto mb-4"></div>
                    <p class="text-gray-600">Loading analysis details...</p>
                </div>
            `;
            document.getElementById('analysis-modal').classList.remove('hidden');
            
            // Fetch analysis details
            fetch(`{{ route('doctor.dermatology.image-analysis.show', '') }}/${analysisId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const analysis = data.imageAnalysis;
                        document.getElementById('modal-content').innerHTML = `
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-2">Image Type</h4>
                                        <p class="text-gray-700">${analysis.image_type ? analysis.image_type.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) : 'N/A'}</p>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-2">Confidence Score</h4>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            ${analysis.confidence_score >= 80 ? 'bg-green-100 text-green-800' : 
                                              (analysis.confidence_score >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')}">
                                            ${analysis.confidence_score}%
                                        </span>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Analysis Results</h4>
                                    <p class="text-gray-700 whitespace-pre-wrap">${analysis.analysis_results || 'No analysis results available'}</p>
                                </div>
                                
                                ${analysis.notes ? `
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Notes</h4>
                                    <p class="text-gray-700 whitespace-pre-wrap">${analysis.notes}</p>
                                </div>
                                ` : ''}
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    ${analysis.before_image ? `
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-2">Before Image</h4>
                                        <img src="/storage/${analysis.before_image}" alt="Before" class="w-full h-32 object-cover rounded-lg">
                                    </div>
                                    ` : ''}
                                    ${analysis.after_image ? `
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-2">After Image</h4>
                                        <img src="/storage/${analysis.after_image}" alt="After" class="w-full h-32 object-cover rounded-lg">
                                    </div>
                                    ` : ''}
                                </div>
                                
                                <div class="text-sm text-gray-500">
                                    Created: ${new Date(analysis.created_at).toLocaleString()}
                                </div>
                            </div>
                        `;
                    } else {
                        document.getElementById('modal-content').innerHTML = `
                            <div class="text-center">
                                <p class="text-red-600">${data.message || 'Failed to load analysis details'}</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('modal-content').innerHTML = `
                        <div class="text-center">
                            <p class="text-red-600">An error occurred while loading the analysis details.</p>
                        </div>
                    `;
                });
        });
    });

    document.getElementById('close-modal').addEventListener('click', function() {
        document.getElementById('analysis-modal').classList.add('hidden');
    });

    // Close modal on backdrop click
    document.getElementById('analysis-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });

    // Notification function
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
            type === 'success' ? 'bg-green-500 text-white' : 
            type === 'error' ? 'bg-red-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
});
</script>
@endpush
@endsection
