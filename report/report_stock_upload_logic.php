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
		 
		
		$file = fopen($uplFile['tmp_name'],"r");
		
		$product_id_arr = array();
		$qty_arr=array();
	
		$i=0;
		
		//trucate table
		$sql = "TRUNCATE TABLE `inventory`  ";	
		mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute sql: $sql");
		
		
		while(! feof($file)){
			$row = fgetcsv($file, 1024);
		
			if($i>0){ 
				
				$prodVal = trim($row[0]);
				 
				$qtyVal = trim($row[1]);
			  
						
			  
						//update ben_check
						if($prodVal!="" &&$qtyVal!="" ){
						 $sql = "insert into inventory (product_id,qty) values ('$prodVal','$qtyVal') ";
						//echo $sql;
						//echo "<p>";
						mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute sql: $sql");
						$num_results=mysql_affected_rows();
				 
						}
					 
					 $product_id_arr[$i]=$prodVal;
					 $qty_arr[$i]=$qtyVal;
			}
			$i++;
		}
		$msg = "Upload Stock Inventory successfully!\\nNo. of inserted record: ".sizeof($product_id_arr);
	}

	
		
		
			
	 
	
	
}

// List out all active tracking no
//$trackingNos = array();
//$result = mysql_query("SELECT * FROM sagawa_tracking_no WHERE sts = 'A'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
//$num_results=mysql_num_rows($result);
//for ($i=0;$i<$num_results;$i++) {
	//$row = mysql_fetch_array($result);
	
//	$trackingNos[$i]['tracking_no'] = $row['tracking_no'];
//}

?>