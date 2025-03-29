<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\CustomersSheetTowImport;

class CustomersImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new CustomersInvoicesImport('company')
        ];
    }
}
