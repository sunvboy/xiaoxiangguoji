<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\DealInvoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class DealInvoicesExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithColumnWidths
{
    protected $date_start;
    protected $date_end;
    protected $user_id;
    protected $status;
    public function __construct($date_start, $date_end, $user_id, $status)
    {
        $this->date_start = $date_start;
        $this->date_end = $date_end;
        $this->user_id = $user_id;
        $this->status = $status;
    }
    public function collection()
    {
        $data = DealInvoice::where(['deleted_at' => null])->with(['deal'])->orderBy('id', 'desc');
        $date_start =  !empty($this->date_start) ? \Carbon\Carbon::createFromFormat('d/m/Y', $this->date_start)->format('Y-m-d') : '';
        $date_end = !empty($this->date_end) ? \Carbon\Carbon::createFromFormat('d/m/Y', $this->date_end)->format('Y-m-d') : '';
        if (isset($date_start) && !empty($date_start) && empty($date_end)) {
            $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00')->where('date_end', '<=', $date_start . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && empty($date_start)) {
            $data =  $data->where('date_end', '>=', $date_end . ' 00:00:00')->where('date_end', '<=', $date_end . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && isset($date_start) && !empty($date_start)) {
            if ($date_end == $date_start) {
                $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00');
            } else {
                $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00')->where('date_end', '<=', $date_end . ' 23:59:59');
            }
        }
        if (!empty($this->user_id)) {
            $data = $data->where('user_id', $this->user_id);
        }
        if (!empty($this->status)) {
            $data = $data->where('status', $this->status);
        }
        $data = $data->get();
        return $data;
    }
    public function headings(): array
    {
        return [
            'ID',
            'TRẠNG THÁI',
            'DANH MỤC',
            'DEAL',
            'TIÊU ĐỀ HÓA ĐƠN',
            'PHÂN LOẠI',
            'DUY TRÌ',
            'SẢN PHẨM',
            'TIỀN HÓA ĐƠN (VNĐ)',
            'THÔNG TIN NGUỒN',
            'NGÀY THANH TOÁN',
            'CÔNG TY',
            'CHỊU TRÁCH NGHIỆM',
        ];
    }
    public function map($row): array
    {
        $duytri = '';
        $duytri = !empty($row->deal->tag_id) ? json_decode($row->deal->tag_id, TRUE) : [];
        return [
            $row->id,
            !empty($row->status) ? "Đã thanh toán" : "Chưa thanh toán",
            !empty($row->category_products) ? $row->category_products->title : '',
            !empty($row->deal) ? $row->deal->title : '',
            $row->title,
            !empty($row->deal) ? $row->deal->brand_id : '',
            collect($duytri)->join(', '),
            !empty($row->deal->deal_relationships) ? $row->deal->deal_relationships->pluck('title')->join(',') : "",
            $row->price,
            $row->tax,
            $row->comment,
            !empty($row->date_end) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $row->date_end)->format('d/m/Y') : '',
            !empty($row->deal) ? (!empty($row->deal->customer) ? $row->deal->customer->name : '') : "",
            !empty($row->user) ? $row->user->name : ""
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:N1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF17a2b8');
                $event->sheet->setAutoFilter($cellRange);
            },
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 10,
            'C' => 20,
            'D' => 60,
            'E' => 60,
            'F' => 20,
            'G' => 20,
            'H' => 20,
            'I' => 20,
            'J' => 20,
            'K' => 20,
            'L' => 20,
            'M' => 20,
            'N' => 20,
        ];
    }
}
