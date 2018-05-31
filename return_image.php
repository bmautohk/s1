<?php

$img_name = $_GET['name'];
$img_name = "return_photo/".$img_name;

$img_width = 0;
$img_height = 0;

$img_width = @$_GET['w'];
$img_height = @$_GET['h'];

if (empty($img_width)) {$img_width = 100;} 
if (empty($img_height)) {$img_height = 100;} 

$max_width    = $img_width ; // maximum x aperture  in pixels
$max_height   = $img_height; // maximum y aperture in pixels

$size=GetImageSize($img_name);
$width_ratio  = ($size[0] / $max_width);
$height_ratio = ($size[1] / $max_height);
 
if($width_ratio >=$height_ratio) 
{
   $ratio = $width_ratio;
}
else
{
   $ratio = $height_ratio;
}
 
$new_width    = ($size[0] / $ratio);
$new_height   = ($size[1] / $ratio);
Header("Content-Type: image/jpeg");
$src_img = ImageCreateFromJPEG($img_name);
$thumb = ImageCreateTrueColor($new_width,$new_height);
ImageCopyResampled($thumb, $src_img, 0,0,0,0,($new_width),($new_height),$size[0],$size[1]);
ImageJPEG($thumb);
ImageDestroy($src_img);
ImageDestroy($thumb);
?>
