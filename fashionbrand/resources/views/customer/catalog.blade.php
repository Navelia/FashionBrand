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
        <div class="row mb-4">
            @foreach ($data as $d)
                <div class="col-md-3 mb-5">
                    <div class="card">
                        <img src="{{ $d->image_url }}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{ $d->name }}</h5>
                            <p class="card-text">Rp{{ number_format($d->price, 2, ',', '.') }}</p>
                            <form action="{{ route('transaction.addtocart') }}" method="post">
                                @csrf
                                <select name="variant" id="cbVariants" class="form-control">
                                    @foreach ($d->variants as $var)
                                        <option value="{{ $var->id }}">{{ strtoupper($var->dimension) }}</option>
                                    @endforeach
                                </select>
                        </div>
                        <input type="hidden" name="idProduk" value="{{ $d->id }}">
                        <button type="submit" class="btn btn-primary btn-bottom-right"><i
                                class="fas fa-shopping-cart mr-2"></i>Add to
                            Cart</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
