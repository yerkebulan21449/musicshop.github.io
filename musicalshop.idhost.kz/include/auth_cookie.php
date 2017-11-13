<?php

 if ($_SESSION['auth'] != 'yes_auth' && $_COOKIE["rememberme"])
  {
    
  $str = $_COOKIE["rememberme"];
  
  
  $all_len = strlen($str);
  
  $login_len = strpos($str,'+'); 
 
  $login = clear_string(substr($str,0,$login_len));
  
  $pass = clear_string(substr($str,$login_len+1,$all_len));

  
     $result = mysql_query("SELECT * FROM users WHERE (users_login = '$login' or users_mail = '$login') AND users_password = '$pass'",$link);
If (mysql_num_rows($result) > 0)
{
    $row = mysql_fetch_array($result);
   session_start();
    $_SESSION['auth'] = 'yes_auth';
    $_SESSION['auth_name'] = $row["users_name"];
    $_SESSION['auth_surname'] = $row["users_surname"];
    $_SESSION['auth_email'] = $row["users_mail"];
    $_SESSION['auth_phone'] = $row["users_phone"];
    $_SESSION['auth_address'] = $row["users_address"];
    $_SESSION['auth_login'] = $row["users_login"]; 
    $_SESSION['auth_pass'] = $row["users_password"];
}
  
  
  
  }
?>