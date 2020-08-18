@extends('layouts.master')
@section('content')
    <div class="container">
        <!-- Project-->
        <div class="bg-white card payments-item mb-2 shadow-sm">
            <h4 class="font-weight-bold mt-3  mb-4 col-7">Purchase History</h4>
            <table class="table table-striped">
                <tr>
                    <th>Bill ID</th>
                    <th>Price Total</th>
                    <th>Date</th>
                    <th>Option</th>
                </tr>
                @foreach ($bill as $b)
                    <tr>
                        <td>{{ $b->id }}</td>
                        <td>${{ $b->total_money }}</td>
                        <td>{{ $b->created_at }}</td>
                        <td>
                            <a class="bill_detail" href="{{ route('bill_detail', $b->id) }}">Detail</a>
                            /
                            <a id="send_question" class="check_seller" type="button" data-seller="{{ $b->seller_id }}"
                                data-toggle="modal" data-target="#myModal" href="#{{ $b->seller_id }}">Send
                                Question</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    {{-- Model --}}
    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 id="modal_title" class="modal-title">Modal Heading</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="usr">Title:</label>
                        <input type="text" class="form-control" id="title">
                    </div>
                    <div class="form-group">
                        <label for="comment">Description:</label>
                        <textarea class="form-control" rows="5" id="comment" name="text"></textarea>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button id="action_send_question" class="btn btn-primary">Submit</button>
                </div>

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

        $(document).ready(function() {
            // var check_seller = $(".check_seller").data("seller");
            var datalist_seller = $(".check_seller").map(function() {
                return $(this).data("seller");
            }).get();
            var class_list = $(".check_seller")
            for (i = 0; i < datalist_seller.length; i++) {
                if (datalist_seller[i] == "") {
                    // console.log(class_list[i]);
                    class_list[i].setAttribute("class", "null_seller");
                } else {
                    console.log(datalist_seller[i]);
                }
            }


            // if (check_seller == undefined){
            //     console.log("null");
            // }else{
            //     console.log(check_seller);
            // }


        });

        $("#send_question").click(function() {
            var seller_id = $(this).data("seller");
            console.log(seller_id);
            // $.ajax({
            //     url: "card/edit",
            //     type: 'POST',
            //     data: {
            //         "number_card": number_card,
            //         "exp_month": exp_month,
            //         "exp_year": exp_year,
            //     },
            //     success: function(data) {
            //         console.log(data);
            //         alert(data.success);
            //         location.reload();
            //     }
            //     // console.log(id+exp_month+exp_year);
            // });

        });

    </script>

@endsection
