@extends('layouts.admin')
<script src="https://code.jquery.com/jquery-3.6.0.min.js "></script>

@section('page-title')
    {{__('Damaged Stocks')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Damaged Stocks')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">

        <a href="#" data-size="lg" data-url="{{ route('damaged_stocks.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create Damaged Stocks')}}"  class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>

    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Type of damage')}}</th>
                                <th>{{__('Reference number')}}</th>
                                <th>{{__('Total')}}</th>
                                <th>{{__('Reason')}}</th>
                                <th>{{__('Product Name')}}</th>
                                <th>{{__('Branch Name')}}</th>
                                <th>{{__('Created By')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $warehouse)
                                <tr class="font-style">
                                    <td>{{ $warehouse->date}}</td>
                                    <td>{{ $warehouse->type }}</td>
                                    <td>{{ $warehouse->number }}</td>
                                    <td>{{ $warehouse->total }}</td>
                                    <td>{{ $warehouse->description }}</td>
                                    <td>{{ $warehouse->product->name ?? '' }}</td>
                                    <td>{{ $warehouse->branch->name ?? '' }}</td>
                                    <td>{{ $warehouse->created_by }}</td>

                                    @if(Gate::check('show warehouse') || Gate::check('edit warehouse') || Gate::check('delete warehouse'))
                                        <td class="Action">

                                            @can('edit warehouse')
                                                <div class="action-btn me-2">
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bg-info" data-url="{{ route('damaged_stocks.edit',$warehouse->id) }}" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Edit Damaged Stocks')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan
                                            @can('delete warehouse')
                                                <div class="action-btn ">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['damaged_stocks.destroy', $warehouse->id],'id'=>'delete-form-'.$warehouse->id]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para bg-danger" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white"></i></a>
                                                    {!! Form::close() !!}
                                                </div>
                                            @endcan
                                        </td>
                                    @endif
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
