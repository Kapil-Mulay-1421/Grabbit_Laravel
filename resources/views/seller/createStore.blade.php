@extends('layouts.app')
@section('content')

<div class="store-page-container">
    <div class="vertical-strip" id="verticalStrip">
        <div class="top-navigator">
            My Stores / Create
        </div>
        <div class="main-store-container">
            {!! Form::open(['url' => '/my-stores', 'method' => 'POST', 'style' => 'display: grid; grid-template-columns: 1fr 1fr; column-gap: 40px; margin-bottom: 50px;', 'files' => true]) !!}
            {{Form::hidden('_method', 'POST')}}  

            <div class="store-image-container" style="width: 500px; position: relative; border: 1px solid black;">
                <input type="file" id="store_image_input" name="image" style="display: block;" hidden>
                <label for="store_image_input">
                  <i class="fa fa-upload" aria-hidden="true" style="position: absolute; right: 5px; top: 5px; font-size: 27px;" onclick="document.getElementById('file-upload-button').click"></i>
                </label>
                <div class="image-here" style="width: 100%; min-height: 600px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <label for="store_image_input" style="text-align: center; color: grey; cursor: pointer;">Upload an Image for your Store</label>
                </div>
            </div>
            <div class="product-info" style="width: 500px">


                {{Form::label('name', 'Name')}}&nbsp;
                {{Form::text('name')}}<br><br>

                {{Form::label('phone', 'Phone')}}&nbsp;
                {{Form::text('phone')}}<br><br>

                {{Form::label('email', 'Email')}}&nbsp;
                {{Form::text('email')}}<br><br>

                {{Form::label('street', 'Street')}}&nbsp;
                {{Form::text('street')}}<br><br>

                {{Form::label('city', 'City')}}&nbsp;
                {{Form::text('city')}}<br><br>

                {{Form::label('state', 'State')}}&nbsp;
                {{Form::text('state')}}<br><br>

                {{Form::label('opens_at', 'Opens At: ')}}&nbsp; {{Form::text('opens_at')}}<br><br>
                {{Form::label('closes_at', 'Closes At: ')}}&nbsp; {{Form::text('closes_at')}}<br><br>
                <h2>Store Info</h2>
                {{Form::label('description', 'Description')}}<br>
                {{Form::textarea('description')}}<br><br>

                {{Form::submit('Submit', ['style' => 'padding:8px 2.4em', 'class' => "add-to-cart-lighter", 'name' => 'addToCart'])}}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection