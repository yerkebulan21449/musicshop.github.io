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

  $_SESSION['urlpage'] = "<a href='index.php' >Главная</a> \ <a href='view_order.php' >Просмотр заказов</a>";
  
  include("include/db_connect.php");
  include("include/functions.php"); 
 
  $id = clear_string($_GET["id"]);
  $action = $_GET["action"];
  
  if (isset($action))
{
   switch ($action) {

      case 'accept':
       if ($_SESSION['accept_orders'] == '1')
       {
                     $update = mysql_query("UPDATE zakaz SET zakaz_confirm='yes', zakaz_pay='accepted' WHERE zakaz_id = '$id'",$link);  
                     header("Location: orders.php"); 
       }else
        {
            $msgerror = 'У вас нет прав на подтверждение заказов!';
        }

      break;
        
        case 'delete':
        
        if ($_SESSION['delete_orders'] == '1')
        {
           $delete = mysql_query("DELETE FROM zakaz WHERE zakaz_id = '$id'",$link); 
           header("Location: orders.php");   
        }else
        {
            $msgerror = 'У вас нет прав на удаление заказов!';
        }
        case 'cancelled':
        
        if ($_SESSION['delete_orders'] == '1')
        {
           $cancel = mysql_query("UPDATE zakaz SET zakaz_confirm='no', zakaz_pay='cancelled' WHERE zakaz_id = '$id'",$link); 
           header("Location: orders.php");   
        }else
        {
            $msgerror = 'У вас нет прав на отмены заказов!';
        }
        


      break;
        
  } 
    
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf8" />
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="jquery_confirm/jquery_confirm.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
    <script type="text/javascript" src="js/script.js"></script> 
    <script type="text/javascript" src="jquery_confirm/jquery_confirm.js"></script> 
    
  <title>Панель Управления - Просмотр заказов</title>
</head>
<body>
<div id="block-body">
<?php
  include("include/block-header.php");
?>
<div id="block-content">
<div id="block-parameters">
<p id="title-page" >Просмотр заказа</p>
</div>
<?php
if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';


if ($_SESSION['view_orders'] == '1')
{

  $result = mysql_query("SELECT * FROM zakaz WHERE zakaz_id = '$id'",$link);
 
 If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);
do
{
if ($row["zakaz_confirm"] == 'yes')
{
    $status = '<span class="green">Обработан</span>';
} else
{
    $status = '<span class="red">Не обработан</span>';    
}


 echo '
  <p class="view-order-link" ><a class="green" href="view_order.php?id='.$row["zakaz_id"].'&action=accept" >Подтвердить заказ</a> | <a class="red" href="view_order.php?id='.$row["zakaz_id"].'&action=cancelled" >Отменить заказ</a> | <a class="delete" rel="view_order.php?id='.$row["zakaz_id"].'&action=delete" >Удалить заказ</a></p>
  <p class="order-datetime" >'.$row["zakaz_datetime"].'</p>
  <p class="order-number" >Заказ № '.$row["zakaz_id"].' - '.$status.'</p>

<TABLE align="center" CELLPADDING="10" WIDTH="100%">
<TR>
<TH>№</TH>
<TH>Наименование товара</TH>
<TH>Цена</TH>
<TH>Количество</TH>
</TR>
';
$query_product = mysql_query("SELECT * FROM buy_products,items WHERE buy_products.buy_id_order = '$id' AND items.items_id = buy_products.buy_id_product",$link);
 
$result_query = mysql_fetch_array($query_product);
do
{
$price = $price + ($result_query["items_price"] * $result_query["buy_count_product"]);    
$index_count =  $index_count + 1; 
echo '
 <TR>
<TD  align="CENTER" >'.$index_count.'</TD>
<TD  align="CENTER" >'.$result_query["items_title"].'</TD>
<TD  align="CENTER" >'.$result_query["items_price"].' тг</TD>
<TD  align="CENTER" >'.$result_query["buy_count_product"].'</TD>
</TR>

';
} while ($result_query = mysql_fetch_array($query_product));


if ($row["zakaz_pay"] == "accepted")
{
    $statpay = '<span class="green">Оплачено</span>';
}else
{
    $statpay = '<span class="red">Не оплачено</span>';
}

echo '
</TABLE>
<ul id="info-order">
<li>Общая цена - <span>'.$price.'</span> тг</li>
<li>Способ доставки - <span>'.$row["zakaz_dostavka"].'</span></li>
<li>Статус оплаты - '.$statpay.'</li>
<li>Тип оплаты - <span>'.$row["zakaz_type_pay"].'</span></li>
<li>Дата оплаты - <span>'.$row["zakaz_datetime"].'</span></li>
</ul>


<TABLE align="center" CELLPADDING="10" WIDTH="100%">
<TR>
<TH>ФИО</TH>
<TH>Адрес</TH>
<TH>Контакты</TH>
<TH>Примечание</TH>
</TR>

 <TR>
<TD  align="CENTER" >'.$row["zakaz_fio"].'</TD>
<TD  align="CENTER" >'.$row["zakaz_address"].'</TD>
<TD  align="CENTER" >'.$row["zakaz_phone"].'</br>'.$row["zakaz_email"].'</TD>
<TD  align="CENTER" >'.$row["zakaz_note"].'</TD>
</TR>
</TABLE>

 ';   
    
} while ($row = mysql_fetch_array($result));
}
    
}else
{
    echo '<p id="form-error" align="center">У вас нет прав на просмотр данного раздела!</p>';  
} 
?>
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