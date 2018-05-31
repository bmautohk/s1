<?php
include("functions.php");

$db=connectDatabase();
mysql_select_db("autopart_db",$db);
mysql_query("update office_address set address2 = 'ÂçºåÉÜÀôÂçÄÅ»Ô', address3 = 'ÅìË­ÃæÄ®1-8-23-301' where id = 3;", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	mysql_close($db);
?>
