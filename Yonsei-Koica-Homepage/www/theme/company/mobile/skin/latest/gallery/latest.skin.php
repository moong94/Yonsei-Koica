<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once(G5_THEME_LIB_PATH.'/thumbnail2.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);

$thumb_width  = isset($options['thumb_width']) ? $options['thumb_width'] : $board['bo_gallery_width'];
$thumb_height = isset($options['thumb_height']) ? $options['thumb_height'] : $board['bo_gallery_height'];
$content_length = isset($options['content_length']) ? $options['content_length'] : 30;
?>
<div class="lt_gal">
    <h2><a href="<?php echo get_pretty_url($bo_table); ?>" class="lt_title"><span></span><?php echo $bo_subject ?></a></h2>
    <ul>
    <?php
    for ($i=0; $i<count($list); $i++) {
        $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height);

        if($thumb['src']) {
            $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$thumb_width.'" height="'.$thumb_height.'">';
        } else {
            $noimg = $latest_skin_path.'/img/no_img.gif';
            $img_content = '<span>'.get_noimage_thumbnail($bo_table, $noimg, $thumb_width, $thumb_height, $class='no_img').'</span>';
        }
    ?>
        <li>
            <a href="<?php echo $list[$i]['href']; ?>" class="lt_image"><?php echo $img_content; ?></a>
            <?php
            echo "<a href=\"".$list[$i]['href']."\" class=\"lt_tit\">";
            if ($list[$i]['is_notice'])
                echo "<strong>".$list[$i]['subject']."</strong>";
            else
                echo $list[$i]['subject'];
            echo "</a>";
             ?>
        </li>
    <?php }  ?>

    <?php if ($i == 0) { //게시물이 없을 때  ?>
        <li class="no_lt">게시물이 없습니다.</li>
    <?php }  ?>
    </ul>

</div>
