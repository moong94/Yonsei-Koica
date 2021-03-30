<?php
if (!defined('_GNUBOARD_')) exit;

// NO IMAGE 썸네일
function get_noimage_thumbnail($bo_table, $noimg, $width, $height, $class='')
{
    $img_content = '<span style="width:'.$width.'px;height:'.$height.'px"';
    if($class)
        $img_content .= ' class="'.$class.'"';
    $img_content .= '>no image</span>';

    if(!is_file($noimg))
        return $img_content;

    $size = @getimagesize($noimg);
    if($size[2] < 1 || $size[2] > 3)
        return $img_content;

    $ext = array(1 => 'gif', 2 => 'jpg', 3 => 'png');

    $filename = 'no-image.'.$ext[$size[2]];
    $filepath = G5_DATA_PATH.'/file/'.$bo_table;

    $src_file = $filepath.'/'.$filename;
    if(!is_file($src_file)) {
        if(!copy($noimg, $src_file))
            return $img_content;

        @chmod($src_file, G5_FILE_PERMISSION);
    }

    $tname = thumbnail($filename, $filepath, $filepath, $width, $height, false, true);

    if(!$tname)
        return $img_content;

    return '<img src="'.G5_DATA_URL.'/file/'.$bo_table.'/'.$tname.'" width="'.$width.'" height="'.$height.'">';
}
?>