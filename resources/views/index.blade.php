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
                <a class="nav-link active " type="button" onclick="sortListNew()" id="new">New</a>
                <a class="nav-link active" type="button" onclick="sortListUpdate()" id="update">Update</a>
                <a class="nav-link active" type="button" onclick="sortListView()" id="view">View</a>
                <a class="nav-link active" type="button" onclick="sortListBuy()" id="buy">Buy</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row list_pro">
                @foreach ($product as $p)
                    <div data-view="{{ $p->view }}" data-buy="{{ $p->buy }}" data-new="{{ $p->created_at }}" data-update="{{ $p->updated_at }}"
                        class="sort col-md-3 mt-3">

                        <div class="card">
                            <div class="card-body">
                                <img src="{{ $p->icon_pro }}" alt="" class="img-fluid">
                                <div class="caption">
                                    <h5 class="pull-right">${{ $p->price_license }}</h5>
                                    <a href="#">{{ $p->name_pro }}</a>
                                </div>

                                <div class="space-ten">
                                    <a>View: </a><a id="{{ $p->id }}">{{ $p->view }}</a><br>
                                    <a>New: </a><a>{{ $p->created_at }}</a><br>
                                    <a>Update: </a><a>{{ $p->updated_at }}</a><br>
                                    <a>Buy: </a><a>{{ $p->buy }}</a>
                                </div>
                                <div class="btn-ground text-center">
                                    <a href="/login" class="add_to_card btn btn-primary"><i
                                            class="fa fa-shopping-cart"></i></a>
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
            var name_pro = $(this).data("name_pro");
            var description_pro = $(this).data("description_pro");
            var icon_pro = $(this).data("icon_pro");
            var price_license = $(this).data("price_license");
            document.getElementById("name_pro").innerHTML = name_pro;
            document.getElementById("description_pro").innerHTML = description_pro;
            document.getElementById("icon_pro").src = icon_pro;
            document.getElementById("price").innerHTML = "$" + price_license;
        });

        /////Product Detail//////

    </script>

    <script>
        function sortListView() {
            var $wrapper = $('.list_pro');
            $wrapper.find('.sort').sort(function(a, b) {
                    return +b.dataset.view - +a.dataset.view;
                })
                .appendTo($wrapper);
            var view = $("#view");
            view.addClass("bg-primary text-white");
            var buy = $("#buy");
            buy.removeClass("bg-primary text-white");
            var newdate = $("#new");
            newdate.removeClass("bg-primary text-white");
            var updatedate = $("#update");
            updatedate.removeClass("bg-primary text-white");
        }

        function sortListBuy() {
            var $wrapper = $('.list_pro');
            $wrapper.find('.sort').sort(function(a, b) {
                    return +b.dataset.buy - +a.dataset.buy;
                })
                .appendTo($wrapper);
            var buy = $("#buy");
            buy.addClass("bg-primary text-white");
            var view = $("#view");
            view.removeClass("bg-primary text-white");
            var newdate = $("#new");
            newdate.removeClass("bg-primary text-white");
            var updatedate = $("#update");
            updatedate.removeClass("bg-primary text-white");
        }

        function sortListNew() {
            var $wrapper = $('.list_pro');
            $wrapper.find('.sort').sort(function(a, b) {
                return new Date(b.dataset.new) - new Date(a.dataset.new);
            })
            .appendTo($wrapper);

            var newdate = $("#new");
            newdate.addClass("bg-primary text-white");
            var buy = $("#buy");
            buy.removeClass("bg-primary text-white");
            var view = $("#view");
            view.removeClass("bg-primary text-white");
            var updatedate = $("#update");
            updatedate.removeClass("bg-primary text-white");
        }
        function sortListUpdate() {
            var $wrapper = $('.list_pro');
            $wrapper.find('.sort').sort(function(a, b) {
                return new Date(b.dataset.update) - new Date(a.dataset.update);
            })
            .appendTo($wrapper);

            var updatedate = $("#update");
            updatedate.addClass("bg-primary text-white");
            var newdate = $("#new");
            newdate.removeClass("bg-primary text-white");
            var buy = $("#buy");
            buy.removeClass("bg-primary text-white");
            var view = $("#view");
            view.removeClass("bg-primary text-white");
        }

    </script>

@endsection
