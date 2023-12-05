@extends('layouts.template')

@section('content')
    <form method="POST" action="{{ route('akun.store') }}" class="card p-5">
        <div class="mb-3 row">
            <h2>Buat Akun</h2>
            @csrf

            @if (Session::get('success'))
                <div class="alert alert-primary" role="alert">{{ Session::get('success') }}</div>
            @endif
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <label for="name" class="col-sm-2 col-form-label">Nama :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email :</label>
            <div class="col-sm-10">
                <input type="email" id="email" name="email" class="form-control" placeholder="Masukan Email">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Role :</label>
            <div class="col-sm-10">
                <select id="role" name="role" class="form-control">
                    <option selected disabled hidden>Pilih</option>
                    <option value="admin">Admin</option>
                    <option value="cashier">Cashier</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-secondary">Buat Akun</button>
    </form>
    </div>
@endsection
