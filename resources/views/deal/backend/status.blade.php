  <?php
  $configStatus  = !empty($active == 'website') ? config('tamphat')['status_web'] : config('tamphat')['status'];
  ?>
  <div class="col-span-1 md:col-span-3" id="listStatus">
    <ul class="flex space-x-2">
      @foreach($configStatus as $key=>$item)
      @if($key <= $detail->status)
        <li data-status="<?php echo $key ?>" class="changeStatus flex-auto flex justify-center items-center font-medium cursor-pointer gd gd<?php echo $detail->status ?>">{{$item}}</li>
        @else
        <li data-status="<?php echo $key ?>" class="changeStatus flex-auto flex justify-center items-center font-medium cursor-pointer gd gd0">{{$item}}</li>
        @endif
        @endforeach
    </ul>
  </div>