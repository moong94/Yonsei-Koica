<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$cr = array("alert-info","alert-secondary","alert-success");

?>
<div class="row">
<?php for ($i=0; $i<count($list); $i++) {  ?>
	  <div class="col-md-4 margin-bottom-30">
		<div class="card <?php echo $cr[$i];?>">
		  <div class="card-body">
			<h5 class="card-title ko1">
			<?php
				if ($list[$i]['is_notice'])
					echo "<strong>".$list[$i]['subject']."</strong>";
				else
					echo "<strong>".$list[$i]['subject']."</strong>";
			?>
			</h5>
			<h6 class="card-subtitle mb-2 text-muted ko2 f12"><?php echo $list[$i]['name'] ?> <?php echo $list[$i]['datetime'] ?></h6>
			<p class="card-text ko1 f15" style="margin-bottom:20px;height:118px;">
				<?php echo cut_str(strip_tags($list[$i]['wr_content']),'120','..')?>
				<?php
				if ($list[$i]['comment_cnt'])  echo "
				<span class=\"lt_cmt\">+ ".$list[$i]['comment_cnt']."</span>";
			?>
			</p>
			<a href="<?php echo $list[$i]['href']?>" class="card-link"><strong>더보기</strong></a>
		  </div>
		</div>
	  </div>
	 <?php } ?>
</div><!-- /row -->