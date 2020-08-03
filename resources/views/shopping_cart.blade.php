@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row">
      <div class=" col-md-9 col-md-offset-1">
        <div class="osahan-account-page-right shadow-sm bg-white p-4 h-100">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                    <h4 class="font-weight-bold mt-0 mb-4">Product</h4>
                    <div class="row">
                        <table  class="table table-borderless">
                            <thead>
                              <tr>
                                <th>Name</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Line Total</th>
                                <th>Option</th>
                              </tr>
                            </thead>
                            <tbody id="cart_product">
                            @foreach(Cart::content() as $row)
                                <tr>
                                <td class="pro_id" data-id="{{$row->id}}"><?php echo $row->name; ?></td>
                                <td>
                                    <input data-qty="{{$row->qty}}" class="qty" type="number" min="0" onfocus="focusFunction()" value="<?php echo $row->qty; ?>"/>
                                </td>
                                <td class="price" data-price="{{$row->price}}">$<?php echo $row->price; ?></td>
                                <td class="subtotal" data-subtotal="{{$row->subtotal}}">$<?php echo $row->subtotal; ?></td>
                                <td>
                                    <a class="remove_item" type="button" data-id="{{$row->rowId}}"><i class="fa fa-trash " aria-hidden="true"></i></a>
                                </td>
                                </tr>
                            @endforeach
                            </tbody>
                          </table>
                          @if (Session::has('erorr2'))
                                    <div class="alert alert-danger alert-dismissible col-12">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Erorr!!</strong>{{ Session::get('erorr2') }}
                                    </div>
                        @endif
                    </div>
                    <div class="row hidden" style="display: none" >
                        <button type="submit" class="get_item btn btn-primary" >Update</button>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class=" col-md-3">
        <div class="osahan-account-page-right shadow-sm bg-white p-4 h-100">
            <div class="tab-content" id="myTabContent">
            <form action="{{route('pay')}}">
                <div class="tab-pane fade active show" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                    <h4 class="font-weight-bold mt-0 mb-4">Payments</h4>

                    {{-- action payment --}}

                    <div class="row">
                        <h4>Total: $<?php echo Cart::subtotal(); ?></h4>

                        <div class="payment">

                            {{-- route payment_profile --}}
                            <select class="form-control" id="card_number" name="card_number">
                            @foreach($data as $p)
                                <option>{{$p->number_card}}</option>
                                @endforeach
                              </select>

                            <h4 class="headline-primary">Payment</h3>

                                @if (Session::has('erorr'))
                                    <div class="alert alert-danger alert-dismissible col-12">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Erorr!!</strong>{{ Session::get('erorr') }}
                                    </div>
                                @endif
                          </div>
                          <input type="submit"  id="amount" name="amount" class="btn btn-primary action_payment col-12" value="<?php echo Cart::initial();?>">





                    </div>
                </form>

                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
    {{-- <script>
    $(document).ready(function(){
        var n = $("h6");
        var re = /(\w+)\s(\w+)\s(\w+)\s(\w+)/;
        for (i = 0; i < n.length+1; i++){
            var str = document.getElementsByTagName("h6")[i].innerHTML;
            var newstr = str.replace(re, "$1 **** **** $4");
            document.getElementsByTagName("h6")[i].innerHTML = newstr;
        }
    });
</script> --}}
    {{-- delete cart item --}}
    {{-- <script>
        $(document).ready(function(){
            var n = $("select");
            var re = /(\w+)\s(\w+)\s(\w+)\s(\w+)/;
            for (i = 0; i < n.length+1; i++){
                var str = document.getElementsByTagName("select")[i].innerHTML;
                var newstr = str.replace(re, "$1 **** **** $4");
                document.getElementsByTagName("select")[i].innerHTML = newstr;
            }
        });
    </script>

<script>
    $(document).ready(function(){
        var n = $("option");
        var re = /(\w+)\s(\w+)\s(\w+)\s(\w+)/;
        for (i = 0; i < n.length+1; i++){
            var str = document.getElementsByTagName("option")[i].innerHTML;
            var newstr = str.replace(re, "$1 **** **** $4");
            document.getElementsByTagName("option")[i].innerHTML = newstr;
        }
    });
</script> --}}

    <script>
        $(".remove_item").click(function(){
            var id = $(this).data("id");
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            $.ajax(
            {
                url: "cart/"+id,
                type: 'GET',
                data: {
                    "id": id,
                    "_method": 'DELETE',
                },
                success: function (data)
                {
                    console.log("it Work");
                    alert('Record has been deleted successfully !!!!');
                    window.location.reload();

                }
            });
            console.log(id,token);
        });
    </script>
    {{-- end delete --}}


    <script type = "text/javascript">
        $(".get_item").click(function(){
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            var datalist_id = $(".remove_item").map(function() {
                return $(this).data("id");
            }).get();
            var get_qty = document.getElementsByTagName("input");
            var i = 0;

            for(i=0; i<datalist_id.length; i++){
                id=datalist_id[i];
                qty=get_qty[i+1].value;

                $.ajax({
                    url: "cart/update/"+id+"/"+qty,
                    type: 'PUT',
                    data: {
                        "id": id,
                        "qty": qty,
                    },

                });
                console.log("it Work");
                console.log(id+" "+qty);
            };
            alert('Record has been update successfully !!!!');
            window.location.reload();
            // datalist_id.forEach(test)
            // function test(id){
            // console.log(id+" "+"qty");
        });
    </script>

    {{-- Billl --}}

    <script>
        $(".action_payment").click(function(){
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
        var id = $(".pro_id").map(function() {
                return $(this).data("id");
            }).get();
        // var qty = $(".qty").map(function() {
        //     return $(this).data("qty");
        // }).get();
        // var price = $(".price").map(function() {
        //     return $(this).data("price");
        // }).get();
        // var subtotal = $(".subtotal").map(function() {
        //     return $(this).data("subtotal");
        // }).get();

        for(i=0;i<id.length;i++){
            id_item=id[i];
            console.log(id[i]+" "+qty[i]+" "+price[i]+" "+subtotal[i]);
        // $.ajax({
        //             url: "pay/"+id+"/"+qty+"/"+price+"/"+subtotal,
        //             type: 'GET',
        //             data: {
        //                 "id": id,
        //                 "qty": qty,
        //                 "price":price,
        //                 "subtotal":subtotal
        //             },

        //         });

        };

    });
    </script>


    <script>
        var str = document.getElementById("amount").value;
        var result = str.replace(/,/g, "");
        document.getElementById("amount").value = result;

    </script>




    {{-- show button update --}}
    <script>
        function focusFunction() {
            $(".hidden").show();
        }
    </script>


@endsection

