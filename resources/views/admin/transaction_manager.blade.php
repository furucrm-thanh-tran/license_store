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
                            <option value="" disabled selected>Select your option</option>
                            <optgroup label="Người bán được nhiều license nhất">
                                @foreach ($sellers_best as $seller)
                                    <option>{{ $seller->managers->full_name }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Người có thời gian làm việc lâu nhất">
                                @foreach ($sellers_long as $seller)
                                    <option>{{ $seller->full_name }}</option>
                                @endforeach
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
            {{ $sellers_best }}
            <div class="table-responsive">
                <!-- Transaction table -->
                @include('components.transaction-table', ['transactions' => $transactions])
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

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                closeOnSelect: false,
            });
        });

    </script>
@endsection
