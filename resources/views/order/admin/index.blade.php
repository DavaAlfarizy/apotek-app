@extends('layouts.template')

@section('content')
    <div class="d-flex justify-content-between my-1">
        <div class="row w-100 ml-2">
            <form action="{{ route('order.data') }}" class="w-100 d-flex align-items-center" method="get">
                <div class="col-5">
                    <input type="date" name="search" id="search" class="form-control">
                </div>
                <button type="submit" class="btn btn-info m-1" id="cari_data">Search</button>
                <a href="{{ route('order.reset') }}" class="btn btn-secondary m-1" id="clear_data">Clear</a>
                <div style="margin-left: 30%;">
                    <a href="{{ route('order.export-excel') }}" class="btn btn-primary">Export Data(excel)</a>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Pembeli</th>
                <th>Obat</th>
                <th>Kasir</th>
                <th>Tanggal Pembelian</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $orders->currentPage() - 1 + $loop->index + 1 }}</td>
                    <td>{{ $order['name_customer'] }}</td>
                    <td>
                        <ol>
                            @foreach ($order['medicines'] as $medicine)
                                <li>
                                    {{ $medicine['name_medicine'] }}
                                    (Rp. {{ number_format($medicine['price'], 0, ',', '.') }})
                                    Rp. {{ number_format($medicine['sub_price'], 0, ',', '.') }}
                                    <small>qty {{ $medicine['qty'] }}</small>
                                </li>
                            @endforeach
                        </ol>
                    </td>
                    <td>{{ $order['user']['name'] }}</td>
                    {{-- setting local time sebagai wilayah Indonesia --}}

                    <td>
                        @php
                            \Carbon\Carbon::setLocale('id_ID');
                        @endphp
                        {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y') }}</td>
                    <td>
                        <a href="{{ route('order.download', $order['id']) }}" class="btn btn-secondary">Unduh
                            (.pdf)</a>
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
@endsection
