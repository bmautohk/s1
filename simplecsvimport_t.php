
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


    $filename="jp.csv";
     $handle = fopen("$filename", "r");
     while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
     {
 	 for ($i=0;$i<=40;$i++) {
	 $j[$i] =iconv("UTF-8","EUC-JP",$data[$i]);
	 

	 }

    $db=connectDatabase();
      $import="INSERT into ben_product_t (product_id,product_name,product_made,product_model,product_model_no,product_cat,product_pcs,product_colour,product_price_u,product_yahoo_last_price,product_cost)
	   values('$j[0]','$j[5]','$j[1]','$j[2]','$j[3]','$j[4]','$j[6]','$j[7]','$j[8]','$j[20]','$j[25]')";

     sqlinsert( $import);
	 for ($i=0;$i<=30;$i++) {
	 
	 
	 echo $j[$i]." $i";
	 
	 
	 }
	 echo "<br>";
	 }
     fclose($handle);
     print "Import done"; 

?>
</body>
</html> 
