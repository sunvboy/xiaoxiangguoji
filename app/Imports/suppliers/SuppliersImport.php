<?php

namespace App\Imports\suppliers;

use App\Models\Suppliers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SuppliersImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        return new Suppliers([
            'title' => $row[0],
            'code' => $row[1],
            'category_id' => $row[2],
            'phone' => $row[3],
            'email' => $row[4],
            'label' => $row[5],
            'address' => $row[6],
            'city_id' => $row[7],
            'district_id' => $row[8],
            'ward_id' => $row[9],
            'fax' => $row[10],
            'taxNumber' => $row[11],
            'website' => $row[12],
            'debt' => $row[13],
            'description' => $row[14],
            'payment' => $row[15],
            'user_id' => $row[16],
        ]);
    }
}
