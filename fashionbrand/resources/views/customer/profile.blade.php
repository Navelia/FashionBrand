<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Katalog Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .card img {
            width: 100%;
            height: auto;
        }

        .card {
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .card .card-body {
            margin-bottom: 40px;
        }

        .card-img-top {
            object-fit: cover;
            max-height: 200px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card .btn-bottom-right {
            position: absolute;
            bottom: 0;
            right: 0;
            margin: 10px;
        }

        .catalog-container {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">Fashion Brand</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                @if (Auth::user())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transaction.cart') }}">Shopping Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.profile') }}">Customer:
                            {{ Auth::user()->name }}</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="nav-link">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>

    <div class="container catalog-container">
        @if (session('status'))
            <div class='alert alert-success'>{{ session('status') }}</div>
        @endif
        <div class="row mb-4">
            <div class="col-12">
                <h2>Hi, {{ Auth::user()->name }}!</h2>
                <p class="mb-1">Alamat</p>
                <p class="mb-1"><strong>{{ Auth::user()->customer->address }}</strong></p>
                <br>
                <p class="mb-1">Nomor Telepon</p>
                <p class="mb-1"><strong>{{ Auth::user()->customer->phone_number }}</strong></p>
                <br>
                <p class="mb-1">Poin dimiliki: {{ Auth::user()->customer->points }}</p>

                <h5>Riwayat Transaksi</h5>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>No Transaksi</th>
                            <th>Tanggal Transaksi</th>
                            <th>Total Transaksi</th>
                            <th>Lokasi Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $d)
                            <tr>
                                <td class="text-center">{{ $d->id }}</td>
                                <td>{{ $d->created_at }}</td>
                                <td>Rp{{ number_format($d->total, 2, ',', '.') }}</td>
                                @if ($d->staff != null)
                                    <td>Toko</td>
                                @else
                                    <td>Online</td>
                                @endif
                                <td class="text-center"><a href="{{ route('transaction.custDetail', $d->id) }}"
                                        class="btn btn-fill btn-info">Detail Transaksi</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
