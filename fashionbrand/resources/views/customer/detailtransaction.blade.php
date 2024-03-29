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
        <div class="row mb-4">
            <div class="col-12">
                <h2>Detail Transaksi No.{{ $transaction->id }}</h2>
                @if ($transaction->staff != null)
                    <h5 class="mt-0 mb-0">Kasir: <strong>{{ $transaction->staff->name }}</strong></h5>
                @else
                    <h5 class="mt-0 mb-0">Kasir: <strong>Transaksi Online</strong></h5>
                @endif
                <h6>Detail Barang</h6>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Dimensi</th>
                            <th>Harga Beli</th>
                            <th>Jumlah</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->variants as $var)
                            <tr>
                                <td>{{ $var->product->name }}</td>
                                <td>{{ strtoupper($var->dimension) }}</td>
                                <td>Rp{{ number_format($var->pivot->price, 2, ',', '.') }}</td>
                                <td>{{ $var->pivot->quantity }}</td>
                                <td>Rp{{ number_format($var->pivot->sub_total, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h6 class="text-right">Grand Total: Rp{{ number_format($transaction->grand_total, 2, ',', '.') }}</h6>
                <h6 class="text-right">Pajak (PPn 11%): Rp{{ number_format($transaction->tax, 2, ',', '.') }}</h6>
                @if (count($transaction->points_histories) == 0)
                    <h6 class="text-right">Perolehan Poin: 0</h6>
                    <h6 class="text-right">Penggunaan Poin: 0</h6>
                @else
                    @foreach ($transaction->points_histories as $point)
                        @if ($point->type == 'in')
                            <h6 class="text-right">Perolehan Poin: {{ $point->amount }}</h6>
                        @else
                            <h6 class="text-right">Penggunaan Poin: {{ $point->amount }}</h6>
                        @endif
                    @endforeach
                @endif
                <h6 class="text-right">Total Transaksi: Rp{{ number_format($transaction->total, 2, ',', '.') }}
                </h6>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
