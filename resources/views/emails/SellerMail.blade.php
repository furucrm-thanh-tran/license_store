<!doctype html>
<html>

<head>
    <h1>{{ $details['title']}}</h1>

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
    <table>
        <tr>
            <td>Product Name</td>
            <td>Description</td>
            <td>Price</td>
        </tr>
        @foreach($details['product'] as $pro)
        <tr>
            <td>{{ $pro->name_pro }}</td>
            <td>{{ $pro->description_pro }}</td>
            <td>${{ $pro->price_license }}</td>
        </tr>
        @endforeach
    </table>
    <p>Mail to: {{ $details['seller_email']}}</p>
    <p>Click to seen detail: {{$details['link']}}</p>
</body>

</html>