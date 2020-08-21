<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

    </style>
</head>

<body>
    <h1>License Store Bill#{{ $details['email']->id }}</h1>
    <p>Hi {{ $details['email']->users->full_name }}!</p>
    <p>Everything have been done. These are all license key which you ordered:</p>
    <table style="width:100%">
        <tr>
            <th>Product</th>
            <th>License key</th>
            <th>Expiration date</th>
        </tr>
        @foreach ($details['licenses'] as $item)
            <tr>
                <td>{{ $item->products->name_pro }}</td>
                <td>{{ $item->product_key }}</td>
                <td>{{ $item->expiration_date }}</td>
            </tr>
        @endforeach
    </table>
    <p>Thank you!</p>
</body>
</html>
