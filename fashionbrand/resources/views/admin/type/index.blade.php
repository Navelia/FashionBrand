@extends('layoutAdmin.layoutAdmin')
@section('content')
    <h2>Tipe Produkmu</h2>

    <a href="{{ route('category.create') }}" class="btn btn-success"> + Tambah Tipe</a>
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
                                <th>ID</th>
                                <th>Nama Kategori</th>
                                <th>Unit</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                {{-- @foreach ($data as $d) --}}
                                <tr>
                                    {{-- <td>{{ $d->id }}</td>
                                        <td>{{ $d->name }}</td> --}}
                                    {{-- <td> <a href="{{ route('category.edit') }}" class="btn">Ubah</a>
                                            <form method="POST" action="{{ route('category.destroy', $d->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" value="Hapus" class="btn"
                                                    onclick="return confirm('Apakah Anda ingin menghapus kategori dengan data {{ $d->id }} - {{ $d->name }}?')">
                                            </form>
                                        </td> --}}
                                    <td>1</td>
                                    <td>Cole</td>
                                    <td>10</td>
                                    <td>
                                        <a href=# class="btn btn-info btn-fill">Ubah</a>
                                        <div class="inline-block">
                                            <form method="POST" action="">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" value="Hapus" class="btn btn-danger btn-fill"
                                                    onclick="return confirm('Apakah Anda ingin menghapus kategori dengan data?')">
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                {{-- @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
