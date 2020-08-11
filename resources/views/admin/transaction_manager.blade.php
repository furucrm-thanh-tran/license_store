@extends('layouts.dashboard')
@section('style')
    <!-- Custom styles for this page -->
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="/vendor/select2/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <h1 class="h3 mb-2 text-gray-800">Transaction manager</h1>

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
    <script src="/js/demo/datatables-demo.js"></script>

    <!-- Page level custom scripts -->


    <script>
        $(document).ready(function() {
            $('.select2').select2({
                closeOnSelect: false,
            });
        });

    </script>


    <script src="{{ asset('js/vue.js') }}" defer></script>

    <script type="text/javascript">
        $(function() {
            /* Edit product */
            $('#dataTable').on('click', '#assign-seller', function() {
                var bill_id = $(this).data('id');
                $('#assignSeller').modal('show');
                $('#title').html(bill_id);
                $('#update_bill').attr('action', 'transactionmanager/' + bill_id);
            });
        });

    </script>

@endsection
