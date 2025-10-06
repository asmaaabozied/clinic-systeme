
            <!-- Middle Column - Treatment Plan & Dental Chart -->
            <div class="space-y-8">
                <!-- Treatment Plan -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Treatment Plan</h2>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('doctor.dental.treatment-plans.index') }}" class="p-2 text-gray-500 hover:text-blue-600" title="{{ __('View History') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </a>
                            <button onclick="openModal('new-plan-modal')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                New Plan
                            </button>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @php
                            $stageProgress = ['pre-op' => 25, 'procedure' => 50, 'follow-up' => 75, 'completed' => 100];
                        @endphp

                        @if(isset($latestPlan))
                            <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-100">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="font-semibold text-blue-900">{{ $latestPlan->title }}</h3>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">{{ ucfirst(str_replace('-', ' ', $latestPlan->stage)) }}</span>
                                </div>
                                <div class="mb-4">
                                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                                        <span>Progress</span>
                                        <span>{{ $stageProgress[$latestPlan->stage] ?? 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full" style="width:{{ $stageProgress[$latestPlan->stage] ?? 0 }}%"></div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600">{{ __('Start:') }} {{ $latestPlan->start_date?->format('Y-m-d') }}</p>
                                @if($latestPlan->estimated_completion)
                                    <p class="text-sm text-gray-600">{{ __('Est. Completion:') }} {{ $latestPlan->estimated_completion->format('Y-m-d') }}</p>
                                @endif
                                @if($latestPlan->estimated_cost)
                                    <p class="text-sm text-gray-600">{{ __('Cost: $') }}{{ $latestPlan->estimated_cost }}</p>
                                @endif
                                @if($latestPlan->procedures)
                                    <p>{{ $latestPlan->procedures }}</p>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-500">{{ __('No treatment plan found.') }}</p>
                        @endif
                    </div>

                </div>

                <!-- Interactive Dental Chart -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Interactive Dental Chart</h2>

                    <div class="space-y-8">
                        <!-- Upper Teeth -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-600 mb-3">Upper Jaw</h3>
                            <div class="flex justify-center">
                                <div class="grid grid-cols-8 gap-2">
                                    @php
                                        $conditionColors = [
                                            'healthy' => '#22c55e', // green
                                            'decay' => '#ef4444', // red
                                            'filling' => '#f59e42', // orange
                                            'crown' => '#6366f1', // blue
                                            'missing' => '#9ca3af', // gray
                                            'implant' => '#0ea5e9', // cyan
                                            'root-canal' => '#a21caf', // purple
                                        ];
                                    @endphp
                                    @for ($i = 1; $i <= 8; $i++)
                                        @php
                                            $tooth = $toothConditions[$i] ?? null;
                                            $fill = $tooth ? ($conditionColors[$tooth->condition] ?? '#ffffff') : '#ffffff';
                                            $toothData = $tooth ? json_encode($tooth) : '{}';
                                        @endphp
                                        <div class="relative cursor-pointer group tooth-element" data-tooth-number="{{ $i }}" data-tooth='@json($tooth)'>
                                            <svg width="40" height="50" viewBox="0 0 40 50" class="tooth-svg">
                                                <path d="M8 45 C8 45, 8 20, 12 10 C16 5, 24 5, 28 10 C32 20, 32 45, 32 45 C30 47, 25 48, 20 48 C15 48, 10 47, 8 45 Z" fill="{{ $fill }}" stroke="#374151" stroke-width="1"/>
                                            </svg>
                                            <div class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 text-xs text-gray-600 font-medium">{{ $i }}</div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <!-- Lower Teeth -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-600 mb-3">Lower Jaw</h3>
                            <div class="flex justify-center">
                                <div class="grid grid-cols-8 gap-2">
                                    @for ($i = 17; $i <= 24; $i++)
                                        @php
                                            $tooth = $toothConditions[$i] ?? null;
                                            $fill = $tooth ? ($conditionColors[$tooth->condition] ?? '#ffffff') : '#ffffff';
                                            $toothData = $tooth ? json_encode($tooth) : '{}';
                                        @endphp
                                        <div class="relative cursor-pointer group tooth-element" data-tooth-number="{{ $i }}" data-tooth='@json($tooth)'>
                                            <svg width="40" height="50" viewBox="0 0 40 50" class="tooth-svg">
                                                <path d="M8 5 C8 5, 8 30, 12 40 C16 45, 24 45, 28 40 C32 30, 32 5, 32 5 C30 3, 25 2, 20 2 C15 2, 10 3, 8 5 Z" fill="{{ $fill }}" stroke="#374151" stroke-width="1"/>
                                            </svg>
                                            <div class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 text-xs text-gray-600 font-medium">{{ $i }}</div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Condition Legend</h4>
                        <div class="grid grid-cols-3 gap-3 text-xs">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-white border border-gray-300 rounded"></div>
                                <span>Healthy</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-red-500 rounded"></div>
                                <span>Decay</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-blue-500 rounded"></div>
                                <span>Filling</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-yellow-500 rounded"></div>
                                <span>Crown</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-gray-500 rounded"></div>
                                <span>Missing</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-green-500 rounded"></div>
                                <span>Implant</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
