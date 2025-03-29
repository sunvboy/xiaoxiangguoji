<?php
return [
    'method' => [
        '0' => 'Chọn hình thức thanh toán',
        'money' => 'Tiền mặt',
        'banking' => 'Chuyển khoản',
        'cart' => 'Quẹt thẻ',
        'other' => 'Khác',
    ],
    'status' => [
        '0' => 'Trạng thái',
        'draft' => 'Đặt hàng',
        'active' => 'Đang giao dịch',
        'closed' => 'Kết thúc',
        'completed' => 'Hoàn thành',
        'cancelled' => 'Đã hủy',
    ],
    'receiveStatus' => [
        '0' => 'Trạng thái nhập kho',
        'pending' => 'Chờ nhập hàng',
        'received' => 'Đã nhập hàng',
        'partially_returned' => 'Hoàn trả một phần',
        'returned' => 'Hoàn trả toàn bộ'
    ],
    'financialStatus' => [
        '0' => 'Trạng thái thanh toán',
        'pending' => 'Chưa thanh toán',
        'partially_paid' => 'Thanh toán một phần',
        'paid' => 'Đã thanh toán',
        'partially_refunded' => 'Hoàn tiền một phần',
        'refunded' => 'Hoàn tiền toàn bộ',
    ],
    'statusColor' => [
        'draft' => 'text-primary',
        'active' => 'text-pending',
        'closed' => 'text-warning',
        'completed' => 'text-success',
        'cancelled' => 'text-danger',
    ],
    'receiveStatusColor' => [
        'pending' => 'text-primary',
        'received' => 'text-success',
        'partially_returned' => 'text-danger',
        'returned' => 'text-pending'
    ],
    'financialStatusColor' => [
        'pending' => 'text-primary',
        'partially_paid' => 'text-warning',
        'paid' => 'text-success',
        'partially_refunded' => 'text-danger',
        'refunded' => 'text-pending',
    ]
];
