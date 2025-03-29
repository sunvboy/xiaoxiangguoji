<?php
if (!function_exists('queryHelper')) {
	function queryHelper($module = '', $orderBy = [], $keyword = '', $catalogueid = '')
	{
		$data = $module::where('alanguage', config('app.locale'))->orderBy($orderBy[0]['row'], $orderBy[0]['value']);
		if (isset($orderBy)) {
			foreach ($orderBy as $k => $v) {
				if ($k > 0) {
					$data =  $data->orderBy($v['row'], $v['value']);
				}
			}
		}
		if (is($keyword)) {
			$data =  $data->where('title', 'like', '%' . $keyword . '%');
		}
		if (is($catalogueid)) {
			$data =  $data->where('catalogueid', '=', $catalogueid);
		}
		$data = $data->paginate(env('APP_paginate'));
		if (is($keyword)) {
			$data->appends(['keyword' => $keyword]);
		}
		if (is($catalogueid)) {
			$data->appends(['catalogueid' => $catalogueid]);
		}
		return $data;
	}
}
if (!function_exists('getListAttr')) {
	function getListAttr($attrid = '')
	{
		$attribute = [];
		// lấy ra danh sách thuộc tính
		$list_attrid = json_decode($attrid, true);
		//lay khoang gia
		$list_attr_catalogue_price = \App\Models\CategoryAttribute::select('id', 'title', 'slug')->where('slug', 'khoang-gia')->first();
		if ($list_attr_catalogue_price) {
			$list_attr_price = \App\Models\Attribute::select('id', 'title')->where('catalogueid', $list_attr_catalogue_price->id)->get();
			if ($list_attr_price) {
				$attribute[$list_attr_catalogue_price->title]['keyword_cata'] = $list_attr_catalogue_price->slug;
				foreach ($list_attr_price as $v) {
					$attribute[$list_attr_catalogue_price->title][$v->id] = $v->title;
				}
			}
		}
		if (isset($list_attrid)) {
			$list_attr_cata = \App\Models\CategoryAttribute::select('id', 'title', 'slug')->whereIn('id', array_keys($list_attrid))->where('slug', '!=', 'khoang-gia')->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
			$list_attribute = [];
			foreach ($list_attrid as $key => $value) {
				$list_attribute = array_merge($list_attribute, $value);
			}
			$list_attr = \App\Models\Attribute::select('id', 'title', 'catalogueid')->whereIn('id', $list_attribute)->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
			foreach ($list_attrid as $key => $value) {
				foreach ($list_attr_cata as $subs) {
					//check khoảng giá
					foreach ($list_attr as  $items) {
						foreach ($value as $k) {
							if ($key == $subs['id'] && $k == $items['id'] &&  $items['catalogueid'] == $subs['id']) {
								$attribute[$subs['title']]['keyword_cata'] = $subs['slug'];
								$attribute[$subs['title']][$items['id']] = $items['title'];
							}
						}
					}
				}
			}
		}

		return $attribute;
	}
}

if (!function_exists('getPrice')) {
	function getPrice($param = [])
	{
		$price_old = 0;
		$price_final = 0;

		if (isset($param['price_contact']) && $param['price_contact'] == 1) {
			return array(
				'price_old' => '',
				'price_final' => 'Liên hệ',
				'price_old_none_format' => 0,
				'price_final_none_format' => 0,
				'percent' => '',
				'flag' => 1,
			);
		} else {

			if (isset($param['price_sale']) && $param['price_sale'] != '' && $param['price_sale'] > 0) {
				$price_old = $param['price'];
				$price_final = $param['price_sale'];
			}
			if (isset($param['price']) && $param['price_sale'] == 0) {
				$price_old = 0;
				$price_final = $param['price'];
			}
			if ($price_final == $price_old) {
				$flag = 1;
			} else {
				$flag = 0;
			};
			if (!empty($price_final) && !empty($price_old)) {
				$percent = ($price_old - $price_final) * 100 / $price_old;
				if ($percent > 1) {
					$percent = round($percent);
				} else {
					$percent = round($percent, 1);
				}
				$percent = $percent . '%';
			}
			return array(
				'price_old' => !empty($price_old > 0) ? number_format($price_old, 0, ',', '.') . 'đ' : '',
				'price_final' => !empty($price_final > 0) ? number_format($price_final, 0, ',', '.') . 'đ' : 'Liên hệ',
				'price_old_none_format' => !empty($price_old > 0) ? $price_old : 0,
				'price_final_none_format' => !empty($price_final > 0) ? $price_final : 0,
				'percent' => isset($percent) ? $percent : '',
				'flag' => $flag,
			);
		}
	}
}
if (!function_exists('groupValue')) {

	function groupValue($old_arr = [], $sort = '')
	{
		$arr = array();
		foreach ($old_arr as $key => $item) {
			$arr[$item[$sort]][$key] = $item;
		}
		ksort($arr, SORT_NUMERIC);
		return $arr;
	}
}
if (!function_exists('curl_api')) {

	function curl_api($CURLOPT_URL = '')
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $CURLOPT_URL,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$data = json_decode($response);
		return $data;
	}
}
if (!function_exists('convert_date')) {

	function convert_date($date = '')
	{
		$date = explode('/', $date);
		$data = trim($date[2]) . '-' . trim($date[0]) . '-' . trim($date[1]) . ' 00:00:00';
		return $data;
	}
}
if (!function_exists('cutnchar')) {
	function cutnchar($str = NULL, $n = 320)
	{
		if (strlen($str) < $n) return $str;
		$html = substr($str, 0, $n);
		$html = substr($html, 0, strrpos($html, ' '));
		return $html . '...';
	}
}

function execPostRequest($url, $data)
{
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt(
		$ch,
		CURLOPT_HTTPHEADER,
		array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data)
		)
	);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	//execute post
	$result = curl_exec($ch);
	//close connection
	curl_close($ch);
	return $result;
}
if (!function_exists('relationships')) {
	function relationships($module = '')
	{
		$data = $module::select('id', 'title')->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
		$return = [];
		if (!empty($data)) {
			foreach ($data as $val) {
				$return[$val->id] = $val->title;
			}
		}
		return $return;
	}
}
//get comment() of ITEM
if (!function_exists('getRateOfComment')) {
	function getRateOfComment($id = '', $module = 'products')
	{
		$rating = \App\Models\Comment::where(['module_id' => $id, 'module' => $module, 'publish' => 0])->selectRaw('SUM(rating) / COUNT(DISTINCT id) AS rate')
			->first();
		return $rating;
	}
}
//get total() of ITEM
if (!function_exists('sobaidang')) {
	function sobaidang($type = 'customer', $id = 0)
	{
		$sobaidang = \App\Models\Briefing::where(['type' => $type, 'publish' => 0, 'userid_created' => $id])->count();
		return $sobaidang;
	}
}
//get số bài đăng
if (!function_exists('sothaoluan')) {
	function sothaoluan($customerid = 0, $type = 'customer')
	{
		$sothaoluan = \App\Models\Comment::where(['customerid' => $customerid,  'publish' => 0, 'type' => $type])->count();
		return $sothaoluan;
	}
}
if (!function_exists('commentCategory')) {
	function commentCategory($module_id = 0)
	{
		$count = \App\Models\Comment::where(['module_id' => $module_id, 'publish' => 0])->count();
		$cmtLast = \App\Models\Comment::where(['module_id' => $module_id, 'publish' => 0])->orderBy('id', 'desc')->first();;
		return [
			'count' => $count,
			'cmtLast' => $cmtLast,
		];
	}
}

if (!function_exists('checkInventoryCheckout')) {
	function checkInventoryCheckout($options = '')
	{
		$stock = 1000;
		if (isset($options["options"]) && is_array($options["options"]) && count($options["options"])) {
			$getVersionproduct = \App\Models\ProductVersion::select('id', '_stock_status', '_stock', '_outstock_status')->where('product_id', $options['id'])->where('id_version', $options["options"])->first();
			if ($getVersionproduct['_stock_status'] == 1) {
				if ($getVersionproduct['_outstock_status']  == 0) {
					$stock = $getVersionproduct['_stock'];
				}
			}
		} else {
			$product = \App\Models\Product::select('inventory', 'inventoryPolicy', 'inventoryQuantity')->find($options['id']);
			if ($product->inventory == 1) {
				if ($product->inventoryPolicy  == 0) {
					$stock = $product['inventoryQuantity'];
				}
			}
		}
		return $stock;
	}
}
