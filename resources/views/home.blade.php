<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    {{-- Boxicon CSS --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/css/home.css">
</head>
<body>
    <header>
        <div class="login">
            <ul class="links">
                <a href="#" class="icon"><i class='bx bxl-facebook-circle'></i></a>
                <a href="#" class="icon"><i class='bx bxl-linkedin'></i></a>
                <form action="#" method="GET">
                    <div class="searchBox">

                        <input class="searchInput" type="text" name="" placeholder="Search something">
                        <button class="searchButton" href="#">
                            <i class='bx bx-search'></i>
                        </button>
                    </div>
                </form>
                    <li><a href="{{ route('login') }}">login</a></li>
                    <li><a href="{{ route('registration') }}">Signup</a></li>
                    <li><a href="#">Contact Us </a></li>
                    <li><a href="#"> Write for us</a></li>
            </ul>
        </div>
    </header>
    <nav>
        <div class="navigation">
            <div class="logo"><a href="/">NEWS</a></div>
            <ul class="links">
                <li><a href="/">Home</a></li>
                <li><a href="#">News</a></li>
                <li><a href="#">Economy</a></li>
                <li><a href="#">Market</a></li>
                <li><a href="#">Company</a></li>
            </ul>
        </div>
    </nav>
</body>
</html>
<main>
    @yield('content')
</main>
