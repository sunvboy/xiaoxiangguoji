<?php

namespace App\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Helper
{
    //thêm vào bảng catalogue_relationship
    function catalogue_relation_ship($productid = 0, $catalogueid = 0, $tmp_catalogue = [], $module = '')
    {
        /*$_catalogue_relation_ship[] = array(
            'module' => $module,
            'moduleid' => $productid,
            'catalogueid' => $catalogueid,
            'created_at' => Carbon::now(),
        ); */
        $_catalogue_relation_ship = [];
        if (isset($tmp_catalogue)) {
            foreach ($tmp_catalogue as $v) {
                $_catalogue_relation_ship[] = array(
                    'module' => $module,
                    'moduleid' => $productid,
                    'catalogueid' => $v,
                    'created_at' => Carbon::now(),
                );
            }
        }
        DB::table('catalogues_relationships')->insert($_catalogue_relation_ship);
    }
    //thêm vào bảng attributes_relationships
    function attributes_relationships($productid = 0, $attribute = [], $tmp_catalogue = [])
    {
        $_insert_attribute = [];
        if (isset($attribute) && is_array($attribute) && count($attribute) && $attribute != array('0' => 0)) {
            foreach ($attribute as $key => $val) {
                if (isset($val) && is_array($val) && count($val) && $val != array('0' => 0)) {
                    foreach ($val as $sub => $subs) {
                        if (isset($tmp_catalogue)) {
                            foreach ($tmp_catalogue as $v) {
                                $_insert_attribute[] = array(
                                    'product_id' => $productid,
                                    'attribute_id' => $subs,
                                    'created_at' => Carbon::now(),
                                    'category_product_id' => $v
                                );
                            }
                        }
                    }
                }
            }
            if (check_array($_insert_attribute)) {
                DB::table('attributes_relationships')->insert($_insert_attribute);
            }
        }
    }
    //thêm vào bảng attributes_relationships
    function cours_attributes_relationships($productid = 0, $attribute = [], $tmp_catalogue = [])
    {
        $_insert_attribute = [];
        if (isset($attribute) && is_array($attribute) && count($attribute) && $attribute != array('0' => 0)) {
            foreach ($attribute as $key => $val) {
                if (isset($val) && is_array($val) && count($val) && $val != array('0' => 0)) {
                    foreach ($val as $sub => $subs) {
                        if (isset($tmp_catalogue)) {
                            foreach ($tmp_catalogue as $v) {
                                $_insert_attribute[] = array(
                                    'course_id' => $productid,
                                    'attribute_id' => $subs,
                                    'created_at' => Carbon::now(),
                                    'course_category_id' => $v
                                );
                            }
                        }
                    }
                }
            }
            if (check_array($_insert_attribute)) {
                DB::table('cours_attributes_relationships')->insert($_insert_attribute);
            }
        }
    }
    /*// thêm nhóm thuộc tính vào nhóm sản phẩm
    function update_attribute_catalogue_in_product_catalogue($param = [])
    {
        $_catalogue_relation_ship[] = $param['catalogueid'];
        if (isset($param['tmp_catalogue'])) {
            foreach ($param['tmp_catalogue'] as $v) {
                $_catalogue_relation_ship[] = $v;
            }
        }

        if (!empty($param['attribute_catalogue']) && $param['attribute_catalogue'] != array(0 => 0)) {
            //foreach từng mảng danh mục sản phẩm
            if (isset($_catalogue_relation_ship)) {
                foreach ($_catalogue_relation_ship as $v) {
                    $product_catalogue = DB::table('category_products')->select('attrid')->where('id', '=', $v)->first();
                    $attrid_old = is(json_decode($product_catalogue->attrid, true));
                    foreach ($param['attribute_catalogue'] as $key => $cata) {
                        if (!empty($param['attribute'])) {
                            foreach ($param['attribute'] as $sub => $attr) {
                                if ($key == $sub) {
                                    $attrid_new[$cata] = $attr;
                                }
                            }
                        }
                    }
                    if (!empty($attrid_old)) {
                        foreach ($attrid_old as $cata_old => $attr_old) {
                            if (!empty($attr_old)) {
                                if (!empty($attrid_new) && check_array($attrid_new)) {
                                    foreach ($attrid_new as $cata_new => $attr_new) {
                                        if ($cata_old == $cata_new) {
                                            $attrid[$cata_old] = array_unique(array_merge($attr_new, $attr_old));
                                        }
                                        if ($cata_old != $cata_new) {
                                            $attrid[$cata_new] = (isset($attrid[$cata_new])) ? array_unique(array_merge($attr_new, $attrid[$cata_new])) : $attr_new;
                                            $attrid[$cata_old] = (isset($attrid[$cata_old])) ? array_unique(array_merge($attr_old, $attrid[$cata_old])) : $attr_old;
                                        }
                                    }
                                }
                            } else {
                                foreach ($param['attribute_catalogue'] as $key => $val) {
                                    foreach ($param['attribute'] as $sub => $subs) {
                                        if ($sub == $key) {
                                            $attrid[$val] = $subs;
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        foreach ($param['attribute_catalogue'] as $key => $val) {
                            foreach ($param['attribute'] as $sub => $subs) {
                                if ($sub == $key) {
                                    $attrid[$val] = $subs;
                                }
                            }
                        }
                    }
                    if (isset($attrid) && check_array($attrid)) {
                        $_update_attrid = array(
                            'attrid' => json_encode($attrid),
                        );
                        DB::table('category_products')->where('id', '=', $v)->update($_update_attrid);
                    }
                }
            }
        }
    } */
    // thêm phiên bản sản phẩm: products_version
    /* function create_product_version($param = [])
    {
        $_insert_version = [];
        //lấy dữ liệu post lên
        if (isset($param['title_version']) && is_array($param['title_version']) && count($param['title_version'])) {
            foreach ($param['title_version'] as $key => $val) {
                //thêm id sort để chọn các thuộc tính mua hàng theo thứ tự
                $ex = explode(":", $param['id_version'][$key]);
                $id_sort = array();
                foreach ($ex as $k => $row) {
                    $id_sort[$k] = $row;
                }
                array_multisort($id_sort, SORT_DESC, $ex);
                $_insert_version[] = array(
                    'title_version_1' => $param['title_version_1'][$key],
                    'title_version_2' => !empty($param['title_version_2'][$key]) ? $param['title_version_2'][$key] : '',

                    'productid' => $param['productid'],
                    'title_version' => $val,

                    'id_version' => $param['id_version'][$key],

                    'code_version' => $param['code_version'][$key],
                    'image_version' => !empty($param['image_version'][$key]) ? $param['image_version'][$key] : '',

                    'price_version' => (int)str_replace('.', '', $param['price_version'][$key]),
                    'price_sale_version' => (int)str_replace('.', '', $param['price_sale_version'][$key]),

                    '_stock_status' => $param['_stock_status'][$key],
                    '_stock' => $param['_stock'][$key],
                    '_outstock_status' => $param['_outstock_status'][$key],

                    'id_sort' => json_encode($id_sort),

                    'created_at' => Carbon::now(),
                    'userid_created' => Auth::user()->id,
                );
            }
        }
        //thuc hien groupBy id_version
        $tmpArr = [];
        if (!empty($_insert_version)) {
            foreach ($_insert_version as $key => $item) {
                $tmpArr[$item['title_version_1']]['title'] = $item['title_version_1'];
                $tmpArr[$item['title_version_1']]['children'][$key] = $item;
            }
            ksort($tmpArr, SORT_NUMERIC);
            array_values($tmpArr);
        }
        //done groupBy id_version => getname
        $productVersionArr = [];
        if (isset($tmpArr) && is_array($tmpArr) && count($tmpArr)) {
            foreach ($tmpArr as $key => $value) {
                $tmp_status[$key] = [];
                $totalStock = 0;
                $addOneID = \App\Models\products_color::insertGetId([
                    'title' => $value['title'],
                    'product_id' => $param['productid'],
                    'stock' => 0,
                    'userid_created' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);
                if (isset($value['children']) && is_array($value['children']) && count($value['children'])) {
                    // echo "<pre>";var_dump(array_values($value['children']));
                    //  array_values($value['children']);
                    foreach ($value['children'] as $keyC => $val) {
                        $totalStock += $val['_stock'];
                        $productVersionArr[] = array(
                            'title_version' => $val['title_version'],
                            'code_version' => $val['code_version'],
                            'image_version' => $val['image_version'],
                            'price_version' => $val['price_version'],
                            'price_sale_version' => $val['price_sale_version'],
                            '_stock_status' => $val['_stock_status'],
                            '_stock' =>  $val['_stock'],
                            '_outstock_status' => $val['_outstock_status'],
                            'id_sort' => $val['id_sort'],
                            'productid' => $val['productid'],
                            'product_color_id' => $addOneID,
                            'userid_created' => Auth::user()->id,
                            'created_at' => Carbon::now(),
                        );
                        //check không quản lý tồn kho và đồng ý đặt hàng khi hết hàng

                        if ($val['_stock_status'] == 0 || $val['_outstock_status'] == 1) {
                            $tmp_status[$key][] = $value['title'] . '/' . $val['title_version'];
                        }
                        //tổng số lượng sản phẩm tồn kho lớn hơn 0
                        if ($totalStock > 0) {
                            $tmp_status[$key][] = $value['title'] . '/' . $val['title_version'];
                        }
                    }
                }

                if (!empty($tmp_status[$key])) {
                    DB::table('products_colors')->where('id', '=', $addOneID)->update([
                        'stock' => 1,
                    ]);
                }
            }
        }
        //thực hiện thêm vào bảng products_versions
        if (!empty($productVersionArr)) {
            DB::table('products_versions')->insert($productVersionArr);
        }
    } */
    //thêm vào bảng table_relationship: brand, tag,...
    function tags_relationships($id = 0, $tag_id = [], $module = '')
    {
        $_insert = [];
        if (isset($tag_id) && is_array($tag_id) && count($tag_id) && $tag_id != array('0' => 0)) {
            foreach ($tag_id as $val) {
                if (isset($val) && is_array($val) && count($val) && $val != array('0' => 0)) {
                    foreach ($val as $subs) {
                        $_insert[] = array(
                            'module_id' => $id,
                            'tag_id' => $subs,
                            'module' => $module,
                            'created_at' => Carbon::now(),
                            'userid_created' => Auth::user()->id,
                        );
                    }
                } else {
                    $_insert[] = array(
                        'module_id' => $id,
                        'tag_id'  => $val,
                        'module' => $module,
                        'created_at' => Carbon::now(),
                        'userid_created' => Auth::user()->id,
                    );
                }
            }
            if (check_array($_insert)) {
                DB::table('tags_relationships')->insert($_insert);
            }
        }
    }
    //thêm vào bảng brands_relationships
    function brands_relationships($id = 0, $brand_id = 0, $tmp_catalogue = [])
    {
        //lấy danh mục cha của brand
        $detailBrand = \App\Models\Brand::select('id', 'title', 'slug', 'lft')->where('id', $brand_id)->first();
        if ($detailBrand) {
            $breadcrumbBrand = \App\Models\Brand::select('id', 'title')->where('alanguage', config('app.locale'))->where('lft', '<=', $detailBrand->lft)->where('rgt', '>=', $detailBrand->lft)->orderBy('lft', 'ASC')->get();
            //end
            $_insert_brands_relationships = [];
            if (!$breadcrumbBrand->isEmpty()) {
                foreach ($breadcrumbBrand as $val) {
                    if (isset($tmp_catalogue)) {
                        foreach ($tmp_catalogue as $v) {
                            $_insert_brands_relationships[] = array(
                                'product_id' => $id,
                                'brand_id' => $val->id,
                                'created_at' => Carbon::now(),
                                'userid_created' => Auth::user()->id,
                                'category_product_id' => $v
                            );
                        }
                    }
                }
                if (check_array($_insert_brands_relationships)) {
                    DB::table('brands_relationships')->insert($_insert_brands_relationships);
                }
            }
        }
    }
    //thêm giá của sản phẩm vào khoảng giá của bộ lọc
    function price_attributes($price = 0, $productid = 0, $tmp_catalogue = [])
    {
        $category_attributes = DB::table('category_attributes')->where(['ishome' => 1, 'alanguage' => config('app.locale')])->first();

        if ($category_attributes) {
            // $attributes = DB::table('attributes')->where('price_start', '<=', $price)->where('price_end', '>=', $price)->where('catalogueid', $category_attributes->id)->where('price_end', 0)->first();
            $attributes = DB::table('attributes')->where('price_start', '<=', $price)->where('price_end', '>', $price)->where('catalogueid', $category_attributes->id)->first();
            if ($attributes) {
                if (isset($tmp_catalogue)) {
                    foreach ($tmp_catalogue as $v) {
                        DB::table('attributes_relationships')->insert(array(
                            'product_id' => $productid,
                            'attribute_id' => $attributes->id,
                            'category_product_id' => $v,
                            'created_at' => Carbon::now(),
                        ));
                    }
                }
            } else {
                $attributesMax = DB::table('attributes')->where('price_start', '<=', $price)->where('price_end', 0)->where('catalogueid', $category_attributes->id)->first();
                if ($attributesMax) {
                    if (isset($tmp_catalogue)) {
                        foreach ($tmp_catalogue as $v) {
                            DB::table('attributes_relationships')->insert(array(
                                'product_id' => $productid,
                                'attribute_id' => $attributesMax->id,
                                'category_product_id' => $v,
                                'created_at' => Carbon::now(),
                            ));
                        }
                    }
                }
            }
        }
    }
    //Them moi phien ban san pham: product_versions
    function insert_product_versions($request = [], $id)
    {
        //lấy danh sách chi nhánh
        $address = \App\Models\Address::select('id')->where('alanguage', config('app.locale'))->get();
        //end
        $ids = $request['ids'];
        $title_version = $request['title_version'];
        $image_version = $request['image_version'];
        $code_version = $request['code_version'];
        $_stock_status = $request['_stock_status'];
        // $_stock = !empty($request['_stock']) ? $request['_stock'] : 0;
        $_outstock_status = !empty($request['_outstock_status']) ? $request['_outstock_status'] : 0;
        $_ships_weight = !empty($request['_ships_weight']) ? $request['_ships_weight'] : '';
        $_ships_length = !empty($request['_ships_length']) ? $request['_ships_length'] : '';
        $_ships_width = !empty($request['_ships_width']) ? $request['_ships_width'] : '';
        $_ships_height = !empty($request['_ships_height']) ? $request['_ships_height'] : '';
        $price_version =  !empty($request['price_version']) ? str_replace('.', '', $request['price_version']) : 0;
        $price_sale_version =  !empty($request['price_sale_version']) ? str_replace('.', '', $request['price_sale_version']) : 0;
        $price_import_version =  !empty($request['price_import_version']) ? str_replace('.', '', $request['price_import_version']) : 0;
        // $_stock_address =  !empty($request['_stock_address']) ? $request['_stock_address'] : [];
        $_insert_version = [];
        $_insert_stock = [];
        if (!empty($title_version)) {
            foreach ($title_version as $key => $item) {
                $value_id = [];
                $value_title = [];
                //lấy id theo title 
                $explodeID = explode('&&&&', $item);
                if (!empty($explodeID)) {
                    $filtered = collect($explodeID)->filter(function ($value, $key) {
                        return $value != '';
                    });
                    $getAttrid = \App\Models\Attribute::select('id', 'title')->where(['alanguage' => config('app.locale')])->whereIn('title', $filtered)->orderBy('id', 'asc')->get();
                    if (!$getAttrid->isEmpty()) {
                        foreach ($getAttrid as $val) {
                            $value_id[] = $val->id;
                            $value_title[] = $val->title;
                        }
                    }
                }
                //end
                if (!empty($ids[$key])) {
                    $_insert_version[]  = array(
                        'id' => $ids[$key],
                        'product_id' => $id,
                        'id_version' => json_encode(collect($value_id)->sort()),
                        'title_version' => json_encode($value_title),
                        'code_version' => $code_version[$key],
                        'image_version' => !empty($image_version[$key]) ? $image_version[$key] : '',
                        'price_version' => $price_version[$key],
                        'price_sale_version' => $price_sale_version[$key],
                        'price_import_version' => $price_import_version[$key],
                        '_stock_status' => $_stock_status[$key],
                        // '_stock' => !empty($_stock[$key]) ? $_stock[$key] : '',
                        '_outstock_status' => !empty($_outstock_status[$key]) ? $_outstock_status[$key] : '',
                        '_ships_weight' => !empty($_ships_weight[$key]) ? $_ships_weight[$key] : '',
                        '_ships_length' => !empty($_ships_length[$key]) ? $_ships_length[$key] : '',
                        '_ships_width' => !empty($_ships_width[$key]) ? $_ships_width[$key] : '',
                        '_ships_height' => !empty($_ships_height[$key]) ? $_ships_height[$key] : '',
                        'updated_at' => Carbon::now(),
                        'userid_updated' => Auth::user()->id,
                    );
                } else {
                    $_insert_version[]  = array(
                        'product_id' => $id,
                        'id_version' => json_encode(collect($value_id)->sort()),
                        'title_version' => json_encode($value_title),
                        'code_version' => $code_version[$key],
                        'image_version' => !empty($image_version[$key]) ? $image_version[$key] : '',
                        'price_version' => $price_version[$key],
                        'price_sale_version' => $price_sale_version[$key],
                        'price_import_version' => $price_import_version[$key],
                        '_stock_status' => $_stock_status[$key],
                        // '_stock' => !empty($_stock[$key]) ? $_stock[$key] : '',
                        '_outstock_status' => !empty($_outstock_status[$key]) ? $_outstock_status[$key] : '',
                        '_ships_weight' => !empty($_ships_weight[$key]) ? $_ships_weight[$key] : '',
                        '_ships_length' => !empty($_ships_length[$key]) ? $_ships_length[$key] : '',
                        '_ships_width' => !empty($_ships_width[$key]) ? $_ships_width[$key] : '',
                        '_ships_height' => !empty($_ships_height[$key]) ? $_ships_height[$key] : '',
                        'created_at' => Carbon::now(),
                        'userid_created' => Auth::user()->id,
                    );
                }

                //lưu tồn kho
                /*if (!empty($_stock_address) && !empty($_stock_address[$key])) {
                    foreach ($_stock_address[$key] as $ks => $vs) {
                        $_insert_stock[]  = array(
                            'product_id' => $id,
                            'value' => $vs,
                            'address_id' => $ks,
                            'type' => 'variable',
                            'product_version_id' => json_encode(collect($value_id)->sort()),
                            'created_at' => Carbon::now(),
                            'user_id' => Auth::user()->id,
                        );
                    }
                } */
                //end
            }
        }
        /* \App\Models\ProductVersion::insert($_insert_version); */
        if (!empty($_insert_version)) {
            foreach ($_insert_version as $key => $item) {
                if (!empty($item['id'])) {
                    \App\Models\ProductVersion::where('id', $item['id'])->update($item);
                } else {
                    $id_insert = \App\Models\ProductVersion::insertGetId($item);
                    if ($id_insert > 0) {
                        if (!empty($address)) {
                            foreach ($address as $ks => $vs) {
                                $_insert_stock[]  = array(
                                    'address_id' => $vs->id,
                                    'product_id' => $id,
                                    'product_version_id' => $id_insert,
                                    'type' => 'variable',
                                    'created_at' => Carbon::now(),
                                    'user_id' => Auth::user()->id,
                                );
                            }
                        }
                    }
                }
            }
        }
        \App\Models\ProductStock::insert($_insert_stock);
    }
    //Them moi phien ban san pham: product_versions
    function insert_product_stocks($id)
    {
        $address = \App\Models\Address::select('id')->where('alanguage', config('app.locale'))->get();
        /*
        if (!empty($inventoryQuantity)) {
            $idProductStock = \App\Models\ProductStock::insertGetId(array(
                'product_id' => $id,
                'value' => $inventoryQuantity,
                'type' => 'simple',
                'user_id' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ));
        }
        $_insert = [];
        if (!empty($stockAddress)) {
            foreach ($stockAddress as $key => $item) {
                $_insert[]  = array(
                    'product_id' => $id,
                    'address_id' => $key,
                    'type' => 'simple',
                    'value' => (float)str_replace('.', '', $item),
                    'user_id' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                );
            }
            \App\Models\ProductStock::insert($_insert);
        }*/
        $_insert = [];
        if (!empty($address) && count($address) > 0) {
            foreach ($address as $k => $v) {
                $_insert[]  = array(
                    'address_id' => $v->id,
                    'product_id' => $id,
                    'type' => 'simple',
                    'user_id' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                );
            }
        }
        \App\Models\ProductStock::insert($_insert);
    }
    //thêm thuế vào bảng taxes_relationships
    function insert_taxes_relationships($taxes_type = 'notax', $taxes_import = 0, $taxes_export = 0, $id)
    {
        \App\Models\TaxesRelationships::insertGetId(array(
            'product_id' => $id,
            'taxes_type' => $taxes_type,
            'taxes_import' => $taxes_import,
            'taxes_export' => $taxes_export,
            'created_at' => Carbon::now(),
        ));
    }
    //thêm Course
    function addCourse($chapter = [], $lesson = [], $id = 0, $action = 'create')
    {
        $arr_convert = convert_chapter($chapter, $lesson, $id);
        if ($action == 'create') {
            if (isset($arr_convert) && is_array($arr_convert) && count($arr_convert)) {
                foreach ($arr_convert as $key => $val) {
                    $resultid = \App\Models\CourseChapter::insertGetId(array(
                        'course_id' => $id,
                        'title' => $val['title'],
                        'description' => !empty($val['description']) ? $val['description'] : '',
                        'count' => $val['count'],
                        'created_at' => Carbon::now(),
                    ));
                    if ($resultid > 0) {
                        if (isset($val['lessons']) && is_array($val['lessons']) && count($val['lessons'])) {
                            foreach ($val['lessons'] as $k => $v) {
                                // if (!empty($v['title']) && !empty($v['link'])) {
                                if (!empty($v['title'])) {
                                    \App\Models\CourseLesson::insertGetId(array(
                                        'course_chapter_id' => $resultid,
                                        'course_id' => $id,
                                        'title' => $v['title'],
                                        'slug' => slug($v['title']),
                                        'link' => !empty($v['link']) ? $v['link'] : '',
                                        'description' => !empty($v['description']) ? $v['description'] : '',
                                        'created_at' => Carbon::now(),
                                    ));
                                }
                            }
                        }
                    }
                }
            }
        } else {
            //check xóa chapter
            $chaptersBefore = \App\Models\CourseChapter::where('course_id', $id)->pluck('id');
            $chaptersAfter = collect($arr_convert)->groupBy('id')->keys()->all();
            if (!empty($chaptersBefore)) {
                foreach ($chaptersBefore as $item) {
                    if (!in_array($item, $chaptersAfter)) {
                        \App\Models\CourseChapter::where(['id' => $item])->delete();
                        \App\Models\CourseLesson::where(['product_chapter_id' => $item])->delete();
                    }
                }
            }
            //end
            //check xóa lesson
            $lessonBefore = \App\Models\CourseLesson::where(['course_id' => $id])->pluck('id');
            $lessonAfter = [];
            if (!empty($arr_convert)) {
                foreach ($arr_convert as $item) {
                    if (!empty($item['lessons'])) {
                        foreach ($item['lessons'] as $val) {
                            if (!empty($val['id'])) {
                                $lessonAfter[] = $val['id'];
                            }
                        }
                    }
                }
            }
            if (!empty($lessonBefore)) {
                foreach ($lessonBefore as $item) {
                    if (!in_array($item, $lessonAfter)) {
                        \App\Models\CourseLesson::where(['id' => $item])->delete();
                    }
                }
            }
            //end
            if (isset($arr_convert) && is_array($arr_convert) && count($arr_convert)) {
                foreach ($arr_convert as $key => $val) {
                    //Nếu tồn tại chapter_id thì update => chapter
                    if (!empty($val['id'])) {
                        \App\Models\CourseChapter::where('id', $val['id'])->update([
                            'course_id' => $id,
                            'title' => $val['title'],
                            'description' => !empty($val['description']) ? $val['description'] : '',
                            'count' => $val['count'],
                            'updated_at' => Carbon::now(),
                        ]);
                        if (isset($val['lessons']) && is_array($val['lessons']) && count($val['lessons'])) {
                            foreach ($val['lessons'] as $k => $v) {
                                //tồn tại lesson thì update
                                if (!empty($v['id'])) {
                                    // if (!empty($v['title']) && !empty($v['link'])) {
                                    if (!empty($v['title'])) {
                                        \App\Models\CourseLesson::where('id', $v['id'])->update(array(
                                            'course_chapter_id' => $val['id'],
                                            'course_id' => $id,
                                            'title' => $v['title'],
                                            'slug' => slug($v['title']),
                                            'link' => !empty($v['link']) ? $v['link'] : '',
                                            'description' => !empty($v['description']) ? $v['description'] : '',
                                            'updated_at' => Carbon::now(),
                                        ));
                                    }
                                } else {
                                    //không tồn tại lesson thì create
                                    // if (!empty($v['title']) && !empty($v['link'])) {
                                    if (!empty($v['title'])) {
                                        \App\Models\CourseLesson::insertGetId(array(
                                            'course_chapter_id' => $val['id'],
                                            'course_id' => $id,
                                            'title' => $v['title'],
                                            'slug' => slug($v['title']),
                                            'link' => !empty($v['link']) ? $v['link'] : '',
                                            'description' => !empty($v['description']) ? $v['description'] : '',
                                            'created_at' => Carbon::now(),
                                        ));
                                    }
                                }
                            }
                        }
                    } else {
                        //không tồn tại ID thêm chapter mới
                        $resultid = \App\Models\CourseChapter::insertGetId(array(
                            'course_id' => $id,
                            'title' => $val['title'],
                            'description' => !empty($val['description']) ? $val['description'] : '',
                            'count' => $val['count'],
                            'created_at' => Carbon::now(),
                        ));
                        if ($resultid > 0) {
                            if (isset($val['lessons']) && is_array($val['lessons']) && count($val['lessons'])) {
                                foreach ($val['lessons'] as $k => $v) {
                                    // if (!empty($v['title']) && !empty($v['link'])) {
                                    if (!empty($v['title'])) {
                                        \App\Models\CourseLesson::insertGetId(array(
                                            'course_chapter_id' => $resultid,
                                            'course_id' => $id,
                                            'title' => $v['title'],
                                            'slug' => slug($v['title']),
                                            'link' => !empty($v['link']) ? $v['link'] : '',
                                            'description' => !empty($v['description']) ? $v['description'] : '',
                                            'created_at' => Carbon::now(),
                                        ));
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
