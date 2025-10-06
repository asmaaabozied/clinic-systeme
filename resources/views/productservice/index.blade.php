@extends('layouts.admin')
<link href="https://cdn.jsdelivr.net/npm/bootstrap @5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@section('page-title')
    {{__('Manage Product & Services')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Product & Services')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="#" data-size="md" data-bs-toggle="tooltip" title="{{__('Import')}}"
           data-url="{{ route('productservice.file.import') }}" data-ajax-popup="true"
           data-title="{{__('Import product CSV file')}}" class="btn btn-sm bg-brown-subtitle me-1">
            <i class="ti ti-file-import"></i>
        </a>
        <a href="{{route('productservice.export')}}" data-bs-toggle="tooltip" title="{{__('Export')}}"
           class="btn btn-sm btn-secondary me-1">
            <i class="ti ti-file-export"></i>
        </a>

        <a href="#" data-size="lg" data-url="{{ route('productservice.create') }}" data-ajax-popup="true"
           data-bs-toggle="tooltip" data-bs-original-title="{{__('Create')}}"
           data-title="{{__('Create New Product & Service')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>

    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class=" mt-2 {{isset($_GET['category'])?'show':''}}" id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['route' => ['productservice.index'], 'method' => 'GET', 'id' => 'product_service']) }}
                        <div class="d-flex align-items-center justify-content-end">

                            <div class="col-xl-2 col-lg-2 col-md-2 me-1">
                                <div class="btn-box">
                                    {{ Form::label('category', __('Category'),['class'=>'form-label']) }}
                                    {{ Form::select('category', $category, isset($_GET['category']) ? $_GET['category'] : null, ['class' => 'form-control select','id'=>'choices-multiple', 'required' => 'required']) }}
                                </div>
                            </div>


                            <div class="col-xl-2 col-lg-2 col-md-2 me-1">
                                <div class="btn-box">
                                    {{ Form::label('brand_id', __('Brand'),['class'=>'form-label']) }}
                                    {{ Form::select('brand_id', $brands, isset($_GET['brand_id']) ? $_GET['brand_id'] : null, ['class' => 'form-control select', 'required' => 'required']) }}
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 me-1">
                                <div class="btn-box">
                                    {{ Form::label('branch_id', __('Branch'),['class'=>'form-label']) }}
                                    {{ Form::select('branch_id', $branchs, isset($_GET['branch_id']) ? $_GET['branch_id'] : null, ['class' => 'form-control select', 'required' => 'required']) }}
                                </div>
                            </div>

                            <div class="col-xl-2 col-lg-2 col-md-2 me-1">
                                <div class="btn-box">
                                    {{ Form::label('unit_id', __('Unit'),['class'=>'form-label']) }}
                                    {{ Form::select('unit_id', $units, isset($_GET['unit_id']) ? $_GET['unit_id'] : null, ['class' => 'form-control select', 'required' => 'required']) }}
                                </div>
                            </div>
                            {{--                            <div class="col-xl-1 col-lg-1 col-md-1 me-1">--}}
                            {{--                                <div class="btn-box">--}}
                            {{--                                    {{ Form::label('tax_id', __('Tax'),['class'=>'form-label']) }}--}}
                            {{--                                    {{ Form::select('tax_id', $tax, isset($_GET['tax_id']) ? $_GET['tax_id'] : null, ['class' => 'form-control select', 'required' => 'required']) }}--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="col-xl-2 col-lg-2 col-md-2">--}}
                            {{--                                <div class="btn-box">--}}
                            {{--                                    {{ Form::label('type_product', __('Type Product'),['class'=>'form-label']) }}--}}
                            {{--                                    {{ Form::select('type_product',  ['Individual'=>'Individual','Combo'=>'Combo','Contrasting'=>'Contrasting'], isset($_GET['type_product']) ? $_GET['type_product'] : null, ['class' => 'form-control select']) }}--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            <div class="col-auto float-end ms-2 mt-4">
                                <a href="#" class="btn btn-sm btn-primary me-1"
                                   onclick="document.getElementById('product_service').submit(); return false;"
                                   data-bs-toggle="tooltip" title="{{ __('apply') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                <a href="{{ route('productservice.index') }}" class="btn btn-sm btn-danger"
                                   data-bs-toggle="tooltip"
                                   title="{{ __('Reset') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-refresh "></i></span>
                                </a>
                            </div>

                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container mt-4">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">All Products</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Stock Report</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                <div class="row" >
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <table class="table datatable">
                                        <thead>
                                        <tr>
                                            <th>{{__('Image')}}</th>
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Sku')}}</th>
                                            <th>{{__('Sale Price')}}</th>
                                            <th>{{__('Purchase Price')}}</th>
                                            <th>{{__('Tax')}}</th>
                                            <th>{{__('Category')}}</th>
                                            <th>{{__('Brand')}}</th>
                                            <th>{{__('Branch')}}</th>
                                            <th>{{__('Unit')}}</th>
                                            <th>{{__('Quantity')}}</th>
                                            <th>{{__('Type')}}</th>
                                            <th>{{__('Custom Field 1')}}</th>
                                            <th>{{__('Custom Field 2')}}</th>
                                            <th>{{__('Custom Field 3')}}</th>
                                            <th>{{__('Custom Field 4')}}</th>
                                            <th>{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($productServices as $productService)
                                            <tr class="font-style">
                                                <td>
                                                    <img  class="mt-3" width="50" height="50"
                                                          src="{{asset('uploads/products/' . $productService->pro_image)}}" />
                                                </td>
                                                <td>{{ $productService->name}}</td>
                                                <td>{{ $productService->sku }}</td>
                                                <td>{{ \Auth::user()->priceFormat($productService->sale_price) }}</td>
                                                <td>{{  \Auth::user()->priceFormat($productService->purchase_price )}}</td>
                                                <td>
                                                    @if (!empty($productService->tax_id))
                                                        @php
                                                            $itemTaxes = [];
                                                            $getTaxData = Utility::getTaxData();

                                                                foreach (explode(',', $productService->tax_id) as $tax) {
                                                                    $itemTax['name'] = $getTaxData[$tax]['name'];
                                                                    $itemTax['rate'] = $getTaxData[$tax]['rate'] . '%';

                                                                    $itemTaxes[] = $itemTax;

                                                                }
                                                                $productService->itemTax = $itemTaxes;
                                                        @endphp
                                                        @foreach ($productService->itemTax as $tax)

                                                            <span>{{$tax['name'] .' ('.$tax['rate'] .')'}}</span><br>
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ !empty($productService->category)?$productService->category->name:'' }}</td>
                                                <td>{{ !empty($productService->brand)?$productService->brand->name:'' }}</td>
                                                <td>{{ !empty($productService->branch)?$productService->branch->name:'' }}</td>
                                                <td>{{ !empty($productService->unit)?$productService->unit->name:'' }}</td>
                                                @if($productService->type == 'product')
                                                    <td>{{$productService->quantity}}</td>
                                                @else
                                                    <td>-</td>
                                                @endif
                                                <td>{{ucwords($productService->type)}}</td>
                                                <td>{{$productService->field1 ?? ''}}</td>
                                                <td>{{$productService->field2 ?? ''}}</td>
                                                <td>{{$productService->field3 ?? ''}}</td>
                                                <td>{{$productService->field4 ?? ''}}</td>

                                                @if(Gate::check('edit product & service') || Gate::check('delete product & service'))
                                                    <td class="Action">
                                                        <div class="action-btn me-2">
                                                            <a href="#" class="mx-3 btn btn-sm align-items-center bg-warning"
                                                               data-url="{{ route('productservice.detail',$productService->id) }}"
                                                               data-ajax-popup="true" data-bs-toggle="tooltip"
                                                               title="{{__('Product Details')}}"
                                                               data-title="{{__('Product Details')}}">
                                                                <i class="ti ti-eye text-white"></i>
                                                            </a>
                                                        </div>

                                                        @can('edit product & service')
                                                            <div class="action-btn me-2">
                                                                <a href="#" class="mx-3 btn btn-sm  align-items-center bg-info"
                                                                   data-url="{{ route('productservice.edit',$productService->id) }}"
                                                                   data-ajax-popup="true" data-size="lg " data-bs-toggle="tooltip"
                                                                   title="{{__('Edit')}}" data-title="{{__('Edit Product')}}">
                                                                    <i class="ti ti-pencil text-white"></i>
                                                                </a>
                                                            </div>
                                                        @endcan
                                                        @can('delete product & service')
                                                            <div class="action-btn \">
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['productservice.destroy', $productService->id],'id'=>'delete-form-'.$productService->id]) !!}
                                                                <a href="#"
                                                                   class="mx-3 btn btn-sm  align-items-center bs-pass-para bg-danger"
                                                                   data-bs-toggle="tooltip" title="{{__('Delete')}}"><i
                                                                        class="ti ti-trash text-white"></i></a>
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




            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">



                {{--                sTock data start--}}

                <div class="row" >
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <table class="table datatable">
                                        <thead>
                                        <tr>
                                            <th>{{__('Image')}}</th>
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Sku')}}</th>
                                            <th>{{__('Sale Price')}}</th>
                                            <th>{{__('Purchase Price')}}</th>
                                            <th>{{__('Tax')}}</th>
                                            <th>{{__('Category')}}</th>
                                            <th>{{__('Brand')}}</th>
                                            <th>{{__('Branch')}}</th>
                                            <th>{{__('Unit')}}</th>
                                            <th>{{__('Quantity')}}</th>
                                            <th>{{__('Type')}}</th>
                                            <th>{{__('Custom Field 1')}}</th>
                                            <th>{{__('Custom Field 2')}}</th>
                                            <th>{{__('Custom Field 3')}}</th>
                                            <th>{{__('Custom Field 4')}}</th>
                                            <th>{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($productStock as $productService)
                                            <tr class="font-style">
                                                <td>
                                                    <img  class="mt-3" width="100"
                                                         src="{{asset('uploads/products/' . $productService->pro_image)}}" />
                                                </td>
                                                <td>{{ $productService->name}}</td>
                                                <td>{{ $productService->sku }}</td>
                                                <td>{{ \Auth::user()->priceFormat($productService->sale_price) }}</td>
                                                <td>{{  \Auth::user()->priceFormat($productService->purchase_price )}}</td>
                                                <td>
                                                    @if (!empty($productService->tax_id))
                                                        @php
                                                            $itemTaxes = [];
                                                            $getTaxData = Utility::getTaxData();

                                                                foreach (explode(',', $productService->tax_id) as $tax) {
                                                                    $itemTax['name'] = $getTaxData[$tax]['name'];
                                                                    $itemTax['rate'] = $getTaxData[$tax]['rate'] . '%';

                                                                    $itemTaxes[] = $itemTax;

                                                                }
                                                                $productService->itemTax = $itemTaxes;
                                                        @endphp
                                                        @foreach ($productService->itemTax as $tax)

                                                            <span>{{$tax['name'] .' ('.$tax['rate'] .')'}}</span><br>
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ !empty($productService->category)?$productService->category->name:'' }}</td>
                                                <td>{{ !empty($productService->brand)?$productService->brand->name:'' }}</td>
                                                <td>{{ !empty($productService->branch)?$productService->branch->name:'' }}</td>
                                                <td>{{ !empty($productService->unit)?$productService->unit->name:'' }}</td>
                                                @if($productService->type == 'product')
                                                    <td>{{$productService->quantity}}</td>
                                                @else
                                                    <td>-</td>
                                                @endif
                                                <td>{{ucwords($productService->type)}}</td>
                                                <td>{{$productService->field1 ?? ''}}</td>
                                                <td>{{$productService->field2 ?? ''}}</td>
                                                <td>{{$productService->field3 ?? ''}}</td>
                                                <td>{{$productService->field4 ?? ''}}</td>

                                                @if(Gate::check('edit product & service') || Gate::check('delete product & service'))
                                                    <td class="Action">
                                                        <div class="action-btn me-2">
                                                            <a href="#" class="mx-3 btn btn-sm align-items-center bg-warning"
                                                               data-url="{{ route('productservice.detail',$productService->id) }}"
                                                               data-ajax-popup="true" data-bs-toggle="tooltip"
                                                               title="{{__('Products Details')}}"
                                                               data-title="{{__('Products Details')}}">
                                                                <i class="ti ti-eye text-white"></i>
                                                            </a>
                                                        </div>

                                                        @can('edit product & service')
                                                            <div class="action-btn me-2">
                                                                <a href="#" class="mx-3 btn btn-sm  align-items-center bg-info"
                                                                   data-url="{{ route('productservice.edit',$productService->id) }}"
                                                                   data-ajax-popup="true" data-size="lg " data-bs-toggle="tooltip"
                                                                   title="{{__('Edit')}}" data-title="{{__('Edit Product')}}">
                                                                    <i class="ti ti-pencil text-white"></i>
                                                                </a>
                                                            </div>
                                                        @endcan
                                                        @can('delete product & service')
                                                            <div class="action-btn \">
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['productservice.destroy', $productService->id],'id'=>'delete-form-'.$productService->id]) !!}
                                                                <a href="#"
                                                                   class="mx-3 btn btn-sm  align-items-center bs-pass-para bg-danger"
                                                                   data-bs-toggle="tooltip" title="{{__('Delete')}}"><i
                                                                        class="ti ti-trash text-white"></i></a>
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



            </div>
        </div>

    </div>


@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap @5.3.0/dist/js/bootstrap.bundle.min.js"></script>

