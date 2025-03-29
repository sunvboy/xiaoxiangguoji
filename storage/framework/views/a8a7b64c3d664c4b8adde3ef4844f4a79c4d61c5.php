
<?php $__env->startSection('content'); ?>
<main>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('homepage.index')); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">查询运单号</li>
                    </ol>
                </nav>

            </div>
            <div class="col-md-12">
                <form method="GET" class="position-relative w-100">
                    <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" name="keyword" placeholder="请输入运单号" value="<?php echo e(request()->get('keyword')); ?>">
                    <button type="submit" class="btn btn-light py-2 position-absolute top-0 end-0 mt-2 me-2">查询</button>
                </form>
            </div>
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="row">
                    <?php if(!empty($data)): ?>
                    <?php if(!empty($data['data'])): ?>
                    <?php if(!empty($data['data']['rows'])): ?>
                    <?php $__currentLoopData = $data['data']['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="tracking-box col-md-6">
                        <div class="tracking-header">
                            <?php echo e($item['code_cn']); ?>

                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered tracking-table">
                                <tbody>
                                    <tr>
                                        <td> 客户码</td>
                                        <td><?php echo e($item['customer_packaging']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>越南单号</td>
                                        <td class="important"><?php echo e($item['code_vn']); ?></td>
                                    </tr>
                                    <tr>
                                        <td> 包号</td>
                                        <td class="important"><?php echo e($item['code_packaging'] ?? '---'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>中国品名</td>
                                        <td><?php echo e($item['name_cn']); ?> (<?php echo e($item['name_vn']); ?>)</td>
                                    </tr>
                                    <tr>
                                        <td>产品数量</td>
                                        <td><?php echo e($item['quantity']); ?></td>
                                    </tr>
                                    <tr>
                                        <td> 价格</td>
                                        <td><?php echo e(number_format(rand(100000,300000)),0,',','.'); ?> VND</td>
                                    </tr>
                                    <tr>
                                        <td>重量</td>
                                        <td><?php echo e($item['weight']); ?> kg</td>
                                    </tr>
                                    <tr>
                                        <td>数量件</td>
                                        <td><?php echo e($item['quantity_kien']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>备注</td>
                                        <td><?php echo e($item['fullname_new']); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php if(!empty($item['history'])): ?>
                            <!-- Timeline -->
                            <ul class="tracking-timeline">
                                <?php $__currentLoopData = $item['history']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <small><?php echo e($h['time']); ?></small>
                                    <b style="color: <?php echo e($h['color'] ?? '#333'); ?>;"><?php echo e($h['title']); ?></b>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>
</main>
<style>
    .tracking-box {
        border-radius: 4px;
        overflow: hidden;
    }

    .tracking-header {
        background: #000;
        color: #fff;
        padding: 10px 15px;
        font-weight: bold;
        font-size: 16px;
    }

    .tracking-table td {
        padding: 8px;
        vertical-align: middle;
    }

    .tracking-table td:first-child {
        font-weight: bold;
        width: 35%;
        color: #333;
    }

    .tracking-table td:last-child {
        color: #555;
    }

    .tracking-table .important {
        color: red;
        font-weight: bold;
    }

    .tracking-timeline {
        border-left: 2px solid #ccc;
        margin: 15px 0 0 15px;
        padding-left: 15px;
        list-style: none;
        position: relative;
    }

    .tracking-timeline li {
        position: relative;
        margin-bottom: 15px;
    }

    .tracking-timeline li::before {
        content: "";
        position: absolute;
        width: 10px;
        height: 10px;
        background: #3498db;
        border-radius: 50%;
        left: -20px;
        top: 3px;
    }

    .tracking-timeline li b {
        display: block;
        margin-top: 3px;
    }
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/homepage/home/search.blade.php ENDPATH**/ ?>