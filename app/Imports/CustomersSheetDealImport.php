<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\DealBrandTmp;
use App\Models\DealRelationships;
use App\Models\Product;
use Carbon\Carbon;
use App\Models\Suppliers;
use App\Models\TimeSheets;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CustomersSheetDealImport implements ToModel, WithStartRow
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
        // $catalogue_id = Brand::where('title', $row[19])->first();
        // return new DealBrandTmp([
        //     "id_old" => !empty($row[0]) ? $row[0] : 0,
        //     "brand_id" => !empty($catalogue_id) ? $catalogue_id->id : '',
        // ]);
        /*$catalogue_id = CategoryProduct::where('title', $row[20])->first();
        return new DealRelationships([
            "catalogue_id" => !empty($catalogue_id) ? $catalogue_id->id : 6,
            "deal_id" => !empty($row[0]) ? $row[0] : '',
            "title" => !empty($row[14]) ? $row[14] : '',
            "price" => !empty($row[15]) ? $row[15] : 0,
            "quantity" => !empty($row[16]) ? $row[16] : 0,
        ]); */
        /*$category_products = CategoryProduct::where('title', $row[1])->first();
        $catalogue_child_id = [];
        if (!empty($row[18])) {
            $catalogue_child_id[] = $row[18];
        }
        if (!empty($row[20])) {
            $catalogue_child_id[] = $row[20];
        }
        $catalogue_child_ids = CategoryProduct::whereIn('title', $catalogue_child_id)->get()->pluck('id');
        $customer = Customer::where('id_old', $row[22])->first();
        $userid_created = User::where('name', $row[9])->first();
        $users_support = User::where('name', $row[10])->get()->pluck('id');
        $created_at = $row[8];
        if (!empty($created_at)) {
            $created_at = DateTime::createFromFormat('d/m/Y H:i:s', $created_at);
            if (empty($created_at)) {
                $created_at = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8]))->format('Y-m-d H:i:s');
            } else {
                $created_at = $created_at->format('Y-m-d H:i:s');
            }
        }

        return new Deal([
            "id_old" => !empty($row[0]) ? $row[0] : '',
            "title" => !empty($row[2]) ? $row[2] : '',
            'catalogue_id' => !empty($category_products) ? $category_products->id : 6,
            'catalogue_child_id' => !empty($catalogue_child_ids) ? json_encode($catalogue_child_ids) : null,
            "website" => !empty($row[3]) ? $row[3] : '',
            "type" => !empty($row[4]) ? $row[4] : '',
            "source" => !empty($row[5]) ? $row[5] : '',
            "source_description" => !empty($row[6]) ? $row[6] : '',
            "created_at" => $created_at,
            "date_end" => $created_at,
            "customer_id" => !empty($customer) ? $customer->id : '',
            "source_date_start" => !empty($row[12]) ?  $row[12] : null,
            "source_date_end" => !empty($row[13]) ?  $row[13] : null,
            "address" =>  !empty($address) ? $customer->address : '',
            "status" => !empty($row[11]) ? $row[11] : '',
            "userid_created" => !empty($row[17]) ? !empty($userid_created) ? $userid_created->id : 0 : 0, //đã tạo bởi
            "users_support" => !empty($row[19]) ? json_encode($users_support) : '', //chịu trách nghiệm
            "file" => !empty($row[21]) ? $row[21] : '',
        ]); */
    }
}
