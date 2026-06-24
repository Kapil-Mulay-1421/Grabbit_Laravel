@extends('layouts.app')
@section('content')

<head>
    {{-- @vite(['resources/js/cart.js']) --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<div class="container" style="display: flex; justify-content: center; margin-top: 50px;">
    <div class="cart-main-wrapper">
        <div class="my-cart-wrapper">
            <h2>My Cart</h2>
            <hr>
            <div class="cart-items-wrapper" id="nonSlidingCartItemsWrapper">
                @foreach($cartItems as $cartItem)
                <div class="cart-item-wrapper">
                    <div class="cart-product" style="display: flex; justify-content: space-between;">
                        <div class="cart-item-info" style="display: flex;">
                            <img src={{asset($cartItem->product_image)}} alt="" style="border: 1px solid black; width: 100px;">
                            <div class="product-information" style="margin-left: 20px;">
                                <p style="margin-top:0; margin-bottom:0; margin-right: 30px; font-weight: bold;">{{$cartItem->product_name}}</p> <br>
                                <div class="dropdown-wrapper">
                                    

                                </div><br>
                                <p style="margin:0px;">{{$cartItem->current_list_price}}</p> <br>
                                <input type="number" onchange="updateItemTotal(event)" name="quantity" value={{$cartItem->quantity}} style="width: 48%; height: 20px;" data-internal-id={{$loop->index}}> <br>
                            </div>
                        </div>
                        <div class="cart-item-right">
                            {!! Form::open(['action' => ['App\Http\Controllers\CartItemController@destroy', $cartItem->id], "method" => 'PUT', 'id' => 'delete-form']) !!}
                                {{Form::hidden('_method', 'GET')}}
                                <p style="margin: 0px;">{{round($cartItem->current_list_price*$cartItem->quantity, 2)}}</p>{{Form::submit('⛌', ['style' => 'border: none; background: none; margin: 0px; user-select: none; cursor: pointer;', 'id' => 'delete-button', 'data-delete-button-id' => $loop->index])}}
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <hr>
                </div>
                @endforeach
            </div>
        </div>
        <div class="order-summary-wrapper" style="display: flex; flex-direction: column; align-items: center;">
            <h2>Order Summary</h2>
            <hr style="width: 100%; margin-block-start: 0px;">
            <ul style="list-style-type: none; padding-inline-start: 0; width: 100%;">
                <li><div class="subtotal" style="display: flex; justify-content: space-between;"><p>Subtotal</p><p id="subtotal-element">{{$subtotal}}</p></div></li>
                <li><div class="coupon" style="justify-content: space-between; display:flex;"><p>Coupon</p><p id="coupon">{{$appliedCoupon ? '20% Off' : 'None'}}</p></div></li>
                <li><div class="shipping" style="display: flex; justify-content: space-between;"><p>Shipping</p><p>{{$shipping}}.00</p></div></li>
                @if($addressFound)
                <li><b>Shipping Address:</b> <br>{{$address->address}}, {{$address->city}}, {{$address->state}}, {{$address->country}}</li>
                <div style="display:flex; justify-content:flex-end; padding: 5px;">
                    <button class="light-square-button" style="padding: 5px;" onclick="window.location.href='/profile/addresses'">Change Address</button>
                    @endif
                    @if(! $addressFound)
                    <button class="light-square-button" style="padding: 5px;" onclick="window.location.href='/profile/addresses'">Activate Address</button>
                    @endif
                </div>
                <hr>
                <li><div class="total" style="display: flex; justify-content: space-between; align-items: center;"><p style="font-size: 24px; margin-top:9.5px;">Total</p><p id="total-element">{{$total}}</p></div></li>
                <li style="display: flex; justify-content: space-around">
                    <label for="paymentPreferenceSelection">Choose a Payment Method:</label>
                    <select name="visiblePaymentPreference" id="visiblePaymentInputId" style="border: 2px solid #154051">
                        <option value="razorpay">Razorpay</option>
                        <!--<option value="stripe">Stripe</option>--><!--Uncomment after stripe becomes open to all in the latter half of 2025.-->
                    </select>
                </li>
            </ul>
            
            <div class="shop-now-dark" style="display: flex; justify-content: center; width: 100%;">
                <button style="width: 100%;" onclick="checkout()">Checkout</button>
            </div>
            <p>⛊ Secure Checkout</p>

            <div class="shop-now-light" style="display: flex; justify-content: center; width: 100%;">
                <button style="width: 100%;" onclick="showStores()">Store Preference</button>
            </div>

            <!-- <p style="font-size: 24px; margin-bottom: 0;">We Accept Crypto</p>
            <p>⛊ Secure Payments</p>-->
            
        </div>
        
    </div>

    <form style="display: none" action="/checkout" method="POST" id="checkoutForm">
        @csrf
        <input type="hidden" id="cartItemsInput" name="cartItems" value=""/>
        <input type="hidden" id="orderNoteInput" name="orderNote" value=""/>
        <input type="hidden" id="paymentPreferenceInput" name="paymentPreference" value=""/>
    </form>

</div>

@endsection