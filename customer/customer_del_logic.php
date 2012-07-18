<?
include('config.php');

$custId=$_GET['cust_id'];

// Delete model
$sql = "delete from customer where id = $custId ";
sqlinsert($sql);

// Delete product selling price
$sql = "delete from cust_prod_price where cust_id = $custId ";
sqlinsert($sql);

echo "<html><meta http-equiv='refresh' content='0; URL=index.php?page=$page&subpage=list'></html>";
exit; 

?>