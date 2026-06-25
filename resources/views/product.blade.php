@extends('layouts.app')
@section('content')

<div class="product-page-container">
    <div class="vertical-strip" id="verticalStrip">
        <div class="top-navigator">
            Home / {{$product->product_name}}
        </div>
        <div class="main-product-container">
            <img src={{asset($product->product_image)}} alt="Product Image Here" style="width: 500px; border: 1px solid black;">
            <div class="product-info" style="width: 500px">
                <h1 style="margin-top: 0; font-size: 30px;"> {{$product->product_name}} </h1>
                <h2 style = "font-size: 22px;">${{$product->list_price}}</h2><br>
                {!! Form::open(['action' => ['App\Http\Controllers\ProductController@addToCartOrWishlist'], 'method' => 'post']) !!}
                    {{Form::hidden('_method', 'POST')}}  
                    {{Form::hidden('productId', $product->product_id)}}   
                    {{Form::hidden('storeId', $product->store_id)}}                  
                    {{Form::label('quantity', 'Quantity')}}<br><br>
                    {{Form::number('quantity', 1, ['min' => 1, 'step' => 1])}} <br><br><br>
                    <div class="cart-button-wrapper" style="display:flex; align-items:center;">
                        {{Form::submit('Add to Cart', ['style' => 'padding:8px 2.4em', 'class' => "add-to-cart-lighter", 'name' => 'addToCart'])}}
                        {{Form::image(url($inWishlist ? asset("images/Icons/heart_circle_full.png") : asset("images/Icons/heart_circle.png")), 'submit', ['style'=>"width:48px; margin-left: 20px; cursor: pointer;"])}}
                    </div>
                {!! Form::close() !!}
                <h2 style="margin-top: 45px;">Product Info</h2>
                <p style="margin-right: 50px;">{{$product->description}}</p>
            </div>
            <p style="margin-right: 50px; margin-bottom: 50px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis ex repellat fugiat reprehenderit nihil facere consectetur ad? Quo, minus tenetur ipsum nemo fugiat error non sapiente, molestias veniam repellat tempore?</p>
        </div>
    </div>
</div>

@endsection