 @if($data)
 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 -mx-[10px]">
     @foreach ($data as $k => $item)
     <?php echo htmlArticle($item) ?>
     @endforeach
 </div>
 <div class="mt-5" style="visibility: visible; animation-name: fadeInUp">
     <?php echo $data->links() ?>
 </div>
 @endif