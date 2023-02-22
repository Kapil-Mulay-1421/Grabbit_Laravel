<div style="border: 1px solid black; padding: 30px;">
    <h1 style="color: black;">Order Placed</h1><br><br>
    <p>
        Dear {{$username}},
        We are thrilled to confirm that your order has been received and your payment has been processed successfully. Thank you for choosing Grabbit India for your purchase. <br><br>
    </p>
    <h3>Order Details</h3>
    <p>Order Number: {{$order->order_id}}</p><br>
    <p>Order Date: {{$order->order_date}}</p><br>
    <p>Payment Method: {{$order->payment_method}}</p><br>
    <p>Total: {{$order->total_amount}}</p><br><br>
    <p>
        Your order will be shipped to the shipping address you provided during checkout. <br>
        <br>
        We want you to know that we appreciate you doing business with us and value you as our customer. Your satisfaction is our top priority, and we will do everything we can to ensure that your order is processed and shipped promptly. <br>
        <br>
        If you have any questions or concerns regarding your order, please don't hesitate to contact us. Our customer service team is available to assist you with any inquiries you may have. <br>
        <br>
        Thank you once again for your business. We look forward to serving you in the future. <br>
        <br>
        Sincerely, <br>
        <br>
        Team Grabbit
    </p>
</div>