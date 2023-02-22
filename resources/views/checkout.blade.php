@extends('layouts.app')
@section('content')

<head>
    <meta name="razorpay_order_id" content="{{$razorpay_order_id}}">
    <meta name="total" content="{{$total}}">
    @vite(['resources/js/pay.js'])
</head>

<button id="rzp-button1">Pay With Razorpay</button>
<form action="/payment-verification" method="POST" id="payment-form" style="display: none;">
    @csrf
    <input type="hidden" id="payment_id" name="razorpay_payment_id">
    <input type="hidden" id="order_id" name="razorpay_order_id">
    <input type="hidden" id="signature" name="razorpay_signature">
</form>

@endsection