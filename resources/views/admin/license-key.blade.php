@extends('layouts.dashboard')
@section('style')
<!-- Custom styles for this page -->
<link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link href="/vendor/select2/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="/css/delete-modal.css">
<style>
    .table td,
    .table thead th,
    .table th {
        vertical-align: middle;
    }

    td:first-child,
    td:last-child {
        text-align: center
    }

    table.dataTable thead .sorting_asc {
        background: url("http://cdn.datatables.net/1.10.0/images/sort_asc.png") no-repeat center right;
    }

    table.dataTable thead .sorting_desc {
        background: url("http://cdn.datatables.net/1.10.0/images/sort_desc.png") no-repeat center right;
    }

    table.dataTable thead .sorting {
        background: url("http://cdn.datatables.net/1.10.0/images/sort_both.png") no-repeat center right;
    }

    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:before,
    table.dataTable thead .sorting_desc_disabled:after {
        display: none;
    }

    table img {
        max-width: 80px;
    }

    /* View Product */
    .product_view .modal-dialog {
        max-width: 800px
    }

    .pre-cost {
        text-decoration: line-through;
        color: #a5a5a5;
    }

    .space-ten {
        padding: 10px 0;
    }

    .product_view img {
        max-width: 100%;
        margin: auto;
    }
</style>
@endsection
@section('content')
<h1 class="h3 mb-2 text-gray-800">License key manager</h1>
<div class="col-sm-12">

    @if(session()->get('success'))
    <div class="alert alert-success" id="message-success">
        {{ session()->get('success') }}
    </div>
    @endif

</div>
<!-- The Add license key -->
<div class="modal fade" id="add-key">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add new license key</h5>
                <button onclick="return location.reload()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <form id="frmCreate" action="{{ route('license.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input id="" type="hidden" class="form-control" name="pro_id" value="{{ $id }}" readonly>
                    </div>
                    <div class="form-group">
                        <button id="create_key" type="button" class="create_key btn btn-outline-dark mb-2"><i class="fas fa-key"></i> License key</button>
                        <input id="product_key" type="text" class="key form-control @error('product-key') is-invalid @enderror" name="product_key" value="" required autocomplete="product-key" autofocus placeholder="Enter license key">

                        @error('product-key')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Choose a bill</label>
                        <select name="" id="select_bill" class="select2" style="width: 100%;" required>
                            <option value="" disabled selected>Select your option</option>
                            @foreach($bills as $bill)
                            <option>{{ $bill->bills->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="customer">Customer Name</label>
                        <input class="form-control user_name" type="text" value="" id="user_name" name="user_name" readonly>
                        <input class="form-control user_id" type="hidden" value="" id="user_id" name="user_id" readonly>
                    </div>
                    <div class="form-group">
                        <label for="seller">Seller Name</label>
                        <input class="form-control seller_name" type="text" value="" id="seller_name" name="seller_name" readonly>
                        <input class="form-control seller_id" type="hidden" value="" id="seller_id" name="seller_id" readonly>
                    </div>

                    <div class="form-group">
                        <label for="activation-date">Activation date</label>
                        <input class="form-control" type="date" value="" id="activation-date" name="activation_date" required>
                    </div>

                    <div class="form-group">
                        <label for="activation-date">Expiration date</label>
                        <input class="form-control" type="date" value="" id="expiration-date" name="expiration_date" required>
                    </div>
                </div>

                <!-- Message -->
                <div class="alert alert-danger" style="display:none"></div>
                <div class="alert alert-success" style="display:none"></div>

                <!-- Modal footer -->
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button id="btnAdd" type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- The Edit Product -->
<div class="modal fade" id="edit-key">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit key</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <form id="update_license" action="" method="POST">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <input id="id" type="hidden" class="form-control" name="id" value="" readonly>
                    <div class="form-group">
                        <label for="">License key</label>
                        <!-- <button id="create_key_edit" type="button" class="create_key btn btn-outline-dark mb-2"><i class="fas fa-key"></i> License key</button> -->
                        <input id="product_key_edit" type="text" class="key form-control @error('product_key') is-invalid @enderror" name="product_key" value="" readonly>

                        @error('product_key')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Choose a bill</label>
                        <select name="" id="select_bill_edit" class="select2" style="width: 100%;">
                            <option value="" disabled selected>Select your option</option>
                            @foreach($bills as $bill)
                            <option>{{ $bill->bills->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="customer">Customer Name</label>
                        <input class="form-control user_name" type="text" value="" id="user_name_edit" name="user_name" readonly>
                        <input class="form-control user_id" type="hidden" value="" id="user_id_edit" name="user_id" readonly>
                    </div>
                    <div class="form-group">
                        <label for="seller">Seller Name</label>
                        <input class="form-control seller_name" type="text" value="" id="seller_name_edit" name="seller_name" readonly>
                        <input class="form-control seller_id" type="hidden" value="" id="seller_id_edit" name="seller_id" readonly>
                    </div>

                    <div class="form-group">
                        <label for="activation-date-edit">Activation date</label>
                        <input class="form-control @error('activation_date') is-invalid @enderror" type="date" value="" id="activation-date-edit" name="activation_date">
                        @error('activation_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="activation-date-edit">Expiration date</label>
                        <input class="form-control @error('expiration_date') is-invalid @enderror" type="date" value="" id="expiration-date-edit" name="expiration_date">
                        @error('expiration_date')
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


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-inline-flex justify-content-between align-items-center" id="test">
        <h6 class="m-0 font-weight-bold text-primary">DataTable license key</h6>
        <div>
            <button class="btn btn-outline-dark" data-toggle="modal" data-target="#add-key"><i class="fa fa-user-plus"></i> Create license key</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>License key</th>
                        <th>Seller</th>
                        <th>Customer</th>
                        <th>Activation</th>
                        <th>Expiration</th>
                        <th data-orderable="false"></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Product ID</th>
                        <th>License key</th>
                        <th>Seller</th>
                        <th>Customer</th>
                        <th>Activation</th>
                        <th>Expiration</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($licenses as $license)
                    <tr>
                        <td>{{ $license->products->id }}</td>
                        <td>{{ $license->product_key }}</td>
                        @if ($license->seller_id != null)
                        <td>{{ $license->managers->full_name }}</td>
                        @else
                        <td>{{ $license->seller_id }}</td>
                        @endif
                        <td>{{ $license->users->full_name }}</td>
                        <td>{{ $license->activation_date }}</td>
                        <td>{{ $license->expiration_date }}</td>
                        <td>
                            <div class="d-flex flex-nowrap justify-content-center">
                                <button class="btn" type="submit" id="edit-license" data-toggle="modal" data-id="{{ $license->id }}"><i class="fa fa-edit"></i></button>
                                <form action="{{ route('license.destroy',$license->id) }}" method="POST">
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
<script src="/js/upload-img.js"></script>
<script src="/js/bootstrap-input-spinner.js"></script>
<script src="/vendor/select2/dist/js/select2.min.js"></script>

<!-- Page level custom scripts -->
<script src="/js/demo/datatables-demo.js"></script>

<script>
    $(function() {
        $('#message-success').delay(3000).fadeOut();
    });
</script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            closeOnSelect: false,
        });
    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('#btnAdd').click(function(e) {
            e.preventDefault();

            $.ajax({
                data: $('#frmCreate').serialize(),
                url: "{{ route('license.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    if (data.errors) {
                        $('.alert-danger').html('');

                        $.each(data.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-success').hide();
                            $('.alert-danger').append('<li>' + value + '</li>');
                        });
                        $('#btnAdd').html('Save Changes');
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('.alert-success').html(data.success);
                        $('#frmCreate').trigger("reset");
                        $('#btnAdd').html('Submit');
                    }
                }
            });
        });
    });
</script>

<script>
    $('.select2').change(function() {
        var bill_id = $(this).val();

        $.ajax({
            url: "/get_bill",
            type: 'GET',
            data: {
                "id": bill_id,
            },
            success: function(data) {
                $user_id = data[0].user_id;
                $seller_id = data[0].seller_id;
                $user_name = data[0].users.full_name;
                if ($seller_id != null) {
                    $sell_name = data[0].managers.full_name;
                } else {
                    $sell_name = '';
                }

                $('.seller_id').val($seller_id);
                $('.seller_name').val($sell_name);
                $('.user_id').val($user_id);
                $('.user_name').val($user_name);

                console.log($user_id + " " + $seller_id + " " + $user_name + " " + $sell_name);
            }
        });
    });
</script>

<script>
    $('.create_key').click(function() {
        $.ajax({
            url: "/create_key",
            type: 'GET',
            data: {

            },

            success: function(data) {
                $('.key').val(data);
                console.log(data);
            }
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        /* Edit License */
        $('#dataTable').on('click', '#edit-license', function() {
            var id = $(this).data('id');
            $.get(id + '/edit', function(data) {
                $('#edit-key').modal('show');
                $('#id').val(data[0].id);
                $('#product_key_edit').val(data[0].product_key);
                $('#activation-date-edit').val(data[0].activation_date);
                $('#expiration-date-edit').val(data[0].expiration_date);
                $('#user_id_edit').val(data[0].user_id);
                $('#seller_id_edit').val(data[0].seller_id);
                $('#user_name_edit').val(data[0].users.full_name);
                if (data[0].seller_id != null) {
                    $('#seller_name_edit').val(data[0].managers.full_name);
                } else {
                    $('#seller_name_edit').val(data[0].seller_id);
                }
                $('#update_license').attr('action', id);
            })
        });
    });
</script>
@endsection