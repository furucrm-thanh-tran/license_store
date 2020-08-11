@extends('layouts.dashboard')
@section('content')
<!-- The Edit Profile -->
<div class="modal fade" id="editProfile">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Update profile information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <form id="update_seller" action="" method="POST">
                <input type="hidden" name="seller_id" id="seller_id" disabled>
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="full_name">Full name</label>
                        <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}" required autocomplete="full_name" autofocus placeholder="Enter full name">

                        @error('full_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone number</label>
                        <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" placeholder="Enter phone number">
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@if(session()->get('success'))
<div class="alert alert-success" id="message-success">
    {{ session()->get('success') }}
</div>
@endif
<div class="card" id="profileCard">
    <div class="card-body">
        <div class="row">
            <div class="col-10">
                <h1>{{ Auth::guard('manager')->user()->full_name }}</h1>
            </div>
            <div class="col-2">
                <button id="edit-seller" class="btn btn-outline-dark float-right" data-toggle="modal" data-id="{{ Auth::guard('manager')->user()->id }}">Edit Profile</button>
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
</div>
@endsection

@section('script')
<script>
    $(function() {
        $('#message-success').delay(3000).fadeOut();
    });
</script>

<script type="text/javascript">
    $(function() {
        /* Update infor seller */
        $('#profileCard').on('click', '#edit-seller', function() {
            var seller_id = $(this).data('id');
            $.get('profile/' + seller_id + '/edit', function(data) {
                $('#editProfile').modal('show');
                $('#seller_id').val(data.id);
                $('#full_name').val(data.full_name);
                $('#email').val(data.email);
                $('#phone').val(data.phone);
                $('#update_seller').attr('action', 'profile/' + data.id);
            })
        });
    });
</script>

@endsection