@extends('layouts.master')
@section('content')
    <div class="container">
        <!-- Project-->
        <div class="bg-white card payments-item mb-2 shadow-sm row">
            <div class="m-3">
            <form action="{{route('check_mail')}}">
                    <h4 class="font-weight-bold mt-3  mb-4 col-7">Check Mail</h4>
                    <input id="email" name="email" class='form-control' type='email' placeholder="example@gmail.com">
                    <input class="btn btn-success mt-2" type="submit" value="Check">
                </form>
            </div>

        </div>
    </div>

@endsection
