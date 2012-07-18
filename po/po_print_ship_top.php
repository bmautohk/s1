<html>

<?
include_once('../functions.php');
$prod_n = 0;
$subTotal = 0;

$total_prod_cnt = $_GET['prod_n'];

$db=connectDatabase();
mysql_select_db(DB_NAME,$db);

$ship_date = $_GET['ship_date'];
$entry_date = $_GET['entry_date'];
$staff_code = $_GET['staff_code'];
$staff_name = $_GET['staff_name'];
$wareHouseCode = $_GET['wareHouseCode'];
$remarks = $_GET['remarks'];

switch($wareHouseCode)
{
case 'J1':
	$warehouse = '3ÃúÌÜ';
	break;
case 'J2':
	$warehouse = '±ºÅÄ';
	break;
case 'HK':
	$warehouse = 'HK';
	break;
case 'CN':
	$warehouse = 'China';
	break;
default:
	$warehouse = '';
}

for ($i=1;$i<=$total_prod_cnt;$i++) {
	$prod_n++;			
	$po_prod_id[$prod_n] = $_GET['po_prod_id'.$i];
	$ship_qty[$prod_n] = $_GET['ship_qty'.$i]; if ($ship_qty[$prod_n] == '') $ship_qty[$prod_n] = 0;

	$sql = "SELECT * FROM po_product WHERE id = $po_prod_id[$prod_n]";
	$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	$row = mysql_fetch_array($result);
	
	$po_id[$prod_n] = $row['po_id'];
	$goods_partno[$prod_n] = $row["product_cd"];
	$goods_name[$prod_n] = $row["product_name"];
	$goods_remark[$prod_n] = $row["remark"];
	$product_colour[$prod_n] = $row["colour"];
	$pcs[$prod_n] = $row["pcs_set"];
	$po_qty[$prod_n] = $row["qty"];
	$shiped_qty = $row['ship_qty'];
	$remain_qty[$prod_n] = $po_qty[$prod_n] - $shiped_qty;
	
	$subTotal = $subTotal + $ship_qty[$prod_n];
}
?>

<head>
<LINK href="../style1.css" type=text/css rel=STYLESHEET>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
</head>
<body>

<strong>Purchase Order<br /></strong><br>
<table>
<tr>
    <td>Ship Date :</td><td><?=$ship_date?></td>
    <td width="34">&nbsp;</td>
    <td>Ship Entry Date :</td><td><?=$entry_date?></td>
</tr>
<tr>
    <td>Staff Code :</td><td><?=$staff_cd?></td>
    <td>&nbsp;</td>
    <td>Staff Name :</td><td><?=$staff_name?></td>
</tr>
<tr>
	<td>Ware House :</td><td><?=$warehouse?></td>
</tr>
<tr>
	<td valign="top">Remarks :</td><td colspan="4"><?=$remarks?></td>
</tr>
</table>
<br><br>
<table width="1094" border="1" cellpadding="0" cellspacing="0">
                    <div align="center">
                      <tr bgcolor="#CCCCCC">
                        <td width="58">Row Num.</td>
                        <td><div align="center">PO ID</div></td>
                        <td width="100"><div align="center">Product No. </div></td>
                        <td width="206"><div align="center">Products Name</div></td>
                        <td align="center" width="172">Remark</td>
                        <td width="98"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="center" width="88">Colour</td>
                          </tr>
                        </table></td>
                        <td align="center" width="76">Pcs/Set</td>
                        <td align="center" width="76">PO Qty</td>
                        <td align="center" width="98">Remaining Qty</td>
                        <td width="117"><div align="center">Ship Qty</div></td>
                      </tr>
                      <? for($i=1;$i<=$prod_n;$i++){ ?>
                      
                      <tr>
                        <td align="right">
							<? echo $i?>
                        </td>
                        <td><div align="center">
                          <? echo $po_id[$i]?>
                        </div></td>
                        <td><div align="center">
                          <? echo $goods_partno[$i] ?>
                        </div></td>
                        <td><div align="center">
                          <? echo $goods_name[$i] ?>
                        </div></td>
                        <td><div align="center">
                          <? echo $goods_remark[$i] ?>
                        </div></td>
                        <td><div align="center">
                        	<? echo $product_colour[$i] ?>
                        </div></td>
                        <td><div align="center">
                        	<? echo $pcs[$i] ?>
                        </div></td>
                        <td><div align="center">
                          <? echo $po_qty[$i]?>
                        </div></td>
                        <td><div align="center">
                        	<? echo $remain_qty[$i]?>
                        </div></td>
                        <td><div align="center">
                          <? echo $ship_qty[$i]?>
                        </div></td>
                      </tr>
                      <? } ?>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>Total Ship Qty:<br /></td>
                        <td><div align="center">
                        	<? echo $subTotal?>
                        </div></td>
                      </tr>
                      </div>
              </table>
</body>
</html>