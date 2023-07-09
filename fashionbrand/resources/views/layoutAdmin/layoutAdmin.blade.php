<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.ico') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Fashion Brand</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Animation library for notifications   -->
    <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet" />

    <!--  Light Bootstrap Table core CSS    -->
    <link href="{{ asset('assets/css/light-bootstrap-dashboard.css?v=1.4.0') }}" rel="stylesheet" />


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{ asset('assets/css/demo.css') }}" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="{{ asset('assets/css/pe-icon-7-stroke.css') }}" rel="stylesheet" />

</head>

<body>

    <div class="wrapper">
        <div class="sidebar" data-color="purple" data-image="{{ asset('assets/img/sidebar-5.jpg') }}">

            <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="http://www.creative-tim.com" class="simple-text">
                        Fashion Brand
                    </a>
                </div>

                <ul class="nav">
                    <li class="{{ request()->is('admin/category') ? ' active' : '' }}">
                        <a href="{{ route('category.index') }}">
                            <i class="pe-7s-graph"></i>
                            <p>Categories</p>
                        </a>
                    </li>
                    <li class="{{ request()->is('admin/type') ? ' active' : '' }}">
                        <a href="{{ route('type.index') }}">
                            <i class="pe-7s-user"></i>
                            <p>Types</p>
                        </a>
                    </li>
                    <li class="{{ request()->is('admin/product') ? ' active' : '' }}">
                        <a href="{{ route('product.index') }}">
                            <i class="pe-7s-note2"></i>
                            <p>Products</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('transaction.index') }}">
                            <i class="pe-7s-news-paper"></i>
                            <p>Transactions</p>
                        </a>
                    </li>
                    <li class="active-pro">
                        <a href="upgrade.html">
                            <i class="pe-7s-rocket"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-panel">
            <div class="content">
                @yield('content')
            </div>


            <footer class="footer">
                <div class="container-fluid">
                    <p class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script> Ncent & Gede, made with
                        love for an A score
                    </p>
                </div>
            </footer>

        </div>
    </div>


</body>

<!--   Core JS Files   -->
<script src="{{ asset('assets/js/jquery.3.2.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>

<!--  Charts Plugin -->
<script src="{{ asset('assets/js/chartist.min.js') }}"></script>

<!--  Notifications Plugin    -->
<script src="{{ asset('assets/js/bootstrap-notify.js') }}"></script>


<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="{{ asset('assets/js/light-bootstrap-dashboard.js?v=1.4.0') }}"></script>

<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
<script src="{{ asset('assets/js/demo.js') }}"></script>

@yield('javascript')

</html>
