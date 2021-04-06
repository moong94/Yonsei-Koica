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
      <?php
    // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
    // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수, 캐시타임, option);
    // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
    $options = array(
        'thumb_width'    => 143, // 썸네일 width
        'thumb_height'   => 89,  // 썸네일 height
        'content_length' => 40   // 간단내용 길이
    );
    echo latest('theme/basic', 'thesis', 4, 25, 1, $options);
    ?>

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
<!--
<div id="link_bar">
  <div class="quick_menu1">
    <img src="/theme/company/img/quick_link/degreeprogram.png" alt="degreeprogram">
  </div>
  <div class="quick_menu2">
	 <img src="/theme/company/img/quick_link/supports2.png" alt="supports">
  </div>
  <div class="quick_menu3">
  	 <img src="/theme/company/img/quick_link/contactus.png" alt="contactus">
  </div>
</div>
 -->

<table style="margin: 31px 22px;" width=100% border="0">
  <tr><td><a href="http://gmegm.cafe24.com/bbs/content.php?co_id=mastersdegree"><img src="/theme/company/img/quick_link/degreeprogram.png" alt="degreeprogram"></td>

<td><a href="http://gmegm.cafe24.com/bbs/content.php?co_id=supports"><img src="/theme/company/img/quick_link/supports2.png" alt="supports"></td>
<td><a href="http://gmegm.cafe24.com/bbs/content.php?co_id=info"><img src="/theme/company/img/quick_link/contactus.png" alt="contactus"></td>

</tr>


</table>
<!-- <div id="mou_icon">
  <!-- <a href="https://www.yonsei.ac.kr/" target="_blank"><img src="/theme/company/img/mou/yonsei.jpg" style="width:230px;height:80px;margin-right:80px"></a>
  <a href="https://yupa.yonsei.ac.kr/" target="_blank"><img src="/theme/company/img/mou/yonsei_administration.jpg" style="width:230px;height:80px;margin-right:80px"></a>
  <a href="http://koica.go.kr/sites/koica_en/index.do" target="_blank"><img src="/theme/company/img/mou/koica.jpg" style="height:80px;width:230px;margin-right:80px"></a>
  <a href="http://www.futuregov.re.kr/" target="_blank"><img src="/theme/company/img/mou/future.jpg" style="height:80px;width:230px;margin-right:80px"></a>
  <a href="http://bk21yupa.yonsei.ac.kr/" target="_blank"><img src="/theme/company/img/mou/bk.jpg" style="height:80px;width:230px"></a>

</div> -->

<html lang="en">
    <head>
    <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="../css/lightslider.css">

    <style>
    	ul{
			list-style: none outside none;
		    padding-left: 0;
            margin: 0;

		}
        .demo .item{
            margin-bottom: 60px;
        }
		.content-slider li{
		    background-color: #FFFFFF;
		    text-align: center;
		    color: #FFF;
          padding-bottom: 0.5%;
		}
      .content-slider li img {
       max-width= 100%;

      }
		.content-slider h3 {
		    margin: 0;
		    padding: 70px 0;

		}
		.demo{
			width: 800px;

		}
    </style>

      <script type="text/javascript" src="../js/lightslider.js"></script>
    <script>
    	 $(document).ready(function() {
			$("#content-slider").lightSlider({
				auto:true,
				speed:500,
                loop:true,
                  item: 5,
                vThumbWidth: 100,
                keyPress:false

            });

		});
    </script>


</head>

        <div class="item">
            <ul id="content-slider" class="content-slider">
                <li>
                  <a href="https://www.yonsei.ac.kr/" target="_blank"><img src="/theme/company/img/mou/yonsei.jpg" width=60% height=40% alt=""/></a>

                </li>
                <li>
                  <a href="https://yupa.yonsei.ac.kr/" target="_blank"><img src="/theme/company/img/mou/yonsei_administration.jpg" width=60% height=40% alt=""/></a>
                </li>
                <li>
                  <a href="http://koica.go.kr/sites/koica_en/index.do" target="_blank"><img src="/theme/company/img/mou/koica.jpg" width=50% height=40% alt=""/></a>
                </li>
                <li>
                  <a href="http://www.futuregov.re.kr/" target="_blank"> <img src="/theme/company/img/mou/future.jpg" width=80% height=40% alt=""/></a>
                </li>
                <li>h
                  <a href="http://bk21yupa.yonsei.ac.kr/" target="_blank"><img src="/theme/company/img/mou/bk.jpg" width=40% height=30% alt=""/></a>
                </li>


              </ul>
          </div>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>
