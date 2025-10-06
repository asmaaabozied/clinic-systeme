{{ Form::open(array('url' => 'purchase-return', 'class'=>'needs-validation', 'novalidate','enctype' => "multipart/form-data")) }}

@csrf
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
            {{ Form::label('vendor_id', __('Vendor'),['class'=>'form-label']) }}
            {{ Form::select('vendor_id', $vendor,null, array('class' => 'form-control select2')) }}

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

        <div class="col-md-12 form-group">
            {{Form::label('image',__(' Image'),['class'=>'form-label'])}}
            <div class="choose-file ">
                <label for="pro_image" class="form-label">
                    <input type="file" class="form-control file-validate" name="document" id="pro_image"
                           data-filename="pro_image_create">
                    <p id="" class="file-error text-danger"></p>
                    <img id="image" class="mt-3" style="width:25%;"/>
                </label>
            </div>
        </div>
        <div class="col-md-6 form-group">
            {{ Form::label('product_id', __('Product'),['class'=>'form-label','id'=>'selectedproduct']) }}
            {{ Form::select('product_id', $products,null, array('class' => 'form-control select2')) }}
            <div class=" text-xs mt-1">
                {{__('Create Product here. ')}}<a
                    href="{{route('productservice.index')}}"><b>{{__('Create Product')}}</b></a>
            </div>
        </div>
        <div class="col-md-6 form-group">
        </div>

        <div class="form-group col-md-12">
            <table class="table datatable">
                <thead>
                <tr>
                    <th>{{__('Product Name')}}</th>
                    <th>{{__('Quantity')}}</th>
                    <th>{{__('Price')}}</th>
                    <th>{{__('Quantity Return')}}</th>
                    <th>{{__('Total')}}</th>
                </tr>

                </thead>
                <tbody>
                <td><input type="text" style="width:100%" id="product_name" readonly></td>
                <td><input type="text" style=" width:50%" id="quantity" readonly></td>
                <td><input type="text" style="width:50%" id="price" readonly></td>
                <td><input type="text" name="quantity" style="width:50%" id="quantityreturn"></td>
                <td><input type="text" name="total" style="width:50%" id="totalss" readonly></td>
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
        $('#quantityreturn').on('keyup', function () {
            let num = parseFloat($(this).val());
            let price = $('#price').val();
            let quantity = $('#quantity').val();

            console.log("ssss", num);

            // if (!isNaN(num)) {
            let square = num * price * quantity;
            $('#totalss').val(square);
            // } else {
            //     $('#totalss').text('0');
            // }
        });
    });

    document.getElementById('pro_image').onchange = function () {
        var src = URL.createObjectURL(this.files[0])
        document.getElementById('image').src = src
    }
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

                    $('#price').css('display', 'block').val(response.purchase_price);

                    $('#quantity').css('display', 'block').val(response.quantity);
                    var total = parseFloat(response.purchase_price) * parseFloat(response.quantity);
                    // console.log("totalt", total);
                    // $('#totalss').css('display', 'block');
                    $('#totalss').val(total);

                }
            });
        });
    });
</script>
