<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

    <thead>
        <tr>
            <th>Code bill</th>
            <th>Customer ID</th>
            <th>Date of purchase</th>
            <th>Seller</th>
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
            <th>Process</th>
            <th>Total money</th>
            <th></th>
        </tr>
    </tfoot>
    <tbody>
        @foreach ($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->users->full_name }}</td>
                <td>{{ $transaction->created_at }}</td>
                <td>
                    @if ($transaction->seller_id != null)
                        {{ $transaction->managers->full_name }}
                    @else
                        <span class="text-danger">Anonymous</span>
                    @endif
                </td>
                <td>
                    @if ($transaction->status == 1)
                        <span class="text-success">Complete</span>
                    @else
                        <span class="text-warning">Pending...</span>
                    @endif
                </td>
                <td>$320,800</td>
                <td>
                    @if ($transaction->seller_id != null)
                        <button class="btn btn-primary disabled" data-toggle="modal" data-target="#assignSeller"
                            disabled>Assign</button>
                    @else
                        <button class="btn btn-primary" data-toggle="modal" data-target="#assignSeller">Assign</button>
                    @endif
                    @if (Auth::guard('manager')->user()->role == 1)
                        <a href="{{ route('admin.bill-detail') }}" class="btn"><i class="fas fa-info text-info"></i></a>
                    @else
                        <a href="{{ route('seller.bill-detail') }}" class="btn"><i
                                class="fas fa-info text-info"></i></a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
