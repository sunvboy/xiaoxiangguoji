  <?php

    use App\Components\Polylang;

    $Polylang = new Polylang();
    $polylang = collect($Polylang->get($module, $detail->id));
    ?>
  <div class="box p-5 pt-3 {{!empty(count(config('language')) < 2) ? 'hidden' : ''}}">
      <div>
          <label class="form-label text-base font-semibold">Languages</label>
      </div>
      <div>
          <p><strong>Select Language</strong></p>
          <div class="flex items-center mt-2">
              <img src="{{asset(config('language')[$detail->alanguage]['image'])}}" class="w-9" alt="language icon">
              <span class="ml-2">{{config('language')[$detail->alanguage]['title']}}</span>
          </div>
      </div>
      <div class="mt-3">
          <input type="text" name="language[{{config('app.locale')}}]" value="{{$detail->id}}" class="hidden">
          <p><strong>Translations</strong></p>
          @foreach(config('language') as $key=>$item)
          @if($key != config('app.locale'))
          @if(!empty($polylang[$key]))
          <?php
            $product  = $Polylang->module($module, $polylang[$key]);
            ?>
          @endif
          <div class="flex items-center mt-2">
              <div class="w-9">
                  <img src="{{asset($item['image'])}}" alt="{{$item['title']}} icon">
                  <input type="text" name="language[{{$key}}]" class="hidden" value="{{!empty($polylang[$key])?$polylang[$key]:''}}">
              </div>
              <div class="flex-1 ml-2 flex items-center relative box-{{$key}}">
                  <div class="hidden">
                      <a href="{{route('products.create')}}">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                          </svg>
                      </a>
                  </div>
                  <input class="form-control w-full js_languageSearch" type="text" value="{{!empty($product->title)?$product->title:''}}" data-language="{{$key}}" data-module="{{$module}}">
                  <ul class="absolute w-full top-full left-0 shadow-sm p-2 bg-white space-y-1 ulDropdown ulDropdown-{{$key}} hidden" style="top:100%;z-index: 99999;">
                  </ul>
              </div>
          </div>
          @endif
          @endforeach
      </div>
  </div>