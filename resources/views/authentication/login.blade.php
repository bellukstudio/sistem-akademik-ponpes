<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Si PMM | Log in</title>
      <link rel="shortcut icon" href="{{ asset('template/img/logo.png') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('template/img/logo.png') }}" alt=" Logo" class="brand-image img-circle elevation-3"
                style="opacity: 0.8" />
            <h5 class="mt-3"><b>Si</b>PMM</h5>
        </div>
        @include('components.alert')
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="{{ route('authenticate') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" value="{{ old('email') ?? 'sispendikapps@gmail.com' }}"
                            name="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3" id="show_hide_password">
                        <input type="password" class="form-control" id="password" placeholder="Password"
                            name="password" value="{{ old('password') ?? 'adminponpes' }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <a href="" style="text-decoration: none;color: gray;" id="toggle"><span
                                        class="fas fa-eye" aria-hidden="true"></span></a>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </form>


                <div class="d-flex justify-content-center mt-3">
                    <a href="{{ route('activate') }}">Aktivasi Akun</a>
                </div>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
    <!-- /.login-box -->
    <script>
        $(document).ready(function() {
            $("#show_hide_password #toggle").click(function() {
                event.preventDefault();
                if ($('#show_hide_password #password').attr("type") == "text") {
                    $('#show_hide_password #password').attr('type', 'password');
                    $('#show_hide_password span').removeClass("fas fa-eye");
                    $('#show_hide_password span').addClass("fas fa-eye-slash");
                } else if ($('#show_hide_password #password').attr("type") == "password") {
                    $('#show_hide_password #password').attr('type', 'text');
                    $('#show_hide_password span').removeClass("fas fa-eye-slash");
                    $('#show_hide_password span').addClass("fas fa-eye");
                }
            });
        });
    </script>
</body>

</html>
