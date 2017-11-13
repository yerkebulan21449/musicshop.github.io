<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{ 
   
include("../include/connect.php");
include("../options/option.php");

$login = clear_string($_POST['reg_login']);

$result = mysql_query("SELECT users_login FROM users WHERE users_login = '$login'",$link);
If (mysql_num_rows($result) > 0)
{
   echo 'false';
}
else
{
   echo 'true'; 
}
}
?>