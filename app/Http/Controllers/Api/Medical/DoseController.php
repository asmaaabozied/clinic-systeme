<?php

namespace App\Http\Controllers\Api\Medical;

use App\Http\Controllers\Controller;
use App\Models\Dose;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Resources\Medical\DoseResource;
use Yajra\DataTables\Facades\DataTables;

class DoseController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = Dose::query();
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $doses = $query->paginate($perPage);
        return $this->successResponse(
            DoseResource::collection($doses->items()),
            'Doses fetched successfully',
            200,
            [
                'meta' => [
                    'current_page' => $doses->currentPage(),
                    'last_page' => $doses->lastPage(),
                    'per_page' => $doses->perPage(),
                    'total' => $doses->total(),
                ]
            ]
        );
    }

    /**
     * DataTables.net endpoint for server-side processing
     */
    public function datatable(Request $request)
    {
        $query = Dose::query();

        return DataTables::of($query)
            ->addColumn('actions', function ($dose) {
                return view('api.medical.doses.actions', compact('dose'))->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:doses,name',
        ]);
        $dose = Dose::create($validated);
        return $this->successResponse(new DoseResource($dose), 'Dose created successfully', 201);
    }

    public function show($id)
    {
        $dose = Dose::findOrFail($id);
        return $this->successResponse(new DoseResource($dose), 'Dose fetched successfully');
    }

    public function update(Request $request, $id)
    {
        $dose = Dose::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|unique:doses,name,' . $id,
        ]);
        $dose->update($validated);
        return $this->successResponse(new DoseResource($dose), 'Dose updated successfully');
    }

    public function destroy($id)
    {
        $dose = Dose::findOrFail($id);
        $dose->delete();
        return $this->successResponse(null, 'Dose deleted successfully');
    }
} 