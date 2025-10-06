{{ Form::open(array('url' => 'warehouse', 'class'=>'needs-validation', 'novalidate')) }}
<div class="modal-body">
    {{-- start for ai module--}}
    @php
        $plan= \App\Models\Utility::getChatGPTSettings();
    @endphp
    @if($plan->chatgpt == 1)
    <div class="text-end">
        <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true" data-url="{{ route('generate',['warehouse']) }}"
           data-bs-placement="top" data-title="{{ __('Generate content with AI') }}">
            <i class="fas fa-robot"></i> <span>{{__('Generate with AI')}}</span>
        </a>
    </div>
    @endif
    {{-- end for ai module--}}
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}<x-required></x-required>
            {{ Form::text('name', '', array('class' => 'form-control','required'=>'required', 'placeholder' => __('Enter Name'))) }}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('address',__('Address'),array('class'=>'form-label')) }}<x-required></x-required>
            {{Form::textarea('address',null,array('class'=>'form-control','rows'=>3 ,'required'=>'required', 'placeholder' => __('Enter Address')))}}
        </div>

        <div class="form-group col-md-6">
            <div class="form-group">
                <div class="btn-box">
                    <label class="d-block form-label">{{__('Type')}}</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input type" id="customRadio5" name="type" value="main" checked="checked" >
                                <label class="custom-control-label form-label" for="customRadio5">{{__('Main')}}</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input type" id="customRadio6" name="type" value="sub" >
                                <label class="custom-control-label form-label" for="customRadio6">{{__('Sub')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 form-group" style="display: none" id="selectedAllDoctor">
            {{ Form::label('doctor_id', __('Doctor'),['class'=>'form-label']) }}
            {{ Form::select('doctor_id', $doctors,null, array('class' => 'form-control select2')) }}
            <div class=" text-xs mt-1">
                {{__('Create Doctors here. ')}}<a href="{{route('doctors.index')}}"><b>{{__('Create doctors')}}</b></a>
            </div>
        </div>
        {{--        <div class="form-group col-md-6">--}}
{{--            {{Form::label('city',__('City'),array('class'=>'form-label')) }}<x-required></x-required>--}}
{{--            {{Form::text('city',null,array('class'=>'form-control', 'required'=>'required', 'placeholder' => __('Enter City')))}}--}}
{{--        </div>--}}
{{--        <div class="form-group col-md-6">--}}
{{--            {{Form::label('city_zip',__('Zip Code'),array('class'=>'form-label')) }}--}}
{{--            {{Form::text('city_zip',null,array('class'=>'form-control', 'placeholder' => __('Enter Zip')))}}--}}
{{--        </div>--}}

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-secondary" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}


<!-- JavaScript to toggle visibility -->
<script>
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const div = document.getElementById('selectedAllDoctor');

            if (this.value === 'sub') {
                div.style.display = 'block';
            } else {
                div.style.display = 'none';
            }
        });
    });
</script>
