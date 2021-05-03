<head>
  <style>
  ul, ol, li{ list-style:none; margin:0; padding:0; }
  .mytable {
        margin:0px -265px;background: ;text-align: center;background: #86A5D0; border-bottom: 2px solid #123059; color: #163B6E;height: 15px;font-size: 16;background: #fafafa;
      }
ul.myMenu {}
ul.myMenu > li { width:298px; padding:5px 10px; background:#4e6791; font-size: 12pt; border:1px solid #163B6E; color: white; text-align:center; position:fixed;    right: 1553px;
    top: 787px; }
ul.myMenu > li:hover { background:#4e6791; }
ul.myMenu > li ul.submenu { display:none; position:absolute; top:30px; left:0; }
ul.myMenu > li:hover ul.submenu { display:block; }
ul.myMenu > li ul.submenu > li { display:inline-block; width:319px; padding:5px 10px; background:#163B6E; border:1px solid #163B6E; text-align:center;font-size: 12pt; }
ul.myMenu > li ul.submenu > li:hover { background:#5981B7; }

#network_nav .leftmenu_net{color:white; width: 320px;line-height: 85px;background-color: #163B6E;border:0px solid gray;text-align: center;font-size: 12pt; font-weight: bold;}
#network_nav .leftmenu_s_net {line-height:35px;padding-left:20px;padding-right:20px;background-color:#fafafa;color: #163B6E;border-bottom:2px solid #123059;width:280px;}
#network_nav .leftmenu_s_selected{line-height:35px; padding-left:20px; padding-right:20px;width:280px; background-color:#4e6791;border-bottom:2px solid #123059;color:white}

  </style>

</head>

<?php

/* www/sub/new.php */



include_once('../common.php');





$g5['title'] = "Alumni Network";


// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨

add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/sub.css">', 0);
?>

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Berkshire+Swash&display=swap" rel="stylesheet">
<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

add_javascript('<script src="'.G5_THEME_JS_URL.'/fancySelect.js"></script>', 10);
?>
<!-- 상단 시작 { -->
<div id="hd">
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>

    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    }
    ?>

    <div id="hd_wrapper">

        <div id="logo">
            <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_URL ?>/theme/company/img/main_koica_main2.jpg" alt="<?php echo $config['cf_title']; ?>"></a>
        </div>

        <?php include_once(G5_THEME_PATH.'/head.menu.php'); ?>

        <ul id="tnb">
            <?php if ($is_member) {  ?>
            <?php if ($is_admin) {  ?>
            <li class="tnb_adm"><a href="<?php echo G5_ADMIN_URL ?>"><b>관리자</b></a></li>
            <?php }  ?>
            <li><a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a></li>
            <?php } else {  ?>
            <li><a href="<?php echo G5_BBS_URL ?>/login.php" ><b>로그인</b></a></li>
            <?php }  ?>
        </ul>
    </div>



</div>
<!-- } 상단 끝 -->


<!-- 콘텐츠 시작 { -->
<div id="wrapper">


    <div id="sub_tit"><?php
        // echo "<img src='/theme/company/img/$co_id.jpg'/>";
         echo "<img src='/theme/company/img/tab_img.jpg'/>";
    ?>


    </div>
      <h2 id="ctn_title"><?php echo get_text((isset($bo_table) && $bo_table) ? $board['bo_subject'] : $g5['title']); ?></h2>

      <div id="network_nav" style="float: left;margin-right:30px; margin-left:30px;margin-top:20px; z-index:1; position:fixed">

              <ul id="mysub_net" style="display:block;">
              <a href="http://gmegm.cafe24.com/bbs/board.php?bo_table=notice" target="_self">
                <li class="leftmenu_net">
                  COMMUNITY
                </li>
                </a>
                  <ul>
                      <a href="https://gmegm.cafe24.com/sub/network_2.php" target="_self">
                      <li class="leftmenu_s_selected">

                      network2</li></a>
                                  <a href="http://gmegm.cafe24.com/bbs/board.php?bo_table=notice" target="_self">
                      <li class="leftmenu_s_net">

                      News &amp; Notices</li></a>
                                  <a href="http://gmegm.cafe24.com/bbs/board.php?bo_table=thesis" target="_self">
                      <li class="leftmenu_s_net">

                      Thesis</li></a>
                                  <a href="http://gmegm.cafe24.com/bbs/board.php?bo_table=graduation" target="_self">
                      <li class="leftmenu_s_net">

                      Graduation Report</li></a>
                                  <a href="http://gmegm.cafe24.com/bbs/board.php?bo_table=gallery" target="_self">
                      <li class="leftmenu_s_net">

                      Gallery</li></a>
                                  <a href="http://gmegm.cafe24.com/sub/network.php" target="_self">
                      <li class="leftmenu_s_net">

                      Alumni Network</li></a>
                  </ul>
          </ul>


      </div>

    <div id="container">
        <?php if ((!$bo_table || $w == 's' ) && !defined("_INDEX_")) { ?><div id="container_title"><?php echo $g5['title'] ?></div><?php } ?>
        <table style="position: relative;" width="100%" height="150" border="1">
          <tbody><tr>

          <td width="10%"><img src="../theme/company/img/network/20210428_191006.png" width="100%"></td>


          <td width="40%"><h1> SINIT LONH</h1> <br>
            Cambodia<br>
            Deputy Head of Office of General Affair<br>
            Ministry of Industry, Science, Technology and Innovation<br><br>


            Research InterestsField of e-Government: Citizen trust in e-Government adoption/services, e-Government as a driving force to economic growth, and e-Government in politics.<br>
            Career Plan in 10 Years<br>
            Policy decision making in the area of e-Government</td>
            <td width="10%"> <img src="../theme/company/img/network/20210428_200614.png" width="100%"></td>
              <td width="40%"><br><br>
              <h1>  VILAYPHONE XAYSONGKHAME</h1><br>

                Lao People's Democratic Republic (Lao PDR/Laos)<br><br>

                Technical official in the field of disability development<br>
                Department of Policy to Devotees, Disabilities, and Elderlies<br>
                Ministry of Labor and Social Welfare<br><br>

                Research Interests <br>
                I am interested in ICT or Data Online System in Korea, especially in terms of the Social Welfare online system for persons with disabilities. Thus, my research expects to study:<br>



              </td>
          </tr>

        </table>

        <br><br><br><br>

        <table style="position: relative;" width="100%" height="150" border="1">
          <tbody><tr>

          <td width="10%"><img src="../theme/company/img/network/20210429_190916.png" width="100%"></td>


          <td width="40%"><h1> KYAW SOE NAING</h1> <br>
            Myanmar<br>
            Deputy Director<br>
            Ministry of Transport and Communications, Information Technology and Cyber Security Department<br><br>


            Research Interests <br>
          e-Government Development processes, cyber security and other IT fields
        <br>
        Career plan in 10 Years<br>
        IT professional in the government sector, especially in e-Government and cyber security sector
        </td>
            <td width="10%"> <img src="../theme/company/img/network/20210429_190932.png" width="100%"></td>
              <td width="40%"><br><br>
              <h1>  VILAYPHONE XAYSONGKHAME</h1><br>

                Lao People's Democratic Republic (Lao PDR/Laos)<br><br>

                Technical official in the field of disability development<br>
                Department of Policy to Devotees, Disabilities, and Elderlies<br>
                Ministry of Labor and Social Welfare<br><br>

                Research Interests <br>
                I am interested in ICT or Data Online System in Korea, especially in terms of the Social Welfare online system for persons with disabilities. Thus, my research expects to study:<br>



              </td>
          </tr>

        </table>
        <br><br><br><br>
        <table style="/*! margin: ; */position: relative;" width="100%" height="150" border="1">
          <tbody><tr>

          <td width="10%"><img src="../theme/company/img/network/20210429_190956.png" width="100%"></td>


          <td width="40%"><h1> SINIT LONH</h1> <br>
            Cambodia<br>
            Deputy Head of Office of General Affair<br>
            Ministry of Industry, Science, Technology and Innovation<br><br>


            Research InterestsField of e-Government: Citizen trust in e-Government adoption/services, e-Government as a driving force to economic growth, and e-Government in politics.<br>
            Career Plan in 10 Years<br>
            Policy decision making in the area of e-Government</td>
            <td width="10%"> <img src="../theme/company/img/network/20210429_191012.png" width="100%"></td>
              <td width="40%"><br><br>
              <h1>  VILAYPHONE XAYSONGKHAME</h1><br>

                Lao People's Democratic Republic (Lao PDR/Laos)<br><br>

                Technical official in the field of disability development<br>
                Department of Policy to Devotees, Disabilities, and Elderlies<br>
                Ministry of Labor and Social Welfare<br><br>

                Research Interests <br>
                I am interested in ICT or Data Online System in Korea, especially in terms of the Social Welfare online system for persons with disabilities. Thus, my research expects to study:<br>



              </td>
          </tr>

        </table>



<?php

include_once(G5_PATH.'/tail.php');

?>
