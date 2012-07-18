<?php
//include("../phpmailer/class.phpmailer.php");
include("class.phpmailer.php");
include("../functions.php");

$mail= new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; 
$mail->CharSet = "euc-jp";

$mail->Username = "superparts2010";
$mail->Password = "qwer1234";

$mail->From = "superparts2010@gmail.com";
$mail->FromName = "Superparts";

$current_path = $_SERVER['SERVER_NAME'];
//$template_path = "http://$current_path/superparts/webadv/webadv_email_template.php";
$template_path = "http://$current_path/webadv/webadv_email_template.php";

$db=connectDatabase();
mysql_select_db(DB_NAME,$db);
$sql = "SELECT * FROM webadv WHERE sts is null";

$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
$num_results=mysql_num_rows($result);
for ($i=0; $i<$num_results; $i++) {
	$row = mysql_fetch_array($result);
	
	$id = $row['id'];
	$email = $row['email'];
	
	$item1 = $row['item1'];
	$item2 = $row['item2'];
	$item3 = $row['item3'];
	$item4 = $row['item4'];
	$item5 = $row['item5'];
	
	// Get mail content
	$link = "$template_path?item1=$item1&item2=$item2&item3=$item3&item4=$item4&item5=$item5";
	$handle = @fopen($link, "rt");
	$source_code = fread($handle,9000);
	$mail->Body = $source_code;
	
	$mail->Subject = "Superparts Product";
	$mail->IsHTML(true);
	$mail->AddAddress($email, "Customer");

	echo "$id: ";
	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo."<br>";
		$sts = 'E';
	} else {
		echo "Message sent!<br>";
		$sts = 'C';	
	}
	// Update sts
	$upd_sql = "UPDATE webadv SET sts = '$sts' WHERE id = '$id'";
	$upd_result = mysql_query($upd_sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");

}

mysql_close($db);

?>
