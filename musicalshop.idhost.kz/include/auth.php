<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    
    include('connect.php');
    include('../options/option.php');
    
    $login = clear_string($_POST["login"]);
    
    $pass   = md5(clear_string($_POST["pass"]));
    $pass   = strrev($pass);
    $pass   = strtolower("9nm2rv8q".$pass."2yo6z");
    

    
    if ($_POST["rememberme"] == "yes")
    {

            setcookie('rememberme',$login.'+'.$pass,time()+3600*24*31, "/");

    }
   $result = mysql_query("SELECT * FROM users WHERE (users_login = '$login' OR users_mail = '$login') AND users_password = '$pass'",$link);
 If (mysql_num_rows($result) > 0)
{
    $row = mysql_fetch_array($result);
    
    $_SESSION['auth'] = 'yes_auth';
    $_SESSION['auth_name'] = $row["users_name"];
    $_SESSION['auth_surname'] = $row["users_surname"];
    $_SESSION['auth_email'] = $row["users_mail"];
    $_SESSION['auth_phone'] = $row["users_phone"];
    $_SESSION['auth_address'] = $row["users_address"];
    $_SESSION['auth_login'] = $row["users_login"]; 
    $_SESSION['auth_pass'] = $row["users_password"];
    echo 'yes_auth';

}else
{
    echo 'no_auth';
}  
} 

?>
