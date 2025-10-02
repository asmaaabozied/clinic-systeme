<?php

namespace App\Http\Controllers\Api\Medical;

use App\Http\Controllers\Controller;
use App\Models\DoctorSpecialization;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Resources\Medical\SpecializationResource;
use Yajra\DataTables\Facades\DataTables;

class SpecializationController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = DoctorSpecialization::query();
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $specializations = $query->paginate($perPage);
        return $this->successResponse(
            SpecializationResource::collection($specializations->items()),
            'Specializations fetched successfully',
            200,
            [
                'meta' => [
                    'current_page' => $specializations->currentPage(),
                    'last_page' => $specializations->lastPage(),
                    'per_page' => $specializations->perPage(),
                    'total' => $specializations->total(),
                ]
            ]
        );
    }

    /**
     * DataTables.net endpoint for server-side processing
     */
    public function datatable(Request $request)
    {
        $query = DoctorSpecialization::query();

        return DataTables::of($query)
            ->addColumn('actions', function ($specialization) {
                return view('api.medical.specializations.actions', compact('specialization'))->render();
            })
            ->addColumn('doctors_count', function ($specialization) {
                return $specialization->doctors()->count();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:doctor_specializations,name',
        ]);
        $specialization = DoctorSpecialization::create($validated);
        return $this->successResponse(new SpecializationResource($specialization), 'Specialization created successfully', 201);
    }

    public function show($id)
    {
        $specialization = DoctorSpecialization::findOrFail($id);
        return $this->successResponse(new SpecializationResource($specialization), 'Specialization fetched successfully');
    }

    public function update(Request $request, $id)
    {
        $specialization = DoctorSpecialization::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|unique:doctor_specializations,name,' . $id,
        ]);
        $specialization->update($validated);
        return $this->successResponse(new SpecializationResource($specialization), 'Specialization updated successfully');
    }

    public function destroy($id)
    {
        $specialization = DoctorSpecialization::findOrFail($id);
        $specialization->delete();
        return $this->successResponse(null, 'Specialization deleted successfully');
    }

    public function search(Request $request)
    {
        $q = $request->input('q');
        $specializations = DoctorSpecialization::where('name', 'like', "%$q%")
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        return $this->successResponse(SpecializationResource::collection($specializations), 'Search results');
    }

    public function doctors($id)
    {
        $specialization = DoctorSpecialization::with('doctors.user')->findOrFail($id);
        $doctors = $specialization->doctors->map(function($doctor) {
            return [
                'id' => $doctor->id,
                'name' => $doctor->user->name ?? null,
            ];
        });
        return $this->successResponse($doctors, 'Doctors for specialization fetched successfully');
    }
} 