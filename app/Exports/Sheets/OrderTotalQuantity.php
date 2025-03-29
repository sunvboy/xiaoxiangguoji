<?php

namespace App\Exports\Sheets;

use App\Models\Orders_item;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class OrderTotalQuantity implements WithTitle, FromCollection, WithHeadings, WithMapping, WithEvents, WithColumnWidths
{
    public function collection()
    {
        $data = \App\Models\Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1])->orderBy('id', 'desc');
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
        $data = $data->pluck('id');
        $topProductPayment =  \App\Models\Orders_item::whereIn('order_id', $data)->where(['deleted_at' => '0000-00-00 00:00:00'])
            ->groupBy(DB::raw("product_title"))
            ->orderBy('quantity', 'desc')
            ->limit(8)
            ->get(array(
                DB::raw('SUM(product_quantity) as quantity'),
                DB::raw('product_title'),
                DB::raw('product_unit'),
            ));
        return $topProductPayment;
    }
    public function headings(): array
    {
        return [
            'Tiêu đề',
            'Số lượng',
            'Đơn vị',
        ];
    }
    public function map($row): array
    {
        return [
            $row->product_title,
            $row->quantity,
            $row->product_unit,
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:C1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->getColor()
                    ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF17a2b8');
                $event->sheet->setAutoFilter($cellRange);
            },
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 100,
            'B' => 15,
            'C' => 8,
        ];
    }
    public function title(): string
    {
        return 'Thống kê hàng hóa';
    }
}
