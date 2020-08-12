@extends('layouts.dashboard')
@section('style')
    <!-- Custom styles for this page -->
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="/css/custom-uploadimg.css">
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
    <h1 class="h3 mb-2 text-gray-800">Product manager</h1>

    <!-- The View Product -->
    <x-detail-demo />

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-inline-flex justify-content-between align-items-center" id="test">
            <h6 class="m-0 font-weight-bold text-primary">DataTable Product</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <!-- Product table -->
                @include('components.product-table', ['products' => $products])

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

    <!-- Page level custom scripts -->
    <script src="/js/demo/datatables-demo.js"></script>
    <script>
        $('#dataTable').DataTable({
            columnDefs: [{
                    targets: 1,
                    render: function(data, type, row) {
                        return data.substr(0, 40);
                    },
                    "width": "15%"
                },
                {
                    targets: 2,
                    render: function(data, type, row) {
                        return data.substr(0, 290);
                    },
                    "width": "50%"
                },
            ]
        });

    </script>

    <script>
        customUploading('#customFile', '#uploaded_view');
        customUploading('#customFile2', '#uploaded_view2');

        $("input[type='number']").inputSpinner();

        $('tr[data-href]').on("click", function() {
            document.location = $(this).data('href');
        });

    </script>

    <script>
        /* Show product */
        $('#dataTable').on('click', '#seller_showproduct', function() {
            var pro_id = $(this).data('id');
            $.get('productmanager/' + pro_id, function(data) {
                $('#viewProduct').modal('show');
                $('#show_name').html(data.name_pro);
                $('#show_des').html(data.description_pro);
                $('#show_view').html('Views: ' + data.view);
                $('#show_price').html('<span class="fa fa-dollar-sign"></span>' + data.price_license);
                $("#show_img").attr('src',data.icon_pro);
            })
        });
    </script>
@endsection
