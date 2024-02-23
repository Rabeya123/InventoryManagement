@extends('layouts.master')

@push('styles')

@endpush

@section('content')

<div class="page-heading row">
    <div class="col-md-6">  <h1 class="page-title">User</h1></div>
    <div class="col-md-6"><a class="btn btn-default float-right mt-4" href="{{ route('users.index') }}" > <i class="fa fa-arrow-left"></i> Back</a></div>
</div>

<div class="page-content fade-in-up">
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
                    <form class="form-horizontal" action="{{ route('users.update',$User) }}" method="POST">
                            @csrf
                            @method('PUT')

                        <div class="row">
                            
                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'name',
                                'lebel' => 'Name',
                                'is_required' => true,
                                'value' => $User->name,
                                'placeholder' =>'Enter Name',
                                'colsize' => 6
                            ])
                           
                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'email',
                                'lebel' => 'Email',
                                'is_required' => true,
                                'value' => $User->email,
                                'placeholder' =>'Enter Name',
                                'colsize' => 6
                            ])

                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'mobile',
                                'lebel' => 'Mobile',
                                'is_required' => true,
                                'value' => $User->mobile,
                                'placeholder' =>'Enter Mobile',
                                'colsize' => 6
                            ])
                            
                          
                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'address',
                                'lebel' => 'Address',
                                'is_required' => false,
                                'value' => "",
                                'placeholder' =>'Enter Address',
                                'colsize' => 6
                            ])
                                                       
                            <div class="form-group col-md-6 row  @error('role_id') has-error @enderror">
                                <label class="col-sm-4 col-form-label">Role <span class="text-danger">*</span> </label>
                                <div class="col-sm-8">
                                    <select name="role_id" class="form-control select_item_list" id="role_id">
                                        <option value="">Select one</option>
                                    @foreach ($Roles as $Role)
                                        <option value="{{ $Role->id }}"  {{ $Role->id == old('role_id', $User->role_id) ? 'selected' : '' }} >{{ $Role->name }}</option>
                                    @endforeach

                                </select>
                                    @error('role_id')
                                    <span class="help-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            @include('layouts.ui.radio', [
                                'type' => 'text',
                                'name' => 'is_active',
                                'lebel' => 'Is Active',
                                'options' => ['Active', 'Inactive'],
                                'values' => [1, 0],
                                'selected_value' => $User->is_active,
                                'colsize' => 6
                            ])

                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'password',
                                'lebel' => 'Password',
                                'is_required' => false,
                                'value' =>"",
                                'placeholder' =>'Enter Password',
                                'colsize' => 6
                            ])

                            @include('layouts.ui.input',[
                                'type' => 'text',
                                'name' => 'password_confirmation',
                                'lebel' => 'Password Confirmation',
                                'is_required' => false,
                                'value' =>"",
                                'placeholder' =>'Confirm Password',
                                'colsize' => 6
                            ])

                        </div>

                        <div class="form-group row justify-content-md-center">
                            <div class="col-sm-2">
                                <button class="btn btn-warning btn-block pointer" type="submit">Update</button>
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
