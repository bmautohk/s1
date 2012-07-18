<?
//check for authority to view this page
if (allow_access(@Administrators) != "yes")
{
	echo "not authorized to perform this function";
}

//make the connection to the database
$connection = @mysql_connect($server, $dbusername, $dbpassword) or die(mysql_error());
$db = @mysql_select_db($db_name,$connection)or die(mysql_error());

//make query to database
$sql ="SELECT * FROM $table_name WHERE username= '$_POST[username]'";
$result = @mysql_query($sql,$connection) or die(mysql_error());

//get the number of rows in the result set
$num = mysql_num_rows($result);

//check if that username already exists
if ($num != 0){

echo "<P>Sorry, that username already exists.</P>";
echo "<P><a href=\"#\" onClick=\"history.go(-1)\">Try Another Username.</a></p>";
echo "$_POST[username]";
exit;

}else{

//or add it to the database
$sql_add = "INSERT INTO $table_name VALUES
			('$_POST[firstname]', '$_POST[lastname]', '$_POST[username]', '$_POST[password]', 
			'$_POST[group1]', '$_POST[group2]', '$_POST[group3]', '$_POST[pchange]', '$_POST[email]',
			'$_POST[redirect]', '1', 'last_login()', '','')";

$result = @mysql_query($sql_add,$connection) or die(mysql_error());
}

if ($_POST[@email_user] == "Yes")
{
	$mailheaders = "From: $domain\n";
	$mailheaders .= "Dear $_POST[firstname] $_POST[lastname],\n";
	$mailheaders .= "\n";
	$mailheaders .= "An account has been created for you at $domain.\n";
	$mailheaders .= "Please log in with the following account information:\n";
	$mailheaders .= "Username: $_POST[username]\n";
	$mailheaders .= "Password: $_POST[password]\n";
	$mailheaders .= "\n";
	$mailheaders .= "Please login at:\n";
	$mailheaders .= "$base_dir/login.html\n";
	$mailheaders .= "Should you have any complications, please email the System Administrator at:\n";
	$mailheaders .= "$adminemail\n";

	$to = "$_POST[email]";
	$subject = "Your account has been created !!";

	mail($to, $subject, $mailheaders, "From: No Reply <$adminemail>\n");

}
?>
<? include_once("admin_add_js.php");
