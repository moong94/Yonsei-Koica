<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}
?>


<?php if($bo_table) {?>
        </div>
      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->
<?php }?>

    <footer class="py-5 bg-dark">
		<div class="container footer">
			<div class="row">
				<div class="col-md-3 text-white text-left">
					<h2>ETY.KR</h2><!-- image or text  -->
					<p>
					무료테마배포 <a href="http://ety.kr" target="_blank">에티테마</a>
					</p>
					<p class="text-center">
						<div class="sns_icon">
						<a href="https://www.youtube.com/channel/UC8dWZEBrCxXbAZKmgrHhtQw" target="_blank"><i class="fab fa-facebook-f"></i></a>
						</div>
						<div class="sns_icon">
						<a href="https://www.youtube.com/channel/UC8dWZEBrCxXbAZKmgrHhtQw" target="_blank"><i class="fab fa-twitter"></i></a>
						</div>
						<div class="sns_icon">
						<a href="https://www.youtube.com/channel/UC8dWZEBrCxXbAZKmgrHhtQw"><i class="fab fa-instagram"></i></a>
						</div>
					</p>
				</div>
				<div class="col-md-3 text-white text-left">
					
					<ul>
						<li><a href="<?php echo G5_THEME_URL?>/about.php">ABOUT</a></li>
						<li><a href="<?php echo G5_THEME_URL?>/service.php">SERVICE</a></li>
						<li><a href="<?php echo G5_THEME_URL?>/product.php">PRODUCE</a></li>
						<li><a href="<?php echo G5_URL?>/bbs/board.php?bo_table=gallery">PORTFOLIO</a></li>
						<li><a href="<?php echo G5_THEME_URL?>/about.php">CUSTOM</a></li>
					</ul>
				</div>
				<div class="col-md-3 text-white text-left">
					
					<ul>
						<li><a href="<?php echo G5_URL?>/bbs/board.php?bo_table=notice">NOTICE</a></li>
						<li><a href="<?php echo G5_URL?>/bbs/board.php?bo_table=free">FREE</a></li>
						<li><a href="<?php echo G5_URL?>/bbs/board.php?bo_table=gallery">GALLERY</a></li>
					</ul>
				</div>
				<div class="col-md-3 text-white text-left">
					<p>
						<i class="far fa-building"></i> 사무실 : 경기도 아름다운 아파트 101동 1004호<br />
						<i class="fas fa-phone"></i> 연락처 : 010-5879-1459 , <i class="far fa-envelope-open"></i> <a href="mailto:softzonecokr@naver.com">Email : SOFTZONECOKR@NAVER.COM</a><br />
						<i class="fas fa-fax"></i> 팩스번호 : 02) 1234-1234<br />
					</p>

				</div>
			</div>
		</div><!--/container-->
    </footer>
	<div class="container-fluid bg-gray">
		<div class="col-md-12 text-white text-center">
				Copyright 2019 &copy; <a href="http://ety.kr" target="_blank">HTTP://ety.kr</a>
		</div>
	</div><!-- /container -->


    <!-- Bootstrap core JavaScript -->
    <!--<script src="vendor/jquery/jquery.min.js"></script>-->
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script>
	var jQuery = $.noConflict(true);
	</script>
    <script src="<?php echo G5_THEME_URL?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo G5_THEME_URL?>/assets/parallax/js/parallax.min.js"></script>
	<script src="<?php echo G5_THEME_URL?>/assets/owlcarousel/js/owl.carousel.min.js"></script>
	<!-- countdown -->
	<script type="text/javascript" src="<?php echo G5_THEME_URL?>/assets/countdown/js/kinetic.js"></script>
	<script type="text/javascript" src="<?php echo G5_THEME_URL?>/assets/countdown/js/jquery.final-countdown.js"></script>
	<script type="text/javascript" src="<?php echo G5_THEME_URL?>/js/bootstrap-dropdownhover.js"></script>
	<script type="text/javascript" src="<?php echo G5_THEME_URL?>/js/custom.js"></script>
	<script>
		jQuery('.parallax-window').parallax({imageSrc: 'http://placehold.it/1920x1280'});
	</script>
	<script>
		$(document).ready(function () {
			//owl
			jQuery(".owl-carousel").owlCarousel({
				loop:true,
				margin:3,
				nav:false,
				responsive:{
					0:{
						items:2
					},
					600:{
						items:3
					},
					1000:{
						items:6
					}
				}
			});

			// countdown
			'use strict';			
			jQuery('.countdown').final_countdown({
				'start': 1362139200,
				'end': 1388461320,
				'now': 1387461319        
			});
		});
	</script>


<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
<?php
}

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<!-- } 하단 끝 -->

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_THEME_PATH."/tail.sub.php");
?>