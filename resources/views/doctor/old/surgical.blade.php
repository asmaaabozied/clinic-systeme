@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Surgical Cases</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($surgicalCases as $case)
                                        <tr>
                                            <td>{{ $case->patient->name }}</td>
                                            <td>{{ $case->appointment_date->format('M d, Y') }}</td>
                                            <td>
                                                <span class="badge bg-danger">Emergency</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('patients.show', $case->patient->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No surgical cases found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $surgicalCases->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
