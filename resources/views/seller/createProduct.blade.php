@extends('layouts.app')
@section('content')

<head>
    {{-- @vite(['resources/js/createProduct.js']) --}}
</head>

<div class="product-page-container">
    <div class="vertical-strip" id="verticalStrip">
        <div class="top-navigator">
            Is your product one of the following?
        </div>
        <div class="items-wrapper" style="border: 1px solid black; padding: 20px; margin-bottom: 30px; width: 100%;">
            @foreach($products as $product)
                <div class="item-wrapper" onclick="prefill({{$product->product_id}})">
                    <img src="{{asset($product->product_image)}}" alt="">
                    <p style="text-align: center;" class="product-name">
                        {{$product->product_name}}
                    </p>
                </div>
            @endforeach
        </div>
        <div class="main-create-product-container">
                {!! Form::open(['url' => ['my-stores/'.$storeId.'/products'], 'method' => 'post', 'id' => 'productInfoForm', 'style'=> "display: grid; grid-template-columns: 1fr 1fr; column-gap: 40px; margin-bottom: 50px;", 'files' => true]) !!}
                    {{Form::hidden('_method', 'POST')}}  
                    <div class="store-image-container" style="width: 500px; position: relative; border: 1px solid black;">
                        <input type="file" id="product_image_input" name="image" style="display: block;" hidden>
                        <label for="product_image_input">
                          <i class="fa fa-upload" aria-hidden="true" style="position: absolute; right: 5px; top: 5px; font-size: 27px;" onclick="document.getElementById('file-upload-button').click"></i>
                        </label>
                        <div class="image-here" style="width: 100%; min-height: 600px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            <label for="product_image_input" id="image-input-prompt" style="text-align: center; color: grey; cursor: pointer;">Upload an Image for your Product</label>
                        </div>
                    </div>
                    <div class="product-info" style="width: 500px">
                    {{Form::hidden('productId')}}   
                    {{Form::hidden('storeId', $storeId)}}     

                    {{Form::label('name', 'Name')}}<br>
                    {{Form::text('name')}} <br><br>

                    <label for="category">Choose a category: </label><br>
                    <select name="category" id="category">
                        @foreach ($categories as $category)
                            <option id={{$category->category_id}} value="{{$category->category_name}}">{{$category->category_name}}</option>
                        @endforeach
                    </select><br><br>

                    {{Form::label('list_price', 'List Price')}}<br>
                    {{Form::text('list_price')}} <br><br>        

                    {{Form::label('quantity', 'Quantity')}}<br>
                    {{Form::number('quantity')}} <br><br>

                    {{Form::label('localproduce', 'I locally produce this product.')}}&nbsp;
                    {{Form::checkbox('localproduce')}}<br><br><br>

                    <h2 style="margin-top: 45px;">Product Info</h2>

                    {{Form::label('description', 'Description')}}<br>
                    {{Form::textarea('description')}}<br><br>

                    <div class="cart-button-wrapper" style="display:flex; align-items:center;">
                        {{Form::submit('Submit', ['style' => 'padding:8px 2.4em', 'class' => "add-to-cart-lighter", 'name' => 'addToCart'])}}
                    </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection