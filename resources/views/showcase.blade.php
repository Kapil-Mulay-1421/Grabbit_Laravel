@extends('layouts.app')

@section('content')

<div class="container">
        
    <div class="heading" id="heading" style="display: flex;justify-content: center;">
        <h1></h1>
    </div>

    <div class="content" style="display: flex;justify-content: center;margin-bottom: 50px;">
        <div class="filterby">

        </div>
        <div class="items-wrapper" id="1" style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr 1fr; width: 85%; row-gap: 30px; height: max-content;">
            @foreach($products as $product)
                <div class="item-wrapper" style="position: relative;">
                    @if($product->localproduce)  <p style="position: absolute; background-color: #2B80A1; margin: 0; padding: 8px; color: white; font-size: 13px">Local Produce</p> @endif
                    <a href="productPage.php?productName={{$product->product_name}}">
                        <img src= {{asset($product->product_image)}}  alt="">
                    </a>
                    <div class="item-mid">
                        <a href="productPage.php?productName={{$product->product_name}}">
                            <p style="margin-top: 10px;"> {{$product->product_name}} </p>
                            <p> $ {{ $product->list_price }} </p>
                        </a>
                    </div>
                    <div class="item-lower">
                        <form name="productForm" action="" method="post" style="display: flex; flex-direction: column; align-items: center;">
                            <input name="productQuantity" type="number" value="1" min="1" max="255">
                            <button type="submit" style="cursor: pointer;" onclick = addToCart(event) data-internal-id= {{$loop->index}}, data-internal-class="0">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div> 
    </div>

</div>
@endsection