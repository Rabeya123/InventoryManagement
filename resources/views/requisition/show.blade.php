@extends('layouts.master')

@section('title', 'Inventory Management System' || Requsition Details')

@push('styles')

@endpush

@section('content')

<div class="page-heading row">
    <div class="col-md-6">  <h1 class="page-title">Requisition</h1></div>
    <div class="col-md-6"><a class="btn btn-default float-right mt-4" href="{{ route('requisitions.index') }}" > <i class="fa fa-arrow-left"></i> Back</a></div>
</div>

<div class="page-content pt-2 fade-in-up">
    <div class="row">
        <div class="col-md-12">

            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Details</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        <a class="fullscreen-link"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    <form class="form-horizontal" action="{{ route('requisitions.update', $Requisition) }}" method="POST">
                        <input type="hidden" name="is_approved" value="1">
                            @csrf
                            @method('PUT')
                        <div class="row">
                            
                            <div class="form-group col-md-6 row  @error('date') has-error @enderror ">
                                <label class="col-sm-4 col-form-label">Date </label>
                                <div class="col-sm-8">
                                    <input class="form-control" required type="text" name="date" value="{{ old('date', $Requisition->date ) }}" placeholder="Enter date" readonly>
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
                                'is_read_only' => true,
                                'value' => $Requisition->code,
                                'placeholder' =>'',
                                'colsize' => 6
                            ])

                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'description',
                                'lebel' => 'Requisition for (Employee)',
                                'is_required' => true,
                                'is_read_only' => true,
                                'value' => $Requisition->requisition_for->name,
                                'placeholder' =>'',
                                'colsize' => 6
                            ])                       
                                                       
                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'description',
                                'lebel' => 'Requisition by (Supervisor)',
                                'is_required' => true,
                                'is_read_only' => true,
                                'value' => $Requisition->requisition_by->name,
                                'placeholder' =>'',
                                'colsize' => 6
                            ])

                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'description',
                                'lebel' => 'Description',
                                'is_required' => true,
                                'is_read_only' => true,
                                'value' => $Requisition->description,
                                'placeholder' =>'',
                                'colsize' => 6
                            ])

                            <div class="form-group col-md-6 row  @error('location_id') has-error @enderror ">
                                <label class="col-sm-4 col-form-label">Location</label>
                                <div class="col-sm-8">
                                <select name="location_id" class="form-control select_item_list" @if($Requisition->status == 'approved') disabled @endif id="location_id">
                                        <option value="">Select One</option>
                                    @foreach ($Locations as $Location)
                                        <option value="{{ $Location->id }}" {{ $Location->id == old('location_id',  $Requisition->location_id) ? 'selected' : '' }} >{{ $Location->name }}</option>
                                    @endforeach

                                </select>
                                    @error('location_id')
                                    <span class="help-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="ibox">
                                    <div class="ibox-head">
                                        <div class="ibox-title">Requsition details</div>
                                    </div>
                                    <div class="ibox-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Item Name</th>
                                                    <th>Code</th>
                                                    <th>Request Quantity</th>
                                                    <th>Approved Quantity</th>
                                                    {{-- <th>Actions</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @foreach ($Requisition->products as $key => $Product)
                                                <tr>
                                                    <td>{{ $key + 1 }} 
                                                        <input type="hidden" name="product_id[]" class="select-product" required value="{{ $Product->product_id }}">
                                                        {{-- <input type="hidden" name="req_product_id[]" class="select-product" required value="{{ $Product->id }}"> --}}
                                                        <input type="hidden" name="req_product_id[]" class="select-product" required value="{{ $Product->id }}">
                                                    </td>
                                                    <td>{{ $Product->product->name }}</td>
                                                    <td>{{ $Product->product->code }}</td>
                                                    <td>
                                                        <input readonly class="form-control" type="number" value="{{ $Product->quantity }}" name="quantity[]" min="0" required> 
                                                    </td>
                                                    <td><input @if($Requisition->status == 'approved' || $Product->product->has_identifier) readonly @endif  class="form-control" type="number" value="@if($Requisition->status == 'approved'){{ $Product->approved_quantity }}@else{{ $Product->product->has_identifier ? 0 : $Product->quantity }}@endif" data-quantity="{{ $Product->quantity }}" id="product_id_{{$Product->product->id}}" name="approved_quantity[]" min="1" required> </td>
                                                    {{-- <td><Button type="button" class="btn btn-danger delete-button" > <i class="fa fa-trash"></i></Button></td> --}}
                                                </tr>
                                               @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4">
                                                       
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @if($Requisition->status == 'pending') 
                                <div class="col-md-12 row">
                                    <div class="col-sm-8" style="margin: 0 auto;">
                                        <select disabled class="form-control select_item_list" id="product_id">
                                            <option value="">Select identifer item</option>
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="col-xl-12">
                                <div class="ibox">
                                    <div class="ibox-head">
                                        <div class="ibox-title">Assign Item details</div>
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
                                           @if($Requisition->status == 'approved')
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
                                                    <th colspan="5" class="text-center">Total quantity: {{ $Requisition->indentifiers->count('id') }} Unit</th>
                                                </tr>
                                            @else   
                                                <tbody id="table_body"></tbody>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group row justify-content-md-center">
                            @if($Requisition->status != 'approved') 
                                <div class="col-sm-4"></div>
                                <div class="col-sm-2">
                                    <button class="btn btn-info btn-block pointer" type="submit">Submit</button>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-info btn-block pointer" name="is_print" value="1" type="submit">Submit & Print</button>
                                </div>
                                <div class="col-sm-4"></div>
                            @endif
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

            $(document).on('change', '#location_id', function() { 
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
                                    location_id: locationId,
                                    product_ids: products
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
            });

            let rowCount = 0;
            $(document).on('change', '#product_id', function() {
                
                var productIndentiferId = $(this).val(); //alert(productId);
                var productIndentifers = []
                
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
                            " <td>" + rowCount + " <input type=\"hidden\" name=\"identifier_id[]\" class=\"select-product-identifer\" required value=\"" + productIndentiferId + "\"\><input type=\"hidden\" name=\"identifier_product_id[]\" class=\"select-product-identifer-product\" required value=\"" + res.product.id + "\"\></td>" +
                            " <td>" +  res.product.name + "</td>" +
                            " <td>" +  res.batch.code + "</td>" +
                            " <td>" + res.code + "</td>" +
                            " <td>" +  res.secondary_code + "</td>" +
                            " <td><Button type=\"button\" class=\"btn btn-danger delete-button\" > <i class=\"fa fa-trash\"></i></Button></td>" +
                            "</tr>";

                        $("#table_body").append(tr);
                    })
                }else{
                    alert('Product already selected or something went wrong!')
                }
            });
        });

    </script>
@endpush

