<?php
session_start();
if ($_SESSION['auth_admin'] == "yes_auth")
{
  define('myeshop', true);
       
       if (isset($_GET["logout"]))
    {
        unset($_SESSION['auth_admin']);
        header("Location: login.php");
    }

  $_SESSION['urlpage'] = "<a href='index.php' >Главная</a>";
  
  include("include/db_connect.php");

?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="content-type" content="text/html" charset="utf8" />
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
  <title>Панель Управления</title>
</head>
<body>
<div id="block-body">
<?php
  include("include/block-header.php");
    
     // Общее количество заказов 
 $query1 = mysql_query("SELECT * FROM zakaz",$link);
 $result1 = mysql_num_rows($query1);
 // Общее количество товаров 
 $query2 = mysql_query("SELECT * FROM items",$link);
 $result2 = mysql_num_rows($query2);   
 // Общее количество отзывов 
 $query3 = mysql_query("SELECT * FROM reviews",$link);
 $result3 = mysql_num_rows($query3);
  // Общее количество клиентов 
 $query4 = mysql_query("SELECT * FROM users",$link);
 $result4 = mysql_num_rows($query4);
?>
<div id="block-content">
<div id="block-parameters">
<p id="title-page" >Общая статистика</p>
</div>

<ul id="general-statistics">
<li><p>Всего заказов - <span><?php echo $result1; ?></span></p></li>
<li><p>Товаров - <span><?php echo $result2; ?></span></p></li>
<li><p>Отзывы - <span><?php echo $result3; ?></span></p></li>
<li><p>Клиенты - <span><?php echo $result4; ?></span></p></li>
</ul>

<h3 id="title-statistics">Статистика продаж</h3>

<TABLE align="center" CELLPADDING="10" WIDTH="100%">
<TR>
<TH>Дата</TH>
<TH>Товар</TH>
<TH>Цена</TH>
<TH>Статус</TH>
</TR>


<?php

$result = mysql_query("SELECT * FROM zakaz,buy_products WHERE zakaz.zakaz_pay='accepted' AND zakaz.zakaz_id=buy_products.buy_id_order",$link);
 
 If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);
do
{

 $result2 = mysql_query("SELECT * FROM items WHERE items_id='{$row["buy_id_product"]}'",$link);    
  If (mysql_num_rows($result2) > 0)
{
 $row2 = mysql_fetch_array($result2);
}
    
$statuspay = "";
if ($row["zakaz_pay"] == "accepted") $statuspay = "Оплачено";

echo '
 <TR>
<TD  align="CENTER" >'.$row["zakaz_datetime"].'</TD>
<TD  align="CENTER" >'.$row2["items_title"].'</TD>
<TD  align="CENTER" >'.$row2["items_price"].'</TD>
<TD  align="CENTER" >'.$statuspay.'</TD>
</TR>
';

  }
     while ($row = mysql_fetch_array($result));
}     
?>

</TABLE>
</div>
</div>
</body>
</html>
<?php
}else
{
    header("Location: login.php");
}
?>