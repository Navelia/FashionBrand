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
                                    <form action="{{ route('transaction.store') }}" method="POST">
                                        @csrf
                                        <select name="namePelanggan" id="namePelanggan" class="form-control" required>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}" points="{{ $customer->points }}">
                                                    {{ $customer->user->name }} -
                                                    {{ $customer->phone_number }} | Poin: {{ $customer->points }}</option>
                                            @endforeach
                                        </select>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5>Tambah Produk</h5>
                                                <div class="col-md-4">
                                                    <select id="cbNameProduk" class="form-control">
                                                        <option value="nd" selected disabled>Pilih Produk</option>
                                                        @foreach ($products as $pro)
                                                            <option value="{{ $pro->id }}" price="{{ $pro->price }}"
                                                                name="{{ $pro->name }}">
                                                                {{ $pro->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <select id="cbDimensiProduk" class="form-control">
                                                        <option value="nd" selected disabled>Pilih Dimensi</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="number" id="nudJumlahProduk" class="form-control"
                                                        value="1" min="1">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-fill btn-info"
                                                        id="btnTambahProduk">Tambah
                                                        Produk</button>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
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
                                        <div class="row" id="rowBawah">
                                            <div class="col-md-12">
                                                <div class="col-md-6">
                                                    <button id="btnPakaiPoin" type="button"
                                                        class="btn btn-fill btn-info">Pakai
                                                        Poin</button>
                                                    <br><br>
                                                    <h6 id="txtGrandTotal">Grand Total: Rp0</h6>
                                                    <h6 id="txtPajak">Pajak: Rp0</h6>
                                                    <h6 id="txtPPoin">Penggunaan Poin: Rp0</h6>
                                                    <h6 id="txtTotal">Total: Rp0</h6>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <button type="submit" class="btn btn-fill btn-primary"><strong>Selesaikan
                                                            Transaksi</strong></button>
                                                </div>
                                            </div>
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
        var total = 0;
        $(document).ready(function() {
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
                            '<option value="nd" selected disabled>Pilih Dimensi</option>');
                        $('#cbDimensiProduk').append(data.msg);
                    }
                });
            });
            $('#btnTambahProduk').on('click', function() {
                var idProduk = $('#cbNameProduk').val();
                var namaProduk = $('#cbNameProduk').find(":selected").attr('name');
                var hargaProduk = $('#cbNameProduk').find(":selected").attr('price');
                var idDimensi = $('#cbDimensiProduk').val();
                var dimensi = $('#cbDimensiProduk').find(":selected").attr('dimension');
                var stock = $('#cbDimensiProduk').find(":selected").attr('stock');
                var jumlah = $('#nudJumlahProduk').val();
                if (idProduk != null) {
                    if (idDimensi != null) {
                        if (stock * 1 < jumlah * 1) {
                            alert('Jumlah stok tidak mencukupi!');
                            $('#cbDimensiProduk').val('nd');
                        } else {
                            var subtotal = hargaProduk * jumlah;
                            if ($('#tdJumlah' + idDimensi).length) {
                                var jmlhTd = $('#tdJumlah' + idDimensi).html();
                                jmlhTd = jmlhTd * 1 + jumlah * 1;
                                if (jmlhTd > stock) {
                                    alert('Sebagian stok telah diinput, jumlah stok tidak mencukupi!')
                                } else {
                                    var isiTdJumlah = jmlhTd;

                                    var subTotalTd = $('#tdSubtotal' + idDimensi).html().substring(2);
                                    subTotalTd = subTotalTd * 1 + subtotal * 1;
                                    var isiTdSubtotal = 'Rp' + subTotalTd;

                                    $('#tdJumlah' + idDimensi).html(isiTdJumlah);
                                    $('#tdSubtotal' + idDimensi).html(isiTdSubtotal)
                                    $('#iJmlh' + idDimensi).val(isiTdJumlah);
                                }
                            } else {
                                var tableRow = '<tr id="trDimensi' + idDimensi + '">' +
                                    '<td>' + namaProduk + ' (' + dimensi + ')</td>' +
                                    '<td>Rp' + hargaProduk + '</td>' +
                                    '<td id="tdJumlah' + idDimensi + '">' + jumlah + '</td>' +
                                    '<td id="tdSubtotal' + idDimensi + '">Rp' + subtotal + '</td>' +
                                    '<td class="text-center"><button type="button" onclick="hapusBarang(' +
                                    idDimensi +
                                    ')" class="btn btn-sm btn-fill btn-danger"><i class=\'bx bx-trash\'></i></button>' +
                                    '</td>' +
                                    '<input type="hidden" id="iJmlh' + idDimensi +
                                    '" name="jmlhProduk[]" value="' + jumlah + '">' +
                                    '<input type="hidden" name="varianProduk[]" value="' + idDimensi +
                                    '">' +
                                    '</tr>';
                                $('#bodyTable').append(tableRow);
                            }
                            $('#cbDimensiProduk').val('nd');
                            $('#cbDimensiProduk').html(
                                '<option value="nd" selected disabled>Pilih Dimensi</option>');
                            $('#cbNameProduk').val('nd');
                            $('#nudJumlahProduk').val('1');

                            total = total * 1 + subtotal * 1;
                            $('#txtGrandTotal').html('Grand Total: Rp' + total);

                            var tax = total * 0.11;
                            var totalWithTax = total * 1 + tax * 1;
                            $('#txtPajak').html('Pajak: Rp' + tax);
                            if ($('#iHPoin').length){
                                var poin = $('#namePelanggan').find(":selected").attr('points');
                                var potongPoin = poin * 1000;
                                $('#txtPPoin').html('Penggunaan Poin: Rp' + potongPoin);
                            }
                            else{
                                $('#txtPPoin').html('Penggunaan Poin: Rp0');
                            }
                            $('#txtTotal').html('Total: Rp' + totalWithTax);
                        }
                    }
                }
            });
            $('#btnPakaiPoin').on('click', function() {
                var poin = $('#namePelanggan').find(":selected").attr('points');
                if (poin > 0 && total >= 100000) {
                    var potongPoin = poin * 1000;
                    total = total * 1 - potongPoin * 1;
                    var tax = total * 0.11;
                    var totalWithTax = total * 1 + tax * 1;
                    $('#txtGrandTotal').html('Grand Total: Rp' + total);
                    $('#txtPajak').html('Pajak: Rp' + tax);
                    $('#txtPPoin').html('Penggunaan Poin: Rp' + potongPoin);
                    $('#txtTotal').html('Total: Rp' + totalWithTax);
                    $('#rowBawah').append('<input type="hidden" name="poin" value="true" id="iHPoin">');
                    $('#btnPakaiPoin').attr('disabled', 'true');
                } else {
                    alert('Poin tidak dapat digunakan! Poin = 0 atau Nominal Belanja < Rp100.000.');
                }
            })
        });

        function hapusBarang(idDimensi) {
            var poin = $('#namePelanggan').find(":selected").attr('points');
            var subTotalTd = $('#tdSubtotal' + idDimensi).html().substring(2);
            $('#trDimensi' + idDimensi).remove();

            total = total * 1 - subTotalTd * 1;
            if ($('#iHPoin').length && total < 100000) {
                var potongPoin = poin * 1000;
                total = total * 1 + potongPoin * 1;
                $('#txtPPoin').html('Penggunaan Poin: Rp0');
                $('#iHPoin').remove();
                $('#btnPakaiPoin').removeAttr('disabled');
                alert('Penggunaan Poin dibatalkan karena transaksi < Rp100.000');
            }
            $('#txtGrandTotal').html('Grand Total: Rp' + total);

            var tax = total * 0.11;
            var totalWithTax = total * 1 + tax * 1;
            $('#txtGrandTotal').html('Grand Total: Rp' + total);
            $('#txtPajak').html('Pajak: Rp' + tax);
            $('#txtTotal').html('Total: Rp' + totalWithTax);
        }
    </script>
@endsection
