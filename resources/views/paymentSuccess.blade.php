@extends('layouts.app')
@section('content')

<div class="container" style="display: flex; justify-content: center; margin-bottom: 50px;">
<div class="vertical-strip" >
    <h1>Thank you, {{$customerName}}</h1>
    <p>Thank you for placing an order with us. You'll receive a confirmation email from us as soon as we verify your order.</p>
    
    <form class="feedback-form" name="feedback-form" action="/feedback" method="POST" style="width: 100%; display: flex; flex-direction: column; align-items: center; margin-bottom: 30px;">
        @csrf
        <h2>Feedback</h2>
        <p style="margin-top:0;">Please give you feedback and help us improve our service</p>
        <textarea class="feedback-textarea" name="feedback" cols="30" rows="10" style="resize: none; width: 100%;" placeholder="Enter your feedback here"></textarea> <br>
        <div class="shop-now-dark" style="width: 100%; display: flex; justify-content: center;">
            <button type="submit" style="width: 33%;">Submit</button>
        </div>
    </form>
    <a href="/home" style="text-decoration: none; color: black;">Continue Browsing</a>
</div>
</div>

@endsection