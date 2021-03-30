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
        <a href="<?php echo get_pretty_url('content', 'company'); ?>">About YONSEI-KOICA</a>
            <a href="<?php echo get_pretty_url('content', 'privacy'); ?>">개인정보처리방침</a>

            <a href="#">오시는길</a>
            <a href="#">사이트맵</a>
        </div>
        <div id="ft_company">
            <p class="ft_info">TEL. 00-000-0000 FAX. 00-000-0000 서울 강남구 강남대로 1 <br>
            대표:홍길동 사업자등록번호:000-00-00000 개인정보관리책임자:홍길동</p>
            <p class="ft_copy">Copyright &copy; <b>소유하신 도메인.</b> All rights reserved.</p>
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
