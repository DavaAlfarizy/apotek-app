@extends('layouts.template')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-primary" role="alert">{{ Session::get('success') }}</div>
    @endif
    @if (Session::get('deleted'))
        <div class="alert alert-warning" role="alert">{{ Session::get('deleted') }}</div>
    @endif
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <td>No</td>
                <td>Nama</td>
                <td>Tipe</td>
                <td>Harga</td>
                <td>Stock</td>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach ($medicines as $medicine)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $medicine['name'] }}</td>
                    <td>{{ $medicine['type'] }}</td>
                    <td> Rp. {{ number_format($medicine['price'], 0, ',','.' )}}</td>
                    <td>{{ $medicine['stock'] }}</td>
                    <td class="d-flex justify-content-center">
                        <a href="{{ route('medicine.edit', $medicine['id']) }}" class="btn btn-primary me-3">Edit</a>
                        <form action="{{ route('medicine.delete',  $medicine['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
