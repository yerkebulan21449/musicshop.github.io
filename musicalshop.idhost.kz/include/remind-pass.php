<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
   
include("connect.php");
include("../options/option.php");

$email = clear_string($_POST["email"]);

if ($email != "")
{
    
   $result = mysql_query("SELECT users_mail FROM users WHERE users_mail='$email'",$link);
If (mysql_num_rows($result) > 0)
{
    

    $newpass = fungenpass();
    

    $pass   = md5($newpass);
    $pass   = strrev($pass);
    $pass   = strtolower("9nm2rv8q".$pass."2yo6z");    
 

$update = mysql_query ("UPDATE users SET users_password='$pass' WHERE users_mail='$email'",$link);


mail($email, "Запрос на восстановление пароля", "Здравствуйте $login ваш новый пароль : $newpass");
   
   echo 'yes';
    
}else
{
    echo 'Данный E-mail не найден!';
}

}
else
{
    echo 'Укажите свой E-mail';
}

}



?>