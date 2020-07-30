@extends('layouts.master')
@section('style')
    <style>
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
@section('title') License Store @endsection
@section('content')
    <x-product-detail />
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Pricing</h1>
        <p class="lead">Quickly build an effective pricing table for your potential customers with this Bootstrap
            example. It's built with default Bootstrap components and utilities with little customization.</p>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <img src="img/samsung.jpg" alt="" class="img-fluid">
                    <div class="caption">
                        <h4 class="pull-right">$700.99</h4>
                        <h4><a href="#">Mobile Product</a></h4>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                            the
                            industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                            type
                            and scrambled it to make a type specimen book.</p>
                    </div>
                    <p>
                        (15 reviews)
                    </p>
                    <div class="space-ten"></div>
                    <div class="btn-ground text-center">
                        <button type="button" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Add To
                            Cart</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewProduct"><i
                                class="fa fa-search"></i> Quick View</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <img src="img/samsung.jpg" alt="" class="img-fluid">
                    <div class="caption">
                        <h4 class="pull-right">$700.99</h4>
                        <h4><a href="#">Mobile Product</a></h4>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                            the
                            industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                            type
                            and scrambled it to make a type specimen book.</p>
                    </div>
                    <p>
                        (15 reviews)
                    </p>
                    <div class="space-ten"></div>
                    <div class="btn-ground text-center">
                        <button type="button" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Add To
                            Cart</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewProduct"><i
                                class="fa fa-search"></i> Quick View</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <img src="img/samsung.jpg" alt="" class="img-fluid">
                    <div class="caption">
                        <h4 class="pull-right">$700.99</h4>
                        <h4><a href="#">Mobile Product</a></h4>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                            the
                            industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                            type
                            and scrambled it to make a type specimen book.</p>
                    </div>
                    <p>
                        (15 reviews)
                    </p>
                    <div class="space-ten"></div>
                    <div class="btn-ground text-center">
                        <button type="button" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Add To
                            Cart</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewProduct"><i
                                class="fa fa-search"></i> Quick View</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('script')
        <script src="/js/bootstrap-input-spinner.js"></script>
        <script>
            $("input[type='number']").inputSpinner();

            $('tr[data-href]').on("click", function() {
                document.location = $(this).data('href');
            });
        </script>
    @endsection
