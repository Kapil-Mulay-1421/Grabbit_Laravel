<div style="border: 1px solid black; padding: 30px;">
    <h1 style="color: black;">Order Placed</h1><br><br>

@foreach($orderItems as $orderItem)
    <div class="bought-item" style="display: flex; justify-content: space-between;">
        <div class="item-info" style="display: flex;">
            <img src="{{asset($orderItem->product_image)}}" alt="" style="border: 1px solid black; width: 100px;">
            <div class="product-information" style="margin-left: 20px;">
                <p style="font-weight: 600; margin-top: 0;">{{$orderItem->product_name}}</p> 
                {{$orderItem->buy_price}}
                <p style="font-size: 15px; font-weight: 100;">Store: {{$orderItem->store_name}} </p> 
            </div>
        </div>
        <div class="bought-item-right" >
            <p style="margin: 0px;">QTY: {{$orderItem->quantity}} </p><p style="margin: 0px;">{{$orderItem->buy_price*$orderItem->quantity}}</p>
        </div>
        <p>From: {{$orderItem->store_name.", ".$orderItem->street.", ".$orderItem->city.", ".$orderItem->state}}</p>
    </div>
    <hr>
@endforeach

<div class="billbox-lower" style="display: grid; grid-template-columns: 1fr 1fr; column-gap: 50px;">
    <div class="order-note">
        <p style="font-weight: 300;">Note: </p>
        <p>{{$order->note}}</p>
    </div>
    <div class="bill">
        <ul style="list-style-type: none; padding-inline-start: 0; width: 100%;">
            <li><div class="subtotal" style="display: flex; justify-content: space-between;"><p style="margin-bottom: 0;">Subtotal</p><p style="margin-bottom: 0;">{{$order->subtotal}}</p></div></li>
            <li><div class="shipping" style="display: flex; justify-content: space-between;"><p>Shipping</p><p>{{$order->shipping}}.00</p></div></li>
            <!--<li style="display: flex; justify-content: space-between;"><p style="margin-top: 0;">Sales Tax</p><p style="margin-top: 0;">$0.5</p></li>-->
            <hr>
            <li><div class="total" style="display: flex; justify-content: space-between;"><p style="font-size: 24px; margin-top:9.5px;">Total</p><p>{{$order->total_amount}}</p></div></li>
        </ul>
    </div>
</div>
</div>

<div class="address-box" style="display: grid; grid-template-columns: 1fr 1fr 1fr; column-gap: 40px; border: 1px solid black; padding: 30px; margin-bottom: 30px;">
<div class="shipping-div">
    <h3>Shipping Address</h3>
    <p>
        {{$username}} <br>
        {{$order->shipping_address}} <br>
    </p>
</div>
<div class="billing-div">
    <h3>Billing Address</h3>
    <p>
        {{$username}} <br>
        {{$order->billing_address}} <br>
    </p>
</div>
<div class="status-div">
    <h3>Order Status</h3>
    <p>
        {{ ($order->order_status==1) ? "Payment Received" : (($order->order_status==2) ? "Dispatched" : "Delivered") }}
    </p>
    <p>
        Reference ID: {{$order->order_id}}
    </p>
    <p>
        Payment Method: {{$order->payment_method}}
    </p>
</div>
</div>
</div>