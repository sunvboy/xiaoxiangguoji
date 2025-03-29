<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\DealBrandTmp;
use App\Models\Product;
use Carbon\Carbon;
use App\Models\Suppliers;
use App\Models\TimeSheets;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CustomersSheetTowImport implements ToModel, WithStartRow
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
        return new DealBrandTmp([
            "source_date_start" => !empty($row[12]) ?  $row[12] : null,
            "source_date_end" => !empty($row[13]) ?  $row[13] : null,
            "date_end" => !empty($row[8]) ? $row[8] : '',
            "id_old" => !empty($row[0]) ? $row[0] : '',
        ]);
        /*$category_products = CategoryProduct::where('title', $row[2])->first();
        $customer = Customer::where('name', $row[8])->first();
        $users_support = User::where('name', $row[19])->get()->pluck('id');
        $userid_created = User::where('name', $row[17])->first();
        $created_at = $row[16];
        if (!empty($created_at)) {
            $created_at = DateTime::createFromFormat('d/m/Y H:i:s', $created_at);
            if (empty($created_at)) {
                $created_at = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[16]))->format('Y-m-d H:i:s');
            } else {
                $created_at = $created_at->format('Y-m-d H:i:s');
            }
        }
        return new Deal([
            "id_old" => !empty($row[0]) ? $row[0] : '',
            "title" => !empty($row[1]) ? $row[1] : '',
            'catalogue_id' => !empty($category_products) ? $category_products->id : 5,
            "website" => !empty($row[3]) ? $row[3] : '',
            "source_description" => !empty($row[6]) ? $row[6] : '',
            "customer_id" => !empty($customer) ? $customer->id : '',
            "source_date_start" => !empty($row[13]) ?  $row[13] : null,
            "source_date_end" => !empty($row[14]) ?  $row[14] : null,
            "address" => !empty($row[15]) ? $row[15] : '',
            "created_at" => $created_at,
            "userid_created" => !empty($row[17]) ? !empty($userid_created) ? $userid_created->id : 0 : 0,
            "status" => !empty($row[18]) ? $row[18] : '',
            "users_support" => !empty($row[19]) ? json_encode($users_support) : '',
            "type" => !empty($row[20]) ? $row[20] : '',
            "file" => !empty($row[21]) ? $row[21] : '',
        ]); */

        /*$catalogue_id = CategoryProduct::where('title', $row[0])->first();
        $catalogue_child_id_1 = CategoryProduct::where('title', $row[3])->first();
        $catalogue_child_id_2 = CategoryProduct::where('title', $row[4])->first();
        $catalogue = [];
        if (!empty($catalogue_child_id_1)) {
            $catalogue[]  = $catalogue_child_id_1->id;
        }
        if (!empty($catalogue_child_id_2)) {
            $catalogue[]  = $catalogue_child_id_2->id;
        }
        return new Product([
            "title" => !empty($row[1]) ? $row[1] : '',
            "catalogue_id" => !empty($catalogue_id) ? $catalogue_id->id : 5,
            'catalogue' => json_encode($catalogue),
            "publish" => 0,
            "price" =>  !empty($row[2]) ? $row[2] : 0,
            "userid_created" => Auth::user()->id,
            "created_at" => Carbon::now(),
            'alanguage' => config('app.locale'),
        ]); */
        // if (!empty($row[0])) {
        //     return new Brand([
        //         "title" => !empty($row[0]) ? $row[0] : '',
        //         "userid_created" => Auth::user()->id,
        //         "created_at" => Carbon::now(),
        //         'alanguage' => config('app.locale'),
        //     ]);
        // }

        /*if (!empty($row[0])) {
            return new CategoryProduct([
                "title" => !empty($row[0]) ? $row[0] : '',
                "parentid" => 1,
                "userid_created" => Auth::user()->id,
                "created_at" => Carbon::now(),
                'alanguage' => config('app.locale'),
            ]);
        } */
        /*return new CategoryProduct([
            "title" => !empty($row[0]) ? $row[0] : '',
            "parentid" => 1,
            "userid_created" => Auth::user()->id,
            "created_at" => Carbon::now(),
            'alanguage' => config('app.locale'),
        ]); */
        /*if (!empty($row[9])) {
            $created_at = $row[9];
            $created_at = DateTime::createFromFormat('d/m/Y H:i:s', $created_at);
            if (empty($created_at)) {
                $created_at = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[9]))->format('Y-m-d H:i:s');
            } else {
                $created_at = $created_at->format('Y-m-d H:i:s');
            }
        }
        $userid_created = User::where('name', $row[10])->first();

        $catalogue_id = 0;
        if (!empty($row[2])) {
            if (!empty($row[2])) {
                if ($row[2] == 'Cá nhân') {
                    $catalogue_id = 1;
                } else if ($row[2] == 'Công ty') {
                    $catalogue_id = 2;
                }
            }
        }

        return new Customer([
            "id_old" => !empty($row[0]) ? $row[0] : '',
            "name" => !empty($row[1]) ? $row[1] : '',
            "catalogue_id" => $catalogue_id,
            "note" => !empty($row[8]) ? $row[8] : null,
            "hotline" => !empty($row[3]) ? $row[3] : null,
            "website" => !empty($row[5]) ? $row[5] : '',
            "email" => !empty($row[6]) ? $row[6] : '',
            "address" => !empty($row[7]) ? $row[7] : '',
            "userid_created" => !empty($userid_created) ? $userid_created->id : null,
            "userid_updated" => !empty($userid_created) ? $userid_created->id : null,
            "created_at" => !empty($created_at) ? $created_at : '',
            "updated_at" => !empty($created_at) ? $created_at : '',
        ]); */
    }
}
