<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
include("connect.php");
include("../options/option.php");

$id = clear_string($_POST["id"]);

$result = mysql_query("SELECT * FROM korzina WHERE cart_id = '$id' AND cart_ip = '{$_SERVER['REMOTE_ADDR']}'",$link);
If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);    
$new_count = $row["cart_count"] + 1;
$update = mysql_query ("UPDATE korzina SET cart_count='$new_count' WHERE cart_id='$id' AND cart_ip = '{$_SERVER['REMOTE_ADDR']}'",$link);
echo $new_count;    
}
}
?>