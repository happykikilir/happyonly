<?php
if($dbc = mysql_connect("localhost", "songgenlei_root", "19850903song")) {
	mysql_query("SET NAMES 'UTF8'");
	mysql_select_db("songgenlei_blog", $dbc);
	
	mysql_query("alter table comment add column nickname varchar(100) not null after username");
    
	//mysql_query($sql,$dbc);
	
	mysql_close($dbc);
}
?>