<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dose;

class DoseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doses = Dose::all();
        return view('dose.index', compact('doses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:doses,name',
        ]);

        Dose::create($validated);

        return redirect()->route('doses.index')->with('success', 'Dose created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dose = Dose::findOrFail($id);
        return view('doses.show', compact('dose'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dose = Dose::findOrFail($id);
        return view('doses.edit', compact('dose'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dose = Dose::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|unique:doses,name,' . $id,
        ]);

        $dose->update($validated);

        return redirect()->route('doses.index')->with('success', 'Dose updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dose = Dose::findOrFail($id);
        $dose->delete();

        return redirect()->route('doses.index')->with('success', 'Dose deleted successfully.');
    }

    public function livesearch(Request $request)
    {
        $query = $request->input('q');
        $doses = Dose::query()
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        return response()->json(['specializations' => $doses]);
    }
}
