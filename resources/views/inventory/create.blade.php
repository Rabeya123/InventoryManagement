@extends('layouts.master')

@section('title', 'Bondstein || Supplier List')

@push('styles')

@endpush

@section('content')

<div class="page-heading row">
    <div class="col-md-6">  <h1 class="page-title">Add Product</h1></div>
    <div class="col-md-6"><a class="btn btn-default float-right mt-4" href="{{ route('inventories.index') }}" > <i class="fa fa-arrow-left"></i> Back</a></div>
</div>

<div class="page-content pt-2 fade-in-up">
    <div class="row">
        <div class="col-md-12">

            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Create</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        <a class="fullscreen-link"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    <form class="form-horizontal" action="{{ route('inventories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                        <div class="row">
                            
                            <div class="form-group col-md-6 row  @error('date') has-error @enderror ">
                                <label class="col-sm-4 col-form-label">Date </label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="date" value="{{ old('date', date('d-m-Y')) }}" placeholder="Enter date" readonly>
                                    @error('date')
                                    <span class="help-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>

                            @switch(request('type_id'))
                                @case(1)
                                    @php $type_id = 1 @endphp
                                    @break
                                @case(2)
                                    @php $type_id = 2 @endphp
                                    @break
                                @case(3)
                                    @php $type_id = 3 @endphp
                                    @break
                                @default
                                    @php $type_id = 1 @endphp
                            @endswitch
                            <input type="hidden" name="type_id" value="{{ $type_id }}">

                            <div class="form-group col-md-6 row  @error('type') has-error @enderror ">
                                <label class="col-sm-4 col-form-label">Addtion/Deduction</label>
                                <div class="col-sm-8">
                                <select name="type" class="form-control customer_list" id="type_id" disabled>
                                        <option value="">Select One</option>
                                        <option value="1" {{ 1 == $type_id ? 'selected' : '' }} >Addtion</option>
                                        <option value="2" {{ 2 == $type_id ? 'selected' : '' }}>Deduction</option>
                                        <option value="3" {{ 3 == $type_id ? 'selected' : '' }}>Transfar</option>
                                        <option value="4" {{ 4 == $type_id ? 'selected' : '' }}>Retunr</option>
                                        <option value="5" {{ 5 == $type_id ? 'selected' : '' }}>Damage</option>
                                </select>
                                    @error('type')
                                    <span class="help-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6 row  @error('from_location_id') has-error @enderror ">
                                <label class="col-sm-4 col-form-label">Warehouse</label>
                                <div class="col-sm-8">
                                <select name="from_location_id" class="form-control select_item_list" id="from_location_id">
                                        <option value="">Select One</option>
                                    @foreach ($Locations as $Location)
                                        <option value="{{ $Location->id }}" {{ $Location->id == old('from_location_id') ? 'selected' : '' }} >{{ $Location->name }}</option>
                                    @endforeach

                                </select>
                                    @error('from_location_id')
                                    <span class="help-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            @if (request('type_id') == 1)
                                <div class="form-group col-md-6 row  @error('purchase_order_id') has-error @enderror ">
                                    <label class="col-sm-4 col-form-label">Purchase order</label>
                                    <div class="col-sm-8">
                                    <select name="purchase_order_id" class="form-control select_item_list" id="purchase_order_id">
                                            <option value="">Select One</option>
                                        @foreach ($PurchaseOrders as $PurchaseOrder)
                                            <option value="{{ $PurchaseOrder->id }}" {{ $PurchaseOrder->id == old('purchase_order_id') ? 'selected' : '' }} >{{ $PurchaseOrder->title . " ( Code: " . $PurchaseOrder->code  . ", Date: " . $PurchaseOrder->date . ")"}}</option>
                                        @endforeach

                                    </select>
                                        @error('purchase_order_id')
                                        <span class="help-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            @else                       
                                <div class="form-group col-md-6 row  @error('to_location_id') has-error @enderror">
                                    <label class="col-sm-4 col-form-label">To Location <span class="text-danger">[Applicable for transfar]</span> </label>
                                    <div class="col-sm-8">
                                    <select name="to_location_id" class="form-control select_item_list" id="to_location_id" {{ 3 != request('type_id') ? 'disabled' : '' }} >
                                            <option value="">Select One</option>
                                        @foreach ($Locations as $Location)
                                            <option value="{{ $Location->id }}" {{ $Location->id == old('to_location_id') ? 'selected' : '' }} >{{ $Location->name }}</option>
                                        @endforeach

                                    </select>
                                        @error('to_location_id')
                                        <span class="help-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                                                       
                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'description',
                                'lebel' => 'Description',
                                'is_required' => false,
                                'value' => null,
                                'placeholder' =>'Enter Description',
                                'colsize' => 6
                            ])

                            <div class="form-group col-md-6 row  @error('product_id') has-error @enderror">
                                <label class="col-sm-4 col-form-label">Select product </label>
                                <div class="col-sm-8">
                                    <select name="product_id" class="form-control select_item_list" id="product_id">
                                        <option value="">Select product</option>
                                    @foreach ($Products as $Product)
                                        <option value="{{ $Product->id }}" product-identifier="{{ $Product->has_identifier }}" product-name="{{ $Product->name }}" product-code="{{ $Product->code }}"  {{ $Product->id == old('product_id') ? 'selected' : '' }} >{{ $Product->name }}</option>
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
                                        <div class="ibox-title">Product details</div>
                                    </div>
                                    <div class="ibox-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product Name</th>
                                                    <th>Code</th>
                                                    <th>Identifier File (CSV)  <a href="{{ asset('files/TerminalListUploadSampleIMS.xlsx') }}" class="text-danger" download=""> <i class="fa fa-download"></i> Download</a></th>
                                                    <th>Quantity</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_body">
                                               
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4">
                                                        Note: For excel upload total quantity count from excel file.
                                                    </td>
                                                    <td>Total</td>
                                                </tr>
                                            </tfoot>
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
    <script>

        $(document).ready(function() {
           
            $(document).on('change', '#type_id', function() {
                if($(this).val() == 3) {
                    $("#to_location_id").attr('disabled', false);
                } else {
                    $("#to_location_id").attr('disabled', true);
                };
            });
            
            $(document).on('input', '.quantity', function() {
                let purchaserOrderQuantity = parseInt($(this).attr('max'));
                let inputQuantity = parseInt($(this).val());
                if(inputQuantity > purchaserOrderQuantity) {
                    alert('You can not input more then your purchase order quantity;');
                    $(this).val(purchaserOrderQuantity);
                    return false;
                }
            });

            $(document).on('change', '#purchase_order_id', function() {
                $("#product_id").empty();
                $("#table_body").empty();
                $.get("{{ route('purchase-orders.index')}}/" + $(this).val() , function(res) { 
                    let options = "<option value=''>Select One</option>" ;
                    res.orders.forEach(item => { 
                        let Product = item.product; 
                        options += "<option value='" + Product.id + "' product-identifier='" + Product.has_identifier + "' product-name='" + Product.name + "' product-code='" + Product.code + "' product-quantity='" + item.quantity + "' >" + Product.name  +  "</option>";                        
                    });
                    $("#product_id").append(options);
                });
            });

            $(document).on('click', '.delete-button', function() {
                $(this).parent().parent().remove();
            });

            let rowCount = 0;
            $(document).on('change', '#product_id', function() {
                
                var product_id = $(this).val();
                var productName = $('option:selected', this).attr('product-name');
                var productCode = $('option:selected', this).attr('product-code');
                var hasIdentifier = $('option:selected', this).attr('product-identifier');
                var quantity = $('option:selected', this).attr('product-quantity'); 
                var products = []
                var maxInQuantity = 100000;

                if(quantity != undefined) {
                    maxInQuantity = quantity;
                }
                
                $('.select-product').each(function(index, tr) { 
                    products.push($(this).val());
                });

                if(productName != undefined && !products.includes(product_id)) {
                    rowCount++;
                    let identifierInput = "";
                    let quantityInputStatus = '';

                    if(hasIdentifier == 1) {
                        identifierInput = "<input type=\"file\" required name=\"identifier[]\" accept=\".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel\">";
                        quantityInputStatus = 'disabled';
                    } else {
                        identifierInput = "<input type=\"file\" class=\"d-none\" name=\"identifier[]\">";
                    }

                    let tr = "<tr data=\"" + product_id + "\">" +
                        " <td>" + rowCount + " <input type=\"hidden\" name=\"product_id[]\" class=\"select-product\" value=\"" + product_id + "\"\></td>" +
                        " <td>" + productName + "</td>" +
                        " <td>" + productCode + "</td>" +
                        " <td>" + identifierInput + "</td>" +
                        " <td> <input class=\"form-control quantity\" required type=\"number\" " + quantityInputStatus + " name=\"quantity[]\" value=\"\" min=\"1\"  max=\""+ maxInQuantity +"\"> </td>" +
                        " <td><Button type=\"button\" class=\"btn btn-danger delete-button\" > <i class=\"fa fa-trash\"></i></Button></td>" +
                        "</tr>";

                    $("#table_body").append(tr);
                }
            });

        });

    </script>
@endpush

