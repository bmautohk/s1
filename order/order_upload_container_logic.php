<?php
//include_once 'Classes/PHPExcel.php';

$lang_type="EUC-JP";
//$lang_type="Shift-JIS";

require_once 'Classes/PHPExcel/IOFactory.php';

$action = $_POST['action'];

if ($action == 'Upload') {
	// Upload JP tracking no
	$uplFile = $_FILES["uplFile"];
	
	if ($uplFile !=	"") {
		$objReader = PHPExcel_IOFactory::createReader('CSV')->setDelimiter(',');
		$objReader->setInputEncoding($lang_type);
		$objPHPExcel = $objReader->load($uplFile['tmp_name']);
	

		$containers = array();
		$worksheet = $objPHPExcel->getActiveSheet();
		foreach ($worksheet->getRowIterator() as $row) {
			$rowNo = $row->getRowIndex();
			if ($rowNo == 1) {
				// Skip 1st row (i.e. header)
				continue;
			}
			$cell = $worksheet->getCellByColumnAndRow(0, $rowNo);
			
			 
			$cellVal = $cell->getValue();
			if ($cellVal != "") {
			//	$container['container_date'] = $worksheet->getCellByColumnAndRow(0, $rowNo)->getValue();
				$container['packing_no'] = $worksheet->getCellByColumnAndRow(0, $rowNo)->getValue();
				$container['product_id'] = $worksheet->getCellByColumnAndRow(1, $rowNo)->getValue();
				//$container['color'] = $worksheet->getCellByColumnAndRow(3, $rowNo)->getValue();
				//$container['piece'] = $worksheet->getCellByColumnAndRow(4, $rowNo)->getValue();
				$container['qty'] = $worksheet->getCellByColumnAndRow(2, $rowNo)->getValue();
				$container['custom'] = $worksheet->getCellByColumnAndRow(3, $rowNo)->getValue();
				 $container['custom'] = mb_convert_encoding($container['custom'],$lang_type,"UTF-8");
				 
				$containers[] = $container;
			}
		}
	}

	$userName = $_SESSION['user_name'];
	foreach ($containers as $container) {
		$sql = "insert into container (container_date,packing_no, product_id, qty, created_by, creation_date, last_upd_by, last_upd_date,color,piece,custom) values ('".
		$container['container_date']."', '".$container['packing_no']."', '".$container['product_id']."','".$container['qty']."', '$userName', now(), '$userName', null,'".$container['color']."','".$container['piece']."','".$container['custom']."') ";
		sqlinsert($sql);
	 
	}
	
	$msg = "Upload container successfully! No. of inserted record: ".sizeof($containers);;
}

// List out all containers
$containers = array();
$db=connectDatabase();
mysql_select_db(DB_NAME,$db);
//mysql_query("SET NAMES 'euc-jp'"); 
$result = mysql_query("SELECT * FROM container order by id desc" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
$num_results=mysql_num_rows($result);
for ($i=0;$i<$num_results;$i++) {
	$row = mysql_fetch_array($result);
	
	$containers[$i]['id'] = $row['id'];
	$containers[$i]['packing_no'] = $row['packing_no'];
	$containers[$i]['product_id'] = $row['product_id'];
	$containers[$i]['qty'] = $row['qty'];
	$containers[$i]['color'] = $row['color'];
	$containers[$i]['piece'] = $row['piece'];
	$containers[$i]['custom'] = $row['custom'];
	$containers[$i]['container_date']=$row['container_date'];
	$containers[$i]['creation_date']=$row['creation_date'];
}

?>