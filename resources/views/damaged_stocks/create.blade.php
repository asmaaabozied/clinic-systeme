{{ Form::open(array('url' => 'damaged_stocks', 'class'=>'needs-validation', 'novalidate')) }}
<div class="modal-body">
    {{-- start for ai module--}}
    @php
        $plan= \App\Models\Utility::getChatGPTSettings();
    @endphp
    <div class="row">
        <div class="col-md-6 form-group">
            {{ Form::label('branch_id', __('Branch'),['class'=>'form-label']) }}
            {{ Form::select('branch_id', $branch,null, array('class' => 'form-control select2')) }}
            <div class=" text-xs mt-1">
                {{__('Create Branch here. ')}}<a href="{{route('branch.index')}}"><b>{{__('Create Branch')}}</b></a>
            </div>
        </div>
        <div class="col-md-6 form-group">
            {{ Form::label('type', __('Type'),['class'=>'form-label']) }}
            {{ Form::select('type', ['normal'=>'Normal','nonormal'=>'No Normal'],null, array('class' => 'form-control select2')) }}

        </div>
        <div class="form-group col-md-6">
            {{ Form::label('date', __('Date'),['class'=>'form-label']) }}
            <x-required></x-required>
            {{ Form::date('date', '', array('class' => 'form-control','required'=>'required', 'placeholder' => __('Enter Date'))) }}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('number',__('Reference number'),array('class'=>'form-label')) }}
            <x-required></x-required>
            {{Form::text('number',null,array('class'=>'form-control','rows'=>3 ,'required'=>'required', 'placeholder' => __('Enter Reference number')))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('total',__('Total'),array('class'=>'form-label')) }}
            <x-required></x-required>
            {{Form::text('total',null,array('class'=>'form-control','rows'=>3 ,'required'=>'required', 'placeholder' => __('Enter total')))}}
        </div>
        <div class="col-md-6 form-group">
            {{ Form::label('product_id', __('Product'),['class'=>'form-label','id'=>'selectedproduct']) }}
            {{ Form::select('product_id', $products,null, array('class' => 'form-control select2')) }}
            <div class=" text-xs mt-1">
                {{__('Create Product here. ')}}<a
                    href="{{route('productservice.index')}}"><b>{{__('Create Product')}}</b></a>
            </div>
        </div>

        <div class="form-group col-md-6">
            {{Form::label('description',__('Reason'),array('class'=>'form-label')) }}
            <x-required></x-required>
            {{Form::textarea('description',null,array('class'=>'form-control','rows'=>3 ,'required'=>'required', 'placeholder' => __('Enter Description')))}}
        </div>
        <div class="form-group col-md-6">
            <table class="table datatable">
                <thead>
                <tr>
                    <th>{{__('Product Name')}}</th>
                    <th>{{__('Quantity')}}</th>
                    <th>{{__('Price')}}</th>
                    <th>{{__('Total')}}</th>
                </tr>

                </thead>
                <tbody>
                <td><input type="text"  style="display: none ; width:100%" id="product_name"></td>
                <td><input type="text"  style="display: none; width:100%" id="quantity"></td>
                <td><input type="text"  style="display: none ; width:100%" id="price"></td>
                <td><input type="text"  style="display: none ; width:100%" id="totalss"></td>
                </tbody>
            </table>
        </div>


    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-secondary" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}

<!-- jquery to toggle visibility -->
<script>
    $(document).ready(function () {
        $('select[name="product_id"]').on('change', function () {
            let productid = $(this).val();
            let url = "{{ url('/get-product') }}/" + productid;
            $.ajax({
                url: url,
                method: 'GET',
                success: function (response) {

                    console.log(response)
                    $('#product_name').css('display', 'block').val(response.name);

                    $('#price').css('display', 'block').val(response.sale_price);

                    $('#quantity').css('display', 'block').val(response.quantity);
                    var total = parseFloat(response.sale_price)  * parseFloat(response.quantity);
                    console.log("totalt",total);
                    $('#totalss').css('display', 'block');
                    $('#totalss').val(total);

                }
            });
        });
    });
</script>
