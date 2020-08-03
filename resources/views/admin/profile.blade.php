@extends('layouts.dashboard')
@section('content')
<div class="card">
    <form action="">
        <div class="card-body">
            <div class="row">
                <div class="col-10">
                    <h1>{{ Auth::guard('manager')->user()->full_name }}</h1>
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col-md-2">
                    <label>Username</label>
                </div>
                <div class="col-md-6">
                    <p>{{ Auth::guard('manager')->user()->user_name }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label>Email</label>
                </div>
                <div class="col-md-6">
                    <p>{{ Auth::guard('manager')->user()->email }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label>Phone</label>
                </div>
                <div class="col-md-6">
                    <p>{{ Auth::guard('manager')->user()->phone }}</p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection