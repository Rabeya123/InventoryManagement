@extends('layouts.master')

@section('title', 'Bondstein || Product Create')

@push('styles')

@endpush

@section('content')

<div class="page-heading row">
    <div class="col-md-6">  <h1 class="page-title">Product</h1></div>
    <div class="col-md-6"><a class="btn btn-default float-right mt-4" href="{{ route('products.index') }}" > <i class="fa fa-arrow-left"></i> Back</a></div>
</div>

<div class="page-content pt-2 fade-in-up">
    <div class="row">
        <div class="col-md-12">

            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Update</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        <a class="fullscreen-link"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    <form class="form-horizontal" action="{{ route('products.update', $Product) }}" method="POST">
                            @csrf
                            @method('PUT')
                        <div class="row">
                            
                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'name',
                                'lebel' => 'Name',
                                'is_required' => true,
                                'value' => $Product->name,
                                'placeholder' =>'Enter Name',
                                'colsize' => 6
                            ])

                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'code',
                                'lebel' => 'Code',
                                'is_required' => true,
                                'value' => $Product->code,
                                'placeholder' =>'Enter Code',
                                'colsize' => 6
                            ])

                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'origin',
                                'lebel' => 'Manufacturer',
                                'is_required' => true,
                                'value' => $Product->origin,
                                'placeholder' =>'Enter Manufacturer',
                                'colsize' => 6
                            ])

                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'description',
                                'lebel' => 'Description',
                                'is_required' => true,
                                'value' =>  $Product->description,
                                'placeholder' =>'Enter Description',
                                'colsize' => 6
                            ])

                            <div class="form-group col-md-6 row  @error('category_id') has-error @enderror ">
                                <label class="col-sm-4 col-form-label">Category</label>
                                <div class="col-sm-8">
                                <select name="category_id" class="form-control customer_list" id="category_id">
                                            <option value="">Select One</option>
                                    @foreach ($Categories as $Category)
                                            <option value="{{ $Category->id }}" {{ $Category->id == old('category_id', $Product->category_id) ? 'selected' : '' }} >{{ $Category->name }}</option>
                                    @endforeach
                                </select>
                                    @error('category_id')
                                    <span class="help-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-6 row  @error('unit_id') has-error @enderror ">
                                <label class="col-sm-4 col-form-label">Unit</label>
                                <div class="col-sm-8">
                                <select name="unit_id" class="form-control customer_list" id="unit_id">
                                            <option value="">Select One</option>
                                    @foreach ($Units as $Unit)
                                            <option value="{{ $Unit->id }}" {{ $Unit->id == old('unit_id', $Product->unit_id) ? 'selected' : '' }} >{{ $Unit->name }}</option>
                                    @endforeach
                                </select>
                                    @error('unit_id')
                                    <span class="help-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            @include('layouts.ui.radio', [
                                'type' => 'text',
                                'name' => 'has_identifier',
                                'lebel' => 'Has Unique identifier',
                                'options' => ['Yes', 'No'],
                                'values' => [1, 0],
                                'selected_value' => $Product->has_identifier,
                                'colsize' => 6
                            ])

                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'reorder_limit',
                                'lebel' => 'Reorder Alert',
                                'is_required' => false,
                                'value' => $Product->reorder_limit,
                                'placeholder' =>'Enter reorder limit',
                                'colsize' => 6
                            ])

                            @include('layouts.ui.radio', [
                                'type' => 'text',
                                'name' => 'is_active',
                                'lebel' => 'Is Active',
                                'is_required' => true,
                                'options' => ['Active', 'Inactive'],
                                'values' => [1, 0],
                                'selected_value' => 1,
                                'colsize' => 6
                            ])
                       
                        </div>
                        
                        <div class="form-group row justify-content-md-center">
                            <div class="col-sm-2">
                                <button class="btn btn-info btn-block pointer" type="submit">Update</button>
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

@endpush
