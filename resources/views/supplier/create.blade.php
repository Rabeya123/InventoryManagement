@extends('layouts.master')

@section('title', 'Bondstein || Supplier List')

@push('styles')

@endpush

@section('content')

<div class="page-heading row">
    <div class="col-md-6">  <h1 class="page-title">Supplier</h1></div>
    <div class="col-md-6"><a class="btn btn-default float-right mt-4" href="{{ route('companies.index') }}" > <i class="fa fa-arrow-left"></i> Back</a></div>
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
                    <form class="form-horizontal" action="{{ route('companies.store') }}" method="POST">
                            @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <p class="lead">Supplier details</p>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            
                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'name',
                                'lebel' => 'Company',
                                'is_required' => true,
                                'value' => null,
                                'placeholder' =>'Enter Name',
                                'colsize' => 6
                            ])

                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'address',
                                'lebel' => 'Address',
                                'is_required' => true,
                                'value' => null,
                                'placeholder' =>'Enter Address',
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

                        <div class="row">
                            <div class="col-md-12">
                                <p class="lead">Contact details</p>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            @include('layouts.ui.input',[
                                    'type' => 'text',
                                    'name' => 'contact_name',
                                    'lebel' => 'Name',
                                    'is_required' => true,
                                    'value' => null,
                                    'placeholder' =>'Enter Name',
                                    'colsize' => 6
                                ])
    
                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'contact_mobile',
                                'lebel' => 'Mobile',
                                'is_required' => true,
                                'value' => null,
                                'placeholder' =>'Enter Mobile',
                                'colsize' => 6
                            ])

                            @include('layouts.ui.input',[
                                'type' => 'email',
                                'name' => 'contact_email',
                                'lebel' => 'Email',
                                'is_required' => true,
                                'value' => null,
                                'placeholder' =>'Enter Email',
                                'colsize' => 6
                            ])

                        </div>

                        <div class="form-group row justify-content-md-center">
                            <div class="col-sm-2">
                                <button class="btn btn-info btn-block pointer" type="submit">Create</button>
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
