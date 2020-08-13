<table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Title</th>
            <th>Description</th>
            <th>Release date</th>
            <th>Recent update</th>
            <th>Price</th>
            <th data-orderable="false"></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Title</th>
            <th>Description</th>
            <th>Release date</th>
            <th>Recent update</th>
            <th>Price</th>
            <th></th>
        </tr>
    </tfoot>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{$product->id}}</td>
            <td>
                <img src="{{ $product->icon_pro }}">
            </td>
            <td>{{$product->name_pro}}</td>
            <td>{{$product->description_pro}}</td>
            <td>{{$product->created_at}}</td>
            <td>{{$product->updated_at}}</td>
            <td>{{$product->price_license}}</td>
            <td>
                <div class="d-flex flex-nowrap">
                    @if(Auth::guard('manager')->user()->role == 1)
                    <a class="btn" href="{{ route('license.show', $product->id) }}"><i class="fa fa-plus"></i></a>
                    <button class="btn" id="show-product" data-toggle="modal" data-id="{{ $product->id }}"><i class="fa fa-eye"></i></button>
                    <button class="btn" id="edit-product" data-id="{{ $product->id }}" data-toggle="modal"><i class="fa fa-edit"></i></button>
                    <form action="{{ route('product_manager.destroy',$product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn" type="submit" data-toggle="modal" onclick="return confirm('Are you sure ????');"><i class="fa fa-trash"></i></button>
                    </form>
                    @else
                    <a class="btn" href="{{ route('seller.license-key') }}"><i class="fa fa-plus"></i></a>
                    <button class="btn" id="seller_showproduct" data-toggle="modal" data-id="{{ $product->id }}"><i class="fa fa-eye"></i></button>
                    @endif
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>