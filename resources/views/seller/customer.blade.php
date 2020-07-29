@extends('layouts.dashboard')
@section('style')
    <!-- Custom styles for this page -->
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="/css/custom-table.css">
@endsection
@section('content')
    <h1 class="h3 mb-2 text-gray-800">Customer manager</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-inline-flex justify-content-between align-items-center" id="test">
            <h6 class="m-0 font-weight-bold text-primary">DataTable Customer</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Bills</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Customer</th>
                            <th>Bills</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>61</td>
                            <td>systemarchitect@gmail.com</td>
                            <td>20110425</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-envelope"></i></button>
                                <a href="{{ route('seller.bill') }}" class="btn"><i class="fas fa-arrow-right"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Garrett Winters</td>
                            <td>63</td>
                            <td>accountant@gmail.com</td>
                            <td>20110725</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-envelope"></i></button>
                                <a href="{{ route('seller.bill') }}" class="btn"><i class="fas fa-arrow-right"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Ashton Cox</td>
                            <td>66</td>
                            <td>juniortechnicalauthor@gmail.com</td>
                            <td>20090112</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-envelope"></i></button>
                                <a href="{{ route('seller.bill') }}" class="btn"><i class="fas fa-arrow-right"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Cedric Kelly</td>
                            <td>22</td>
                            <td>seniorjavascriptdeveloper@gmail.com</td>
                            <td>20120329</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-envelope"></i></button>
                                <a href="{{ route('seller.bill') }}" class="btn"><i class="fas fa-arrow-right"></i></a>
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

    <!-- Page level custom scripts -->
    <script src="/js/demo/datatables-demo.js"></script>
@endsection
