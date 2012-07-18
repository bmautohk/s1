<?
$sprod_no=$_GET['sprod_no'];
$sale_ref=$_GET['sale_ref'];
$sql = "delete from ben_sale_prod where sprod_no = $sprod_no";
sqlinsert($sql);

echo "<html><meta http-equiv='refresh' content='0; URL=index.php?page=order&subpage=edit&sale_ref=$sale_ref'></html>";
?>