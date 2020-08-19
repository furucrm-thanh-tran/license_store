<h1>License Store Bill#{{ $details['bill_code'] }}</h1>
<p>Hi {{ $details['seller_name'] }}!</p>
<p>You have a new bill need to be handled. This is infomation of the bill:</p>
<p>
    <ul>
        <li>Bill code: {{ $details['bill_code'] }}</li>
        <li>Customer name: {{ $details['customer_name'] }}</li>
        <li>Customer email: {{ $details['customer_email'] }}</li>
    </ul>
</p>
