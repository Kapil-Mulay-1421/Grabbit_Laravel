@extends('layouts.app')
@section('content')

<div class="store-page-container">
    <div class="vertical-strip" id="verticalStrip" style="margin-bottom: 50px;">
        <div class="top-navigator">
            My Stores / {{$store->store_name}}
        </div>
        <div class="main-store-container">
            {!! Form::open(['url' => '/my-stores/'.$store->store_id, 'method' => 'PUT', 'style' => 'display: grid; grid-template-columns: 1fr 1fr; column-gap: 40px;', 'files' => true]) !!}
            {{Form::hidden('_method', 'PUT')}}  
            {{Form::hidden('storeId', $store->store_id)}} 

            <div class="store-image-container" style="width: 500px; position: relative; border: 1px solid black;">
                <input type="file" id="store_image_input" name="image" style="display: block;" hidden>
                <label for="store_image_input">
                  <i class="fa fa-pencil-square-o" aria-hidden="true" style="position: absolute; right: 5px; top: 5px; font-size: 27px;" onclick="document.getElementById('file-upload-button').click"></i>
                </label>
                <img src='{{$store->image}}' alt="Product Image Here" style="width: 100%; height: auto;">
            </div>
            <div class="product-info" style="width: 500px">


                {{Form::label('name', 'Name')}}&nbsp;
                {{Form::text('name', $store->store_name)}}<br><br>

                {{Form::label('phone', 'Phone')}}&nbsp;
                {{Form::text('phone', $store->phone)}}<br><br>

                {{Form::label('email', 'Email')}}&nbsp;
                {{Form::text('email', $store->email)}}<br><br>

                {{Form::label('street', 'Street')}}&nbsp;
                {{Form::text('street', $store->street)}}<br><br>

                {{Form::label('city', 'City')}}&nbsp;
                {{Form::text('city', $store->city)}}<br><br>

                {{Form::label('state', 'State')}}&nbsp;
                {{Form::text('state', $store->state)}}<br><br>


                {{Form::label('opens_at', 'Opens At: ')}}&nbsp; {{Form::text('opens_at', $store->opens_at)}}<br><br>
                {{Form::label('closes_at', 'Closes At: ')}}&nbsp; {{Form::text('closes_at', $store->closes_at)}}<br><br>
                <h2>Store Info</h2>
                {{Form::label('description', 'Description')}}<br>
                {{Form::textarea('description', $store->description)}}<br><br>

                {{Form::submit('Submit Changes', ['style' => 'padding:8px 2.4em', 'class' => "add-to-cart-lighter", 'name' => 'addToCart'])}}
                {!! Form::close() !!}

            </div>
            
        </div>
        <button class="light-square-button" onclick="window.location.href='/my-stores/{{$store->store_id}}/products/create'" style="margin-bottom: 45px;">Add a Product</button>
        {!! Form::open(['url' => '/my-stores/'.$store->store_id, 'method' => 'DELETE']) !!}
                {{Form::hidden('_method', 'DELETE')}}  
                <button class="dark-square-button" onclick="return confirm('Are you sure you want to delete this store?')" type="submit">Delete Store</button>
        {!! Form::close() !!}
    </div>
</div>

@endsection