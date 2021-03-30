<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/index_head.php');
?>
<!--
<ul id="comp_bn">
    <li>
        <button type="button" class="accordion-toggle bubn_btn">BUSINESS 01<span>사업보기</span></button>
        <div class="accordion-content default bubn_img">
            <img src="<?php echo G5_URL ?>/theme/company/img/bu01.jpg" alt="회사설명">
            <div class="bubn_img_ov">
                <h3> BUSINESS 01</h3>
                <p>사업에 관한 간략 설명<br>회사에 대한 간략한 설명</p>
                <a href="#">상세보기</a>
            </div>
        </div>
    </li>
    <li>
        <button type="button" class="accordion-toggle bubn_btn">BUSINESS 02<span>사업보기</span></button>
        <div class="accordion-content  bubn_img">
            <img src="<?php echo G5_URL ?>/theme/company/img/bu01.jpg" alt="회사설명">
            <div class="bubn_img_ov">
                <h3> BUSINESS 02</h3>
                <p>사업에 관한 간략 설명<br>회사에 대한 간략한 설명</p>
                <a href="#">상세보기</a>
            </div>
        </div>
    </li>
    <li>
        <button type="button" class="accordion-toggle bubn_btn">BUSINESS 03<span>사업보기</span></button>
        <div class="accordion-content  bubn_img">
            <img src="<?php echo G5_URL ?>/theme/company/img/bu01.jpg" alt="회사설명">
            <div class="bubn_img_ov">
                <h3> BUSINESS 03</h3>
                <p>사업에 관한 간략 설명<br>회사에 대한 간략한 설명</p>
                <a href="#">상세보기</a>
            </div>
        </div>
    </li>
</ul>
-->
<script type="text/javascript">
  $(document).ready(function($) {
    $("#comp_bn").find(".accordion-toggle").click(function(){
        $(this).next().slideToggle('fast');
        $(".accordion-content").not($(this).next()).slideUp('fast');
    });
  });
</script>

<!--
<ul id="comp_if">
    <li  class="com_bg1">
        <h2>회사소개</h2>
        <p>대한민국 no1 <br>
        오늘을 이끄는 원동력</p>
        <a href="#">회사소개 바로가기</a>
    </li>
    <li  class="com_bg2">
        <h2>사회공헌</h2>
        <p>대한민국 no1 <br>
        오늘을 이끄는 원동력</p>
        <a href="#">회사소개 바로가기</a>
    </li>
    <li class="com_bg3">
        <h2>인재채용</h2>
        <p>대한민국 no1 <br>
        오늘을 이끄는 원동력</p>
        <a href="#">회사소개 바로가기</a>
    </li>
</ul>
-->
<div id="comp_lt">
    <div class="li_notice">
        <?php
        // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
        // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
        // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
        echo latest('theme/basic', 'notice', 4, 18);
        ?>
    </div>
    <div class="lt_about">
      <strong class="lt_title"><a href="  http://gmegm.cafe24.com/bbs/board.php?bo_table=gallery">Timetable</a></strong>
        <ul>

            <li class="no_bd">게시물이 없습니다.</li>
        </ul>

        <div class="lt_more"><a href="  http://gmegm.cafe24.com/bbs/board.php?bo_table=gallery"><span class="sound_only">Timetable</span>더보기</a></div>
    </div>
    <div class="li_gall">
        <?php
        // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
        // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수, 캐시타임, option);
        // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
        $options = array(
            'thumb_width'    => 143, // 썸네일 width
            'thumb_height'   => 89,  // 썸네일 height
            'content_length' => 40   // 간단내용 길이
        );
        echo latest('theme/gallery', 'gallery', 3, 25, 1, $options);
        ?>
    </div>
</div>
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>
