<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
     {{-- Boxicon CSS --}}
     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
     {{-- CSS --}}
     <link rel="stylesheet" href="/css/login/login.css">
     {{-- JS --}}
     <script defer  src="/js/login/login.js"></script>
</head>
<body>
    <section class="container forms">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="form login">
        <div class="form-content">
            <header>Login</header>
            <form action="/login" method="POST">
                @csrf
                {{-- email --}}
                <div class="field input-field">
                    <input type="email" placeholder="Email" name="email" class="email" required>
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- password --}}
                <div class="field input-field">
                    <input type="password" placeholder="Password" name="password" class="password" required>
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <i class='bx bx-hide eye-icon'></i>
                </div>
                {{-- forgot password --}}
                <div class="form-link">
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>
                {{-- button --}}
                <div class="field button-field">
                    <button type="submit">Login</button>
                </div>
            </form>
    
            <div class="form-link">
                <span>Dont have an account? <a href="/registration" class="link signup-link">Signup</a> </span>
            </div>
        </div>
    
        <div class="line"></div>
    
        <div class="media-options">
            <a href="#" class="field facebook">
                <i class='bx bxl-facebook facebook-icon'></i>
                <span>Login with Facebook</span>
            </a>
        </div>
        <div class="media-options">
            <a href="#" class="field google">
                <img src="logo/google.png" alt="" class="google-img">
                <span>Login with Gmail</span>
            </a>
        </div>
    </div>
    
    </section>
</body>
</html>