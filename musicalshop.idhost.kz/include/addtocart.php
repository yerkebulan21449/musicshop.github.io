<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
include("connect.php");
include("../options/option.php");
        
$id = clear_string($_POST["id"]);

$result = mysql_query("SELECT * FROM korzina WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND cart_id_items = '$id'",$link);
If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);    
$new_count = $row["cart_count"] + 1;
$update = mysql_query ("UPDATE korzina SET cart_count='$new_count' WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND cart_id_items ='$id'",$link);   
}
else
{
    $result = mysql_query("SELECT * FROM items WHERE items_id = '$id'",$link);
    $row = mysql_fetch_array($result);
    
    		mysql_query("INSERT INTO korzina(cart_id_items,cart_price,cart_datetime,cart_ip)
						VALUES(	
                            '".$row['items_id']."',
                            '".$row['items_price']."',					
							NOW(),
                            '".$_SERVER['REMOTE_ADDR']."'                                                                        
						    )",$link);	
}
}
?>