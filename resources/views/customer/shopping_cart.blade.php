@extends('layouts.master')
@section('content')
<div class="container">
    <form class="row" >
        <div class=" col-lg-9 col-md-offset-1">
            <div class="osahan-account-page-right shadow-sm bg-white p-4 h-100">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                        <h4 class="font-weight-bold mt-0 mb-4">Product</h4>
                            <div class="row overflow-auto">
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

                            <div class="row">
                                <div class=" update" style="display: none" >
                                    <button type="submit" class="get_item btn btn-primary" >Update</button>
                                </div>
                                <div class="delete ml-auto mr-3">
                                    <button class="btn btn-danger" >Delete All</button>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
        <div class=" col-lg-3">
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
                                        <option value="null">Choose Card !!!!</option>
                                        @if ($data == null){
                                            {{-- data == null --}}
                                        }
                                        @else{
                                            @foreach($data as $p)
                                                <option data-id="{{$p->id}}" value="{{$p->number_card}}">**** **** **** {{$p->number_card}}</option>
                                            @endforeach
                                        }
                                        @endif
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
<!-- The Modal Confirm -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header m-auto">
                <h5 class="modal-title">Do you already have an account ?</h5>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer m-auto">
                <a href="/login" type="button" class="btn btn-success" >I have</a>
                <a href="/register" type="button" class="btn btn-danger">I don't</a>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')

    {{-- alredy function --}}
    <script>
        var str = document.getElementById("amount").value;
        var result = str.replace(str, "Payment for $"+str);
        document.getElementById("amount").value = result;

        var tbody = $("#cart_product");
        if (tbody.children().length == 0){
            $(".delete").hide();
        }
    </script>

    {{-- Delete Cart Item --}}
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

    {{-- Update Cart item --}}
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
            var user_name = document.getElementById("navbarDropdown");
            if(user_name == null){
                for(i=0; i<datalist_id.length; i++){
                id=datalist_id[i];
                qty=get_qty[i].value;
                $.ajax({
                    url: "cart/update",
                    type: 'PUT',
                    data: {
                        "id": id,
                        "qty": qty,
                    },
                });
            };
            }else{
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
            }
            alert('Record has been update successfully !!!!');
        });
    </script>

    {{-- Destroy Cart --}}
    <script>
        $(".delete").click(function(e){
            $.ajax({
                    url: "cart/destroy",
                    type: 'GET',
                });
                alert('Delete Complete !!!! !!!!');
                $(".delete").hide();
            })
    </script>

    {{-- Create Billl --}}
    <script>
         $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
        $(".action_payment").click(function(e){
            e.preventDefault();
            document.getElementById("amount").disabled = true;
            var card_number = document.getElementById("card_number").value
            var user_name = document.getElementById("navbarDropdown")
            if(card_number == "null" && user_name == null){
                $('#myModal').modal('show');
            }else{
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
            }
        });

    </script>



    {{-- show button update --}}
    <script>
        function focusFunction() {
            $(".update").show();
            $(".delete").hide();
        }
    </script>

@endsection

