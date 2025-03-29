<div id="scrollUp" class="hover:bg-[#333] hover:text-white ">
    <img src="{{asset('images/top.png')}}" alt="top">
</div>
<style type="text/css">
    #scrollUp {
        box-shadow: 0 0 15px 0px rgb(50 50 50 / 20%);
        transition: 0.3s;
        position: fixed;
        bottom: 62px;
        right: 10px;
        cursor: pointer;
        z-index: 99999;
        width: 35px;
        height: 35px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $(window).scroll(function() {
            if ($(this).scrollTop() != 0) {
                $("#scrollUp").fadeIn();
            } else {
                $("#scrollUp").fadeOut();
            }
        });
        $("#scrollUp").click(function() {
            $("body,html").animate({
                scrollTop: 0
            }, 800);
        });
    });
</script>