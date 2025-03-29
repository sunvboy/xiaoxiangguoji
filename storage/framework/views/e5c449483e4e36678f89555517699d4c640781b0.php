<?php if(isset($paginator) && $paginator->lastPage() > 1): ?>

<ul class="pagination">

    <?php
    $interval = isset($interval) ? abs(intval($interval)) : 1;
    $from = $paginator->currentPage() - $interval;
    if ($from < 1) {
        $from = 1;
    }

    $to = $paginator->currentPage() + $interval;
    if ($to > $paginator->lastPage()) {
        $to = $paginator->lastPage();
    }
    ?>

    <!-- first/previous -->
    <?php if($paginator->currentPage() > 1): ?>
    <li>
        <a href="<?php echo e($paginator->url(1)); ?>" aria-label="First">
            <i class="fa fa-angle-double-left"></i>
        </a>
    </li>

    <li>
        <a href="<?php echo e($paginator->url($paginator->currentPage() - 1)); ?>" aria-label="Previous">
            <i class="fa fa-angle-left"></i>
        </a>
    </li>
    <?php endif; ?>

    <!-- links -->
    <?php for($i = $from; $i <= $to; $i++): ?> <?php
                                        $isCurrentPage = $paginator->currentPage() == $i;
                                        ?> <li class="<?php echo e($isCurrentPage ? 'active' : ''); ?>">
        <a href="<?php echo e(!$isCurrentPage ? $paginator->url($i) : '#'); ?>">
            <?php echo e($i); ?>

        </a>
        </li>
        <?php endfor; ?>

        <!-- next/last -->
        <?php if($paginator->currentPage() < $paginator->lastPage()): ?>
            <li>
                <a href="<?php echo e($paginator->url($paginator->currentPage() + 1)); ?>" aria-label="Next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </li>

            <li>
                <a href="<?php echo e($paginator->url($paginator->lastpage())); ?>" aria-label="Last">
                    <i class="fa fa-angle-double-right"></i>
                </a>
            </li>
            <?php endif; ?>

</ul>

<?php endif; ?><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/homepage/common/pagination.blade.php ENDPATH**/ ?>