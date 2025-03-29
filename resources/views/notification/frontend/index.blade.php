@extends('homepage.layout.home')
@section('content')
{!!htmlBreadcrumb($seo['meta_title'])!!}
<main class="pb-20">
    <div class="container px-4 mx-auto">
        <div class="mt-4 flex flex-col md:flex-row items-start md:space-x-4">
            @include('customer/frontend/auth/common/sidebar')
            <div class="flex-1 w-full md:w-auto order-1 md:order-2">
                <div class="overflow-x-hidden shadowC rounded-xl">
                    <div class="md:p-6 bg-white ">
                        <h1 class="text-black font-bold text-xl">{{$seo['meta_title']}}</h1>


                        <div class="mt-5 space-y-5">
                            @if(!empty($data))
                            @foreach($data as $item)
                            <a <?php if (!empty($item->QuestionOptionUser)) { ?> href="{{route('quizzes.frontend.answer',['slug' => $item->QuestionOptionUser->quizzes->slug,'id' => $item->question_option_user_id,'notifications' => $item->id])}}" <?php } ?> class="flex space-x-2">
                                <div class="w-16 h-16 bg-primary rounded-lg flex justify-center items-center">
                                    <div class="relative">
                                        @if($item->view == 0)
                                        <span class="absolute top-[-1px] -right-[1px] bg-red-600 rounded-full w-3 h-3"></span>
                                        @endif

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="font-bold">
                                        {{$item->message}}
                                    </div>
                                    <div class="italic text-sm">
                                        {{$item->created_at}}
                                    </div>
                                </div>
                            </a>
                            @endforeach
                            @endif
                        </div>
                        <div class="mt-5">
                            {{$data->links()}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('javascript')
<script>
    $('.menu_item_auth:nth-child(3)').addClass('active');
</script>
@endpush