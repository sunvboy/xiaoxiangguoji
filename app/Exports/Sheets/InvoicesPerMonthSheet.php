<?php

namespace App\Exports\Sheets;

use App\Exports\Sheets\OrderTotalQuantity;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;

class InvoicesPerMonthSheet implements WithTitle, FromView
{
    public function view(): View
    {
        $data = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1])->orderBy('id', 'desc');
        if (!empty($_GET['keyword'])) {
            $data =  $data->where('code', 'like', '%' . $_GET['keyword'] . '%')
                ->orWhere('fullname', 'like', '%' . $_GET['keyword'] . '%')
                ->orWhere('phone', 'like', '%' . $_GET['keyword'] . '%')
                ->orWhere('email', 'like', '%' . $_GET['keyword'] . '%');
        }
        if (!empty($_GET['status'])) {
            $data =  $data->where('status', $_GET['status']);
        }
        if (!empty($_GET['payment'])) {
            $data =  $data->where('payment', $_GET['payment']);
        }
        if (!empty($_GET['customerid'])) {
            $data =  $data->where('customerid', $_GET['customerid']);
        }
        if (!empty($_GET['date'])) {
            $date =  explode(' to ', $_GET['date']);
            $date_start = trim($date[0] . ' 00:00:00');
            $date_end = trim($date[1] . ' 23:59:59');
            if ($date[0] != $date[1]) {
                $data =  $data->where('created_at', '>=', $date_start)->where('created_at', '<=', $date_end);
            }
        }
        $data = $data->get();
        return view('order.backend.export', [
            'orders' => $data
        ]);
    }
    public function title(): string
    {
        return 'Danh sách đơn hàng';
    }
}
