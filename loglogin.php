<?

session_start();

//include config file
include ('config.php');

//sets date and time variables
$last = gmdate("Y-m-d");
$time = gmdate("H:i", time() + $zone);

$viewer = $HTTP_USER_AGENT;

//checks to see if the browser the user is using is determinable
$brower = "unknown";
if (preg_match("/MSIE/", $viewer))
{
	$browser = "Internet Explorer";
}
else if (preg_match("/Netscape/", $viewer))
{
	$browser = "Netscape";
}
else if (preg_match("/Opera/", $viewer))
{
	$browser = "Opera";
}

//checks to see if the OS the user is using is determinable
$platform = "unknown";
if (preg_match("/Windows/", $viewer))
{
	$platform = "Windows";
}
else if (preg_match("/Linux/", $viewer))
{
	$platform = "Linux";
}
else if (preg_match("/Mac/", $viewer))
{
	$platform = "MAC";
}

//make the connection to the database
$connection = @mysql_connect($server, $dbusername, $dbpassword) or die(mysql_error());
$db = @mysql_select_db($db_name,$connection)or die(mysql_error());
		
//build and issue the query
$sql ="INSERT INTO log_login VALUES
	('$_SESSION[user_name]', '$last', '$time', '$REMOTE_ADDR', '$platform', '$browser')";
$result = @mysql_query($sql,$connection) or die(mysql_error());


?>