                <!-- Oral Health Assessment -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Oral Health Assessment
                        </h2>
                        <button onclick="openModal('oral-health-modal')" class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-6">
                        <!-- Health Metrics -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gum Health</label>
                                <span class="px-3 py-2 rounded-lg font-medium text-blue-700 bg-blue-100 border-blue-200 border">{{ $latestAssessment->gum_health ?? '-' }}</span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Oral Hygiene</label>
                                <span class="px-3 py-2 rounded-lg font-medium text-yellow-700 bg-yellow-100 border-yellow-200 border">{{ $latestAssessment->oral_hygiene ?? '-' }}</span>
                            </div>
                        </div>

                        <!-- Current Issues -->
                        <div>
                            <label class="text-sm font-medium text-gray-700 flex items-center gap-2 mb-3">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Current Issues
                            </label>
                            <div class="space-y-2">
                                @forelse($latestAssessment?->issues ?? [] as $issue)
                                    <div class="flex items-center gap-2 text-sm text-gray-700 bg-red-50 border border-red-200 rounded-lg px-3 py-2">
                                        <svg class="w-3 h-3 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                        </svg>
                                        {{ $issue }}
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500">{{ __('No issues recorded.') }}</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Risk Factors -->
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-3 block">Risk Factors</label>
                            <div class="space-y-1">
                                @forelse($latestAssessment?->risk_factors ?? [] as $factor)
                                    <div class="text-sm text-gray-700 bg-yellow-50 border border-yellow-200 px-3 py-2 rounded-lg">{{ $factor }}</div>
                                @empty
                                    <p class="text-sm text-gray-500">{{ __('No risk factors recorded.') }}</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Recommendations -->
                        <div>
                            <label class="text-sm font-medium text-gray-700 flex items-center gap-2 mb-3">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Recommendations
                            </label>
                            <div class="space-y-2">
                                @forelse($latestAssessment?->recommendations ?? [] as $rec)
                                    <div class="flex items-center gap-2 text-sm text-gray-700 bg-green-50 border border-green-200 px-3 py-2 rounded-lg">
                                        <svg class="w-3 h-3 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $rec }}
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500">{{ __('No recommendations recorded.') }}</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

