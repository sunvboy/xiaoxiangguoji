@extends('dashboard.layout.dashboard')
<!--Start: title SEO -->
@section('title')
<title>Quản trị website</title>
@endsection
<!--END: title SEO -->
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Dashboard",
        "src" => route('admin.dashboard'),
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
<!--Start: add javascript only index.html -->
@section('css-dashboard')
@endsection
<!--END: add javascript only index.html -->
<!-- START: main -->
@section('content')
<div class="content">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-6">
                    <div class=" report-box mt-12 sm:mt-4">
                        <div class="box py-0 xl:py-5 grid grid-cols-4 gap-0 divide-y xl:divide-y-0 divide-x divide-dashed divide-slate-200 dark:divide-white/5">
                            <?php if (in_array('orders', $dropdown)) { ?>
                                <div class="report-box__item py-5 xl:py-0 px-5 ">
                                    <a href="{{route('orders.index')}}" class="report-box__content">
                                        <div class="flex">
                                            <div class="report-box__item__icon text-warning bg-warning/20 border border-warning/20 flex items-center justify-center rounded-full">
                                                <i data-lucide="shopping-bag"></i>
                                            </div>
                                        </div>
                                        <div class="text-2xl font-medium leading-7 mt-6">{{$totalOrder}}</div>
                                        <div class="text-slate-500 mt-1">Đơn hàng</div>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if (in_array('products', $dropdown)) { ?>
                                <div class="report-box__item py-5 xl:py-0 px-5 ">
                                    <a href="{{route('products.index')}}" class="report-box__content">
                                        <div class="flex">
                                            <div class="report-box__item__icon text-warning bg-warning/20 border border-warning/20 flex items-center justify-center rounded-full">
                                                <i data-lucide="shopping-bag"></i>
                                            </div>
                                        </div>
                                        <div class="text-2xl font-medium leading-7 mt-6">{{$totalProduct}}</div>
                                        <div class="text-slate-500 mt-1">Sản phẩm</div>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if (in_array('articles', $dropdown)) { ?>
                                <div class="report-box__item py-5 xl:py-0 px-5 sm:!border-t-0">
                                    <a href="{{route('articles.index')}}" class="report-box__content">
                                        <div class="flex">
                                            <div class="report-box__item__icon text-pending bg-pending/20 border border-pending/20 flex items-center justify-center rounded-full">
                                                <i data-lucide="credit-card"></i>
                                            </div>
                                        </div>
                                        <div class="text-2xl font-medium leading-7 mt-6">{{$totalArticle}}</div>
                                        <div class="text-slate-500 mt-1">Bài viết</div>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if (in_array('contacts', $dropdown)) { ?>
                                <div class="report-box__item py-5 xl:py-0 px-5">
                                    <a href="{{route('contacts.index')}}" class="report-box__content">
                                        <div class="flex">
                                            <div class="report-box__item__icon text-success bg-success/20 border border-success/20 flex items-center justify-center rounded-full">
                                                <i data-lucide="hard-drive"></i>
                                            </div>
                                        </div>
                                        <div class="text-2xl font-medium leading-7 mt-6">{{$totalContact}}</div>
                                        <div class="text-slate-500 mt-1">Liên hệ</div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
                <!-- END: General Report -->
                <!-- BEGIN: Sales Report -->
                @can('orders_index')
                <?php if (in_array('orders', $dropdown)) { ?>
                    <div class="col-span-12">
                        <div class="box p-5">
                            <div class="md:flex items-center">
                                <select class="form-select w-40 md:ml-auto mt-3 md:mt-0 dark:bg-darkmode-600 " id="orderSearch">
                                    <option value="week" selected>7 ngày qua</option>
                                    <option value="month">Tháng này</option>
                                    <option value="month_before">Tháng trước</option>
                                    <option value="year">Năm nay</option>
                                </select>
                            </div>
                            <div class="mt-6">
                                <div class="chartreport">
                                    <figure class="highcharts-figure">
                                        <div id="container"></div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-6">
                        <div class="box p-5">
                            <div class="md:flex items-center">
                                <select class="form-select w-40 md:ml-auto mt-3 md:mt-0 dark:bg-darkmode-600 " id="orderSearchStatus">
                                    <option value="week" selected>7 ngày qua</option>
                                    <option value="month">Tháng này</option>
                                    <option value="month_before">Tháng trước</option>
                                    <option value="year">Năm nay</option>
                                </select>
                            </div>
                            <div class="mt-6">
                                <div class="chartreport">
                                    <figure class="highcharts-figure">
                                        <div id="containerStatus"></div>
                                    </figure>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-6">
                        <div class="box p-5">
                            <div class="md:flex items-center">
                                <select class="form-select w-40 md:ml-auto mt-3 md:mt-0 dark:bg-darkmode-600 " id="orderSearchProduct">
                                    <option value="week" selected>7 ngày qua</option>
                                    <option value="month">Tháng này</option>
                                    <option value="month_before">Tháng trước</option>
                                    <option value="year">Năm nay</option>
                                </select>
                            </div>
                            <div class="mt-6">
                                <div class="chartreport">
                                    <figure class="highcharts-figure">
                                        <div id="containerProduct"></div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
                @endcan
            </div>
        </div>

    </div>
</div>

@endsection
<!-- END: main -->
<!--Start: add javascript only index.html -->
@push('javascript')
<!-- highcharts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/variable-pie.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
    Highcharts.chart('container', {
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: 'Thống kê đơn hàng',
            align: 'left'
        },
        xAxis: [{
            categories: [<?php foreach ($data as $key => $val) { ?> '<?php echo $key ?>', <?php } ?>],
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
            labels: {
                format: '{value}',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            title: {
                text: '',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            }
        }, { // Secondary yAxis
            title: {
                text: '',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            labels: {
                format: '{value}',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            opposite: true
        }],
        tooltip: {
            shared: true
        },
        series: [{
            name: 'Doanh số',
            type: 'column',
            yAxis: 1,
            data: [<?php foreach ($data as $key => $val) { ?><?php echo $val['y'] ?>, <?php } ?>],
            tooltip: {
                valueSuffix: ' đơn hàng'
            }

        }, {
            name: 'Doanh thu bán hàng',
            type: 'spline',
            data: [<?php foreach ($data as $key => $val) { ?><?php echo $val['x'] ?>, <?php } ?>],
            tooltip: {
                valueSuffix: 'đ'
            }
        }]
    });
</script>
<script>
    $(document).on('change', '#orderSearch', function() {
        let value = $(this).val();
        $.ajax({
            type: 'POST',
            url: "<?php echo route('admin.searchOrder') ?>",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                value: value
            },
            success: function(response) {

                const categories = Object.keys(response.data);
                let dataX = [];
                let dataY = [];
                $.each(response.data, function(i, val) {
                    dataX.push(val.x);
                });
                $.each(response.data, function(i, val) {
                    dataY.push(val.y);
                });
                Highcharts.chart('container', {
                    chart: {
                        zoomType: 'xy'
                    },
                    title: {
                        text: 'Thống kê đơn hàng',
                        align: 'left'
                    },
                    xAxis: [{
                        categories: categories,
                        crosshair: true
                    }],
                    yAxis: [{ // Primary yAxis
                        labels: {
                            format: '{value}',
                            style: {
                                color: Highcharts.getOptions().colors[1]
                            }
                        },
                        title: {
                            text: '',
                            style: {
                                color: Highcharts.getOptions().colors[1]
                            }
                        }
                    }, { // Secondary yAxis
                        title: {
                            text: '',
                            style: {
                                color: Highcharts.getOptions().colors[0]
                            }
                        },
                        labels: {
                            format: '{value}',
                            style: {
                                color: Highcharts.getOptions().colors[0]
                            }
                        },
                        opposite: true
                    }],
                    tooltip: {
                        shared: true
                    },
                    series: [{
                        name: 'Doanh số',
                        type: 'column',
                        yAxis: 1,
                        data: dataY,
                        tooltip: {
                            valueSuffix: ' đơn hàng'
                        }

                    }, {
                        name: 'Doanh thu bán hàng',
                        type: 'spline',
                        data: dataX,
                        tooltip: {
                            valueSuffix: 'đ'
                        }
                    }]
                });

            },
            error: function(jqXhr, json, errorThrown) {
                swal({
                    title: "ERROR",
                    text: "Lỗi hiển thị",
                    type: "error"
                });
            },
        });
        return false;
    });
</script>
<!-- Thống kê tình trạng -->
<script>
    Highcharts.chart('containerStatus', {
        chart: {
            type: 'variablepie'
        },
        title: {
            text: 'Tình trạng đơn hàng',
            align: 'left'
        },
        tooltip: {
            headerFormat: '',
            pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
                'Tổng tiền: <b>{point.y}</b><br/>' +
                'Số đơn hàng: <b>{point.z}</b><br/>'
        },
        series: [{
            minPointSize: 10,
            innerSize: '20%',
            zMin: 0,
            name: 'countries',
            data: [{
                    name: 'Chờ xác nhận',
                    y: <?php echo $returnStatus['wait'] ?>,
                    z: <?php echo $returnStatusCount['wait'] ?>
                }
                <?php if ($returnStatusCount['pending'] > 0) { ?>, {
                        name: 'Đang giao',
                        y: <?php echo $returnStatus['pending'] ?>,
                        z: <?php echo $returnStatusCount['pending'] ?>
                    }
                <?php } ?>
                <?php if ($returnStatusCount['completed'] > 0) { ?>, {
                        name: 'Đã giao',
                        y: <?php echo $returnStatus['completed'] ?>,
                        z: <?php echo $returnStatusCount['completed'] ?>
                    }
                    <?php } ?><?php if ($returnStatusCount['canceled'] > 0) { ?>, {
                        name: 'Đã hủy',
                        y: <?php echo $returnStatus['canceled'] ?>,
                        z: <?php echo $returnStatusCount['canceled'] ?>
                    }
                <?php } ?>
                <?php if (!empty($returnStatusCount['returns']) && $returnStatusCount['returns'] > 0) { ?>, {
                        name: 'Trả hàng/Hoàn tiền',
                        y: <?php echo $returnStatus['returns'] ?>,
                        z: <?php echo $returnStatusCount['returns'] ?>
                    }
                <?php } ?>
            ]
        }]
    });
</script>
<script>
    $(document).on('change', '#orderSearchStatus', function() {
        let value = $(this).val();
        $.ajax({
            type: 'POST',
            url: "<?php echo route('admin.searchOrderStatus') ?>",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                value: value
            },
            success: function(response) {
                let returnStatus = response.returnStatus
                let returnStatusCount = response.returnStatusCount
                Highcharts.chart('containerStatus', {
                    chart: {
                        type: 'variablepie'
                    },
                    title: {
                        text: 'Tình trạng đơn hàng',
                        align: 'left'
                    },
                    tooltip: {
                        headerFormat: '',
                        pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
                            'Tổng tiền: <b>{point.y}</b><br/>' +
                            'Số đơn hàng: <b>{point.z}</b><br/>'
                    },
                    series: [{
                        minPointSize: 10,
                        innerSize: '20%',
                        zMin: 0,
                        name: 'countries',
                        data: [{
                            name: 'Chờ xác nhận',
                            y: returnStatus.wait,
                            z: returnStatusCount.wait
                        }, {
                            name: 'Đang giao',
                            y: returnStatus.pending,
                            z: returnStatusCount.pending
                        }, {
                            name: 'Đã giao',
                            y: returnStatus.completed,
                            z: returnStatusCount.completed
                        }, {
                            name: 'Đã hủy',
                            y: returnStatus.canceled,
                            z: returnStatusCount.canceled
                        }, {
                            name: 'Trả hàng/Hoàn tiền',
                            y: returnStatus.returns,
                            z: returnStatusCount.returns
                        }]
                    }]
                });
            },
            error: function(jqXhr, json, errorThrown) {
                swal({
                    title: "ERROR",
                    text: "Lỗi hiển thị",
                    type: "error"
                });
            },
        });
        return false;
    });
</script>
<!--END Thống kê tình trạng -->
<!-- Sản phẩm bán chạy -->
<script>
    Highcharts.chart('containerProduct', {
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Sản phẩm bán chạy',
            align: 'left'
        },
        xAxis: {
            categories: [<?php if (!$topProductPayment->isEmpty()) { ?> <?php foreach ($topProductPayment as $item) { ?> '<?php echo $item->product_title ?>',
                    <?php } ?>
                <?php } ?>
            ],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Số lượng',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' sản phẩm'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Số lượng',
            data: [
                <?php if (!$topProductPayment->isEmpty()) { ?>
                    <?php foreach ($topProductPayment as $key => $item) { ?>
                        <?php echo (int)$item->quantity ?>,

                    <?php } ?>
                <?php } ?>
            ]
        }]
    });
</script>
<script>
    $(document).on('change', '#orderSearchProduct', function() {
        let value = $(this).val();
        $.ajax({
            type: 'POST',
            url: "<?php echo route('admin.searchOrderProduct') ?>",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                value: value
            },
            success: function(response) {
                let dataValue = [];
                let dataTitle = [];
                $.each(response.data, function(i, val) {
                    dataValue.push(parseFloat(val.quantity));
                });
                $.each(response.data, function(i, val) {
                    dataTitle.push(val.product_title);
                });
                Highcharts.chart('containerProduct', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: 'Sản phẩm bán chạy',
                        align: 'left'
                    },
                    xAxis: {
                        categories: dataTitle,
                        title: {
                            text: null
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Số lượng',
                            align: 'high'
                        },
                        labels: {
                            overflow: 'justify'
                        }
                    },
                    tooltip: {
                        valueSuffix: ' sản phẩm'
                    },
                    plotOptions: {
                        bar: {
                            dataLabels: {
                                enabled: true
                            }
                        }
                    },
                    credits: {
                        enabled: false
                    },
                    series: [{
                        name: 'Số lượng',
                        data: dataValue
                    }]
                });
            },
            error: function(jqXhr, json, errorThrown) {
                swal({
                    title: "ERROR",
                    text: "Lỗi hiển thị",
                    type: "error"
                });
            },
        });
        return false;
    });
</script>
<!-- END:Sản phẩm bán chạy -->
<!-- end highcharts -->
<style>
    .highcharts-credits {
        display: none
    }
</style>
@endpush
<!--END: add css only index.html -->