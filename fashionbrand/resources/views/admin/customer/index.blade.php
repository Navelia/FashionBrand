@extends('layoutAdmin.layoutAdmin')
@section('content')
    <h2>Membermu</h2>
    @can('owner')
        <a href="{{ route('customer.create') }}" class="btn btn-success"> + Tambah Member</a>
    @endcan
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
                                <th class="text-center">Nama</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">Nomor HP</th>
                                <th class="text-center">Bergabung Sejak</th>
                                @can('owner')
                                    <th class="text-center">Aksi</th>
                                @endcan
                            </thead>
                            <tbody>
                                @foreach ($customers as $cust)
                                    <tr>
                                        <td>{{ $cust->id }}</td>
                                        <td>{{ $cust->user->name }}</td>
                                        <td>{{ $cust->user->email }}</td>
                                        <td>{{ $cust->address }}</td>
                                        <td>{{ $cust->phone_number }}</td>
                                        <td>{{ $cust->user->created_at }}</td>
                                        <td>
                                            @can('owner', $cust)
                                                <form method="POST" action="{{ route('customer.destroy', $cust->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="submit" value="Hapus" class="btn btn-danger btn-fill"
                                                        onclick="return confirm('Apakah Anda ingin menghapus customer dengan data {{ $cust->id }} - {{ $cust->user->name }}?')">
                                                </form>
                                            @endcan
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
