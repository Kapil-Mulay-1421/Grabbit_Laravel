@extends('layouts.app')
@section('content')

<body>
    <div class="container" style="display: flex; justify-content: center;">
        <div class="vertical-strip" style="width: 67%; margin-top: 0;">
            <div class="user-box">
                <div class="photo-email-wrapper">
                    <div class="circle"><p style="height: 100%; display: flex; justify-content: center; align-items: center; margin-block-start: 0; margin-block-end: 0; color: gray; font-size: 40px;">{{ Auth::user()->name[0] }}</p></div>
                    <h2 style="margin-block-end:40px; font-weight: 100;">{{ Auth::user()->email }}</h2>
                </div>
            </div>
            <div class="user-info-nav">
                <a id="MyOrders" href="/profile/orders">My Orders</a>
                <a id="MyAddresses" href="/profile/addresses">My Addresses</a>
                <a id="MyWallet" href="/profile/wallet">My Wallet</a>
                <a id="MyWishlist" href="/profile/wishlist">My Wishlist</a>
                <a id="MySubscriptions" href="/profile/subscriptions">My Subscriptions</a>
                <a id="MyAccount" href="/profile/account">My Account</a>
            </div>
            <div class="content" id="content" style="width: 93%; margin-bottom: 30px;">
                @yield('substance')
            </div>
            <hr>
        </div>
</body>
@endsection