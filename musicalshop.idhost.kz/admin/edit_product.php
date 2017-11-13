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

  $_SESSION['urlpage'] = "<a href='index.php' >Главная</a> \ <a href='tovar.php' >Товары</a> \ <a>Изменение товара</a>";
  
  include("include/db_connect.php");
  include("include/functions.php"); 
  $id = clear_string($_GET["id"]);
  $action = clear_string($_GET["action"]);
if (isset($action))
{
   switch ($action) {

      case 'delete':
     
    if ($_SESSION['edit_tovar'] == '1')
    {
         
         if (file_exists("../uploads_images/".$_GET["img"]))
        {
          unlink("../uploads_images/".$_GET["img"]);  
        }
            
    }else
    {
       $msgerror = 'У вас нет прав на изменение товара!'; 
    }     
    
      break;

  } 
}
    if ($_POST["submit_save"])
    {
    if ($_SESSION['edit_tovar'] == '1')
    { 
      $error = array();
    
    // Проверка полей
        
       if (!$_POST["form_title"])
      {
         $error[] = "Укажите название товара";
      }
      
       if (!$_POST["form_price"])
      {
         $error[] = "Укажите цену";
      }
          
       if (!$_POST["form_category"])
      {
         $error[] = "Укажите категорию";         
      }else
      {
        $result = mysql_query("SELECT * FROM category WHERE id='{$_POST["form_category"]}'",$link);
        $row = mysql_fetch_array($result);
        $selectbrand = $row["brand"];

      }
 
 
        if (empty($_POST["upload_image"]))
      {        
      include("actions/upload-image.php");
      unset($_POST["upload_image"]);           
      } 
      
       if (empty($_POST["galleryimg"]))
      {        
      include("actions/upload-gallery.php"); 
      unset($_POST["galleryimg"]);                 
      }
      
 // Проверка чекбоксов
      
       if ($_POST["chk_visible"])
       {
          $chk_visible = "1";
       }else { $chk_visible = "0"; }
      
       if ($_POST["chk_new"])
       {
          $chk_new = "1";
       }else { $chk_new = "0"; }
      
      if ($_POST["chk_sale"])
       {
          $chk_sale = "1";
       }else { $chk_sale = "0"; }                   
      
                                      
       if (count($error))
       {           
            $_SESSION['message'] = "<p id='form-error'>".implode('<br />',$error)."</p>";
            
       }else
       {
                           
       $querynew = "items_title='{$_POST["form_title"]}',items_price='{$_POST["form_price"]}',items_brand='$selectbrand',key_words='{$_POST["form_seo_words"]}',key_description='{$_POST["form_seo_description"]}',mini_description='{$_POST["txt1"]}',items_description='{$_POST["txt2"]}',mini_features='{$_POST["txt3"]}',features='{$_POST["txt4"]}',items_new='$chk_new',items_sale='$chk_sale',items_visible='$chk_visible',items_type='{$_POST["form_type"]}',brand_id='{$_POST["form_category"]}'"; 
           
       $update = mysql_query("UPDATE items SET $querynew WHERE items_id = '$id'",$link); 
                   
      $_SESSION['message'] = "<p id='form-success'>Товар успешно изменен!</p>";
                
}
}
else
    {
       $msgerror = 'У вас нет прав на изменение товара!'; 
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
    <script type="text/javascript" src="./ckeditor/ckeditor.js"></script>  
  <title>Панель Управления</title>
</head>
<body>
<div id="block-body">
<?php
  include("include/block-header.php");
?>
<div id="block-content">
<div id="block-parameters">
<p id="title-page" >Добавление товара</p>
</div>
<?php
if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';

     if(isset($_SESSION['message']))
    {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
    }
        
     if(isset($_SESSION['answer']))
    {
    echo $_SESSION['answer'];
    unset($_SESSION['answer']);
    } 
?>
<?php
  $result = mysql_query("SELECT * FROM items WHERE items_id='$id'",$link);
    
If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);
do
{
    
echo '

<form enctype="multipart/form-data" method="post">
<ul id="edit-tovar">

<li>
<label>Название товара</label>
<input type="text" name="form_title" value="'.$row["items_title"].'" />
</li>

<li>
<label>Цена</label>
<input type="text" name="form_price" value="'.$row["items_price"].'"  />
</li>

<li>
<label>Ключевые слова</label>
<input type="text" name="form_seo_words" value="'.$row["key_words"].'"  />
</li>

<li>
<label>Краткое описание</label>
<textarea name="form_seo_description">'.$row["key_description"].'</textarea>
</li>
';    
    
$category = mysql_query("SELECT * FROM category",$link);
    
If (mysql_num_rows($category) > 0)
{
$result_category = mysql_fetch_array($category);

if ($row["items_type"] == "struna") $type_mobile = "selected";
if ($row["items_type"] == "udarnie") $type_notebook = "selected";
if ($row["items_type"] == "naduvnie") $type_notepad = "selected";



echo '
<li>
<label>Тип товара</label>
<select name="form_type" id="type" size="1" >

<option '.$type_mobile.' value="struna" >Струнные</option>
<option '.$type_notebook.' value="udarnie" >Ударные</option>
<option '.$type_notepad.' value="naduvnie" >Надувные</option>

</select>
</li>

<li>
<label>Категория</label>
<select name="form_category" size="10" >
';


do
{
  
  echo '
  
  <option value="'.$result_category["id"].'" >'.$result_category["brand"].'</option>
  
  ';
    
}
 while ($result_category = mysql_fetch_array($category));
}
echo '
</select>
</ul> 
';

   if  (strlen($row["items_image"]) > 0 && file_exists("../uploads_images/".$row["items_image"]))
{
$img_path = '../uploads_images/'.$row["items_image"];
$max_width = 110; 
$max_height = 110; 
 list($width, $height) = getimagesize($img_path); 
$ratioh = $max_height/$height; 
$ratiow = $max_width/$width; 
$ratio = min($ratioh, $ratiow); 
// New dimensions 
$width = intval($ratio*$width); 
$height = intval($ratio*$height); 

echo '
<label class="stylelabel" >Основная картинка</label>
<div id="baseimg">
<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
<a href="edit_product.php?id='.$row["items_id"].'&img='.$row["items_image"].'&action=delete" ></a>
</div>

';
   
}else
{  
echo '
<label class="stylelabel" >Основная картинка</label>

<div id="baseimg-upload">
<input type="hidden" name="MAX_FILE_SIZE" value="5000000"/>
<input type="file" name="upload_image" />

</div>
';
}

echo '
<h3 class="h3click" >Краткое описание товара</h3>
<div class="div-editor1" >
<textarea id="editor1" name="txt1" cols="100" rows="20">'.$row["mini_description"].'</textarea>
    <script type="text/javascript">
      var ckeditor1 = CKEDITOR.replace( "editor1" );
      ajexFileManager.init({
        returnTo: "ckeditor",
        editor: ckeditor1
      });
    </script>
 </div>       
 
<h3 class="h3click" >Описание товара</h3>
<div class="div-editor2" >
<textarea id="editor2" name="txt2" cols="100" rows="20">'.$row["mini_description"].'</textarea>
    <script type="text/javascript">
      var ckeditor1 = CKEDITOR.replace( "editor2" );
      ajexFileManager.init({
        returnTo: "ckeditor",
        editor: ckeditor1
      });
    </script>
 </div>          

<h3 class="h3click" >Краткие характеристики</h3>
<div class="div-editor3" >
<textarea id="editor3" name="txt3" cols="100" rows="20">'.$row["mini_features"].'</textarea>
    <script type="text/javascript">
      var ckeditor1 = CKEDITOR.replace( "editor3" );
      ajexFileManager.init({
        returnTo: "ckeditor",
        editor: ckeditor1
      });
    </script>
 </div>        

<h3 class="h3click" >Характеристики</h3>
<div class="div-editor4" >
<textarea id="editor4" name="txt4" cols="100" rows="20">'.$row["features"].'</textarea>
    <script type="text/javascript">
      var ckeditor1 = CKEDITOR.replace( "editor4" );
      ajexFileManager.init({
        returnTo: "ckeditor",
        editor: ckeditor1
      });
    </script>
  </div> 


 
 ';
 


if ($row["visible"] == '1') $checked1 = "checked";
if ($row["new"] == '1') $checked2 = "checked";
if ($row["sale"] == '1') $checked4 = "checked";
 

echo ' 
<h3 class="h3title" >Настройки товара</h3>   
<ul id="chkbox">
<li><input type="checkbox" name="chk_visible" id="chk_visible" '.$checked1.' /><label for="chk_visible" >Показывать товар</label></li>
<li><input type="checkbox" name="chk_new" id="chk_new" '.$checked2.' /><label for="chk_new" >Новый товар</label></li>
<li><input type="checkbox" name="chk_sale" id="chk_sale" '.$checked4.' /><label for="chk_sale" >Товар со скидкой</label></li>
</ul> 


    <p align="right" ><input type="submit" id="submit_form" name="submit_save" value="Сохранить"/></p>     
</form>
';

}while ($row = mysql_fetch_array($result));
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