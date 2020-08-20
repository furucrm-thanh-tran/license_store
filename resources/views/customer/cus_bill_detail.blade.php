@extends('layouts.master')
@section('content')
<div class="container">
    <div class="bg-white card payments-item mb-2 shadow-sm">
        <h4 class="font-weight-bold mt-3  mb-4 col-7">Bill Detail</h4>
        <table class="table table-borderless">
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Line Total</th>
            </tr>
                @foreach ($data as $d)
                <tr>
                    <td class="name">{{$d->products->name_pro}}</td>
                    <td class="price" >${{$d->products->price_license}}</td>
                    <td class="amount" >{{$d->amount_licenses}}</td>
                    <td class="line_total" data-total="{{$d->products->price_license*$d->amount_licenses}}">${{$d->products->price_license*$d->amount_licenses}}.00</td>
                </tr>
            @endforeach
        </table>
        <hr>
        <h5 id="total" class="mt-3  mb-4 col-7">Total: $1000</h5>
    </div>
</div>
@endsection

@section('script')
    <script>
        var total = $(".line_total").map(function() {
                return $(this).data("total");
            }).get();
            t=0;
            for(i=0;i<total.length;i++){
                t = total[i] + t;
            }
            $("#total").text("Total: "+"$"+t+".00");
    </script>
@endsection
