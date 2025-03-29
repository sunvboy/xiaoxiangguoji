<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

if (!function_exists('convert_chapter')) {

    function convert_chapter($chapter = '', $lesson = '', $course_id = '')
    {

        $temp = [];

        if (isset($chapter['title']) && is_array($chapter['title'])  && count($chapter['title'])) {

            foreach ($chapter['title'] as $key => $val) {
                $temp[] = array('title' => $val);
            }
        }

        if (isset($temp) && is_array($temp) && count($temp) && !empty($chapter['count'])) {

            foreach ($temp as $key => $val) {

                $temp[$key]['title'] = $chapter['title'][$key];

                $temp[$key]['description'] = $chapter['description'][$key];

                $temp[$key]['count'] = $chapter['count'][$key];

                if (!empty($chapter['id'][$key])) {

                    $temp[$key]['id'] = $chapter['id'][$key];
                }
            }
        }



        $temp2 = [];

        if (isset($lesson['title']) && is_array($lesson['title'])  && count($lesson['title'])) {

            foreach ($lesson['title'] as $key => $val) {

                $temp2[] = array('title' => $val);
            }
        }

        if (isset($temp2) && is_array($temp2) && count($temp2)) {
            foreach ($temp2 as $key2 => $val) {
                $temp2[$key2]['title'] = $lesson['title'][$key2];
                $temp2[$key2]['link'] = $lesson['link'][$key2];
                $temp2[$key2]['description'] = $lesson['description'][$key2];
                if (!empty($lesson['id'][$key2])) {
                    $temp2[$key2]['id'] = $lesson['id'][$key2];
                }
            }
        }
        // return $temp;

        $array = [];

        if (isset($temp) && is_array($temp) && count($temp)) {

            $j = $i = 0;

            foreach ($temp as $key3 => $vals) {

                if (!empty($vals['id'])) {

                    $array[$key3]['id'] = $vals['id'];
                }

                if (!empty($course_id)) {

                    $array[$key3]['course_id'] = $course_id;
                }

                $array[$key3]['title'] = $vals['title'];
                $array[$key3]['count'] = $vals['count'];

                $array[$key3]['description'] = !empty($vals['description']) ? $vals['description'] : '';

                $j = $j + $vals['count'];

                $page = [];

                if (isset($temp2) && is_array($temp2) && count($temp2)) {

                    foreach ($temp2 as $keyp => $val) {

                        if ($keyp < $j && $keyp >= $i) {

                            $page[$keyp] = $val;

                            $i++;
                        }
                    }

                    $page = array_values($page);
                }

                $array[$key3]['lessons'] = $page;
            }
        }
        return $array;
    }
}
if (!function_exists('removeutf8')) {
    function removeutf8($value = NULL)
    {
        $chars = array(
            'a'    =>    array('ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'á', 'à', 'ả', 'ã', 'ạ', 'â', 'ă', 'Á', 'À', 'Ả', 'Ã', 'Ạ', 'Â', 'Ă'),
            'e' =>    array('ế', 'ề', 'ể', 'ễ', 'ệ', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ', 'é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê'),
            'i'    =>    array('í', 'ì', 'ỉ', 'ĩ', 'ị', 'Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị'),
            'o'    =>    array('ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'Ố', 'Ồ', 'Ổ', 'Ô', 'Ộ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ', 'ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ơ', 'Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ơ'),
            'u'    =>    array('ứ', 'ừ', 'ử', 'ữ', 'ự', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự', 'ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư'),
            'y'    =>    array('ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ'),
            'd'    =>    array('đ', 'Đ'),
        );
        foreach ($chars as $key => $arr)
            foreach ($arr as $val)
                $value = str_replace($val, $key, $value);
        return $value;
    }
}
if (!function_exists('slug')) {
    function slug($value = NULL)
    {
        $value = removeutf8($value);
        $value = str_replace('-', ' ', trim($value));
        $value = preg_replace('/[^a-z0-9-]+/i', ' ', $value);
        $value = trim(preg_replace('/\s\s+/', ' ', $value));
        return strtolower(str_replace(' ', '-', trim($value)));
    }
}
if (!function_exists('CodeRender')) {
    function CodeRender($module = '')
    {
        switch ($module) {
            case "products":
                $lastRow = \App\Models\Product::orderBy('id', 'DESC')->first();
                $str = 'SP';
                break;
            case "purchases":
                $lastRow = \App\Models\ProductPurchase::orderBy('id', 'DESC')->first();
                $str = 'PON';
                break;
            case "payment_vouchers":
                $lastRow = \App\Models\PaymentVouchers::orderBy('id', 'DESC')->first();
                $str = 'PVN';
                break;
            case "questions":
                $lastRow = \App\Models\Question::orderBy('id', 'DESC')->first();
                $str = 'QUE';
                break;
            case "courses":
                $lastRow = \App\Models\Course::orderBy('id', 'DESC')->first();
                $str = 'QUE';
                break;
            case "receipt_vouchers":
                $lastRow = \App\Models\ReceiptVouchers::orderBy('id', 'DESC')->first();
                $str = 'RVN';
                break;
        }
        if (!empty($lastRow)) {
            $lastId = (int)$lastRow['id'] + 1;
            $data = $str . str_pad($lastId, 2, '0', STR_PAD_LEFT);
        } else {
            $data = $str . '01';
        }
        return $data;
    }
}
if (!function_exists('is')) {
    function is($data)
    {
        return (isset($data)) ? $data : '';
    }
}
if (!function_exists('check_array')) {
    function check_array($array)
    {
        if (isset($array)) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('activeMenu')) {
    function activeMenu($uri = '')
    {
        $active = '';
        if (Request::is(Request::segment(1) . '/' . $uri . '/*') || Request::is(Request::segment(1) . '/' . $uri) || Request::is($uri)) {
            $active = 'side-menu--active';
        }
        return $active;
    }
}
if (!function_exists('array_group_by')) {
    function array_group_by(array $arr, callable $key_selector)
    {
        $result = array();
        foreach ($arr as $i) {
            $key = call_user_func($key_selector, $i);
            $result[$key][] = $i;
        }
        return $result;
    }
}
/*Breadcrumb*/
if (!function_exists('breadcrumb_backend')) {
    function breadcrumb_backend($array = [])
    {
        $result = '<nav aria-label="breadcrumb" class="hidden xl:flex">
        <ol class="breadcrumb breadcrumb-light">
            <li class="breadcrumb-item"><a href="' . route('admin.dashboard') . '">App</a></li>';
        if (isset($array) && count($array) > 0 && is_array($array)) {
            foreach ($array as $v) {
                $result .= '<li class="breadcrumb-item"><a href="' . $v['src'] . '">' . $v['title'] . '</a></li>';
            }
        }
        $result .= '</ol>
        </nav>';
        return $result;
    }
}
/*Upload image*/
if (!function_exists('uploadImage')) {
    function uploadImage($image = '', $path = '')
    {
        $image_url = '';
        if (!empty($image)) {
            $name_gen = hexdec(uniqid()) . '.webp';
            $base_path = base_path('upload/images/' . $path);
            if (!file_exists($base_path)) {
                mkdir($base_path, 0777, true);
            }
            Image::make($image)->encode('webp', 100)->save($base_path . '/' . $name_gen);
            //lưu ảnh thumbnail
            /* $thumbnail = \App\Models\ConfigImage::select('data')->where('module', $path)->first();
            if (!empty($thumbnail)) {
                $jsonData = json_decode($thumbnail->data, TRUE);
                if (!empty($jsonData) && count($jsonData['with']) > 0 && count($jsonData['height'])  > 0) {
                    foreach ($jsonData['with'] as $key => $item) {
                        if ($item > 0 && $jsonData['height'][$key] > 0) {
                            $base_path_thum = base_path('upload/.thumbs/images/' . $path . '/' . $jsonData['type'][$key]);
                            if (!file_exists($base_path_thum)) {
                                mkdir($base_path_thum, 666, true);
                            }
                            Image::make($image)->resize($item, $jsonData['height'][$key])->encode('webp', 100)->save($base_path_thum . '/' . $name_gen);
                        }
                    }
                }
            } */
            //end
            $image_url = 'upload/images/' . $path . '/' . $name_gen;
        }
        return $image_url;
    }
}
if (!function_exists('uploadImageNone')) {
    function uploadImageNone($image = '', $path = '')
    {
        $image_url = '';
        if (!empty($image)) {
            // $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $name_gen = hexdec(uniqid()) . '.webp';
            // $base_path = base_path('upload/images/'.$path.'/'.date('Y').'/'.date('m').'/'.date('d'));
            $base_path = base_path('upload/images/' . $path);
            if (!file_exists($base_path)) {
                mkdir($base_path, 0777, true);
            }
            Image::make($image)->encode('webp', 100)->save($base_path . '/' . $name_gen);
            // $image_url = 'upload/images/'.$path.'/'.date('Y').'/'.date('m').'/'.date('d').'/'.$name_gen;
            $image_url = 'upload/images/' . $path . '/' . $name_gen;
        }
        return $image_url;
    }
}
if (!function_exists('uploadImageFrontend')) {
    function uploadImageFrontend($image = '', $path = '')
    {
        $image_url = '';
        if (!empty($image)) {
            // $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $name_gen = hexdec(uniqid()) . '.webp';
            // $base_path = base_path('upload/images/'.$path.'/'.date('Y').'/'.date('m').'/'.date('d'));
            $base_path = base_path('upload/' . $path);
            if (!file_exists($base_path)) {
                mkdir($base_path, 0777, true);
            }
            // Image::make($image)->insert(url('frontend/images/logo.webp'))->encode('webp', 100)->save($base_path.'/'.$name_gen);
            Image::make($image)->encode('webp', 100)->save($base_path . '/' . $name_gen);
            // $image_url = 'upload/images/'.$path.'/'.date('Y').'/'.date('m').'/'.date('d').'/'.$name_gen;
            $image_url = 'upload/' . $path . '/' . $name_gen;
        }
        return $image_url;
    }
}
//custom fields
if (!function_exists('fieldsInsert')) {
    function fieldsInsert($module = '', $id = 0, $request = '')
    {
        $field = \App\Models\ConfigColum::select('keyword', 'type', 'id')->where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        if (!$field->isEmpty()) {
            foreach ($field as $item) {
                $keyword = $item->keyword;
                $keyword_convert = str_replace('-', '_', $keyword);
                switch ($item->type) {
                    case ('input'):
                        $meta_key = 'config_colums_input_' . $keyword_convert;
                        $meta_value = $request[$meta_key];
                        break;
                    case ('textarea'):
                        $meta_key = 'config_colums_textarea_' . $keyword_convert;
                        $meta_value = $request[$meta_key];
                        break;
                    case ('editor'):
                        $meta_key = 'config_colums_editor_' . $keyword_convert;
                        $meta_value = $request[$meta_key];
                        break;
                    case ('select'):
                        $meta_key = 'config_colums_select_' . $keyword_convert;
                        $meta_value = $request[$meta_key];
                        break;
                    case ('checkbox'):
                        $meta_key = 'config_colums_checkbox_' . $keyword_convert;
                        $meta_value = json_encode($request[$meta_key]);
                        break;
                    case ('radio'):
                        $meta_key = 'config_colums_radio_' . $keyword_convert;
                        $meta_value = $request[$meta_key];
                        break;
                    case ('json'):
                        $meta_key = 'config_colums_json_' . $keyword_convert;
                        $meta_value = json_encode($request[$meta_key]);
                        break;
                    default:
                        $meta_key = 'config_colums_input_' . $keyword_convert;
                        $meta_value = $request[$meta_key];
                }
                if (!empty($meta_value) && $meta_value != 'null') {
                    DB::table('config_postmetas')->insert([
                        'module_id' => $id,
                        'module' => $module,
                        'config_colums_id' => $item->id,
                        'meta_key' => $meta_key,
                        'meta_value' => $meta_value,
                        'created_at' => Carbon::now(),
                        'alanguage' => config('app.locale'),
                    ]);
                }
            }
        }
    }
}

if (!function_exists('variations')) {
    function variations($array)
    {
        if (empty($array)) {
            return [];
        }
        function traverse($array, $parent_ind)
        {
            $r = [];
            $pr = '';
            if (!is_numeric($parent_ind)) {
                $pr = $parent_ind . '-';
            }
            foreach ($array as $ind => $el) {
                if (is_array($el)) {
                    $r = array_merge($r, traverse($el, $pr . (is_numeric($ind) ? '' : $ind)));
                } elseif (is_numeric($ind)) {
                    $r[] = $pr . $el;
                } else {
                    $r[] = $pr . $ind . '-' . $el;
                }
            }
            return $r;
        }
        //1. Go through entire array and transform elements that are arrays into elements, collect keys
        $keys = [];
        $size = 1;
        foreach ($array as $key => $elems) {
            if (is_array($elems)) {
                $rr = [];
                foreach ($elems as $ind => $elem) {
                    if (is_array($elem)) {
                        $rr = array_merge($rr, traverse($elem, $ind));
                    } else {
                        $rr[] = $elem;
                    }
                }
                $array[$key] = $rr;
                $size *= count($rr);
            }
            $keys[] = $key;
        }
        //2. Go through all new elems and make variations
        $rez = [];
        for ($i = 0; $i < $size; $i++) {
            $rez[$i] = [];
            foreach ($array as $key => $value) {
                $current = current($array[$key]);
                $rez[$i][$key] = $current;
            }
            foreach ($keys as $key) {
                if (!next($array[$key])) {
                    reset($array[$key]);
                } else {
                    break;
                }
            }
        }
        return $rez;
    }
}
// KiotViet API
if (!function_exists('curl_init_kiotviet')) {
    function curl_init_kiotviet($link)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://public.kiotapi.com/' . $link,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Retailer: yduocdaicatloc',
                'Authorization: Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6ImF0K2p3dCJ9.eyJuYmYiOjE3MTcwMzg4ODAsImV4cCI6MTcxNzEyNTI4MCwiaXNzIjoiaHR0cDovL2lkLmtpb3R2aWV0LnZuIiwiY2xpZW50X2lkIjoiYWFlYmRhMWQtOWVkNy00NDBhLTljNmEtYzc3MzVlYmI4NmQxIiwiY2xpZW50X1JldGFpbGVyQ29kZSI6InlkdW9jZGFpY2F0bG9jIiwiY2xpZW50X1JldGFpbGVySWQiOiI1MDAxMzg1ODIiLCJjbGllbnRfVXNlcklkIjoiMTAyOTQ2NSIsImNsaWVudF9TZW5zaXRpdmVBcGkiOiJUcnVlIiwiY2xpZW50X0dyb3VwSWQiOiIxMCIsImlhdCI6MTcxNzAzODg4MCwic2NvcGUiOlsiUHVibGljQXBpLkFjY2VzcyJdfQ.WhEslzvvdsjzXW4FO3dEiyZhQZUjq9x0xh2q-6WQRMtKj0IvnnxlpxYi6sPBorgD6BWFlW5FqHnjWCMhh0Kbpve6MYhjVbITKx-OAEq34K_rtsQRMM9Ncax1ICobY4l-2NCF4CVnIaSNwO39aiWnsb_b8Twh3mPjK3HN7z-nlrShizBDwEfK2cxXAwZTmFaepgpndSp-tMdgkCCOhCl8uLRUrVeKyPDchBCM3QIrIDdi2knSsQKoxBqKnJoDWE0EIpqNBdKQcQD7azcQKly-QTAoV3Hi_k6bDfoC8mega0uKR8RMBpZqQxPeJFQG4C1iIIab37S9QSlb0Ug4J-qelQ'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return collect(json_decode($response, TRUE));
    }
}
