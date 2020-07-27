@extends('layouts.dashboard')
@section('style')
    <!-- Custom styles for this page -->
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
        .table td {
            vertical-align: middle;
        }

        td:last-child {
            text-align: center
        }

        /* Delete modal */
        .modal-confirm {
            color: #636363;
            width: 400px;
        }

        .modal-confirm .modal-content {
            padding: 20px;
            border-radius: 5px;
            border: none;
            text-align: center;
            font-size: 14px;
        }

        .modal-confirm .modal-header {
            border-bottom: none;
            position: relative;
        }

        .modal-confirm h4 {
            text-align: center;
            font-size: 26px;
            margin: 30px 0 -10px;
        }

        .modal-confirm .close {
            position: absolute;
            top: -5px;
            right: -2px;
        }

        .modal-confirm .modal-body {
            color: #999;
        }

        .modal-confirm .modal-footer {
            border: none;
            text-align: center;
            border-radius: 5px;
            font-size: 13px;
            padding: 10px 15px 25px;
        }

        .modal-confirm .modal-footer a {
            color: #999;
        }

        .modal-confirm .icon-box {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            border-radius: 50%;
            z-index: 9;
            text-align: center;
            border: 3px solid #f15e5e;
        }

        .modal-confirm .icon-box i {
            color: #f15e5e;
            font-size: 46px;
            display: inline-block;
            margin-top: 13px;
        }

        .modal-confirm .btn,
        .modal-confirm .btn:active {
            color: #fff;
            border-radius: 4px;
            background: #60c7c1;
            text-decoration: none;
            transition: all 0.4s;
            line-height: normal;
            min-width: 120px;
            border: none;
            min-height: 40px;
            border-radius: 3px;
            margin: 0 5px;
        }

        .modal-confirm .btn-secondary {
            background: #c1c1c1;
        }

        .modal-confirm .btn-secondary:hover,
        .modal-confirm .btn-secondary:focus {
            background: #a8a8a8;
        }

        .modal-confirm .btn-danger {
            background: #f15e5e;
        }

        .modal-confirm .btn-danger:hover,
        .modal-confirm .btn-danger:focus {
            background: #ee3535;
        }

        .trigger-btn {
            display: inline-block;
            margin: 100px auto;
        }

    </style>
@endsection
@section('content')
    <h1 class="h3 mb-2 text-gray-800">Seller manager</h1>

    <!-- The Create Seller -->
    <div class="modal fade" id="createSeller">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Create new seller account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal body -->
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Full name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                placeholder="Enter full name">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input id="username" type="text"
                                class="form-control @error('username') is-invalid @enderror" name="username"
                                value="{{ old('username') }}" required autocomplete="username" autofocus
                                placeholder="Enter username">

                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email"
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
                                name="phone" value="{{ old('phone') }}" required autocomplete="phone"
                                placeholder="Enter phone number">

                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password1">Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                required autocomplete="new-password" placeholder="Enter password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="Confirm password">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer border-top-0 d-flex justify-content-center">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- The Edit Seller -->
    <div class="modal fade" id="editSeller">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Update seller information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal body -->
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Full name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
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
                                name="email" value="{{ old('email') }}" required autocomplete="email"
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
                                name="phone" value="{{ old('phone') }}" required autocomplete="phone"
                                placeholder="Enter phone number">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer border-top-0 d-flex justify-content-center">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- The Delete Seller -->
    <div id="deleteSeller" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header flex-column">
                    <div class="icon-box">
                        <i class="material-icons">&#xE5CD;</i>
                    </div>
                    <h4 class="modal-title w-100">Are you sure?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Do you really want to delete these records? This process cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-inline-flex justify-content-between align-items-center" id="test">
            <h6 class="m-0 font-weight-bold text-primary">DataTable Seller</h6>
            <div>
                <button class="btn btn-outline-dark" data-toggle="modal" data-target="#createSeller"><i
                        class="fa fa-user-plus"></i> Create seller</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                            <th data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                            <td>2011/04/25</td>
                            <td>$320,800</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Garrett Winters</td>
                            <td>Accountant</td>
                            <td>Tokyo</td>
                            <td>63</td>
                            <td>2011/07/25</td>
                            <td>$170,750</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Ashton Cox</td>
                            <td>Junior Technical Author</td>
                            <td>San Francisco</td>
                            <td>66</td>
                            <td>2009/01/12</td>
                            <td>$86,000</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Cedric Kelly</td>
                            <td>Senior Javascript Developer</td>
                            <td>Edinburgh</td>
                            <td>22</td>
                            <td>2012/03/29</td>
                            <td>$433,060</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Airi Satou</td>
                            <td>Accountant</td>
                            <td>Tokyo</td>
                            <td>33</td>
                            <td>2008/11/28</td>
                            <td>$162,700</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Brielle Williamson</td>
                            <td>Integration Specialist</td>
                            <td>New York</td>
                            <td>61</td>
                            <td>2012/12/02</td>
                            <td>$372,000</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Herrod Chandler</td>
                            <td>Sales Assistant</td>
                            <td>San Francisco</td>
                            <td>59</td>
                            <td>2012/08/06</td>
                            <td>$137,500</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Rhona Davidson</td>
                            <td>Integration Specialist</td>
                            <td>Tokyo</td>
                            <td>55</td>
                            <td>2010/10/14</td>
                            <td>$327,900</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Colleen Hurst</td>
                            <td>Javascript Developer</td>
                            <td>San Francisco</td>
                            <td>39</td>
                            <td>2009/09/15</td>
                            <td>$205,500</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Sonya Frost</td>
                            <td>Software Engineer</td>
                            <td>Edinburgh</td>
                            <td>23</td>
                            <td>2008/12/13</td>
                            <td>$103,600</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Jena Gaines</td>
                            <td>Office Manager</td>
                            <td>London</td>
                            <td>30</td>
                            <td>2008/12/19</td>
                            <td>$90,560</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Quinn Flynn</td>
                            <td>Support Lead</td>
                            <td>Edinburgh</td>
                            <td>22</td>
                            <td>2013/03/03</td>
                            <td>$342,000</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Charde Marshall</td>
                            <td>Regional Director</td>
                            <td>San Francisco</td>
                            <td>36</td>
                            <td>2008/10/16</td>
                            <td>$470,600</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Haley Kennedy</td>
                            <td>Senior Marketing Designer</td>
                            <td>London</td>
                            <td>43</td>
                            <td>2012/12/18</td>
                            <td>$313,500</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Tatyana Fitzpatrick</td>
                            <td>Regional Director</td>
                            <td>London</td>
                            <td>19</td>
                            <td>2010/03/17</td>
                            <td>$385,750</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Michael Silva</td>
                            <td>Marketing Designer</td>
                            <td>London</td>
                            <td>66</td>
                            <td>2012/11/27</td>
                            <td>$198,500</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Paul Byrd</td>
                            <td>Chief Financial Officer (CFO)</td>
                            <td>New York</td>
                            <td>64</td>
                            <td>2010/06/09</td>
                            <td>$725,000</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Gloria Little</td>
                            <td>Systems Administrator</td>
                            <td>New York</td>
                            <td>59</td>
                            <td>2009/04/10</td>
                            <td>$237,500</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Bradley Greer</td>
                            <td>Software Engineer</td>
                            <td>London</td>
                            <td>41</td>
                            <td>2012/10/13</td>
                            <td>$132,000</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Dai Rios</td>
                            <td>Personnel Lead</td>
                            <td>Edinburgh</td>
                            <td>35</td>
                            <td>2012/09/26</td>
                            <td>$217,500</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Jenette Caldwell</td>
                            <td>Development Lead</td>
                            <td>New York</td>
                            <td>30</td>
                            <td>2011/09/03</td>
                            <td>$345,000</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Yuri Berry</td>
                            <td>Chief Marketing Officer (CMO)</td>
                            <td>New York</td>
                            <td>40</td>
                            <td>2009/06/25</td>
                            <td>$675,000</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Caesar Vance</td>
                            <td>Pre-Sales Support</td>
                            <td>New York</td>
                            <td>21</td>
                            <td>2011/12/12</td>
                            <td>$106,450</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Doris Wilder</td>
                            <td>Sales Assistant</td>
                            <td>Sidney</td>
                            <td>23</td>
                            <td>2010/09/20</td>
                            <td>$85,600</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Angelica Ramos</td>
                            <td>Chief Executive Officer (CEO)</td>
                            <td>London</td>
                            <td>47</td>
                            <td>2009/10/09</td>
                            <td>$1,200,000</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Gavin Joyce</td>
                            <td>Developer</td>
                            <td>Edinburgh</td>
                            <td>42</td>
                            <td>2010/12/22</td>
                            <td>$92,575</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Jennifer Chang</td>
                            <td>Regional Director</td>
                            <td>Singapore</td>
                            <td>28</td>
                            <td>2010/11/14</td>
                            <td>$357,650</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Brenden Wagner</td>
                            <td>Software Engineer</td>
                            <td>San Francisco</td>
                            <td>28</td>
                            <td>2011/06/07</td>
                            <td>$206,850</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Fiona Green</td>
                            <td>Chief Operating Officer (COO)</td>
                            <td>San Francisco</td>
                            <td>48</td>
                            <td>2010/03/11</td>
                            <td>$850,000</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Shou Itou</td>
                            <td>Regional Marketing</td>
                            <td>Tokyo</td>
                            <td>20</td>
                            <td>2011/08/14</td>
                            <td>$163,000</td>
                            <td>
                                <button class="btn" data-toggle="modal" data-target="#editSeller"><i
                                        class="fa fa-edit"></i></button>
                                <button class="btn" data-toggle="modal" data-target="#deleteSeller"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Page level plugins -->
    <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/js/demo/datatables-demo.js"></script>
@endsection
