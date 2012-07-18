<?
include('config.php');

$makeId=$_GET['make_id'];

// Delete model
$sql = "delete from ben_make where make_id = $makeId ";
sqlinsert($sql);

echo "<html><meta http-equiv='refresh' content='0; URL=index.php?page=$page&subpage=model_list'></html>";
exit; 

?>