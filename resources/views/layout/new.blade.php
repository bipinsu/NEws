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
        <nav class="nav ">
            <a href="#" class="nav__logo">NEWS</a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    {{-- <li class="nav__item">
                        <a href="#" class="nav__link">Home</a>
                    </li> --}}

                    <li class="nav__item dropdown">
                        <a  href="#" class="nav__link">News
                            <i class='bx bxs-down-arrow'></i>
                        </a>
                            <div class="dropdown-content">
                                <a href="#">All News</a>
                                <a href="#">Anouncment</a>
                            </div>
                    </li>

                    <li class="nav__item dropdown">
                        <a href="#" class="nav__link">Economy
                            <i class='bx bxs-down-arrow'></i>
                        </a>
                        <div class="dropdown-content">
                            <a href="#">Inflation</a>
                            <a href="#">Gold & Silver Price</a>
                            <a href="#">GDP & Market Cap</a>
                            <a href="#">GDP Growth & NEPSE</a>
                            <a href="#">Weekly Deposite & Lending</a>
                            <a href="#">Govetment Revenue & Expenditure</a>
                            <a href="#">Capital Expenditure</a>
                            <a href="#">Remitance</a>
                            <a href="#">BFIs Deposite/Lending Growth </a>
                            <a href="#">Short-Term Interest Rates</a>
                            <a href="#">Bugdet Surplus/Deficit Status</a>

                        </div>
                    </li>
                    <li class="nav__item dropdown">
                        <a href="#" class="nav__link">Market
                            <i class='bx bxs-down-arrow'></i>
                        </a>
                        <div class="dropdown-content">
                            <a href="#">Market Overview</a>
                            <a href="#">Live Trading</a>
                            <a href="#">Stock Heat Map</a>
                            <a href="#">Today's Share Price</a>
                            <a href="#">FloorSheet</a>
                            <a href="#">AGM/SGM</a>
                            <a href="#">PRoposed Dividend</a>
                            <a href="#">Sectorwise Share Price</a>
                            <a href="#">INdicies / Sub-indices</a>
                            <a href="#">Datewise Indices</a>
                            <a href="#">Top Brokers</a>
                            <a href="#">NEPSE Candlestick Chart</a>
                            <a href="#">Index History Data</a>
                        </div>
                    </li>

                    <li class="nav__item dropdown">
                        <a href="#" class="nav__link">IPO/FPO
                            <i class='bx bxs-down-arrow'></i>
                        </a>
                        <div class="dropdown-content">
                            <a href="#">Check IPO/FPO Result</a>
                            <a href="#">IPO/FPO News</a>
                            <a href="#">IPO/FPO Allotment News</a>
                        </div>
                    </li>



                    <li class="nav__item dropdown">
                        <a class="nav__link ">Company
                            <i class='bx bxs-down-arrow'></i>
                        </a>

                            <div class="dropdown-content">
                                <a href="#">Listed Companies</a>
                                <a href="#">Mutual Funds & NAVs</a>
                                <a href="#">MErged Companies</a>
                                <a href="#">Merged & Acquisitions</a>
                                <a href="#">Trading Suspended Companies</a>
                                <a href="#">Name Changed Companies</a>
                            </div>

                    </li>
                    <li class="nav__item dropdown">
                        <a class="nav__link ">Investment
                            <i class='bx bxs-down-arrow'></i>
                        </a>

                            <div class="dropdown-content">
                                <a href="#">Investment Overview</a>
                                <a href="#">Existing Issues</a>
                                <a href="#">Upcoming Issues</a>
                                <a href="#">Auction</a>
                            </div>
                    </li>
                    <li class="nav__item dropdown">
                        <a class="nav__link ">Training
                            <i class='bx bxs-down-arrow'></i>
                        </a>

                            <div class="dropdown-content">
                                <a href="#">Indepth Training</a>
                                <a href="#">Technical Analysis</a>
                                <a href="#">Registration Form</a>
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
