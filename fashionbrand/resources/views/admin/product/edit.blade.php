@extends('layoutAdmin.layoutAdmin')
@section('content')
    <h2>Ubah Data Produk</h2>
    @if ($errors->any())
        <div class='alert alert-danger'>
            @foreach ($errors->all() as $err)
                <p class="mt-0 mb-0">{{ $err }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Ubah Data Produk</h4>
                        </div>
                        <div class="content">
                            <form>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <h5>Kategori Produk</h5>
                                            @foreach ($categories as $cat)
                                                <div class='col-md-2'><input type='checkbox'name='categoryproduct[]'
                                                        value='{{ $cat->id }}'
                                                        {{ in_array($cat->id, $proCat) ? 'checked' : '' }}>
                                                    {{ $cat->name }}</div>
                                            @endforeach
                                        </div>
                                        <br>
                                        <h5>Tipe Produk</h5>
                                        <input type="hidden" name="idProduct" value="{{ $product->id }}">
                                        <input type="text" name="typeproduct" id="typeProduct" value="{{ $product->type->name }}" class="form-control"
                                            disabled>
                                        <h5>Nama Produk</h5>
                                        <input type="text" name="nameproduct" id="nameProduct" class="form-control"
                                            placeholder="Tuliskan nama produk disini" required value="{{ $product->name }}">
                                        <h5>Brand Produk</h5>
                                        <input type="text" name="brandproduct" id="brandProduct" class="form-control"
                                            placeholder="Tuliskan brand produk disini" required
                                            value="{{ $product->brand }}">
                                        <h5>Harga Produk (dalam Rupiah)</h5>
                                        <input type="number" name="priceproduct" id="priceProduct" class="form-control"
                                            placeholder="Tuliskan harga produk disini" min="0" required
                                            value="{{ $product->price }}">
                                        <h5>Ukuran Produk</h5>
                                        @if ($product->type->unit == 'pcs')
                                            @if (in_array("xs", $proDim))
                                                <div class="col-md-2"><input type="checkbox"name="dimensionproduct[]"
                                                        value="xs" checked> XS</div>
                                            @else
                                                <div class="col-md-2"><input type="checkbox"name="dimensionproduct[]"
                                                        value="xs"> XS</div>
                                            @endif

                                            @if (in_array("s", $proDim))
                                                <div class="col-md-2"><input type="checkbox"name="dimensionproduct[]"
                                                        value="s" checked> S</div>
                                            @else
                                                <div class="col-md-2"><input type="checkbox"name="dimensionproduct[]"
                                                        value="s"> S</div>
                                            @endif

                                            @if (in_array("m", $proDim))
                                                <div class="col-md-2"><input type="checkbox"name="dimensionproduct[]"
                                                        value="m" checked> M</div>
                                            @else
                                                <div class="col-md-2"><input type="checkbox"name="dimensionproduct[]"
                                                        value="m"> M</div>
                                            @endif

                                            @if (in_array("l", $proDim))
                                                <div class="col-md-2"><input type="checkbox"name="dimensionproduct[]"
                                                        value="l" checked> L</div>
                                            @else
                                                <div class="col-md-2"><input type="checkbox"name="dimensionproduct[]"
                                                        value="l"> L</div>
                                            @endif

                                            @if (in_array("xl", $proDim))
                                                <div class="col-md-2"><input type="checkbox"name="dimensionproduct[]"
                                                        value="xl" checked> XL</div>
                                            @else
                                                <div class="col-md-2"><input type="checkbox"name="dimensionproduct[]"
                                                        value="xl"> XL</div>
                                            @endif

                                            @if (in_array("xxl", $proDim))
                                                <div class="col-md-2"><input type="checkbox"name="dimensionproduct[]"
                                                        value="xxl" checked> XXL</div>
                                            @else
                                                <div class="col-md-2"><input type="checkbox"name="dimensionproduct[]"
                                                        value="xxl"> XXL</div>
                                            @endif
                                        @else
                                            <input type='number'name='dimensionproduct[]' min=0 class='form-control' required
                                                placeholder='tuliskan ukuran produk disini' value='{{ $proDim[0] }}'>
                                            <label>{{$product->type->unit }}</label>
                                        @endif
                                        <h5>Upload Gambar</h5>
                                        <input type="file" accept="application/images" name="urlproduct" id="urlProduct"
                                            class="form-control">
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-6"><button type="submit"
                                            class="btn btn-info btn-fill pull-right">Simpan</button>
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