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
                    <th>Seller Name</th>
                    <th>Option</th>
                </tr>
                @foreach ($bill as $b)
                    <tr>
                        <td>{{ $b->id }}</td>
                        <td>${{ $b->total_money }}</td>
                        <td>{{ $b->created_at }}</td>
                        @if($b->seller_id != null)
                            <td>{{ $b->managers->full_name }}</td>
                        @else
                            <td></td>
                        @endif
                        <td>
                            <a class="bill_detail" href="{{ route('bill_detail', $b->id) }}">Detail</a>
                            /
                            <a id="send_question" class="check_seller" type="button" data-seller="{{ $b->seller_id }}"
                                data-toggle="modal" data-target="#modal_qes" href="#{{ $b->seller_id }}">Send
                                Question</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    {{-- Model --}}
    <div class="modal fade" id="modal_qes">
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
                        <label>Title:</label>
                        <input type="text" class="form-control" id="title">
                    </div>
                    <div class="form-group">
                        <label>Description:</label>
                        <textarea class="form-control" rows="5" id="des"></textarea>
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

        });

        $("#send_question").click(function() {
            var seller_id = $(this).data("seller");
            console.log(seller_id);
            $("#action_send_question").click(function() {
                var title = $("#title").val();
                var des = $("#des").val();
                // console.log(seller_id+" "+title+" "+des);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "feedback/add",
                    type: 'POST',
                    data: {
                        "seller_id": seller_id,
                        "title": title,
                        "des": des,
                    },
                    success: function(data) {
                        console.log(data);
                        alert(data.status);
                        $("#title").val('');
                        $("#des").val('');
                    }
                    // console.log(id+exp_month+exp_year);
                });
            })
        });
    </script>

@endsection
