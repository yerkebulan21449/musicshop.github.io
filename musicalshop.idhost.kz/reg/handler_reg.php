<?php
 if($_SERVER["REQUEST_METHOD"] == "POST")
{ 
  session_start();
 include("../include/connect.php");
 include("../options/option.php");
 
     $error = array();
         
        $name = iconv("UTF-8", "utf-8",clear_string($_POST['reg_name'])); 
        $surname = iconv("UTF-8", "utf-8",clear_string($_POST['reg_surname'])); 
        $email = iconv("UTF-8", "utf-8",clear_string($_POST['reg_email'])); 
        $phone = iconv("UTF-8", "utf-8",clear_string($_POST['reg_phone'])); 
        $address = iconv("UTF-8", "utf-8",clear_string($_POST['reg_address'])); 
        $login = iconv("UTF-8", "utf-8",strtolower(clear_string($_POST['reg_login']))); 
        $pass = iconv("UTF-8", "utf-8",strtolower(clear_string($_POST['reg_pass']))); 
        
 
    if (strlen($login) < 5 or strlen($login) > 15)
    {
       $error[] = "Укажите От 5 до 15 символов!"; 
    }
    else
    {   
     $result = mysql_query("SELECT users_login FROM users WHERE users_login = '$login'",$link);
    If (mysql_num_rows($result) > 0)
    {
       $error[] = "Логин занят!";
    }
            
    }
     
    if (strlen($name) < 3 or strlen($name) > 15) $error[] = "Укажите Имя от 3 до 15 символов!";
    if (strlen($surname) < 3 or strlen($surname) > 20) $error[] = "Укажите Фамилию от 3 до 20 символов!";
    if (!$phone) $error[] = "Укажите номер телефона!";
    if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",trim($email))) $error[] = "Укажите корректный email!";
    if (!$address) $error[] = "Необходимо указать адрес доставки!";
    if (strlen($pass) < 7 or strlen($pass) > 15) $error[] = "Укажите пароль от 7 до 15 символов!";
    
    if($_SESSION['img_captcha'] != strtolower($_POST['reg_captcha'])) $error[] = "Неверный код с картинки!";
    unset($_SESSION['img_captcha']);
    
   if (count($error))
   {
    
 echo implode('<br />',$error);
     
   }else
   {   
        $pass   = md5($pass);
        $pass   = strrev($pass);
        $pass   = strtolower("9nm2rv8q".$pass."2yo6z");
        
        $ip = $_SERVER['REMOTE_ADDR'];
		
		mysql_query("	INSERT INTO users(users_name, users_surname, users_mail, users_phone, users_address, users_login, users_password, users_datetime, users_ip)
						VALUES(
							
						            	'".$name."',
                            '".$surname."',
                            '".$email."',
                            '".$phone."',
                            '".$address."',
                            '".$login."',
                            '".$pass."',
                            NOW(),
                            '".$ip."'							
						)",$link);

 echo 'true';
 } 

}
?>

