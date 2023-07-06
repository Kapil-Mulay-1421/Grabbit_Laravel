@extends('layouts.app')
@section('content')

<div class="store-page-container">
    <div class="vertical-strip" id="verticalStrip">
        <div class="top-navigator">
            My Stores / {{$store->store_name}}
        </div>
        <div class="main-store-container">
            <img src='{{$store->image}}' alt="Product Image Here" style="width: 500px; border: 1px solid black;">
            <div class="product-info" style="width: 500px">
                <h1 style="margin-top: 0; font-size: 30px;">{{$store->store_name}}</h1>
                <h2 style = "font-size: 22px; font-weight: 400">{{$store->street. ", ".$store->city. ", ".$store->state}}</h2><br>
                <h3 style="font-weight:400;">Opens At: {{$store->opens_at}}</h2><br>
                <h3 style="font-weight:400;">Closes At: {{$store->closes_at}}</h2><br>
                <h2>Store Info</h2>
                <p style="margin-right: 50px;">{{$store->description}}</p>
            </div>
        </div>
    </div>
</div>

@endsection