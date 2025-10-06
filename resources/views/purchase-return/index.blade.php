@extends('layouts.admin')
<script src="https://code.jquery.com/jquery-3.6.0.min.js "></script>

@section('page-title')
    @if(request()->is('sales-return'))
        {{__('Sales Return')}}
@else
        {{__('Purchase Return')}}

    @endif
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">

        @if(request()->is('sales-return'))
            {{__('Sales Return')}}


        @else
            {{__('Purchase Return')}}
        @endif
    </li>
@endsection
@section('action-btn')
    <div class="float-end">
        @if(request()->is('sales-return'))
            <a href="#" data-size="lg" data-url="{{ route('sales-return.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create Sales Return')}}"  class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @else
        <a href="#" data-size="lg" data-url="{{ route('purchase-return.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create Purchase Return')}}"  class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
        @endif
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
                                <th>{{__('quantity')}}</th>
                                <th>{{__('Reference number')}}</th>
                                <th>{{__('Total')}}</th>
                                <th>{{__('Product Name')}}</th>
                                <th>{{__('Branch Name')}}</th>
                                <th>{{__('Created At')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $warehouse)
                                <tr class="font-style">
                                    <td>{{ $warehouse->date}}</td>
                                    <td>{{ $warehouse->quantity }}</td>
                                    <td>{{ $warehouse->number }}</td>
                                    <td>{{ $warehouse->total }}</td>
                                    <td>{{ $warehouse->product->name ?? '' }}</td>
                                    <td>{{ $warehouse->branch->name ?? '' }}</td>
                                    <td>{{ $warehouse->created_at->diffForHumans() ?? '' }}</td>

                                    @if(Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase'))
                                        <td class="Action">

                                            @can('edit purchase')
                                                <div class="action-btn me-2">
                                                    <a href="{{ route('purchase-return.edit',$warehouse->id) }}" class="mx-3 btn btn-sm  align-items-center bg-info" data-url="{{ route('purchase-return.edit',$warehouse->id) }}" data-ajax-popup="false"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Edit purchase-return')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan
                                            @can('delete purchase')
                                                <div class="action-btn ">

                                                    @if(request()->is('sales-return'))
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['sales-return.destroy', $warehouse->id],'id'=>'delete-form-'.$warehouse->id]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para bg-danger" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white"></i></a>
                                                    {!! Form::close() !!}

                                                    @else
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['purchase-return.destroy', $warehouse->id],'id'=>'delete-form-'.$warehouse->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para bg-danger" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white"></i></a>
                                                        {!! Form::close() !!}
                                                    @endif
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
