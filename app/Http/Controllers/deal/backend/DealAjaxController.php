<?php

namespace App\Http\Controllers\deal\backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\DealHistory;
use App\Models\DealInvoice;
use App\Models\DealInvoiceRelationships;
use App\Models\DealView;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class DealAjaxController extends Controller
{
    protected $table = 'deals';

    public function __construct()
    {
        View::share(['module' => $this->table]);
    }
    public function customerAutocomplete(Request $request)
    {
        $data = Customer::select('id', 'name', 'website', 'email', 'hotline')->orderBy('id', 'desc');
        if (is($request->keyword)) {
            $data =  $data->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('hotline', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('website', 'like', '%' . $request->keyword . '%');
        }
        $data = $data->paginate(env('APP_paginate'));
        return response()->json($data);
    }
    public function customer(Request $request)
    {
        $response = [];
        $customer = Customer::find($request->id);
        if (!empty($customer)) {
            $hotline = explode(',', $customer->hotline);
            $email = explode(',', $customer->email);
        }
        $response['address'] = $customer->address;
        $response['phone'] = !empty($hotline) ? $hotline[0] : "";
        $response['email'] = !empty($email) ? $email[0] : "";
        return response()->json(array('customer' => $response));
    }

    public function product(Request $request)
    {
        $keyword = $request->keyword;
        $products = Product::with('detailCategoryProduct')->select('id', 'price', 'title', 'image', 'catalogue_id')
            ->orderBy('title', 'ASC');
        if (!empty($keyword)) {
            $products = $products->where('products.title', 'like', '%' . $keyword . '%');;
        }
        $products = $products->limit(20)->get();
        return response()->json(array('html' => view('deal.backend.products', compact('products'))->render(), 'count' => $products->count()));
    }

    public function note(Request $request)
    {
        $id = $request->id;
        $note = $request->note;
        //ghi lịch sử
        DealHistory::insertGetId([
            'created_at' => Carbon::now(),
            'user_id' => Auth::user()->id,
            'deal_id' => $id,
            'note' => $note
        ]);
        $history = DealHistory::orderBy('id', 'desc')->where('deal_id', $id)->get();
        $action = 'update';
        return response()->json(array('html' => view('deal.backend.histories', compact('history', 'action'))->render()));
    }

    public function status(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $catalogue_id = $request->catalogue_id;
        if ($request->status == 8 || $request->status == 9) {
            Deal::where('id', $id)->update([
                'status' => $status,
                'type' => 0
            ]);
        } else {
            Deal::where('id', $id)->update([
                'status' => $status
            ]);
        }

        //ghi lịch sử
        $active = $request->active;
        if ($catalogue_id == 1 || $catalogue_id == 21199) {
            $active = 'maintain';
        } else {
            $active = 'website';
        }
        if ($active == 'website') {
            $note = "Giai đoạn được thay đổi thành: <b>" . config('tamphat')["status_web"][$status] . "</b>";
        } else {
            $note = "Giai đoạn được thay đổi thành: <b>" . config('tamphat')["status"][$status] . "</b>";
        }

        DealHistory::insertGetId([
            'created_at' => Carbon::now(),
            'user_id' => Auth::user()->id,
            'deal_id' => $id,
            'note' => $note
        ]);
        $history = DealHistory::orderBy('id', 'desc')->where('deal_id', $id)->get();
        $action = 'update';
        $detail = Deal::find($id);
        return response()->json(
            array(
                'status' => view('deal.backend.status', compact('detail', 'action', 'active'))->render(),
                'history' => view('deal.backend.histories', compact('history', 'action'))->render()
            )
        );
    }

    public function searchDomain(Request $request)
    {
        $website = Deal::select('website')->groupBy('website');
        if (is($request->keyword)) {
            $website = $website->where('website', 'like', '%' . $request->keyword . '%');
        }
        $website = $website->get();
        $websites = [];
        if (!empty($website)) {
            foreach ($website as $item) {
                $exp = json_decode($item->website, TRUE);
                if (!empty($exp)) {
                    foreach ($exp as $val) {
                        if (!in_array($val, $websites)) {
                            $websites[] = [
                                'name' => $val,
                                'id' => $item->id,
                            ];
                        }
                    }
                }
            }
        }
        return response()->json(
            array(
                'items' => $websites,
            )
        );
    }

    public function updateDealView(Request $request)
    {
        $module = $this->table;
        $type = $request->type;
        $handle = $request->handle;
        $customer_id = $request->customer_id;
        $catalogue_id = $request->catalogue_id;
        $status = $request->status;
        $type = $request->type;
        $date_end = $request->date_end;
        $product = $request->product;
        $source_date_start = $request->source_date_start;
        $source_date_end = $request->source_date_end;
        $sorts = $request->sorts;
        $active = $request->active;
        $keyword = $request->keyword;
        $keywordDomain = $request->keywordDomain;
        $keywordID = $request->keywordID;
        $company = $request->company;
        $perpage = $request->perpage;
        $catalogue_child_id = $request->catalogue_child_id;
        if ($handle == 'update') {
            DealView::where(['id' => $request->id])->update(['active' => !empty($request->isChecked == 'true') ? 1 : 0]);
        }
        $deal_views = DealView::where('active', 1)->where('type', $active)->get();
        $permissionCheckedIndex = $deal_views->pluck('keyword');
        if ($active == 'website') {
            $data = Deal::where(['deleted_at' => null])->whereNotIn('catalogue_id', [1, 21199])->with(['user_created', 'user_updated', 'deal_relationships']);
            if ($type == 'index') {
                if (empty($sort)) {
                    $data = $data->orderBy('type', 'desc');
                }
            } else if ($type == 'month') {
                $data = $data->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
            } else if ($type == 'experience') {
                $data = $data->whereNotIn('status',  [5, 8]);
            } else if ($type == 'wait') {
                $data = $data->where('type', null);
            } else if ($type == 'status') {
                $data = $data->whereIn('status', [5, 8]);
            }
            if (!empty($catalogue_child_id)) {
                $data = $data->where('catalogue_child_id', 'like', '%' . $catalogue_child_id . '%');
            }
            if (!empty($sorts)) {
                $sort = explode("|", $sorts);
                $data = $data->orderBy($sort[0], $sort[1]);
                $data = $data->orderBy('id', 'desc');
            } else {
                $data = $data->orderBy('id', 'desc');
            }
        } else if ($active == 'vps') {
            $data = Deal::where(['deleted_at' => null])->where('catalogue_id', 21199)->with(['user_created', 'user_updated', 'deal_relationships']);
            if ($type == 'index') {
                $data = $data->orderBy('type', 'desc');
                if (empty($sort)) {
                    $data = $data->orderBy('type', 'desc');
                }
            } else if ($type == 'using') {
                $data = $data->where('type', 1);
            } else if ($type == 'is') {
                $data = $data->where('source_date_end', '>', Carbon::today())
                    ->where('source_date_end', '<', Carbon::now()->addMonth()->endOfMonth());
            } else if ($type == 'expired') {
                $data = $data->where('type', 0);
            }
            if (!empty($sorts)) {
                $sort = explode("|", $sorts);
                $data = $data->orderBy($sort[0], $sort[1]);
                $data = $data->orderBy('id', 'desc');
            } else {
                $data = $data->orderBy('id', 'desc');
            }
        } else {
            $data = Deal::where(['deleted_at' => null, 'catalogue_id' => 1])->with(['user_created', 'user_updated', 'deal_relationships']);
            if ($type == 'index') {
                if (empty($sorts)) {
                    $data = $data->orderBy('type', 'desc')->orderBy('id', 'desc');
                }
            } else if ($type == 'awaiting') {
                $data = $data->where(['status' => 8]);
                if (empty($sorts)) {
                    $data = $data->orderBy('type', 'desc')->orderBy('id', 'desc');
                }
            } else if ($type == 'newly') {
                $data = $data->whereDate('created_at', now()->toDateString());
                if (empty($sorts)) {
                    $data = $data->orderBy('type', 'desc')->orderBy('id', 'desc');
                }
            } else if ($type == 'is') {
                $data = $data->where(['type' => 1])
                    ->where('source_date_end', '>', Carbon::today())
                    ->where('source_date_end', '<', Carbon::now()->addMonth()->endOfMonth());
                if (empty($sorts)) {
                    $data = $data->orderBy('source_date_end', 'asc')->orderBy('type', 'desc')->orderBy('id', 'desc');
                }
            } else if ($type == 'suspend') {
                $data =  $data->where(['status' => 7]);
                if (empty($sorts)) {
                    $data = $data->orderBy('source_date_end', 'desc')->orderBy('type', 'desc')->orderBy('id', 'desc');
                }
            } else if ($type == 'expired') {
                $data = $data->where(['type' => 0]);
                if (empty($sorts)) {
                    $data = $data->orderBy('type', 'desc')->orderBy('id', 'desc');
                }
            } else if ($type == 'using') {
                $data = $data->where(['type' => 1]);
                if (empty($sorts)) {
                    $data = $data->orderBy('type', 'desc')->orderBy('id', 'desc');
                }
            }
            if (!empty($sorts)) {
                $sort = explode("|", $sorts);
                $data = $data->orderBy($sort[0], $sort[1]);
                $data = $data->orderBy('id', 'desc');
            }
            if (!empty($catalogue_child_id)) {
                $data = $data->where('tag_id', 'like', '%' . $catalogue_child_id . '%');
            }
        }


        if (is($request->keyword)) {
            $data =  $data->where('company', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%');
        }
        if (is($request->keywordID)) {
            $data =  $data->where('title', 'like', '%' . $request->keywordID . '%')
                ->orWhere('id', 'like', '%' . $request->keywordID . '%')->orWhere('source_description', 'like', '%' . $request->keywordID . '%');
        }
        if (is($request->keywordDomain)) {
            $data =  $data->where('website', 'like', '%' . $request->keywordDomain . '%');
        }

        if (!empty($product)) {
            $data = $data->where('products', 'like', '%' . $product . '%');
        }
        if (!empty($customer_id)) {
            $data = $data->where('customer_id', $customer_id);
        }
        if (!empty($catalogue_id)) {
            $data = $data->where('catalogue_id', $catalogue_id);
        }
        if (!empty($status)) {
            $data = $data->where('status', (int)$status);
        }
        if (!empty($source_date_start)) {
            $sourceDateStart = explode("/", $source_date_start);
            $data = $data->whereMonth('source_date_start', $sourceDateStart[1])
                ->whereYear('source_date_start', $sourceDateStart[2]);
        }

        if (!empty($source_date_end)) {
            $sourceDateEnd = explode("/", $source_date_end);
            $data = $data->whereMonth('source_date_start', $sourceDateEnd[1])->whereYear('source_date_start', $sourceDateEnd[2]);
        }

        if (!empty($date_end)) {
            $date_end = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d');
            $data = $data->whereDate('date_end', $date_end);
        }
        if (!empty($perpage)) {
            $data = $data->paginate($perpage);
        } else {
            $data = $data->paginate(env('APP_paginate'));
        }
        return response()->json(
            array(
                'html' => view('deal.backend.data', compact('permissionCheckedIndex', 'data', 'active'))->render(),
            )
        );
    }
    public function updatePL(Request $request)
    {
        $id = $request->id;
        $value = $request->value;
        $deal = Deal::find($id);
        $html = '';
        if (!empty($deal)) {
            Deal::where('id', $deal->id)->update([
                'brand_id' => !empty($value) ? $value : null,
            ]);
            //ghi lịch sử
            DealHistory::insertGetId([
                'created_at' => Carbon::now(),
                'user_id' => Auth::user()->id,
                'deal_id' => $id,
                'note' => "Cập nhập phân loại: $value"
            ]);
            return response()->json(
                array(
                    'status' => 200,
                    'html' => $html,
                    'message' => 'Cập nhập phân loại thành công'
                )
            );
        }
        return response()->json(
            array(
                'status' => 500,
                'message' => 'Deal không tồn tại'
            )
        );
    }
    public function updateDT(Request $request)
    {
        $id = $request->id;
        $value = $request->value;
        $deal = Deal::find($id);
        $html = '';
        if (!empty($deal)) {
            $tags = !empty($deal->tag_id) ? json_decode($deal->tag_id, TRUE) : [];
            $tags = collect($tags)->push($value)->unique()->toArray();
            foreach ($tags as $key => $value) {
                if ($value === "Chọn duy trì") {
                    unset($tags[$key]);
                }
            }
            $note = collect($tags)->join(', ');
            Deal::where('id', $deal->id)->update([
                'tag_id' => !empty($tags) ? json_encode($tags) : null,
            ]);
            if (!empty($tags)) {
                foreach ($tags as $t) {
                    $html .= ' <div class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 relative pr-8">
                                    ' . $t . '
                                    <a href="javascript:void(0)" data-value="' . $t . '" data-id="' . $id . '" class="js_removeDT absolute top-1/2 right-2 -translate-y-1/2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                    </a>
                                </div>';
                }
            }
            //ghi lịch sử
            DealHistory::insertGetId([
                'created_at' => Carbon::now(),
                'user_id' => Auth::user()->id,
                'deal_id' => $id,
                'note' => "Cập nhập duy trì: $note"
            ]);
            return response()->json(
                array(
                    'status' => 200,
                    'html' => $html,
                    'message' => 'Cập nhập thành công'
                )
            );
        }
        return response()->json(
            array(
                'status' => 500,
                'message' => 'Deal không tồn tại'
            )
        );
    }
    public function RemoveDT(Request $request)
    {
        $id = $request->id;
        $value = $request->value;
        $deal = Deal::find($id);
        $html = '';
        if (!empty($deal)) {
            $tags = !empty($deal->tag_id) ? json_decode($deal->tag_id, TRUE) : [];
            $tags = collect($tags);
            foreach ($tags as $key => $val) {
                if ($val === "Chọn duy trì" || $val === $value) {
                    unset($tags[$key]);
                }
            }
            $note = collect($tags)->join(', ');
            Deal::where('id', $deal->id)->update([
                'tag_id' => !empty($tags) ? json_encode($tags) : null,
            ]);
            if (!empty($tags)) {
                foreach ($tags as $t) {
                    $html .= ' <div class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 relative pr-8">
                                    ' . $t . '
                                    <a href="javascript:void(0)" data-value="' . $t . '" data-id="' . $id . '" class="js_removeDT absolute top-1/2 right-2 -translate-y-1/2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                    </a>
                                </div>';
                }
            }
            //ghi lịch sử
            DealHistory::insertGetId([
                'created_at' => Carbon::now(),
                'user_id' => Auth::user()->id,
                'deal_id' => $id,
                'note' => "Cập nhập duy trì: $note"
            ]);
            return response()->json(
                array(
                    'status' => 200,
                    'html' => $html,
                    'message' => 'Cập nhập thành công'
                )
            );
        }
        return response()->json(
            array(
                'status' => 500,
                'message' => 'Deal không tồn tại'
            )
        );
    }
    public function createInvoices(Request $request)
    {
        $tax = 0;
        if (!empty($request->status_tax)) {
            $tax = isset($request->price) ? ((int)str_replace('.', '', $request->price) / 100) * (int)$request->status_tax : 0;
        }
        $id = $request->id;
        $deal = Deal::select('source_date_end', 'catalogue_id')->find($request->deal_id);
        $invoices_title = $request->invoices_title;
        $invoices_phan_loai = $request->invoices_phan_loai;
        $invoices_duy_tri = $request->invoices_duy_tri;
        $invoices_price = $request->invoices_price;
        $invoices_quantity = $request->invoices_quantity;
        $invoices_tax = $request->invoices_tax;
        $invoices_tax_price = $request->invoices_tax_price;
        $invoices_price_total = $request->invoices_price_total;
        $deal_invoice_relationships_id = $request->deal_invoice_relationships_id;
        $deal_invoice_relationships = [];

        if ($request->action == 'create') {
            $data = [
                'catalogue_id' => !empty($request->catalogue_id) ? $request->catalogue_id : null,
                'deal_id' => !empty($request->deal_id) ? $request->deal_id : null,
                'title' => !empty($request->title) ? $request->title : null,
                'comment' => !empty($request->comment) ? $request->comment : null,
                'note' => !empty($request->note) ? $request->note : null,
                'status' => !empty($request->status) ? $request->status : 0,
                'price' => !empty($request->invoices_price_1) ? $request->invoices_price_1 : 0,
                'price_tax' => !empty($request->invoices_price_2) ? $request->invoices_price_2 : 0,
                'total' => !empty($request->invoices_price_3) ? $request->invoices_price_3 : 0,
                'date_end' => !empty($request->date_end) ? Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d') : null,
                'source_date_end' => !empty($deal->source_date_end) ? $deal->source_date_end : null,
                'user_id' => !empty($request->user_id) ? $request->user_id : null,
                'status_tax' => !empty($request->status_tax) ? $request->status_tax : null,
                'created_at' => Carbon::now(),
            ];
            $create = DealInvoice::create($data);
            if (!empty($create)) {
                $deal_invoice_id = $create->id;
                //ghi lịch sử
                $DealHistory = "Tạo mới hóa đơn <span class='text-primary'>#$create->id</span> thành công";
            }
        } else {
            $data = [
                'catalogue_id' => !empty($request->catalogue_id) ? $request->catalogue_id : null,
                'deal_id' => !empty($request->deal_id) ? $request->deal_id : null,
                'title' => !empty($request->title) ? $request->title : null,
                'comment' => !empty($request->comment) ? $request->comment : null,
                'note' => !empty($request->note) ? $request->note : null,
                'status' => !empty($request->status) ? $request->status : 0,
                'price' => !empty($request->invoices_price_1) ? $request->invoices_price_1 : 0,
                'price_tax' => !empty($request->invoices_price_2) ? $request->invoices_price_2 : 0,
                'total' => !empty($request->invoices_price_3) ? $request->invoices_price_3 : 0,
                'date_end' => !empty($request->date_end) ? Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d') : null,
                'user_id' => !empty($request->user_id) ? $request->user_id : null,
                'source_date_end' => !empty($deal->source_date_end) ? $deal->source_date_end : null,
                'status_tax' => !empty($request->status_tax) ? $request->status_tax : null,
                'updated_at' => Carbon::now(),
            ];
            DealInvoice::where('id', $id)->update($data);
            $deal_invoice_id = $id;
            DealInvoiceRelationships::where(['deal_invoice_id' => $deal_invoice_id])->delete();
            //ghi lịch sử
            $DealHistory = "Cập nhập hóa đơn <span class='text-primary'>#$id</span>";
        }
        //deal_invoice_relationships
        if (!empty($invoices_title)) {
            foreach ($invoices_title as $key => $item) {
                $duy_tri_create = !empty($deal->catalogue_id == 1) ? (!empty($invoices_duy_tri) ? $invoices_duy_tri[$key] : '') : (!empty($invoices_phan_loai) ? $invoices_phan_loai[$key] : '');
                $deal_invoice_relationships[] = [
                    'title' => !empty($item) ? $item : '',
                    'deal_invoice_id' => $deal_invoice_id,
                    'user_id' => !empty($request->user_id) ? $request->user_id : 0,
                    'phan_loai' => !empty($invoices_phan_loai) ? $invoices_phan_loai[$key] : 0,
                    'duy_tri' => $duy_tri_create,
                    'price' => !empty($invoices_price) ? $invoices_price[$key] : 0,
                    'quantity' => !empty($invoices_quantity) ? $invoices_quantity[$key] : 0,
                    'tax' => !empty($invoices_tax) ? $invoices_tax[$key] : 0,
                    'tax_price' => !empty($invoices_tax_price) ? str_replace('.', '', $invoices_tax_price[$key]) : 0,
                    'total' => !empty($invoices_price_total) ? $invoices_price_total[$key] : 0,
                    'created_at' => Carbon::now(),
                ];
            }
            DealInvoiceRelationships::insert($deal_invoice_relationships);
        }
        DealHistory::insertGetId([
            'created_at' => Carbon::now(),
            'user_id' => Auth::user()->id,
            'deal_id' => $request->deal_id,
            'note' => $DealHistory
        ]);
        $invoices = DealInvoice::where(['deal_id' => $request->deal_id, 'deleted_at' => null])->orderBy('id', 'desc')->get();

        return response()->json(
            array(
                'invoices' => view('deal.backend.invoices', compact('invoices'))->render(),
            )
        );
    }


    public function showInvoices(Request $request)
    {
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $id = $request->id;
        $deal_id = $request->deal_id;
        $source_date_start = \Carbon\Carbon::today()->format('d/m/Y');
        $source_date_end = \Carbon\Carbon::today()->addYear()->format('d/m/Y');
        $users = dropdown(User::select('id', 'name')->get(), '', 'id', 'name');
        $formInvoices = DealInvoice::find($id);
        $detail = Deal::find($deal_id);
        $action = !empty($id) ? 'update' : 'create';
        return response()->json(
            array(
                'html' => view('deal.backend.formInvoices', compact('detail', 'formInvoices', 'action', 'users', 'source_date_start', 'source_date_end', 'category_products'))->render(),
            )
        );
    }

    public function removeFile(Request $request)
    {
        $id = $request->id;
        Deal::where('id', $id)->update(['file' => null]);
        return response()->json(
            array(
                'code' => 200
            )
        );
    }
    public function updateStatus(Request $request)
    {
        if ($request->status == 8 || $request->status == 9) {
            Deal::whereIn('id', $request->id_checked)->update(['status' => $request->status, 'type' => 0]);
        } else {
            Deal::whereIn('id', $request->id_checked)->update(['status' => $request->status]);
        }
        if ($request->active == 'website') {
            $DealHistory = config('tamphat')['status_web'][$request->status];
        } else {
            $DealHistory = config('tamphat')['status'][$request->status];
        }
        $DealColor = config('tamphat')['status_color'][$request->status];
        if (!empty($request->id_checked)) {
            foreach ($request->id_checked as $id) {
                //ghi lịch sử
                DealHistory::insertGetId([
                    'created_at' => Carbon::now(),
                    'user_id' => Auth::user()->id,
                    'deal_id' => $id,
                    'note' => "Cập nhập giai đoạn <span style='color: $DealColor'>$DealHistory</span> thành công"
                ]);
            }
        }
        return response()->json(
            array(
                'code' => 200
            )
        );
    }
}
