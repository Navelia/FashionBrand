@extends('layoutAdmin.layoutAdmin')
@section('content')
    <h2>Produk Anda</h2>

    <a href="{{ route('product.create') }}" class="btn btn-success"> + Tambah Produk</a>
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
                                <th class="text-center">Nama Produk</th>
                                <th class="text-center">Gambar</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Tipe Produk</th>
                                <th class="text-center">Brand</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Varian & Stok</th>
                                <th class="text-center">Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td class="text-center">{{ $d->id }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>
                                            <div>
                                                <img class="img-fluid mb-3" src="{{ asset($d->image_url) }}"
                                                    style="max-height:150px" />
                                            </div>
                                        </td>
                                        <td>
                                            <ul>
                                                @foreach ($d->categorieswithTrashed as $c)
                                                    <li>{{ $c->name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $d->typewithTrashed->name }} </td>
                                        <td>{{ $d->brand }}</td>
                                        <td>Rp{{ number_format($d->price, 2, ',', '.') }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($d->variantswithTrashed as $variant)
                                                    <li> {{ $variant->dimension }} = {{ $variant->stock }}</li>
                                                @endforeach
                                            </ul>
                                        </td>

                                        <td>
                                            <a href="{{ route('product.showAddStock', $d->id) }}"
                                                class="btn btn-fill btn-info">Tambah Stok</a>
                                            <a href="{{ route('product.edit', $d->id) }}"
                                                class="btn btn-fill btn-info">Ubah</a>
                                            <form method="POST" action="{{ route('product.destroy', $d->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" value="Hapus" class="btn btn-danger btn-fill"
                                                    onclick="return confirm('Apakah Anda ingin menghapus produk dengan data {{ $d->id }} - {{ $d->name }}?')">
                                            </form>
                                        </td>
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
