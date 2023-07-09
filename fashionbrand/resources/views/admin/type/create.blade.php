@extends('layoutAdmin.layoutAdmin')
@section('content')
    <h2>Tambah Tipe Baru</h2>
    <form method="POST" action="{{ route('type.store') }}">
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
                                            <h5>Nama Tipe</h5>
                                            <input type="text" name="name" id="txtName" class="form-control"
                                                placeholder="Tuliskan nama tipe disini" required>
                                        </div>
                                        <div class="form-group">
                                            <h5>Unit Tipe</h5>
                                            <select name="unit" id="cbUnit" class="form-control" required>
                                                <option value="pcs">Pcs</option>
                                                <option value="gr">Gram</option>
                                                <option value="mL">Mililiter</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <h5>Deskripsi</h5>
                                            <textarea name="description" id="txtDescription" class="form-control" placeholder="Tuliskan deskripsi tipe disini" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info btn-fill pull-right">Tambah Tipe</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
