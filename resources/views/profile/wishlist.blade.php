@extends('layouts.profile')
@section('substance')

<div class="items-wrapper">
@foreach($wishlist as $product)
    <div class="item-wrapper" style="position: relative;">
        @if($product->localproduce)  <p style="position: absolute; background-color: #2B80A1; margin: 0; padding: 8px; color: white; font-size: 13px">Local Produce</p> @endif
        <a href="productPage.php?productName={{$product->product_name}}">
            <img src= {{asset($product->product_image)}}  alt="">
        </a>
        <div class="item-mid">
            <a href="productPage.php?productName={{$product->product_name}}">
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

@endsection