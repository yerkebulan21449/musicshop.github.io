<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
 define('myeshop', true);   
 include("connect.php");
 include("../options/option.php");

 $id = clear_string($_POST['id']);
 $name = iconv("UTF-8", "UTF-8",clear_string($_POST['name']));
 $good = iconv("UTF-8", "UTF-8",clear_string($_POST['good']));
 $bad =  iconv("UTF-8", "UTF-8",clear_string($_POST['bad']));
 $comment =  iconv("UTF-8", "UTF-8",clear_string($_POST['comment']));

    		mysql_query("INSERT INTO reviews(items_id,name,good_reviews,bad_reviews,comment,reviews_date)
						VALUES(						
                            '".$id."',
                            '".$name."',
                            '".$good."',
                            '".$bad."',
                            '".$comment."',
                             NOW()							
						)",$link);	

echo 'yes';
}
?>