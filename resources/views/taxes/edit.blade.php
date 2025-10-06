@extends('layouts.admin')

@section('content')
<div class="container bg-white p-4 shadow">
    <h1>Edit Tax</h1>
    {{ Form::model($tax, array('route' => array('taxes.update', $tax->id), 'method' => 'PUT', 'class'=>'needs-validation', 'novalidate')) }}
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-6">
                {{ Form::label('name', __('Tax Rate Name'),['class'=>'form-label']) }}<x-required></x-required>
                {{ Form::text('name', null, array('class' => 'form-control font-style','required'=>'required', 'placeholder'=>__('Enter Tax Rate Name'))) }}
                @error('name')
                <small class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
            <div class="form-group col-md-6">
                {{ Form::label('rate', __('Tax Rate %'),['class'=>'form-label']) }}<x-required></x-required>
                {{ Form::number('rate', null, array('class' => 'form-control','required'=>'required','step'=>'0.01', 'placeholder'=>__('Enter Rate'))) }}
                @error('rate')
                <small class="invalid-rate" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn  btn-secondary" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
    </div>
    {{ Form::close() }}
</div>
@endsection
