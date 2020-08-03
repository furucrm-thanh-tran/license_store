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

                                    <td><?php echo $row->name; ?></td>
                                    <td>
                                    <input class="qty" type="number" id="replyNumber" min="0" onfocus="focusFunction()" data-qty="{{$row->qty}}"value="<?php echo $row->qty; ?>"/>
                                    </td>
                                    <td>$<?php echo $row->price; ?></td>
                                    <td>$<?php echo $row->subtotal; ?></td>
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
                        <h4>Total: $<?php echo Cart::subtotal(); ?></h4>
                    @foreach($data as $p)
                        <div class="payment">

                            {{-- route payment_profile --}}
                            <a href="/paymentprofile">Change</a>
                            <h4 class="headline-primary">Payment</h3>

                                @if (Session::has('erorr'))
                                    <div class="alert alert-danger alert-dismissible col-12">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Erorr!!</strong>{{ Session::get('erorr') }}
                                    </div>
                                @endif

                              <div class="bg-white card payments-item mb-4 shadow-sm">
                                  <div class="gold-members p-4">

                                      <div class="media">
                                          <div class="media-body">
                                              <a href="#">
                                                {{$p->name_card}}
                                                  <h6 id="card_number" >{{$p->number_card}}</h6>
                                              </a>
                                          </div>
                                      </div>

                                  </div>
                              </div>
                          </div>
                          <a type="button"
                                        data-number="{{$p->number_card}}"
                                        data-cvc="{{$p->cvc}}"
                                        data-month="{{$p->exp_month}}"
                                        data-year="{{$p->exp_year}}"
                                        href="{{route('pay_cart',[Cart::subtotal(),
                                                                    $p->number_card,
                                                                    $p->cvc,
                                                                    $p->exp_month,
                                                                    $p->exp_year,])}}" class="btn btn-primary action_payment">Pay $<?php echo Cart::subtotal(); ?> </a>

                          @endforeach


                    </div>
                {{-- </form> --}}

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


    <script>
        $(".get_item").click(function(){
            var datalist_id = $(".remove_item").map(function() {
                return $(this).data("id");
            }).get();
            // var datalist_qty = $(".qty").map(function() {
            //     return $(this).data("qty");
            // }).get();

            // get Quantity
            var get_qty = document.getElementsByTagName("input");

            // get token
            // var token = $(".remove_item").map(function() {
            //     return $(this).data("token");
            // }).get();
            var i = 0;
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            for(i=0; i<datalist_id.length; i++){
                id=datalist_id[i];
                qty=get_qty[i].value;

                $.ajax({
                    url: "cart/update/"+id+"/"+qty,
                    type: 'PUT',
                    data: {
                        "id": id,
                        "qty": qty,
                        _method: 'PUT'
                    },

                });
                console.log("it Work");
            };
            // alert('Record has been update successfully !!!!');
            // window.location.reload();
            // datalist_id.forEach(test)
            // function test(id){
            console.log(id+" "+qty);
        });
    </script>

    {{-- show button update --}}
    <script>
        function focusFunction() {
            $(".hidden").show();
        }
    </script>


@endsection

