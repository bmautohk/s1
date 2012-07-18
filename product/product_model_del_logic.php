<?
include('config.php');

$modelId=$_GET['model_id'];

// Clear model & model no. mapping
$sql = "update ben_model_no set model_id = null where model_id = $modelId ";
sqlinsert($sql); 

// Delete model
$sql = "delete from ben_model where model_id = $modelId ";
sqlinsert($sql);

echo "<html><meta http-equiv='refresh' content='0; URL=index.php?page=$page&subpage=model_list'></html>";
exit; 

?>