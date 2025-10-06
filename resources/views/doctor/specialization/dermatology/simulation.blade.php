@extends('doctor.specialization.dermatology.layout.main')

@section('title', '3D Simulation - Dermatology')

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
                    3D Simulation
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
            <p class="text-gray-600">Please select a patient to start 3D simulation.</p>
        </div>
    </div>
    @endif

    @if($patient)
    <div class="mb-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-2xl font-bold text-gray-900">3D Simulation</h2>
        <p class="text-gray-600 mt-2">Interactive 3D facial modeling for surgical planning and visualization</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- 3D Viewer -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">3D Facial Model</h3>
                    <div class="flex gap-2">
                        <button id="reset-view" class="px-3 py-1 bg-blue-100 text-blue-700 rounded-md text-sm">Reset View</button>
                        <button id="save-simulation" class="px-3 py-1 bg-green-100 text-green-700 rounded-md text-sm">Save Changes</button>
                    </div>
                </div>
                <div id="viewer-3d" class="viewer-3d bg-gray-100 flex items-center justify-center rounded-lg" style="height: 500px;">
                    <span class="text-gray-400">[3D Model Viewer Placeholder]</span>
                </div>
            </div>
        </div>

        <!-- 3D Controls -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Model Controls</h3>
                <form id="simulation-controls-form" class="space-y-4">
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nose Size</label>
                        <input type="range" name="nose_size" class="model-control w-full" min="0.5" max="2" step="0.1" value="1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nose Position</label>
                        <input type="range" name="nose_position" class="model-control w-full" min="0.5" max="1.5" step="0.1" value="1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Eye Distance</label>
                        <input type="range" name="eye_distance" class="model-control w-full" min="0.8" max="1.2" step="0.05" value="1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Face Width</label>
                        <input type="range" name="face_width" class="model-control w-full" min="0.8" max="1.2" step="0.05" value="1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Face Height</label>
                        <input type="range" name="face_height" class="model-control w-full" min="0.8" max="1.2" step="0.05" value="1">
                    </div>
                </form>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Simulation Presets</h3>
                <div class="space-y-2">
                    <button class="w-full text-left p-3 rounded-lg border hover:bg-gray-50 transition-colors">Rhinoplasty - Subtle</button>
                    <button class="w-full text-left p-3 rounded-lg border hover:bg-gray-50 transition-colors">Rhinoplasty - Dramatic</button>
                    <button class="w-full text-left p-3 rounded-lg border hover:bg-gray-50 transition-colors">Facial Contouring</button>
                    <button class="w-full text-left p-3 rounded-lg border hover:bg-gray-50 transition-colors">Lip Enhancement</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('script-page')
<script>
$(document).ready(function() {
    // Placeholder for 3D model controls
    $('#reset-view').click(function(e) {
        e.preventDefault();
        // Reset all sliders to default
        $('#simulation-controls-form input[type=range]').each(function() {
            $(this).val($(this).attr('value'));
        });
        showAlert('success', 'View reset to default.');
    });

    $('#save-simulation').click(function(e) {
        e.preventDefault();
        submitSimulation();
    });

    function submitSimulation() {
        const form = $('#simulation-controls-form');
        const formData = new FormData(form[0]);
        $.ajax({
            url: '{{ route('doctor.dermatology.simulation') }}', // You may want to create a dedicated store route
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                showAlert('success', 'Simulation parameters saved!');
            },
            error: function() {
                showAlert('error', 'An error occurred while saving simulation.');
            }
        });
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
        }, 4000);
    }
});
</script>
@endpush 