@extends('doctor.specialization.dermatology.layout.main')

@section('title', 'Reports - Dermatology')

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
                    Reports & Documentation
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
            <p class="text-gray-600">Please select a patient to generate reports.</p>
        </div>
    </div>
    @endif

    @if($patient)
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Reports & Documentation</h2>
        <p class="text-gray-600 mt-2">Generate comprehensive reports and documentation for patient consultations</p>
    </div>

        <!-- Report Generation -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Generate New Report</h3>

                <form class="space-y-4" id="report-form">
                    <input type="hidden" name="patient_id" id="report-patient-id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Report Type</label>
                            <select name="report_type" class="w-full border border-gray-300 rounded-md px-3 py-2">
                                <option value="consultation">Consultation Report</option>
                                <option value="treatments">Treatments Report</option>
                                <option value="medical_history">Medical History Report</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                            <select class="w-full border border-gray-300 rounded-md px-3 py-2">
                                <option>Last 7 days</option>
                                <option>Last 30 days</option>
                                <option>Last 3 months</option>
                                <option>Custom range</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Include Sections</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600" checked>
                                <span class="ml-2 text-sm text-gray-700">Patient Info</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600" checked>
                                <span class="ml-2 text-sm text-gray-700">Images</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600" checked>
                                <span class="ml-2 text-sm text-gray-700">Measurements</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                                <span class="ml-2 text-sm text-gray-700">3D Models</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                                <span class="ml-2 text-sm text-gray-700">Analysis</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                                <span class="ml-2 text-sm text-gray-700">Recommendations</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                        <textarea rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Add any additional notes or observations..."></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Generate Report
                        </button>
                        <button type="button" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                            Preview
                        </button>
                    </div>
                </form>
            </div>

            <!-- Quick Actions -->
{{--            <div class="space-y-6">--}}
{{--                <div class="bg-white rounded-xl shadow-lg p-6">--}}
{{--                    <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>--}}

{{--                    <div class="space-y-3">--}}
{{--                        <button class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center gap-2">--}}
{{--                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />--}}
{{--                            </svg>--}}
{{--                            Export to PDF--}}
{{--                        </button>--}}

{{--                        <button class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">--}}
{{--                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />--}}
{{--                            </svg>--}}
{{--                            Email Report--}}
{{--                        </button>--}}

{{--                        <button class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors flex items-center justify-center gap-2">--}}
{{--                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />--}}
{{--                            </svg>--}}
{{--                            Share with Team--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <!-- Report Templates -->--}}
{{--                <div class="bg-white rounded-xl shadow-lg p-6">--}}
{{--                    <h3 class="text-lg font-bold text-gray-800 mb-4">Report Templates</h3>--}}

{{--                    <div class="space-y-2">--}}
{{--                        <button class="w-full text-left p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">--}}
{{--                            <p class="font-medium text-gray-800">Standard Consultation</p>--}}
{{--                            <p class="text-sm text-gray-600">Basic patient assessment</p>--}}
{{--                        </button>--}}

{{--                        <button class="w-full text-left p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">--}}
{{--                            <p class="font-medium text-gray-800">Rhinoplasty Analysis</p>--}}
{{--                            <p class="text-sm text-gray-600">Specialized nose surgery report</p>--}}
{{--                        </button>--}}

{{--                        <button class="w-full text-left p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">--}}
{{--                            <p class="font-medium text-gray-800">Progress Tracking</p>--}}
{{--                            <p class="text-sm text-gray-600">Before/after comparison</p>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>

        <!-- Recent Reports -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800">Recent Reports</h3>
                <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All</button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 font-medium text-gray-700">Report Name</th>
                            <th class="text-left py-3 px-4 font-medium text-gray-700">Type</th>
                            <th class="text-left py-3 px-4 font-medium text-gray-700">Patient</th>
                            <th class="text-left py-3 px-4 font-medium text-gray-700">Date</th>
                            <th class="text-left py-3 px-4 font-medium text-gray-700">Status</th>
                            <th class="text-left py-3 px-4 font-medium text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <p class="font-medium text-gray-800">{{ $report->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $report->data['description'] ?? '' }}</p>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">{{ $report->type }}</span>
                                </td>
                                <td class="py-3 px-4 text-gray-700">{{ $report->patient->name ?? '' }}</td>
                                <td class="py-3 px-4 text-gray-700">{{ $report->created_at->format('Y-m-d') }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">{{ ucfirst($report->status) }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex gap-2">
                                        <button class="text-blue-600 hover:text-blue-700 text-sm view-report-btn" data-report-id="{{ $report->id }}">View</button>
                                        <button class="text-green-600 hover:text-green-700 text-sm download-pdf-btn" data-report-id="{{ $report->id }}">Download PDF</button>
                                        <button class="text-purple-600 hover:text-purple-700 text-sm">Share</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-gray-500">No reports found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        </div>
    @endif
</div>

<!-- Report Details Modal -->
<div id="report-details-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Report Details</h3>
                <div class="flex gap-2">
                    <button id="print-report-modal" class="text-gray-600 hover:text-blue-700 flex items-center gap-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2m-6 0v4m0 0h4m-4 0H8"/></svg>
                        Print
                    </button>
                    <button id="download-report-pdf" class="text-green-600 hover:text-green-700 flex items-center gap-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Download PDF
                    </button>
                    <button id="close-report-modal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div id="report-modal-content">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

@push('script-page')
<script>
    // Utility to get patient_id from query string
    function getPatientId() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('patient_id');
    }

    // Set patient_id in hidden input on page load
    document.addEventListener('DOMContentLoaded', function() {
        const pid = getPatientId();
        if (pid) {
            const input = document.getElementById('report-patient-id');
            if (input) input.value = pid;
        }
    });

    // Use getPatientId() in any AJAX or dynamic content loading for patient context.

    // AJAX form submission for report creation
    document.getElementById('report-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        // Collect form data
        const data = {
            patient_id: form.querySelector('[name="patient_id"]').value,
            name: form.querySelector('[name="report_name"]') ? form.querySelector('[name="report_name"]').value : 'Custom Report',
            type: form.querySelector('select').value,
            status: 'completed',
            data: {
                date_range: form.querySelectorAll('select')[1].value,
                sections: Array.from(form.querySelectorAll('input[type=checkbox]:checked')).map(cb => cb.nextElementSibling.textContent.trim()),
                notes: form.querySelector('textarea').value
            }
        };
        fetch("{{ route('doctor.dermatology.reports.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(res => {
            if (res.success) {
                // Optionally, prepend the new report to the table
                location.reload(); // For simplicity, reload to show new report
            } else {
                alert('Failed to create report');
            }
        })
        .catch(() => alert('Error creating report'));
    });

    // Report Details Modal logic
    document.querySelectorAll('.text-blue-600.text-sm').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const reportName = row.querySelector('td').innerText.trim();
            // Find the report ID by matching name (for demo; ideally use data-id)
            const report = @json($reports).find(r => r.name === reportName);
            if (!report) return;
            document.getElementById('report-modal-content').innerHTML = `<div class='text-center'><div class='animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto mb-4'></div><p class='text-gray-600'>Loading report details...</p></div>`;
            document.getElementById('report-details-modal').classList.remove('hidden');
            // Render report data
            setTimeout(() => {
                let html = `<div class='space-y-4'>`;
                html += `<div><h4 class='font-semibold text-gray-900 mb-2'>Report Name</h4><p>${report.name}</p></div>`;
                html += `<div><h4 class='font-semibold text-gray-900 mb-2'>Type</h4><p>${report.type}</p></div>`;
                html += `<div><h4 class='font-semibold text-gray-900 mb-2'>Status</h4><p>${report.status}</p></div>`;
                html += `<div><h4 class='font-semibold text-gray-900 mb-2'>Created At</h4><p>${report.created_at}</p></div>`;
                // Consultations
                if (report.data.consultations && report.data.consultations.length) {
                    html += `<div><h4 class='font-semibold text-blue-700 mb-2'>Consultations</h4><ul class='list-disc pl-5'>`;
                    report.data.consultations.forEach(c => {
                        html += `<li><b>Chief Complaint:</b> ${c.chief_complaint || ''} <b>Medical History:</b> ${c.medical_history || ''}</li>`;
                    });
                    html += `</ul></div>`;
                }
                // Assessments
                if (report.data.assessments && report.data.assessments.length) {
                    html += `<div><h4 class='font-semibold text-blue-700 mb-2'>Assessments</h4><ul class='list-disc pl-5'>`;
                    report.data.assessments.forEach(a => {
                        html += `<li><b>Facial Symmetry:</b> ${a.facial_symmetry || ''} <b>Skin Quality:</b> ${a.skin_quality || ''}</li>`;
                    });
                    html += `</ul></div>`;
                }
                // Recommendations
                if (report.data.recommendations && report.data.recommendations.length) {
                    html += `<div><h4 class='font-semibold text-blue-700 mb-2'>Recommendations</h4><ul class='list-disc pl-5'>`;
                    report.data.recommendations.forEach(r => {
                        html += `<li><b>Treatment:</b> ${r.treatment_recommendations || ''} <b>Alternatives:</b> ${r.alternative_options || ''}</li>`;
                    });
                    html += `</ul></div>`;
                }
                // Image Analyses
                if (report.data.image_analyses && report.data.image_analyses.length) {
                    html += `<div><h4 class='font-semibold text-blue-700 mb-2'>Image Analyses</h4><ul class='list-disc pl-5'>`;
                    report.data.image_analyses.forEach(img => {
                        html += `<li><b>Type:</b> ${img.image_type || ''} <b>Result:</b> ${img.analysis_results || ''} <b>Confidence:</b> ${img.confidence_score || ''}%`;
                        if (img.before_image) html += `<br><img src='/storage/${img.before_image}' alt='Before' class='inline-block h-16 rounded mr-2'>`;
                        if (img.after_image) html += `<img src='/storage/${img.after_image}' alt='After' class='inline-block h-16 rounded'>`;
                        html += `</li>`;
                    });
                    html += `</ul></div>`;
                }
                // Measurements
                if (report.data.measurements && report.data.measurements.length) {
                    html += `<div><h4 class='font-semibold text-blue-700 mb-2'>Measurements</h4><ul class='list-disc pl-5'>`;
                    report.data.measurements.forEach(m => {
                        html += `<li><b>Name:</b> ${m.name || ''} <b>Value:</b> ${m.value || ''} ${m.unit || ''}</li>`;
                    });
                    html += `</ul></div>`;
                }
                html += `</div>`;
                document.getElementById('report-modal-content').innerHTML = html;
            }, 500);
        });
    });
    document.getElementById('close-report-modal').addEventListener('click', function() {
        document.getElementById('report-details-modal').classList.add('hidden');
    });
    document.getElementById('report-details-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });

    // Print report modal content
    document.getElementById('print-report-modal').addEventListener('click', function() {
        const printContents = document.getElementById('report-modal-content').innerHTML;
        const printWindow = window.open('', '', 'height=800,width=900');
        printWindow.document.write('<html><head><title>Print Report</title>');
        printWindow.document.write('<link rel="stylesheet" href="/css/dermatology/app.css">');
        printWindow.document.write('</head><body>');
        printWindow.document.write(printContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        setTimeout(() => { printWindow.print(); printWindow.close(); }, 500);
    });

    // Download PDF button logic
    document.querySelectorAll('.download-pdf-btn').forEach(button => {
        button.addEventListener('click', function() {
            const reportId = this.getAttribute('data-report-id');
            window.open(`{{ url('doctor/dermatology/reports') }}/${reportId}/pdf`, '_blank');
        });
    });
</script>
@endpush
@endsection
