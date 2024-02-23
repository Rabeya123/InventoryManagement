@extends('layouts.master')

@section('title', 'Bondstein || Contact Create')

@push('styles')

@endpush

@section('content')

<div class="page-heading row">
    <div class="col-md-6">  <h1 class="page-title">Contact</h1></div>
    <div class="col-md-6"><a class="btn btn-default float-right mt-4" href="{{ route('contacts.index') }}" > <i class="fa fa-arrow-left"></i> Back</a></div>
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
                    <form class="form-horizontal" action="{{ route('contacts.store') }}" method="POST">
                            @csrf

                        <div class="row">

                            @include('layouts.ui.input',[
                                    'type' => 'text',
                                    'name' => 'name',
                                    'lebel' => 'Name',
                                    'is_required' => true,
                                    'value' => null,
                                    'placeholder' =>'Enter Name',
                                    'colsize' => 6
                                ])
    
                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'mobile',
                                'lebel' => 'Mobile',
                                'is_required' => true,
                                'value' => null,
                                'placeholder' =>'Enter Mobile',
                                'colsize' => 6
                            ])

                            @include('layouts.ui.input',[
                                'type' => 'email',
                                'name' => 'email',
                                'lebel' => 'Email',
                                'is_required' => true,
                                'value' => null,
                                'placeholder' =>'Enter Email',
                                'colsize' => 6
                            ])

                            <div class="form-group col-md-6 row  @error('company_id') has-error @enderror ">
                                <label class="col-sm-4 col-form-label">Company</label>
                                <div class="col-sm-8">
                                <select name="company_id" class="form-control customer_list" id="company_id">
                                            <option value="">Select One</option>
                                    @foreach ($Companies as $Company)
                                            <option value="{{ $Company->id }}" {{ $Company->id == old('company_id') ? 'selected' : '' }} >{{ $Company->name }}</option>
                                    @endforeach
                                </select>
                                    @error('company_id')
                                    <span class="help-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

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
