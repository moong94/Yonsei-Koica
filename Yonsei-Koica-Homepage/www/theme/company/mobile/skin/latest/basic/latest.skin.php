<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>

<div class="lt">
    <h2><a href="<?php echo get_pretty_url($bo_table); ?>" class="lt_title"><span></span><?php echo $bo_subject ?></a></h2>
    <ul>
    <?php for ($i=0; $i<count($list); $i++) { ?>
        <li>
            <?php
            //echo $list[$i]['icon_reply']." ";
            echo "<a href=\"".$list[$i]['href']."\">";
            if ($list[$i]['is_notice'])
                echo "<strong>".$list[$i]['subject']."</strong>";
            else
                echo $list[$i]['subject'];

            if ($list[$i]['comment_cnt'])
                echo " <span class=\"cnt_cmt\">".$list[$i]['comment_cnt']."</span>";
                if (isset($list[$i]['icon_new']))    echo " " . $list[$i]['icon_new'];
            echo "</a>";

            ?>
            <span class="lt_date"><?php echo $list[$i]['datetime2'] ?></span>
        </li>
    <?php } ?>
    <?php if (count($list) == 0) { //게시물이 없을 때 ?>
    <li class="no_lt">게시물이 없습니다.</li>
    <?php } ?>
    </ul>

</div>
