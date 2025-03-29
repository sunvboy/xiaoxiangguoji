<?php


if (!function_exists('getMenus')) {

    function getMenus($keyword = "")
    {
        $data = Cache::remember($keyword, 600, function () use ($keyword) {
            $data = \App\Models\Menu::select('id', 'title')->where(['slug' => $keyword])->with(['menu_items' => function ($query) {
                $query->select('menu_items.id', 'menu_items.menu_id', 'menu_items.parentid', 'menu_items.title', 'menu_items.image', 'menu_items.slug', 'menu_items.target', 'menu_items.type', 'menu_items.module_id')
                    ->where(['alanguage' => config('app.locale'), 'parentid' => 0])
                    ->with(['children' => function ($query) {
                        $query->select('menu_items.id', 'menu_items.menu_id', 'menu_items.parentid', 'menu_items.title', 'menu_items.image', 'menu_items.slug', 'menu_items.target', 'menu_items.type', 'menu_items.module_id')->where('alanguage', config('app.locale'))
                            ->orderBy('menu_items.order', 'asc')->orderBy('menu_items.id', 'desc');
                    }])
                    ->orderBy('menu_items.order', 'asc')->orderBy('menu_items.id', 'desc');
            }])->first();
            return $data;
        });
        return $data;
    }
}
if (!function_exists('getHtmlMenus')) {
    function getHtmlMenus($data = [], $arr = [])
    {
        $html = '';
        $html .= '<ul class="' . $arr['ul'] . '">';
        if ($data) {
            if (count($data->menu_items) > 0) {
                foreach ($data->menu_items as $item) {
                    $_blank = !empty($item->target === '_blank') ? 'target="_blank"' : '';
                    $html .= '<li class="' . $arr['li'] . ' group relative ">';
                    $html .= '<a href="' . url($item->slug) . '" class="' . $arr['a'] . ' ' . $arr['hover_color'] . ' flex items-center" ' . $_blank . '>';
                    $html .= '<span class="lg:mt-0 ' . $arr['hover_color'] . '">' . $item->title . '</span>';

                    if (count($item->children) > 0) {
                        $html .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>';
                    }

                    $html .= '</a>';
                    if (count($item->children) > 0) {
                        //menu cấp 2
                        $html .= '<ul class="' . $arr['ul_2'] . ' group-hover:block hidden absolute dropdown left-0 top-full w-[200px] bg-white text-left rounded z-10 ">';
                        foreach ($item->children as $item2) {
                            $_blank_2 = !empty($item2->target === '_blank') ? 'target="_blank"' : '';
                            $html .= '<li class="' . $arr['li_2'] . ' group2 relative">';
                            $html .= '<a href="' . url($item2->slug) . '" class="' . $arr['hover_color'] . '" ' . $_blank_2 . '>' . $item2->title . '';
                            if (count($item2->children) > 0) {
                                $html .= ' <span class="float-right"><i class="fa fa-angle-right " aria-hidden="true"></i></span>';
                            }
                            $html .= '</a>';
                            if (count($item2->children) > 0) {
                                $html .= '<ul class="' . $arr['ul_3'] . ' group2-hover:block hidden absolute dropdown left-full top-0 w-[200px]">';
                                foreach ($item2->children as $item3) {
                                    $_blank_3 = !empty($item3->target === '_blank') ? 'target="_blank"' : '';
                                    $html .= '<li class="' . $arr['li_3'] . '"><a href=" ' . url($item3->slug) . '" class="' . $arr['hover_color'] . '" ' . $_blank_3 . '>' . $item3->title . '</a></li>';
                                }
                                $html .= '</ul>';
                            }
                            $html .= '</li>';
                        }
                        $html .= '</ul>';
                        //end
                    }
                    $html .= '</li>';
                }
            }
        }
        $html .= '</ul>';
        return $html;
    }
}
if (!function_exists('getHtmlMenusFooter')) {
    function getHtmlMenusFooter($data = [], $arr = [])
    {
        $html = '';
        if ($data) {
            if (count($data->menu_items) > 0) {
                foreach ($data->menu_items as $item) {
                    if (count($item->children) > 0) {
                        $html .= '<div class="' . $arr['class'] . '">';
                        $html .= '<div class="item">';
                        $html .= '<div class="' . $arr['class_title'] . '">' . $item->title . '';
                        $html .= '</div>';
                        $html .= ' <ul class="' . $arr['class_ul'] . '">';
                        foreach ($item->children as $item2) {
                            $_blank = !empty($item2->target === '_blank') ? 'target="_blank"' : '';
                            $html .= ' <li class="' . $arr['class_li'] . '">';
                            $html .= ' <a href="' . url($item2->slug) . '" class="' . $arr['class_a'] . '" ' . $_blank . '>' . $item2->title . '</a>';
                            $html .= ' </li>';
                        }
                        $html .= ' </ul>';
                        $html .= '</div>';
                        $html .= '</div>';
                    }
                }
            }
        }
        return $html;
    }
}
if (!function_exists('getHtmlFormSearch')) {

    function getHtmlFormSearch($arr = [])
    {
        $html = '';
        $html .= '<form class="' . $arr['classForm'] . '" action="' . $arr['action'] . '" method="GET" enctype="multipart/form">';
        $html .= '<div class="relative">';
        $html .= '<input placeholder="' . $arr['placeholder'] . '" type="text" value="" class="' . $arr['classInput'] . '" name="keyword" />';
        $html .= '<button class="absolute right-1 rounded-full bg-d61c1f h-9 w-10 text-white top-1/2 ' . $arr['classButton'] . '" style="transform: translateY(-50%) " type="submit">';
        $html .= '<svg
  width="24"
  height="24"
  viewBox="0 0 24 24"
  fill="none"
  class="' . $arr['classSvg'] . '"
  xmlns="http://www.w3.org/2000/svg"
>
  <path
    fill-rule="evenodd"
    clip-rule="evenodd"
    d="M18.319 14.4326C20.7628 11.2941 20.542 6.75347 17.6569 3.86829C14.5327 0.744098 9.46734 0.744098 6.34315 3.86829C3.21895 6.99249 3.21895 12.0578 6.34315 15.182C9.22833 18.0672 13.769 18.2879 16.9075 15.8442C16.921 15.8595 16.9351 15.8745 16.9497 15.8891L21.1924 20.1317C21.5829 20.5223 22.2161 20.5223 22.6066 20.1317C22.9971 19.7412 22.9971 19.1081 22.6066 18.7175L18.364 14.4749C18.3493 14.4603 18.3343 14.4462 18.319 14.4326ZM16.2426 5.28251C18.5858 7.62565 18.5858 11.4246 16.2426 13.7678C13.8995 16.1109 10.1005 16.1109 7.75736 13.7678C5.41421 11.4246 5.41421 7.62565 7.75736 5.28251C10.1005 2.93936 13.8995 2.93936 16.2426 5.28251Z"
    fill="currentColor"
  />
</svg>';
        $html .= '</button>';
        $html .= '</div>';
        $html .= '</form>';
        return $html;
    }
}
if (!function_exists('dropdown')) {

    function dropdown($data = [], $title = 'Select', $key = '', $value = '')
    {
        if (!empty($title)) {
            $return['0'] = $title;
        }
        if (!empty($data)) {
            foreach ($data as $item) {
                $return[$item[$key]] = $item[$value];
            }
        }
        return $return;
    }
}
if (!function_exists('langURLFrontend')) {

    function langURLFrontend($module = '', $locale = '', $id = 0, $model = '')
    {
        $data = [];
        $lang = \App\Models\Polylang::where(['module' => $module, $locale => $id])->first();
        if (!empty($lang)) {
            $slugVI = $model::select('slug')->find($lang->vi);
            if (!empty($slugVI)) {
                $data['vi'] = url($slugVI->slug);
            }
            foreach (config('app.alt_langs') as $item) {
                $slugLanguage = $model::select('slug')->find($lang->$item);
                if (!empty($slugLanguage)) {
                    $data[$item] = url($item . '/' . $slugLanguage->slug);
                }
            }
        }
        return $data;
    }
}
if (!function_exists('configEmail')) {

    function configEmail()
    {
        $settingEmail = \App\Models\ConfigEmail::select('data')->where('id', 1)->first();
        if ($settingEmail) {
            $emailJson = json_decode($settingEmail->data, true);
            config(['mail.mailers.smtp.username' => !empty($emailJson) ? (!empty($emailJson[0]) ? $emailJson[0] : env('MAIL_USERNAME')) : env('MAIL_USERNAME'), 'mail.mailers.smtp.password' => !empty($emailJson) ? (!empty($emailJson[1]) ? $emailJson[1] : env('MAIL_USERNAME')) : env('MAIL_PASSWORD')]);
        }
    }
}
