@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="bg-white card payments-item mb-2 shadow-sm">
            <h4 class="font-weight-bold mt-3  mb-4 col-7">Feedback</h4>
            <table class="table table-borderless">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Answer</th>
                    <th>Seller</th>
                    <th>Answer at</th>
                </tr>
                    @foreach ($data as $d)
                    <tr>
                        <td>{{ $d->title }}</td>
                        <td>{{ $d->description }}</td>
                        <td>{{ $d->answer }}</td>
                        <td>{{ $d->managers->full_name }}</td>
                        <td>{{ $d->created_at }}</td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>
@endsection
