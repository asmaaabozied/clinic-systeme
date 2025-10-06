 @extends('layouts.admin')
@section('page-title')
    {{__('Manage Brands')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Brand')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">

        <a href="#" data-size="lg" data-url="{{ route('brands.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-original-title="{{__('Create')}}" data-title="{{__('Create New Brand')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>

    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class=" mt-2 {{isset($_GET['category'])?'show':''}}" id="multiCollapseExample1">
                <div class="card">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Image')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Description')}}</th>

                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($brands as $dat)
                                <tr class="font-style">
<td>
                                    <img id="image" class="mt-3" width="100"
                                         src="{{asset('uploads/' . $dat->image)}}" />


</td>
                                    <td>{{ $dat->name}}</td>
                                    <td>{{ $dat->description }}</td>
                                    @if(Gate::check('edit product & service') || Gate::check('delete product & service'))
                                        <td class="Action">
{{--                                            @can('edit product & service')--}}
{{--                                                <div class="action-btn me-2">--}}
{{--                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bg-info" data-url="{{ route('brands.edit',$dat->id) }}" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Edit Product')}}">--}}
{{--                                                        <i class="ti ti-pencil text-white"></i>--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}
{{--                                            @endcan--}}
                                            @can('delete product & service')
                                                <div class="action-btn \">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['brands.destroy', $dat->id],'id'=>'delete-form-'.$dat->id]) !!}
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

