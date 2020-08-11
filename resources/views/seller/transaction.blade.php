@extends('layouts.dashboard')
@section('style')
    <!-- Custom styles for this page -->
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="/vendor/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/custom-table.css">

@endsection
@section('content')
    <h1 class="h3 mb-2 text-gray-800">Transaction manager</h1>

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
            <h6 class="m-0 font-weight-bold text-primary">DataTable Seller</h6>
        </div>
        <div class="card-body">
            {{-- {{ $sellers_best }} --}}
            <div class="table-responsive">
                <!-- Transaction table -->
                <transaction-manager></transaction-manager>
                {{--
                <x-transaction-table /> --}}
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

    <script src="{{ asset('js/vue.js') }}" defer></script>

@endsection
