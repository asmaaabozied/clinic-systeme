<div class="modal-body">
    <div class="row">
{{--        <div class="col-md-12">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}

                    <h4 class="modal-title" id="modalTitle">{{$products->name ?? ''}} ( Available)</h4>
{{--                </div>--}}
{{--                <div class="modal-body">--}}
            <div class="col-1g-3 col-md-3">
                <div class="thumbnail">
                    <img src="{{asset('uploads/products/' . $products->pro_image)}}"
                         alt="Product image" width="100px" height="100px">
                </div>
            </div>
                        <div class="col-md-9">
{{--                            <div class="col-sm-4 invoice-col">--}}
                                <b>SKU:</b>
                                {{ $products->sku }}<br>
                                <b> Brands: </b>
                                {{ !empty($products->brand)?$products->brand->name:'' }} --<br>
                                <b>Units: </b>
                                {{ !empty($products->unit)?$products->unit->name:'' }}<br>
                                <b>BarCode: </b>
                                {{$products->code ?? ''}}


                                <br>
                                <strong>Reason:</strong>


                                {{$products->description ?? ''}}


{{--                            <div class="col-sm-4 invoice-col">--}}
                                <b>Category: </b>
                                {{ !empty($products->category)?$products->category->name:'' }}<br>

                                <b>

                                </b>
                                --<br>

                                <b>Mange stock؟: </b>
                               No <br>



{{--                            <div class="col-sm-4 invoice-col">--}}
                                <b>Expire Date: </b>
                                {{$products->expire_date}}
                                <br>
                                <b>Weight: </b>
                                {{$products->weight}}<br>

                                <b>Quantity: </b>
                                {{$products->quantity}}<br>
                                <b>Purchase Price	: </b>
                                {{$products->purchase_price	}}<br>
                                <b> Vat: </b>
                                {{$products->vat}} <br>
                                <b>Type Sales Tax:</b>
                                {{$products->type_sales}}<br>
                                <b> Type Product: </b>
                                {{$products->type_product}}
                                <br><b> Price Product: </b>
                                {{$products->sale_price}}


                        </div>

                    </div>
                    <br>
                </div>

            </div>
        </div>
    </div>
</div>
