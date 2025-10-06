
    <!-- Tooth Modal -->
    <div id="tooth-modal" class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4">
            <form method="POST" action="{{ route('doctor.dental.tooth-conditions.store') }}" class="p-6">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $patient->id ?? '' }}">
                <input type="hidden" name="doctor_id" value="{{ $doctor->id ?? '' }}">
                <input type="hidden" id="tooth-number-input" name="tooth_number">
                <h3 class="text-lg font-bold mb-4">Tooth #<span id="modal-tooth-number">1</span> Condition</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Condition</label>
                        <select id="tooth-condition" name="condition" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="healthy">Healthy</option>
                            <option value="decay">Decay</option>
                            <option value="filling">Filling</option>
                            <option value="crown">Crown</option>
                            <option value="missing">Missing</option>
                            <option value="implant">Implant</option>
                            <option value="root-canal">Root Canal</option>
                        </select>
                    </div>

                    <div id="severity-section">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Severity</label>
                        <select id="tooth-severity" name="severity" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="mild">Mild</option>
                            <option value="moderate">Moderate</option>
                            <option value="severe">Severe</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input name="date" type="date" id="tooth-date" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="notes" id="tooth-notes" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Add any additional notes..."></textarea>
                    </div>
                </div>

                <div class="flex gap-2 mt-6">
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                        Save
                    </button>
                    <button type="button" onclick="deleteToothCondition()" class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                    <button type="button" data-close-modal="tooth-modal" class="bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- New Plan Modal -->
    <div id="new-plan-modal" class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-800">Create Treatment Plan</h3>
                    <button type="button" data-close-modal="new-plan-modal" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <form method="POST" action="{{ route('doctor.dental.treatment-plans.store') }}" class="p-6 space-y-6">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $patient->id ?? '' }}">
                <input type="hidden" name="doctor_id" value="{{ $doctor->id ?? '' }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Plan Title *</label>
                    <input
                        type="text"
                        name="title"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="e.g., Root Canal Treatment, Comprehensive Restoration"
                        required
                    />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                        <input
                            type="date"
                            name="start_date"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estimated Completion</label>
                        <input
                            type="date"
                            name="estimated_completion"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estimated Cost ($)</label>
                    <input
                        type="number"
                        name="estimated_cost"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="0"
                        min="0"
                        step="0.01"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Procedures</label>
                    <textarea
                        name="procedures"
                        rows="4"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Enter each procedure on a new line:&#10;• Root canal therapy&#10;• Crown placement&#10;• Follow-up examination"
                    ></textarea>
                    <p class="text-xs text-gray-500 mt-1">Enter each procedure on a new line</p>
                </div>
                <input type="hidden" name="doctor_id" value="{{ $doctor->id ?? '' }}">
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-md hover:shadow-lg">
                        Create Treatment Plan
                    </button>
                    <button
                            type="button"
                            data-close-modal="new-plan-modal"
                            class="bg-white border border-gray-300 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                    >
                        Cancel
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- Add Treatment Modal -->
    <div id="add-treatment-modal" class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <form method="POST" action="{{ route('doctor.dental.treatment-records.store') }}">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $patient->id ?? '' }}">
                <input type="hidden" name="doctor_id" value="{{ $doctor->id ?? '' }}">
                <h3 class="text-lg font-bold mb-4">Add Treatment Record</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Procedure</label>
                    <input
                        type="text"
                        name="procedure"
                        class="w-full border border-gray-300 rounded-md px-3 py-2"
                        placeholder="e.g., Cleaning, Filling, Root Canal"
                    />
                    </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input
                        type="date"
                        name="date"
                        class="w-full border border-gray-300 rounded-md px-3 py-2"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="completed">Completed</option>
                        <option value="in-progress">In Progress</option>
                        <option value="planned">Planned</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tooth Numbers (comma separated)</label>
                    <input
                        type="text"
                        name="teeth"
                        class="w-full border border-gray-300 rounded-md px-3 py-2"
                        placeholder="e.g., 14, 15, 16"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cost ($)</label>
                    <input
                        type="number"
                        name="cost"
                        class="w-full border border-gray-300 rounded-md px-3 py-2"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea
                        name="notes"
                        rows="3"
                        class="w-full border border-gray-300 rounded-md px-3 py-2"
                        placeholder="Add any additional notes about the treatment..."
                    ></textarea>
                </div>
                </div>

                <div class="flex gap-2 mt-6">
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                        Add Treatment
                    </button>
                    <button type="button" data-close-modal="add-treatment-modal" class="bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Oral Health Assessment Modal -->
    <div id="oral-health-modal" class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <form method="POST" action="{{ route('doctor.dental.oral-assessments.store') }}" class="p-6 space-y-6">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $patient->id ?? '' }}">
                <input type="hidden" name="doctor_id" value="{{ $doctor->id ?? '' }}">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        Edit Oral Health Assessment
                    </h3>
                    <button type="button" data-close-modal="oral-health-modal" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <!-- Health Metrics -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gum Health</label>
                        <select name="gum_health" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="excellent" @selected(($latestAssessment->gum_health ?? '')=='excellent')>Excellent</option>
                            <option value="good" @selected(($latestAssessment->gum_health ?? '')=='good')>Good</option>
                            <option value="fair" @selected(($latestAssessment->gum_health ?? '')=='fair')>Fair</option>
                            <option value="poor" @selected(($latestAssessment->gum_health ?? '')=='poor')>Poor</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Oral Hygiene</label>
                        <select name="oral_hygiene" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="excellent" @selected(($latestAssessment->oral_hygiene ?? '')=='excellent')>Excellent</option>
                            <option value="good" @selected(($latestAssessment->oral_hygiene ?? '')=='good')>Good</option>
                            <option value="fair" @selected(($latestAssessment->oral_hygiene ?? '')=='fair')>Fair</option>
                            <option value="poor" @selected(($latestAssessment->oral_hygiene ?? '')=='poor')>Poor</option>
                        </select>
                    </div>
                </div>

                <!-- Current Issues -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            Current Issues
                        </label>
                        <button type="button" onclick="addIssueField()" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center gap-1 hover:bg-blue-50 px-2 py-1 rounded transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Issue
                        </button>
                    </div>
                    <div id="issues-container" class="space-y-2" data-field-container="issue">
                        @forelse($latestAssessment?->issues ?? [] as $issue)
                            <div class="flex items-center gap-2">
                                <input type="text" name="issues[]" value="{{ $issue }}" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" />
                                <button type="button" onclick="removeField(this)" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        @empty
                            <div class="flex items-center gap-2">
                                <input type="text" name="issues[]" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" />
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Risk Factors -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-sm font-medium text-gray-700">Risk Factors</label>
                        <button type="button" onclick="addRiskFactorField()" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center gap-1 hover:bg-blue-50 px-2 py-1 rounded transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Factor
                        </button>
                    </div>
                    <div id="risk-factors-container" class="space-y-2" data-field-container="risk">
                        @forelse($latestAssessment?->risk_factors ?? [] as $factor)
                            <div class="flex items-center gap-2">
                                <input type="text" name="risk_factors[]" value="{{ $factor }}" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" />
                                <button type="button" onclick="removeField(this)" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        @empty
                            <div class="flex items-center gap-2">
                                <input type="text" name="risk_factors[]" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" />
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recommendations -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Recommendations
                        </label>
                        <button type="button" onclick="addRecommendationField()" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center gap-1 hover:bg-blue-50 px-2 py-1 rounded transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Recommendation
                        </button>
                    </div>
                    <div id="recommendations-container" class="space-y-2" data-field-container="recommendation">
                        @forelse($latestAssessment?->recommendations ?? [] as $rec)
                            <div class="flex items-center gap-2">
                                <input type="text" name="recommendations[]" value="{{ $rec }}" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" />
                                <button type="button" onclick="removeField(this)" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        @empty
                            <div class="flex items-center gap-2">
                                <input type="text" name="recommendations[]" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" />
                            </div>
                        @endforelse
                    </div>
        <div class="sticky bottom-0 bg-gray-50 px-6 py-4 rounded-b-xl border-t border-gray-200">
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Save Assessment
                    </button>
                    <button
                        type="button"
                        data-close-modal="oral-health-modal"
                        class="bg-white border border-gray-300 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                    >
                        Cancel
                </button>
            </div>
        </div>
        </form>
    </div>
