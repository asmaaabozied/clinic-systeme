            <div class="space-y-8">
                <!-- Treatment History -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Treatment History & Notes
                        </h2>
                        <button onclick="openModal('add-treatment-modal')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Treatment
                        </button>
                    </div>

                                        <div class="space-y-4 max-h-96 overflow-y-auto">
                        @forelse($treatmentRecords as $record)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $record->procedure }}</h3>
                                        <div class="flex items-center gap-4 text-sm text-gray-600 mt-1">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a2 2 0 11-4 0 2 2 0 014 0zM8 11a4 4 0 118 0v2H8v-2z" />
                                                </svg>
                                                {{ $record->date?->format('F j, Y') }}
                                            </span>
                                            @if($record->tooth_numbers)
                                                <span>{{ __('Teeth:') }} {{ implode(', ', $record->tooth_numbers) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ ucfirst($record->status) }}</span>
                                        @if($record->cost)
                                            <p class="text-sm font-medium text-green-600 mt-1 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                                </svg>
                                                ${{ $record->cost }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                @if($record->notes)
                                    <div class="mt-3 p-3 bg-gray-100 rounded-md">
                                        <p class="text-sm text-gray-700 flex items-start gap-2">
                                            <svg class="w-4 h-4 text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            {{ $record->notes }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-500">{{ __('No treatment records found.') }}</p>
                        @endforelse
                    </div>

            </div>
        </div>
    </div>
