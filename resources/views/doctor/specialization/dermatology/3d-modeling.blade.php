@extends('doctor.specialization.dermatology.layout.main')

@section('title', '3D Modeling - Plastic Surgery Diagnosis System')

@section('content')
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">3D Modeling & Simulation</h2>
            <p class="text-gray-600 mt-2">Interactive 3D facial modeling for surgical planning and visualization</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- 3D Viewer -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">3D Face Model</h3>
                    <div class="flex gap-2">
                        <button class="p-2 rounded-lg border hover:bg-gray-50" title="Reset View">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                        <button class="p-2 rounded-lg border hover:bg-gray-50" title="Save Model">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div id="viewer-3d" class="viewer-3d w-full h-96 rounded-lg"></div>

                <div class="mt-4 text-sm text-gray-600">
                    <p><strong>Controls:</strong> Click and drag to rotate • Scroll to zoom • Right-click and drag to pan</p>
                </div>
            </div>

            <!-- Model Controls -->
            <div class="space-y-6">
                <!-- Facial Features -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Facial Features</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nose Size</label>
                            <input type="range" class="model-control w-full" data-control="nose-size" min="0.5" max="2" step="0.1" value="1">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nose Position</label>
                            <input type="range" class="model-control w-full" data-control="nose-position" min="0.5" max="1.5" step="0.1" value="1">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Eye Distance</label>
                            <input type="range" class="model-control w-full" data-control="eye-distance" min="0.7" max="1.3" step="0.1" value="1">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Face Width</label>
                            <input type="range" class="model-control w-full" data-control="face-width" min="0.7" max="1.3" step="0.1" value="1">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Face Height</label>
                            <input type="range" class="model-control w-full" data-control="face-height" min="0.8" max="1.4" step="0.1" value="1.2">
                        </div>
                    </div>
                </div>

                <!-- Simulation Options -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Simulation Options</h3>

                    <div class="space-y-3">
                        <button class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                            Rhinoplasty Simulation
                        </button>

                        <button class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                            Facelift Preview
                        </button>

                        <button class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors">
                            Brow Lift Simulation
                        </button>

                        <button class="w-full bg-yellow-600 text-white py-2 px-4 rounded-lg hover:bg-yellow-700 transition-colors">
                            Cheek Enhancement
                        </button>
                    </div>
                </div>

                <!-- Export Options -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Export & Share</h3>

                    <div class="space-y-3">
                        <button class="w-full bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Export as Image
                        </button>

                        <button class="w-full bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V7M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                            Generate Report
                        </button>

                        <button class="w-full bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                            </svg>
                            Share with Patient
                        </button>
                    </div>
                </div>
            </div>
        </div>
@endsection
