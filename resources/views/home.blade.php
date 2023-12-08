@extends('layouts.template')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            @if (session('message'))
                <div class="alert alert-danger">
                    {{ session('message') }}
                </div>
            @endif
            @if (Session::get('isLogin'))
                <div class="alert alert-danger">
                    {{ session::get('isLogin') }}
                </div>
            @endif

            <div class="card" style="margin-top: 40px;">
                <div class="card-body">
                    <h1 class="card-title">Welcome {{ Auth::user()->name }}!</h1>
                    <hr class="my-4">
                    <p class="card-text">Aplikasi ini digunakan hanya oleh pegawai administrator APOTEK. Digunakan untuk mengelola
                        data obat, penyetokan, juga pembelian (kasir).</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <img src="../assets/img/ijo.jpeg" alt="Image" class="img-fluid" style="">
        </div>
    </div>
</div>
@endsection
