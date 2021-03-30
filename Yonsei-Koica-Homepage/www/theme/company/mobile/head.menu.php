<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<button type="button" id="gnb_open" class="hd_opener">메뉴<span class="sound_only"> 열기</span></button>
<div id="gnb" class="hd_div">
    <div id="hd_sch" >
        <h2>사이트 내 전체검색</h2>
        <form name="fsearchbox" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);" method="get">
        <input type="hidden" name="sfl" value="wr_subject||wr_content">
        <input type="hidden" name="sop" value="and">
        <input type="text" name="stx" id="sch_stx"  required class="required" maxlength="20">
        <input type="submit" value="검색" id="sch_submit">
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
    </div>
    <ul id="gnb_1dul">
        <?php
        $gnb_menus = array();

		$menu_datas = get_menu_db(1, true);
		$i = 0;
		foreach( $menu_datas as $row ){
			if( empty($row) ) continue;
        ?>
        <li class="gnb_1dli" style="z-index:<?php echo $gnb_zindex--; ?>">
            <?php
            $submenus = '';

			$k = 0;
			foreach( (array) $row['sub'] as $row2 ){
                if($k == 0)
                   $submenus .= '<button type="button" class="gnb_op">하위메뉴</button><ul class="gnb_2dul">'.PHP_EOL;

                $submenus .= '<li class="gnb_2dli"><a href="'.$row2['me_link'].'" target="_'.$row2['me_target'].'" class="gnb_2da">'.$row2['me_name'].'</a></li>'.PHP_EOL;

				$k++;
            }	//end foreach $row2

            if($k > 0)
                $submenus .= '</ul>'.PHP_EOL;

            if($submenus)
                $gnb_class = 'gnb_1da gnb_bg';
            else
                $gnb_class = 'gnb_1da';
            ?>
            <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="<?php echo $gnb_class; ?>"><?php echo $row['me_name'] ?></a>
            <?php echo $submenus; ?>
        </li>
        <?php
		$i++;
        }	//end foreach $row

        if ($i == 0) {  ?>
            <li id="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <br><a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
        <?php } ?>
    </ul>
    <ul id="hd_nb">
        <?php if ($is_member) { ?>
        <?php if ($is_admin) { ?>
        <li><a href="<?php echo G5_ADMIN_URL ?>" id="snb_adm">관리자</a></li>
        <?php } ?>
        <li><a href="<?php echo G5_BBS_URL ?>/logout.php" id="snb_logout">로그아웃</a></li>
        <?php } else { ?>
        <li><a href="<?php echo G5_BBS_URL ?>/login.php" id="snb_login">로그인</a></li>
        <?php } ?>

    </ul>
    
    <button type="button" id="gnb_close" class="hd_closer"><span class="sound_only">메뉴 </span>닫기</button>
</div>



    

<script>
$(function () {
    $(".hd_opener").on("click", function() {
        var $this = $(this);
        var $hd_layer = $this.next(".hd_div");

        if($hd_layer.is(":visible")) {
            $hd_layer.hide();
            $this.find("span").text("열기");
        } else {
            var $hd_layer2 = $(".hd_div:visible");
            $hd_layer2.prev(".hd_opener").find("span").text("열기");
            $hd_layer2.hide();

            $hd_layer.show();
            $this.find("span").text("닫기");
        }
        $("#wrapper").css("position","fixed").bind('touchmove', function(e){e.preventDefault()});
    });

    $(".hd_closer").on("click", function() {
        var idx = $(".hd_closer").index($(this));
        $(".hd_div:visible").hide();
        $(".hd_opener:eq("+idx+")").find("span").text("열기");
        $("#wrapper").css("position","relative").unbind('touchmove'); //스크롤 방지 해제

    });
});

$(function(){
    $(".gnb_op").click(function(){
        $(this).next().slideToggle(300).siblings(".gnb_2dul").slideUp("slow");
    });
});


</script>
