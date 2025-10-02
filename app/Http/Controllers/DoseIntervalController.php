<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoseInterval;

class DoseIntervalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doses = DoseInterval::all();
        return view('dose_interval.index', compact('doses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dose_interval.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:dose_intervals,name',
        ]);

        DoseInterval::create($validated);

        return redirect()->route('dose_intervals.index')->with('success', 'Dose Interval created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dose = DoseInterval::findOrFail($id);
        return view('dose_interval.show', compact('dose'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dose = DoseInterval::findOrFail($id);
        return view('dose_interval.edit', compact('dose'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dose = DoseInterval::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|unique:dose_intervals,name,' . $id,
        ]);

        $dose->update($validated);

        return redirect()->route('dose_intervals.index')->with('success', 'Dose Interval updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dose = DoseInterval::findOrFail($id);
        $dose->delete();

        return redirect()->route('dose_intervals.index')->with('success', 'Dose Interval deleted successfully.');
    }

    public function livesearch(Request $request)
    {
        $query = $request->input('q');
        $doses = DoseInterval::query()
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        return response()->json(['specializations' => $doses]);
    }
}
