@php
$type = $report->type;
$data = $report->data;
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Report PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h2 { color: #2d3748; margin-top: 24px; }
        .section { margin-bottom: 24px; }
        .section ul { margin: 0; padding-left: 20px; }
        .section li { margin-bottom: 6px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Patient Report</h1>
    <p><span class="label">Patient:</span> {{ $report->patient->name ?? '' }}</p>
    <p><span class="label">Doctor:</span> {{ $report->doctor->name ?? '' }}</p>
    <p><span class="label">Type:</span> {{ ucfirst($type) }}</p>
    <p><span class="label">Date:</span> {{ $report->created_at->format('Y-m-d') }}</p>

    @if($type === 'consultation')
        <div class="section">
            <h2>Consultations</h2>
            <ul>
                @foreach($data['consultations'] ?? [] as $c)
                    <li>
                        <span class="label">Chief Complaint:</span> {{ $c['chief_complaint'] ?? '' }}<br>
                        <span class="label">Medical History:</span> {{ $c['medical_history'] ?? '' }}
                    </li>
                @endforeach
            </ul>
        </div>
    @elseif($type === 'treatments')
        <div class="section">
            <h2>Treatments</h2>
            <ul>
                @foreach($data['recommendations'] ?? [] as $r)
                    <li>
                        <span class="label">Treatment:</span> {{ $r['treatment_recommendations'] ?? '' }}<br>
                        <span class="label">Alternatives:</span> {{ $r['alternative_options'] ?? '' }}<br>
                        <span class="label">Estimated Cost:</span> {{ $r['estimated_cost'] ?? '' }}<br>
                        <span class="label">Recovery Time:</span> {{ $r['recovery_time'] ?? '' }}
                    </li>
                @endforeach
            </ul>
        </div>
    @elseif($type === 'medical_history')
        <div class="section">
            <h2>Consultations</h2>
            <ul>
                @foreach($data['consultations'] ?? [] as $c)
                    <li>
                        <span class="label">Chief Complaint:</span> {{ $c['chief_complaint'] ?? '' }}<br>
                        <span class="label">Medical History:</span> {{ $c['medical_history'] ?? '' }}
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="section">
            <h2>Assessments</h2>
            <ul>
                @foreach($data['assessments'] ?? [] as $a)
                    <li>
                        <span class="label">Facial Symmetry:</span> {{ $a['facial_symmetry'] ?? '' }}<br>
                        <span class="label">Skin Quality:</span> {{ $a['skin_quality'] ?? '' }}
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="section">
            <h2>Recommendations</h2>
            <ul>
                @foreach($data['recommendations'] ?? [] as $r)
                    <li>
                        <span class="label">Treatment:</span> {{ $r['treatment_recommendations'] ?? '' }}<br>
                        <span class="label">Alternatives:</span> {{ $r['alternative_options'] ?? '' }}
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="section">
            <h2>Image Analyses</h2>
            <ul>
                @foreach($data['image_analyses'] ?? [] as $img)
                    <li>
                        <span class="label">Type:</span> {{ $img['image_type'] ?? '' }}<br>
                        <span class="label">Result:</span> {{ $img['analysis_results'] ?? '' }}<br>
                        <span class="label">Confidence:</span> {{ $img['confidence_score'] ?? '' }}%
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="section">
            <h2>Measurements</h2>
            <ul>
                @foreach($data['measurements'] ?? [] as $m)
                    <li>
                        <span class="label">Name:</span> {{ $m['name'] ?? '' }}<br>
                        <span class="label">Value:</span> {{ $m['value'] ?? '' }} {{ $m['unit'] ?? '' }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html> 