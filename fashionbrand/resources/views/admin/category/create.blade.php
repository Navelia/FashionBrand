@extends('layoutAdmin.layoutAdmin')
@section('content')
    <h2>Tambah Kategori Baru</h2>
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
                                                placeholder="Tuliskan nama kategori disini">
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
