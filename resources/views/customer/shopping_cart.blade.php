@extends('layouts.master')
@section('content')
<div class="container">
    <form class="row" >
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
                                            @foreach($cart as $row)
                                            <tr id="{{$row->rowId}}">
                                                <td class="pro_id" data-id="{{$row->rowId}}"><?php echo $row->name; ?></td>
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
                    <div class="tab-pane fade active show" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                        <h4 class="font-weight-bold mt-0 mb-4">Payments</h4>
                    {{-- action payment --}}
                        <div class="row">
                            <h4 class="col-12">Total: $<?php echo Cart::subtotal(); ?></h4>
                            <div class="col-12">
                                    {{-- route payment_profile --}}
                                    <select class="form-control"  id="card_number" name="card_number">
                                        <option>Choose Card !!!!</option>
                                        @foreach($data as $p)
                                            <option data-id="{{$p->id}}" value="{{$p->number_card}}">**** **** **** {{$p->number_card}}</option>
                                        @endforeach
                                    </select>
                                        @if (Session::has('erorr'))
                                            <div class="alert alert-danger alert-dismissible col-12">
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                <strong>Erorr!!</strong>{{ Session::get('erorr') }}
                                            </div>
                                    @endif
                            </div>
                            <input type="submit" data-amount="<?php echo Cart::initial();?>"  id="amount" name="amount" class="btn btn-primary action_payment mt-3 col-12" value="<?php echo Cart::initial();?>">
                        </div>
                    </div>
                </div>
             </div>
        </div>
    </form>
</div>
@endsection

@section('script')
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
                url: "cart/delete",
                type: 'GET',
                data: {
                    "id": id,
                },
                success: function (data)
                {
                    console.log("it Work");
                    alert('Record has been deleted successfully !!!!');
                    document.getElementById(id).remove();
                }
            });
        });
    </script>





    <script type = "text/javascript">
    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
        $(".get_item").click(function(){

            var datalist_id = $(".remove_item").map(function() {
                return $(this).data("id");
            }).get();
            var get_qty = document.getElementsByTagName("input");
            var i = 0;

            for(i=0; i<datalist_id.length; i++){
                id=datalist_id[i];
                qty=get_qty[i+1].value;
                $.ajax({
                    url: "cart/update",
                    type: 'PUT',
                    data: {
                        "id": id,
                        "qty": qty,
                    },
                });
            };
            alert('Record has been update successfully !!!!');
        });
    </script>

    {{-- Billl --}}

    <script>
        $(".action_payment").click(function(e){
        e.preventDefault();
        var card_number = document.getElementById("card_number").value
        $.ajax({
                    url: "create_bill",
                    type: 'POST',
                    data: {
                        "card_number":card_number,
                    },
                    success:function(data){
                    console.log(data);
                    alert(data.success);
                    location.reload();
                }

                });

    });
    </script>

    <script>
        var str = document.getElementById("amount").value;
        var result = str.replace(str, "Payment for $"+str);
        document.getElementById("amount").value = result;

    </script>

    {{-- show button update --}}
    <script>
        function focusFunction() {
            $(".hidden").show();
        }
    </script>

    <script>
        $("#amount").click(function(){
            document.getElementById("amount").disabled = true;
        })
    </script>

@endsection

