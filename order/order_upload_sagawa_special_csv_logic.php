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
		
		$trackingNos = array();
	 
		$i=0;$j=0;$k=0;
		while(! feof($file)){
			$row = fgetcsv($file, 1024);
		 
				$sagawa_item_cellVal = trim($row[0]);
				//echo "sagawa_tracking_no_cellVal=".$sagawa_tracking_no_cellVal;
				 
						//update ben_check
						if($sagawa_item_cellVal!=""  ){
							
							
							
							 $sql = "update product set  	sagawa_label = 'Y' where product_id='$sagawa_item_cellVal'";
							//echo $sql;
						//	echo "<p>";
							mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute sql: $sql");
							$num_results=mysql_affected_rows();
							
							
							
							$sql = "select sagawa_label from product where sagawa_label = 'Y' and product_id='$sagawa_item_cellVal'";
							//echo $sql;
						//	echo "<p>";
							$result=mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute sql: $sql");
							$num_results=mysql_affected_rows();
							if ($num_results==1){
									$row2=mysql_fetch_array($result);
									if ($row2['sagawa_label']=='Y'){
										$trackingNos[$i] = $sagawa_item_cellVal;
										$i++;
									}
									else
									{
									$notOK[$j]= $sagawa_item_cellVal;
									$j++;
									}
							}else{
								$notExist[$k]= $sagawa_item_cellVal;
								$k++;
							}
							
							
							$sql = "select * from product where sagawa_label = 'N' and product_id='$sagawa_item_cellVal'";
							//echo $sql;
							//	echo "<p>";
							mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute sql: $sql");
							$num_results=mysql_affected_rows();
							if ($num_results==1){
									
							}
								
					 		
							
						}
				 
		 
		}
		$msg = "Upload sagawa special product successfully!\\nNo. of inserted record: ".sizeof($trackingNos);
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