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
        <p class="lead"></p>
    </div>

    <div class="row">
        @foreach ($product as $p)
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <img src="fetch_icon/{{ $p->id }}" alt="" class="img-fluid">
                    <div class="caption">
                        <h4 class="pull-right">${{$p->price_license}}</h4>
                        <h4><a href="#">{{$p->name_pro}}</a></h4>
                    </div>
                    <p>
                        (15 reviews)
                    </p>
                    <div class="space-ten"></div>
                    <div class="btn-ground text-center">
                        <a class="add_to_card btn btn-primary"
                        id="card_add"
                        href="/login"

                        ><i class="fa fa-shopping-cart"></i> Add To
                            Cart</a>
                        <button class="btn btn-primary" data-toggle="modal"
                                                        data-price="{{$p->price_license}}"
                                                        data-name="{{$p->name_pro}}"
                                                        data-description="{{$p->description_pro}}"
                                                        data-target="#viewProduct"><i
                                class="fa fa-search"></i> Quick View</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endsection

    @section('script')

    <script>
        $(".add_to_card").click(function(){
            var id = $(this).data("id");
            var name = $(this).data("name");
            var price = $(this).data("price");
            var qty = $(this).data("qty");
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            $.ajax(
            {
                url: "cart/add/"+id+"/"+name+"/"+qty+"/"+price,
                type: 'POST',
                data: {
                    "id": id,
                    "name": name,
                    "price":price,
                    "qty":qty
                },
                success: function (data)
                {
                    console.log("it Work");

                }
            });
            console.log(id,token);
        });
    </script>

    @endsection
