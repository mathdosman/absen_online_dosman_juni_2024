
<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Login e-absensi</title>
    <meta name="description" content="absensi gps dan foto">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="{{asset('assets/img/favicondosman.png')}}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/img/icon/192x192.png')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="manifest" href="__manifest.json">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
</head>

<body class="bg-white">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->


    <!-- App Capsule -->
    <div id="appCapsule" class="pt-0">

        <div class="login-form mt-1">
            <div class="section">
                <img src="{{asset('assets/img/logodosman.png')}}" alt="image" class="form-image" style="margin-top: 40px">
            </div>
            <div class="section mt-1">
                <h1>e-absensi</h1>
                <h4>SMA Negeri 1 Gianyar</h4>
            </div>
            <div class="section mt-1 mb-5">
                @php
                    $pesan_error = Session::get('error');
                @endphp
                @if(Session::get('error'))
                    <div class="alert alert-outline-warning">
                        {{$pesan_error}}
                    </div>
                @endif
                <form action="/proseslogin" method="POST">
                    @csrf
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="nisn" class="form-control" id="nisn" name="nisn" placeholder="NISN">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                            <i id="eye" class="fa fa-eye"></i>
                            {{-- <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i> --}}
                        </div>
                    </div>

                    <div class="form-button-group">
                        <button type="submit" class="btn btn-primary btn-block btn-lg" style="position: absolute">Log in</button>
                    </div>

                </form>
            </div>
        </div>


    </div>
    <!-- * App Capsule -->



    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="{{asset('assets/js/lib/jquery-3.4.1.min.js')}}"></script>
    <!-- Bootstrap-->
    <script src="{{asset('assets/js/lib/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/lib/bootstrap.min.js')}}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="{{asset('assets/js/plugins/owl-carousel/owl.carousel.min.js')}}"></script>
    <!-- jQuery Circle Progress -->
    <script src="{{asset('assets/js/plugins/jquery-circle-progress/circle-progress.min.js')}}"></script>
    <!-- Base Js File -->
    <script src="{{asset('assets/js/base.js')}}"></script>
    <script src="{{asset('login/app.js')}}"></script>


</body>

</html>
