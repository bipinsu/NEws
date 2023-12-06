<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="/css/navbar/new.css">

    <title>News</title>
</head>
<body class="nav_body">
    <!--==================== HEADER ====================-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="#" class="nav__logo">NEWS</a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="#" class="nav__link">Home</a>
                    </li>

                    <li class="nav__item">
                        <a href="#" class="nav__link">News</a>
                    </li>

                    <li class="nav__item">
                        <a href="#" class="nav__link">Economy</a>
                    </li>

                    <li class="nav__item">
                        <a href="#" class="nav__link">Market</a>
                    </li>

                    <li class="nav__item dropdown">
                        <a class="nav__link ">Company
                            <i class='bx bxs-down-arrow'></i>
                        </a>

                            <div class="dropdown-content">
                                <a href="#">Link 1</a>
                                <a href="#">Link 2</a>
                                <a href="#">Link 3</a>
                            </div>

                    </li>
                </ul>

                <!-- Close button -->
                <div class="nav__close" id="nav-close">
                    <i class="ri-close-line"></i>
                </div>
            </div>

            <div class="nav__actions">
                <!-- Search button -->
                <i class="ri-search-line nav__search" id="search-btn"></i>

                <!-- Login button -->
                @auth
                <a href="#" class="nav__link">{{ auth()->user()->name }}</a>

                @else
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="{{ route('login') }}" class="nav__link">Login</a>
                    </li>
                </ul>
                @endauth
                <!-- Toggle button -->
                <div class="nav__toggle" id="nav-toggle">
                    <i class="ri-menu-line"></i>
                </div>
            </div>
        </nav>
    </header>

    <!--==================== SEARCH ====================-->
    <div class="search" id="search">
        <form action="" class="search__form">
            <i class="ri-search-line search__icon"></i>
            <input type="search" placeholder="What are you looking for?" class="search__input">
        </form>
        <i class="ri-close-line search__close" id="search-close"></i>
    </div>


    <!--==================== MAIN ====================-->
    <section>
        <main>
            @yield('content')
        </main>
    </section>

    <!--=============== MAIN JS ===============-->
    <script src="js/new.js"></script>

</body>
</html>
