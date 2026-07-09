<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inoodex Inventory - Login</title>
    <link rel="shortcut icon" href="{{asset('assets')}}/img/logo.png">
    <link rel="stylesheet" href="{{asset('assets')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('assets')}}/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{asset('assets')}}/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="{{asset('assets')}}/css/style.css">
    <style>
        body.login-body { background: #fef9f8; display: flex; align-items: center; min-height: 100vh; }
        .login-wrapper { width: 100%; }
        .loginbox { max-width: 420px; margin: 0 auto; }
        .login-right { background: #fff; border-radius: 12px; box-shadow: 0 1px 8px rgba(233,65,52,0.06), 0 1px 2px rgba(0,0,0,0.04); border: 1px solid rgba(233,65,52,0.07); padding: 40px; }
        .login-right h1 { color: #e94134; font-size: 22px; font-weight: 700; text-align: center; margin-bottom: 5px; }
        .account-subtitle { text-align: center; color: #888; font-size: 13px; margin-bottom: 25px; }
        .login-right .form-control { border-radius: 6px; border: 1.5px solid #dee2e6; padding: 10px 14px; font-size: 13px; }
        .login-right .form-control:focus { border-color: #e94134; box-shadow: 0 0 0 0.2rem rgba(233,65,52,0.15); }
        .login-right .form-control-label { font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px; }
        .login-right .btn-primary { background: #e94134; border-color: #e94134; border-radius: 6px; padding: 10px; font-size: 14px; font-weight: 600; }
        .login-right .btn-primary:hover { background: #d0352a; border-color: #d0352a; }
        .login-right .pass-group { position: relative; }
        .login-right .toggle-password { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #999; cursor: pointer; }
        .logo-color { display: block; margin: 0 auto 20px; max-width: 160px; }
        .alert { border-radius: 6px; font-size: 13px; }
    </style>
</head>
<body class="login-body">
    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <img class="img-fluid logo-dark mb-2 logo-color" src="{{asset('assets')}}/img/logo.png" alt="Logo">
                <div class="loginbox">
                    <div class="login-right">
                        <h1>Login</h1>
                        <p class="account-subtitle">Access to our dashboard</p>
                        <form method="post" action="{{ route('login') }}">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <p class="mb-0">{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-control-label">Email Address</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-control-label">Password</label>
                                <div class="pass-group">
                                    <input type="password" name="password" class="form-control pass-input">
                                    <span class="fas fa-eye toggle-password"></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="cb1">
                                            <label class="form-check-label" for="cb1">Remember me</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-lg btn-primary w-100" type="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets')}}/js/jquery-3.7.1.min.js"></script>
    <script src="{{asset('assets')}}/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".toggle-password").click(function(){
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $(".pass-input");
                input.attr("type", input.attr("type") === "password" ? "text" : "password");
            });
        });
    </script>
</body>
</html>
