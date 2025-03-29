<?php
$list_images_cmt = [];
foreach ($comment_view['listComment'] as $v) {
    if (!empty($v->images)) {
        $tmp_images_cmt = json_decode($v->images, TRUE);
        if (!empty($tmp_images_cmt)) {
            foreach ($tmp_images_cmt as $v) {
                $list_images_cmt[] = $v;
            }
        }
    }
}
?>
<?php
$totalComment = $averagePoint = 0;
if (isset($comment_view) && is_array($comment_view) && count($comment_view)) {
    $averagePoint = round($comment_view['averagePoint']);
    $totalComment = $comment_view['totalComment'];
}
?>
<style>
    .input-group {
        display: flex;
        align-items: center;
    }

    .btn {
        display: inline-flex;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        border-radius: 0.375rem;
        border-width: 1px;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        padding-left: 0.75rem;
        padding-right: 0.75rem;
        font-weight: 500;
        transition-duration: 200ms;
        background-color: #2db2ff;
        height: 44px;
        border: 0px;
        display: flex;
        align-items: center;
        color: #fff;
        border-radius: 4px !important;
    }

    .btn i {
        color: #fff;

    }

    .btn span {
        color: #fff;
        margin-left: 5px
    }

    .input-group-btn {
        margin-bottom: 0px;
        width: 200px;
        position: absolute;
    }

    #my-image,
    #my-image-sub {
        display: none;
    }

    #valueImageAvatar,
    #valueImageAvatarSub {
        cursor: no-drop;
        padding-left: 210px;
        background: transparent;
    }
</style>

<div class="leave-comment">
    <div class="container mx-auto pl-4 pr-4">
        <div class="flex flex-wrap justify-center">
            <div class="w-full md:w-1/2 space-y-10">
                <div class="Express-checkout mt-[40px]">
                    <h2 class="title-primary text-black text-f20 md:text-f35  font-black leading-[30px] md:leading-[50px] relative pb-[10px]">
                        <?php echo $fcSystem['title_6'] ?>
                    </h2>
                    <div class="text-f16 mb-[10px]"><?php echo $fcSystem['title_7'] ?></div>
                    <div class="text-f16 mb-[10px]">
                        <?php echo $fcSystem['title_8'] ?>
                    </div>
                    <form method="post" id="form-comment">
                        <div class="">
                            @include('homepage.common.alert')
                            <div class="mt-5">
                                <div class="grid md:grid-cols-2 md:gap-4 space-y-4 md:space-y-0">
                                    <div class="">
                                        <input name="fullname" placeholder="{{trans('index.Fullname')}} *" class="w-full h-[45px] px-4  bg-white text-f15 border">
                                    </div>
                                    <div class="">
                                        <input name="email" placeholder="Email *" class="w-full h-[45px] px-4  bg-white text-f15 border">
                                    </div>
                                    <div class="md:col-span-2">
                                        <textarea name="message" id="" cols="30" rows="10" class="w-full h-[100px]  bg-white text-f15 border p-4" placeholder="{{trans('index.Message')}} *"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-[10px]">
                                <button id="form-comment-submit" class="font-bold text-white h-[45px] px-[20px] bg-red-600 border border-red hover:text-white hover:bg-red-800 transition-all">{{trans('index.Send')}}</button>
                            </div>
                            <input id="my-image" class="hidden" type="file" name="filepath" onchange="mainThamUrl(this)">
                            <?php /*<div id="hot" class="">
                                <div class="content-right">
                                    <div class="flex-bottom" style="display: flex;justify-content: space-between;">
                                        <!-- upload image -->
                                        <div class="input-group" style="position: relative;grid-template-columns: auto;">
                                            <label for="my-image" class="input-group-btn">
                                                <span class="btn btn-primary">
                                                    <i class="fa fa-picture-o"></i> <span>Upload avatar</span>
                                                </span>
                                            </label>
                                            <input type="text" id="valueImageAvatar" disabled>
                                            <input id="my-image" class="form-control" type="file" name="filepath" onchange="mainThamUrl(this)">
                                        </div>
                                        <!-- end: upload image -->
                                        <input name="submit" type="submit" id="form-comment-submit" class="submit pull-right" value="comment">
                                    </div>
                                </div>
                            </div>*/ ?>
                        </div>
                    </form>
                    <div class="tour-review" style="padding-top:0px">
                        <div class="comment clearfix" style="padding-top:30px" id="getListCommentArticle">
                            @include('article.frontend.article.comment._data')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@push('javascript')
<script>
    /*lấy tên file khi upload ảnh xong*/
    function mainThamUrl(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.img-responsive-result').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#my-image').change(function(e) {
        var fileName = e.target.files[0].name;
        console.log(fileName);
        $('#valueImageAvatar').val(fileName);;
    });
    /*end*/
    /*START: submit comment*/
    $('#form-comment-submit').click(function(e) {
        e.preventDefault();
        var fullname = $('#form-comment input[name="fullname"]').val();
        var email = $('#form-comment input[name="email"]').val();
        var message = $('#form-comment textarea[name="message"]').val();
        var module_id = "{{$detail->id}}";
        var avatar = $("#my-image")[0].files[0];
        let form = new FormData();
        form.append('fullname', fullname);
        form.append('email', email);
        form.append('message', message);
        form.append('module_id', module_id);
        form.append('avatar', avatar);
        $.ajax({
            type: 'POST',
            url: "<?php echo route('commentFrontend.postArticle') ?>",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            cache: false,
            contentType: false,
            processData: false,
            data: form,
            success: function(data) {
                if (data.status == 200) {
                    $("#form-comment .print-error-msg").css('display', 'none');
                    $("#form-comment .print-success-msg").css('display', 'flex');
                    $("#form-comment .print-success-msg span").html("<?php echo $fcSystem['message_3'] ?>");
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    $("#form-comment .print-error-msg").css('display', 'flex');
                    $("#form-comment .print-success-msg").css('display', 'none');
                    $("#form-comment .print-error-msg span").html(data.error);
                }
            }
        });
    });
    /*END: submit comment*/
    /*comment reply*/
    $(document).on('click', '.handleReply', function(e) {
        e.preventDefault();
        let _this = $(this);
        let text = _this.text();
        if (text == "<?php echo trans('index.ReplyNo') ?>") {
            _this.parent().find('.reply-comment').html('');
            _this.html('<i class="fas fa-reply"></i><?php echo trans('index.Reply') ?>');
        } else {
            let param = {
                'parentid': _this.attr('data-id'),
                'name': _this.attr('data-name'),
            };
            let reply = get_comment_html(param);
            $('.reply-comment').html('');
            $('.js_btn_reply').html('<i class="fas fa-reply"></i><?php echo trans('index.Reply') ?>');
            _this.parent().find('.reply-comment').html(reply);
            _this.attr('data-comment', 0);
            _this.html('<?php echo trans('index.ReplyNo') ?>');
        }

    });

    function get_comment_html(param = '') {
        let comment = '';
        comment += '<form method="post" id="form-comment-reply">';
        comment += '<div class="">';
        comment += '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2 print-error-msg " style="display: none">';
        comment += '<strong class="font-bold">ERROR!</strong>';
        comment += '<span class="block sm:inline"></span>';
        comment += '</div>';
        comment += '<div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-2 print-success-msg" style="display: none">';
        comment += '<div class="flex items-center mb-">';
        comment += '<div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">';
        comment += '<path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />';
        comment += '</svg>';
        comment += '</div>';
        comment += '<div>';
        comment += '<span class="font-bold"></span>';
        comment += '</div>';
        comment += '</div>';
        comment += '</div>';
        comment += '<div class="mt-5">';
        comment += '<div class="grid md:grid-cols-2 md:gap-4 space-y-4 md:space-y-0">';
        comment += '<div class="">';
        comment += '<input placeholder="<?php echo trans('index.Fullname') ?> *" class="fullname_reply_cmt w-full h-[45px] px-4  bg-white text-f15 border">';
        comment += '</div>';
        comment += '<div class="">';
        comment += '<input placeholder="Email *" class="email_reply_cmt w-full h-[45px] px-4  bg-white text-f15 border">';
        comment += '</div>';
        comment += '<div class="md:col-span-2">';
        comment += '<textarea cols="30" rows="10" class="message_reply_cmt w-full h-[100px]  bg-white text-f15 border p-4" placeholder="<?php echo trans('index.Message') ?> *"></textarea>';
        comment += '</div>';
        comment += '</div>';
        comment += '</div>';
        comment += '<div class="mt-[10px]">';
        comment += '<button data-parent-id="' + param.parentid + '" class="font-bold text-white h-[45px] px-[20px] bg-red-600 border border-red hover:text-white hover:bg-red-800 transition-all"><?php echo trans('index.Send') ?></button>';
        comment += '</div>';
        comment += '<input id="my-image-sub" class="hidden" type="file" name="filepath" onchange="mainThamUrl(this)">';
        comment += '</div>';
        comment += '</form>';
        return comment;
    }

    $(document).on('change', '#my-image-sub', function(e) {
        var fileName = e.target.files[0].name;
        console.log(fileName);
        $('#valueImageAvatarSub').val('Select file image: ' + fileName);;
    });
    $(document).on('submit', '#form-comment-reply', function(e) {
        e.preventDefault(e);
        var parent_id = $('#form-comment-reply button').attr('data-parent-id');
        let fullname = $('.fullname_reply_cmt').val();
        let email = $('.email_reply_cmt').val();
        let message = $('.message_reply_cmt').val();
        var avatar = $("#my-image-sub")[0].files[0];
        let form = new FormData();
        form.append('parent_id', parent_id);
        form.append('fullname', fullname);
        form.append('email', email);
        form.append('message', message);
        form.append('avatar', avatar);
        $.ajax({
            type: 'POST',
            url: "<?php echo route('commentFrontend.replyCmt') ?>",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            cache: false,
            contentType: false,
            processData: false,
            data: form,
            success: function(data) {
                if (data.status == 200) {
                    $("#form-comment-reply .print-error-msg").css('display', 'none');
                    $("#form-comment-reply .print-success-msg").css('display', 'flex');
                    $("#form-comment-reply .print-success-msg span").html("<?php echo $fcSystem['message_4'] ?>");
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    $("#form-comment-reply .print-error-msg").css('display', 'flex');
                    $("#form-comment-reply .print-success-msg").css('display', 'none');
                    $("#form-comment-reply .print-error-msg span").html(data.error);
                }
            }
        });
        return false;
    });
    /*end*/

    $(document).on('click', '.paginate_cmt a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var sort = 'id';
        get_list_object(page, sort, true);
    });

    function get_list_object(page = 1, sort = 'id', animate = true) {
        setTimeout(function() {
            $.post('<?php echo route('commentFrontend.listCmt') ?>', {
                    page: page,
                    module: 'articles',
                    module_id: '{{$detail->id}}',
                    sort: sort,
                    "_token": $('meta[name="csrf-token"]').attr("content")
                },
                function(data) {
                    $('#getListCommentArticle').html(data);
                    $('.lds-show').addClass('hidden');
                    if (animate === true) {
                        $('html, body').animate({
                            scrollTop: $(".blog-comment").offset().top
                        }, 200);
                    }

                }
            );
        }, 210);
    }
</script>
@endpush