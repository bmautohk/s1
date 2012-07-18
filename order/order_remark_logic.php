<?

if (isset($_GET['sale_ref']) )
{
$sale_ref=$_GET['sale_ref'];
$remark_row = getdebt_data($sale_ref);
$remark= $remark_row['debt_remark'];

}

if (isset($_GET['sale_ref']))
{$sale_ref=$_GET['sale_ref'];}

if (isset($_POST['isupdate']))
		{
		
if (!getdebt_data($sale_ref)) {

$sqla = "INSERT INTO ben_debt SET
debt_ref='".$sale_ref."',
debt_remark='".$_POST['remark']."'";
		 
sqlinsert($sqla);
$remark_row = getdebt_data($sale_ref);
$remark= $remark_row['debt_remark'];
}
else 
{

//update debt note

$sqla = "Update ben_debt SET debt_remark='".$_POST['remark']."' where debt_ref= '".$sale_ref."'";
//echo $sqla;
sqlinsert($sqla);

$remark_row = getdebt_data($sale_ref);
$remark= $remark_row['debt_remark'];


}
		}


?>