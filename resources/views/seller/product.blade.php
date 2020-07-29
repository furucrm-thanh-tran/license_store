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
    <x-product-detail />

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-inline-flex justify-content-between align-items-center" id="test">
            <h6 class="m-0 font-weight-bold text-primary">DataTable Product</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Release date</th>
                            <th>Recent update</th>
                            <th>Price</th>
                            <th data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Product</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Release date</th>
                            <th>Recent update</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td><img src="/img/samsung.jpg" alt=""></td>
                            <td>Máy Tính Bảng Samsung Galaxy Tab A8 8" T295 (2019)</td>
                            <td>Máy Tính Bảng Samsung Galaxy Tab A8 8" T295 (2019) sở hữu kính thước màn hình lớn đem lại
                                không gian sử dụng thoải mái. Màn hình của chiếc máy tính bảng Samsung được thiết kế theo tỷ
                                lệ 16:10 rất lý tưởng cho việc đọc sách, tạp chí, đọc báo hoặc lướt web. Đặc biệt với độ
                                phân giải 1280 x 800 pixels cho hình ảnh hiển thị chi tiết, giúp bạn thoải mái lướt web hay
                                xem phim phụ đề mà không mỏi mắt.</td>
                            <td>2011/04/25</td>
                            <td>2012/05/11</td>
                            <td>$320,800</td>
                            <td>
                                <div class="d-flex flex-nowrap">
                                    <a class="btn" href="{{ route('admin.license-key') }}"><i
                                        class="fa fa-plus"></i></a>
                                    <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                            class="fa fa-eye"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="/img/vivo.jpg" alt=""></td>
                            <td>Laptop Asus Vivobook A512DA-EJ422T AMD R5-3500U/Win10 (15.6 FHD)</td>
                            <td>Laptop Asus Vivobook A512DA-EJ422T AMD R5-3500U/Win10 (15.6 FHD) có sẵn theo nhiều màu hoàn
                                thiện khác nhau để phù hợp với phong cách của bạn. Màu Bạc trong mang đến diện mạo bóng bẩy
                                và tinh tế, hoặc hãy chọn màu Xám đá để tinh tế theo kiểu trầm lắng hơn. Bắt đầu một xu
                                hướng mới với màu Xanh lông công đổi màu đặc biệt: một lựa chọn độc đáo có thể thay đổi màu
                                sắc khi nhìn từ những góc độ khác nhau. Nếu thực sự muốn nổi bật, bạn có thể chọn màu Hồng
                                san hô với lớp hoàn thiện tươi sáng.</td>
                            <td>2011/06/11</td>
                            <td>2011/07/25</td>
                            <td>$170,750</td>
                            <td>
                                <div class="d-flex flex-nowrap">
                                    <a class="btn" href="{{ route('admin.license-key') }}"><i
                                        class="fa fa-plus"></i></a>
                                    <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                            class="fa fa-eye"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="/img/fujifilm.jpg" alt=""></td>
                            <td>Máy Ảnh Fujifilm X-T100 + Lens 15-45mm (24.2MP)</td>
                            <td>Máy Ảnh Fujifilm X-T100 + Lens 15-45mm kết hợp kiểu retro với chức năng hiện đại, có kiểu
                                dáng đẹp, cấu hình nhỏ gọn và bề ngoài tinh tế, là một máy ảnh đa năng hoàn hảo cho việc
                                chụp hằng ngày. Fujifilm X-T100 là kết hợp của ngoại hình và tính năng giữa máy ảnh Fujifilm
                                X-A5 và Fujifilm X-T20, có vẻ như đây là phiên bản tầm trung được kì vọng sẽ đáp ứng được
                                phân khúc khách hàng là những người dùng mới tiếp xúc với máy ảnh nhưng vẫn đảm bảo được
                                hiệu năng sử dụng và chất lượng ảnh.
                            </td>
                            <td>2009/01/12</td>
                            <td>2009/07/22</td>
                            <td>$86,000</td>
                            <td>
                                <div class="d-flex flex-nowrap">
                                    <a class="btn" href="{{ route('admin.license-key') }}"><i
                                        class="fa fa-plus"></i></a>
                                    <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                            class="fa fa-eye"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="/img/lg.jpg" alt=""></td>
                            <td>Tai nghe Bluetooth LG HBS-510</td>
                            <td>tai nghe Bluetooth LG HBS-510 mang thiết kế sành điệu, phù hợp với người dùng trẻ, năng
                                động, thời gian nghe nhạc và đàm thoại đáp ứng được cho cả ngày sử dụng, thích hợp cho những
                                chuyến đi xa.</td>
                            <td>2012/01/30</td>
                            <td>2012/03/29</td>
                            <td>$433,060</td>
                            <td>
                                <div class="d-flex flex-nowrap">
                                    <a class="btn" href="{{ route('admin.license-key') }}"><i
                                        class="fa fa-plus"></i></a>
                                    <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                            class="fa fa-eye"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="/img/jbl.jpg" alt=""></td>
                            <td>Loa Bluetooth JBL Pulse 4</td>
                            <td>Loa Bluetooth JBL Pulse 4 với thiết kế thay đổi đáng kể phần chân đế đã biến mất làm cho
                                loa trở nên trong suốt, tổng thể hài hòa thanh thoát hơn. Cho cảm giác loa thực sự chắc
                                chắn, một phần nữa là giúp loa được chống rung tốt hơn khi đặt trên mặt phẳng. Các nút điều
                                khiển đã được làm dày giúp dễ bấm hơn và được dời lên ở trên vòng loa và chia đều ra làm 3
                                nhóm gồm Nguồn / Bluetooth, Partyboost / Lights, Play / Volume.</td>
                            <td>2008/11/28</td>
                            <td>2009/03/30</td>
                            <td>$162,700</td>
                            <td>
                                <div class="d-flex flex-nowrap">
                                    <a class="btn" href="{{ route('admin.license-key') }}"><i
                                        class="fa fa-plus"></i></a>
                                    <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                            class="fa fa-eye"></i></button>
                                </div>
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
@endsection
