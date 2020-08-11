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
            text-align: left;
            padding: 8px;
        }

        th {
            /* background-color; */
            color: gray;
        }

        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            width: 40%;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .container {
            padding: 2px 16px;
        }

    </style>
</head>

<body>
    <div class="container">

            <table>
                <tr>
                    <th>AMOUNT PAID</th>
                    <th>DATE PAID</th>
                    <th>PAYMENT METHOD</th>
                </tr>
                <tr>
                    {{-- <td>${{ $details['total'] }}</td>
                    --}}
                    {{-- <td>{{ $details['date'] }}</td> --}}
                    {{-- <td>VISA - {{ $details['card'] }}</td>
                    --}}
                    <td>${{ $details['total'] }}</td>
                    <td>{{ $details['date'] }}</td>
                    <td>VISA - {{ $details['card'] }}</td>
                </tr>
            </table>
            <h5>STATUS: {{ $details['status'] }}</h5>


    </div>





</body>

</html>
