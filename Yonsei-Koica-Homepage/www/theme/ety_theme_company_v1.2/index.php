<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');
?>
<div class="ety-mt-main"></div>

<!-------------------------- 슬라이드 -------------------------->
<header>
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
	  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
	  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
	  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
	</ol>
	<div class="carousel-inner" role="listbox">
	  <!-- Slide One - Set the background image for this slide in the line below -->
	  <div class="carousel-item active" style="background-image: url('<?php echo G5_THEME_URL?>/img/background02.jpg')">
		<div class="carousel-caption d-none d-md-block">
		  <h3 class="ko1">에티테마 커뮤니티</h3>
		  <p class="ko1 f20">에티테마에 오시면 커뮤니티형, 비즈니스형 두가지 모두 다운로드 하실 수 있습니다.</p>
		</div>
	  </div>
	  <!-- Slide Two - Set the background image for this slide in the line below -->
	  <div class="carousel-item" style="background-image: url('<?php echo G5_THEME_URL?>/img/background05.jpg')">
		<div class="carousel-caption d-none d-md-block">
		  <h3 class="ko1">반응형 비즈니스 테마</h3>
		  <p class="ko1 f20">그누보드5.3 / 5.4 와 연동되어 사용가능한 테마 입니다.</p>
		</div>
	  </div>
	  <!-- Slide Three - Set the background image for this slide in the line below -->
	  <div class="carousel-item" style="background-image: url('<?php echo G5_THEME_URL?>/img/background01.jpg')">
		<div class="carousel-caption d-none d-md-block">
		  <h3 class="ko1">ETY.KR</h3>
		  <p class="ko1 f20">클릭하시면 에티테마 비즈니스 설치법으로 이동 합니다.</p>
		</div>
	  </div>
	</div>
	<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
	  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	  <span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
	  <span class="carousel-control-next-icon" aria-hidden="true"></span>
	  <span class="sr-only">Next</span>
	</a>
  </div>
</header>
<div class="margin-top-80"></div>
<!-------------------------- 아이콘박스 -------------------------->
<div class="container">
	<div class="center-heading">
		<h2>FREE <strong>THEME</strong> </h2>
		<span class="center-line"></span>
		<p class="sub-text margin-bottom-80 ko1 f19">
		무료로 사용가능한 반응형 에티테마는 커뮤니티 테마, 비즈니스 테마로 구분 됩니다.
		</p>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-lg-4">
			<div class="box">							
				<div class="icon">
					<div class="image"><i class="fas fa-apple-alt"></i></div>
					<div class="info">
						<h3 class="title">IOS</h3>
						<p class="ko1 f15">
							애플사의 IOS 부터 안드로이드 운영체제까지 모두 지원되는 무료 비즈니스 반응형 홈페이지 입니다.
							스마트TV, 각종 태블릿등 어떤 기기에도 브라우저가 있으면 표준 및 최적화되어 제작되고 있습니다.
						</p>
						<div class="margin-top-20 margin-bottom-20">
							<button type="button" class="btn btn-secondary btn-sm" onclick="location.href='http://ety.kr/board/qa'">바로가기</button>
						</div>
					</div>
				</div>
				<div class="space"></div>
			</div> 
		</div>
		<div class="col-xs-12 col-sm-6 col-lg-4">
			<div class="box">							
				<div class="icon">
					<div class="image"><i class="fa fa-flag"></i></div>
					<div class="info">
						<h3 class="title">Android</h3>
						<p class="ko1 f15">
							갤럭시 시리즈의 모든 기종에서도 문제 없이 최적화된 사이트로 적용됩니다.
							또한 한개의 도메인으로 PC, MOBILE 까지 모두 적용되므로 마케팅측면으로서 큰 이득이 있습니다.
						</p>
						<div class="margin-top-20 margin-bottom-20">
							<button type="button" class="btn btn-secondary btn-sm" onclick="location.href='http://ety.kr/board/qa'">바로가기</button>
						</div>
					</div>
				</div>
				<div class="space"></div>
			</div> 
		</div>
		<div class="col-xs-12 col-sm-6 col-lg-4">
			<div class="box">							
				<div class="icon">
					<div class="image"><i class="fa fa-desktop"></i></div>
					<div class="info">
						<h3 class="title">Desktop</h3>
						<p class="ko1 f15">
							현재 에티테마 에서 배포중인 무료 비즈니스 반응형 홈페이지의 경우 질문답변 게시판에서 서포트를 해드리고 있습니다. 문의사항은 질문게시판에 글 남겨주세요.
						</p>
						<div class="margin-top-20 margin-bottom-20">
							<button type="button" class="btn btn-secondary btn-sm" onclick="location.href='http://ety.kr/board/qa'">바로가기</button>
						</div>
					</div>
				</div>
				<div class="space"></div>
			</div> 
		</div>		    
	</div><!-- /row -->
	<!-- LATEST : basic_company -->
	<?php echo latest('theme/basic_company', 'free', 3, 13); ?>


</div><!-- /container -->
<!-------------------------- 비즈니스안내 -------------------------->
<div class="py-5 margin-top-80" style="background:#f2f2f2;">
	<div class="container">
		<div class="center-heading margin-top-40">
			<h2>USE A <strong>LIBRARY</strong> </h2>
			<span class="center-line"></span>
		</div>

	  <!-- Features Section -->
	  <div class="row margin-top-50 margin-bottom-50">

		<div class="col-lg-5">
		  <h2>JavaScript Library</h2>
		  <p class="ko_17">테마폴더내 라이선스 문서 확인</p>
		  <ul>
		  	<li><strong>GNUboard5</strong></li>
			<li><strong>Bootstrap4</strong></li>
			<li>jQuery</li>
			<li>Font Awesome5</li>
			<li>Working contact form with validation</li>
			<li>Unstyled page elements for easy customization</li>
			<li>Parallax</li>
			<li>Owl</li>
			
		  </ul>
		  <p class="ko_16">
		  현제 제작되는 모든 테마 및 템플릿은 글로벌하게 <strong><a href="http://ety.kr" target="_blank">에티테마</a></strong> 에서 제작되고 있으며 무료 테마 및 템플릿의 경우에는 이미지가 포함 되어 있지 않습니다. 또한 <strong><a href="http://ety.kr" target="_blank">에티테마</a></strong>로 오시면 추가적인 업데이트된 파일을 다운로드 하실 수 있습니다.</p>
		</div>
		<div class="col-lg-7">
			<img class="img-fluid rounded" src="http://placehold.it/635x515" alt="">
			<!--<img class="img-fluid rounded" src="http://placehold.it/570x400" alt="">-->
		</div>
	  </div>
	  <!-- /.row -->
	</div>
</div>

<!-------------------------- 회사소개 및 안내 -------------------------->
<div class="container margin-top-80 margin-bottom-80">
	<h3 class="margin-bottom-50 text-left">PRODUCT</h3>
	<!-- LATEST : pic_basic_company -->
	<?php echo latest('theme/pic_basic_company', 'gallery', 9, 24); ?>
</div>

<!-------------------------- parallax 박스 및 countdown -------------------------->
<div class="parallax-window" data-parallax="scroll">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center p-center para-text">
				<h2 class='text-light'>반응형 커뮤니티 , 반응형 비즈니스 에티테마 바로가기</h2>
				<button type="button" class="btn btn-outline-light" onclick='window.open("about:blank").location.href="http://ety.kr"'>바로가기</button>
			</div>
		</div>
	</div>
</div><!-- /parallax -->

<!-------------------------- 클라이언트 -------------------------->
<div class="container margin-top-50 margin-bottom-50">
	<h3 class="margin-bottom-50 text-left">GALLERY</h3>
	<?php echo latest('theme/pic_basic_owl', 'gallery', 12, 24); ?>
</div>

<!-------------------------- CALL ACTION -------------------------->
<div class="callbox">
	<div class="container margin-top-20">
	<h3 class="margin-bottom-50 text-left ko1">ETY DEMO</h3>
	  <div class="row">
		<div class="col-md-8">
		  <p class="ko_17">
		  에티테마에 대한 궁금증이나 질문이 있으시면 에티테마의 질문게시판을 이용해주세요.<BR />
		  http://ety.kr/board/qa
		  </p>
		</div>
		<div class="col-md-4">
		  <a class="btn btn-lg btn-secondary btn-block" href="http://ety.kr/board/qa" target="_blank">GO!</a>
		</div>
	  </div>
	</div>
</div>
<!-- /.container -->




<?php
include_once(G5_THEME_PATH.'/tail.php');
?>