<?php

namespace App\Http\Controllers\Api\Medical;

use App\Http\Controllers\Controller;
use App\Models\MedicineCategory;
use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Resources\Medical\MedicineCategoryResource;
use Yajra\DataTables\Facades\DataTables;

class MedicineCategoryController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = MedicineCategory::query();
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $medicineCategories = $query->paginate($perPage);
        return $this->successResponse(
            MedicineCategoryResource::collection($medicineCategories->items()),
            'Medicine categories fetched successfully',
            200,
            [
                'meta' => [
                    'current_page' => $medicineCategories->currentPage(),
                    'last_page' => $medicineCategories->lastPage(),
                    'per_page' => $medicineCategories->perPage(),
                    'total' => $medicineCategories->total(),
                ]
            ]
        );
    }

    /**
     * DataTables.net endpoint for server-side processing
     */
    public function datatable(Request $request)
    {
        $query = MedicineCategory::query();

        return DataTables::of($query)
            ->addColumn('actions', function ($medicineCategory) {
                return view('api.medical.medicine-categories.actions', compact('medicineCategory'))->render();
            })
            ->addColumn('medicines_count', function ($medicineCategory) {
                return $medicineCategory->medicines()->count();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:medicine_categories,name',
        ]);
        $medicineCategory = MedicineCategory::create($validated);
        return $this->successResponse(new MedicineCategoryResource($medicineCategory), 'Medicine category created successfully', 201);
    }

    public function show($id)
    {
        $medicineCategory = MedicineCategory::findOrFail($id);
        return $this->successResponse(new MedicineCategoryResource($medicineCategory), 'Medicine category fetched successfully');
    }

    public function update(Request $request, $id)
    {
        $medicineCategory = MedicineCategory::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|unique:medicine_categories,name,' . $id,
        ]);
        $medicineCategory->update($validated);
        return $this->successResponse(new MedicineCategoryResource($medicineCategory), 'Medicine category updated successfully');
    }

    public function destroy($id)
    {
        $medicineCategory = MedicineCategory::findOrFail($id);
        $medicineCategory->delete();
        return $this->successResponse(null, 'Medicine category deleted successfully');
    }


} 