<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<style>
.gall_date { font-size:11px; }
.gall_name { font-size:11px; }
</style>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
					<!-- 게시판 목록 시작 { -->
					<div id="bo_gall" style="width:<?php echo $width; ?>">

						<?php if ($is_category) { ?>
						<nav id="bo_cate">
							<h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
							<ul id="bo_cate_ul">
								<?php echo $category_option ?>
							</ul>
						</nav>
						<?php } ?>


						<!-- 게시판 페이지 정보 및 버튼 시작 { -->
						<div id="bo_btn_top">
							<div id="bo_list_total">
								<span>Total <?php echo number_format($total_count) ?>건</span>
								<?php echo $page ?> 페이지
							</div>

							<?php if ($rss_href || $write_href) { ?>
							<ul class="btn_bo_user">
								<?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01 btn"><i class="fa fa-rss" aria-hidden="true"></i> RSS</a></li><?php } ?>
								<?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin btn"><i class="fa fa-user-circle" aria-hidden="true"></i> 관리자</a></li><?php } ?>
								<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn"><i class="far fa-edit"></i> 글쓰기</a></li><?php } ?>
							</ul>
							<?php } ?>
						</div>
						<!-- } 게시판 페이지 정보 및 버튼 끝 -->

						<form name="fboardlist"  id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
						<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
						<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
						<input type="hidden" name="stx" value="<?php echo $stx ?>">
						<input type="hidden" name="spt" value="<?php echo $spt ?>">
						<input type="hidden" name="sst" value="<?php echo $sst ?>">
						<input type="hidden" name="sod" value="<?php echo $sod ?>">
						<input type="hidden" name="page" value="<?php echo $page ?>">
						<input type="hidden" name="sw" value="">

						<?php if ($is_checkbox) { ?>
						<div id="gall_allchk">
							<label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
							<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
						</div>
						<?php } ?>

					  <section class="wrapper">

									<div class="row">
									<?php for ($i=0; $i<count($list); $i++) {

										if($bo_gallery_cols == "1") {
											$cols = "col-md-12";
										}elseif($bo_gallery_cols == "2"){
											$cols = "col-md-6";
										}elseif($bo_gallery_cols == "3"){
											$cols = "col-md-4";
										}elseif($bo_gallery_cols == "4"){
											$cols = "col-md-3";
										}elseif($bo_gallery_cols == "6"){
											$cols = "col-md-2";
										}else{
											$cols = "col-md-1";
										}

									 ?>
										<div class="col-xs-12 col-sm-6 <?php echo $cols;?> card-position">
											<!-- 체크박스 -->
											<div class="gall_chk">
											<?php if ($is_checkbox) { ?>
											<label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
											<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
											<?php } ?>
											<span class="sound_only">
												<?php
												if ($wr_id == $list[$i]['wr_id'])
													echo "<span class=\"bo_current\">열람중</span>";
												else
													echo $list[$i]['num'];
												 ?>
											</span>
											</div>
											<!-- /체크박스 -->
											<div class="card">
												<a class='img-card' href="<?php echo $list[$i]['href'] ?>">
												<?php
												if ($list[$i]['is_notice']) { // 공지사항  ?>
													<!--span class="is_notice">공지</span-->

												<?php
													// notice
													$thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], false, true);
													if($thumb['src']) {
														$img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" >';
													} else {
														$img_content = '<span class="no_image">no image</span>';
													}
													echo $img_content;
												?>
												<?php } else {
													$thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], false, true);

													if($thumb['src']) {
														$img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" >';
													} else {
														$img_content = '<span class="no_image">no image</span>';
													}
													echo $img_content;
												}
												 ?>
												</a>
												<div class="card-content">
													<h4 class="card-title">
					 
														<?php
														// echo $list[$i]['icon_reply']; 갤러리는 reply 를 사용 안 할 것 같습니다. - 지운아빠 2013-03-04
														if ($is_category && $list[$i]['ca_name']) {
														 ?>
														<a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
														<?php } ?>
														<a href="<?php echo $list[$i]['href'] ?>" class="bo_tit">
															<span style="font-size:16px;"><?php echo $list[$i]['subject'] ?></span>
															<?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only">댓글</span><span class="cnt_cmt">+ <?php echo $list[$i]['wr_comment']; ?></span><span class="sound_only">개</span><?php } ?>
															<?php
															// if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
															// if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }
															if (isset($list[$i]['icon_new'])) echo rtrim($list[$i]['icon_new']);
															if (isset($list[$i]['icon_hot'])) echo rtrim($list[$i]['icon_hot']);
															//if (isset($list[$i]['icon_file'])) echo rtrim($list[$i]['icon_file']);
															//if (isset($list[$i]['icon_link'])) echo rtrim($list[$i]['icon_link']);
															if (isset($list[$i]['icon_secret'])) echo rtrim($list[$i]['icon_secret']);
														  ?>
														  </a>


													</h4>
													<p class="">
														<strong><span class="sound_only">작성자 </span><?php echo $list[$i]['name'] ?></strong>
													</p>
												</div>

												<div class="card-read-more">
												<div class="row card-padding">

													<div class="col-md-7 text-left">
														<span class="sound_only">조회 </span><i class="fa fa-eye" aria-hidden="true"></i> <?php echo "<span class='gall_name' style='margin:2px;'>".$list[$i]['wr_hit']."</span>" ?>
														<?php if ($is_good) { ?><span class="sound_only">추천</span><strong><i class="far fa-thumbs-up"></i> <?php echo $list[$i]['wr_good'] ?></strong><?php } ?>
														<?php if ($is_nogood) { ?><span class="sound_only">비추천</span><strong><i class="far fa-thumbs-down"></i> <?php echo $list[$i]['wr_nogood'] ?></strong><?php } ?>
													</div>
													<div class="col-md-5 text-right">
														<span class="gall_date"><span class="sound_only">작성일 </span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $list[$i]['datetime'] ?></span>
													</div>
												</div>

												</div>
											</div>
										</div>

									
								

									<?php }//for ?>
									</div><!-- //row -->

								 <?php if ($list_href || $is_checkbox || $write_href) { ?>
								<div class="bo_fx">
									<?php if ($list_href || $write_href) { ?>
									<ul class="btn_bo_user">
										<?php if ($is_checkbox) { ?>
										<li><input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_b01"></li>
										<li><input type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="btn btn_b01"></li>
										<li><input type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class="btn btn_b01"></li>
										<?php } ?>
										<?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn_b01 btn">목록</a></li><?php } ?>
										<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn">글쓰기</a></li><?php } ?>
									</ul>
									<?php } ?>
								</div>
								<?php } ?>
								</form>
								 
								   <!-- 게시판 검색 시작 { -->
								<fieldset id="bo_sch">
									<form name="fsearch" method="get">
									<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
									<input type="hidden" name="sca" value="<?php echo $sca ?>">
									<input type="hidden" name="sop" value="and">
									<label for="sfl" class="sound_only">검색대상</label>
									<select name="sfl" id="sfl">
										<option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
										<option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
										<option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
										<option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
										<option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
										<option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
										<option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
									</select>
									<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
									<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="sch_input" size="25" maxlength="20" placeholder="검색어를 입력해주세요">
									<input type="submit" value="검색" class="sch_btn">
									</form>
								</fieldset>
								<!-- } 게시판 검색 끝 --> 
							</section>
						</form>
						 




<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>



<!-- 페이지 -->
<?php echo $write_pages;  ?>
<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == 'copy')
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->


			</div>
		</div><!--/collapse col-->
	</div><!-- /row -->
</div><!-- /container -->
<div class="divide80"></div>


<script>
$(document).ready(function(){
	$('.breadcrumb-wrap').backstretch([
	  "<?php echo G5_THEME_URL?>/img/etc/sub-1.png",
	  "<?php echo G5_THEME_URL?>/img/etc/sub-2.png",
	  "<?php echo G5_THEME_URL?>/img/etc/sub-3.png",
	  "<?php echo G5_THEME_URL?>/img/etc/sub-5.png",
	  "<?php echo G5_THEME_URL?>/img/etc/sub-6.png"
	], {
		fade: 750,
		duration: 4000
	});
});
</script>