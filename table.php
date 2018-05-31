<? 
$pro_num=$_POST['pro_num'];
if (isset($_POST['pro_color'])){
$pro_color=$_POST['pro_color'];
} else
{$pro_color="#000000";}
$pro_size=$_POST['pro_size'];
$pro_type=$_POST['pro_type'];



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>無標題文件</title>
<link rel="stylesheet" type="text/css" href="/print.css" media="print" />
<style type="text/css">
<!--
.ad_font {
	font-family: <?=$pro_type;?>;
	font-size: <?=$pro_size;?>;
	color: <?=$pro_color;?>;
}


-->
</style>
</head>

<body leftmargin="0" topmargin="0">

<table width="720" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" rowspan="2" valign="top"><img src="<?=$_POST['pro_main']; ?>" width="540" height="320"></td>
    <td width="180" height="120" valign="top"><div align="center">
        <table width="150" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="20" valign="middle">
              <div align="center">
                <span class="ad_font"><?=$_POST['pro_name_1']; ?></span>
</div></td>
          </tr>
          <tr>
            <td valign="top"><div align="center"><img src="<?=$_POST['pro_link_1']; ?>" width="180" height="120"><br>
              <span class="ad_font"><?=$_POST['pro_detail_1']; ?></span>
            </div></td>
          </tr>
          <tr>
        
          </tr>
        </table>
    </div></td>
  </tr>
<tr>
    <td height="120"><div align="center">
        <table width="180" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="20">
              <div align="center">
               <span class="ad_font"> <?=$_POST['pro_name_2']; ?></span>
            </div></td>
          </tr>
          <tr>
            <td valign="top"><div align="center"><img src="<?=$_POST['pro_link_2']; ?>" width="180" height="120">
           <span class="ad_font"> <?=$_POST['pro_detail_2']; ?></span></div>            </td>
          </tr>
          <tr>
           
          </tr>
        </table>
    </div></td>
</tr>

  
  <? 



$table_row=floor(($pro_num-3)/4);
$remain = 4 - ($pro_num-2)%4;

for ($z=3;$z<=$pro_num;$z++){
if ($z==19 or $z==43 or $z==67 or $z==91)
 {echo "<table width=\"720\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";}

$pro_name="pro_name_".$z;
$pro_link="pro_link_".$z;
$pro_detail="pro_detail_".$z;

if ($z%4==3)
{echo "<tr>";}
 	echo"<td width=\"180\" valign=\"middle\"><div align=\"center\">
	
	<table width=\"180\" height=\"170\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
        <tr>
          <td >
            <div align=\"center\"><span class=\"ad_font\">$_POST[$pro_name]&nbsp;</span></div>
  </td>
  </tr>
  <tr>
    <td><img src=\"$_POST[$pro_link]\" width=\"180\" height=\"120\"><br><span class=\"ad_font\">$_POST[$pro_detail]</span></td>
  </tr>
  <tr>
</tr></table></td>";

  
 if ($z%4==2)
{echo "</tr>";}





if ($z<$pro_num) {
if ($z==18 || $z==42 || $z==66 || $z==90)
 {echo "</table>"; 
 	if (isset($_POST['pro_space']))
		 { for  ($y=0;$y<$_POST['pro_space'];$y++)
 		{echo "<br>";}
 			}
			}
}else
{
if (($z==$pro_num) and ($remain!=4))
{
for ($x=0;$x<$remain;$x++){
echo "<td width=\"180\">&nbsp;</td>";
}
}
echo "</tr></table>"; 
}


}
//echo $remain;
?></body>
</html>
