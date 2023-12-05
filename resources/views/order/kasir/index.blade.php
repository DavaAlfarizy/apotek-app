@extends('layouts.template')

@section('content')
    <div class="container mt-4">

        <div class="d-flex justify-content-between my-1">
            <div class="row w-100 ml-2">
                <form action="{{ route('kasir.order.index') }}" class="w-100 d-flex align-items-center" method="get">
                    <div class="col-5">
                        <input type="date" name="search" id="search" class="form-control">
                    </div>
                    <div class="col-4">
                        <div class="d-flex">
                            <button type="submit" class="btn  m-1" id="cari_data" style=" background-color:#16f4d0">Search</button>
                            <a href="{{ route('kasir.order.clear') }}" class="btn m-1"
                                id="clear_data" style=" background-color: #153243; color:aliceblue">Clear</a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-6">
                        <a href="{{ route('kasir.order.create') }}" class="btn" style="margin-left: 130px; background-color:#16f4d0">Pembelian Baru</a>
                    </div>
                </form>
            </div>
        </div>


        <table class="table table-striped table-bordered table-hover" style="margin-top: 40px">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Pembeli</th>
                    <th>Obat</th>
                    <th>Total Bayar</th>
                    <th>Kasir</th>
                    <th>Tanggal Beli</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 0;
                @endphp
                @foreach ($orders as $order)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $order['name_customer'] }}</td>
                        <td>
                            {{-- karena column medicines pada table orders bertipe json yang diubah formatnya menjadi array, maka dari itu untuk mengakses/menampilkan itemnya perlu menggunakan looping --}}
                            @foreach ($order['medicines'] as $medicine)
                                <ol>
                                    <li>
                                        {{-- mengakses key array assoc dari tiap item array value column medicine --}}
                                        {{ $medicine['name_medicine'] }} (
                                        {{ number_format($medicine['price'], 0, ',', '.') }}
                                        )
                                        : Rp. {{ number_format($medicine['sub_price'], 0, ',', '.') }} <small>qty
                                            {{ $medicine['qty'] }}</small>
                                    </li>
                                </ol>
                            @endforeach
                        </td>
                        <td>
                            {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                        <td>
                            @if ($order->user)
                                {{ $order->user->name }}
                                {{ $order->user->id }}
                            @endif
                        </td>

                        <td>
                            @if ($order->created_at)
                                @php
                                    \Carbon\Carbon::setLocale('id_ID');
                                @endphp
                                {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y') }}
                                <br>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('kasir.order.download', $order['id']) }}" class="btn btn-primary">Download
                                Struk</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-end">
            @if ($orders->count())
                {{ $orders->links() }}
            @endif
        </div>
    </div>
@endsection
