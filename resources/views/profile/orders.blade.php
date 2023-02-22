@extends('layouts.profile')
@section('substance')


<div class="bought-item" style="display: flex; justify-content: space-between;">
    <div class="item-info" style="display: flex;">
        <div class="product-information" style="margin-left: 20px;">
            <p style="font-weight: 600; margin-top: 0;">Date</p> 
        </div>
    </div>
    <div class="bought-item-right" >
        <p style="margin: 0px; font-weight: 600;">Subtotal </p><p style="margin: 0px; font-weight: 600;">Total</p>
    </div>
</div>
<hr>
@foreach($orders as $order)
<div class="bought-item" style="display: flex; justify-content: space-between; cursor: pointer;" onclick="window.location.href='/profile/orders/{{$order->order_id}}'">
    <div class="item-info" style="display: flex;">
        <div class="product-information" style="margin-left: 20px;">
            <p style="font-weight: 600; margin-top: 0;">{{$order->order_date}}</p> 
        </div>
    </div>
    <div class="bought-item-right" >
        <p style="margin: 0px;">{{$order->subtotal}} </p><p style="margin: 0px;">{{$order->total_amount}}</p>
    </div>
</div>
<hr>
@endforeach

@endsection