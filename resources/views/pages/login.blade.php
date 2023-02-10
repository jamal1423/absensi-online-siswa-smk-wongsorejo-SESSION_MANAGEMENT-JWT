@extends('layouts.main-login')

@section('content')
<div class="card o-hidden">
    <div class="row">
        <div class="col-md-6">
            <div class="p-4">
                <div class="auth-logo text-center mb-4"><img src="{{ asset('gambar-umum/logo.png') }}" alt=""></div>
                @if(Session::has('loginError'))
                    <div class="alert alert-danger">
                        <button class="close" data-dismiss="alert"></button>
                        <strong>Periksa username / password Anda.
                    </div>
                @endif
                <h1 class="mb-3 text-18">Login</h1>
                <form method="post" action="{{ url('/login') }}">
                    @method('post')
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input class="form-control form-control-rounded" name="username" id="username" type="text" autocomplete="off" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control form-control-rounded" name="password" id="password" type="password">
                    </div>
                    <button type="submit" name="submit-login" class="btn btn-rounded btn-primary btn-block mt-2">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection