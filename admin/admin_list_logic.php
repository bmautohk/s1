<?php
//make connection to dbase
$connection = @mysql_connect($server, $dbusername, $dbpassword)
			or die(mysql_error());
			
$db = @mysql_select_db($db_name,$connection)
			or die(mysql_error());

//build and issue the query
$sql ="SELECT * FROM $table_name";
$result = @mysql_query($sql,$connection) or die(mysql_error());
 include("admin_list_js.php");
 ?>