<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .nav-link {
            color: white;
        }
        main {
            padding: 0;
        }
    </style>
</head>
<body>
    <div id="app">
        <header style="margin-bottom: 20px;">
        <nav class="navbar navbar-expand-md shadow-sm" style="background-color: #154051;">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a href="" class="nav-link">About Us</a> 
                        </li>
                        <li class="nav-item">
                            <a href="/customerSupport" class="nav-link">Customer Support</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/profile/orders">
                                        My Orders
                                    </a>
                                    <a class="dropdown-item" href="/profile/addresses">
                                        My Addresses
                                    </a>
                                    <a class="dropdown-item" href="/profile/wallet">
                                        My Wallet
                                    </a>
                                    <a class="dropdown-item" href="/profile/subscriptions">
                                        My Subscriptions
                                    </a>
                                    <a class="dropdown-item" href="/profile/account">
                                        My Account
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="grabbit-bar">

            <div class="hamburger-menu">
                <input type="image" src={{asset("images/Icons/hamburger_icon.png")}} onclick="toggleHamburgerMenu()" id="hamburger">
                <div class="hamburger-menu-links" id="hamburgerMenuLinks">
                    <a href="/profile/account">My Account</a>
                    <!--<a class="menu-item" href="expressLane.php">Express Lane</a>-->
                    <a href="/home">Home</a>
                    <!--<a class="menu-item" href="virtualStores.php">Virtual Stores</a>-->
                    <a class="menu-item" href="/deals">Deals</a>
                    <a class="menu-item" href="/categories">Product Range</a>
                    <a class="menu-item" href="/localproduce">Verified Local Produce</a>
                    <!--<a class="menu-item" href="more.html">More</a>-->
                    <a href="/customerSupport#locations">Locations</a>
                    <a href="/profile/wishlist">Wishlist</a>
                    <a href="/cart">Your Cart</a>
                    <a href="/customerSupport">Customer Support</a>
                    <a href="about.html">About Us</a>
                </div>
            </div>

            <div class="grabbit-bar-left">
                <div class="grabbit-bar-text-wrapper">
                    <h1><a href="/home" style="text-decoration: none; color: white;">Grabbit.</a></h1>
                </div>
            </div>

            <div class="grabbit-bar-mid">
                <div class="search-bar-wrapper" style="width:100%;">
                    <form action="/search" name="searchForm" style="width:100%;" method="POST">
                        @csrf
                        <input type="text" name="search" class="main-search-bar" placeholder="Surf products" autocomplete="off">
                    </form>
                </div>
            </div>

            <div class="grabbit-bar-right">
                <div class="icon-wrapper">
                    <div class="location-icon-wrapper">
                        <a href="/customerSupport#locations"><img src={{asset("images/Icons/location_icon.png")}} alt=""></a>
                    </div>
                    <div class="heart-icon-wrapper">
                        <a href="/profile/wishlist"><img src={{asset("images/Icons/heart_icon.png")}} alt=""></a>
                    </div>
                    <div class="cart-icon-wrapper">
                        <a href="/cart"><img src={{asset("images/Icons/shopping_cart.png")}} alt=""></a>
                    </div>
                </div>
            </div>
            </div>

            <div class="nav-bar">
            <div class="menu-wrapper">
                <a href="/home">Home</a>
                <!--<div class="dropdown-wrapper">
                    <a class="menu-item" href="">Express Lane</a>
                    <div class="dropdown-content">
                        <a href="expressLanePage.php?request=daily_dose">Daily Dose</a>
                        <a href="expressLanePage.php?request=weekly_wonders">Weekly Wonders</a>
                        <a href="expressLanePage.php?request=monthly_mania">Monthly Mania</a>
                    </div>
                </div> 
                <div class="dropdown-wrapper">
                    <a class="menu-item" href="virtualStores.php">Virtual Stores</a>
                    <div class="dropdown-content">
                        <a href="">Monginis</a>
                    </div>
                </div> -->
                <div class="dropdown-wrapper">
                    <a class="menu-item" href="/deals">Deals</a>
                    <div class="dropdown-content">
                    </div>
                </div>
                <div class="dropdown-wrapper">
                    <a class="menu-item" href="">Product Range</a>
                    <div class="dropdown-content">
                        <a href="/categories/vegetables">Vegetables</a>
                        <a href="/categories/coffee">Coffee</a>
                        <a href="/categories/fruit">Fruit</a>
                        <a href="/categories/beer">Beer</a>
                        <a href="/categories/soft%20drinks">Soft Drinks</a>
                        <a href="/categories/Meat%20%26%20Poultry">Meat & Poultry</a>
                        <a href="/categories/Fish%20%26%20Seafood">Fish & Seafood</a>
                        <a href="/categories/dairy%20%26%20eggs">Dairy & Eggs</a>
                        <a href="/categories/Cereal%20%26%20Snacks">Cereal & Snacks</a>
                    </div>
                </div>
                <div class="dropdown-wrapper">
                    <a class="menu-item" href="/localproduce">Verified Local Produce</a>
                    <div class="dropdown-content">
                    </div>
                </div>
                <!--<div class="dropdown-wrapper">
                    <a class="menu-item" href="">More</a>
                    <div class="dropdown-content">
                        <a href="classicCombos.php">Classic Combos</a>
                    </div>
                </div>-->
            </div>
        </div>
        </header>

        <main>
            @include('inc.messages')
            @yield('content')
        </main>

        <div class="footer-container">
            <div class="footer-starter"> <!-- starting footer block --> </div>
    
            <div class="footer-strip-top">
                <ul class="left-list">
                    <li><h1>Grabbit</h1></li>
                    <li><h2>Need Help?</h2></li>
                    <li><p>​Visit our Customer Support <br> for assistance or call us at</p></li>
                    <li><h2>123-456-7890</h2></li>
                    <li>
                        <div class="social-bar">
                            <a href=""><img src={{asset("images/Icons/facebook_icon.png")}} alt=""></a>
                            <a href=""><img src={{asset("images/Icons/instagram_icon.png")}} alt=""></a>
                            <a href=""><img src={{asset("images/Icons/twitter_icon.png")}} alt=""></a>
                            <a href=""><img src={{asset("images/Icons/youtube_icon.png")}} alt=""></a>
                        </div>
                    </li>
                </ul>
        
                <ul class="footer-menu">
                    <li><h2>Menu</h2></li>
                    <li><a href="/home">Home</a></li>
                    <li><a href="">Express Lane</a></li>
                    <li><a href="">Virtual Stores</a></li>
                    <li><a href="/deals">Deals</a></li>
                    <li><a href="/localproduce">Verified Local Produce</a></li>
                    <li><a href="classicCombos.php">Classic Combos</a></li>
                    <li><a href="/categories/=Home & Kitchen">Home & Kitchen</a></li>
                    <li><a href="/categories/Cleaning Supplies">Cleaning Supplies</a></li>
                    <li><a href="/profile/orders">My Orders</a></li>
                </ul>
        
                <ul>
                    <li><h2>Categories</h2></li>
                    <li><a href="/categories/Vegetables">Vegetables</a></li>
                    <li><a href="/categories/Bakery">Bakery</a> </li>
                    <li><a href="/categories/Wine">Wine</a> </li>
                    <li><a href="/categories/Dairy & Eggs">Dairy & Eggs</a> </li>
                    <li><a href="/categories/Meat & Poultry">Meat & Poultry</a> </li>
                    <li><a href="/categories/Soft Drinks">Soft Drinks</a> </li>
                    <li><a href="/categories/Cleaning Supplies">Cleaning Supplies</a> </li>
                    <li><a href="/categories/Cereal & Snacks">Cereal & Snacks</a> </li>
                </ul>
        
                <ul>
                    <li><h2>Info</h2></li>
                    <li><a href="/faq">FAQ</a></li>
                    <li><a href="/about">About Us</a></li> 
                    <li><a href="/customerSupport">Customer Support</a></li> 
                    <li><a href="/customerSupport#locations">Locations</a></li> 
                </ul>
        
                <ul>
                    <li><h2>My Choice</h2></li>
                    <li><a href="/profile/wishlist">Wishlist</a></li>
                    <li><a href="/profile/orders">Orders</a></li>
                </ul>
            </div>
    
            <div class="footer-strip-bottom">
                <div class="policy-display-wrapper">
                    <a href="/cancellation-refund-policy">Shipping & Returns</a>
                    <a href="/terms-and-conditions">Terms & Conditions</a>
                    <a href="/privacy-policy">Privacy Policy</a>
                </div>
    
                <h2 style="margin-block-start: 0; margin-block-end: 1.2em;">We Accept the Following Payment Methods</h2>
    
                <div class="payment-methods-images-wrapper">
                    <img src={{asset("images/american-express-payment.jpg")}} alt="">
                    <img src={{asset("Images/paypal.jpg")}} alt="">
                    <img src={{asset("Images/visa-payment.png")}} alt="">
                    <img src={{asset("images/mastercard-icon.jpg")}} alt="">
                    <img src={{asset("images/american-express-payment.jpg")}} alt="">
                    <img src={{asset("Images/visa-payment.png")}} alt="">
                    <img src={{asset("Images/paypal.jpg")}} alt="">
                    <img src={{asset("images/mastercard-icon.jpg")}} alt="">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
