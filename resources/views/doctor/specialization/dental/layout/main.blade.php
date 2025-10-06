@push('script-page')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/dental/app.js') }}"></script>
@endpush

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Dental Dashboard') }}</title>
    <link rel="stylesheet" href="{{ asset('css/dental/app.css') }}">
</head>
<body class="bg-gray-50">
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <h1 class="text-2xl font-bold text-gray-900">Dental Diagnosis System</h1>
            <p class="text-gray-600">Comprehensive patient dental care management</p>
            <a href="{{ route('doctor.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-home"></i> Home
            </a>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="space-y-8">
                @include('doctor.specialization.dental.partials.patient-overview')
                @include('doctor.specialization.dental.partials.oral-health-assessment')
            </div>
            <div class="space-y-8">
                @include('doctor.specialization.dental.partials.treatment-and-chart', ['toothConditions' => $toothConditions])
            </div>
            <div class="space-y-8">
                @include('doctor.specialization.dental.partials.treatment-history')
            </div>
        </div>
    </div>
    @include('doctor.specialization.dental.partials.modals')

    @stack('script-page')
</body>
</html>
