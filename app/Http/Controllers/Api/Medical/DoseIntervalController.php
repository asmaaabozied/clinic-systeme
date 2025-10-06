<?php

namespace App\Http\Controllers\Api\Medical;

use App\Http\Controllers\Controller;
use App\Models\DoseInterval;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Resources\Medical\DoseIntervalResource;
use Yajra\DataTables\Facades\DataTables;

class DoseIntervalController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = DoseInterval::query();
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $doseIntervals = $query->paginate($perPage);
        return $this->successResponse(
            DoseIntervalResource::collection($doseIntervals->items()),
            'Dose intervals fetched successfully',
            200,
            [
                'meta' => [
                    'current_page' => $doseIntervals->currentPage(),
                    'last_page' => $doseIntervals->lastPage(),
                    'per_page' => $doseIntervals->perPage(),
                    'total' => $doseIntervals->total(),
                ]
            ]
        );
    }

    /**
     * DataTables.net endpoint for server-side processing
     */
    public function datatable(Request $request)
    {
        $query = DoseInterval::query();

        return DataTables::of($query)
            ->addColumn('actions', function ($doseInterval) {
                return view('api.medical.dose-intervals.actions', compact('doseInterval'))->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:dose_intervals,name',
        ]);
        $doseInterval = DoseInterval::create($validated);
        return $this->successResponse(new DoseIntervalResource($doseInterval), 'Dose interval created successfully', 201);
    }

    public function show($id)
    {
        $doseInterval = DoseInterval::findOrFail($id);
        return $this->successResponse(new DoseIntervalResource($doseInterval), 'Dose interval fetched successfully');
    }

    public function update(Request $request, $id)
    {
        $doseInterval = DoseInterval::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|unique:dose_intervals,name,' . $id,
        ]);
        $doseInterval->update($validated);
        return $this->successResponse(new DoseIntervalResource($doseInterval), 'Dose interval updated successfully');
    }

    public function destroy($id)
    {
        $doseInterval = DoseInterval::findOrFail($id);
        $doseInterval->delete();
        return $this->successResponse(null, 'Dose interval deleted successfully');
    }
} 