@extends('layouts.dashboard')
@section('style')

@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">{{ __('Update Product Information') }}</div>

            <form id="update_product" action="{{ route('product_manager.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <!-- Card body -->
                <div class="card-body">
                    <div class="form-group">
                        <label for="product-name2">Name</label>
                        <input id="pro_edit" type="text" class="form-control @error('name_pro') is-invalid @enderror" name="name_pro" value="{{ $product->name_pro }}" required autocomplete="product-name2" autofocus placeholder="Enter product name">

                        @error('name_pro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description2">Description</label>
                        <textarea id="des_edit" type="text" class="form-control @error('description_pro') is-invalid @enderror" name="description_pro" required autofocus placeholder="Enter description" rows="4">{{ $product->description_pro }}</textarea>

                        @error('description_pro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price2">Price</label>
                        <input id="price_edit" type="text" class="form-control @error('price_license') is-invalid @enderror" name="price_license" value="{{ $product->price_license }}" required autocomplete="price2" autofocus placeholder="Enter price license">

                        @error('price_license')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="customFile2">Icon</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input file-upload @error('icon_pro') is-invalid @enderror" name="icon_pro">
                            <label class="custom-file-label" for="customFile2">Choose file</label>
                            @error('icon_pro')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="text-center">
                        <img id="img_pro" src="{{ $product->icon_pro }}" class="icon img-thumbnail" alt="icon">
                    </div>
                </div>

                <!--Card Footer -->
                <div class="card-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success">Submit</button>
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