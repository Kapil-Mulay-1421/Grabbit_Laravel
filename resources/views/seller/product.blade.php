@extends('layouts.app')
@section('content')

<div class="product-page-container">
    <div class="vertical-strip" id="verticalStrip">
        <div class="top-navigator">
            My Stores / {{$storeName}} / Products / {{$product->product_name}}
        </div>
        <div class="main-create-product-container">
            {!! Form::open(['url' => 'my-stores/'.$storeId.'/products/'.$product->product_id, 'method' => 'put', 'id' => 'productInfoForm', 'style'=> "display: grid; grid-template-columns: 1fr 1fr; column-gap: 40px; margin-bottom: 50px;", 'files' => true]) !!}
                {{Form::hidden('_method', 'PUT')}}  
                @if($hasRights)
                <div class="store-image-container" style="width: 500px; position: relative; border: 1px solid black;">
                    <input type="file" id="product_image_input" name="image" style="display: block;" hidden>
                    <img src="{{asset($product->product_image)}}" alt="">
                    <label for="product_image_input">
                      <i class="fa fa-upload" aria-hidden="true" style="position: absolute; right: 5px; top: 5px; font-size: 27px;" onclick="document.getElementById('file-upload-button').click"></i>
                    </label>
                </div>
                <div class="product-info" style="width: 500px">
                {{Form::hidden('productId')}}   
                {{Form::hidden('storeId', $storeId)}}     

                {{Form::label('name', 'Name')}}<br>
                {{Form::text('name', $product->product_name)}} <br><br>

                <label for="category">Choose a category: </label><br>
                <select name="category" id="category">
                    @foreach ($categories as $category)
                        @if($category->category_id == $product->category_id)
                        <option id={{$category->category_id}} value="{{$category->category_name}}" @selected(true)>{{$category->category_name}}</option>
                        @else
                        <option id={{$category->category_id}} value="{{$category->category_name}}">{{$category->category_name}}</option>
                        @endif
                    @endforeach
                </select><br><br>

                {{Form::label('list_price', 'List Price')}}<br>
                {{Form::text('list_price', $product->list_price)}} <br><br>        

                {{Form::label('quantity', 'Quantity')}}<br>
                {{Form::number('quantity', $product->quantity)}} <br><br>

                <h2 style="margin-top: 45px;">Product Info</h2>

                {{Form::label('description', 'Description')}}<br>
                {{Form::textarea('description', $product->description)}}<br><br>
                @endif

                @if(!$hasRights)
                <div class="store-image-container" style="width: 500px; position: relative; border: 1px solid black;">
                    <input type="file" id="product_image_input" name="image" style="display: block;" hidden disabled>
                    <img src="{{asset($product->product_image)}}" style="width: 500px; border: 1px solid black;" alt="product image here">
                    <label for="product_image_input">
                      <i class="fa fa-upload" aria-hidden="true" style="position: absolute; right: 5px; top: 5px; font-size: 27px;" onclick="document.getElementById('file-upload-button').click"></i>
                    </label>
                </div>
                <div class="product-info" style="width: 500px">
                {{Form::hidden('productId')}}   
                {{Form::hidden('storeId', $storeId)}}     

                {{Form::label('name', 'Name')}}<br>
                {{Form::text('name', $product->product_name, $attributes=['disabled'])}} <br><br>

                <label for="category">Choose a category: </label><br>
                <select name="category" id="category" disabled>
                    @foreach ($categories as $category)
                        @if($category->category_id == $product->category_id)
                        <option id={{$category->category_id}} value="{{$category->category_name}}" @selected(true)>{{$category->category_name}}</option>
                        @else
                        <option id={{$category->category_id}} value="{{$category->category_name}}">{{$category->category_name}}</option>
                        @endif
                    @endforeach
                </select><br><br>

                {{Form::label('list_price', 'List Price')}}<br>
                {{Form::text('list_price', $product->list_price)}} <br><br>        

                {{Form::label('quantity', 'Quantity')}}<br>
                {{Form::number('quantity', $product->quantity)}} <br><br>

                <h2 style="margin-top: 45px;">Product Info</h2>

                {{Form::label('description', 'Description')}}<br>
                {{Form::textarea('description', $product->description, $attributes=['disabled'])}}<br><br>
                @endif

                <div class="cart-button-wrapper" style="display:flex; align-items:center;">
                    {{Form::submit('Submit', ['style' => 'padding:8px 2.4em', 'class' => "add-to-cart-lighter", 'name' => 'addToCart'])}}
                </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection