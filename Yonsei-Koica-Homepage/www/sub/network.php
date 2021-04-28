<?php

/* www/sub/new.php */



include_once('../common.php');



// 페이지 제목




// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨

add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/sub.css">', 0);




include_once(G5_PATH.'/head.php');

?>

<head>
  <style>
  ul, ol, li{ list-style:none; margin:0; padding:0; }

ul.myMenu {}
ul.myMenu > li { width:319px; padding:5px 10px; background:#4e6791; font-size: 12pt; border:1px solid #163B6E; color: white; text-align:center; position:relative; margin: 0px -200px; }
ul.myMenu > li:hover { background:#4e6791; }
ul.myMenu > li ul.submenu { display:none; position:absolute; top:30px; left:0; }
ul.myMenu > li:hover ul.submenu { display:block; }
ul.myMenu > li ul.submenu > li { display:inline-block; width:319px; padding:5px 10px; background:#163B6E; border:1px solid #163B6E; text-align:center;font-size: 12pt; }
ul.myMenu > li ul.submenu > li:hover { background:#5981B7; }
  </style>

</head>

<div id="container">
<table style="margin:0px -200px;background: ;text-align: center;background: #163B6E;color: #ffff;height: 80px;font-size: 18;" width="342px" border="0">
    <tbody><tr><td>COMMUNITY</td></tr>
  </tbody></table>

</table>
<ul class="myMenu">

    <li class="menu2">
       network
        <ul class="menu2_s submenu">
            <li>1st Batch Members</li>
            <li>메뉴 2-2</li>
            <li>메뉴 2-3</li>
        </ul>
    </li>

</ul>
</div>

<!--
<table border="1" style="float: left;margin-right:30px; margin-left:-285px;margin-top:70px; z-index:1" width="500" height="200">
<tr><td>3</td></tr>
<tr><td>3</td></tr>
<tr><td>3</td></tr>
</table>
-->

<br><br><br><br><br><br><br><br><br>
<table style="float: left;margin-right:39px; margin-left:224px;margin-top:-202px; z-index:1" width="100%" height="150" border="1">
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


<?php

include_once(G5_PATH.'/tail.php');

?>
