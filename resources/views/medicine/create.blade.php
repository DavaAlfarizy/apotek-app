@extends('layouts.template')

@section('content')
    <form action="{{ route('medicine.create') }}" method="post" class="card p-5">
        <div class="mb-3 row">
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
            <label for="name" class="col-sm-2 col-form-label">Nama Obat :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="type" class="col-sm-2 col-form-label">Jenis Obat :</label>
            <div class="col-sm-10">
                <select class="form-select" name="type" id="type">
                    <option selected disabled hidden>Pilih</option>
                    <option value="tablet">Tablet</option>
                    <option value="sirup">Sirup</option>
                    <option value="kapsul">Kapsul</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="price" class="col-sm-2 col-form-label">Harga Obat :</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="price" name="price">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="stock" class="col-sm-2 col-form-label">Stock Tersedia :</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="stock" name="stock">
            </div>
        </div>
        <button class="btn btn- mt-3" type="submit" style="background-color: #153243; color:white">Tambah</button>
    </form>
@endsection
