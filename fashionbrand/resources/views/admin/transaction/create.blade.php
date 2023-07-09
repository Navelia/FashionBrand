@extends('layoutAdmin.layoutAdmin')
@section('content')
    <h2>Tambah Transaksimu</h2>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h5>Pelanggan</h5>
                                    <select name="namePelanggan" id="namePelanggan" class="form-control">
                                        <option selected disabled>Pilih Pelanggan</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->user->name }} -
                                                {{ $customer->phone_number }}</option>
                                        @endforeach
                                    </select>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>Tambah Produk</h5>
                                            <div class="col-md-4">
                                                <select id="cbNameProduk" class="form-control">
                                                    <option selected disabled>Pilih Produk</option>
                                                    @foreach ($products as $pro)
                                                        <option value="{{ $pro->id }}" price="{{ $pro->price }}" name="{{ $pro->name }}">
                                                            {{ $pro->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <select id="cbDimensiProduk" class="form-control">
                                                    <option selected disabled>Pilih Dimensi</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" id="nudJumlahProduk" class="form-control"
                                                    value="1" min="1">
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-fill btn-info" id="btnTambahProduk">Tambah
                                                    Produk</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <form action="{{ route('transaction.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6>Daftar Pembelian</h6>
                                                <table class="table table-hover table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Nama Produk</th>
                                                            <th class="text-center">Harga</th>
                                                            <th class="text-center">Jumlah</th>
                                                            <th class="text-center">Sub Total</th>
                                                            <th class="text-center">Batalkan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="bodyTable">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            var total = 0;
            $('#cbNameProduk').on('change', function() {
                var idProduct = $('#cbNameProduk').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('product.getDimension') }}',
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'idProduct': idProduct,
                    },
                    success: function(data) {
                        $('#cbDimensiProduk').html('');
                        $('#cbDimensiProduk').append(
                            '<option selected disabled>Pilih Dimensi</option>');
                        $('#cbDimensiProduk').append(data.msg);
                    }
                });
            });
            $('#btnTambahProduk').on('click', function() {
                var idProduk = $('#cbNameProduk').val();
                var namaProduk = $('#cbNameProduk').find(":selected").attr('name');
                var hargaProduk = $('#cbNameProduk').find(":selected").attr('price');
                var dimensi = $('#cbDimensiProduk').val();
                var jumlah = $('#nudJumlahProduk').val();
                var subtotal = hargaProduk * jumlah;
                total += subtotal*1;
                var tableRow = '<tr>' +
                    '<td>' + namaProduk + '(' + dimensi + ')</td>' +
                    '<td>Rp' + hargaProduk + '</td>' +
                    '<td>' + jumlah + '</td>' +
                    '<td>Rp' + subtotal + '</td>' +
                    '<td class="text-center"><button type="button" onclick="hapusBarang()" class="btn btn-sm btn-fill btn-danger"><i class=\'bx bx-trash\'></i></button>' +
                    '</td>' +
                    '</tr>';
                $('#bodyTable').append(tableRow);

            });

            function hapusBarang(){
                alert('Hapus!');
            }
        });
    </script>
@endsection
