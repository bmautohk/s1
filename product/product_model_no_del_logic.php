<?
include('config.php');

$modelNoId=$_GET['model_no_id'];

// Delete model
$sql = "delete from ben_model_no where model_no_id = $modelNoId ";
sqlinsert($sql);

echo "<html><meta http-equiv='refresh' content='0; URL=index.php?page=$page&subpage=model_list'></html>";
exit; 

?>