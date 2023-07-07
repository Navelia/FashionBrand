@extends('layoutAdmin.layoutAdmin')
@section('content')
    <h2>Transaksimu</h2>
    <a href="{{ route('transaction.create') }}" class="btn btn-success"> + Tambah Transaksi</a>
    @if (session('status'))
        <div class='alert alert-success'>{{ session('status') }}</div>
    @endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th class="text-center">ID</th>
                                <th class="text-center">Tanggal Transaksi</th>
                                <th class="text-center">Nama Pelanggan</th>
                                <th class="text-center">Total Transaksi</th>
                                <th class="text-center">Nama Kasir</th>
                                <th class="text-center">Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td class="text-center">{{ $d->id }}</td>
                                        <td>{{ $d->created_at }}</td>
                                        <td>{{ $d->customer->user->name }}</td>
                                        <td>Rp{{ number_format($d->total, 2, ',', '.') }}</td>
                                        <td>{{ $d->staff->name }}</td>
                                        <td class="text-center"><a href="{{ route('transaction.show', $d->id) }}"
                                                class="btn btn-fill btn-info">Detail Transaksi</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
