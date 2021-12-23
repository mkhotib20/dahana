<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Aplikasi Perjalanan Dahana </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('public/icons/') }}/favicon.ico">

    <!-- App css -->
    <link href="{{ asset('public/template/') }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/template/') }}/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/template/') }}/css/app.min.css" rel="stylesheet" type="text/css" />

</head>

<body class="authentication-bg">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card">

                        <div class="card-body p-4">
                            <center><img src="{{ asset('public/template/') }}/assets/images/logo.png" alt=""
                                    height="70"></center>
                            @yield('content')
                        </div> <!-- end card-body -->
                    </div>

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->


    <!-- App js -->
    <script src="{{ asset('public/template/') }}/js/vendor.min.js"></script>
    <script src="{{ asset('public/template/') }}/js/app.js"></script>
</body>

</html>
