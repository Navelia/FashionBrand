@extends('layoutAdmin.layoutAdmin')
@section('content')
    <h2>Tambah Kategori Baru</h2>
    @if ($errors->any())
        <div class='alert alert-danger'>
            @foreach ($errors->all() as $err)
                <p class="mt-0 mb-0">{{ $err }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('category.store') }}">
        @csrf
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="content">
                            <form>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <h5>Nama Kategori</h5>
                                            <input type="text" name="namecategory" id="nameCategory" class="form-control"
                                                placeholder="Tuliskan nama kategori disini" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info btn-fill pull-right">Tambah Kategori</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
