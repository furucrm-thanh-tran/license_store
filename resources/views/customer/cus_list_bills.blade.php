@extends('layouts.master')
@section('content')
    <div class="container">
        <!-- Project-->
        <div class="bg-white card payments-item mb-2 shadow-sm">
            <h4 class="font-weight-bold mt-3  mb-4 col-7">Purchase History</h4>
            <table class="table table-striped">
                <tr>
                    <th>Bill ID</th>
                    <th>Price Total</th>
                    <th>Date</th>
                    <th>Option</th>
                </tr>
                @foreach ($bill as $b)
                    <tr>
                        <td>{{$b->id}}</td>
                        <td>${{$b->total_money}}</td>
                        <td>{{$b->created_at}}</td>
                        <td>
                            <a class="bill_detail" href="{{route("bill_detail",$b->id)}}">Detail</a>
                            /
                        <a href="#{{$b->seller_id}}">Send Question</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
