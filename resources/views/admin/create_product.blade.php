@extends('layouts.dashboard')
@section('style')

@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">{{ __('Update Seller Information') }}</div>

            <form id="frmCreate" action="{{ route('product_manager.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="product-name">Name</label>
                        <input id="product-name" type="text" class="form-control @error('name_pro') is-invalid @enderror" name="name_pro" value="{{ old('product-name') }}" required autocomplete="product-name" autofocus placeholder="Enter product name">

                        @error('name_pro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" type="text" class="form-control @error('description_pro') is-invalid @enderror" name="description_pro" value="{{ old('description') }}" required autocomplete="description" autofocus placeholder="Enter description" rows="4"></textarea>

                        @error('description_pro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input id="price" type="text" class="form-control @error('price_license') is-invalid @enderror" name="price_license" value="{{ old('price') }}" required autocomplete="price" autofocus placeholder="Enter price license">

                        @error('price_license')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="customFile">Icon</label>
                        <div class="custom-file">
                            <input id="icon_pro" type="file" class="custom-file-input file-upload @error('icon_pro') is-invalid @enderror" name="icon_pro">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                            @error('icon_pro')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="text-center">
                        <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="icon img-thumbnail" alt="icon">
                    </div>
                </div>
                <!-- Footer -->
                <div class="card-footer border-top-0 d-flex justify-content-center">
                    <button id="btnAdd" type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
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
@endsection