<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\DealBrandTmp;
use App\Models\DealInvoice;
use App\Models\DealInvoiceTmp;
use App\Models\Product;
use App\Models\ProductCustom;
use Carbon\Carbon;
use App\Models\Suppliers;
use App\Models\TimeSheets;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductItemImport implements ToModel, WithStartRow
{
    /**
     * @param Collection $collection
     */
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        return new ProductCustom([
            "product_code" => !empty($row[0]) ?  $row[0] : null,
            "so_dang_ky" => !empty($row[1]) ?  $row[1] : null,
            "hoat_chat" => !empty($row[2]) ?  $row[2] : null, //ngày lập hóa đơn
            "ham_luong" => !empty($row[3]) ? $row[3] : '',
            "hang_san_xuat" => !empty($row[4]) ? $row[4] : '',
            "nuoc_san_xuat" => !empty($row[5]) ? $row[5] : '',
            "quy_cach_dong_goi" => !empty($row[6]) ? $row[6] : '',
            "duong_dung" => !empty($row[7]) ? $row[7] : '',
        ]);
        // $deal = Deal::where('title', $row[3])->first();
        // $user = User::where('name', $row[12])->first();
        // return new DealInvoice([
        //     "id_old" => !empty($row[0]) ? $row[0] : '',
        //     "title" => !empty($row[1]) ? $row[1] : '',
        //     'status' => !empty($row[2]) ? $row[2] : '',
        //     "deal_id" => !empty($deal) ? $deal->id : '',
        //     "customer_id" => !empty($deal) ? $deal->customer_id : '',
        //     "type" => !empty($row[5]) ?  $row[5] : null,
        //     "tax" => !empty($row[6]) ?  $row[6] : 0,
        //     "price" => !empty($row[7]) ?  $row[7] : 0,
        //     // "created_at" => !empty($row[8]) ?  $row[8] : null,
        //     // "date_end" => !empty($row[9]) ?  $row[9] : null,
        //     // "source_date_end" => !empty($row[10]) ?  $row[10] : null,
        //     "note" => !empty($row[11]) ?  $row[11] : null,
        //     "user_id" => !empty($user) ?  $user->id : 17,
        //     "comment" => !empty($row[13]) ?  $row[13] : null,
        //     'payment' =>  !empty($row[14]) ?  $row[14] : null,
        // ]);
    }
}
