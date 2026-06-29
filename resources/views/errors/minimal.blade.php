<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets') }}/img/logo.png">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #f7f8fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .error-wrapper {
            text-align: center;
            padding: 40px 20px;
        }
        .error-code {
            font-size: 120px;
            font-weight: 700;
            color: #2c3e50;
            line-height: 1;
            margin-bottom: 10px;
        }
        .error-code .text-primary {
            color: #0d6efd !important;
        }
        .error-icon {
            font-size: 48px;
            color: #0d6efd;
            margin-bottom: 20px;
        }
        .error-message {
            font-size: 18px;
            color: #6c757d;
            margin-bottom: 30px;
            max-width: 450px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <div class="error-wrapper">
        <div class="error-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="error-code">@yield('code')</div>
        <div class="error-message">@yield('message')</div>
        <a href="{{ url('/') }}" class="btn btn-primary btn-lg px-4">
            <i class="fas fa-home me-2"></i> Back to Home
        </a>
    </div>
</body>
</html>
