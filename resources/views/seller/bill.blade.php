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
</style>
@endsection
@section('content')
<h1 class="h3 mb-2 text-gray-800">Bill manager</h1>

<!-- The Assign Seller -->
<div class="modal fade" id="assignSeller" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Are you sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to do this?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary">Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-inline-flex justify-content-between align-items-center" id="test">
        <h6 class="m-0 font-weight-bold text-primary">DataTable Bill</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Code bill</th>
                        <th>Customer Name</th>                        
                        <th>Seller</th>
                        <th>Total money</th>
                        <th>Date of purchase</th>
                        <th>Process</th>                        
                        <th data-orderable="false"></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Code bill</th>
                        <th>Customer Name</th>                        
                        <th>Seller</th>
                        <th>Total money</th>
                        <th>Date of purchase</th>
                        <th>Process</th>                        
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($bills as $bill)
                    <tr>
                        <td>{{ $bill->id }}</td>
                        <td>{{ $bill->users->full_name }}</td>                        
                        <td>{{ $bill->managers->full_name }}</td>
                        <td>{{ $bill->total_money }}</td>
                        <td>{{ $bill->created_at }}</td>
                        @if($bill->status == 1)
                        <td><span class="text-success">Complete</span></td>
                        <td>
                            <button class="btn" disabled><i class="fa fa-check text-mute"></i></button>
                            <a href="{{ route('seller.bill-detail', $bill->id) }}" class="btn"><i class="fas fa-info text-info"></i></a>
                        </td>
                        @else
                        <td><span class="text-warning">Pending...</span></td>
                        <td>
                            <a href="{{ route('customermanager.show', $bill->id) }}" class="btn"  onclick="return confirm('Are you sure ????');"><i class="fa fa-check text-success"></i></a>
                            <a href="{{ route('seller.bill-detail', $bill->id) }}" class="btn"><i class="fas fa-info text-info"></i></a>
                        </td>
                        @endif
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