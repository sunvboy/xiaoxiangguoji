<?php

namespace App\Http\Controllers\components;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PolyLangController extends Controller
{
    public function autocomplete(Request $request)
    {
        $query = $request->input('keyword');
        $module = $request->input('module');
        $language = $request->input('language');
        $data = DB::table($module)->where('title', 'LIKE', "%{$query}%")->where('alanguage', $language)->get();
        $result = [];
        foreach ($data as $product) {
            $result[] = ['title' => $product->title, 'id' => $product->id];
        }
        return response()->json($result);
    }
}
