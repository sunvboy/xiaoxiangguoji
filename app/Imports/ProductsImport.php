<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\CustomersSheetTowImport;

class ProductsImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new ProductItemImport('company')
        ];
    }
}
