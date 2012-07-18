<?
require('../functions.php');
$msg = "You submission has been sent out successfully.";
if (isset($_POST['save'])) {

	$item = $_POST['item'];
	for ($i = 0; $i < count($item); $i++) {
		$prod_item[$i] = trim($item[$i]);
	}
	$sql = "INSERT INTO webadv SET
	 	  	email = '".trim($_POST['email'])."',
		 	item1 = '$prod_item[0]',
			item2 = '$prod_item[1]',
			item3 = '$prod_item[2]',
			item4 = '$prod_item[3]',
			item5 = '$prod_item[4]',
			contact_no = '".trim($_POST['contactNo'])."',
			sts = null,
			ip_addr = '".trim($_POST['ip'])."',
			user_agent = '".trim($_POST['referrer'])."'
			";
	sqlinsert($sql);
}
?>
