@extends('layouts.dashboard')
@section('style')
    <!-- Custom styles for this page -->
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="/vendor/select2/dist/css/select2.min.css" rel="stylesheet" />
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

    <!-- The Add license key -->
    <div class="modal fade" id="add-key">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Add new license key</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal body -->
                <form action="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="license-key">License key</label>
                            <input id="license-key" type="text"
                                class="form-control @error('license-key') is-invalid @enderror" name="license-key"
                                value="{{ old('license-key') }}" required autocomplete="license-key" autofocus
                                placeholder="Enter license key">

                            @error('license-key')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Choose a seller</label>
                            <select class="select2" style="width: 100%;">
                                <option value="" disabled selected>Select your option</option>
                                <optgroup label="Người bán được nhiều đơn nhất">
                                    <option>Alabama</option>
                                    <option>Alaska</option>
                                    <option>California</option>
                                    <option>Delaware</option>
                                    <option>Tennessee</option>
                                    <option>Texas</option>
                                    <option>Washington</option>
                                </optgroup>
                                <optgroup label="Người có doanh thu cao nhất">
                                    <option>Alaska</option>
                                    <option>California</option>
                                    <option>Delaware</option>
                                    <option>Tennessee</option>
                                    <option>Texas</option>
                                    <option>Washington</option>
                                </optgroup>
                            </select>
                        </div> <!-- /.form-group -->
                        <div class="form-group">
                            <label for="customer">Customer</label>
                            <input id="customer" type="text" class="form-control @error('customer') is-invalid @enderror"
                                name="customer" value="{{ old('customer') }}" required autocomplete="customer" autofocus
                                placeholder="Enter customer">

                            @error('customer')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="activation-date">Activation date</label>
                            <input class="form-control" type="date" value="" id="activation-date">
                        </div>

                        <div class="form-group">
                            <label for="activation-date">Expiration date</label>
                            <input class="form-control" type="date" value="" id="expiration-date">
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
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="license-key">License key</label>
                            <input id="license-key" type="text"
                                class="form-control @error('license-key') is-invalid @enderror" name="license-key"
                                value="{{ old('license-key') }}" required autocomplete="license-key" autofocus
                                placeholder="Enter license key">

                            @error('license-key')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Choose a seller</label>
                            <select class="select2" style="width: 100%;">
                                <option value="" disabled selected>Select your option</option>
                                <optgroup label="Người bán được nhiều license nhất">
                                    <option>Alabama</option>
                                    <option>Alaska</option>
                                    <option>California</option>
                                    <option>Delaware</option>
                                    <option>Tennessee</option>
                                    <option>Texas</option>
                                    <option>Washington</option>
                                </optgroup>
                                <optgroup label="Người có thời gian làm việc lâu nhất">
                                    <option>Alaska</option>
                                    <option>California</option>
                                    <option>Delaware</option>
                                    <option>Tennessee</option>
                                    <option>Texas</option>
                                    <option>Washington</option>
                                </optgroup>
                            </select>
                        </div> <!-- /.form-group -->
                        <div class="form-group">
                            <label for="customer">Customer</label>
                            <input id="customer" type="text" class="form-control @error('customer') is-invalid @enderror"
                                name="customer" value="{{ old('customer') }}" required autocomplete="customer" autofocus
                                placeholder="Enter customer">

                            @error('customer')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="activation-date">Activation date</label>
                            <input class="form-control" type="date" value="" id="activation-date">
                        </div>

                        <div class="form-group">
                            <label for="activation-date">Expiration date</label>
                            <input class="form-control" type="date" value="" id="expiration-date">
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

    <!-- The Delete Product -->
    <div id="delete-key" class="modal fade">
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
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The View Product -->
    <x-product-detail />

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-inline-flex justify-content-between align-items-center" id="test">
            <h6 class="m-0 font-weight-bold text-primary">DataTable license key</h6>
            <div>
                <button class="btn btn-outline-dark" data-toggle="modal" data-target="#add-key"><i
                        class="fa fa-user-plus"></i> Create seller</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
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
                            <th>Title</th>
                            <th>License key</th>
                            <th>Seller</th>
                            <th>Customer</th>
                            <th>Activation</th>
                            <th>Expiration</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td>Máy Tính Bảng Samsung Galaxy Tab A8 8" T295 (2019)</td>
                            <td>78B47-A5373-8C4A7-FB57A</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>2011/04/25</td>
                            <td>2011/04/25</td>
                            <td>
                                <div>
                                    <button class="btn" data-toggle="modal" data-target="#edit-key"><i
                                            class="fa fa-edit"></i></button>
                                    <button class="btn" data-toggle="modal" data-target="#delete-key"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Máy Tính Bảng Samsung Galaxy Tab A8 8" T295 (2019)</td>
                            <td>FB4WR-32 NVD-4 RW79-XQFWH-CYQG3</td>
                            <td>Accountant</td>
                            <td>Tokyo</td>
                            <td>2011/07/25</td>
                            <td>2011/07/25</td>
                            <td>
                                <div>
                                    <button class="btn" data-toggle="modal" data-target="#edit-key"><i
                                            class="fa fa-edit"></i></button>
                                    <button class="btn" data-toggle="modal" data-target="#delete-key"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Máy Tính Bảng Samsung Galaxy Tab A8 8" T295 (2019)</td>
                            <td>GNBB8-YVD74-QJHX6- 27 H4K-8 QHDG</td>
                            <td>Junior Technical Author</td>
                            <td>San Francisco</td>
                            <td>2009/01/12</td>
                            <td>2009/01/12</td>
                            <td>
                                <div>
                                    <button class="btn" data-toggle="modal" data-target="#edit-key"><i
                                            class="fa fa-edit"></i></button>
                                    <button class="btn" data-toggle="modal" data-target="#delete-key"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Máy Tính Bảng Samsung Galaxy Tab A8 8" T295 (2019)</td>
                            <td>NG4HW-VH26C-733 KW-K6F98-J8CK4</td>
                            <td>Senior Javascript Developer</td>
                            <td>Edinburgh</td>
                            <td>2012/03/29</td>
                            <td>2012/03/29</td>
                            <td>
                                <div>
                                    <button class="btn" data-toggle="modal" data-target="#edit-key"><i
                                            class="fa fa-edit"></i></button>
                                    <button class="btn" data-toggle="modal" data-target="#delete-key"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
            $('#dataTable').DataTable({
                columnDefs: [{
                    targets: 0,
                    render: function(data, type, row) {
                        return data.substr(0, 40);
                    },
                    "width": "15%"
                }, ]
            });

        </script>


        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    closeOnSelect: false,
                });
            });

        </script>
    @endsection
