@extends('layouts.app')
@section('content')

<head>
    <meta name="razorpay_order_id" content="{{$razorpay_order_id}}">
    <meta name="total" content="{{$total}}">
    @vite(['resources/js/pay.js'])
</head>
<div style="display:flex; justify-content: center; margin: 50px;">
    <button id="rzp-button1" class="shop-now-light">Pay With Razorpay</button>
</div>

<form action="/payment-verification" method="POST" id="payment-form" style="display: none;">
    @csrf
    <input type="hidden" id="payment_id" name="razorpay_payment_id">
    <input type="hidden" id="order_id" name="razorpay_order_id">
    <input type="hidden" id="signature" name="razorpay_signature">
</form>

@endsection