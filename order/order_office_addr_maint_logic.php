<?
$username = $_SESSION[user_name];

if (isset($_POST['doWhat'])) {
	$doWhat = $_POST['doWhat'];
	
	if ($doWhat == 'edit') {
		$name = trim($name);
		
		if (checkDuplicate($id, $name)) {
			$error_msg = 'Address ['.$name.'] has already existed!';
		}
		else {
			// Edit
			$sql = "UPDATE office_address SET
					name = '".$name."',
					address1 = '".trim($address1)."',
					address2 = '".trim($address2)."',
					address3 = '".trim($address3)."',
					post_acc_no = '".trim($post_acc_no)."',
					post_acc_name='".trim($post_acc_name)."'
					WHERE id = ".trim($id);
			sqlinsert($sql);
			
			if (isset($isDefault)) {
				$sql = "UPDATE authorize SET office_addr_id = ".$id." WHERE username = '".$username."'";
				sqlinsert($sql);
			}
			else if ($user_office_addr_id == $id) {
				$sql = "UPDATE authorize SET office_addr_id = NULL WHERE username = '".$username."'";
				sqlinsert($sql);
			}
			
			$success_msg = 'Update address ['.$name.'] successfully!';
		}
	}
	else if ($doWhat == 'add') {
		// Add
		$name = trim($name);
		
		if (checkDuplicate($id, $name)) {
			$error_msg = 'Address ['.$name.'] has already existed!';
		}
		else {
			// Edit
			$sql = "INSERT INTO office_address SET
					name = '".$name."',
					address1 = '".trim($address1)."',
					address2 = '".trim($address2)."',
					address3 = '".trim($address3)."',
					post_acc_no = '".trim($post_acc_no)."',
					post_acc_name= '".trim($post_acc_name)."'";
					
					
			sqlinsert($sql);
			
			// Get ID
			$sql_ins_id = "SELECT LAST_INSERT_ID() id FROM dual";
			$db=connectDatabase();
			mysql_select_db(DB_NAME,$db);
			$result = mysql_query($sql_ins_id,$db) or die (mysql_error()."<br />Couldn't execute query: $sql_ins_id");
			$row = mysql_fetch_array($result);
			$id = $row["id"];

			if (isset($isDefault)) {
				$sql = "UPDATE authorize SET office_addr_id = ".$id." WHERE username = '".$username."'";
				sqlinsert($sql);
			}
			
			$doWhat = 'edit';
			$success_msg = 'Create address ['.$name.'] successfully!';
		}
	}
	else if ($doWhat == 'delete') {
		$sql = "DELETE FROM office_address WHERE id = ".trim($id);
		sqlinsert($sql);
		
		$sql = "UPDATE authorize SET office_addr_id = NULL WHERE office_addr_id = '".$id."'";
		sqlinsert($sql);
		
		header('Location: order_office_addr.php?doWhat=delete&addr_name='.$name);
	}
}
else {
	if (isset($_GET['id'])) {
		// Edit
		$id = $_GET['id'];
		
		// List out all office address
		$sql = "SELECT * FROM office_address WHERE id = ".$id;
		$db=connectDatabase();
		mysql_select_db(DB_NAME,$db);
		$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
		$num_results=mysql_num_rows($result);
	
		$row=mysql_fetch_array($result);
		$id = $row["id"];
		$name = $row["name"];
		$address1 = $row["address1"];
		$address2 = $row["address2"];
		$address3 = $row["address3"];
		$post_acc_no = $row["post_acc_no"];
		$post_acc_name= $row["post_acc_name"];

		$user_office_addr_id = getUserDefaultOfficeAddrId($username);
		if ($id == $user_office_addr_id) {
			$isDefault = true;
		}
		
		$doWhat = 'edit';
	}
	else {
		// Add
		$doWhat = 'add';
	}
}

function checkDuplicate($id, $name) {
	
	if ($id != 0) {
		$sql = "SELECT * FROM office_address WHERE id <> ".$id." AND name = '".$name."'";
	}
	else {
		$sql = "SELECT * FROM office_address WHERE name = '".$name."'";
	}
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	$num_results=mysql_num_rows($result);
	
	if ($num_results > 0) {
		return true;
	}
	else {
		return false;
	}
}

?>
