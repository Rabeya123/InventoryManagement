@extends('layouts.master')

@section('title', 'Bondstein || Supplier List')

@push('styles')

@endpush

@section('content')

<div class="page-heading row">
    <div class="col-md-6">  <h1 class="page-title">Transfar Product</h1></div>
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
                                                       
                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'description',
                                'lebel' => 'Description',
                                'is_required' => false,
                                'value' => null,
                                'placeholder' =>'Enter Description',
                                'colsize' => 6
                            ])

                            <div class="form-group col-md-6 row">
                                <label class="col-sm-4 col-form-label">Select Product/Item</label>
                                <div class="col-sm-8">
                                    <select disabled class="form-control select_item_list" id="product_id">
                                        <option value="">Search IME or BST</option>
                                    </select>
                                </div>
                            </div>


                        </div>

                        <div class="col-xl-12">
                            <div class="ibox">
                                <div class="ibox-head">
                                    <div class="ibox-title">Selected Item details</div>
                                </div>
                                <div class="ibox-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Item Name</th>
                                                <th>Batch Number</th>
                                                <th>Code/IMEI</th>
                                                <th>Secondary Code/BST</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        @if(old('product_id'))
                                            @foreach ($Requisition->indentifiers as $key => $indentifier)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $indentifier->product->name }}</td>
                                                    <td>{{ $indentifier->batch->code }}</td>
                                                    <td>{{ $indentifier->code }}</td>
                                                    <td>{{ $indentifier->secondary_code }}</td>
                                                    <td>N/A</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <th colspan="5" class="text-center"><h1>Total: {{ $Requisition->indentifiers->count('id') }} Unit</h1></th>
                                        @else   
                                            <tbody id="table_body"></tbody>
                                            <th colspan="5" class="text-center">Total: <span  id="selected_item_count">0</span> Unit</th>
                                        @endif
                                      
                                    </table>
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
            
            $('.select_item_list').select2();

            $(document).on('change', '#from_location_id', function() { 
                var locationId = $(this).val();
                $("#table_body").empty();
                if(locationId){
                    $('#product_id').attr('disabled', false);
                    let products = [];
                    $('.select-product').each(function(index, tr) { 
                        products.push($(this).val());
                    });

                    $('#product_id').select2({
                        ajax: {
                            url: '{{ route('product-identifiers.index') }}',
                            dataType: 'json',
                            data: function (params) {
                                var query = {
                                    search: params.term,
                                    location_id: locationId
                                }
                                return query;
                            }
                        }
                    });
                }else{
                    $('#product_id').attr('disabled', true)
                };
            }); 

            $(document).on('click', '.delete-button', function() {
                $(this).parent().parent().remove();
                $('#selected_item_count').text($('.select-product-identifer').length);
            });

            let rowCount = 0;
            $(document).on('change', '#product_id', function() {
                
                var productIndentiferId = $(this).val(); //alert(productId);
                var productIndentifers = [];
                
                $('.select-product-identifer').each(function(index, tr) { 
                    productIndentifers.push($(this).val());
                });

                if(!productIndentifers.includes(productIndentiferId)) {
                    rowCount++;
                    $.get('{{ route('product-identifiers.index') }}/' + productIndentiferId, function(res) {
                        let productQuantity = parseInt($('#product_id_' +  res.product.id).val());
                        if( productQuantity == parseInt($('#product_id_' +  res.product.id).attr('data-quantity'))){
                            alert('You could not add the item more than your requisition quantity!')
                            return false;
                        }
                        $('#product_id_' +  res.product.id).val(productQuantity + 1 )
                        let tr = "<tr data=\"" + productIndentiferId + "\">" +
                            " <td>" + rowCount + " <input type=\"hidden\" name=\"items[" + rowCount + "][identifier_id]\" class=\"select-product-identifer\" required value=\"" + productIndentiferId + "\"\><input type=\"hidden\" name=\"items[" + rowCount + "][product_id]\" class=\"select-product-identifer-product\" required value=\"" + res.product.id + "\"\></td>" +
                            " <td>" +  res.product.name + "</td>" +
                            " <td>" +  res.batch.code + "</td>" +
                            " <td>" + res.code + "</td>" +
                            " <td>" +  res.secondary_code + "</td>" +
                            " <td><Button type=\"button\" class=\"btn btn-danger delete-button\" > <i class=\"fa fa-trash\"></i></Button></td>" +
                            "</tr>";

                        $("#table_body").append(tr);
                        $('#selected_item_count').text(productIndentifers.length + 1);
                    });
                }else{
                    alert('Product already selected or something went wrong!')
                }
            });
        });

    </script>
@endpush

