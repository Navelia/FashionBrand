@extends('layoutAdmin.layoutAdmin')
@section('content')
    <h2>Tambah Kategori Baru</h2>
        <form method="POST" action="{{ route('type.update', $data->id) }}">
        @csrf
        @method('PUT')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Ubah Tipe</h4>
                        </div>
                        <div class="content">
                            <form>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <h5>Nama Tipe</h5>
                                            <input type="text" class="form-control" name="name" value="{{ $data->name }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <h5>Deskripsi Tipe</h5>
                                            <textarea rows="5" class="form-control" name="description">{{ $data->description }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-info btn-fill pull-right">Update Profile</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
