<?php



namespace App\Components;


use Illuminate\Support\Facades\DB;


class Polylang

{

    public function get($module = '', $id = 0)

    {

        $data = DB::table('polylangs')->where(['module' => $module, config('app.locale') => $id])->first();

        return $data;
    }

    public function insert($module = '', $request = [], $id = 0)

    {

        foreach (config('language') as $key => $item) {

            if (config('app.locale') == $key) {

                DB::table('polylangs')->where(['module' => $module, $key => $id])->delete();
            }
        }

        DB::table('polylangs')->insert([

            'module' => $module,

            'vi' => !empty($request['vi']) ? $request['vi'] : "",

            'en' => !empty($request['en']) ? $request['en'] : "",

            'tl' => !empty($request['tl']) ? $request['tl'] : '',

            'gm' => !empty($request['gm']) ? $request['gm'] : "",

        ]);
    }

    public function module($module = '', $key = '')

    {

        $product  =  DB::table($module)->select('title')->where('id', $key)->first();

        return $product;
    }
}
