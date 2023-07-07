@extends('layoutAdmin.layoutAdmin')
@section('content')
    <h2>Tipe Produkmu</h2>

    <a href="{{ route('type.create') }}" class="btn btn-success"> + Tambah Tipe</a>
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
                                <th class="w-auto">ID</th>
                                <th>Nama Tipe</th>
                                <th>Description</th>
                                <th>Unit</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td class="w-auto">{{ $d->id }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->description }}</td>
                                        <td>{{ $d->unit }}</td>
                                        <td><a href="{{ route('type.edit', $d->id) }}"
                                                class="btn btn-fill btn-info">Ubah</a>
                                            <form method="POST" action="{{ route('type.destroy', $d->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" value="Hapus" class="btn btn-fill btn-danger"
                                                    onclick="return confirm('Apakah Anda ingin menghapus kategori dengan data {{ $d->id }} - {{ $d->name }}?')">
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
