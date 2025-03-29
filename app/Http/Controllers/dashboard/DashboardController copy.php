<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Article;
use App\Models\Tour;
use App\Models\TourBook;
use App\Models\Contact;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        //Cập nhập lại session login
        $user = \App\Models\User::where(["id" => Auth::user()->id])->first();
        $temp_permission = [];
        $roles = $user->roles;
        $admin = $roles->where('id', 1)->all();
        foreach ($roles as $k => $v) {
            $permissions = $v->permissions;
            foreach ($permissions as $v2) {
                if ($v2['parent_id'] == 22) {
                    $temp_permission[] = $v2['key_code'];
                }
            }
        }
        setcookie('authImagesManager', json_encode(array(
            'domain' => env('APP_URL_UPLOAD'),
            'email' => $user->email,
            'permission' => $temp_permission,
            'folder_upload' => !empty($admin) ? 'all' : ($user->id * 168) * 168 + 168,
        )), time() + (86400 * 30), '/');
        //end

        $module = 'dashboard';
        $totalProduct = Product::where(['alanguage' => config('app.locale')])->count();
        $totalArticle = Article::where(['alanguage' => config('app.locale')])->count();
        $totalContact = Contact::where(['type' => 'contact'])->count();
        $totalOrder = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1])->count();
        $dropdown = getFunctions();
        //7 ngày qua
        $data = [];
        $date = date('Y-m-d');
        $date = strtotime($date);
        $dateStart = date('Y-m-d', strtotime("-6 day", $date));
        $dayOfWeek = [];
        $returnStatus = [];
        $returnStatusCount = [];
        $dataStatus = [];
        for ($i = 0; $i <= 6; $i++) {
            $dayOfWeek[] = date('Y-m-d', strtotime("+$i day", strtotime($dateStart)));
        }
        if (!empty($dayOfWeek)) {
            $dayOfWeekQuery = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1])->where('created_at', '>=', current($dayOfWeek) . " 00:00:00")->where('created_at', '<=', end($dayOfWeek) . " 23:59:59")
                ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                ->orderBy('created_at', 'asc')
                ->get(array(
                    DB::raw('Date(created_at) as date'),
                    DB::raw('COUNT(*) as "count"'),
                    DB::raw('SUM(total_price) as price'),
                    DB::raw('SUM(total_price_coupon) as price_coupon'),
                    DB::raw('SUM(fee_ship) as fee_ship'),
                ));
            foreach ($dayOfWeek as $k => $value) {
                $data[$value]['x'] = $value;
                $data[$value]['y'] = 0;
            }
            if (count($dayOfWeekQuery) > 0) {
                foreach ($dayOfWeekQuery as $day) {
                    $data[$day->date]['x'] = $day->price + $day->fee_ship - $day->price_coupon;
                    $data[$day->date]['y'] = $day->count;
                }
            }
            /*START: order status */
            foreach (config('cart.status') as $key => $item) {
                $dataStatus[$key] =  Order::where(['status' => $key, 'deleted_at' => '0000-00-00 00:00:00', 'publish' => 1])
                    ->where('created_at', '>=', $dateStart . " 00:00:00")
                    ->where('created_at', '<=', end($dayOfWeek) . " 23:59:59")
                    ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                    ->orderBy('created_at', 'asc')
                    ->get(array(
                        DB::raw('Date(created_at) as date'),
                        DB::raw('COUNT(*) as "count"'),
                        DB::raw('SUM(total_price) as price'),
                        DB::raw('SUM(total_price_coupon) as price_coupon'),
                        DB::raw('SUM(fee_ship) as fee_ship'),
                    ));
            }

            foreach (config('cart.status') as $key => $item) {
                $returnStatus[$key] = $returnStatusCount[$key] = 0;
                if (!empty($dataStatus)) {
                    foreach ($dataStatus[$key] as $item) {
                        $returnStatus[$key] = $returnStatus[$key] + ($item['price'] + $item['fee_ship'] - $item['price_coupon']);
                        $returnStatusCount[$key] = $returnStatusCount[$key] + $item['count'];
                    }
                }
            }
            /*END*/
            /*START: Sản phẩm bán chạy */
            $topProductPayment =  \App\Models\Orders_item::where(['deleted_at' => '0000-00-00 00:00:00'])->where('created_at', '>=', $dateStart . " 00:00:00")
                ->where('created_at', '<=', end($dayOfWeek) . " 23:59:59")
                ->groupBy(DB::raw("product_title"))
                ->orderBy('quantity', 'desc')
                ->limit(8)
                ->get(array(
                    // DB::raw('COUNT(*) as "count"'),
                    DB::raw('SUM(product_quantity) as quantity'),
                    DB::raw('product_title'),
                ));
            /*END*/
        }
        //end
        return view('dashboard.home.index', compact('module', 'dropdown', 'totalProduct', 'totalArticle', 'totalContact', 'data',  'totalOrder', 'returnStatus', 'returnStatusCount', 'topProductPayment'));
    }
    public function searchOrder(Request $request)
    {
        $value = $request->value;
        $data = [];
        if ($value == 'week') {
            //7 ngày qua
            $date = date('Y-m-d');
            $date = strtotime($date);
            $dateStart = date('Y-m-d', strtotime("-6 day", $date));
            $dayOfWeek = [];
            for ($i = 0; $i <= 6; $i++) {
                $dayOfWeek[] = date('Y-m-d', strtotime("+$i day", strtotime($dateStart)));
                // echo strtotime( '+1 days' )->format('Y-m-d') . '<br>';
            }
            //endif
            if (!empty($dayOfWeek)) {
                $dayOfWeekQuery = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1])->where('created_at', '>=', current($dayOfWeek) . " 00:00:00")->where('created_at', '<=', end($dayOfWeek) . " 23:59:59")
                    ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                    ->orderBy('created_at', 'asc')
                    ->get(array(
                        DB::raw('Date(created_at) as date'),
                        DB::raw('COUNT(*) as "count"'),
                        DB::raw('SUM(total_price) as price'),
                        DB::raw('SUM(total_price_coupon) as price_coupon'),
                        DB::raw('SUM(fee_ship) as fee_ship'),
                    ));

                foreach ($dayOfWeek as $k => $value) {
                    $data[$value]['x'] = $value;
                    $data[$value]['y'] = 0;
                }
                if (count($dayOfWeekQuery) > 0) {
                    foreach ($dayOfWeekQuery as $day) {
                        $data[$day->date]['x'] = $day->price + $day->fee_ship - $day->price_coupon;
                        $data[$day->date]['y'] = $day->count;
                    }
                }
            }
        } else if ($value == 'month') {
            $dayOfMonthQuery = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1])->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)
                ->select(
                    DB::raw("DAY(created_at) day"),
                    DB::raw("count('day') as count"),
                    DB::raw('SUM(total_price) as price'),
                    DB::raw('SUM(total_price_coupon) as price_coupon'),
                    DB::raw('SUM(fee_ship) as fee_ship'),
                )
                ->groupby('day')
                ->get();

            $start_date =  Carbon::now()->firstOfMonth();
            $end_date =  Carbon::now()->copy()->endOfMonth();
            $start_date_format = Carbon::parse($start_date)->format('d');
            $end_date_format = Carbon::parse($end_date)->format('d');
            for ($i = $start_date_format; $i <= $end_date_format; $i++) {
                $data[date('Y-m') . '-' . str_pad($i, 2, "0", STR_PAD_LEFT)]['x'] = 0;
                $data[date('Y-m') . '-' . str_pad($i, 2, "0", STR_PAD_LEFT)]['y'] = 0;
            }
            if (count($dayOfMonthQuery) > 0) {
                foreach ($dayOfMonthQuery as $day) {
                    $data[date('Y-m') . '-' . str_pad($day->day, 2, "0", STR_PAD_LEFT)]['x'] = $day->price + $day->fee_ship - $day->price_coupon;
                    $data[date('Y-m') . '-' . str_pad($day->day, 2, "0", STR_PAD_LEFT)]['y'] = $day->count;
                }
            }
        } else if ($value == 'month_before') {
            //lấy tháng trước
            $month = (int)Carbon::now()->month - 1;
            if ($month == 1) {
                $year = (int)Carbon::now()->year - 1;
            } else {
                $year = (int)Carbon::now()->year;
            }
            $dayOfMonthQuery = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1])->whereMonth('created_at', $month)->whereYear('created_at', $year)
                ->select(
                    DB::raw("DAY(created_at) day"),
                    DB::raw("count('day') as count"),
                    DB::raw('SUM(total_price) as price'),
                    DB::raw('SUM(total_price_coupon) as price_coupon'),
                    DB::raw('SUM(fee_ship) as fee_ship'),
                )
                ->groupby('day')
                ->get();

            $start_date = Carbon::now()->startOfMonth()->subMonth()->toDateString();
            $end_date =  Carbon::now()->subMonth()->endOfMonth()->toDateString();
            $start_date_format = Carbon::parse($start_date)->format('d');
            $end_date_format = Carbon::parse($end_date)->format('d');
            for ($i = $start_date_format; $i <= $end_date_format; $i++) {
                $data[str_pad($i, 2, "0", STR_PAD_LEFT) . '-' . $month . '-' . $year]['x'] = 0;
                $data[str_pad($i, 2, "0", STR_PAD_LEFT) . '-' . $month . '-' . $year]['y'] = 0;
            }
            if (count($dayOfMonthQuery) > 0) {
                foreach ($dayOfMonthQuery as $day) {
                    $data[str_pad($day->day, 2, "0", STR_PAD_LEFT) . '-' . $month . '-' . $year]['x'] = $day->price + $day->fee_ship - $day->price_coupon;
                    $data[str_pad($day->day, 2, "0", STR_PAD_LEFT) . '-' . $month . '-' . $year]['y'] = $day->count;
                }
            }
        } else if ($value == 'year') {
            $totalMonthOfYear = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1])->whereYear('created_at', Carbon::now()->year)
                ->select(
                    DB::raw("MONTH(created_at) month"),
                    DB::raw("count('month') as count"),
                    DB::raw('SUM(total_price) as price'),
                    DB::raw('SUM(total_price_coupon) as price_coupon'),
                    DB::raw('SUM(fee_ship) as fee_ship'),
                )
                ->groupby('month')
                ->get();
            for ($i = 1; $i <= 12; $i++) {
                $data[$i]['x'] = 0;
                $data[$i]['y'] = 0;
            }
            if (count($totalMonthOfYear) > 0) {
                foreach ($totalMonthOfYear as $month) {
                    $data[$month->month]['x'] = $month->price + $month->fee_ship - $month->price_coupon;
                    $data[$month->month]['y'] = $month->count;
                }
            }
        }
        return response()->json([
            'data' => $data
        ]);
    }
    public function searchOrderStatus(Request $request)
    {
        $value = $request->value;
        $returnStatus = [];
        $returnStatusCount = [];
        if ($value == 'week') {
            //7 ngày qua
            $date = date('Y-m-d');
            $date = strtotime($date);
            $dateStart = date('Y-m-d', strtotime("-6 day", $date));
            $dayOfWeek = [];
            for ($i = 0; $i <= 6; $i++) {
                $dayOfWeek[] = date('Y-m-d', strtotime("+$i day", strtotime($dateStart)));
                // echo strtotime( '+1 days' )->format('Y-m-d') . '<br>';
            }
            //endif
            if (!empty($dayOfWeek)) {
                $dataStatus = [];
                foreach (config('cart.status') as $key => $item) {
                    $dataStatus[$key] =  Order::where(['status' => $key, 'deleted_at' => '0000-00-00 00:00:00', 'publish' => 1])
                        ->where('created_at', '>=', $dateStart . " 00:00:00")
                        ->where('created_at', '<=', end($dayOfWeek) . " 23:59:59")
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                        ->orderBy('created_at', 'asc')
                        ->get(array(
                            DB::raw('Date(created_at) as date'),
                            DB::raw('COUNT(*) as "count"'),
                            DB::raw('SUM(total_price) as price'),
                            DB::raw('SUM(total_price_coupon) as price_coupon'),
                            DB::raw('SUM(fee_ship) as fee_ship'),
                        ));
                }
            }
        } else if ($value == 'month') {
            $dataStatus = [];
            foreach (config('cart.status') as $key => $item) {
                $dataStatus[$key] = Order::where(['status' => $key, 'deleted_at' => '0000-00-00 00:00:00', 'publish' => 1])
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->select(
                        DB::raw("DAY(created_at) day"),
                        DB::raw("count('day') as count"),
                        DB::raw('SUM(total_price) as price'),
                        DB::raw('SUM(total_price_coupon) as price_coupon'),
                        DB::raw('SUM(fee_ship) as fee_ship'),
                    )
                    ->groupby('day')
                    ->get();
            }
        } else if ($value == 'month_before') {
            //lấy tháng trước
            $month = (int)Carbon::now()->month - 1;
            if ($month == 1) {
                $year = (int)Carbon::now()->year - 1;
            } else {
                $year = (int)Carbon::now()->year;
            }
            $dataStatus = [];
            foreach (config('cart.status') as $key => $item) {
                $dataStatus[$key] = Order::where(['status' => $key, 'deleted_at' => '0000-00-00 00:00:00', 'publish' => 1])
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->select(
                        DB::raw("DAY(created_at) day"),
                        DB::raw("count('day') as count"),
                        DB::raw('SUM(total_price) as price'),
                        DB::raw('SUM(total_price_coupon) as price_coupon'),
                        DB::raw('SUM(fee_ship) as fee_ship'),
                    )
                    ->groupby('day')
                    ->get();
            }
        } else if ($value == 'year') {
            $dataStatus = [];
            foreach (config('cart.status') as $key => $item) {
                $dataStatus[$key] = Order::where(['status' => $key, 'deleted_at' => '0000-00-00 00:00:00', 'publish' => 1])
                    ->whereYear('created_at', Carbon::now()->year)
                    ->select(
                        DB::raw("MONTH(created_at) month"),
                        DB::raw("count('month') as count"),
                        DB::raw('SUM(total_price) as price'),
                        DB::raw('SUM(total_price_coupon) as price_coupon'),
                        DB::raw('SUM(fee_ship) as fee_ship'),
                    )
                    ->groupby('month')
                    ->get();
            }
        }
        foreach (config('cart.status') as $key => $item) {
            $returnStatus[$key] = $returnStatusCount[$key] = 0;
            if (!empty($dataStatus)) {
                foreach ($dataStatus[$key] as $item) {
                    $returnStatus[$key] = $returnStatus[$key] + ($item['price'] + $item['fee_ship'] - $item['price_coupon']);
                    $returnStatusCount[$key] = $returnStatusCount[$key] + $item['count'];
                }
            }
        }
        return response()->json([
            'returnStatus' => $returnStatus,
            'returnStatusCount' => $returnStatusCount,
        ]);
    }
    public function searchOrderProduct(Request $request)
    {
        $value = $request->value;
        $data = [];
        if ($value == 'week') {
            //7 ngày qua
            $date = date('Y-m-d');
            $date = strtotime($date);
            $dateStart = date('Y-m-d', strtotime("-6 day", $date));
            $dayOfWeek = [];
            for ($i = 0; $i <= 6; $i++) {
                $dayOfWeek[] = date('Y-m-d', strtotime("+$i day", strtotime($dateStart)));
                // echo strtotime( '+1 days' )->format('Y-m-d') . '<br>';
            }
            //endif
            if (!empty($dayOfWeek)) {
                $data = \App\Models\Orders_item::where(['deleted_at' => '0000-00-00 00:00:00'])->where('created_at', '>=', $dateStart . " 00:00:00")
                    ->where('created_at', '<=', end($dayOfWeek) . " 23:59:59")
                    ->groupBy(DB::raw("product_title"))
                    ->orderBy('quantity', 'desc')
                    ->limit(8)
                    ->get(array(
                        DB::raw('SUM(product_quantity) as quantity'),
                        DB::raw('product_title'),
                    ));
            }
        } else if ($value == 'month') {
            $data = \App\Models\Orders_item::where(['deleted_at' => '0000-00-00 00:00:00'])->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy(DB::raw("product_title"))
                ->orderBy('quantity', 'desc')
                ->limit(8)
                ->get(array(
                    DB::raw('SUM(product_quantity) as quantity'),
                    DB::raw('product_title'),
                ));
        } else if ($value == 'month_before') {
            //lấy tháng trước
            $month = (int)Carbon::now()->month - 1;
            if ($month == 1) {
                $year = (int)Carbon::now()->year - 1;
            } else {
                $year = (int)Carbon::now()->year;
            }
            $data = \App\Models\Orders_item::where(['deleted_at' => '0000-00-00 00:00:00'])->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->groupBy(DB::raw("product_title"))
                ->orderBy('quantity', 'desc')
                ->limit(8)
                ->get(array(
                    DB::raw('SUM(product_quantity) as quantity'),
                    DB::raw('product_title'),
                ));
        } else if ($value == 'year') {
            $data = \App\Models\Orders_item::where(['deleted_at' => '0000-00-00 00:00:00'])->whereYear('created_at', Carbon::now()->year)
                ->groupBy(DB::raw("product_title"))
                ->orderBy('quantity', 'desc')
                ->limit(8)
                ->get(array(
                    DB::raw('SUM(product_quantity) as quantity'),
                    DB::raw('product_title'),
                ));
        }
        return response()->json([
            'data' => $data,
        ]);
    }
}
