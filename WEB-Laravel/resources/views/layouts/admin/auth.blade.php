    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('admin_resources/assets/images/icons/bank-sampah.png') }}">
        <title>BerSinar-App</title>
        <!-- Global stylesheets -->
        <link href="admin_resources/assets/fonts/inter/inter.css" rel="stylesheet" type="text/css">
        <link href="admin_resources/assets/icons/phosphor/styles.min.css" rel="stylesheet" type="text/css">
        <link href="{{ asset('admin_resources/assets_layout/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet"
            type="text/css">
        <!-- /global stylesheets -->

        <!-- Core JS files -->
        <script src="admin_resources/assets/demo/demo_configurator.js"></script>
        <script src="admin_resources/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
        <!-- /core JS files -->

        <!-- Theme JS files -->
        <script src="{{ asset('admin_resources/assets_layout/js/app.js') }}"></script>
        <!-- /theme JS files -->
    </head>

    <style>
        html. body {
            height: 100%;
            margin: 0
        }

        .full-height {
            height: 100%;
        }

        .center-vertically-horizontally {
            display: flex;
            align-items: center;
            /* Aligns vertically */
            justify-content: center;
            /* Aligns horizontally */
            min-height: 100vh;
            /* Fallback for browsers that do not support vh units */
        }
    </style>

    <body>
        <div class="container full-height">
            <div class="row center-vertically-horizontally">
                <div class="col-md-4 card">
                    <div class="card-header">
                        <h1 class="text-center mb-0">Login</h1>
                    </div>
                    <div class="card-body">
                        <form action="#">
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Masukkan username Anda">
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                <a href="{{ route('dashboard.index') }}" class="btn btn-primary ms-3">
                                    Login <i class="ph-paper-plane-tilt ms-2"></i>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
