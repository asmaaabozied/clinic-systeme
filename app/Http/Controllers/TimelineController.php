<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class TimelineController extends Controller
{
    public function index($patientId)
    {
        $timelines = Timeline::where('patient_id', $patientId)->latest()->get();

        $html = Blade::render('
        @if($timelines->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Description</th>
                         <th>document</th>
                        <th>Visible</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($timelines as $timeline)
                        <tr>
                            <td>{{ $timeline->title }}</td>
                            <td>{{ $timeline->date }}</td>
                            <td>{{ $timeline->description }}</td>
                                <td>
                                @if($timeline->document)
                                    <a href="{{ asset("storage/" . $timeline->document) }}" target="_blank">View Document</a>
                                @endif</td>
                            <td>{{ $timeline->visible_to_patient ? "Yes" : "No" }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">No timelines found.</div>
        @endif
    ', ['timelines' => $timelines]);

        return response()->json(['html' => $html]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
            'patient_id' => 'required|exists:patients,id',
            'visible_to_patient' => 'nullable|in:on,off',
        ]);

        $path = null;
        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('documents', 'public');
        }

        Timeline::create([
            'title' => $request->title,
            'date' => $request->date,
            'description' => $request->description,
            'document' => $path,
            'patient_id' => $request->patient_id,
            'visible_to_patient' => $request->boolean('visible_to_patient'),
        ]);

        return response()->json(['message' => 'Timeline saved successfully']);
    }
}
