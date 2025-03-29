<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Họ và tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Tổng tiền</th>
            <th>Sản phẩm</th>
            <th>Trạng thái</th>
            <th>Hình thức thanh toán</th>
            <th>Ngày tạo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $key=>$item)
        <?php $cart = json_decode($item->cart, TRUE); ?>
        <tr>
            <td width="5">{{ $key+1 }}</td>
            <td width="10">{{ $item->code }}</td>
            <td width="25">{{ $item->fullname }}</td>
            <td width="35">{{ $item->email }}</td>
            <td width="15">{{ $item->phone }}</td>
            <td width="70">{{ $item->address }} - {{$item->ward_name->name}} - {{$item->district_name->name}} - {{$item->city_name->name}}</td>
            <td width="15">{{ number_format($item->total_price - $item->total_price_coupon + $item->fee_ship) }}</td>
            <td width="70">
                <?php $cart = json_decode($item->cart, TRUE); ?>
                <?php $total = 0 ?>
                @if($cart)
                @foreach($cart as $k=>$v)
                <?php
                $options = !empty($v['options']['title_version']) ? '- ' . $v['options']['title_version'] : '';
                ?>
                <div>
                    {{$v['title']}} {{$options}}&nbsp;(<strong>Số lượng:</strong> {{$v['quantity']}})
                </div><br>
                @endforeach
                @endif
            </td>
            <td width="20">{{ config('cart.status')[$item->status] }}</td>
            <td width="30">{{ config('cart.payment')[$item->payment] }}</td>
            <td width="25">{{ $item->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>