<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoseDuration;

class DoseDurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doses = DoseDuration::all();
        return view('dose_duration.index', compact('doses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dose_duration.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:dose_durations,name',
        ]);

        DoseDuration::create($validated);

        return redirect()->route('dose_durations.index')->with('success', 'Dose Duration created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dose = DoseDuration::findOrFail($id);
        return view('dose_duration.show', compact('dose'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dose = DoseDuration::findOrFail($id);
        return view('dose_duration.edit', compact('dose'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dose = DoseDuration::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|unique:dose_durations,name,' . $id,
        ]);

        $dose->update($validated);

        return redirect()->route('dose_durations.index')->with('success', 'Dose Duration updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dose = DoseDuration::findOrFail($id);
        $dose->delete();

        return redirect()->route('dose_durations.index')->with('success', 'Dose Duration deleted successfully.');
    }

    public function livesearch(Request $request)
    {
        $query = $request->input('q');
        $doses = DoseDuration::query()
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        return response()->json(['specializations' => $doses]);
    }
}
