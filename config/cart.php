<?php
return [
    'coupon' => [
        'fixed_cart_percent' => 'Giảm giá phần trăm giỏ hàng cố định',
        'fixed_cart_money' => 'Giảm giá tiền giỏ hàng cố định',
        'fixed_percent' => 'Giảm giá phần trăm sản phẩm có trong giỏ hàng',
        'fixed_money' => 'Giảm giá tiền sản phẩm có trong giỏ hàng'
    ],
    'payment' => [
        // 'wallet' => 'Số dư ví',
        'COD' => 'Thanh toán khi nhận hàng',
        'BANKING' => 'Chuyển khoản qua ngân hàng',
        // 'MOMO' => 'Thanh toán online qua MOMO',
        // 'VNPAY' => 'Thanh toán online qua VNPAY',
        // 'ZALOPAY' => 'Thanh toán online qua ZaloPay',
        // 'ALEPAY' => 'Thanh toán online qua Alepay'

    ],
    'payment_image' => [
        'COD' => 'https://s3-sgn09.fptcloud.com/lc-public/app-lc/payment/cod.png',
        'BANKING' => 'https://s3-sgn09.fptcloud.com/lc-public/app-lc/payment/card.png',


    ],
    'payment_en' => [
        'wallet' => 'Wallet balance',
        'COD' => 'Payment on delivery',
        'BANKING' => 'Bank transfer',
        'MOMO' => 'Online payment via MOMO',
        'VNPAY' => 'Pay online via VNPAY',
    ],
    'payment_gm' => [
        'wallet' => 'Wallet-Guthaben',
        'COD' => 'Zahlung bei Lieferung',
        'BANKING' => 'Banküberweisung',
        'MOMO' => 'Online-Zahlung über MOMO',
        'VNPAY' => 'Bezahlen Sie online über VNPAY',


    ],
    'payment_tl' => [
        'wallet' => 'ยอดคงเหลือในกระเป๋าเงิน',
        'COD' => 'ชำระเงินปลายทาง',
        'BANKING' => 'โอนเงินผ่านธนาคาร',
        'MOMO' => 'ชำระเงินออนไลน์ผ่าน MOMO',
        'VNPAY' => 'ชำระเงินออนไลน์ผ่าน VNPAY',
    ],
    'status' => [
        'wait' => 'Đang xử lý',
        'pending' => 'Đang giao',
        'completed' => 'Đã giao',
        'canceled' => 'Đã hủy',
        'returns' => 'Trả hàng',
    ],
    'status_en' => [
        'wait' => 'Wait for confirmation',
        'pending' => 'Delivering',
        'completed' => 'Delivered',
        'canceled' => 'Cancelled',
        'returns' => 'Return',
    ],
    'status_gm' => [
        'wait' => 'Warten Sie auf die Bestätigung',
        'pending' => 'Liefern',
        'completed' => 'Geliefert',
        'canceled' => 'Abgesagt',
        'returns' => 'Rückgabe/Erstattung',
    ],
    'status_tl' => [
        'wait' => 'รอการยืนยัน',
        'pending' => 'กำลังส่งมอบ',
        'completed' => 'ส่ง',
        'canceled' => 'ยกเลิก',
        'returns' => 'คืน/คืนเงิน',
    ],
    'class' => [
        'wait' => 'bg-amber-500',
        'pending' => 'bg-sky-500',
        'completed' => 'bg-green-500',
        'canceled' => 'bg-red-500',
        'returns' => 'bg-orange-600',
    ],
    'individual_use' => [
        '0' => 'Cho phép',
        '1' => 'Không cho phép',
    ],
    'inventory' => [
        '0' => 'Không quản lý kho hàng',
        '1' => 'Quản lý kho hàng',
    ],
];
