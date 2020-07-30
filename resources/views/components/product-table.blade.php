<table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
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
            <td>
                <img src="product_manager/fetch_icon/{{ $product->id }}">
            </td>
            <td>{{$product->name_pro}}</td>
            <td>{{$product->description_pro}}</td>
            <td>{{$product->created_at}}</td>
            <td>{{$product->updated_at}}</td>
            <td>{{$product->price_license}}</td>
            <td>
                <div class="d-flex flex-nowrap">
                    @if(Auth::guard('manager')->user()->role == 1)
                    <a class="btn" href="{{ route('admin.license-key') }}"><i class="fa fa-plus"></i></a>
                    <button class="btn" id="show-product" data-toggle="modal" data-target="#viewProduct"><i class="fa fa-eye"></i></button>
                    <button class="btn" data-toggle="modal" data-target="#editProduct"><i class="fa fa-edit"></i></button>
                    <form action="{{ route('product_manager.destroy',$product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn" type="submit" data-toggle="modal" onclick="return confirm('Are you sure ????');"><i class="fa fa-trash"></i></button>
                        <!-- <button class="btn" data-toggle="modal" data-target="#deleteProduct"><i class="fa fa-trash"></i></button> -->
                    </form>
                    @else
                    <a class="btn" href="{{ route('seller.license-key') }}"><i class="fa fa-plus"></i></a>
                    <button class="btn" data-toggle="modal" data-target="#viewProduct"><i class="fa fa-eye"></i></button>
                    @endif
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
    <!-- <tbody>
        <tr>
            <td><img src="/img/samsung.jpg" alt=""></td>
            <td>Máy Tính Bảng Samsung Galaxy Tab A8 8" T295 (2019)</td>
            <td>Máy Tính Bảng Samsung Galaxy Tab A8 8" T295 (2019) sở hữu kính thước màn hình lớn đem lại
                không gian sử dụng thoải mái. Màn hình của chiếc máy tính bảng Samsung được thiết kế theo tỷ
                lệ 16:10 rất lý tưởng cho việc đọc sách, tạp chí, đọc báo hoặc lướt web. Đặc biệt với độ
                phân giải 1280 x 800 pixels cho hình ảnh hiển thị chi tiết, giúp bạn thoải mái lướt web hay
                xem phim phụ đề mà không mỏi mắt.</td>
            <td>2011/04/25</td>
            <td>2012/05/11</td>
            <td>$320,800</td>
            <td>
                <div class="d-flex flex-nowrap">
                    @if(Auth::guard('manager')->user()->role == 1)
                        <a class="btn" href="{{ route('admin.license-key') }}"><i class="fa fa-plus"></i></a>
                        <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                class="fa fa-eye"></i></button>
                        <button class="btn" data-toggle="modal" data-target="#editProduct"><i
                                class="fa fa-edit"></i></button>
                        <button class="btn" data-toggle="modal" data-target="#deleteProduct"><i
                                class="fa fa-trash"></i></button>
                    @else
                        <a class="btn" href="{{ route('seller.license-key') }}"><i class="fa fa-plus"></i></a>
                        <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                class="fa fa-eye"></i></button>
                    @endif
                </div>
            </td>
        </tr>
        <tr>
            <td><img src="/img/vivo.jpg" alt=""></td>
            <td>Laptop Asus Vivobook A512DA-EJ422T AMD R5-3500U/Win10 (15.6 FHD)</td>
            <td>Laptop Asus Vivobook A512DA-EJ422T AMD R5-3500U/Win10 (15.6 FHD) có sẵn theo nhiều màu hoàn
                thiện khác nhau để phù hợp với phong cách của bạn. Màu Bạc trong mang đến diện mạo bóng bẩy
                và tinh tế, hoặc hãy chọn màu Xám đá để tinh tế theo kiểu trầm lắng hơn. Bắt đầu một xu
                hướng mới với màu Xanh lông công đổi màu đặc biệt: một lựa chọn độc đáo có thể thay đổi màu
                sắc khi nhìn từ những góc độ khác nhau. Nếu thực sự muốn nổi bật, bạn có thể chọn màu Hồng
                san hô với lớp hoàn thiện tươi sáng.</td>
            <td>2011/06/11</td>
            <td>2011/07/25</td>
            <td>$170,750</td>
            <td>
                <div class="d-flex flex-nowrap">
                    @if(Auth::guard('manager')->user()->role == 1)
                        <a class="btn" href="{{ route('admin.license-key') }}"><i class="fa fa-plus"></i></a>
                        <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                class="fa fa-eye"></i></button>
                        <button class="btn" data-toggle="modal" data-target="#editProduct"><i
                                class="fa fa-edit"></i></button>
                        <button class="btn" data-toggle="modal" data-target="#deleteProduct"><i
                                class="fa fa-trash"></i></button>
                    @else
                        <a class="btn" href="{{ route('seller.license-key') }}"><i class="fa fa-plus"></i></a>
                        <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                class="fa fa-eye"></i></button>
                    @endif
                </div>
            </td>
        </tr>
        <tr>
            <td><img src="/img/fujifilm.jpg" alt=""></td>
            <td>Máy Ảnh Fujifilm X-T100 + Lens 15-45mm (24.2MP)</td>
            <td>Máy Ảnh Fujifilm X-T100 + Lens 15-45mm kết hợp kiểu retro với chức năng hiện đại, có kiểu
                dáng đẹp, cấu hình nhỏ gọn và bề ngoài tinh tế, là một máy ảnh đa năng hoàn hảo cho việc
                chụp hằng ngày. Fujifilm X-T100 là kết hợp của ngoại hình và tính năng giữa máy ảnh Fujifilm
                X-A5 và Fujifilm X-T20, có vẻ như đây là phiên bản tầm trung được kì vọng sẽ đáp ứng được
                phân khúc khách hàng là những người dùng mới tiếp xúc với máy ảnh nhưng vẫn đảm bảo được
                hiệu năng sử dụng và chất lượng ảnh.
            </td>
            <td>2009/01/12</td>
            <td>2009/07/22</td>
            <td>$86,000</td>
            <td>
                <div class="d-flex flex-nowrap">
                    @if(Auth::guard('manager')->user()->role == 1)
                        <a class="btn" href="{{ route('admin.license-key') }}"><i class="fa fa-plus"></i></a>
                        <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                class="fa fa-eye"></i></button>
                        <button class="btn" data-toggle="modal" data-target="#editProduct"><i
                                class="fa fa-edit"></i></button>
                        <button class="btn" data-toggle="modal" data-target="#deleteProduct"><i
                                class="fa fa-trash"></i></button>
                    @else
                        <a class="btn" href="{{ route('seller.license-key') }}"><i class="fa fa-plus"></i></a>
                        <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                class="fa fa-eye"></i></button>
                    @endif
                </div>
            </td>
        </tr>
        <tr>
            <td><img src="/img/lg.jpg" alt=""></td>
            <td>Tai nghe Bluetooth LG HBS-510</td>
            <td>tai nghe Bluetooth LG HBS-510 mang thiết kế sành điệu, phù hợp với người dùng trẻ, năng
                động, thời gian nghe nhạc và đàm thoại đáp ứng được cho cả ngày sử dụng, thích hợp cho những
                chuyến đi xa.</td>
            <td>2012/01/30</td>
            <td>2012/03/29</td>
            <td>$433,060</td>
            <td>
                <div class="d-flex flex-nowrap">
                    @if(Auth::guard('manager')->user()->role == 1)
                        <a class="btn" href="{{ route('admin.license-key') }}"><i class="fa fa-plus"></i></a>
                        <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                class="fa fa-eye"></i></button>
                        <button class="btn" data-toggle="modal" data-target="#editProduct"><i
                                class="fa fa-edit"></i></button>
                        <button class="btn" data-toggle="modal" data-target="#deleteProduct"><i
                                class="fa fa-trash"></i></button>
                    @else
                        <a class="btn" href="{{ route('seller.license-key') }}"><i class="fa fa-plus"></i></a>
                        <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                class="fa fa-eye"></i></button>
                    @endif
                </div>
            </td>
        </tr>
        <tr>
            <td><img src="/img/jbl.jpg" alt=""></td>
            <td>Loa Bluetooth JBL Pulse 4</td>
            <td>Loa Bluetooth JBL Pulse 4 với thiết kế thay đổi đáng kể phần chân đế đã biến mất làm cho
                loa trở nên trong suốt, tổng thể hài hòa thanh thoát hơn. Cho cảm giác loa thực sự chắc
                chắn, một phần nữa là giúp loa được chống rung tốt hơn khi đặt trên mặt phẳng. Các nút điều
                khiển đã được làm dày giúp dễ bấm hơn và được dời lên ở trên vòng loa và chia đều ra làm 3
                nhóm gồm Nguồn / Bluetooth, Partyboost / Lights, Play / Volume.</td>
            <td>2008/11/28</td>
            <td>2009/03/30</td>
            <td>$162,700</td>
            <td>
                <div class="d-flex flex-nowrap">
                    @if(Auth::guard('manager')->user()->role == 1)
                        <a class="btn" href="{{ route('admin.license-key') }}"><i class="fa fa-plus"></i></a>
                        <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                class="fa fa-eye"></i></button>
                        <button class="btn" data-toggle="modal" data-target="#editProduct"><i
                                class="fa fa-edit"></i></button>
                        <button class="btn" data-toggle="modal" data-target="#deleteProduct"><i
                                class="fa fa-trash"></i></button>
                    @else
                        <a class="btn" href="{{ route('seller.license-key') }}"><i class="fa fa-plus"></i></a>
                        <button class="btn" data-toggle="modal" data-target="#viewProduct"><i
                                class="fa fa-eye"></i></button>
                    @endif
                </div>
            </td>
        </tr>
    </tbody> -->
</table>