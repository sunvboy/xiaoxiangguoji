<?php
$lesson = old('lesson');
$chapter = old('chapter');
$chapter_page = [];
if ($errors->any()) {
    $chapter_page = convert_chapter($chapter, $lesson, !empty($detail->id) ? $detail->id : 0);
} else if ($action == 'update') {
    $id = $detail->id;
    $chapter_arr = \App\Models\CourseChapter::where(['course_id' => $detail->id])->with('course_lessons')->get();
    if (!$chapter_arr->isEmpty()) {
        foreach ($chapter_arr as $key => $item) {
            $chapter_page[$key]['id'] = $item->id;
            $chapter_page[$key]['title'] = $item->title;
            $chapter_page[$key]['description'] = $item->description;
            $chapter_page[$key]['count'] = $item->count;
            $chapter_page[$key]['course_id'] = $item->course_id;
            $chapter_page[$key]['lessons'] = $item->course_lessons;
        }
    }
}
?>


<div class=" box p-5 mt-3 space-y-3" id="formCourse">
    <?php if (isset($chapter_page) && is_array($chapter_page) && count($chapter_page)) : ?>
        <?php foreach ($chapter_page as $key => $val) : ?>
            <div class="boxChapter">
                <div class="">
                    <div class="box-header with-border mb-5">
                        <h3 class="box-title font-bold">Phần <span><?php echo ($key + 1) ?></span>:</h3>
                        <input type="text" name="chapter[title][]" class="input_hide form-control mb-2" value="<?php echo $val['title'] ?>" placeholder="Tiêu đề chương Click để sửa">
                        <textarea type="text" name="chapter[description][]" class="form-control" placeholder="Link video" rows="5"><?php echo $val['description'] ?></textarea>
                        <input type="hidden" name="chapter[count][]" class="count" value="<?php echo $val['count'] ?>">
                        <?php if (!empty($val['id'])) { ?>
                            <input type="hidden" name="chapter[id][]" value="<?php echo $val['id'] ?>">
                        <?php } ?>
                    </div>
                    <div class="box-body" style="display: block;">
                        <?php if (!empty($val['lessons'])) : ?>
                            <div class="grid grid-cols-2 gap-5 stock itemCourse">
                                <?php foreach ($val['lessons'] as $k => $item) : ?>
                                    <div class="col-sm-6 itemLesson">

                                        <div class="relative">
                                            <span class="font-bold">Bài <?php echo ($k + 1) ?>:</span>
                                            <?php if (!empty($item['id'])) { ?>
                                                <input type="hidden" name="lesson[id][]" value="<?php echo $item['id'] ?>">
                                            <?php } ?>
                                            <textarea type="text" name="lesson[title][]" class="form-control" placeholder="Tên bài giảng" rows="4"><?php echo $item['title'] ?></textarea>
                                            <textarea type="text" name="lesson[description][]" class="form-control" placeholder="Mô tả" rows="4"><?php echo !empty($item['description']) ? $item['description'] : '' ?></textarea>
                                            <textarea type="text" name="lesson[link][]" class="form-control" placeholder="Link video" rows="10"><?php echo $item['link'] ?></textarea>

                                        </div>
                                        <button type="button" class="btn btnDeleteLesson btn-danger pull-right w-full btn-sm" data-page="1">Xóa bỏ</button>

                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>

                        <div class="item-line item-line text-right flex justify-end my-5">

                            <button type="button" class="btn btnDeleteChapter btn-danger btn-sm" data-number="1">Xóa chương này</button>

                            <button type="button" class="btn btnAddLesson btn-success ml-2 text-white btn-sm" data-page="1">Thêm bài mới cho chương này</button>

                        </div>

                    </div>

                </div>

            </div>

        <?php endforeach ?>

    <?php endif ?>
    <div class="form-group" id="formCourse">
        <div class="item-line text-left">
            <button type="button" class="btn btnAddChapter btn-success text-white" data-number="0" data-page="0">Thêm chương mới</button>
        </div>
    </div>
</div>
<?php $__env->startPush('javascript'); ?>
<script type="text/javascript">
    load_chapter_page();
    /*----------------     Thêm bài giảng         ----------------*/
    function load_chapter(stt = 1, page = 1) {

        item2 = '<div class="boxChapter">';
        item2 = item2 + '<div class="">';
        item2 = item2 + '<div class="box-header with-border slideItem mb-5">';
        item2 = item2 + '<h3 class="box-title font-bold">Phần <span>' + (stt + 1) + '</span>:</h3>';
        item2 = item2 + '<input type="text" name="chapter[title][]" class="input_hide form-control mb-2" value="" placeholder="Tiêu đề chương click để sửa">';
        item2 = item2 + '<textarea type="text" name="chapter[description][]"  class="form-control" placeholder="Mô tả" rows="5"></textarea>';
        item2 = item2 + '<input type="hidden" name="chapter[count][]" class="count" value="1">';
        item2 = item2 + '</div>';

        item2 = item2 + '<div class="box-body" style="display: block;">';

        item2 = item2 + '<div class="grid grid-cols-2 gap-5 itemCourse">';

        item2 = item2 + '<div class="itemLesson">';

        item2 = item2 + '<div class="relative">';

        item2 = item2 + '<span class="font-bold">Bài ' + (page + 1) + ': </span>';

        item2 = item2 + '<textarea type="text" name="lesson[title][]"  class="form-control" placeholder="Tên bài giảng" rows="4"></textarea>';
        item2 = item2 + '<textarea type="text" name="lesson[description][]"  class="form-control" placeholder="Mô tả" rows="4"></textarea>';
        item2 = item2 + '<textarea type="text" name="lesson[link][]"  class="form-control" placeholder="Link video" rows="10"></textarea>';

        item2 = item2 + '</div>';

        item2 = item2 + '<button type="button" class="btn btnDeleteLesson btn-danger pull-right w-full btn-sm" data-number="1">Xóa bỏ</button>';

        item2 = item2 + '</div>';

        item2 = item2 + '</div>';

        item2 = item2 + '<div class="item-line text-right flex justify-end my-5">';

        item2 = item2 + '<button type="button" class="btn btnDeleteChapter btn-danger btn-sm" data-number="' + (stt + 1) + '">Xóa chương này</button>';

        item2 = item2 + '<button type="button" class="btn btnAddLesson btn-success ml-2 text-white btn-sm" data-page="' + (page + 1) + '">Thêm bài mới cho chương này</button>';

        item2 = item2 + '</div>';

        item2 = item2 + '</div>';

        item2 = item2 + '</div>';

        item2 = item2 + '</div>';

        item2 = item2 + '<div class="item-line text-left">';

        item2 = item2 + '<button type="button" class="btn btnAddChapter btn-success text-white" data-number="' + (stt + 1) + '" data-page="' + (page + 1) + '">Thêm chương mới</button>';

        item2 = item2 + '</div>';

        return item2;

    }



    function load_page(page = 1) {

        item3 = '<div class="itemLesson">';

        item3 = item3 + '<div class="relative">';
        item3 = item3 + '<span class="font-bold">Bài ' + (page + 1) + ': </span>';
        <?php if ($action == 'update') { ?>
            <?php if (empty($copy)) { ?>
                item3 = item3 + '<input type="hidden" name="lesson[id][]" value="0">';
            <?php } ?>
        <?php } ?>
        item3 = item3 + '<textarea type="text" name="lesson[title][]"  class="form-control" placeholder="Tên bài giảng" rows="4"></textarea>';
        item3 = item3 + '<textarea type="text" name="lesson[description][]"  class="form-control" placeholder="Mô tả" rows="4"></textarea>';
        item3 = item3 + '<textarea type="text" name="lesson[link][]"  class="form-control" placeholder="Link video" rows="10"></textarea>';

        item3 = item3 + '</div>';

        item3 = item3 + '<button type="button" class="btn btnDeleteLesson btn-danger pull-right w-full btn-sm" data-page="' + (page + 1) + '">Xóa bỏ</button>';

        item3 = item3 + '</div>';

        return item3;

    }



    function load_chapter_page() {

        var i = 1;

        var j = 1;

        $('#formCourse .boxChapter').each(function() {

            var chapt = i++;

            // Đánh số lại các Chapter

            $(this).find('.box-title span').html(chapt);

            $(this).find('.btnDeleteChapter').attr('data-number', chapt);

            $('#formCourse').find('.btnAddChapter').attr('data-number', chapt);

            // Đánh số lại các page

            // var jj = j + 1;

            $(this).find('.itemLesson').each(function() {

                var page = j++;

                $(this).find('.relative span').html('Bài ' + page + ': ');

                $(this).find('.btnDeleteLesson').attr('data-page', page);

                $('#formCourse').find('.btnAddChapter').attr('data-number', chapt);

                $(this).parent().next().find('.btnAddLesson').attr('data-page', page);

                $('#formCourse').find('.btnAddChapter').attr('data-page', page);

            });



        });

    }



    /* Thêm chương tiếp theo */

    $(document).on('click', '.btnAddChapter', function() {

        var chap = parseInt($(this).attr('data-number'));

        var page = parseInt($(this).attr('data-page'));

        var item2 = load_chapter(chap, page);

        $(this).parent().remove();

        $('#formCourse').append(item2);

    });



    /* Xóa chương  */

    $(document).on('click', '.btnDeleteChapter', function() {

        $(this).parent().parent().parent().parent().remove();

        load_chapter_page();

    });



    /* Thêm bài giảng vào chương  */

    $(document).on('click', '.btnAddLesson', function() {

        var page = parseInt($(this).attr('data-page'));

        var count = parseInt($(this).parent().parent().parent().find('.count').val());

        $(this).parent().parent().parent().find('.count').attr('value', (count + 1));

        var item3 = load_page(page);

        $(this).attr('data-page', (page + 1));

        $('.btnAddChapter').attr('data-page', (page + 1));

        $(this).parent().parent().find('.itemCourse').append(item3);

        load_chapter_page();

    });
    /* Xóa bài giảng vào chương  */
    $(document).on('click', '.btnDeleteLesson', function() {

        var count = parseInt($(this).parent().parent().parent().parent().parent().find('.count').val());

        $(this).parent().parent().parent().parent().parent().find('.count').attr('value', (count - 1));

        $(this).parent().remove();

        load_chapter_page();

    });
</script>

<?php $__env->stopPush(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/course/backend/course/course.blade.php ENDPATH**/ ?>