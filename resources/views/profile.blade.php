@extends('layouts.master')
@section('content')
    <!-- The Edit Profile -->
    <div class="modal fade" id="editProfile">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Update profile information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="/info_cus/{{Auth::user()->id}}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Full name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ Auth::user()->full_name }}" required autocomplete="name" autofocus
                                placeholder="Enter full name">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ Auth::user()->email}}" required autocomplete="email"
                                placeholder="Enter email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone number</label>
                            <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" value="{{ Auth::user()->phone }}" required autocomplete="phone"
                                placeholder="Enter phone number">
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer border-top-0 d-flex justify-content-center">
                        <button type="submit" data-id="{{ Auth::user()->id }}" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- The Edit Payment Card -->

    <div class="modal fade" id="card_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Update card</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{route('edit_card_item')}}">
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Expiration Month</label>
                            <input name="card_expmonth" id="card_expmonth" class='form-control card-expiry-month' placeholder='MM' max="12" min="01" type='number'>
                        </div>
                        <div class="form-group">
                            <label>Expiration Year</label>
                            <input name="card_expyear" id="card_expyear" class='form-control card-expiry-year' placeholder='YYYY' maxlength="4" maxlength="4" type='number'>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer border-top-0 d-flex justify-content-center">
                        <input type="submit" class="btn btn-success" value="Submit">
                        <input id="edit" name="edit" class="btn btn-success collapse" value="" required>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="osahan-account-page-left shadow-sm bg-white h-100">
                    <div class="border-bottom p-4">
                        <div class="osahan-user text-center">
                            <div class="osahan-user-media">
                                {{-- <img class="mb-3 rounded-pill shadow-sm mt-1" src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="gurdeep singh osahan"> --}}
                                <div class="osahan-user-media-body">
                                    <h6 class="mb-2">{{ Auth::user()->full_name }}</h6>
                                    <p class="mb-1">{{ Auth::user()->phone }}</p>
                                    <p>{{ Auth::user()->email}}</p>
                                    {{-- <button class="btn btn-outline-dark float-right" data-toggle="modal" data-target="#editProfile">Edit Profile</button> --}}
                                    <p class="mb-0 text-black font-weight-bold"><a class="text-primary mr-3" data-toggle="modal" data-target="#editProfile" href="#">EDIT</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                        <a class="nav-link active" id="list_bills"  href="{{ route('list_bills',Auth::user()->id) }}">Purchase History</a>

                </div>
            </div>
            <div class="col-md-9">
                <div class="osahan-account-page-right shadow-sm bg-white p-4 h-100">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                            <div class="row">
                                <h4 class="font-weight-bold mt-0 mb-4 col-7">Payments</h4>
                                <a href="{{ url("/frm_insertcard") }}" class="font-weight-bold">Add payment card</a>
                            </div>
                            <div class="row">
                                @foreach($data as $p)
                                <div class="col-md-6">
                                    <div class="bg-white card payments-item mb-4 shadow-sm">
                                        <div class="gold-members p-4">
                                            <div class="media">
                                                <div class="media-body">
                                                    <i class="fa fa-cc-visa fa-4x"></i>
                                                    <h6 id="card_number" class="mb-1">{{ $p->number_card }}</h6>
                                                    <p>CVC:***<br>VALID TILL: **/****</p>
                                                    <p class="mb-0 text-black font-weight-bold">
                                                        <a class="text-danger" onclick="return confirm('Are you sure ???');" href="{{route('del_card_item',[$p->id])}}">
                                                            <i class="icofont-ui-delete"></i> DELETE</a>
                                                        <a class="text-danger m-lg-3 edit_card" data-toggle="modal"
                                                                                                data-month="{{$p->exp_month}}"
                                                                                                data-year="{{$p->exp_year}}"
                                                                                                data-id="{{$p->id}}"
                                                                                                href="#card_modal"
                                                                                                onclick="edit_card(this)">EDIT</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class='row'>
                                <div class='col-md-12 error form-group collapse'>
                                    <div class='alert-danger alert'>Please correct the errors and try again.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
        var n = $("h6");
        var re = /(\w+)\s(\w+)\s(\w+)\s(\w+)/;
        for (i = 0; i < n.length+1; i++){
            var str = document.getElementsByTagName("h6")[i].innerHTML;
            var newstr = str.replace(re, "$1 **** **** $4");
            document.getElementsByTagName("h6")[i].innerHTML = newstr;
        }
    });
</script>

<script>
    function edit_card(card){
        var month = $(card).data('month');
        var year = $(card).data('year');
        var id = $(card).data('id');
        document.getElementById('card_expmonth').value = month;
        document.getElementById('card_expyear').value = year;
        document.getElementById('edit').value = id;
    }
</script>

@endsection
