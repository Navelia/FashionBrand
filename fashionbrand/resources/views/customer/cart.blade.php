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
                        <a class="nav-link" href="{{ route('customer.profile') }}">Customer: {{ Auth::user()->name }}</a>
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
        @if (session('cart'))
            <form action="{{ route('transaction.checkout') }}" method="POST">
                <div class="row mb-4">
                    <div class="col-12">
                        @csrf
                        <h3>Poin dimiliki: {{ Auth::user()->customer->points }}</h3>
                        @if (Auth::user()->customer->points > 0)
                            <h6>Apakah anda ingin menukar poin? (1 Poin = Rp1.000)</h6>
                            <p class="mb-0">(Apabila transaksi < Rp100.000 maka poin otomatis tidak dapat digunakan.)</p>
                                    <input type="radio" name="tukar" value="ya">Ya&nbsp;
                                    <input type="radio" name="tukar" value="tidak" checked>Tidak
                        @endif
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total=0;?>
                                @foreach (session('cart') as $id => $details)
                                    <tr>
                                        <?php $total+= ($details['price'] * $details['quantity']);?>
                                        <td>{{ $details['name'] }} ({{ strtoupper($details['dimension']) }})</td>
                                        <td>Rp{{ number_format($details['price'], 2, ',', '.') }}</td>
                                        <td>{{ $details['quantity'] }}</td>
                                        <td>Rp{{ number_format($details['price'] * $details['quantity'], 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row mt-2">
                            <div class="col-6">
                                <p>Total adalah sebelum dikurangkan dengan poin (apabila terdapat penukaran)</p>
                                <p class="mb-0">Grand Total: <strong>Rp{{ number_format($total,2,',','.') }}</strong></p>
                                <p class="mb-0">Pajak: <strong>Rp{{ number_format($total*0.11,2,',','.') }}</strong></p>
                                <p>Total: <strong>Rp{{ number_format($total*1.11,2,',','.') }}</strong></p>
                            </div>
                            <div class="col-6 text-right">
                                <button type="submit" class="btn btn-info">Checkout</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <div class="row mb-4">
                <h2>Tidak ada Barang di Cart</h2>
            </div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
