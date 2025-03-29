@if (isset($paginator) && $paginator->lastPage() > 1)

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
    @if($paginator->currentPage() > 1)
    <li>
        <a href="{{ $paginator->url(1) }}" aria-label="First">
            <i class="fa fa-angle-double-left"></i>
        </a>
    </li>

    <li>
        <a href="{{ $paginator->url($paginator->currentPage() - 1) }}" aria-label="Previous">
            <i class="fa fa-angle-left"></i>
        </a>
    </li>
    @endif

    <!-- links -->
    @for($i = $from; $i <= $to; $i++) <?php
                                        $isCurrentPage = $paginator->currentPage() == $i;
                                        ?> <li class="{{ $isCurrentPage ? 'active' : '' }}">
        <a href="{{ !$isCurrentPage ? $paginator->url($i) : '#' }}">
            {{ $i }}
        </a>
        </li>
        @endfor

        <!-- next/last -->
        @if($paginator->currentPage() < $paginator->lastPage())
            <li>
                <a href="{{ $paginator->url($paginator->currentPage() + 1) }}" aria-label="Next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </li>

            <li>
                <a href="{{ $paginator->url($paginator->lastpage()) }}" aria-label="Last">
                    <i class="fa fa-angle-double-right"></i>
                </a>
            </li>
            @endif

</ul>

@endif