<?php
define('_newpage_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/newpage.php');
    return;
}

include_once(G5_THEME_PATH.'/index_head.php');
?>
adsadasd
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>
