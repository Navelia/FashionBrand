@extends('layoutAdmin.layoutAdmin')
@section('content')
    <h2>Tambah Produk Baru</h2>
    @if ($errors->any())
        <div class='alert alert-danger'>
            @foreach ($errors->all() as $err)
                <p class="mt-0 mb-0">{{ $err }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
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
                                            <h5>Kategori Produk</h5>
                                            @foreach ($categories as $cat)
                                                <div class='col-md-2'><input type='checkbox'name='categoryproduct[]'
                                                        value='{{ $cat->id }}'> {{ $cat->name }}</div>
                                            @endforeach
                                        </div>
                                        <br>
                                        <h5>Tipe Produk</h5>
                                        <select name="typesproduct" id="selectedType" class="form-control" required>
                                            <option selected disabled>Pilih jenis produk disini</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}"> {{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                        <h5>Nama Produk</h5>
                                        <input type="text" name="nameproduct" id="nameProduct" class="form-control"
                                            placeholder="Tuliskan nama produk disini" required>
                                        <h5>Brand Produk</h5>
                                        <input type="text" name="brandproduct" id="brandProduct" class="form-control"
                                            placeholder="Tuliskan brand produk disini" required>
                                        <h5>Harga Produk (dalam Rupiah)</h5>
                                        <input type="number" name="priceproduct" id="priceProduct" class="form-control"
                                            placeholder="Tuliskan harga produk disini" min="0" required>
                                        <h5>Ukuran Produk</h5>
                                        <div class="col-md-12" id='inputUnit'>
                                            {{-- isi data dari ajax --}}
                                        </div>
                                        <h5>Upload Gambar</h5>
                                        <input type="file" accept="application/images" name="urlproduct" id="urlProduct"
                                            class="form-control"required>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Stock akan bernilai 0 saat produk dibuat</h5>
                                    </div>
                                    <div class="col-md-6"><button type="submit"
                                            class="btn btn-info btn-fill pull-right">Tambah Produk</button>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection