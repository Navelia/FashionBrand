@extends('layoutAdmin.layoutAdmin')
@section('content')
    <h2>Reporting</h2>
    <h5>Tiga varian yang paling laku dibeli</h5>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Barang</th>
                                <th class="text-center">Jumlah Terjual</th>
                            </thead>
                            <tbody>
                                @foreach ($query as $key=>$q)
                                    <tr>
                                        <td>{{ $key+=1 }}</td>
                                        <td>{{ $q->name }} ({{ strtoupper($q->dimension) }})</td>
                                        <td>{{ $q->total_quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
