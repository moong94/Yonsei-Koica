<?php

/* www/sub/new.php */



include_once('../common.php');



// 페이지 제목




// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨

add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/sub.css">', 0);




include_once(G5_PATH.'/head.php');

?>

<ul id="mysub5">
        <a href="http://gmegm.cafe24.com/bbs/content.php?co_id=info" target="_self"><li class="leftmenu_b">COMMUNITY</li></a>
            <ul>
                <a href="http://gmegm.cafe24.com/bbs/content.php?co_id=info" target="_self">
                <li class="leftmenu_selected">

                MIN</li></a>
            <script language="javascript"> display_submenu(5 ); </script> </ul>
    </ul>



<?php

include_once(G5_PATH.'/tail.php');

?>
