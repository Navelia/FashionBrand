@extends('layoutAdmin.layoutAdmin')
@section('content')
    <h2>Tambah Member Baru</h2>
    @if ($errors->any())
        <div class='alert alert-danger'>
            @foreach ($errors->all() as $err)
                <p class="mt-0 mb-0">{{ $err }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('user.addCustomer') }}">
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
                                            <h5>Nama Member</h5>
                                            <input type="text" name="name" id="nameMember" class="form-control"
                                                placeholder="Tuliskan nama member di sini" required>
                                        </div>
                                        <div class="form-group">
                                            <h5>Password Member</h5>
                                            <input type="password" name="password" id="nameMember" class="form-control"
                                                placeholder="Tuliskan password member di sini" minlength="8" required>
                                        </div>
                                        <div class="form-group">
                                            <h5>Konfirmasi Password Member</h5>
                                            <input type="password" name="conf_password" id="nameMember" class="form-control"
                                                placeholder="Konfirmasi password member di sini" minlength="8" required>
                                        </div>
                                        <div class="form-group">
                                            <h5>Email Member</h5>
                                            <input type="email" name="email" id="nameMember" class="form-control"
                                                placeholder="Tuliskan email member di sini" required>
                                        </div>
                                        <div class="form-group">
                                            <h5>Nomor Telepon</h5>
                                            <input type="text" name="phone" id="nameMember" class="form-control"
                                                placeholder="Tuliskan momor telepon member di sini" required>
                                        </div>
                                        <div class="form-group">
                                            <h5>Alamat</h5>
                                            <textarea name="address" id="addressMember" cols="30" rows="3" placeholder="Tuliskan alamat member di sini" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info btn-fill pull-right">Tambah Member</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
