<script type="text/javascript">
<!--
    function display_submenu(num) {
         document.getElementById("mysub"+num).style.display="block";
    }
//-->
</script>

<style TYPE="text/css">
<!--
#mysubmenu ul {list-style:none; font-size:11pt; margin:0; padding:0;}
#mysubmenu .leftmenu_b {color: white;width:320px;line-height:85px; background-color:#163B6E;border:0px solid gray;text-align:center;font-size:12pt;font-weight:bold;}
#mysubmenu .leftmenu_s {line-height:35px; padding-left:20px; padding-right:20px; background-color:#fafafa;color: #163B6E;border-bottom:2px solid #123059; width:280px;}
#mysubmenu .leftmenu_s a:hover{color:black}
#mysubmenu a {text-decoration:none;}
#mysubmenu a:hover {color:#e6e6e6;}
#mysubmenu a:link, a:visited {color:white;}
#mysubmenu .leftmenu_selected{line-height:35px; padding-left:20px; padding-right:20px;width:280px; background-color:#4e6791;border-bottom:2px solid #123059;}

//-->
</style>

<div id="mysubmenu" style="float: left;margin-right:10px; margin-left:10px; position:fixed; z-index:1">
    <?php
    $sql = " select *
                from {$g5['menu_table']}
                where me_use = '1'
                  and length(me_code) = '2'
                order by me_order, me_id ";
    $result = sql_query($sql, false);
    $gnb_zindex = 999; // gnb_1dli z-index 값 설정용

    for ($i=0; $row=sql_fetch_array($result); $i++) {
    ?>
    <ul id="mysub<?php echo $i ?>" style="display:none;">
        <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" ><li class="leftmenu_b"><?php echo $row['me_name'] ?></li></a>
            <?php
            $sql2 = " select *
                        from {$g5['menu_table']}
                        where me_use = '1'
                          and length(me_code) = '4'
                          and substring(me_code, 1, 2) = '{$row['me_code']}'
                        order by me_order, me_id ";
            $result2 = sql_query($sql2);

            //좌측 서브메뉴 전체 리스트에서 현재 페이지에 해당하는 대메뉴 리스트만 보여줌
            if ( ($row['me_name']==$board['bo_subject'])||($row['me_name']==$g5['title']) ) {
                echo ("<script language='javascript'> display_submenu(" .$i. " ); </script> ");
            }

            for ($k=0; $row2=sql_fetch_array($result2); $k++) {
                if($k == 0)
                    echo '<ul>'.PHP_EOL;
            ?>
                <a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" >
                <?php
                if (($row2['me_name']==$board['bo_subject'])||($row2['me_name']==$g5['title'])){
                  ?><li class = "leftmenu_selected">
                <?php
              }
                else{
                ?><li class="leftmenu_s">
                <?php
              }
              ?>

                <?php echo $row2['me_name'] ?></li></a>
            <?php
                //좌측 서브메뉴 전체 리스트에서 현재 페이지에 해당하는 대메뉴 리스트만 보여줌
                if ( ($row2['me_name']==$board['bo_subject'])||($row2['me_name']==$g5['title']) ) {
                    echo ("<script language='javascript'> display_submenu(" .$i. " ); </script> ");

                }

            }

            if($k > 0)
                echo '</ul>'.PHP_EOL;
            ?>
    </ul>
    <?php } ?>


</div>
