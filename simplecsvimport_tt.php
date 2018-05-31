
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
<title>無標題文件</title>
</head>

<body>
<?
require('functions.php');
require('config.php'); 


    $filename="ben_jp_16_12.csv";
     $handle = fopen("$filename", "r");
     while (($data = fgetcsv($handle, 1000, "	")) !== FALSE)
     {
 	 for ($i=0;$i<=45;$i++) {
	 //$j[$i] = iconv("UTF-8","EUC-JP",$data[$i]);
	 $j[$i] = mb_convert_encoding($data[$i],"EUC-JP","UTF-8");


	 }

    $db=connectDatabase();
      $import="INSERT into ben_product_tt set
	  product_id='$j[0]',
product_jp_no='$j[0]',
product_us_no='',
product_sup_no='',
product_made='$j[1]',
product_model='$j[2]',
product_model_no='$j[3]',
product_year='$j[4]',
cat_id='$j[5]',
product_name='$j[7]',
product_remark='$j[6]',
product_pcs='$j[8]',
product_colour='$j[9]',
product_cus_des='$j[37]',
product_price_u='$j[11]',
product_price_s='$$j[12]',
product_price_s1='$j[13]',
product_price_s2='$j[14]',
product_cus_price='$j[38]',
product_cost_rmb='$j[29]',
product_cost_hk='$j[28]',
product_cost_us='',
product_cost_yan='$j[30]',
product_sup='',
product_stock_hk='',
product_stock_jp='',
product_stock_us='',
product_stock_cn='',
product_stock_level='',
product_web = '$product_web'";
	  
echo $import."<br><br>";	  
	  //(product_id,product_name,product_made,product_model,product_model_no,product_cat,product_pcs,product_colour,product_price_u,product_yahoo_last_price,product_cost)
	   //values('$j[0]','$j[5]','$j[1]','$j[2]','$j[3]','$j[4]','$j[6]','$j[7]','$j[8]','$j[20]','$j[25]')";

     sqlinsert( $import);
	 for ($i=0;$i<=45;$i++) {
	 
	 
	 echo $j[$i]." $i";
	 
	 
	 }
	 echo "<br>";
	 }
     fclose($handle);
     print "Import done"; 

?>
</body>
</html> 
