@extends('layouts.profile')
@section('substance')

@foreach($orders as $order)
    <div class="bought-item" style="display: flex; justify-content: space-between;">
        <div class="item-info" style="display: flex;">
            <img src="{{asset($order->product_image)}}" alt="" style="border: 1px solid black; width: 100px;">
            <div class="product-information" style="margin-left: 20px;">
                <p style="font-weight: 600; margin-top: 0;">{{$order->product_name}}</p> 
                {{$order->buy_price}}
                <p style="font-size: 15px; font-weight: 100;">Store: {{$order->store_name}} </p> 
            </div>
        </div>
        <div class="bought-item-right" >
            <p style="margin: 0px;">QTY: {{$order->quantity}} </p><p style="margin: 0px;">{{$order->buy_price*$order->quantity}}</p>
        </div>
    </div>
    <hr>
@endforeach

@endsection