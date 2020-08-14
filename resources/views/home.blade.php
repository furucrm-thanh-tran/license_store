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

        .test {
            background-color: #007bff;
            color: white;
        }

    </style>
@endsection
@section('title') License Store @endsection
@section('content')
    <x-product-detail />
    <div class="row">
        <div class="col-md-3">
            <div class="osahan-account-page-left shadow-sm bg-white h-100">
                <a class="nav-link active" id="all" href="/home">All</a>
                <a class="nav-link active" id="new" href="/home_new">New</a>
                <a class="nav-link active" id="update" href="/home_update">Update</a>
                <a class="nav-link active" id="view" href="/home_view">View</a>
                <a class="nav-link active" id="buy" href="/home_buy">Buy</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                @foreach ($product as $p)
                    <div class="col-md-3 mt-3">

                        <div class="card">
                            <div class="card-body">
                                <img src="{{ $p->icon_pro }}" alt="" class="img-fluid">
                                <div class="caption">
                                    <h5 class="pull-right">${{ $p->price_license }}</h5>
                                    <a href="#">{{ $p->name_pro }}</a>
                                </div>

                                <div class="space-ten">
                                    <a>View: </a><a id="{{ $p->id }}">{{ $p->view }}</a>
                                </div>
                                <div class="btn-ground text-center">
                                    <button class="add_to_card btn btn-primary" id="card_add" data-id="{{ $p->id }}"
                                        data-price="{{ $p->price_license }}" data-name="{{ $p->name_pro }}" data-qty="1"><i
                                            class="fa fa-shopping-cart"></i></button>
                                            <button name="{{ $p->id }}" class="btn btn-primary btn-view" data-toggle="modal"
                                                data-target="#viewProduct" data-view="{{ $p->view }}" data-id="{{ $p->id }}"
                                                data-name_pro="{{ $p->name_pro }}" data-description_pro="{{ $p->description_pro }}"
                                                data-icon_pro="{{ $p->icon_pro }}" data-price_license="{{ $p->price_license }}">
                                                <i class="fa fa-search"></i>
                                            </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        $(".add_to_card").click(function() {
            var id = $(this).data("id");
            var name = $(this).data("name");
            var price = $(this).data("price");
            var qty = $(this).data("qty");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "cart/add/" + id + "/" + name + "/" + qty + "/" + price,
                type: 'POST',
                data: {
                    "id": id,
                    "name": name,
                    "price": price,
                    "qty": qty
                },
                success: function(data) {
                    console.log("it Work");
                }
            });
            console.log(id, token);
        });

        // ADD View//////////
        $(".btn-view").click(function() {
            var id = $(this).data("id");
            $.ajax({
                url: "/insert_view/" + id,
                type: "GET",
                data: {
                    "id": id,
                },
                success: function(data) {
                    console.log(data);
                    document.getElementById(id).innerHTML = data;
                }
            });
            var name_pro = $(this).data("name_pro");
            var description_pro = $(this).data("description_pro");
            var icon_pro = $(this).data("icon_pro");
            var price_license = $(this).data("price_license");
            document.getElementById("name_pro").innerHTML = name_pro;
            document.getElementById("description_pro").innerHTML = description_pro;
            document.getElementById("icon_pro").src = icon_pro;
            document.getElementById("price").innerHTML = "$"+price_license ;
        });


    </script>

@endsection
