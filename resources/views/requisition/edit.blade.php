@extends('layouts.master')

@section('title', 'Bondstein || Requsition Edit')

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
                    <div class="ibox-title">Create</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        <a class="fullscreen-link"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    <form class="form-horizontal" action="{{ route('requisitions.update', $Requisition) }}" method="POST">
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
                                                       
                            <div class="form-group col-md-6 row  @error('user_id') has-error @enderror">
                                <label class="col-sm-4 col-form-label">Requisition for (Employee) </label>
                                <div class="col-sm-8">
                                    <select name="user_id" class="form-control select_item_list" id="user_id">
                                        <option value="">Select employee</option>
                                    @foreach ($Users as $User)
                                        <option value="{{ $User->id }}" {{ $User->id == old('user_id', $Requisition->requisition_for_user_id) ? 'selected' : '' }} >{{ $User->name }}</option>
                                    @endforeach

                                </select>
                                    @error('user_id')
                                    <span class="help-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group col-md-6 row  @error('location_id') has-error @enderror">
                                <label class="col-sm-4 col-form-label">Location</label>
                                <div class="col-sm-8">
                                    <select name="location_id" class="form-control select_item_list" id="location_id">
                                        <option value="">Select location</option>
                                    @foreach ($Locations as $Location)
                                        <option value="{{ $Location->id }}" {{ $Location->id == old('location_id', $Requisition->location_id) ? 'selected' : '' }} >{{ $Location->name }}</option>
                                    @endforeach

                                </select>
                                    @error('location_id')
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
                                'value' => $Requisition->description,
                                'placeholder' =>'Enter Description',
                                'colsize' => 6
                            ])
         
                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'delivery_address',
                                'lebel' => 'Delivery address',
                                'is_required' => false,
                                'value' => $Requisition->delivery_address,
                                'placeholder' =>'Enter delivery address',
                                'colsize' => 6
                            ])
                            @include('layouts.ui.date',[
                                'type' => 'text',
                                'name' => 'delivery_date',
                                'lebel' => 'Delivery date',
                                'is_required' => false,
                                'value' => $Requisition->getRawOriginal('delivery_date'),
                                'placeholder' =>'Enter delivery address',
                                'colsize' => 6
                            ])

                            <div class="form-group col-md-6 row  @error('product_id') has-error @enderror">
                                <label class="col-sm-4 col-form-label">Select product </label>
                                <div class="col-sm-8">
                                    <select class="form-control select_item_list" id="product_id">
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
                                                    <th>Quantity</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_body">
                                               @foreach ($Requisition->products as $key => $Product)
                                                <tr>
                                                    <td>{{ $key + 1 }} 
                                                        <input type="hidden" name="product_id[]" class="select-product" required value="{{ $Product->product_id }}">
                                                    </td>
                                                    <td>{{ $Product->product->name }}</td>
                                                    <td>{{ $Product->product->code }}</td>
                                                    <td> <input class="form-control" type="number" value="{{ $Product->quantity }}" name="quantity[]" min="1" required> </td>
                                                    <td><Button type="button" class="btn btn-danger delete-button" > <i class="fa fa-trash"></i></Button></td>
                                                </tr>
                                               @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4">
                                                        Total
                                                    </td>
                                                    <td></td>
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

            $(document).on('click', '.delete-button', function() {
                $(this).parent().parent().remove();
            });

            let rowCount = 0;
            $(document).on('change', '#product_id', function() {
                
                var product_id = $(this).val();
                var productName = $('option:selected', this).attr('product-name');
                var productCode = $('option:selected', this).attr('product-code');
                var products = []
                $('.select-product').each(function(index, tr) { 
                    products.push($(this).val());
                });

                if(productName != undefined && !products.includes(product_id)) {
                    rowCount++;
                    let tr = 
                        "<tr>" +
                            " <td>" + rowCount + " <input type=\"hidden\" name=\"product_id[]\" class=\"select-product\" required value=\"" + product_id + "\"\></td>" +
                            " <td>" + productName + "</td>" +
                            " <td>" + productCode + "</td>" +
                            " <td> <input class=\"form-control\" type=\"number\" name=\"quantity[]\" value=\"\" min=\"0\" required> </td>" +
                            " <td><Button type=\"button\" class=\"btn btn-danger delete-button\" > <i class=\"fa fa-trash\"></i></Button></td>" +
                        "</tr>";

                    $("#table_body").append(tr);
                }

            });

        });

    </script>
@endpush

