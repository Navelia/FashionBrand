@extends('layoutAdmin.layoutAdmin')
@section('content')
    <h2>Tambah Stok Produk</h2>
    @if ($errors->any())
        <div class='alert alert-danger'>
            @foreach ($errors->all() as $err)
                <p class="mt-0 mb-0">{{ $err }}</p>
            @endforeach
        </div>
    @endif
<h4>{{ $product->name }}</h4>
    <form method="POST" action="{{ route('product.updateStock', $product->id) }}">
        @csrf
        @method('PUT')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="content">
                            <form>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Varian Produk</h5>
                                        <select name="variantssproduct" id="selectedType" class="form-control" required>
                                            @foreach ($variants as $var)
                                                <option value="{{ $var->id }}">{{ strtoupper($var->dimension) }}</option>
                                            @endforeach
                                        </select>
                                        <h5>Stok Produk</h5>
                                        <input type="number" name="stockproduct" id="stockProduct" class="form-control"
                                            placeholder="Tuliskan penambahan jumlah stok produk disini" min=1 required>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-6"><button type="submit"
                                            class="btn btn-info btn-fill pull-right">Tambah Stok</button>
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
