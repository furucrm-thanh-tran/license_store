@extends('layouts.dashboard')
@section('style')
<!-- Custom styles for this page -->
<!-- <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<style>
    .table td {
        vertical-align: middle;
    }

    td:last-child {
        text-align: center
    }
</style> -->
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">{{ __('Update Seller Information') }}</div>

            <form id="update_seller" action="{{ route('seller_manager.update', $sellermanager->id) }}" method="POST">
                <!-- <input type="hidden" name="seller_id" id="seller_id" disabled> -->
                @method('PATCH')
                @csrf
                <!-- Card body -->
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Full name</label>
                        <input id="edit_name" type="text" class=" form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ $sellermanager->full_name }}" required autocomplete="name" autofocus placeholder="Enter full name">

                        @error('full_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input id="edit_email" type="email" class=" form-control @error('email') is-invalid @enderror" name="email" value="{{ $sellermanager->email }}" required autocomplete="email" placeholder="Enter email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone number</label>
                        <input id="edit_phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $sellermanager->phone }}" required autocomplete="phone" placeholder="Enter phone number">
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <!--Card footer -->
                <div class="card-footer border-top-0 d-flex justify-content-center">
                    <button id="btnUpdate" type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')

@endsection