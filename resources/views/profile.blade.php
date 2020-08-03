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
                                    <p class="mb-0 text-black font-weight-bold"><a class="text-primary mr-3" data-toggle="modal" data-target="#editProfile" href="#"><i class="icofont-ui-edit"></i> EDIT</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs flex-column border-0 pt-4 pl-4 pb-4" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="payments-tab" data-toggle="tab" href="#payments" role="tab" aria-controls="payments" aria-selected="true"><i class="icofont-credit-card"></i> Payments</a>
                        </li>
                    </ul>
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
                                                   <a href="#">
                                                       <i class="fa fa-cc-visa fa-4x"></i>

                                                   </a>
                                                    <a href="#">
                                                        <h6 id="card_number" data-number="{{ $p->number_card }}" class="mb-1">{{ $p->number_card }}</h6>
                                                    <p>CVC:***<br>
                                                        VALID TILL: {{$p->exp_month}}/{{$p->exp_year}}
                                                    </p>
                                                    </a>
                                                    <p class="mb-0 text-black font-weight-bold">
                                                        <a class="text-danger" onclick="return confirm('Are you sure ???');" href="{{route('del_card_item',[$p->number_card])}}">
                                                            <i class="icofont-ui-delete"></i> DELETE</a>
                                                        </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                @endforeach

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

</script>
@endsection
