@extends('layouts.app')

@section('content')

<head>
    @vite(['resources/js/home.js'])
</head>

<body>
    <div class="outer-container">
        <div class="content">
            <div class="bread-area">
                <div class="bread-area-text-container">
                    <div class="bread-area-small-text">
                        <h3>Easy, Fresh & Convenient</h3>
                    </div>
                    <div class="bread-area-large-text">
                        <h1>Stock Up on <br> Daily Essentials</h1>
                    </div>
                    <div class="bread-area-medium-text">
                        <h1>Save Big on Your <br> Favourite Brands</h1>
                    </div>
                </div>
                <div class="shop-now-dark">
                        <button onclick="location.href = '/categories/bakery'">
                            Shop Now
                        </button>
                </div>
            </div>

            <div class="features-strip">
                <div class="feature">
                    <div class="feature-icon-wrapper">
                        <img src="images/Icons/truck_icon.png" alt="">
                    </div>
                    <div class="feature-text-wrapper">
                        <h2>Free Delivery</h2>
                        <p>To Your Door</p>
                    </div>
                </div>
                <div class="feature">
                    <div class="feature-icon-wrapper">
                        <img src="images/Icons/basket_icon.png" alt="">
                    </div>
                    <div class="feature-text-wrapper">
                        <h2>Local Pickup</h2>
                        <p>Check Out <a href="locations.html">Locaitons</a></p>
                    </div>
                </div>
                <div class="feature">
                    <div class="feature-icon-wrapper">
                        <img src="images/Icons/headset_icon.png" alt="">
                    </div>
                    <div class="feature-text-wrapper">
                        <h2>Available for You</h2>
                        <p>Online Support 24/7</p>
                    </div>
                </div>
                <div class="feature">
                    <div class="feature-icon-wrapper">
                        <img src="images/Icons/crypto_icon.png" alt="">
                    </div>
                    <div class="feature-text-wrapper">
                        <h2>Crypto</h2>
                        <p>Towards Digital India</p>
                    </div>
                </div>
            </div>

            <div class="showcase-strip">
                <h1>Best Deals</h1>
                <div class="panel-wrapper">
                    <div class="items-wrapper">
                        @foreach($deals as $product)
                            <div class="item-wrapper" style="position: relative;">
                                @if($product->localproduce)  <p style="position: absolute; background-color: #2B80A1; margin: 0; padding: 8px; color: white; font-size: 13px">Local Produce</p> @endif
                                <a href="/products/{{$product->product_name}}">
                                    <img src= {{$product->product_image}}  alt="">
                                </a>
                                <div class="item-mid">
                                    <a href="/products/{{$product->product_name}}">
                                        <p style="margin-top: 10px;"> {{$product->product_name}} </p>
                                        <p> $ {{ $product->list_price }} </p>
                                    </a>
                                </div>
                                <div class="item-lower">
                                    {!! Form::open(['action' => ['App\Http\Controllers\CartItemController@add'], 'method' => 'post']) !!}
                                        {{Form::hidden('_method', 'POST')}}  
                                        {{Form::hidden('productId', $product->product_id)}}   
                                        {{Form::hidden('storeId', $product->store_id)}}                  
                                        {{Form::label('quantity', 'Quantity')}}
                                        {{Form::number('quantity', 1)}}
                                        {{Form::submit('Add to Cart', ['style' => 'padding:8px 2.4em', 'name' => 'addToCart'])}}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="shop-now-light" style="display: flex; justify-content: center; margin-top: 45px; margin-bottom: 45px;">
                    <button onclick="window.location.href='/deals'">
                        Shop Best Deals
                    </button>
                </div>
            </div>

            <div class="advertisement-strip">
                <div class="advertisement-leftt" style="background-image: url(images/home_page_wine.jpg);">
                    <div class="add-text-box">
                        <h3>It's Wine O'Clock!</h3>
                        <h2>Great Deals on</h2>
                        <h1>Selected Wines</h1>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Modi architecto odit praesentium.</p>
                    </div>
                    <div class="shop-now-dark" style="padding-left: 10%; padding-top: 0px;">
                        <button onclick="window.location.href='/categories/wine'">
                            Shop Now
                        </button>
                    </div>
                </div>
                <div class="advertisement-rightt" style="background-image: url(images/home_page_cheese.jpg);">
                    <div class="add-text-box">
                        <h3>Deal of the Week</h3>
                        <h1>40%</h1>
                        <h2>Cleaning Supplies</h2>
                    </div>
                    <div class="shop-now-dark" style="padding-left: 10%; padding-top: 0px;">
                        <button onclick="window.location.href='/categories/Cleaning Supplies'">
                            Shop Now
                        </button>
                    </div>
                </div>
            </div>

            <div class="most-popular-categories-strip" style="margin-bottom: 100px;">
                <h1 style="margin-left: 10%;">Most Popular Categories</h1>
                <div class="categories-grid">
                    <div class="category-wrapper">
                        <img src="images/vegetables.png" alt="" style="width: 75%; height: auto; cursor: pointer;" onclick="window.location.href='/categories/vegetables'">
                        <a href="/categories/vegetables">Vegetables</a>
                    </div>
                    <div class="category-wrapper">
                        <img src="images/bakery.png" alt="" style="width: 75%; height: auto; cursor: pointer;" onclick="window.location.href='/categories/bakery'" >
                        <a href="/categories/bakery">Bakery</a>
                    </div>
                    <div class="category-wrapper">
                        <img src="images/wine.png" alt="" style="width: 65%; height: auto; cursor: pointer;" onclick="window.location.href='/categories/wine'">
                        <a href="/categories/wine">Wine</a>
                    </div>
                    <div class="category-wrapper">
                        <img src="images/dairy.png" alt="" style="width: 75%; height: auto; cursor: pointer;" onclick="window.location.href='/categories/dairy %26 eggs'">
                        <a href="/categories/dairy %26 eggs">Dairy & Eggs</a>
                    </div>
                    <div class="category-wrapper">
                        <img src="images/meat.png" alt="" style="width: 75%; height: auto; cursor: pointer;" onclick="window.location.href='/categories/meat %26 poultry'">
                        <a href="/categories/meat %26 poultry">Meat & Poultry</a>
                    </div>
                    <div class="category-wrapper">
                        <img src="images/soft_drinks.png" alt="" style="width: 60%; height: auto; cursor: pointer;" onclick="window.location.href='/categories/soft drinks'">
                        <a href="/categories/soft drinks">Soft Drinks</a>
                    </div>
                    <div class="category-wrapper">
                        <img src="images/cleaning_supplies.png" alt="" style="width: 70%; height: auto; cursor: pointer;" onclick="window.location.href='/categories/cleaning supplies'">
                        <a href="/categories/cleaning supplies">Cleaning Supplies</a>
                    </div>
                    <div class="category-wrapper">
                        <img src="images/cereal_and_snacks.png" alt="" style="width: 70%; height: 50%; cursor: pointer;" onclick="window.location.href='/categories/cereal %26 snacks'">
                        <a href="/categories/cereal %26 snacks">Cereal & Snacks</a>
                    </div>
                </div>
            </div>

            <div class="showcase-strip">
                <h1>Start Your Cart</h1>
                <div class="panel-wrapper">
                    <div class="items-wrapper">
                        @foreach($startYourCartProducts as $product)
                            <div class="item-wrapper" style="position: relative;">
                                @if($product->localproduce == 1)  <p style="position: absolute; background-color: #2B80A1; margin: 0; padding: 8px; color: white; font-size: 13px">Local Produce</p> @endif
                                <a href="/products/{{$product->product_name}}">
                                    <img src= {{$product->product_image}}  alt="">
                                </a>
                                <div class="item-mid">
                                    <a href="/products/{{$product->product_name}}">
                                        <p style="margin-top: 10px;"> {{$product->product_name}} </p>
                                        <p> $ {{ $product->list_price }} </p>
                                    </a>
                                </div>
                                <div class="item-lower">
                                    {!! Form::open(['action' => ['App\Http\Controllers\CartItemController@add'], 'method' => 'post']) !!}
                                        {{Form::hidden('_method', 'POST')}}  
                                        {{Form::hidden('productId', $product->product_id)}}   
                                        {{Form::hidden('storeId', $product->store_id)}}                  
                                        {{Form::label('quantity', 'Quantity')}}
                                        {{Form::number('quantity', 1)}}
                                        {{Form::submit('Add to Cart', ['style' => 'padding:8px 2.4em', 'name' => 'addToCart'])}}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="shop-now-light" style="display: flex; justify-content: center; margin-top: 45px; margin-bottom: 45px;">
                    <button onclick="window.location.href='/deals'">
                        Shop Local Produce
                    </button>
                </div>
            </div>

            <div class="app-ad-strip">
                <div class="app-ad-strip-text-wrapper">
                    <h3 style="font-size: 25px; margin-block-end: 0px;">Save Time & Money</h3>
                    <h1 style="font-size: 72px; margin-block-start: 0px; margin-block-end: 0px;">Shop With Us on the Go</h1>
                    <p style="font-size: 20px;">Your weekly shopping routine, at your door in just a click</p>
                    <div class="store-links">
                        <a href=""><img src="images/app_store_download.png" alt="" style="width: 32%;"></a>
                        <a href=""><img src="images/google_play_download.png" alt="" style="width: 35%;"></a>
                    </div>
                </div>
            </div>

            <div class="showcase-strip">
                <h1>Most Popular</h1>
                <div class="panel-wrapper">
                    <div class="items-wrapper">
                        @foreach($mostPopularProducts as $product)
                            <div class="item-wrapper" style="position: relative;">
                                @if($product->localproduce == 1)  <p style="position: absolute; background-color: #2B80A1; margin: 0; padding: 8px; color: white; font-size: 13px">Local Produce</p> @endif
                                <a href="/products/{{$product->product_name}}">
                                    <img src= {{$product->product_image}}  alt="">
                                </a>
                                <div class="item-mid">
                                    <a href="/products/{{$product->product_name}}">
                                        <p style="margin-top: 10px;"> {{$product->product_name}} </p>
                                        <p> $ {{ $product->list_price }} </p>
                                    </a>
                                </div>
                                <div class="item-lower">
                                    {!! Form::open(['action' => ['App\Http\Controllers\CartItemController@add'], 'method' => 'post']) !!}
                                        {{Form::hidden('_method', 'POST')}}  
                                        {{Form::hidden('productId', $product->product_id)}}   
                                        {{Form::hidden('storeId', $product->store_id)}}                  
                                        {{Form::label('quantity', 'Quantity')}}
                                        {{Form::number('quantity', 1)}}
                                        {{Form::submit('Add to Cart', ['style' => 'padding:8px 2.4em', 'name' => 'addToCart'])}}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="shop-now-light" style="display: flex; justify-content: center; margin-top: 45px; margin-bottom: 45px;">
                    <button onclick="window.location.href='/deals">
                        Shop Most Popular
                    </button>
                </div>
            </div>

            <div class="advertisement-strip-type-2">
                <div class="advertisement-left-type-2" style="background-image: url(images/home_page_pasta.jpg);">
                    <div class="add-text-box">
                        <h3>Taste of Italy</h3>
                        <h2>Great Deals on Your</h2>
                        <h1>Favorite <br> Pastas</h1>
                    </div>
                    <div class="shop-now-dark" style="padding-left: 10%; padding-top: 0px;">
                        <button onclick="window.location.href='/categories/Pastas %26 Grains'">
                            Shop Now
                        </button>
                    </div>
                </div>
                <div class="advertisement-rightt" style="background-image: url(images/home_page_cornflakes.jpg);">
                    <div class="add-text-box">
                        <h3>Deal of the Week</h3>
                        <h1>30%</h1>
                        <h2>Cereal Brands</h2>
                    </div>
                    <div class="shop-now-dark" style="padding-left: 10%; padding-top: 0px;">
                        <button onclick="window.location.href='/categories/Cereal %26 Snacks'">
                            Shop Now
                        </button>
                    </div>
                </div>
            </div>

            <div class="showcase-strip">
                <h1>Fresh Finds</h1>
                <div class="panel-wrapper">
                    <div class="items-wrapper">
                        @foreach($freshFindsProducts as $product)
                            <div class="item-wrapper" style="position: relative;">
                                @if($product->localproduce == 1)  <p style="position: absolute; background-color: #2B80A1; margin: 0; padding: 8px; color: white; font-size: 13px">Local Produce</p> @endif
                                <a href="/products/{{$product->product_name}}">
                                    <img src= {{$product->product_image}}  alt="">
                                </a>
                                <div class="item-mid">
                                    <a href="/products/{{$product->product_name}}">
                                        <p style="margin-top: 10px;"> {{$product->product_name}} </p>
                                        <p> $ {{ $product->list_price }} </p>
                                    </a>
                                </div>
                                <div class="item-lower">
                                    {!! Form::open(['action' => ['App\Http\Controllers\CartItemController@add'], 'method' => 'post']) !!}
                                        {{Form::hidden('_method', 'POST')}}  
                                        {{Form::hidden('productId', $product->product_id)}}   
                                        {{Form::hidden('storeId', $product->store_id)}}                  
                                        {{Form::label('quantity', 'Quantity')}}
                                        {{Form::number('quantity', 1)}}
                                        {{Form::submit('Add to Cart', ['style' => 'padding:8px 2.4em', 'name' => 'addToCart'])}}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="shop-now-light" style="display: flex; justify-content: center; margin-top: 45px; margin-bottom: 45px;">
                    <button onclick="window.location.href='/deals'">
                        Continue Shopping
                    </button>
                </div>
            </div>

            <div class="subscription-ad-strip" style="background-image: url(images/subscription-background.jpg);">
                <div class="subscription-wrapper" style="color: white; width:65%">
                    <div class="subscription-wrapper-text">
                        <h3 style="font-size: 20px; margin-block-end: 0;">Subscribe & Save</h3>
                        <div class="subscription-deal">
                            <h1 style="font-size: 110px; margin-block-start: 0; margin-block-end: 0;">20%</h1> <h2 style="font-size: 25px; margin-left: 10px;">off</h2>
                        </div>
                        <h2 style="font-size: 25px; margin-block-start: 0;">Your Next Order</h2>
                    </div>
                    <div class="email-collection-wrapper">
                        <p>Enter your email here *</p>
                        {!! Form::open(['url' => '/subscribers', 'method' => 'POST', 'id' => 'subscribe-form']) !!}
                        <div class="input-buttons" style="display: flex;">
                            <input type="email" name = 'email' class="email-collection-input-box" id="email-collection-input-box">
                            <div class="shop-now-light" style="margin-left: 15px;">
                                <button style="height: 100%;" onclick="subscribe(event)">
                                    Subscribe
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <p id="afterSubmit" style="display: none;">Thanks for submitting!</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
@endsection
