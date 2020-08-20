@extends('layouts.dashboard')
@section('style')
<!-- Custom styles for this page -->
<link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="/css/custom-table.css">

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
<h1 class="h3 mb-2 text-gray-800">Feedback manager</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-inline-flex justify-content-between align-items-center" id="test">
        <h6 class="m-0 font-weight-bold text-primary">Question & Answer</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Title</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th data-orderable="false"></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Title</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($feedbacks as $feedback)
                    <tr>
                        <td>{{ $feedback->id }}</td>
                        <td>{{ $feedback->users->full_name }}</td>
                        <td>{{ $feedback->title }}</td>
                        <td>{{ $feedback->description }}</td>
                        <td>{{ $feedback->answer }}</td>
                        <td>{{ $feedback->created_at }}</td>
                        <td>{{ $feedback->updated_at }}</td>
                        @if($feedback->status == 1)
                        <td>
                            <button class="btn" disabled><i class="fas fa-paper-plane text-mute"></i></button>
                        </td>
                        @else
                        <td>
                            <button id="btnEdit" type="submit" class="btn" data-id="{{ $feedback->id }}"><i class="fas fa-paper-plane text-success"></i></button>
                        </td>
                        @endif

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="UpdateFeedback">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Update Feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <form id="update" action="" method="POST">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input id="title" type="text" class=" form-control" name="title" readonly>
                    </div>

                    <div class="form-group">
                        <label for="answer">Answer</label>
                        <textarea id="answer" type="text" class="form-control @error('answer') is-invalid @enderror" name="answer" required autofocus placeholder="Enter answer" rows="4"></textarea>
                        @error('answer')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer border-top-0 d-flex justify-content-center">
                        <button id="btnUpdate" type="submit" class="btn btn-success">Submit</button>
                    </div>
            </form>
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

<script type="text/javascript">
    $(function() {
        /* Edit */
        $('#dataTable').on('click', '#btnEdit', function() {
            var id = $(this).data('id');
            $.get('feedback/' + id + '/edit', function(data) {
                $('#UpdateFeedback').modal('show');
                $('#title').val(data.title);
                $('#update').attr('action', 'feedback/' + id);
            })
        });
    });
</script>
@endsection