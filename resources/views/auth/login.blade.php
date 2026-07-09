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
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #fef9f8; display: flex; align-items: center; justify-content: center; min-height: 100vh; font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif; }
        .auth-card { background: #fff; border-radius: 12px; box-shadow: 0 1px 8px rgba(233,65,52,0.06), 0 4px 12px rgba(0,0,0,0.04); border: 1px solid rgba(233,65,52,0.07); padding: 40px; width: 100%; max-width: 420px; margin: 20px; }
        .auth-logo { display: block; margin: 0 auto 20px; max-width: 140px; height: auto; }
        .auth-card h1 { color: #e94134; font-size: 22px; font-weight: 700; text-align: center; margin-bottom: 5px; }
        .auth-card .subtitle { text-align: center; color: #888; font-size: 13px; margin-bottom: 25px; }
        .auth-card .form-label { font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px; }
        .auth-card .form-control { border-radius: 6px; border: 1.5px solid #dee2e6; padding: 10px 14px; font-size: 13px; transition: border-color .15s, box-shadow .15s; }
        .auth-card .form-control:focus { border-color: #e94134; box-shadow: 0 0 0 0.2rem rgba(233,65,52,0.15); }
        .auth-card .pass-group { position: relative; }
        .auth-card .toggle-password { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #999; cursor: pointer; z-index: 2; }
        .auth-card .btn-primary { background: #e94134; border-color: #e94134; border-radius: 6px; padding: 10px; font-size: 14px; font-weight: 600; transition: background .15s; }
        .auth-card .btn-primary:hover { background: #d0352a; border-color: #d0352a; }
        .alert { border-radius: 6px; font-size: 13px; }
    </style>
</head>
<body>
    <div class="auth-card">
        <img class="auth-logo" src="{{asset('assets')}}/img/logo.png" alt="Logo">
        <h1>Login</h1>
        <p class="subtitle">Access to our dashboard</p>
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
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="pass-group">
                    <input type="password" name="password" class="form-control pass-input">
                    <span class="fas fa-eye toggle-password"></span>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="cb1">
                    <label class="form-check-label" for="cb1">Remember me</label>
                </div>
            </div>
            <button class="btn btn-lg btn-primary w-100" type="submit">Login</button>
        </form>
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
