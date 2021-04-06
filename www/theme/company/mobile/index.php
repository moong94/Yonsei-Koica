<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_MOBILE_PATH.'/head.php');
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_JS_URL.'/swiper.min.css">', 0);
add_javascript('<script src="'.G5_THEME_JS_URL.'/swiper.min.js"></script>', 10);

?>

<!--메인이미지-->
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide"><!--
            <div class="bn_txt">
                <h2>신뢰와 나눔속에  <br>사랑받는 기업으로</h2>
                <p>우리의 원대한 도전,<br>새로운 100년이 깨어납니다</p>
            </div>
          -->
        </div>
        <div class="swiper-slide"><!--
            <div class="bn_txt">
                <h2>신뢰와 나눔속에  <br>사랑받는 기업으로</h2>
                <p>우리의 원대한 도전,<br>새로운 100년이 깨어납니다</p>
            </div>
          -->
        </div>
        <div class="swiper-slide"><!--
            <div class="bn_txt">
                <h2>신뢰와 나눔속에  <br>사랑받는 기업으로</h2>
                <p>우리의 원대한 도전,<br>새로운 100년이 깨어납니다</p>
            </div>
          -->
        </div>
        <div class="swiper-slide"><!--
            <div class="bn_txt">
                <h2>신뢰와 나눔속에  <br>사랑받는 기업으로</h2>
                <p>우리의 원대한 도전,<br>새로운 100년이 깨어납니다</p>
            </div>
          -->
        </div>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
    <div id="rolling">
        <h2>롤린롤린롤린<br>롤린롤린롤린</h2>

    </div>
</div>


<script>
var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    paginationClickable: true
});
</script>

<!--메인이미지
<ul id="comp_if">
    <li  class="com_bg1">
        <a href="#"><img src="<?php echo G5_THEME_IMG_URL ?>/mobile/main_img1.jpg" alt="회사소개 바로가기"></a>
        <h2>회사소개</h2>
        <p>대한민국 no1 <br>
        오늘을 이끄는 원동력</p>

    </li>
    <li  class="com_bg2">
        <a href="#"><img src="<?php echo G5_THEME_IMG_URL ?>/mobile/main_img2.jpg" alt="사회공헌 바로가기"></a>
        <h2>사회공헌</h2>
        <p>대한민국 no1 <br>
        오늘을 이끄는 원동력</p>
    </li>
    <li class="com_bg3">
        <a href="#"><img src="<?php echo G5_THEME_IMG_URL ?>/mobile/main_img3.jpg" alt="인재채용 바로가기"></a>
        <h2>인재채용</h2>
        <p>대한민국 no1 <br>
        오늘을 이끄는 원동력</p>
    </li>
</ul>
-->





<!-- 메인화면 최신글 시작 -->

<?php
// 이 함수가 바로 최신글을 추출하는 역할을 합니다.
// 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
// 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
echo latest('theme/basic', 'notice', 4, 40);
?>
<div class="li_gall">
    <?php
    // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
    // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수, 캐시타임, option);
    // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
    $options = array(
        'thumb_width'    => 400, // 썸네일 width
        'thumb_height'   => 250,  // 썸네일 height
    );
    echo latest('theme/gallery', 'gallery', 4, 55, 1, $options);
    ?>
</div>

<!-- 메인화면 최신글 끝 -->

<?php
include_once(G5_THEME_MOBILE_PATH.'/tail.php');
?>
