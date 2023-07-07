@extends('layoutAdmin.layoutAdmin')
@section('content')
    <h2>Kategorimu</h2>

    <a href="{{ route('category.create') }}" class="btn btn-success"> + Tambah Kategori</a>
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
                                <th class="text-center">Nama Kategori</th>
                                <th class="text-center">Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td class="text-center">{{ $d->id }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>
                                                <form method="POST" action="{{ route('category.destroy', $d->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="submit" value="Hapus" class="btn btn-danger btn-fill"
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
