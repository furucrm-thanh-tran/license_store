@extends('layouts.dashboard')
@section('style')
<!-- Custom styles for this page -->
<link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<style>
    .table td {
        vertical-align: middle;
    }

    td:last-child {
        text-align: center
    }

    /* Delete modal */
    .modal-confirm {
        color: #636363;
        width: 400px;
    }

    .modal-confirm .modal-content {
        padding: 20px;
        border-radius: 5px;
        border: none;
        text-align: center;
        font-size: 14px;
    }

    .modal-confirm .modal-header {
        border-bottom: none;
        position: relative;
    }

    .modal-confirm h4 {
        text-align: center;
        font-size: 26px;
        margin: 30px 0 -10px;
    }

    .modal-confirm .close {
        position: absolute;
        top: -5px;
        right: -2px;
    }

    .modal-confirm .modal-body {
        color: #999;
    }

    .modal-confirm .modal-footer {
        border: none;
        text-align: center;
        border-radius: 5px;
        font-size: 13px;
        padding: 10px 15px 25px;
    }

    .modal-confirm .modal-footer a {
        color: #999;
    }

    .modal-confirm .icon-box {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        border-radius: 50%;
        z-index: 9;
        text-align: center;
        border: 3px solid #f15e5e;
    }

    .modal-confirm .icon-box i {
        color: #f15e5e;
        font-size: 46px;
        display: inline-block;
        margin-top: 13px;
    }

    .modal-confirm .btn,
    .modal-confirm .btn:active {
        color: #fff;
        border-radius: 4px;
        background: #60c7c1;
        text-decoration: none;
        transition: all 0.4s;
        line-height: normal;
        min-width: 120px;
        border: none;
        min-height: 40px;
        border-radius: 3px;
        margin: 0 5px;
    }

    .modal-confirm .btn-secondary {
        background: #c1c1c1;
    }

    .modal-confirm .btn-secondary:hover,
    .modal-confirm .btn-secondary:focus {
        background: #a8a8a8;
    }

    .modal-confirm .btn-danger {
        background: #f15e5e;
    }

    .modal-confirm .btn-danger:hover,
    .modal-confirm .btn-danger:focus {
        background: #ee3535;
    }

    .trigger-btn {
        display: inline-block;
        margin: 100px auto;
    }
</style>
@endsection
@section('content')
<h1 class="h3 mb-2 text-gray-800">Seller manager</h1>
<div class="col-sm-12">

    @if(session()->get('success'))
    <div class="alert alert-success" id="message-success">
        {{ session()->get('success') }}
    </div>
    @endif
</div>
<!-- The Create Seller -->
<div class="modal fade" id="createSeller">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Create new seller account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <form action="{{ route('seller_manager.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Full name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="full_name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter full name">

                        @error('full_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="user_name" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Enter username">

                        @error('user_name')
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
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password">
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

<!-- The Edit Seller -->
<div class="modal fade" id="editSeller">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Update Seller Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <form id="update_seller" action="" method="POST">
                <input type="hidden" name="seller_id" id="seller_id" disabled>
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Full name</label>
                        <input id="edit_name" type="text" class=" form-control @error('name') is-invalid @enderror" name="full_name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter full name">

                        @error('full_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input id="edit_email" type="email" class=" form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone number</label>
                        <input id="edit_phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" placeholder="Enter phone number">
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

<!-- The Delete Seller -->
<!-- <div id="deleteSeller" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header flex-column">
                <div class="icon-box">
                    <i class="material-icons">&#xE5CD;</i>
                </div>
                <h4 class="modal-title w-100">Are you sure?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="delete_seller" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div> -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-inline-flex justify-content-between align-items-center" id="test">
        <h6 class="m-0 font-weight-bold text-primary">DataTable Seller</h6>
        <div>
            <button class="btn btn-outline-dark" data-toggle="modal" data-target="#createSeller"><i class="fa fa-user-plus"></i> Create seller</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th data-orderable="false"></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($sellermanagers as $sellermanager)
                    <tr>
                        <td>{{$sellermanager->id}}</td>
                        <td>{{$sellermanager->user_name}}</td>
                        <td>{{$sellermanager->full_name}}</td>
                        <td>{{$sellermanager->email}}</td>
                        <td>{{$sellermanager->phone}}</td>
                        <td>
                            <div class="d-flex flex-nowrap justify-content-center">
                                <button class="btn" id="edit-seller" data-toggle="modal" data-id="{{ $sellermanager->id }}"><i class="fa fa-edit"></i></button>
                                <!-- <a href="javascript:void(0)" class="btn" id="edit-seller-a" data-toggle="modal" data-id="{{ $sellermanager->id }}"><i class="fa fa-edit"></i></a> -->
                                <form action="{{ route('seller_manager.destroy',$sellermanager->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn" type="submit" data-toggle="modal" onclick="return confirm('Are you sure ????');"><i class="fa fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- Page level plugins -->
<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="/js/demo/datatables-demo.js"></script>

<script>
    $(function() {
        $('#message-success').delay(3000).fadeOut();
    });
</script>

<script type="text/javascript">
    $(function() {
        /* Edit seller */
        $('#dataTable').on('click', '#edit-seller', function() {
            var seller_id = $(this).data('id');
            $.get('seller_manager/' + seller_id + '/edit', function(data) {
                // $('#btn-save').prop('disabled', false);
                $('#editSeller').modal('show');
                $('#seller_id').val(data.id);
                $('#edit_name').val(data.full_name);
                $('#edit_email').val(data.email);
                $('#edit_phone').val(data.phone);
                // $('#update_seller').attr('action', 'seller_manager/' +data.id +'/update');
                $('#update_seller').attr('action', 'seller_manager/' + data.id);
            })
        });
    });
</script>

@endsection