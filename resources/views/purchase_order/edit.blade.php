@extends('layouts.master')

@section('title', 'Bondstein || Purchase Order Create')

@push('styles')

@endpush

@section('content')

<div class="page-heading row">
    <div class="col-md-6">  <h1 class="page-title">Purchase Order</h1></div>
    <div class="col-md-6"><a class="btn btn-default float-right mt-4" href="{{ route('purchase-orders.index') }}" > <i class="fa fa-arrow-left"></i> Back</a></div>
</div>

<div class="page-content pt-2 fade-in-up">
    <div class="row">
        <div class="col-md-12">

            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Edit</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        <a class="fullscreen-link"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    <form class="form-horizontal" action="{{ route('purchase-orders.update', $PurchaseOrder) }}" method="POST">
                            @csrf
                            @method('PUT')

                        <div class="row">
                            
                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'title',
                                'lebel' => 'Title',
                                'is_required' => true,
                                'value' => $PurchaseOrder->title,
                                'placeholder' =>'Enter Title',
                                'colsize' => 6
                            ])

                            <div class="form-group col-md-6 row  @error('date') has-error @enderror ">
                                <label class="col-sm-4 col-form-label">Date </label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="date" value="{{ old('date', $PurchaseOrder->date) }}" placeholder="Enter date" readonly>
                                    @error('date')
                                    <span class="help-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>

                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'code',
                                'lebel' => 'Code',
                                'is_required' => true,
                                'value' => $PurchaseOrder->code,
                                'placeholder' =>'Enter Code',
                                'colsize' => 6
                            ])

                            <div class="form-group col-md-6 row  @error('contact_id') has-error @enderror ">
                                <label class="col-sm-4 col-form-label">Supplier</label>
                                <div class="col-sm-8">
                                <select name="contact_id" class="form-control select_item_list" id="contact_id">
                                            <option value="">Select One</option>
                                    @foreach ($Contacts as $Contact)
                                            <option value="{{ $Contact->id }}" {{ $Contact->id == old('contact_id',  $PurchaseOrder->contact_id) ? 'selected' : '' }} >{{ $Contact->name }}</option>
                                    @endforeach
                                </select>
                                    @error('contact_id')
                                    <span class="help-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'reference_no',
                                'lebel' => 'Reference',
                                'is_required' => false,
                                'value' => $PurchaseOrder->reference_no,
                                'placeholder' =>'Enter Reference',
                                'colsize' => 6
                            ])

                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'description',
                                'lebel' => 'Description',
                                'is_required' => false,
                                'value' => $PurchaseOrder->description,
                                'placeholder' =>'Enter Description',
                                'colsize' => 6
                            ])

                            
                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'shipping_address',
                                'lebel' => 'Shipping Address',
                                'is_required' => false,
                                'value' => $PurchaseOrder->shipping_address->details,
                                'placeholder' =>'Enter Shipping Address',
                                'colsize' => 6
                            ])

                            <div class="form-group col-md-6 row  @error('status') has-error @enderror">
                                <label class="col-sm-4 col-form-label">Status </label>
                                <div class="col-sm-8">
                                    <select name="status" class="form-control" id="status">
                                        <option @if($PurchaseOrder->status == 'pending') selected @endif value="pending">Pending</option>
                                        <option @if($PurchaseOrder->status == 'approved') selected @endif value="approved">Approved</option>
                                        <option @if($PurchaseOrder->status == 'cancel') selected @endif value="cancel">Cancel </option>
                                </select>
                                    @error('status')
                                    <span class="help-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6 row  @error('product_id') has-error @enderror">
                                <label class="col-sm-4 col-form-label">Select product </label>
                                <div class="col-sm-8">
                                    <select name="product_id" class="form-control select_item_list" id="product_id">
                                        <option value="">Select product</option>
                                    @foreach ($Products as $Product)
                                        <option value="{{ $Product->id }}" product-price="{{ $Product->purchase_price }}" product-percentile="{{ $Product->tax_percentile }}" product-name="{{ $Product->name }}" product-code="{{ $Product->code }}"  {{ $Product->id == old('product_id') ? 'selected' : '' }} >{{ $Product->name }}</option>
                                    @endforeach

                                </select>
                                    @error('product_id')
                                    <span class="help-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="ibox">
                                    <div class="ibox-head">
                                        <div class="ibox-title">Item details</div>
                                    </div>
                                    <div class="ibox-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Item Name</th>
                                                    <th>Code</th>
                                                    <th>Price</th>
                                                    <th>Tax(%)</th>
                                                    <th>Quantity</th>
                                                    <th>Amount</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_body">
                                               @foreach ($PurchaseOrder->orders as $key => $Order)
                                                    <tr data="{{ $Order->product_id }}">
                                                        <td>{{ $key + 1 }} 
                                                            <input type="hidden" name="product_id[]" class="select-product" value="{{ $Order->product_id }}">
                                                            <input type="hidden" name="product_tax_amount[]" class="tax-amount" value="{{ $Order->amount_tax }}">
                                                            <input type="hidden" name="purchase_order_product_id[]" class="purchase-order-product" value="{{ $Order->id }}">
                                                        </td>
                                                        <td>{{ $Order->product->name }}</td>
                                                        <td>{{ $Order->product->code }}</td>
                                                        <td><input class="form-control purchase-price" required type="number" name="purchase_price[]" value="{{ $Order->purchase_price }}" min="1" ></td>
                                                        <td><input class="form-control tax-percentile" step="any" required type="number" name="tax_percentile[]" value="{{ $Order->tax_percentile }}" min="0" max="100"></td>
                                                        <td> <input class="form-control quantity" required type="number" name="quantity[]" value="{{ $Order->quantity }}" min="1"> </td>
                                                        <td> <input class="form-control amount" required type="number" name="amount[]" value="{{ round($Order->amount, 2) }}" min="1" readonly> </td>
                                                        <td><Button type="button" class="btn btn-danger delete-button" > <i class="fa fa-trash"></i></Button></td>
                                                    </tr>
                                               @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="6" class="text-right">
                                                       Grand Total =
                                                    </th>
                                                    <th colspan="2">
                                                        <input class="form-control" type="number" name="grand_total" id="grand_total" value="{{ old('grand_total', 0) }}" min="0" readonly>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="6" class="text-right">
                                                       Total Tax/VAT (+) =
                                                    </th>
                                                    <th colspan="2">
                                                        <input class="form-control" type="number" name="tax_total" id="tax_total" value="{{ old('tax_total', 0) }}" min="0" readonly>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="6" class="text-right">
                                                        Service Charge (+) =
                                                    </th>
                                                    <th colspan="2"><input class="form-control" type="number" name="service_charge" id="service_charge" value="{{ old('service_charge', number_format($PurchaseOrder->service_charge, 2)) }}" min="0"></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="6" class="text-right">
                                                        Others Charge (+) =
                                                    </th>
                                                    <th colspan="2"> <input class="form-control" type="number" name="others_charge"  id="others_charge"  value="{{ old('others_charge', number_format($PurchaseOrder->others_charge, 2)) }}" min="0" ></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="6" class="text-right">Net Total = </th>
                                                    <th colspan="2">
                                                        <input class="form-control" type="number" name="net_total" id="net_total" value="{{ old('net_total', 0) }}" min="0" readonly>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="ibox">
                                    <div class="ibox-head">
                                        <div class="ibox-title">Conditions</div>
                                        <div class="tools">
                                            <button class="btn btn-primary btn-sm" type="button" id="purchase_order_condition_id"> <i class="fa fa-plus"></i> Add</button>
                                        </div>
                                    </div>
                                    <div class="ibox-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Description</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_body_condition">
                                                @foreach ($PurchaseOrder->conditions as $key => $Condition)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td><input class="form-control" required type="text" name="purchase_order_condition[]" value="{{ $Condition->name }}" ></td>
                                                        <td><Button type="button" class="btn btn-danger delete-button" > <i class="fa fa-trash"></i></Button></td>
                                                    </tr>
                                                @endforeach
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group row justify-content-md-center">
                            <div class="col-sm-2">
                                <button class="btn btn-info btn-block pointer" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@push('scripts')

    @if ($PurchaseOrder->status != 'pending' )
        <script> $(".page-content :input").prop("disabled", true); </script>
    @endif

    <script>
        
        $(document).ready(function() {

            //load total value
            getProductTotal();

            //product price change
            $(document).on('input', '.purchase-price', function() {
                let productQuantity = $(this).parent().parent().find('.quantity').val();
                let productPercentile = $(this).parent().parent().find('.tax-percentile').val();
                let productPrice = $(this).val();
                let taxAmount = (productPercentile > 0) ? ((productPrice / 100) * productPercentile) : 0;
                let amount = productPrice * productQuantity;
                $(this).parent().parent().find('.amount').val(amount.toFixed(2));
                $(this).parent().parent().find('.tax-amount').val(taxAmount * productQuantity);
                getProductTotal();
            });

            //product quantity change
            $(document).on('input', '.quantity', function() {
                let productQuantity = parseFloat($(this).val());
                let productPercentile = parseFloat($(this).parent().parent().find('.tax-percentile').val());
                let productPrice = parseFloat($(this).parent().parent().find('.purchase-price').val());
                let amount = productPrice * productQuantity;
                let taxAmount = (productPercentile > 0) ? ((productPrice / 100) * productPercentile) : 0;
                $(this).parent().parent().find('.amount').val(amount.toFixed(2));
                $(this).parent().parent().find('.tax-amount').val(taxAmount * productQuantity);
                getProductTotal();
            });

            //product tax percentile change
            $(document).on('input', '.tax-percentile', function() {
                let productQuantity = $(this).parent().parent().find('.quantity').val(); 
                let productPercentile = $(this).val();
                let productPrice = $(this).parent().parent().find('.purchase-price').val();
                let taxAmount = (productPercentile > 0) ? ((productPrice / 100) * productPercentile) : 0;
                let amount = productPrice * productQuantity;
                $(this).parent().parent().find('.amount').val(amount.toFixed(2));
                $(this).parent().parent().find('.tax-amount').val(taxAmount * productQuantity);
                getProductTotal();
            });

            $(document).on('input', '#service_charge, #others_charge', function() { 
                getProductTotal();
            });
            
            function getProductTotal() {
                
                let total = 0;
                let taxTotal = 0;
                
                $('.amount').each(function(index, tr) { 
                    total += parseFloat($(this).val());
                });

                $('.tax-amount').each(function(index, tr) { 
                    taxTotal += parseFloat($(this).val());
                });

                $('#tax_total').val(taxTotal.toFixed(2));
                $('#grand_total').val(total.toFixed(2));

                let serviceCharge = parseFloat($('#service_charge').val());
                let othersCharge = parseFloat($('#others_charge').val());
                let netTotal = taxTotal + total + serviceCharge + othersCharge;
                
                $('#net_total').val(netTotal.toFixed(2));
            }

            $(document).on('click', '.delete-button', function() {
                $(this).parent().parent().remove();
                getProductTotal();
            });

            let rowCount = '{{ COUNT($PurchaseOrder->orders) }}';
            $(document).on('change', '#product_id', function() {
                
                var product_id = $(this).val();
                var productName = $('option:selected', this).attr('product-name');
                var productPrice = parseFloat($('option:selected', this).attr('product-price'));
                var productCode = $('option:selected', this).attr('product-code');
                var productPercentile = parseFloat($('option:selected', this).attr('product-percentile'));
                var taxAmount = (productPercentile > 0) ? ((productPrice / 100) * productPercentile) : 0;
                var products = []
                
                $('.select-product').each(function(index, tr) { 
                    products.push($(this).val());
                });

                if(productName != undefined && !products.includes(product_id)) {
                    rowCount++;

                    let tr = "<tr data=\"" + product_id + "\">" +
                        " <td>" + rowCount + " <input type=\"hidden\" name=\"product_id[]\" class=\"select-product\" value=\"" + product_id + "\"\><input type=\"hidden\" name=\"product_tax_amount[]\" class=\"tax-amount\" value=\"" + taxAmount + "\"\></td>" +
                        " <td>" + productName + "</td>" +
                        " <td>" + productCode + "</td>" +
                        " <td><input class=\"form-control purchase-price\" required type=\"number\" name=\"purchase_price[]\" value=\"" + productPrice + "\" min=\"1\" ></td>" +
                        " <td><input class=\"form-control tax-percentile\" required type=\"number\" step=\"any\" name=\"tax_percentile[]\" value=\"" + productPercentile + "\" min=\"0\" max=\"100\"></td>" +
                        " <td> <input class=\"form-control quantity\" required type=\"number\" name=\"quantity[]\" value=\"1\" min=\"1\"> </td>" +
                        " <td> <input class=\"form-control amount\" required type=\"number\" name=\"amount[]\" value=\"" + productPrice.toFixed(2) + "\" min=\"1\" readonly> </td>" +
                        " <td><Button type=\"button\" class=\"btn btn-danger delete-button\" > <i class=\"fa fa-trash\"></i></Button></td>" +
                        "</tr>";

                    $("#table_body").append(tr);
                }

                getProductTotal();
            });

            let rowCountCondition = '{{ COUNT($PurchaseOrder->conditions) }}';
            $(document).on('click', '#purchase_order_condition_id', function() {
                rowCountCondition++
                let tr = "<tr>" +
                        " <td>" + rowCountCondition + "</td>" +
                        " <td><input class=\"form-control\" required type=\"text\" name=\"purchase_order_condition[]\" value=\"\" ></td>" +
                        " <td><Button type=\"button\" class=\"btn btn-danger delete-button\" > <i class=\"fa fa-trash\"></i></Button></td>" +
                        "</tr>";

                $("#table_body_condition").append(tr);
            });

        });

    </script>
@endpush

