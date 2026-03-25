<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Register - AMS Admin</title>
  @php
    $favicon = \App\Helpers\SettingHelper::get('site_favicon');
  @endphp
  @if($favicon)
  <link href="{{ asset('storage/' . $favicon) }}" rel="icon" type="image/x-icon">
  <link href="{{ asset('storage/' . $favicon) }}" rel="apple-touch-icon">
  @else
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon" type="image/x-icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
  @endif
  <link href="{{ asset('manifest.json') }}" rel="manifest">
  <meta name="theme-color" content="#0d6efd">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: "roboto", sans-serif;
    }

    .register-container {
      background: white;
      border-radius: 8px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 400px;
      padding: 40px;
    }

    .register-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .register-header h1 {
      font-size: 28px;
      font-weight: 700;
      color: #0d6efd;
      margin: 0;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      font-weight: 600;
      margin-bottom: 8px;
      display: block;
      color: #333;
    }

    .form-control {
      border: 1px solid #ddd;
      padding: 10px 12px;
      border-radius: 4px;
      font-size: 14px;
      transition: all 0.3s;
    }

    .form-control:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .btn-register {
      width: 100%;
      padding: 10px;
      background-color: #0d6efd;
      color: white;
      border: none;
      border-radius: 4px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      font-size: 14px;
    }

    .btn-register:hover {
      background-color: #0b5ed7;
    }

    .register-footer {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
      color: #666;
    }

    .register-footer a {
      color: #0d6efd;
      text-decoration: none;
    }

    .register-footer a:hover {
      text-decoration: underline;
    }

    .alert {
      border-radius: 4px;
      padding: 12px 15px;
      margin-bottom: 20px;
    }

    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    .invalid-feedback {
      display: block;
      color: #dc3545;
      font-size: 12px;
      margin-top: 5px;
    }

    .is-invalid {
      border-color: #dc3545;
    }
  </style>
</head>

<body>

  <div class="register-container">
    <div class="register-header">
      <h1>
        <i class="bi bi-speedometer2"></i> AMS Admin
      </h1>
      <p style="color: #666; margin-top: 10px;">Create Your Account</p>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
      @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
      @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}">
      @csrf

      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
        @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
        @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>

      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
      </div>

      <button type="submit" class="btn-register">Register</button>
    </form>

    <div class="register-footer">
      Already have an account? <a href="{{ route('login') }}">Login here</a>
    </div>
  </div>

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
