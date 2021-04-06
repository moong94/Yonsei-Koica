<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
    </div>
</div>

<div id="ft">
    <div id="ft_copy">
        <div id="ft_company">
            <a href="<?php echo get_pretty_url('content', 'company'); ?>">회사소개</a>
            <a href="<?php echo get_pretty_url('content', 'privacy'); ?>">개인정보처리방침</a>
            <a href="<?php echo get_pretty_url('content', 'provision'); ?>">서비스이용약관</a>
        </div>

        <p class="ft_info">TEL. 00-000-0000 FAX. 00-000-0000 <br>서울 강남구 강남대로 1 <br>
        대표:홍길동 사업자등록번호:000-00-00000 <br>개인정보관리책임자:홍길동</p>
        <p class="copyright">Copyright &copy; <b>소유하신 도메인.</b> All rights reserved.</p>

        <a href="#" class="top_btn">상단으로</a>
    </div>
    <?php
    if(G5_DEVICE_BUTTON_DISPLAY && G5_IS_MOBILE) { ?>
    <a href="<?php echo get_device_change_url(); ?>" id="device_change">PC 버전으로 보기</a>
    <?php
    }
    if ($config['cf_analytics']) {
        echo $config['cf_analytics'];
    }
    ?>
</div>

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_THEME_PATH."/tail.sub.php");
?>