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
    <h1 class="h3 mb-2 text-gray-800">Product manager</h1>

    <!-- The Create Product -->
    <div class="modal fade" id="createProduct">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Create a new product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal body -->
                <form action="test">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="product-name">Name</label>
                            <input id="product-name" type="text"
                                class="form-control @error('product-name') is-invalid @enderror" name="product-name"
                                value="{{ old('product-name') }}" required autocomplete="product-name" autofocus
                                placeholder="Enter product name">

                            @error('product-name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" type="text"
                                class="form-control @error('description') is-invalid @enderror" name="description"
                                value="{{ old('description') }}" required autocomplete="description" autofocus
                                placeholder="Enter description" rows="4"></textarea>

                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="customFile">Icon</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <div class="uploaded_file_view" id="uploaded_view">
                            <span class="file_remove">X</span>
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
    <div class="modal fade" id="editProduct">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Update product information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal body -->
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="product-name2">Name</label>
                            <input id="product-name2" type="text"
                                class="form-control @error('product-name2') is-invalid @enderror" name="product-name2"
                                value='Máy Tính Bảng Samsung Galaxy Tab A8"T295 (2019)' required
                                autocomplete="product-name2" autofocus placeholder="Enter product name">

                            @error('product-name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description2">Description</label>
                            <textarea id="description2" type="text"
                                class="form-control @error('description2') is-invalid @enderror" name="description2"
                                required autofocus placeholder="Enter description" rows="4">
                                                                Máy Tính Bảng Samsung Galaxy Tab A8" T295 (2019) sở hữu kính thước màn hình lớn đem lại
                                                                không gian sử dụng thoải mái. Màn hình của chiếc máy tính bảng Samsung được thiết kế theo tỷ
                                                                lệ 16:10 rất lý tưởng cho việc đọc sách, tạp chí, đọc báo hoặc lướt web. Đặc biệt với độ
                                                                phân giải 1280 x 800 pixels cho hình ảnh hiển thị chi tiết, giúp bạn thoải mái lướt web hay
                                                                xem phim phụ đề mà không mỏi mắt.
                                                            </textarea>

                            @error('username2')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="customFile2">Icon</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile2">
                                <label class="custom-file-label" for="customFile2">Choose file</label>
                            </div>
                        </div>
                        <div class="uploaded_file_view show" id="uploaded_view2">
                            <span class="file_remove">X</span>
                            <img src="/img/samsung.jpg" alt="">
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
    <div id="deleteProduct" class="modal fade">
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
            <h6 class="m-0 font-weight-bold text-primary">DataTable Product</h6>
            <div>
                <button class="btn btn-outline-dark" data-toggle="modal" data-target="#createProduct"><i
                        class="fa fa-user-plus"></i> Add product</button>
            </div>
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
<<<<<<< HEAD
                        <tr>
=======
                        <tr role="button" data-href="{{ route('admin.license-key') }}">
>>>>>>> 5bf8a720b1555a032eb05e87380d9ca94768856f
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
<<<<<<< HEAD
                                    <a class="btn" href="{{ route('admin.license-key') }}"><i
                                        class="fa fa-plus"></i></a>
=======
>>>>>>> 5bf8a720b1555a032eb05e87380d9ca94768856f
                                    <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                            class="fa fa-eye"></i></button>
                                    <button class="btn" data-toggle="modal" data-target="#editProduct"><i
                                            class="fa fa-edit"></i></button>
                                    <button class="btn" data-toggle="modal" data-target="#deleteProduct"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
<<<<<<< HEAD
                        <tr>
=======
                        <tr role="button" data-href="{{ route('admin.license-key') }}">
>>>>>>> 5bf8a720b1555a032eb05e87380d9ca94768856f
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
<<<<<<< HEAD
                                    <a class="btn" href="{{ route('admin.license-key') }}"><i
                                        class="fa fa-plus"></i></a>
=======
>>>>>>> 5bf8a720b1555a032eb05e87380d9ca94768856f
                                    <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                            class="fa fa-eye"></i></button>
                                    <button class="btn" data-toggle="modal" data-target="#editProduct"><i
                                            class="fa fa-edit"></i></button>
                                    <button class="btn" data-toggle="modal" data-target="#deleteProduct"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
<<<<<<< HEAD
                        <tr>
=======
                        <tr role="button" data-href="{{ route('admin.license-key') }}">
>>>>>>> 5bf8a720b1555a032eb05e87380d9ca94768856f
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
<<<<<<< HEAD
                                    <a class="btn" href="{{ route('admin.license-key') }}"><i
                                        class="fa fa-plus"></i></a>
=======
>>>>>>> 5bf8a720b1555a032eb05e87380d9ca94768856f
                                    <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                            class="fa fa-eye"></i></button>
                                    <button class="btn" data-toggle="modal" data-target="#editProduct"><i
                                            class="fa fa-edit"></i></button>
                                    <button class="btn" data-toggle="modal" data-target="#deleteProduct"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
<<<<<<< HEAD
                        <tr>
=======
                        <tr role="button" data-href="{{ route('admin.license-key') }}">
>>>>>>> 5bf8a720b1555a032eb05e87380d9ca94768856f
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
<<<<<<< HEAD
                                    <a class="btn" href="{{ route('admin.license-key') }}"><i
                                        class="fa fa-plus"></i></a>
=======
>>>>>>> 5bf8a720b1555a032eb05e87380d9ca94768856f
                                    <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                            class="fa fa-eye"></i></button>
                                    <button class="btn" data-toggle="modal" data-target="#editProduct"><i
                                            class="fa fa-edit"></i></button>
                                    <button class="btn" data-toggle="modal" data-target="#deleteProduct"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
<<<<<<< HEAD
                        <tr>
=======
                        <tr role="button" data-href="{{ route('admin.license-key') }}">
>>>>>>> 5bf8a720b1555a032eb05e87380d9ca94768856f
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
<<<<<<< HEAD
                                    <a class="btn" href="{{ route('admin.license-key') }}"><i
                                        class="fa fa-plus"></i></a>
=======
>>>>>>> 5bf8a720b1555a032eb05e87380d9ca94768856f
                                    <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                            class="fa fa-eye"></i></button>
                                    <button class="btn" data-toggle="modal" data-target="#editProduct"><i
                                            class="fa fa-edit"></i></button>
                                    <button class="btn" data-toggle="modal" data-target="#deleteProduct"><i
                                            class="fa fa-trash"></i></button>
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
                {
                    targets: 5,
                    "width": "12%"
                }
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
