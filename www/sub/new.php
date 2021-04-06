<?php

/* www/sub/new.php */



include_once('../common.php');



// 페이지 제목

$g5['title'] = "학사 일정";



// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨

add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/sub.css">', 0);




include_once(G5_PATH.'/head.php');

?>
<?php  include_once(G5_PATH.'/skin/nav/mysubmenu.php'); ?>
<div>
        <iframe src="https://ycms.yonsei.ac.kr/koica/tish.do" scrolling="no" frameborder="0" width="100%" height="5300"></iframe>
    </div>



<?php

include_once(G5_PATH.'/tail.php');

?>
