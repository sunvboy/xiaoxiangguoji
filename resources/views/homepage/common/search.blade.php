 <div class="popupSearch w-full h-screen fixed top-0 left z-[99999999] hidden" style="background: rgba(0, 0, 0, 0.9);">
     <button class="absolute top-4 right-4 text-white text-f21 w-16 h-16 js_clickPopupSearch">
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
             <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
         </svg>
     </button>
     <div class="container h-screen px-4">
         <form class="flex justify-center items-center lg:w-2/3 mx-auto relative top-1/2" action="{{route('homepage.search')}}">
             <input type="text" name="keyword" class="text-white w-full px-10px h-50px bg-transparent border-b text-base focus:outline-none hover:outline-none outline-none" placeholder="{{trans('index.SearchPlaceholder')}}">
             <button type="submit" class="text-white absolute right-2 top-1/2 -translate-y-1/2 text-[21px]">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                 </svg>
             </button>
         </form>
     </div>
 </div>
 @push('javascript')
 <script>
     $(document).on('click', '.js_clickPopupSearch', function(e) {
         e.preventDefault();
         $('.popupSearch').toggleClass('hidden');
     })
 </script>
 @endpush