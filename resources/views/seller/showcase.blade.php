@extends('layouts.app')

@section('content')

<div class="container" style="margin-bottom: 50px;">
        
    <div class="heading" id="heading" style="display: flex;justify-content: center; margin-top: 50px; margin-bottom: 15px;  ">
        <h1>{{$heading}}</h1>
    </div>

    <div class="content" style="display: flex;justify-content: center;">
        <div class="filterby">

        </div>
        <div class="items-wrapper" id="1" style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr 1fr; width: 85%; row-gap: 30px; height: max-content;">
            @foreach($products as $product)
                <div class="item-wrapper" style="position: relative;">
                    @if($product->localproduce)  <p style="position: absolute; background-color: #2B80A1; margin: 0; padding: 8px; color: white; font-size: 13px">Local Produce</p> @endif
                    <a href="/products/{{$product->product_name}}">
                        <img src= {{asset($product->product_image)}}  alt="">
                    </a>
                    <div class="item-mid">
                        <a href="/products/{{$product->product_name}}">
                            <p style="margin-top: 10px;"> {{$product->product_name}} </p>
                            <p> $ {{ $product->list_price }} </p>
                        </a>
                    </div>
                    <div class="item-lower">
                        <button onclick="window.location.href='/my-stores/{{$storeId}}/products/{{$product->product_id}}/edit'" style="margin-top: 20px;">Edit</button>
                        {!! Form::open(['action' => ['App\Http\Controllers\SellerProductController@destroy', $storeId, $product->product_id], 'method' => 'DELETE']) !!}
                            {{Form::hidden('_method', 'DELETE')}}  
                            {{Form::submit('Remove', ['style' => 'padding:8px 2.4em', 'name' => 'delete'])}}
                        {!! Form::close() !!}
                    </div>
                </div>
            @endforeach
        </div> 

    </div>

    <div style="display: flex; justify-content: center;">
        <button class="light-square-button" style="margin-top: 50px" onclick="window.location.href='/my-stores/{{$storeId}}/products/create'">Add a Product</button>
    </div>

</div>
@endsection