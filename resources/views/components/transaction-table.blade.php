<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Code bill</th>
            <th>Customer ID</th>
            <th>Date of purchase</th>
            <th>Seller</th>
            <th>Seller email</th>
            <th>Status paid</th>
            <th>Process</th>
            <th>Total money</th>
            <th data-orderable="false"></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Code bill</th>
            <th>Customer ID</th>
            <th>Date of purchase</th>
            <th>Seller</th>
            <th>Seller email</th>
            <th>Status paid</th>
            <th>Process</th>
            <th>Total money</th>
            <th></th>
        </tr>
    </tfoot>
    <tbody>
        <tr>
            <td>Tiger Nixon</td>
            <td>System Architect</td>
            <td>2011/04/25</td>
            <td>Edinburgh</td>
            <td>edinburgh@gmail.com</td>
            <td><span class="text-success">Success</span></td>
            <td><span class="text-success">Complete</span></td>
            <td>$320,800</td>
            <td>
                <button class="btn btn-primary disabled" data-toggle="modal" data-target="#assignSeller"
                    disabled>Assign</button>
                @if(Auth::guard('manager')->user()->role == 1)
                    <a href="{{ route('admin.bill-detail') }}" class="btn"><i class="fas fa-info text-info"></i></a>
                @else
                    <a href="{{ route('seller.bill-detail') }}" class="btn"><i class="fas fa-info text-info"></i></a>
                @endif
            </td>
        </tr>
        <tr>
            <td>Garrett Winters</td>
            <td>Accountant</td>
            <td>2011/07/25</td>
            <td><span class="text-danger">Anonymous</span></td>
            <td><span class="text-danger">Anonymous</span></td>
            <td><span class="text-success">Success</span></td>
            <td><span class="text-warning">Pending...</span></td>
            <td>$170,750</td>
            <td>
                <button class="btn btn-primary" data-toggle="modal" data-target="#assignSeller">Assign</button>
                @if(Auth::guard('manager')->user()->role == 1)
                    <a href="{{ route('admin.bill-detail') }}" class="btn"><i class="fas fa-info text-info"></i></a>
                @else
                    <a href="{{ route('seller.bill-detail') }}" class="btn"><i class="fas fa-info text-info"></i></a>
                @endif
            </td>
        </tr>
        <tr>
            <td>Ashton Cox</td>
            <td>Junior Technical Author</td>
            <td>2009/01/12</td>
            <td>San Francisco</td>
            <td>sanfrancisco@gmail.com</td>
            <td><span class="text-success">Success</span></td>
            <td><span class="text-warning">Pending...</span></td>
            <td>$86,000</td>
            <td>
                <button class="btn btn-primary disabled" data-toggle="modal" data-target="#assignSeller"
                    disabled>Assign</button>
                @if(Auth::guard('manager')->user()->role == 1)
                    <a href="{{ route('admin.bill-detail') }}" class="btn"><i class="fas fa-info text-info"></i></a>
                @else
                    <a href="{{ route('seller.bill-detail') }}" class="btn"><i class="fas fa-info text-info"></i></a>
                @endif
            </td>
        </tr>
        <tr>
            <td>Cedric Kelly</td>
            <td>Senior Javascript Developer</td>
            <td>2012/03/29</td>
            <td><span class="text-danger">Anonymous</span></td>
            <td><span class="text-danger">Anonymous</span></td>
            <td><span class="text-danger">Fail</span></td>
            <td><span class="text-danger">Refuse</span></td>
            <td>$433,060</td>
            <td>
                <button class="btn btn-primary disabled" data-toggle="modal" data-target="#assignSeller"
                    disabled>Assign</button>
                @if(Auth::guard('manager')->user()->role == 1)
                    <a href="{{ route('admin.bill-detail') }}" class="btn"><i class="fas fa-info text-info"></i></a>
                @else
                    <a href="{{ route('seller.bill-detail') }}" class="btn"><i class="fas fa-info text-info"></i></a>
                @endif
            </td>
        </tr>
    </tbody>
</table>
