@extends('layoutAdmin.layoutAdmin')
@section('content')
    <a href="{{ route('transaction.index') }}"><i class='bx bx-left-arrow-alt'></i> Kembali</a>
    <h2>Detail Transaksimu</h2>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="content">
                        <h3 class="mt-1 mb-1"><strong>Transaction ID: {{ $data->id }}</strong></h3>
                        <hr>
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
                                    <th>Dimensi</th>
                                    <th>Harga Beli</th>
                                    <th>Jumlah</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->variants as $var)
                                    <tr>
                                        <td>{{ $var->product->name }}</td>
                                        <td>{{ strtoupper($var->dimension) }}</td>
                                        <td>Rp{{ number_format($var->pivot->price, 2, ',', '.') }}</td>
                                        <td>{{ $var->pivot->quantity }}</td>
                                        <td>Rp{{ number_format($var->pivot->sub_total, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <h6 class="text-right">Grand Total: Rp{{ number_format($data->grand_total, 2, ',', '.') }}</h6>
                        <h6 class="text-right">Pajak (PPn 11%): Rp{{ number_format($data->tax, 2, ',', '.') }}</h6>
                        @if (count($data->points_histories) == 0)
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
                        <h6 class="text-right">Total Transaksi: Rp{{ number_format($data->total, 2, ',', '.') }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
