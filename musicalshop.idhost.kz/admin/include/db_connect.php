<?php
$db_host		= 'mysql370.cp.idhost.kz';
$db_user		= 'u1137539_admin';
$db_pass		= 'admin';
$db_database	= 'db1137539_shop'; 

$link = mysql_connect($db_host,$db_user,$db_pass);

mysql_select_db($db_database,$link) or die("Нет соединения с БД  ".mysql_error());
mysql_query("SET names 'utf8';");
?>