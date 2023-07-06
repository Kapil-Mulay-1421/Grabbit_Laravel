@extends('layouts.app')

@section('content')

<head>
    @vite(['resources/js/gps.js'])
</head>

<body>
    <form action="/delivery-agent/track" method="POST" id="loc-form">
        @csrf
        <input type="hidden" name="latitude" id="lat">
        <input type="hidden" name="longitude" id="long">
    </form>
    <button onclick="window.getLocation()">Start Tracking</button>

</body>

@endsection