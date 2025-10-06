{{Form::model($user,array('route' => array('users.update', $user->id), 'method' => 'PUT', 'class'=>'needs-validation','novalidate')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group ">
                {{Form::label('name',__('Name'),['class'=>'form-label']) }}<x-required></x-required>
                {{Form::text('name',null,array('class'=>'form-control font-style','placeholder'=>__('Enter User Name'), 'required' => 'required'))}}
                @error('name')
                <small class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('email',__('Email'),['class'=>'form-label'])}}<x-required></x-required>
                {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter User Email'), 'required' => 'required'))}}
                @error('email')
                <small class="invalid-email" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        @if(\Auth::user()->type != 'super admin')
            <div class="form-group col-md-6">
                {{ Form::label('role', __('User Role'),['class'=>'form-label']) }}<x-required></x-required>
                {!! Form::select('role', $roles, $user->roles,array('class' => 'form-control select','required'=>'required')) !!}
                <div class="text-xs mt-1">
                    {{ __('Create role here.') }} <a href="{{ route('roles.index') }}"><b>{{ __('Create role') }}</b></a>
                </div>
                @error('role')
                <small class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
            <div class="form-group col-md-6 doctor_specialization_div d-none">
                {{ Form::label('doctor_specialization_id', __('Doctor Specialization'),['class'=>'form-label']) }}<x-required></x-required>
                {!! Form::select('doctor_specialization_id', $specializations, optional($user->doctor)->specialization_id, ['class' => 'form-control select', 'id' => 'doctor_specialization_id']) !!}
            </div>
        @endif
        @if(!$customFields->isEmpty())
                    @include('customFields.formBuilder')
        @endif
    </div>

</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-secondary"data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>

{{Form::close()}}

<script>
    function toggleSpecialization(selectEl) {
        let roleName = selectEl.find('option:selected').text().trim();
        if (roleName === 'Doctor') {
            $('.doctor_specialization_div').removeClass('d-none');
            $('#doctor_specialization_id').attr('required', true);
        } else {
            $('.doctor_specialization_div').addClass('d-none');
            $('#doctor_specialization_id').val(null).removeAttr('required');
        }
    }

    $(document).on('change', 'select[name="role"]', function () {
        toggleSpecialization($(this));
    });

    $(document).ready(function () {
        toggleSpecialization($('select[name="role"]'));
    });
</script>
