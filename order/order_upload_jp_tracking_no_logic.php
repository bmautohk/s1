<?php
require_once 'Classes/PHPExcel/IOFactory.php';

$action = $_POST['action'];

$db=connectDatabase();
mysql_select_db(DB_NAME,$db);

$duplicateTrackingNos = array();

if ($action == 'Upload') {
	// Upload JP tracking no
	$uplFile = $_FILES["uplFile"];
	
	if ($uplFile != "") {
		$objReader = PHPExcel_IOFactory::createReader('CSV');
		$objPHPExcel = $objReader->load($uplFile['tmp_name']);
		
		$trackingNos = array();
		$updTackingNos = array();
		$worksheet = $objPHPExcel->getActiveSheet();
		foreach ($worksheet->getRowIterator() as $row) {
			$rowNo = $row->getRowIndex();
			$cell = $worksheet->getCellByColumnAndRow(0, $rowNo);
			
			$cellVal = trim($cell->getValue());
			if ($cellVal != "") {
				// Check whether tracking no has already existed
				if (isset($trackingNos[$cellVal])) {
					$duplicateTrackingNos[] = $cellVal;
				}
				else {
					$result = mysql_query("SELECT 1 FROM jp_tracking_no WHERE tracking_no = '$cellVal'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
					$num_results=mysql_num_rows($result);
					if ($num_results > 0) {
						$updTackingNos[] = $cellVal;
					}
					else {
						$trackingNos[$cellVal] = $cellVal;
					}
				}
			}
		}
	}

	if (sizeOf($duplicateTrackingNos) == 0) {
		// No duplicate tracking no is found
		$userName = $_SESSION['user_name'];
		foreach ($trackingNos as $trackingNo) {
			$sql = "insert into jp_tracking_no (tracking_no, created_by, creation_date, last_upd_by, last_upd_date) values ('$trackingNo', '$userName', now(), '$userName', null) ";
			sqlinsert($sql);
		}
		
		foreach ($updTackingNos as $trackingNo) {
			$sql = "update jp_tracking_no set sts = 'A' where tracking_no = '$trackingNo' ";
			sqlinsert($sql);
		}
		
		$msg = "Upload tracking no successfully!\\nNo. of inserted record: ".sizeof($trackingNos)."\\nNo. of updated record: ".sizeof($updTackingNos);
	}
	else {
		$msg = "Fail to upload tracking no. Duplicate tracking no is found!";
	}
}

// List out all active tracking no
$trackingNos = array();
$result = mysql_query("SELECT * FROM jp_tracking_no WHERE sts = 'A'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
$num_results=mysql_num_rows($result);
for ($i=0;$i<$num_results;$i++) {
	$row = mysql_fetch_array($result);
	
	$trackingNos[$i]['tracking_no'] = $row['tracking_no'];
}

?>