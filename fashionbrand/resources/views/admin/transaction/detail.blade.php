@extends('layoutAdmin.layoutAdmin')
@section('content')
    <a href="{{ route('transaction.index') }}" class="btn btn-fill btn-info">Kembali</a>
    <h2>Detail Transaksimu</h2>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="content">
                        <h3 class="mt-1 mb-1"><strong>Transaction ID: {{ $data->id }}</strong></h3>
                        <hr>
                        <h5 class="mb-1">Total Transaksi: <strong>Rp{{ number_format($data->total, 2, ',', '.') }}</strong>
                        </h5>
                        <h5 class="mb-1">Pembeli: <strong>{{ $data->customer->user->name }}</strong></h5>
                        @if ($data->staff != null)
                            <h5 class="mt-0 mb-0">Kasir: <strong>{{ $data->staff->name }}</strong></h5>
                        @else
                            <h5 class="mt-0 mb-0">Kasir: <strong>Transaksi Online</strong></h5>
                        @endif
                        <br>
                        <h6>Detail Barang</h6>
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Harga Beli</th>
                                    <th>Jumlah</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->products as $pro)
                                    <tr>
                                        <td>{{ $pro->name }}</td>
                                        <td>Rp{{ number_format($pro->pivot->price, 2, ',', '.') }}</td>
                                        <td>{{ $pro->pivot->quantity }}</td>
                                        <td>Rp{{ number_format($pro->pivot->sub_total, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <h6 class="text-right">Grand Total: Rp{{ number_format($data->grand_total, 2, ',', '.') }}</h6>
                        <h6 class="text-right">Pajak (PPn 11%): Rp{{ number_format($data->tax, 2, ',', '.') }}</h6>
                        @if ($data->points_histories == null)
                            <h6 class="text-right">Perolehan Poin: 0</h6>
                            <h6 class="text-right">Penggunaan Poin: 0</h6>
                        @else
                            @foreach ($data->points_histories as $point)
                                @if ($point->type == 'in')
                                    <h6 class="text-right">Perolehan Poin: {{ $point->amount }}</h6>
                                @else
                                    <h6 class="text-right">Penggunaan Poin: {{ $point->amount }}</h6>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
