@extends('doctor.specialization.dermatology.layout.main')

@section('title', 'Measurements - Plastic Surgery Diagnosis System')

@section('content')
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Measurements & Analysis</h2>
            <p class="text-gray-600 mt-2">Precise facial measurements and proportional analysis tools</p>
        </div>

        <!-- Measurement Entry Form -->
        <form id="measurement-form" class="mb-8 bg-white rounded-xl shadow-lg p-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Measurement Name *</label>
                    <input type="text" name="name" required class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Value *</label>
                    <input type="number" name="value" step="0.01" required class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Unit</label>
                    <input type="text" name="unit" class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
            </div>
            <div id="measurement-message" class="hidden mt-4"></div>
            <button type="submit" class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">Save Measurement</button>
        </form>

        <!-- Previous Measurements Table -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Previous Measurements</h3>
            <div class="overflow-x-auto">
                <table id="measurements-table" class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Value</th>
                            <th>Unit</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Measurement Tools -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Measurement Tools</h3>
                    <div class="flex gap-2">
                        <button class="measurement-tool p-2 rounded-lg border hover:bg-gray-50 active" title="Linear Measurement">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21l3-3-3-3m8 6l3-3-3-3M4 4h16v16H4z" />
                            </svg>
                        </button>
                        <button class="angle-tool p-2 rounded-lg border hover:bg-gray-50" title="Angle Measurement">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z" />
                            </svg>
                        </button>
                        <button class="curve-tool p-2 rounded-lg border hover:bg-gray-50" title="Curve Measurement">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="image-viewer relative bg-gray-100 rounded-lg overflow-hidden" style="height: 500px;">
                    <img src="https://images.pexels.com/photos/3845457/pexels-photo-3845457.jpeg?auto=compress&cs=tinysrgb&w=800" alt="Patient Photo for Measurement" class="w-full h-full object-cover">
                </div>

                <div class="mt-4 grid grid-cols-3 gap-4 text-sm">
                    <div class="text-center p-3 bg-blue-50 rounded-lg">
                        <p class="font-medium text-blue-800">Active Tool</p>
                        <p class="text-blue-600">Linear Measurement</p>
                    </div>
                    <div class="text-center p-3 bg-green-50 rounded-lg">
                        <p class="font-medium text-green-800">Measurements</p>
                        <p class="text-green-600">3 Active</p>
                    </div>
                    <div class="text-center p-3 bg-purple-50 rounded-lg">
                        <p class="font-medium text-purple-800">Precision</p>
                        <p class="text-purple-600">±0.1mm</p>
                    </div>
                </div>
            </div>

            <!-- Measurement Data -->
            <div class="space-y-6">
                <!-- Current Measurements -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Current Measurements</h3>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Nose Length</span>
                            <span class="text-sm font-bold text-blue-600">45.2mm</span>
                        </div>

                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Nose Width</span>
                            <span class="text-sm font-bold text-blue-600">32.8mm</span>
                        </div>

                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Eye Distance</span>
                            <span class="text-sm font-bold text-blue-600">62.1mm</span>
                        </div>

                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Face Width</span>
                            <span class="text-sm font-bold text-blue-600">142.5mm</span>
                        </div>

                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Face Height</span>
                            <span class="text-sm font-bold text-blue-600">185.3mm</span>
                        </div>
                    </div>

                    <button class="w-full mt-4 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                        Export Measurements
                    </button>
                </div>

                <!-- Proportional Analysis -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Proportional Analysis</h3>

                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Golden Ratio</span>
                                <span class="text-sm font-bold text-green-600">1.618</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">85% match</p>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Facial Thirds</span>
                                <span class="text-sm font-bold text-yellow-600">Moderate</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: 72%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">72% symmetry</p>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Nose Proportion</span>
                                <span class="text-sm font-bold text-blue-600">Good</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 78%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">78% ideal</p>
                        </div>
                    </div>
                </div>

                <!-- Measurement History -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Measurement History</h3>

                    <div class="space-y-3">
                        <div class="p-3 border border-gray-200 rounded-lg">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Session #3</span>
                                <span class="text-xs text-gray-500">2024-01-15</span>
                            </div>
                            <p class="text-xs text-gray-600">5 measurements recorded</p>
                        </div>

                        <div class="p-3 border border-gray-200 rounded-lg">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Session #2</span>
                                <span class="text-xs text-gray-500">2024-01-08</span>
                            </div>
                            <p class="text-xs text-gray-600">3 measurements recorded</p>
                        </div>

                        <div class="p-3 border border-gray-200 rounded-lg">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Session #1</span>
                                <span class="text-xs text-gray-500">2024-01-01</span>
                            </div>
                            <p class="text-xs text-gray-600">7 measurements recorded</p>
                        </div>
                    </div>

                    <button class="w-full mt-4 bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors">
                        View All History
                    </button>
                </div>
            </div>
        </div>

        <!-- Measurement Guidelines -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Measurement Guidelines</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-2">Accuracy</h4>
                    <p class="text-sm text-gray-600">Ensure proper image calibration and consistent lighting for accurate measurements.</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-2">Consistency</h4>
                    <p class="text-sm text-gray-600">Use standardized anatomical landmarks for reproducible measurements.</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-2">Documentation</h4>
                    <p class="text-sm text-gray-600">Record all measurements with timestamps and session notes for tracking progress.</p>
                </div>
            </div>
        </div>

        <script>
            // Utility to get patient_id from query string
            function getPatientId() {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get('patient_id');
            }
            // AJAX: Submit measurement form
            document.getElementById('measurement-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const form = this;
                const formData = new FormData(form);
                const patientId = getPatientId();
                if (patientId) formData.append('patient_id', patientId);
                const messageDiv = document.getElementById('measurement-message');
                fetch("{{ route('doctor.dermatology.measurements.store') }}", {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    messageDiv.className = data.success ? 'p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg' : 'p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg';
                    messageDiv.textContent = data.message;
                    messageDiv.classList.remove('hidden');
                    if (data.success) {
                        form.reset();
                        loadMeasurements();
                    }
                })
                .catch(() => {
                    messageDiv.className = 'p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg';
                    messageDiv.textContent = 'An error occurred. Please try again.';
                    messageDiv.classList.remove('hidden');
                });
            });
            // AJAX: Load previous measurements
            function loadMeasurements() {
                const patientId = getPatientId();
                if (!patientId) return;
                fetch(`{{ route('doctor.dermatology.measurements.list') }}?patient_id=${patientId}`)
                    .then(response => response.json())
                    .then(data => {
                        const tbody = document.querySelector('#measurements-table tbody');
                        tbody.innerHTML = '';
                        if (data.success && data.measurements.length > 0) {
                            data.measurements.forEach(m => {
                                tbody.innerHTML += `<tr>
                                    <td>${new Date(m.created_at).toLocaleDateString()}</td>
                                    <td>${m.name}</td>
                                    <td>${m.value}</td>
                                    <td>${m.unit || ''}</td>
                                </tr>`;
                            });
                        } else {
                            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-gray-500">No measurements found.</td></tr>';
                        }
                    });
            }
            document.addEventListener('DOMContentLoaded', loadMeasurements);
        </script>
@endsection
