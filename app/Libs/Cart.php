<?php
if (!function_exists('callApiRequest')) {
    function callApiRequest($url = '', $data = '', $dataHeader = '')
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $dataHeader,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
/**HTML: cart giỏ hàng */
if (!function_exists('htmlItemCart')) {
    function htmlItemCart($k = '', $item = [])
    {
        $html = '';
        if (isset($item)) {
            $stock = getStockProduct($item);
            $slug = !empty($item['slug']) ? $item['slug'] : '';
            $title_version = !empty($item['options']['title_version']) ? $item['options']['title_version'] : '';
            $unit = !empty($item['unit']) ? '/' . $item['unit'] : '';
            $html .= '<tr class="cart_item" data-rowid="' . $k . '">
                        <td class="w-32 p-3 border border-solid  text-center">
                            <a href="' . url($slug) . '"><img src="' . $item['image'] . '" alt="' . $item['title'] . '"></a>
                        </td>
                        <td class="p-3 border border-solid ">
                            <a href="' . url($slug) . '" class="transition-all hover:text-orange text-global font-medium">' . $item['title'] . '</a>
                            <br>';
            if (!empty($title_version)) {
                $html .= '<span class="text-sm">' . trans('index.Classify') . ': ' .  $title_version . '</span>';
            }

            $html .= '</td>
                        <td class="p-3 border border-solid  text-center">
                            <span><span>' . number_format($item['price'], 0, '.', ',') . '₫</span>' . $unit . '</span>
                        </td>
                        <td class="p-3 border border-solid  text-center ">
                            <div class="flex items-center space-x-2 justify-center">
                             <div class="flex count border border-solid border-gray-300 p-2 h-11">
                                <button data-rowid="' . $k . '" class="decrement flex-auto w-5 leading-none tp_cart_minus" aria-label="button"  style="flex: auto;">-</button>
                                <input type="number" min="1" max="' . $stock . '" step="1" value="' . $item['quantity'] . '" class="tp_cardQuantity flex-auto w-8 text-center focus:outline-none input-appearance-none card-quantity">
                                <button data-rowid="' . $k . '" class="increment flex-auto w-5 leading-none tp_cart_plus" aria-label="button" style="flex: auto;">+</button>
                            </div>
                          
                            </div>
                           
                        </td>
                        <td class="p-3 border border-solid  text-center"><span>' . number_format($item['price'] * $item['quantity'], 0, '.', ',') . '₫</span></td>
                        <td class="p-3 border border-solid  text-center">
                            <a href="javascript:void(0)" class="inline-block mx-1 text-d61c1f transition-all js-cart-remove" data-rowid="' . $k . '">
                                <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg_375hu" focusable="false" aria-hidden="true" style="fill: red;width:20px;height20px">
                                    <path d="M8 3.994c0-1.101.895-1.994 2-1.994s2 .893 2 1.994h4c.552 0 1 .446 1 .997a1 1 0 0 1-1 .997h-12c-.552 0-1-.447-1-.997s.448-.997 1-.997h4zm-3 10.514v-6.508h2v6.508a.5.5 0 0 0 .5.498h1.5v-7.006h2v7.006h1.5a.5.5 0 0 0 .5-.498v-6.508h2v6.508a2.496 2.496 0 0 1-2.5 2.492h-5c-1.38 0-2.5-1.116-2.5-2.492z"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>';
        }
        return $html;
    }
}
/**HTML: cart header */
if (!function_exists('htmlItemCartHeader')) {
    function htmlItemCartHeader($k = '', $item = [])
    {
        $html = '';
        if (isset($item)) {
            $stock = getStockProduct($item);
            $slug = !empty($item['slug']) ? $item['slug'] : '';
            $title_version = !empty($item['options']['title_version']) ? ' - ' . $item['options']['title_version'] : '';
            $html .= '<li class="ps-cart__item">
                                     <div class="ps-product--mini-cart">
                                         <a class="ps-product__thumbnail" href="' . $slug . '"><img src="' . asset($item['image']) . '" alt="' . $item['title'] . '" /></a>
                                         <div class="ps-product__content">
                                             <a class="ps-product__name" href="' . $slug . '">' . $item['title'] . '</a>';


            $html .= '<p class="ps-product__meta"> <span class="ps-product__sale">' . number_format($item['price'], '0', ',', '.') . ' ₫</span>';
            if (!empty($item['price_old'])) {
                $html .= '<span class="ps-product__is-price">' . number_format($item['price_old'], '0', ',', '.') . ' ₫</span>';
            }
            $html .= '</p>';
            $html .= '</div>
                                         <a class="ps-product__remove js-cart-remove" data-rowid="' . $k . '" href="javascript: void(0)"><i class="icon-cross"></i></a>
                                     </div>
                                 </li>';
            /* $html .= '<li class="flex flex-wrap group mb-8 cart-' . $k . '" data-rowid="' . $k . '">
                        <div class="mr-5 relative">
                            <a href="' . $slug . '"><img src="' . asset($item['image']) . '" alt="' . $item['title'] . '" loading="lazy" width="90" height="100" /></a>
                        </div>
                        <div class="flex-1">
                            <h4>
                                <a class="font-light text-sm md:text-base text-dark hover:text-orange transition-all tracking-wide" href="' . $slug . '"><span class="font-medium">' . $item['title'] . '</span>' . $title_version . '</a>
                            </h4>
                            <span class="font-light text-sm text-dark transition-all tracking-wide">' . $item['quantity'] . ' x <span>' . number_format($item['price'], 0, ',', '.') . '₫' . '</span></span>
                            <div class="flex items-center space-x-2 mt-2">
                                <div class="flex count border border-solid border-gray-300 p-2 h-11">
                                    <button data-rowid="' . $k . '" class="decrement flex-auto w-5 leading-none cart-minus tp_cart_minus" aria-label="button"  style="flex: auto;">-</button>
                                    <input type="number" min="1" max="' . $stock . '" step="1" value="' . $item['quantity'] . '" class="flex-auto w-8 text-center focus:outline-none input-appearance-none tp_cardQuantity">
                                    <button data-rowid="' . $k . '" class="increment flex-auto w-5 leading-none cart-plus tp_cart_plus" aria-label="button" style="flex: auto;">+</button>
                                </div>
                                <button data-rowid="' . $k . '" class="transition-all hover:text-orange js-cart-remove">
                                    <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg_375hu" focusable="false" aria-hidden="true" style="fill: red;width:20px;height20px">
                                        <path d="M8 3.994c0-1.101.895-1.994 2-1.994s2 .893 2 1.994h4c.552 0 1 .446 1 .997a1 1 0 0 1-1 .997h-12c-.552 0-1-.447-1-.997s.448-.997 1-.997h4zm-3 10.514v-6.508h2v6.508a.5.5 0 0 0 .5.498h1.5v-7.006h2v7.006h1.5a.5.5 0 0 0 .5-.498v-6.508h2v6.508a2.496 2.496 0 0 1-2.5 2.492h-5c-1.38 0-2.5-1.116-2.5-2.492z"></path>
                                    </svg>
                                </button>
                            </div>

                        </div>
                    </li>'; */
        }
        return $html;
    }
}
/**HTML: customer copy cart */
if (!function_exists('htmlItemCartCopyCustomer')) {
    function htmlItemCartCopyCustomer($k = '', $item = [])
    {
        $html = '';
        if (isset($item)) {
            $stock = getStockProduct($item);
            $slug = !empty($item['slug']) ? $item['slug'] : '';
            $title_version = !empty($item['options']['title_version']) ? $item['options']['title_version'] : '';
            $unit = !empty($item['unit']) ? '/' . $item['unit'] : '';
            $html .= '<div class="flex flex-col md:flex-row space-y-2 md:space-y-0 space-x-0 md:space-x-2">
                                <div class="w-full md:w-1/2 flex space-x-3">
                                    <div class="w-[50px]">
                                        <img alt="' . $item['title'] . '" class="border w-full object-cover" src="' . asset($item['image']) . '">
                                    </div>
                                    <div class="flex-1">
                                        <a target="_blank" href="' . route('routerURL', ['slug' => $slug]) . '" class="text-blue-500">' . $item['title'] . '</a>
                                        <p class="subdued">' . $title_version . '</p>
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 flex space-x-2 items-center justify-between">
                                    <div>' . number_format($item['price'], 0, ',', '.') . '₫  x </div>
                                    <div>
                                        <input min="1" max="' . $stock . '" size="30" type="number" class="text-center border h-9 leading-9 text-black pl-2 focus:outline-none rounded js_change_copyCart w-16" value="' . $item['quantity'] . '" data-rowid="' . $k . '">
                                    ' . $unit . '
                                        </div>
                                    <div>
                                        ' . number_format($item['price'] * $item['quantity'], 0, ',', '.') . '₫
                                    </div>
                                    <div>
                                        <a href="javascript:void(0)" class="js_delete_copyCart" data-rowid="' . $k . '">
                                        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg_375hu" focusable="false" aria-hidden="true" style="fill: red;width:20px;height:20px">
                                            <path d="M8 3.994c0-1.101.895-1.994 2-1.994s2 .893 2 1.994h4c.552 0 1 .446 1 .997a1 1 0 0 1-1 .997h-12c-.552 0-1-.447-1-.997s.448-.997 1-.997h4zm-3 10.514v-6.508h2v6.508a.5.5 0 0 0 .5.498h1.5v-7.006h2v7.006h1.5a.5.5 0 0 0 .5-.498v-6.508h2v6.508a2.496 2.496 0 0 1-2.5 2.492h-5c-1.38 0-2.5-1.116-2.5-2.492z"></path>
                                        </svg>
                                        </a>
                                    </div>

                                </div>
                            </div>';
        }
        return $html;
    }
}
/**HTML: admin copy cart */
if (!function_exists('htmlItemCartCopyAdmin')) {
    function htmlItemCartCopyAdmin($key = '', $item = [])
    {
        $html = '';
        if (isset($item)) {
            $stock = getStockProduct($item);
            $slug = !empty($item['slug']) ? $item['slug'] : '';
            $unit = !empty($item['unit']) ? '/' . $item['unit'] : '';
            $title_version = !empty($item['options']['title_version']) ? $item['options']['title_version'] : '';
            $html .= '<tr><td><div class="font-medium whitespace-nowrap">' . $item['title'] . '</div>';
            if (!empty($title_version)) {
                $html .= '<div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">' . $title_version . '</div>';
            }
            $html .= '</td>
                                <td class="text-right w-32">
                                    <div class="flex items-center space-x-2">
                                    <input max="' . $stock . '" type="number" class="form-control js_change_copyCart" value="' . $item['quantity'] . '" data-rowid="' . $key . '"> </div>
                                </td>
                                <td class="text-right w-32">' . number_format($item['price'], 0, ',', '.') . '₫' . $unit . '</td>
                                <td class="text-right w-32 font-medium">' . number_format($item['price'] * $item['quantity'], 0, ',', '.') . '₫</td>
                                <td>
                                    <a href="javascript:void(0)" class="text-danger js_delete_copyCart" data-rowid="' . $key . '">
                                        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg_375hu" focusable="false" aria-hidden="true" style="fill: red;width:20px;height:20px;float:right">
                                            <path d="M8 3.994c0-1.101.895-1.994 2-1.994s2 .893 2 1.994h4c.552 0 1 .446 1 .997a1 1 0 0 1-1 .997h-12c-.552 0-1-.447-1-.997s.448-.997 1-.997h4zm-3 10.514v-6.508h2v6.508a.5.5 0 0 0 .5.498h1.5v-7.006h2v7.006h1.5a.5.5 0 0 0 .5-.498v-6.508h2v6.508a2.496 2.496 0 0 1-2.5 2.492h-5c-1.38 0-2.5-1.116-2.5-2.492z"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>';
        }
        return $html;
    }
}
if (!function_exists('getStockProduct')) {
    function getStockProduct($item = [])
    {
        $stock = 1000;
        $id_version = !empty($item['options']['id_version']) ? $item['options']['id_version'] : '';
        if (!empty($id_version)) {
            $getVersionproduct = \App\Models\ProductVersion::select(
                'id',
                '_stock_status',
                '_stock',
                '_outstock_status'
            )->where('product_id', $item['id'])->where('id_version', $id_version)->first();
            if ($getVersionproduct) {
                if ($getVersionproduct['_stock_status'] == 1 && $getVersionproduct['_outstock_status'] == 0) {
                    $stock = $getVersionproduct['_stock'];
                }
            }
        } else {
            $product = \App\Models\Product::select('inventory', 'inventoryPolicy', 'inventoryQuantity')->find($item['id']);
            if ($product) {
                if ($product->inventory == 1 && $product->inventoryPolicy == 0) {
                    $stock = $product['inventoryQuantity'];
                }
            }
        }
        return $stock;
    }
}
/*Check tồn kho theo item*/
if (!function_exists('checkStock')) {

    function checkStock($item = [])
    {
        $data = array(
            'status' => 0,
            'title' => 0,
            'quantity' => '',
        );
        $stock = $item->product_stocks->sum('value');
        if ($item['_stock_status'] == 1 && $item['_outstock_status']  == 0) {
            if ($stock == 0) {
                $data['status'] = 1;
                $data['title'] =  '<span class="product_stock">' . trans('index.OutOfStock') . '</span>';
            } else {
                $data['title'] = '<span class="product_stock">' . $stock . '</span> ' . trans('index.InOfStock');
            }
        } else {
            $data['title'] =  '<span class="product_stock">' . trans('index.InOfStock') . '</span>';
        }
        return $data;
    }
}
/*Check tồn kho theo số lượng quantity*/
if (!function_exists('checkCart')) {

    function checkCart($data = [], $quantity = 0)
    {
        $return = array(
            'status' => 0,
            'message' => ''
        );
        $stock = $data->product_stocks->sum('value');
        $_stock = checkStock($data);
        if ($_stock['status'] == 1) {
            $return['status'] = 1;
            $return['message'] = 'Hết hàng';
        }
        if ($data['inventory'] == 1 && $data['inventoryPolicy'] == 0) {
            if ($quantity > $stock) {
                $return['status'] = 1;
                if ($stock == 0) {
                    $return['message'] = 'Hết hàng';
                } else {
                    $return['message'] = trans('index.YouCanOnlyBuyUpTo', ['quantity' => $stock]);
                }
            }
        }
        return $return;
    }
}
/*Check tồn kho theo item*/
if (!function_exists('checkStockItemProduct')) {

    function checkStockItemProduct($item = [])
    {
        $return = array(
            'stock' => 0,
            'outStock' => [],
            'disabled' => '',
            'type' => '',
        );
        if (count($item['product_versions']) > 0) {
            foreach ($item['product_versions'] as $val) {
                $checkStock = checkStock($val);
                if ($checkStock['status'] == 1) {
                    $return['outStock'][] = $checkStock['title'];
                }
                $return['stock'] += $val->_stock;
            }
            if (count($return['outStock']) == count($item['product_versions'])) {
                $return['disabled'] = 'disabled';
            }
            $return['type'] = 'variable';
        } else {
            $return['stock'] += $item['inventoryQuantity'];
            $checkStock = checkStock($item, 'simple');
            if ($checkStock['status'] == 1) {
                $return['disabled'] = 'disabled';
            }
            $return['type'] = 'simple';
        }
        return $return;
    }
}
/**TÍnh phí vận chuyển */
if (!function_exists('getFeeShip')) {

    function getFeeShip($cityID = '', $districtID = '')
    {
        $html = '';
        $html_ghn = [];
        $ships = \App\Models\Ship::where(['publish' => 0])->get();
        if (!$ships->isEmpty()) {

            $shipsAddress = \App\Models\Address::select('cityid', 'districtid')->with('city_name')->with('district_name')->where(['active' => 1])->first();
            $district_name =  \App\Models\VNDistrict::select('name', 'ProvinceID')->where('id', (int)$districtID)->with('city')->first();
            $priceShipShop =  \App\Models\VNCity::select('price')->where('id', (int)$cityID)->first();
            $DistrictID = (int)$districtID;
            $total = $price_coupon = $totalCoupon = 0;
            $totalWeight = $totalLength = $totalWidth = $totalHeight = 0;
            $start_fee_shipping = 0;
            $cartController = Session::get('cart');
            $coupon = Session::get('coupon');
            if ($cartController) {
                foreach ($cartController as $k => $item) {
                    $total += $item['price'] * $item['quantity'];
                    if (!empty($item['ships'])) {
                        $totalWeight += $item['ships']['weight'] * $item['quantity'];
                    }
                    // $totalLength += $item['ships']['length'] * $item['quantity'];
                    // $totalWidth += $item['ships']['width'] * $item['quantity'];
                    // $totalHeight += $item['ships']['height'] * $item['quantity'];
                }
            }
            if (isset($coupon)) {
                foreach ($coupon as $item) {
                    $price_coupon += !empty($item['price']) ? $item['price'] : 0;
                }
            }
            $totalCoupon = $total - $price_coupon;
            if (!empty($DistrictID)) {
                if (!$ships->isEmpty()) {
                    foreach ($ships as $item) {
                        if ($item->id == 1) {
                            //tính phí vận chuyển giao hàng tiết kiệm
                            if (!empty($shipsAddress->city_name->name) && !empty($shipsAddress->district_name->name)) {
                                $dataHeaderGHTK = array(
                                    "Token: $item->TOKEN_API"
                                );
                                $dataGHTKRoad = array(
                                    "pick_province" => $shipsAddress->city_name->name,
                                    "pick_district" =>  $shipsAddress->district_name->name,
                                    "province" => $district_name->city->name,
                                    "district" => $district_name->name,
                                    "address" => "",
                                    "weight" => !empty($totalWeight) ? (int)$totalWeight : 200,
                                    "value" => $totalCoupon,
                                    "transport" => "road",
                                    "deliver_option" => "none",
                                );
                                $getServiceGHTKRoad = json_decode(callApiRequest($item->URL_API . 'services/shipment/fee?' . http_build_query($dataGHTKRoad), '', $dataHeaderGHTK));
                            }
                        } else if ($item->id == 2) {
                            //tính phí vận chuyển giao hàng nhanh
                            /*lấy gói dịch vụ*/
                            if (!empty($shipsAddress->districtid)) {
                                $dataService = array(
                                    "shop_id" => 119290,
                                    "from_district" => (int)$shipsAddress->districtid,
                                    "to_district" => $DistrictID
                                );
                                $dataHeader = array(
                                    'token: ' . $item->TOKEN_API . '',
                                    'Content-Type: application/json',
                                    'ShopId: 119290',
                                    'Content-Type: text/plain'
                                );
                                $getService = json_decode(callApiRequest($item->URL_API . 'shipping-order/available-services', json_encode($dataService), $dataHeader));
                                if ($getService->code == 200) {
                                    if (!empty($getService->data)) {
                                        foreach ($getService->data as $item) {
                                            $data = array(
                                                "from_district_id" => (int)$shipsAddress->districtid,
                                                "service_id" => $item->service_id,
                                                "service_type_id" => $item->service_type_id,
                                                "to_district_id" => $DistrictID,
                                                "to_ward_code" => "",
                                                "height" => $totalHeight,
                                                "length" => $totalLength,
                                                "weight" => !empty($totalWeight) ? (int)$totalWeight : 200,
                                                "width" => $totalWeight,
                                                "insurance_value" =>  $totalCoupon,
                                                "coupon" => null
                                            );
                                            $getFeeShip = json_decode(callApiRequest('https://dev-online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee', json_encode($data), $dataHeader));
                                            if ($getFeeShip->code == 200) {
                                                if (!empty($getFeeShip->data)) {
                                                    $html_ghn[] = array(
                                                        'short_name' => $item->short_name,
                                                        'total' => $getFeeShip->data->total,
                                                        'service_fee' => $getFeeShip->data->service_fee,
                                                    );
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            //end 
                        }
                    }
                }
                if ($priceShipShop) {
                    $start_fee_shipping = $priceShipShop->price;
                    $html .= '<div class="js_change_fee_shipping list_shipping_item flex justify-between items-center cursor-pointer" data-fee="' . $priceShipShop->price . '" data-title="Shop giao hàng">
                        <div class="flex space-x-3 w-full">
                           <label class="flex space-x-3 w-full cursor-pointer px-[20px] py-[10px] mb-0" for="shopGH-0">
                                <span class="font-bold">Shop giao hàng</span>
                                <div class="font-bold priceA">₫' . number_format($priceShipShop->price, 0, ',', '.') . '</div>
                            </label>
                        </div>
                        <div class="js_checked_ship">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[24px] h-[24px] stardust-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                </div>';
                }
                if (!empty($getServiceGHTKRoad->fee) && !empty($getServiceGHTKRoad->fee->fee) && $getServiceGHTKRoad->fee->fee > 0) {
                    $html .= '<div class="js_change_fee_shipping list_shipping_item flex justify-between items-center cursor-pointer" data-fee="' . $getServiceGHTKRoad->fee->fee . '" data-title="Giao hàng tiết kiệm">
                        <div class="flex space-x-3 w-full">
                           <label class="flex space-x-3 w-full cursor-pointer px-[20px] py-[10px] mb-0" for="ghtk-0">
                                <span class="font-bold">GHTK</span>
                                <div class="font-bold priceA">₫' . number_format($getServiceGHTKRoad->fee->fee, 0, ',', '.') . '</div>
                            </label>
                        </div>
                        <div class="js_checked_ship hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[24px] h-[24px] stardust-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                </div>';
                }
                if (!empty($html_ghn)) {
                    foreach ($html_ghn as $key => $item) {
                        $html .= '<div class="js_change_fee_shipping list_shipping_item flex justify-between items-center cursor-pointer" data-fee="' . $item['total'] . '" data-title="Giao hàng nhanh - ' . $item['short_name'] . '">
                        <div class="w-full">
                            <label class="flex space-x-3 w-full cursor-pointer px-[20px] py-[10px] mb-0" for="ghn-' . $key . '">
                                <span class="font-bold">GHN - ' . $item['short_name'] . '</span>
                                <div class="font-bold priceA">₫' . number_format($item['total'], 0, ',', '.') . '</div>
                            </label>
                        </div>
                        <div class="js_checked_ship hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[24px] h-[24px] stardust-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        </div>
                </div>';
                    }
                }
            }
            return ['html' => $html, 'totalCart' => $total + $start_fee_shipping - $price_coupon, 'fee_ship' => $start_fee_shipping, 'title_ship' => 'Shop giao hàng'];
        } else {
            return [];
        }
    }
}
