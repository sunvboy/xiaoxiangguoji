<?php
if (!function_exists('svl_ismobile')) {

    function svl_ismobile()
    {
        $tablet_browser = 0;
        $mobile_browser = 0;

        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $tablet_browser++;
        }

        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
        }

        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
        }

        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
            'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
            'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
            'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
            'newt', 'noki', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
            'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
            'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
            'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
            'wapr', 'webc', 'winw', 'winw', 'xda ', 'xda-'
        );

        if (in_array($mobile_ua, $mobile_agents)) {
            $mobile_browser++;
        }

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'opera mini') > 0) {
            $mobile_browser++;
            //Check for tablets on opera mini alternative headers
            $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'] : (isset($_SERVER['HTTP_DEVICE_STOCK_UA']) ? $_SERVER['HTTP_DEVICE_STOCK_UA'] : ''));
            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
                $tablet_browser++;
            }
        }

        if ($tablet_browser > 0) {
            // do something for tablet devices
            return 'is tablet';
        } else if ($mobile_browser > 0) {
            // do something for mobile devices
            return 'is mobile';
        } else {
            // do something for everything else
            return 'is desktop';
        }
    }
}
if (!function_exists('getImageUrl')) {
    function getImageUrl($module = '', $src = '', $type = '')
    {
        $path  = '';
        $dir = explode("/", $src);
        $file = collect($dir)->last();
        if (svl_ismobile() == 'is mobile') {
            $path = 'upload/.thumbs/images/' . $module . '/' . $type . '/' . $file;
        } else if (svl_ismobile() == 'is tablet') {
            $path = 'upload/.thumbs/images/' . $module . '/' . $type . '/' . $file;
        } else if (svl_ismobile() == 'is desktop') {
            $path = 'upload/.thumbs/images/' . $module . '/' . $type . '/' . $file;
        } else {
            $path = $src;
        }
        if (File::exists(base_path($path))) {
            $path = $path;
        } else {
            $path = $src;
        }
        return asset($path);
    }
}
if (!function_exists('getFunctions')) {
    function getFunctions()
    {
        $data = [];
        $getFunctions = \App\Models\Permission::select('title')->where('publish', 0)->where('parent_id', 0)->get()->pluck('title');
        if (!$getFunctions->isEmpty()) {

            foreach ($getFunctions as $v) {
                $data[] = $v;
            }
        }
        return $data;
    }
}
if (!function_exists('getUrlHome')) {
    function getUrlHome()
    {
        return !empty(config('app.locale') == 'vi') ? url('/') : url('/en');
    }
}
/**HTML: Breadcrumb */
if (!function_exists('htmlBreadcrumb')) {
    function htmlBreadcrumb($title = '', $breadcrumb = [])
    {
        $html = '';
        $html .= '<div class="breadcrumb py-[10px] relative">
        <div class="container mx-auto px-3">
          <ul class="flex flex-wrap justify-start">
            <li class="pr-[5px] text-black">
              <a href="' . getUrlHome() . '" class=" text-f15 text-black">Trang chủ</a>
            </li>';
        if (!empty($breadcrumb)) {
            foreach ($breadcrumb as $item) {
                $html .= '<li>
                    <div class="flex items-center">/&nbsp;<a href="' . route('routerURL', ['slug' => $item['slug']]) . '" class=" text-f15 text-black">' . $item['title'] . '&nbsp</a>
                    </div>
                </li>';
            }
        } else {
            $html .= '<li>
                    <div class="flex items-center">/&nbsp;<a href="javascript:void(0)" class=" text-f15 text-black">' . $title . '</a>
                    </div>
                </li>';
        }
        $html .= '</ul>
        </div>
      </div>';
        /*
        $html .= '
        <nav class="px-3 relative w-full flex flex-wrap items-center justify-between py-2 bg-[#f9f9f9] text-gray-500 hover:text-gray-700 focus:text-gray-700 navbar navbar-expand-lg navbar-light">
            <ol class="container inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="' . getUrlHome() . '" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        ' . trans('index.home') . '
                    </a>
                </li>';
        if (!empty($breadcrumb)) {
            foreach ($breadcrumb as $item) {
                $html .= '<li>
                    <div class="flex items-center">
                       /
                        <a href="' . route('routerURL', ['slug' => $item['slug']]) . '" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">' . $item['title'] . '</a>
                    </div>
                </li>';
            }
        } else {
            $html .= '<li>
                    <div class="flex items-center">
                        /
                        <a href="javascript:void(0)" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">' . $title . '</a>
                    </div>
                </li>';
        }


        $html .= '</ol>
        </nav>';
        */

        return $html;
    }
}
if (!function_exists('htmlArticle')) {
    function htmlArticle($item = [])
    {
        $html = '';
        $html .= '<div class="mb-[50px] px-[10px]">
             <div class=" h-full flex flex-col space-y-2">
                <div class="img hover-zoom flex-shrink-0 zoom-effect overflow-hidden">
                    <a href="' . route('routerURL', ['slug' => $item['slug']]) . '" class="relative">
                        <img src="' . asset($item['image']) . '" alt="' . $item['title'] . '" class="w-full object-cover md:h-[190px]" />
                    </a>
                </div>
                 <div class="flex-1 flex flex-col justify-between space-y-1.5">
                    <h3 class="title-2 text-f15 md:text-base font-black  clamp-3">
                        <a href="' . route('routerURL', ['slug' => $item['slug']]) . '" class="text-base leading-[1.1] transition-all hover:text-primary">' . $item['title'] . '</a>
                    </h3>
                    <div class="flex items-center text-sm text-[#999]">
                        <span class="flex items-center space-x-1">
                            <i class="fa-solid fa-calendar-days"></i>
                            <span>
                                ' . $item['created_at'] . '
                            </span>
                        </span>
                    </div>
                    <div class="clamp clamp-3 text-[#757575]">
                        ' . strip_tags($item['description']) . '
                    </div>
                    <div>
                        <a href="' . route('routerURL', ['slug' => $item['slug']]) . '" class="font-bold tracking-wider uppercase text-f13">Xem thêm ...</a>
                    </div>
                 </div>
             </div>
         </div>';
        return $html;
    }
}
if (!function_exists('htmlAddress')) {
    function htmlAddress($data = [])
    {
        $html = '';
        if (isset($data)) {
            foreach ($data as $k => $v) {
                $html .= ' <li class="showroom-item loc_link result-item" data-brand="' . $v->title . '"
                    data-address="' . $v->address . '" data-phone="' . $v->hotline . '" data-lat="' . $v->lat . '"
                    data-long="' . $v->long . '">
                    <div class="heading" style="display: flex">

                        <p class="name-label" style="flex: 1">
                            <strong>' . ($k + 1) . '. ' . $v->title . '</strong>
                        </p>
                    </div>
                    <div class="details">
                        <p class="address" style="flex:1"><em>' . $v->address . '</em>
                        </p>

                        <p class="button-desktop button-view hidden-xs">
                            <a href="javascript:void(0)" onclick="return false;">Tìm đường</a>
                            <a class="arrow-right"><span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                        </p>
                        <p class="button-mobile button-view visible-xs">
                            <a target="_blank" href="https://www.google.com/maps/dir//' . $v->lat . ',' . $v->long . '">Tìm đường</a>
                            <a class="arrow-right" target="_blank"
                                href="https://www.google.com/maps/dir//' . $v->lat . ',' . $v->long . '"><span><i
                                        class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                        </p>
                    </div>
                </li>';
            }
        }
        return $html;
    }
}
/**HTML: item sản phẩm */
if (!function_exists('htmlItemProduct')) {
    function htmlItemProduct($key = '', $item = [], $class = 'item item-product')
    {
        $wishlist = isset($_COOKIE['wishlist']) ? json_decode($_COOKIE['wishlist'], TRUE) : NULL;
        $i_class = 'fa-heart-o';
        if (!empty($wishlist)) {
            if (in_array($item['id'], $wishlist)) {
                $i_class = 'fa-heart';
            }
        }
        $html = '';
        $price = getPrice(array('price' => $item['price'], 'price_sale' => $item['price_sale'], 'price_contact' =>
        $item['price_contact']));
        $route = route('routerURL', ['slug' => $item['slug']]);

        if (!empty($item['image_json'])) {
            $listAlbums = json_decode($item['image_json'], true);
            if (count($listAlbums) < 2) {
                $listAlbums = [$item['image'], $item['image']];
            }
        } else {
            $listAlbums = [$item['image'], $item['image']];
        }
        // $getTags = $item['getTags'];
        $html .= ' <div class="ps-product ps-product--standard">
                                        <div class="ps-product__thumbnail">';
        if (!empty($price['percent'])) {
            $html .= '<span class="smart">-
                                                ' . $price['percent'] . '
                                            </span>';
        }


        /*   $html .= '<span class="icon-wish js_add_wishlist cursor-pointer" data-id="' . $item['id'] . '">
                                                <svg class="icon ' . $i_class . ' js_add_wishlist_' . $item['id'] . '" xmlns="http://www.w3.org/2000/svg" width="17" height="20" viewBox="0 0 17 20" fill="none">
                                                    <path d="M1.2002 5.8C1.2002 4.11984 1.2002 3.27976 1.52718 2.63803C1.8148 2.07354 2.27374 1.6146 2.83822 1.32698C3.47996 1 4.32004 1 6.0002 1H10.4002C12.0804 1 12.9204 1 13.5622 1.32698C14.1267 1.6146 14.5856 2.07354 14.8732 2.63803C15.2002 3.27976 15.2002 4.11984 15.2002 5.8V19L8.2002 15L1.2002 19V5.8Z" stroke="#00AB6D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </span>'; */

        $html .= '<a class="ps-product__image" href="' . $route . '">
                                                <figure>
                                                    <img src="' . asset($item['image']) . '" alt="' . $item['title'] . '" />
                                                  
                                                </figure>
                                            </a>
                                            <div class="heart-cart">
                                                <a href="javascript:void(0)" class="heart js_add_wishlist" data-id="' . $item['id'] . '">
                                                <i class="fa ' . $i_class . ' js_add_wishlist_' . $item['id'] . '"></i>
                                                </a>
                                                <a href="' . $route . '" class="cart"><i class="icon-cart-empty"></i></a>
                                            </div>
                                        </div>
                                        <div class="ps-product__content">
                                            <h5 class="ps-product__title"><a href="' . $route . '">' . $item['title'] . '</a></h5>
                                            <div class="ps-product__meta"><span class="ps-product__price sale">' . $price['price_final'] . '</span><span class="ps-product__del">' . $price['price_old'] . '</span>
                                            </div>
                                        </div>
                                    </div>';
        return $html;
    }
}
if (!function_exists('htmlItemProduct2')) {
    function htmlItemProduct2($key = '', $item = [], $class = 'item item-product')
    {
        $wishlist = isset($_COOKIE['wishlist']) ? json_decode($_COOKIE['wishlist'], TRUE) : NULL;
        $i_class = 'fa-heart-o';
        if (!empty($wishlist)) {
            if (in_array($item['id'], $wishlist)) {
                $i_class = 'fa-heart';
            }
        }
        $html = '';
        $price = getPrice(array('price' => $item['price'], 'price_sale' => $item['price_sale'], 'price_contact' =>
        $item['price_contact']));
        $route = route('routerURL', ['slug' => $item['slug']]);

        if (!empty($item['image_json'])) {
            $listAlbums = json_decode($item['image_json'], true);
            if (count($listAlbums) < 2) {
                $listAlbums = [$item['image'], $item['image']];
            }
        } else {
            $listAlbums = [$item['image'], $item['image']];
        }
        // $getTags = $item['getTags'];
        $html .= ' <div class="item-product-2">
                                                <div class="img">';
        if (!empty($price['percent'])) {
            $html .= '<span class="smart">-
                                                        ' . $price['percent'] . '
                                                    </span>';
        }

        /*$html .= '<span class="icon-wish js_add_wishlist cursor-pointer" data-id="' . $item['id'] . '">
                                                <svg class="icon ' . $i_class . ' js_add_wishlist_' . $item['id'] . '" xmlns="http://www.w3.org/2000/svg" width="17" height="20" viewBox="0 0 17 20" fill="none">
                                                    <path d="M1.2002 5.8C1.2002 4.11984 1.2002 3.27976 1.52718 2.63803C1.8148 2.07354 2.27374 1.6146 2.83822 1.32698C3.47996 1 4.32004 1 6.0002 1H10.4002C12.0804 1 12.9204 1 13.5622 1.32698C14.1267 1.6146 14.5856 2.07354 14.8732 2.63803C15.2002 3.27976 15.2002 4.11984 15.2002 5.8V19L8.2002 15L1.2002 19V5.8Z" stroke="#00AB6D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </span>'; */
        $html .= '<div class="qua-tang" title="' . $item['title'] . '">
                                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.25 13V22H7.25C5.45507 22 4 20.5449 4 18.75V13H11.25ZM20 13V18.75C20 20.5449 18.5449 22 16.75 22H12.75V13H20ZM14.5 2C16.2949 2 17.75 3.45507 17.75 5.25C17.75 5.89498 17.5621 6.49607 17.2381 7.00154L19.75 7C20.4404 7 21 7.46637 21 8.04167V10.9583C21 11.5336 20.4404 12 19.75 12L12.75 11.999V7H11.25V11.999L4.25 12C3.55964 12 3 11.5336 3 10.9583V8.04167C3 7.46637 3.55964 7 4.25 7L6.7619 7.00154C6.43788 6.49607 6.25 5.89498 6.25 5.25C6.25 3.45507 7.70507 2 9.5 2C10.5055 2 11.4044 2.45666 12.0006 3.17391C12.5956 2.45666 13.4945 2 14.5 2ZM9.5 3.5C8.5335 3.5 7.75 4.2835 7.75 5.25C7.75 6.16817 8.45711 6.92119 9.35647 6.9942L9.5 7H11.25V5.25L11.2442 5.10647C11.1712 4.20711 10.4182 3.5 9.5 3.5ZM14.5 3.5C13.5335 3.5 12.75 4.2835 12.75 5.25V7H14.5C15.4665 7 16.25 6.2165 16.25 5.25C16.25 4.2835 15.4665 3.5 14.5 3.5Z" fill="#fff"></path>
                                                        </svg>
                                                    </div>
                                                    <a href="' . $route . '"><img src="' . asset($item['image']) . '" alt="' . $item['title'] . '"></a>
                                                    <div class="heart-cart">
                                                        <a href="javascript:void(0)" class="heart js_add_wishlist" data-id="' . $item['id'] . '">
                                                        <i class="fa ' . $i_class . ' js_add_wishlist_' . $item['id'] . '"></i>
                                                        </a>
                                                        <a href="' . $route . '" class="cart"><i class="icon-cart-empty"></i></a>
                                                    </div>
                                                    
                                                </div>
                                                <div class="nav-img">
                                                    <h3 class="title-3"><a href="' . $route . '">' . $item['title'] . '</a></h3>
                                                    <p class="start">
                                                        <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
                                                        <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
                                                        <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
                                                        <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
                                                        <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
                                                    </p>
                                                    <div class="ps-product__meta">
                                                        <span class="ps-product__price sale">' . $price['price_final'] . '</span>
                                                        <span class="ps-product__del">' . $price['price_old'] . '</span>
                                                    </div>
                                                    
                                                </div>
                                            </div>';
        return $html;
    }
}
if (!function_exists('htmlItemProductList')) {
    function htmlItemProductList($key = '', $item = [], $class = 'item item-product')
    {
        $wishlist = isset($_COOKIE['wishlist']) ? json_decode($_COOKIE['wishlist'], TRUE) : NULL;
        $i_class = 'fa-regular';
        if (!empty($wishlist)) {
            if (in_array($item['id'], $wishlist)) {
                $i_class = 'fa-solid';
            }
        }
        $html = '';
        $price = getPrice(array('price' => $item['price'], 'price_sale' => $item['price_sale'], 'price_contact' =>
        $item['price_contact']));
        $route = route('routerURL', ['slug' => $item['slug']]);

        if (!empty($item['image_json'])) {
            $listAlbums = json_decode($item['image_json'], true);
            if (count($listAlbums) < 2) {
                $listAlbums = [$item['image'], $item['image']];
            }
        } else {
            $listAlbums = [$item['image'], $item['image']];
        }
        // $getTags = $item['getTags'];
        $html .= '<div class="item-product-2">
                                            <div class="img">';
        if (!empty($price['percent'])) {
            $html .= '<span class="smart">-
                                                ' . $price['percent'] . ' 
                                                </span>';
        }
        /*$html .= '<span class="icon-wish js_add_wishlist cursor-pointer" data-id="' . $item['id'] . '">
                                                <svg class="icon ' . $i_class . ' js_add_wishlist_' . $item['id'] . '" xmlns="http://www.w3.org/2000/svg" width="17" height="20" viewBox="0 0 17 20" fill="none">
                                                    <path d="M1.2002 5.8C1.2002 4.11984 1.2002 3.27976 1.52718 2.63803C1.8148 2.07354 2.27374 1.6146 2.83822 1.32698C3.47996 1 4.32004 1 6.0002 1H10.4002C12.0804 1 12.9204 1 13.5622 1.32698C14.1267 1.6146 14.5856 2.07354 14.8732 2.63803C15.2002 3.27976 15.2002 4.11984 15.2002 5.8V19L8.2002 15L1.2002 19V5.8Z" stroke="#00AB6D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </span>'; */
        $html .= '<div class="qua-tang" title="' . $item['title'] . '">
                                                   <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                      <path d="M11.25 13V22H7.25C5.45507 22 4 20.5449 4 18.75V13H11.25ZM20 13V18.75C20 20.5449 18.5449 22 16.75 22H12.75V13H20ZM14.5 2C16.2949 2 17.75 3.45507 17.75 5.25C17.75 5.89498 17.5621 6.49607 17.2381 7.00154L19.75 7C20.4404 7 21 7.46637 21 8.04167V10.9583C21 11.5336 20.4404 12 19.75 12L12.75 11.999V7H11.25V11.999L4.25 12C3.55964 12 3 11.5336 3 10.9583V8.04167C3 7.46637 3.55964 7 4.25 7L6.7619 7.00154C6.43788 6.49607 6.25 5.89498 6.25 5.25C6.25 3.45507 7.70507 2 9.5 2C10.5055 2 11.4044 2.45666 12.0006 3.17391C12.5956 2.45666 13.4945 2 14.5 2ZM9.5 3.5C8.5335 3.5 7.75 4.2835 7.75 5.25C7.75 6.16817 8.45711 6.92119 9.35647 6.9942L9.5 7H11.25V5.25L11.2442 5.10647C11.1712 4.20711 10.4182 3.5 9.5 3.5ZM14.5 3.5C13.5335 3.5 12.75 4.2835 12.75 5.25V7H14.5C15.4665 7 16.25 6.2165 16.25 5.25C16.25 4.2835 15.4665 3.5 14.5 3.5Z" fill="#fff"></path>
                                                   </svg>
                                                </div>
                                                <a href="' . $route . '"><img src="' . asset($item['image']) . '" alt="' . $item['title'] . '"></a>
                                                <div class="heart-cart">
                                                        <a href="" class="heart"><i class="fa fa-heart-o"></i></a>
                                                        <a href="" class="cart"><i class="icon-cart-empty"></i></a>
                                                    </div>
                                             </div>
                                             <div class="nav-img">
                                                <h3 class="title-3"><a href="' . $route . '">' . $item['title'] . '</a></h3>
                                                <p class="start">
                                                   <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
                                                   <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
                                                   <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
                                                   <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
                                                   <a href=""><i class="fa fa-star" aria-hidden="true"></i></a>
                                                </p>
                                                <div class="price-cart">
                                                   <div class="price-i">
                                                      <p class="price">' . $price['price_final'] . '</p>
                                                      <del>' . $price['price_old'] . '</del>
                                                   </div>
                                                  
                                                </div>
                                             </div>
                                        </div>';
        return $html;
    }
}
/**HTML: item sản phẩm */
if (!function_exists('htmlItemCourse')) {
    function htmlItemCourse($item = [], $class = '')
    {
        $html = '';
        $catalogues =  \App\Models\CourseCategory::select('title', 'slug')->whereIn('id', json_decode($item->catalogue))->get();
        $price = getPrice(array('price' => $item['price'], 'price_sale' => $item['price_sale'], 'price_contact' =>
        $item['price_contact']));
        $html .= '<div class="w-full md:w-1/3 px-[10px]">
                                <div class="item border border-gray-200 rounded-[10px] mb-[15px] md:mb-[20px] overflow-hidden">
                                    <div class="img hover-zoom">
                                        <a href="' . $item->slug . '"><img src="' . asset($item->image) . '" alt="' . $item->title . '" class="w-full object-cover" style="height: 210px;"></a>
                                    </div>
                                    <div class="nav-img p-[15px]">';
        if (!empty($catalogues) && count($catalogues) > 0) {
            $html .= '<h4 class="title-category">';
            foreach ($catalogues as $k => $val) {
                if ($k == 0) {
                    $html .= '<a href="' . $val->slug . '" class="text-gray-500 hover:text-primary">' . $val->title . '</a>';
                } else {
                    $html .= '<a href="' . $val->slug . '" class="text-gray-500 hover:text-primary">, ' . $val->title . '</a>';
                }
            }
            $html .= '</h4>';
        }

        $html .= '<h3 class="title-3 bold-1 my-[5px]" style="overflow: hidden;text-overflow: ellipsis;line-height: 23px;-webkit-line-clamp: 2;height: 46px;display: -webkit-box;-webkit-box-orient: vertical;"><a href="' . $item->slug . '">' . $item->title . '</a></h3>
                                        <p class="price text-f16 md:text-f18 bold-1 text-red-700">' . $price['price_final'] . '</p>
                                        <div class="flex flex-wrap justify-between mx-[-5px] mt-[10px]">
                                            <div class="w-1/2 px-[5px]">';
        if (!empty($item->field)) {
            $html .= '<p class="clock text-f15 text-gray-500"><i class="fas fa-clock mr-[5px]"></i>' . $item->field->meta_value . '</p>';
        }
        $html .= '</div>
                                            <div class="w-1/2 px-[5px]">';
        if (!empty($item->course_lessons) && count($item->course_lessons) > 0) {

            $html .= '<p class="book text-f15 text-gray-500"><i class="fa-solid fa-book mr-[5px]"></i>' . count($item->course_lessons) . ' Lessons</p>';
        }
        $html .= '</div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
        return $html;
    }
}
/**HTML: item sản phẩm bán kèm */
if (!function_exists('htmlItemProductUpSell')) {
    function htmlItemProductUpSell($item = [])
    {
        $html = '';
        $price = getPrice(array('price' => $item['price'], 'price_sale' => $item['price_sale'], 'price_contact' => $item['price_contact']));
        $href = route('routerURL', ['slug', $item['slug']]);
        $img = !empty($item['image']) ? $item['image'] : 'images/404.png';
        $title = $item['title'];
        $html .= '<div class="product-item text-center pd-2 mb-6" style="border-bottom: 1px solid #ddd">
                    <div class="box-image">
                        <a href="' . $href . '"><img src="' . $img . '" alt="' . $title . '" height="90" width="90" style="display: inline-block;object-fit: contain"></a>
                    </div>
                    <div class="box-text pt-2 pb-2">
                        <a href="' . $href . '">
                            <h4 class="title-product text-f15">
                                ' . $title . '
                            </h4>
                        </a>
                    </div>
                    <div class="box-price pb-2">
                        <span class="text-red extraPriceFinal text-f16 text-red-600 font-bold">' . $price['price_final'] . '</span>
                        <del class="ml-[5px] extraPriceOld text-f14">' . $price['price_old'] . '</del>
                    </div>
                    <div class="box-action pb-5">
                        <a href="javascript:void(0)" class="addToCartDeals text-f15 text-blue-700">+ Thêm vào giỏ</a>
                    </div>
                </div>';
        return $html;
    }
}
