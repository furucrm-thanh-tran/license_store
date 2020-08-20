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
    <div class="form-inline bg-white p-3 mb-3">
        <div class="form-inline col-sm-6">
            <span>Sort by:</span>
            <select class="form-control w-auto ml-2" name="" id="" onchange="sortList(value);" value="1">
                <option value="1" selected disabled hidden>Select...</option>
                <option value="new.date">New</option>
                <option value="update.date">Update</option>
                <option value="view">View</option>
                <option value="buy">Buy</option>
            </select>
        </div>

        <div class="form-group col-sm-6 my-2 justify-content-end">
            <input type="search" id="search" onkeyup="filtedList()" value="" class="form-control"
                placeholder="Search name...">
        </div>
    </div>
    <div class="row list_pro">
        @foreach ($product as $p)
            <div data-name="{{ $p->name_pro }}" data-view="{{ $p->view }}" data-buy="{{ $p->buy }}"
                data-new="{{ $p->created_at }}" data-update="{{ $p->updated_at }}" class="sort col-lg-4 mb-3">

                <div class="card">
                    <div class="card-body">
                        <img src="{{ $p->icon_pro }}" alt="" class="mx-auto d-block img-thumbnail img-fluid"  style="width:100%">
                        <div class="caption mt-3">
                            <h5 class="pull-right">${{ $p->price_license }}</h5>
                            <h4>{{ $p->name_pro }}</h6>
                                <div class="mt-3">
                                    <div class="d-flex flex-nowrap">
                                        <div><i class="fa fa-eye"></i> <span id="{{ $p->id }}">{{ $p->view }}</span></div>
                                        <div class="ml-3"><span><i class="fas fa-user-tag"></i>
                                                @if ($p->buy)
                                                    {{ $p->buy }}
                                                @else
                                                    0
                                                @endif
                                                purchase
                                            </span></div>
                                    </div>

                                    <div>Created: </a><a>{{ $p->created_at }}</div>
                                    <div>Updated: </a><a>{{ $p->updated_at }}</div>
                                </div>
                        </div>
                        <div class="mt-3 text-center">
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
<a class="cart-btn btn-success text-white" href="/shoppingcart"><i class="fa fa-shopping-cart "></i> <span class="badge badge-light" id="cart_count">{{Cart::count()}}</span></a>
@endsection

@section('script')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // ADD View//////////
        $(".btn-view").click(function() {
            var id = $(this).data("id");
            $.ajax({
                url: "/insert_view",
                type: "GET",
                data: {
                    "id": id,
                },
                success: function(data) {
                    console.log(data);
                    document.getElementById(id).innerHTML = data;
                }
            });
            console.log(id);
            var name_pro = $(this).data("name_pro");
            var description_pro = $(this).data("description_pro");
            var icon_pro = $(this).data("icon_pro");
            var price_license = $(this).data("price_license");
            document.getElementById("name_pro").innerHTML = name_pro;
            document.getElementById("description_pro").innerHTML = description_pro;
            document.getElementById("icon_pro").src = icon_pro;
            document.getElementById("price").innerHTML = "$" + price_license;
        });

        $(".add_to_card").click(function() {
            var id = $(this).data("id");
            var name = $(this).data("name");
            var price = $(this).data("price");
            var qty = $(this).data("qty");
            $.ajax({
                url: "cart/add",
                type: 'POST',
                data: {
                    "id": id,
                    "name": name,
                    "price": price,
                    "qty": qty
                },
                success: function(data) {
                    console.log(data.id + " " + data.name + " " + data.price + " " + data.qty+" "+data.cart_count);
                    document.getElementById("cart_count").innerHTML =data.cart_count;
                }

            });
        });

        /////Product Detail//////

    </script>

    <script>
        function sortList(col) {
            colv = col.split(".");
            var $wrapper = $('.list_pro');
            $wrapper.find('.sort').sort(function(a, b) {
                    if (col.indexOf(".") < 0) {
                        console.log(b.dataset[col])
                        return +b.dataset[col] - +a.dataset[col];
                    } else {
                        // console.log(new Date(b.dataset['update']));
                        return new Date(b.dataset[colv[0]]) - new Date(a.dataset[colv[0]])

                    }
                })
                .appendTo($wrapper);
        }

        function filtedList() {
            var value = $("#search").val().trim().toLowerCase();
            $(".list_pro .sort").filter(function() {
                $(this).toggle($(this).data("name").toLowerCase().indexOf(value) > -1)
            });
        };

    </script>

@endsection
