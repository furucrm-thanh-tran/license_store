@extends('layouts.dashboard')
@section('style')
<!-- Custom styles for this page -->
<link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="/css/custom-uploadimg.css">
<link rel="stylesheet" href="/css/delete-modal.css">
<link rel="stylesheet" href="/css/custom-table.css">
@endsection
@section('content')
<h1 class="h3 mb-2 text-gray-800">Product manager</h1>
@if(session()->get('success'))
<div class="alert alert-success" id="message-success">
    {{ session()->get('success') }}
</div>
@endif
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
            <form action="{{ route('product_manager.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product-name">Name</label>
                        <input id="product-name" type="text" class="form-control @error('product-name') is-invalid @enderror" name="name_pro" value="{{ old('product-name') }}" required autocomplete="product-name" autofocus placeholder="Enter product name">

                        @error('product-name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description_pro" value="{{ old('description') }}" required autocomplete="description" autofocus placeholder="Enter description" rows="4"></textarea>

                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price_license" value="{{ old('price') }}" required autocomplete="price" autofocus placeholder="Enter price license">

                        @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="customFile">Icon</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input file-upload" name="icon_pro">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <div class="text-center">
                        <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="icon img-thumbnail" alt="icon">
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
                        <input id="product-name2" type="text" class="form-control @error('product-name2') is-invalid @enderror" name="product-name2" value='Máy Tính Bảng Samsung Galaxy Tab A8"T295 (2019)' required autocomplete="product-name2" autofocus placeholder="Enter product name">

                        @error('product-name2')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description2">Description</label>
                        <textarea id="description2" type="text" class="form-control @error('description2') is-invalid @enderror" name="description2" required autofocus placeholder="Enter description" rows="4">
                                                                    Máy Tính Bảng Samsung Galaxy Tab A8" T295 (2019) sở hữu kính thước màn hình lớn đem lại
                                                                    không gian sử dụng thoải mái. Màn hình của chiếc máy tính bảng Samsung được thiết kế theo tỷ
                                                                    lệ 16:10 rất lý tưởng cho việc đọc sách, tạp chí, đọc báo hoặc lướt web. Đặc biệt với độ
                                                                    phân giải 1280 x 800 pixels cho hình ảnh hiển thị chi tiết, giúp bạn thoải mái lướt web hay
                                                                    xem phim phụ đề mà không mỏi mắt.
                                                                </textarea>

                        @error('description2')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price2">Price</label>
                        <input id="price2" type="text" class="form-control @error('price2') is-invalid @enderror" name="price_license" value="{{ old('price2') }}" required autocomplete="price2" autofocus placeholder="Enter price license">

                        @error('price2')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="customFile2">Icon</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input file-upload">
                            <label class="custom-file-label" for="customFile2">Choose file</label>
                        </div>
                    </div>
                    <div class="text-center">
                        <img src="/img/samsung.jpg" class="icon img-thumbnail" alt="icon">
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
<!-- <div id="deleteProduct" class="modal fade">
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
</div> -->

<!-- The View Product -->
<x-detail-demo />

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-inline-flex justify-content-between align-items-center" id="test">
        <h6 class="m-0 font-weight-bold text-primary">DataTable Product</h6>
        <div>
            <button class="btn btn-outline-dark" data-toggle="modal" data-target="#createProduct"><i class="fa fa-user-plus"></i> Add product</button>
        </div>
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

<script>
    $(function() {
        $('#message-success').delay(3000).fadeOut();
    });
</script>

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
    $(document).ready(function() {


        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.icon').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }


        $(".file-upload").on('change', function() {
            readURL(this);
        });
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