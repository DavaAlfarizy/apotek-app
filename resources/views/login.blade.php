@extends('layouts.template')

@section('content')

<h1 style="text-align: center;">Login First</h1>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('login.auth') }}" method="post" class="card p-5" style="margin-top: 25%">
                @csrf

                @if (Session::get('failed'))
                    <div class="alert alert-danger">
                        {{ Session::get('failed') }}
                    </div>
                @endif
                @if (Session::get('logout'))
                    <div class="alert alert-primary">
                        {{ Session::get('logout') }}
                    </div>
                @endif
                @if (Session::get('canAccess'))
                    <div class="alert alert-danger">
                        {{ Session::get('canAccess') }}
                    </div>
                @endif

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-" style="background-color: #153243; color: #16f4d0;">Login</button>
            </form>
        </div>
        <div class="col-md-6">
            <img src="../assets/img/dokter.png" alt="Image" class="img-fluid" style="justify-content:end; margin-top:45px">
        </div>
    </div>
</div>
@endsection
