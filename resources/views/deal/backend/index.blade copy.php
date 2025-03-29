@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách các thỏa thuận</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách các thỏa thuận",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<?php
$permissionChecked = collect($deal_views)->where('active', 1);
$permissionCheckedIndex = $permissionChecked->pluck('keyword');
$searchs = [];
if (!empty(request()->get('catalogue_id'))) {
    $searchs[] = $category_products[request()->get('catalogue_id')];
}
if (!empty(request()->get('status'))) {
    $searchs[] = config('tamphat')['status'][request()->get('status')];
}
if (!empty(request()->get('type') != '')) {
    $searchs[] = config('tamphat')['type'][request()->get('type')];
}
if (!empty(request()->get('date_end'))) {
    $searchs[] = request()->get('date_end');
}
if (!empty(request()->get('source_date_start'))) {
    $searchs[] = request()->get('source_date_start');
}
if (!empty(request()->get('source_date_end'))) {
    $searchs[] = request()->get('source_date_end');
}
if (!empty(request()->get('keyword'))) {
    $searchs[] = request()->get('keyword');
}
if (count($_GET) > 1 && !empty($searchs)) {
    $countSearchs = count($searchs);
    $searchs = array_slice($searchs, 0, 3);
    $searchs[] =  !empty($countSearchs - count($searchs) > 0) ? "và thêm " . $countSearchs - count($searchs) : '';
}
?>
<div class="px-4 py-2 space-y-2">
    <div class="">
        <form class="flex space-y-1" autocomplete="off">
            <?php echo Form::select('catalogue_id', $category_products, request()->get('catalogue_id'), ['class' => 'tom-select tom-select-field-category w-full', 'placeholder' => "Chọn danh mục"]); ?>
            <?php echo Form::select('status', config('tamphat')['status'], request()->get('status'), ['class' => 'tom-select tom-select-field-status w-full', 'placeholder' => "Chọn giai đoạn"]); ?>
            <?php echo Form::select('type', config('tamphat')['type'], request()->get('type'), ['class' => 'tom-select tom-select-field-type w-full', 'placeholder' => "Chọn loại giao dịch"]); ?>
            <input type="text" name="date_end" class="form-control" placeholder="NGÀY THANH TOÁN" value="<?php echo request()->get('date_end') ?>" />
            <input type="text" name="source_date_start" class="form-control" placeholder="NGÀY KÍ HĐ" value="<?php echo request()->get('source_date_start') ?>" />
            <input type="text" name="source_date_end" class="form-control" placeholder="NGÀY KẾT THÚC HĐ" value="<?php echo request()->get('source_date_end') ?>" />
            <input type="text" name="keyword" class="form-control" placeholder="Nhập thông tin hồ sơ" value="<?php echo request()->get('keyword') ?>" />
            <div class="flex space-x-2 justify-center">
                <button type="submit" class="text-white bg-primary font-medium rounded-lg text-[13px] w-full sm:w-auto px-5 py-2.5 text-center flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <span>Tìm kiếm</span>
                </button>
            </div>
        </form>
        <div class="grid grid-cols-5 gap-1 mb-2" id="boxDealView" style="display: none;">
            @foreach($deal_views as $val)
            <label for="check{{$val->id}}">
                <input {{!empty($permissionChecked)?($permissionChecked->contains('id',$val->id) ? 'checked' : '') :''}} name="permission_id[]" type="checkbox" class="handle_updateDealView w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" value="{{$val->id}}" id="check{{$val->id}}" />
                {{$val->title}}
            </label>
            @endforeach
        </div>
        <div class="flex justify-between items-center">
            <div class="w-1/2 relative">
                <div class="relative">
                    @if(empty($searchs))
                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 textSearchFilter">Lọc và tìm kiếm</span>
                    @endif
                    <input type="text" id="tag-input1" class="btnSearchFilter" autocomplete="off" placeholder="Lọc và tìm kiếm">
                    <a href="javascript:void(0)" class="absolute top-1/2 right-2 -translate-y-1/2 aHandleHideForm" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </a>
                </div>
                <div class="absolute top-[45px] w-full h-auto p-2 shadow-xl z-[9] bg-white left-0 htmlSearchFilter" style="display: none;">
                    <form class="flex space-y-1 flex-col" autocomplete="off">
                        <?php echo Form::select('catalogue_id', $category_products, request()->get('catalogue_id'), ['class' => 'tom-select tom-select-field-category w-full', 'placeholder' => "Chọn danh mục"]); ?>
                        <?php echo Form::select('status', config('tamphat')['status'], request()->get('status'), ['class' => 'tom-select tom-select-field-status w-full', 'placeholder' => "Chọn giai đoạn"]); ?>
                        <?php echo Form::select('type', config('tamphat')['type'], request()->get('type'), ['class' => 'tom-select tom-select-field-type w-full', 'placeholder' => "Chọn loại giao dịch"]); ?>
                        <input type="text" name="date_end" class="form-control" placeholder="NGÀY THANH TOÁN" value="<?php echo request()->get('date_end') ?>" />
                        <input type="text" name="source_date_start" class="form-control" placeholder="NGÀY KÍ HĐ" value="<?php echo request()->get('source_date_start') ?>" />
                        <input type="text" name="source_date_end" class="form-control" placeholder="NGÀY KẾT THÚC HĐ" value="<?php echo request()->get('source_date_end') ?>" />
                        <input type="text" name="keyword" class="form-control" placeholder="Nhập thông tin hồ sơ" value="<?php echo request()->get('keyword') ?>" />
                        <div class="flex space-x-2 justify-center">
                            <button type="submit" class="text-white bg-primary font-medium rounded-lg text-[13px] w-full sm:w-auto px-5 py-2.5 text-center flex items-center space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                                <span>Tìm kiếm</span>
                            </button>
                            <button type="button" class="text-white bg-gray-400 font-medium rounded-lg text-[13px] w-full sm:w-auto px-5 py-2.5 text-center flex items-center space-x-1">
                                <span>Đặt lại</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="flex flex-1 items-center space-x-2 justify-end">
                <button disabled type="button" class="ajax-delete-all text-white  bg-red-600 font-medium rounded-lg text-[13px] w-full sm:w-auto px-5 py-2.5 text-center ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </button>
                <a href="javascript:void(0)" class="buttonDealViewShow text-white space-x-1 flex items-center bg-blue-600 font-medium rounded-lg text-[13px] w-full sm:w-auto px-5 py-2.5 text-center ">
                    <span>Hiển thị</span>
                </a>
                <a href="javascript:void(0)" style="display: none;" class="buttonDealViewHide text-white space-x-1 flex items-center bg-red-600 font-medium rounded-lg text-[13px] w-full sm:w-auto px-5 py-2.5 text-center ">
                    <span>Đóng</span>
                </a>
                @can('deals_create')
                <a href="{{route('deals.create')}}" class="text-white space-x-1 flex items-center bg-primary font-medium rounded-lg text-[13px] w-full sm:w-auto px-5 py-2.5 text-center ">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tạo</span>
                </a>
                @endcan
            </div>

        </div>
    </div>
    <div id="data_product">
        @include('deal.backend.data',['permissionCheckedIndex' => $permissionCheckedIndex,'data'=>$data])
    </div>
    <div class="lds-dual-ring-container hidden flex w-full h-full fixed top-0 left-0 bg-[#0000008a] !m-0 z-[9999999999999999]">
        <div class="lds-dual-ring "></div>
    </div>

</div>
@endsection
@push('javascript')

<script>
    new TomSelect(".tom-select-field-category", {
        plugins: [{
            remove_button: {
                title: 'Remove this item',
            },

        }],
        persist: false,
        create: true,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
    new TomSelect(".tom-select-field-type", {
        plugins: {
            remove_button: {
                title: 'Remove this item',
            }
        },
        persist: false,
        create: true,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
    new TomSelect(".tom-select-field-status", {
        plugins: {
            remove_button: {
                title: 'Remove this item',
            }
        },
        persist: false,
        create: true,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
</script>
<script type="text/javascript">
    $(function() {
        $('input[name="date_end"]').datetimepicker({
            format: 'd/m/Y',
        });
        $('input[name="source_date_start"]').datetimepicker({
            format: 'd/m/Y',
        });
        $('input[name="source_date_end"]').datetimepicker({
            format: 'd/m/Y',
        });
    });
</script>
<script>
    $(document).on('click', '.js_handleCustomer', function(e) {
        var customer_id = $(this).attr('data-id')
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            beforeSend: function() {
                $('.lds-dual-ring-container').removeClass('hidden')
            },
            complete: function(data) {
                $('.lds-dual-ring-container').addClass('hidden')
            },
            url: "{{route('deals.search')}}",
            type: "POST",
            dataType: "JSON",
            data: {
                customer_id: customer_id,
            },
            success: function(data) {
                $('#data_product').html(data.html);
            }
        });
    })
</script>
<script>
    $(document).on('click', '.handle_updateDealView', function(e) {
        var id = $(this).val();
        var isChecked = $(this).is(":checked");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: '<?php echo route('deals.ajax.updateDealView') ?>',
            type: "POST",
            dataType: "JSON",
            data: {
                id: id,
                isChecked: isChecked
            },
            success: function(data) {
                $('#data_product').html(data.html);
            }
        });
    })
    $(document).on('click', '.buttonDealViewShow', function(e) {
        $(this).hide();
        $('.buttonDealViewHide').show()
        $('#boxDealView').show()
    })
    $(document).on('click', '.buttonDealViewHide', function(e) {
        $(this).hide();
        $('.buttonDealViewShow').show()
        $('#boxDealView').hide()
    })
</script>
<script>
    $(document).on('click', '.tags-input-wrapper', function(e) {
        e.preventDefault()
        $('.htmlSearchFilter').show()
        $('.aHandleHideForm').show()
    })
    $(document).on('click', '.aHandleHideForm', function(e) {
        e.preventDefault()
        $('.htmlSearchFilter').hide()
        $('.aHandleHideForm').hide()
    })
</script>
<script>
    (function() {

        "use strict"


        // Plugin Constructor
        var TagsInput = function(opts) {
            this.options = Object.assign(TagsInput.defaults, opts);
            this.init();
        }

        // Initialize the plugin
        TagsInput.prototype.init = function(opts) {
            this.options = opts ? Object.assign(this.options, opts) : this.options;

            if (this.initialized)
                this.destroy();

            if (!(this.orignal_input = document.getElementById(this.options.selector))) {
                console.error("tags-input couldn't find an element with the specified ID");
                return this;
            }

            this.arr = [];
            this.wrapper = document.createElement('div');
            this.input = document.createElement('input');
            init(this);
            initEvents(this);

            this.initialized = true;
            return this;
        }

        // Add Tags
        TagsInput.prototype.addTag = function(string) {

            if (this.anyErrors(string))
                return;

            this.arr.push(string);
            var tagInput = this;

            var tag = document.createElement('span');
            tag.className = this.options.tagClass;
            tag.innerText = string;

            var closeIcon = document.createElement('a');
            closeIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 text-gray-500"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"></path></svg>';

            // delete the tag when icon is clicked
            closeIcon.addEventListener('click', function(e) {
                e.preventDefault();
                var tag = this.parentNode;

                for (var i = 0; i < tagInput.wrapper.childNodes.length; i++) {
                    if (tagInput.wrapper.childNodes[i] == tag)
                        tagInput.deleteTag(tag, i);
                }
            })


            tag.appendChild(closeIcon);
            this.wrapper.insertBefore(tag, this.input);
            this.orignal_input.value = this.arr.join(',');

            return this;
        }

        // Delete Tags
        TagsInput.prototype.deleteTag = function(tag, i) {
            tag.remove();
            this.arr.splice(i, 1);
            this.orignal_input.value = this.arr.join(',');
            return this;
        }

        // Make sure input string have no error with the plugin
        TagsInput.prototype.anyErrors = function(string) {
            if (this.options.max != null && this.arr.length >= this.options.max) {
                console.log('max tags limit reached');
                return true;
            }

            if (!this.options.duplicate && this.arr.indexOf(string) != -1) {
                console.log('duplicate found " ' + string + ' " ')
                return true;
            }

            return false;
        }

        // Add tags programmatically 
        TagsInput.prototype.addData = function(array) {
            var plugin = this;

            array.forEach(function(string) {
                plugin.addTag(string);
            })
            return this;
        }

        // Get the Input String
        TagsInput.prototype.getInputString = function() {
            return this.arr.join(',');
        }


        // destroy the plugin
        TagsInput.prototype.destroy = function() {
            this.orignal_input.removeAttribute('hidden');

            delete this.orignal_input;
            var self = this;

            Object.keys(this).forEach(function(key) {
                if (self[key] instanceof HTMLElement)
                    self[key].remove();

                if (key != 'options')
                    delete self[key];
            });

            this.initialized = false;
        }

        // Private function to initialize the tag input plugin
        function init(tags) {
            tags.wrapper.append(tags.input);
            tags.wrapper.classList.add(tags.options.wrapperClass);
            tags.orignal_input.setAttribute('hidden', 'true');
            tags.orignal_input.parentNode.insertBefore(tags.wrapper, tags.orignal_input);
        }

        // initialize the Events
        function initEvents(tags) {
            tags.wrapper.addEventListener('click', function() {
                tags.input.focus();
            });


            tags.input.addEventListener('keydown', function(e) {
                var str = tags.input.value.trim();

                if (!!(~[9, 13, 188].indexOf(e.keyCode))) {
                    e.preventDefault();
                    tags.input.value = "";
                    if (str != "")
                        tags.addTag(str);
                }

            });
        }
        // Set All the Default Values
        TagsInput.defaults = {
            selector: '',
            wrapperClass: 'tags-input-wrapper',
            tagClass: 'tag',
            max: null,
            duplicate: false
        }
        window.TagsInput = TagsInput;

    })();

    var tagInput1 = new TagsInput({
        selector: 'tag-input1',
        duplicate: false,
        max: 10
    });
    tagInput1.addData([
        <?php foreach ($searchs as $item) {
            if (!empty($item)) { ?> '<?php echo $item ?>',
            <?php } ?>
        <?php } ?>
    ])
</script>
<style>
    .tags-input-wrapper {
        display: flex;
        overflow: hidden;
        padding-right: 40px;
        padding-top: 3px;
        padding-bottom: 3px;
    }

    .tags-input-wrapper .tag {
        display: inline-block;
        background-color: #bcedfc;
        color: black;
        border-radius: 0.5rem;
        padding: 0px 15px 0px 7px;
        margin-right: 5px;
        display: flex;
        text-overflow: ellipsis;
        line-height: 32px;
        -webkit-line-clamp: 1;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        position: relative;
        flex: auto;
        height: 32px;
    }

    .tags-input-wrapper .tag a {
        display: inline-block;
        cursor: pointer;
        margin-left: 5px;
        position: absolute;
        top: 50%;
        right: 0px;
        transform: translateY(-50%);
        flex: auto;
    }


    .tags-input-wrapper input {
        width: 1px;
        height: 32px;
    }
</style>
<style>
    .lds-dual-ring {
        width: 80px;
        height: 80px;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 999999999999;
    }

    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 64px;
        height: 64px;
        margin: 8px;
        border-radius: 50%;
        border: 6px solid #fff;
        border-color: red transparent red transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }

    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }

    }
</style>
<style>
    .ts-control {
        padding: 0.625rem;
        border-radius: 0.5rem;
    }

    .ts-dropdown [data-selectable] .highlight {
        background: rgba(255, 237, 40, .4) !important;
        border-radius: 1px;
    }

    .ts-wrapper.multi.has-items .ts-control {
        padding: calc(8px - 0px - 0px) 8px calc(8px - 0px - 3px - 0px);
    }
</style>
<!-- <style>
    .container {
        position: relative;
        overflow: hidden;
    }

    .scroll-area {
        overflow-x: auto;
        white-space: nowrap;
        width: 100%;
    }

    .scroll-arrows {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 40px;
        /* Adjust according to your needs */
    }

    .arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        background-color: #ccc;
        text-align: center;
        cursor: pointer;
    }

    .arrow:hover {
        background-color: #aaa;
    }

    .left {
        left: 0;
    }

    .right {
        right: 0;
    }
</style>
<script>
    $(document).ready(function() {
        var tableContainer = $('.table-container');
        var scrollSpeed = 150; // Adjust scroll speed
        var currentScrollLeft = 0; // Initialize currentScrollLeft variable

        // Show/hide scroll arrows on hover
        tableContainer.hover(
            function() {
                var table = $(this).find('table');
                var tableWidth = table.width();
                var containerWidth = tableContainer.width();
                console.log(containerWidth)
                var arrowLeft = $(this).find('.scroll-arrow-left');
                var arrowRight = $(this).find('.scroll-arrow-right');

                if (tableWidth > containerWidth) {
                    arrowLeft.fadeIn();
                    arrowRight.fadeIn();
                }
            },
            function() {
                var arrowLeft = $(this).find('.scroll-arrow-left');
                var arrowRight = $(this).find('.scroll-arrow-right');
                arrowLeft.fadeOut();
                arrowRight.fadeOut();
            }
        );

        // Scroll buttons functionality
        $('.scroll-arrow').hover(
            function() {
                var direction = $(this).data('direction');
                var table = $(this).closest('.table-container').find('table');
                var scrollInterval = setInterval(function() {
                    if (direction === 'left') {
                        currentScrollLeft = Math.max(0, currentScrollLeft - scrollSpeed);
                        var $scrollArea = $(this).closest(".table-container").find(".scroll-area");
                        $scrollArea.animate({
                            scrollLeft: currentScrollLeft
                        }, "slow");
                    } else {
                        currentScrollLeft += scrollSpeed;
                        var $scrollArea = $(this).closest(".table-container").find(".scroll-area");
                        $scrollArea.animate({
                            scrollLeft: currentScrollLeft
                        }, "slow");
                    }
                }, 1000 / 60); // 60 FPS\
                console.log(scrollInterval)
                $(this).data('scrollInterval', scrollInterval);
            },
            function() {
                clearInterval($(this).data('scrollInterval'));
            }
        );
    });

    $(document).ready(function() {
        var scrollSpeed = 50; // Adjust scroll speed
        $('.arrow').hover(
            function() {
                var $scrollArea = $(this).closest(".container").find(".scroll-area");
                var direction = $(this).hasClass("left") ? currentScrollLeft - scrollSpeed : currentScrollLeft += scrollSpeed;;
                $scrollArea.animate({
                    scrollLeft: direction
                }, "slow");
            },
            function() {
                clearInterval($(this).data('scrollInterval'));
                currentScrollLeft = 0; // Reset currentScrollLeft to 0
            }
        );
    });
</script> -->
@endpush