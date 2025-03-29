<script>
    function loadEndAjax(experience) {
        if (experience) {
            $('.btnStoreQuiz').addClass("disabled");
        } else {
            $('.btnStoreQuiz').removeClass("disabled");
            $("#checkbox-all-quiz").prop("checked", false);
            $('#ajax-delete-quiz').addClass("disabled");
        }
    }
    $(document).on("click", "#checkbox-all-quiz", function() {
        let _this = $(this);
        checkall(_this);
        change_background();
        show_button_remove_all();
    });

    $(document).on("click", ".checkbox-item-quiz", function() {
        let _this = $(this);
        change_background(_this);
        check_item_all(_this);
        show_button_remove_all();
    });

    function checkall(_this) {
        let table = _this.parents("#faq-accordion-1");
        if ($("#checkbox-all-quiz").length) {
            if (table.find("#checkbox-all-quiz").prop("checked")) {
                table.find(".checkbox-item-quiz").prop("checked", true);
            } else {
                table.find(".checkbox-item-quiz").prop("checked", false);
            }
        }
    }

    function check_item_all(_this) {
        let table = _this.parents("#faq-accordion-1");
        if (table.find(".checkbox-item-quiz").length) {
            if (
                table.find(".checkbox-item-quiz:checked").length ==
                table.find(".checkbox-item-quiz").length
            ) {
                table.find("#checkbox-all-quiz").prop("checked", true);
            } else {
                table.find("#checkbox-all-quiz").prop("checked", false);
            }
        }
    }

    function change_background() {
        $(".checkbox-item-quiz").each(function() {
            if ($(this).is(":checked")) {
                $(this).parents("tr").addClass("bg-active");
            } else {
                $(this).parents("tr").removeClass("bg-active");
            }
        });
    }

    function show_button_remove_all() {
        if ($(".checkbox-item-quiz:checked").length) {
            $("#ajax-delete-quiz").removeClass("disabled");
        } else {
            $("#ajax-delete-quiz").addClass("disabled");
        }
    }
    // order quiz
    $(document).on('change', '.order-quiz', function(e) {
        var id = $(this).attr('data-id')
        var order = $(this).val()
        $.ajax({
            type: "POST",
            url: "<?php echo route('quizzes.order') ?>",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: {
                id: id,
                order: order,
            },
            success: function(data) {
                $('#load-quiz').html(data)
            },
        });
    })
    $(document).on('click', '.delete-quiz', function(e) {
        var id = $(this).attr('data-id')
        $.ajax({
            type: "POST",
            url: "<?php echo route('quizzes.ajax.delete') ?>",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            data: {
                id: id,
            },
            success: function(data) {
                $('#load-quiz').html(data.html)
                loadEndAjax(data.experience)

            },
        });
    })
    $(document).on('click', '#ajax-delete-quiz', function(e) {
        var ids = '';
        $(".checkbox-item-quiz").each(function() {
            if ($(this).is(":checked")) {
                ids += $(this).val() + ','
            }
        });
        if (ids.length <= 0) {

            swal({

                    title: "Có vấn đề xảy ra",

                    text: "Bạn phải chọn ít nhất 1 bản ghi để thực hiện chức năng này",

                    type: "error",

                },

                function() {

                    location.reload();

                }

            );

            return false;

        }
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: 'POST',

            url: "<?php echo route('quizzes.ajax.deleteAll') ?>",
            data: {
                ids: ids
            },
            success: function(data) {
                $('#load-quiz').html(data.html)
                loadEndAjax(data.experience)

            }
        });
    })
    // autocomplete
    $(document).on("keyup", "input[name='question']", function(e) {
        e.preventDefault();
        getObjectModal(1)
    });
    $(document).on('keypress', "input[name='question']", function(e) {
        var _this = $(this);
        var key = e.which;
        if (key == 13) {
            e.preventDefault()
            getObjectModal(1)
        }
    })
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getObjectModal(page);
    });

    function getObjectModal(page) {
        var keyword = $("input[name='question']").val();
        if (keyword.length >= 3) {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: "<?php echo route('questions.autocomplete') ?>",
                method: "POST",
                data: {
                    keyword: keyword,
                    page: page,
                },
                success: function(data) {
                    if (data) {
                        $(".ulDropdown").html(data).removeClass("hidden");
                    }
                },
            });
        } else {
            $(".ulDropdown").addClass("hidden");
        }
    }
    //END: autocomplete
    //click add autocomplete
    $(document).on('click', '.js_handleAddAutocomplete', function(e) {
        var id = $(this).attr('data-id')
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "<?php echo route('quizzes.add') ?>",
            method: "POST",
            data: {
                id: id,
            },
            success: function(data) {
                $('#load-quiz').html(data.html)
                loadEndAjax(data.experience)
                $(".ulDropdown").addClass("hidden");

            },
        });
    })
    //tạo đề thi
    $(document).on('click', '.btnStoreQuiz:not(.disabled)', function(e) {
        e.preventDefault()
        var count_experience = $('input[name="count_experience"]').val()
        var count_essay = $('input[name="count_essay"]').val()
        var count_speak = $('input[name="count_speak"]').val()
        var mark_experience = $('input[name="mark_experience"]').val()
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "<?php echo route('quizzes.storeQuiz') ?>",
            method: "POST",
            data: {
                count_experience: count_experience,
                count_essay: count_essay,
                count_speak: count_speak,
                mark_experience: mark_experience,
            },
            success: function(data) {
                if (!data.html) {
                    toastr.error("Không tồn tại danh sách câu hỏi", 'ERROR!')
                } else {

                    $('#load-quiz').html(data.html)
                    loadEndAjax(data.experience)
                }
            },
        });
    })
</script>
<script>
    $('#upload').on('click', function(e) {
        e.preventDefault();
        var score = parseFloat($('input[name="score"]').val())
        var files = $('#file')[0].files;
        var fd = new FormData();
        // Append data 
        fd.append('file', files[0]);
        fd.append('_token', $('meta[name="csrf-token"]').attr("content"));
        $.ajax({
            url: "<?php echo route('quizzes.import') ?>",
            method: 'post',
            data: fd,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {
                toastr.success("Import câu hỏi thành công", 'Successfully!')
                // $('input[name="mark_experience"]').val(score * parseFloat(data.score))
                $('#load-quiz').html(data.html)
            },
        });
    });
</script>
<script type="text/javascript">
    function PlayAudio(id) {
        $('audio').each(function(e) {
            var id = $(this).attr('id');
            document.getElementById(id).pause()
        })
        document.getElementById('song' + id).play()
    }

    function PlayPause(id) {
        $('audio').each(function(e) {
            var id = $(this).attr('id');
            document.getElementById(id).pause()
        })
    }
</script>
<style>
    .scrollBar {
        height: 300px;
        overflow-y: scroll;
    }

    .scrollBar::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.3);
        border-radius: 5px;
        background-color: #F5F5F5;
    }

    .scrollBar::-webkit-scrollbar {
        width: 3px;
        background-color: #F5F5F5;
    }

    .scrollBar::-webkit-scrollbar-thumb {
        border-radius: 5in;
        -webkit-box-shadow: inset 0 0 3px rgba(0, 0, 0, .3);
        background-color: #D62929;
    }
</style><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/quiz/backend/quiz/script.blade.php ENDPATH**/ ?>