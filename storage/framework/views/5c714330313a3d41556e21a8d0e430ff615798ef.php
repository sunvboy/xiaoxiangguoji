<?php $__env->startSection('content'); ?>
<?php
$items = !empty($fields['config_colums_json_ht_2']) ? json_decode($fields['config_colums_json_ht_2']) : [];
?>
<div class="main-system-page bg-gray">
    <div class="container">
        <h2 class="title-2">Hệ thống nhà thuốc trên toàn quốc</h2>
        <p class="desc-2">
            <?php echo $page->description; ?>

        </p>
        <div class="content-system-page">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-12">
                    <div class="content-system-left">
                        <h3 class="title-3">Tìm kiếm nhà thuốc</h3>
                        <select name="" id="city">
                            <option value="">Chọn tỉnh thành</option>
                            <?php if(!empty($vn_province)): ?>
                            <?php $__currentLoopData = $vn_province; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>">
                                <?php echo e($item->name); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                        <select name="" id="district">
                            <option value="">Chọn Quận/Huyện </option>
                        </select>
                    </div>
                    <div class="product-suggest">
                        <h3 class="title-3" style="font-weight: bold;">Nhà thuốc gợi ý</h3>
                        <div class="loadHtmlItemAddress">
                            <?php if(!empty($address)): ?>
                            <ul>
                                <?php $__currentLoopData = $address; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <label style="cursor: pointer;">
                                        <input type="radio" value="<?php echo e($item->id); ?>" name="address_id">
                                        <?php echo e($item->title); ?>

                                    </label>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-12">
                    <div class="content-system-right">
                        <div id="loadHtmlAddress">

                        </div>
                        <div class="desc-2">
                            <?php echo !empty($fields['config_colums_editor_ht_1'])?$fields['config_colums_editor_ht_1']:''; ?>

                        </div>
                        <div class="nav-content-system">
                            <div class="row">
                                <?php if(!empty($items->title)): ?>
                                <?php $__currentLoopData = $items->title; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="item">
                                        <div class="icon">
                                            <img src="<?php echo e(!empty($items->image[$key]) ? asset($items->image[$key]):''); ?>" alt="<?php echo e($item); ?>" style="width: 32px;height: 32px">
                                        </div>
                                        <div class="nav-icon">
                                            <h3 class="title-3"><?php echo e($item); ?></h3>
                                            <p class="desc-2"><?php echo e(!empty($items->des[$key]) ? $items->des[$key]:''); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="libary-album">
                            <div class="nav-libary-album">
                                <h3 class="title-3"> <?php echo e($fcSystem['title_11']); ?></h3>

                                <?php if(!empty($address)): ?>
                                    <div class="slider-libary-album owl-carousel">
                                        <?php $__currentLoopData = $address; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!empty($item->image)): ?>
                                    <div class="item">
                                        <img src="<?php echo e(asset($item->image)); ?>" alt="hình ảnh nhà thuốc">
                                    </div>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
<style>
    .css-e30d1v {
        font-size: 18px;
        line-height: 24px;
        font-weight: 600;
    }

    .css-1oqd6bl {
        font-size: 16px;
        line-height: 24px;
        font-weight: 400;
        margin-bottom: 0px;
    }

    .text-gray-7 {
        color: #4a4f63;
    }

    .css-1v577ri {
        font-size: 16px;
        line-height: 24px;
        font-weight: 500;
    }

    .\!text-gray-10 {
        color: #020b27 !important;
    }

    .flex {
        display: flex;
    }

    .items-center {
        align-items: center;
    }

    .bg-\[var\(--gray-500\)\] {
        background-color: #a9b2be;
    }

    .rounded-full {
        border-radius: 9999px;
    }

    .w-\[4px\] {
        width: 4px;
    }

    .h-\[4px\] {
        height: 4px;
    }

    .mx-2 {
        margin-left: .5rem;
        margin-right: .5rem;
    }

    .py-1 {
        padding-top: .25rem;
        padding-bottom: .25rem;
    }

    a.css-1v577ri {
        color: #1250dc;
    }

    .css-1sdho3w {
        display: flex;
        gap: 16px;
        margin: 4px 0px;
    }

    .css-1sdho3w .btn-map {
        background: linear-gradient(315deg, #1250dc 14.64%, #306de4 85.36%);
        border-radius: 42px;
        padding: 12px 24px;
    }

    .css-1sdho3w .btn-map a {
        color: #fff !important;
        text-align: center;
    }

    .css-1l7n2ui {
        font-size: 16px;
        line-height: 24px;
    }

    .css-1sdho3w .btn-advise {
        background: #eaeffa;
        border-radius: 42px;
        padding: 12px 24px;
    }

    .font-bold {
        font-weight: bold;
    }
</style>
<script>
    function loadAlbums() {
        $(".slider-libary-album").owlCarousel({
            loop: false,
            margin: 20,
            navText: [
                '<i class="fa fa-chevron-left"></i>',

                '<i class="fa fa-chevron-right"></i>',
            ],
            nav: true,
            dots: false,
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 2,
                },
                1000: {
                    items: 3,
                },
            },
        });
    }
    $(document).on('click', 'input[name="address_id"]', function(e) {
        var id = $(this).val()
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "<?php echo route('pageF.addressDetail') ?>",
            type: "POST",
            dataType: "JSON",
            data: {
                id: id,
            },
            success: function(data) {
                $('#loadHtmlAddress').html(data.html)
                $('.nav-libary-album').html(data.albums)
                loadAlbums();
            },
            error: function(jqXhr, json, errorThrown) {
                var errors = jqXhr.responseJSON;
            },
        });
    })
    $(document).on("change", "#city", function(e, data) {
        let _this = $(this);
        let param = {
            id: _this.val(),
            type: "city",
            trigger_district: typeof data != "undefined" ? true : false,
            text: "Chọn Quận/Huyện",
            select: "districtid",
        };
        getLocation(param, "#district");
    });
    $(document).on("change", "#district", function(e, data) {
        let _this = $(this);
        var id = _this.val();
        if (id == null) {
            id = districtid;
        }
        let param = {
            id: id,
            type: "district",
            trigger_ward: typeof data != "undefined" ? true : false,
            text: "Chọn Phường/Xã",
            select: "wardid",
        };
        getLocation(param, "#ward");
    });

    function getLocation(param, object) {
        let formURL = "<?php echo route('pageF.addressGetLocation') ?>";
        $.post(
            formURL, {
                param: param,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            function(data) {
                let json = JSON.parse(data);
                if (param.select == "districtid") {
                    if (param.trigger_district == true) {
                        $(object).html(json.html);
                    } else {
                        $(object).html(json.html);
                    }
                }
                $('.loadHtmlItemAddress').html(json.htmlItems)
                $('.nav-libary-album').html(json.albums)
                loadAlbums();
            }
        );
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/page/frontend/address.blade.php ENDPATH**/ ?>