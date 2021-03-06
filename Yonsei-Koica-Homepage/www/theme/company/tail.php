<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}
?>
        <a href="#hd" id="top_btn">상단으로</a>
    </div>
</div>


<!-- } 콘텐츠 끝 -->

<!-- 하단 시작 { -->

<div id="ft">
    <div id="ft_wr">

        <div id="ft_copy">
        <a href="<?php echo get_pretty_url('content', 'Welcome'); ?>">About YONSEI-KOICA</a>
          <a href="<?php echo get_pretty_url('content', 'campus_map'); ?>">To visit our office</a>
            <a href="https://www.yonsei.ac.kr/sc/etc/privacy.jsp"target="_blank">개인정보처리방침</a>

            <a href="https://www.yonsei.ac.kr/sc/etc/legal.jsp" target="_blank">법적고지</a>
        </div>
        <div id="ft_company">
            <p class="ft_info">Tel: +82-2-2123-2954 &nbsp;&nbsp;&nbsp;Fax:+82-2-2123-8118 <br>Address: Yonhee Hall 315-2, 50 Yonsei-ro
,Seodaemun-gu, Seoul, 03722,Republic of Korea <br>
          Email: yupa.gmegm@gmail.com</p>
            <p class="ft_copy">Copyright &copy; <b>gmegm.yonsei.ac.kr</b> All rights reserved.</p>
        </div>
    </div>
</div>

<script>
$(function() {
    $("#top_btn").on("click", function() {
        $("html, body").animate({scrollTop:0}, '500');
        return false;
    });
});
</script>

<?php
if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>
<div id="ft_dv">
<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?><a href="<?php echo get_device_change_url(); ?>" id="device_change">모바일 버전으로 보기</a>
</a>
<?php
}

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>
</div>
<!-- } 하단 끝 -->

<?php
include_once(G5_THEME_PATH."/tail.sub.php");
?>
