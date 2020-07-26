@extends('layouts.dashboard')
@section('style')
    <!-- Custom styles for this page -->
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="/vendor/select2/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <h1 class="h3 mb-2 text-gray-800">Transaction manager</h1>

    <!-- The Assign Seller -->
    <div class="modal fade" id="assignSeller">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Assign seller</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal body -->
                <form>
                    <div class="form-group">
                        <label>Choose a seller</label>
                        <select class="select2" style="width: 100%;">
                            <option value="" disabled  selected>Select your option</option>
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
                        </select> </div> <!-- /.form-group -->

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
            <h6 class="m-0 font-weight-bold text-primary">DataTable Seller</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Code bill</th>
                            <th>Customer ID</th>
                            <th>Date of purchase</th>
                            <th>Seller</th>
                            <th>Seller email</th>
                            <th>Total money</th>
                            <th data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Code bill</th>
                            <th>Customer ID</th>
                            <th>Date of purchase</th>
                            <th>Seller</th>
                            <th>Seller email</th>
                            <th>Total money</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>2011/04/25</td>
                            <td>Edinburgh</td>
                            <td>edinburgh@gmail.com</td>
                            <td>$320,800</td>
                            <td>
                                <button class="btn btn-primary disabled" data-toggle="modal" data-target="#assignSeller"
                                    disabled>Assign</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Garrett Winters</td>
                            <td>Accountant</td>
                            <td>2011/07/25</td>
                            <td class="text-danger">Anonymous seller</td>
                            <td></td>
                            <td>$170,750</td>
                            <td>
                                <button class="btn btn-primary" data-toggle="modal"
                                    data-target="#assignSeller">Assign</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Ashton Cox</td>
                            <td>Junior Technical Author</td>
                            <td>2009/01/12</td>
                            <td>San Francisco</td>
                            <td>sanfrancisco@gmail.com</td>
                            <td>$86,000</td>
                            <td>
                                <button class="btn btn-primary disabled" data-toggle="modal" data-target="#assignSeller"
                                    disabled>Assign</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Cedric Kelly</td>
                            <td>Senior Javascript Developer</td>
                            <td>2012/03/29</td>
                            <td class="text-danger">Anonymous seller</td>
                            <td></td>
                            <td>$433,060</td>
                            <td>
                                <button class="btn btn-primary" data-toggle="modal"
                                    data-target="#assignSeller">Assign</button>
                            </td>
                        </tr>
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
    <script src="/vendor/select2/dist/js/select2.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/js/demo/datatables-demo.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                closeOnSelect: false,
            });
        });

    </script>
@endsection
