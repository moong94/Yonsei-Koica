<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

add_javascript('<script src="'.G5_THEME_JS_URL.'/unslider.min.js"></script>', 10);
?>
<!-- 상단 시작 { -->
<div id="hd">
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>

    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    }
    ?>

    <div id="hd_wrapper">

        <div id="logo">
            <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_URL ?>/theme/company/img/main_koica_main2.jpg" alt="<?php echo $config['cf_title']; ?>"></a>
        </div>

        <?php include_once(G5_THEME_PATH.'/head.menu.php'); ?>

<!--
        <fieldset id="hd_sch">
            <legend>사이트 내 전체검색</legend>
            <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">
            <input type="hidden" name="sfl" value="wr_subject||wr_content">
            <input type="hidden" name="sop" value="and">
            <label for="sch_stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="stx" id="sch_stx" maxlength="20">
            <input type="submit" id="sch_submit" value="검색">
            </form>

            <script>
            function fsearchbox_submit(f)
            {
                if (f.stx.value.length < 2) {
                    alert("검색어는 두글자 이상 입력하십시오.");
                    f.stx.select();
                    f.stx.focus();
                    return false;
                }

                // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
                var cnt = 0;
                for (var i=0; i<f.stx.value.length; i++) {
                    if (f.stx.value.charAt(i) == ' ')
                        cnt++;
                }

                if (cnt > 1) {
                    alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                    f.stx.select();
                    f.stx.focus();
                    return false;
                }

                return true;
            }
            </script>
        </fieldset>
-->
        <ul id="tnb">
            <?php if ($is_member) {  ?>
            <?php if ($is_admin) {  ?>
            <li class="tnb_adm"><a href="<?php echo G5_ADMIN_URL ?>"><b>관리자</b></a></li>
            <?php }  ?>
            <li><a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a></li>
            <?php } else {  ?>
            <li><a href="<?php echo G5_BBS_URL ?>/login.php" ><b>로그인</b></a></li>
            <?php }  ?>
        </ul>
    </div>



</div>

<!-- } 상단 끝 -->

<!-- 콘텐츠 시작 { -->
<div id="idx_wrapper">
    <!--메인배너-->
    <div id="main_bn">

        <ul class="bn_ul">
            <li class="bn_bg1">
                <div class="bn_wr"><!--
                    <div class="bn_txt">
                        <h2>신뢰와 나눔속에  <br>사랑받는 기업으로</h2>
                        <p>우리의 원대한 도전,<br>새로운 100년이 깨어납니다</p>
                    </div>
                  -->
                </div>
            </li>
            <li class="bn_bg1">
                <div class="bn_wr"><!--
                    <div class="bn_txt">
                        <h2>신뢰와 나눔속에  <br>사랑받는 기업으로</h2>
                        <p>우리의 원대한 도전,<br>새로운 100년이 깨어납니다</p>
                    </div>
                  -->
                </div>
            </li>
            <li class="bn_bg1">
                <div class="bn_wr"><!--
                    <div class="bn_txt">
                        <h2>신뢰와 나눔속에  <br>사랑받는 기업으로</h2>
                        <p>우리의 원대한 도전,<br>새로운 100년이 깨어납니다</p>
                    </div>
                  -->
                </div>
            </li>
            <li class="bn_bg1">
                <div class="bn_wr"><!--
                    <div class="bn_txt">
                        <h2>신뢰와 나눔속에  <br>사랑받는 기업으로</h2>
                        <p>우리의 원대한 도전,<br>새로운 100년이 깨어납니다</p>
                    </div>
                  -->
                </div>
            </li>
        </ul>
        <div class="bn_btn">
            <a href="#" class="unslider-arrow prev">Previous slide</a>
            <a href="#" class="unslider-arrow next">Next slide</a>
        </div>
        <div id="rolling">
            <h2>롤린롤린롤린<br>롤린롤린롤린</h2>

        </div>
    </div>
  

    <!--메인배너-->
    <script>
    $(function() {
        var unslider = $("#main_bn").unslider({
            speed: 700,               //  The speed to animate each slide (in milliseconds)
            delay: 5000,              //  The delay between slide animations (in milliseconds)
            keys: true,               //  Enable keyboard (left, right) arrow shortcuts
            dots: true,               //  Display dot navigation
            fluid: false              //  Support responsive design. May break non-responsive designs
        });

        $('.unslider-arrow').click(function() {
            var fn = this.className.split(' ')[1];

            //  Either do unslider.data('unslider').next() or .prev() depending on the className
            unslider.data('unslider')[fn]();
        });
    });
   </script>

    <div id="idx_container">
        <?php if ((!$bo_table || $w == 's' ) && !defined("_INDEX_")) { ?><div id="container_title"><?php echo $g5['title'] ?></div><?php } ?>
