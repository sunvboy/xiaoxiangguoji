<?php

namespace App\Http\Controllers\product\backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductStockHistory;
use Illuminate\Http\Request;

class AjaxProductController extends Controller
{

    public function addressStock(Request $request)
    {
        $addressID = $request->addressID;
        $productID = $request->productID;
        $detail  = Product::find($productID);
        $data = ProductStock::where(['product_id' => $productID, 'address_id' => $addressID, 'type' => $detail->type])->with('product_versions')->get();
        $html = '';
        if (!$data->isEmpty()) {
            foreach ($data as $key => $item) {
                $html .= '<tr>
                                <td class="whitespace-nowrap">
                                    ' . collect(json_decode($item->product_versions->title_version, TRUE))->join(', ', '') . '
                                </td>
                                <td class="whitespace-nowrap">
                                   ' . $item->value . '
                                </td>
                                <td class="whitespace-nowrap">';
                if ($item->product_versions->_stock_status == 1 && $item->product_versions->_outstock_status == 0) {
                    $html .= $item->value - $item->stockDeal;
                } else {
                    $html .= "∞+";
                }
                $html .= '</td>
                                <td class="whitespace-nowrap">
                                    ' . $item->stockOrder . '
                                </td>
                                <td class="whitespace-nowrap">
                                    ' . $item->stockComing . '
                                </td>
                            </tr>';
            }
        }
        return response()->json($html);
    }
    public function productStockHistories(Request $request)
    {
        $addressID = $request->addressID;
        $productID = $request->productID;
        $date = $request->date;
        $data = ProductStockHistory::where(['product_id' => $productID])->with(['user', 'product_versions', 'address']);
        if (!empty($addressID)) {
            $data = $data->where(['address_id' => $addressID]);
        }
        if (!empty($date)) {
            $date =  explode(' to ', $date);
            $date_start = trim($date[0] . ' 00:00:00');
            $date_end = trim($date[1] . ' 23:59:59');
            if ($date[0] != $date[1]) {
                $data =  $data->where('created_at', '>=', $date_start)->where('created_at', '<=', $date_end);
            }
        }
        $data = $data->paginate(20);
        $html = '';
        $paginate = '';
        if (!$data->isEmpty()) {
            foreach ($data as $key => $item) {
                $titleVersion = !empty($item->product_versions->title_version) ? collect(json_decode($item->product_versions->title_version, TRUE))->join(', ', '') : '';
                $userName = !empty($item->user->name) ? $item->user->name : '';
                $class = !empty($item->type == 'plus') ? "text-success"  : "text-danger";
                $addressName = !empty($item->address->title) ? $item->address->title : '';
                $html .= '<tr>
                                <td class="whitespace-nowrap"> ' . $item->created_at . ' </td>
                                <td class="whitespace-nowrap">
                                    ' . $titleVersion . '
                                </td>
                                <td class="whitespace-nowrap">' . $userName . '</td>
                                <td>
                                    ' . $item->note . '
                                </td>
                                <td class="' . $class . '  font-bold">';
                if ($item->type == 'plus') {
                    $html .= '+';
                } else {
                    $html .= '-';
                }
                $html .= $item->quantity . '
                                </td>
                                <td class="whitespace-nowrap"> ' . $item->stock . '</td>
                                <td class="whitespace-nowrap"> ' . $addressName . '</td>
                            </tr>';
            }
            $paginate .= $data->links();
        }
        return response()->json(['html' => $html, 'paginate' => $paginate]);
    }
}
