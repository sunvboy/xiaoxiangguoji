<?php

namespace App\Exports\suppliers;

use App\Models\Suppliers;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class SuppliersExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithColumnWidths
{
    public function collection()
    {
        return Suppliers::with(['categories', 'city_name', 'district_name', 'ward_name'])->get();
    }
    public function headings(): array
    {
        return [
            'Tên nhà cung cấp',
            'Mã nhà cung cấp',
            'Nhóm nhà cung cấp',
            'Số điện thoại',
            'Email',
            'Website',
            'Fax',
            'Mã số thuế',
            'Mô tả',
            'Phương thức thanh toán mặc định',
            'Nhãn',
            'Địa chỉ',
            'Tỉnh/Thành phố',
            'Quận/Huyện',
            'Phường/Xã',
            'Công nợ',
        ];
    }
    public function map($row): array
    {
        return [
            $row->title,
            $row->code,
            $row->categories->title,
            $row->phone,
            $row->email,
            $row->website,
            $row->fax,
            $row->taxNumber,
            $row->description,
            $row->payment,
            $row->label,
            $row->address,
            $row->city_name->name,
            $row->district_name->name,
            $row->ward_name->name,
            number_format($row->debt),
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:P1'; // All headers
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
            'A' => 20,
            'B' => 20,
            'C' => 50,
            'D' => 20,
            'E' => 40,
            'F' => 30,
            'G' => 20,
            'H' => 30,
            'I' => 50,
            'J' => 30,
            'K' => 20,
            'L' => 50,
            'M' => 20,
            'N' => 20,
            'O' => 20,
            'P' => 20,
        ];
    }
}
