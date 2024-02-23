@extends('layouts.guest')

@section('content')
    <div class="content">
        <!-- <div class="brand mt-5">
            {{-- <a class="link" href="/">Bondstein <span class="small">Inventory</span> </a> --}}
            <img src="{{ asset('assets/img/logos/logo.png') }}" alt="" style="max-width: 60%">
        </div> -->
        <form id="login-form" action="{{ route('login') }}" method="POST">
            @csrf
            @method('POST')
            <h2 class="login-title">User LogIn</h2>
            <div class="form-group @error('email') has-error @enderror">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-envelope"></i></div>
                    <input class="form-control" type="email" name="email" placeholder="Email" autocomplete="off">
                    @error('email')
                    <span class="help-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group @error('password') has-error @enderror">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-lock font-16"></i></div>
                    <input class="form-control" type="password" name="password" placeholder="Password">
                    @error('password')
                    <span class="help-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-info btn-block relaoding-animation" type="submit">Login</button>
            </div>
        </form>
    </div>
@endsection
