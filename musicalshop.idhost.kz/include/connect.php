<?php

$connect = mysql_connect("localhost","root","") or die(mysql_error());
mysql_select_db("users");
mysql_query("SET names 'utf8';");
?>