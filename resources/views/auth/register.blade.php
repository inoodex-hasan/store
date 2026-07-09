<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bashundhara Foundation - Register</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('frontend') }}/images/webLogo/Logo/Bashundhara-Foundation-LOGO-MARK.png" />
    <style>
        body.login-page { background: #fef9f8; display: flex; align-items: center; min-height: 100vh; font-family: 'Poppins', sans-serif; }
        .login-box-container { background: #fff; border-radius: 12px; box-shadow: 0 1px 8px rgba(233,65,52,0.06); border: 1px solid rgba(233,65,52,0.07); padding: 30px; }
        .authent-logo { text-align: center; margin-bottom: 15px; }
        .authent-logo img { max-width: 150px; }
        .authent-text { text-align: center; margin-bottom: 20px; }
        .authent-text p { color: #888; font-size: 13px; }
        .form-floating > .form-control { border-radius: 6px; border: 1.5px solid #dee2e6; }
        .form-floating > .form-control:focus { border-color: #e94134; box-shadow: 0 0 0 0.2rem rgba(233,65,52,0.15); }
        .btn-primary { background: #e94134; border-color: #e94134; border-radius: 6px; padding: 10px; font-weight: 600; }
        .btn-primary:hover { background: #d0352a; border-color: #d0352a; }
        .authent-login { text-align: center; margin-top: 15px; font-size: 13px; }
        .authent-login a { color: #e94134; font-weight: 600; text-decoration: none; }
        .alert { border-radius: 6px; font-size: 13px; }
    </style>
</head>
<body class="login-page">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-12 col-lg-4">
                <div class="card login-box-container">
                    <div class="card-body">
                        <div class="authent-logo">
                            <img width="150" src="{{ asset('frontend') }}/images/webLogo/Logo/Bashundhara-Foundation.png" alt="" />
                        </div>
                        <div class="authent-text">
                            <p>Enter your details to create your account</p>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    <label for="floatingInput">Fullname</label>
                                </div>
                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    <label for="floatingInput">Email address</label>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    <label for="floatingPassword">Password</label>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    <label for="floatingPassword">Confirm Password</label>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary m-b-xs">Register</button>
                            </div>
                        </form>
                        <div class="authent-login">
                            <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
