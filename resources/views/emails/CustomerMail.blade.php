<h1>License Store Bill#{{ $details['bill_code'] }}</h1>
<p>Hi {{ $details['customer_name'] }}!</p>
<p>Your invoice has been approved. This is detail infomation:</p>
<p>
    <ul>
        <li>Bill code: {{ $details['bill_code'] }}</li>
        <li>Seller name: {{ $details['seller_name'] }}</li>
        <li>Seller email: {{ $details['seller_email'] }}</li>
    </ul>
</p>
<p>Thank you!</p>
