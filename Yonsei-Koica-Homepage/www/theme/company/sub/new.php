<?php

/* www/sub/new.php */



include_once('../common.php');



// 페이지 제목

$g5['title'] = "새로운 페이지";



// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨

add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/sub.css">', 0);



include_once(G5_PATH.'/head.php');

?>



<!-- 여기 아래부터 모든 HTML 요소 구성 시작 -->



asdasd

<!-- 여기 아래부터 모든 HTML 요소 구성 끝 -->



<?php

include_once(G5_PATH.'/tail.php');

?>
