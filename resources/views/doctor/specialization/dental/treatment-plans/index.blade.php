@extends('layouts.admin')

@section('page-title')
    {{ __('Treatment Plans') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('doctor.dental.dashboard') }}">{{ __('Dental Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Plans History') }}</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Stage') }}</th>
                            <th>{{ __('Start Date') }}</th>
                            <th>{{ __('Estimated Completion') }}</th>
                            <th>{{ __('Estimated Cost') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                            <tr>
                                <td>{{ $plan->title }}</td>
                                <td>{{ ucfirst(str_replace('-', ' ', $plan->stage)) }}</td>
                                <td>{{ $plan->start_date?->format('Y-m-d') }}</td>
                                <td>{{ $plan->estimated_completion?->format('Y-m-d') }}</td>
                                <td>{{ $plan->estimated_cost }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">{{ __('No treatment plans found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $plans->links() }}
            </div>
        </div>
    </div>
@endsection
