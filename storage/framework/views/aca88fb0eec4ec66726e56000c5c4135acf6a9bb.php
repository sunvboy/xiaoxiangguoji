<!-- loading -->
<style>
    .lds-ring {
        width: 80px;
        height: 80px;
        position: fixed;
        z-index: 9999;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .lds-ring div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 64px;
        height: 64px;
        margin: 8px;
        border: 8px solid #000;
        border-radius: 50%;
        animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        border-color: #000 transparent transparent transparent;
    }

    .lds-ring div:nth-child(1) {
        animation-delay: -0.45s;
    }

    .lds-ring div:nth-child(2) {
        animation-delay: -0.3s;
    }

    .lds-ring div:nth-child(3) {
        animation-delay: -0.15s;
    }

    @keyframes  lds-ring {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .lds-show {
        width: 100%;
        height: 100vh;
        float: left;
        position: fixed;
        z-index: 999999999999999999999;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #0000004f;
    }
</style>
<div class="d-none lds-show">
    <div class="lds-ring ">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<?php /*<script>
    $(document).ajaxStart(function() {
        $('.lds-show').removeClass('hidden');
    }).ajaxStop(function() {
        $('.lds-show').addClass('hidden');
    });
</script>*/ ?>
<!-- end: loading --><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/homepage/common/loading.blade.php ENDPATH**/ ?>