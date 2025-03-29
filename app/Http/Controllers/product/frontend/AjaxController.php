<?php

namespace App\Http\Controllers\product\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Components\Comment as CommentHelper;

class AjaxController extends Controller
{
    protected $comment;
    public function __construct()
    {
        $this->comment = new CommentHelper();
    }


    //load data version khi load trang
    public function product_version(Request $request)
    {
        $type = 'simple';
        $attr = collect(json_decode($request->attr))->sort();
        $module_id = $request->module_id;
        $stt = $request->stt;
        $detailProduct = Product::findOrFail($module_id);
        if (empty($detailProduct)) {
            echo 500;
            die();
        }
        if (empty($stt)) {
            $data = \App\Models\ProductVersion::where(['product_id' => $module_id])->with('product_stocks');
            if (!empty($attr)) {
                foreach ($attr as $item) {
                    $data = $data->whereJsonContains('id_version', (int)$item);
                }
            }
            $data = $data->first();
            $idOutStock = [];
            $idStock = 0;
            if ($data) {
                $idStock = collect(json_decode($data->id_version, TRUE))->sort()->filter(function ($value, $key) use ($attr) {
                    return $key == count($attr) - 1;
                })->join('');
                $type = 'variable';
            }
        } else {
            $data = \App\Models\ProductVersion::where(['product_id' => $module_id])->with('product_stocks')->orderBy('id_version', 'asc');
            if (!empty($attr)) {
                foreach ($attr as $item) {
                    $data = $data->whereJsonContains('id_version', (int)$item);
                }
            }
            $data = $data->orderBy('id', 'desc')->get();
            $idOutStock = $tmpCheck =  [];
            $idStock = 0;
            if (!$data->isEmpty()) {
                //lấy array id của nhưng sản phẩm hết hàng
                foreach ($data as $item) {
                    $_stock = $item->product_stocks->sum('value');
                    //Quản lí kho hàng = 1, Đồng ý cho đặt hàng khi đã hết hàng = 0, Số lượng tồn kho = 0
                    if ($item['_stock_status'] == 1 && $item['_outstock_status']  == 0 && $_stock == 0) {
                        $idOutStock[] = (int)collect(json_decode($item->id_version, TRUE))->sort()->filter(function ($value, $key) use ($attr) {
                            return $key == count($attr);
                        })->join('');
                    } else {
                        $tmpCheck[] = (int)collect(json_decode($item->id_version, TRUE))->sort()->filter(function ($value, $key) use ($attr) {
                            return $key == count($attr);
                        })->join('');
                    }
                }
                $type = 'variable';
                if (!empty($tmpCheck)) {
                    sort($tmpCheck);
                    $idStock = $tmpCheck[0];
                }
            }
        }

        echo json_encode(['data' => $data, 'idOutStock' => $idOutStock, 'idStock' => $idStock, 'type' => $type]);
        die;
    }
}
