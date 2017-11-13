<div id="block-category">

<p class="header-title">Категория инструментов</p>

<ul id="category">

<li><a id="index1"><img src="/images/icon1.png" id="icon_images" />&nbsp&nbsp&nbsp&nbspСтрунные</a>
<ul class="category-section">
<li><a href="view.php?type=Струнные"><strong>Все инструменты</strong></a></li>

<?php

  $result = mysql_query("SELECT * FROM category WHERE type='Струнные'",$link);
  
 If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);
do
{
	echo '
    
  <li><a href="view.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>
    
    ';
}
 while ($row = mysql_fetch_array($result));
} 
	
?>


</ul>
</li>

<li><a id="index2"><img src="/images/icon2.png" id="icon_images_2" />&nbsp&nbsp&nbsp&nbspНадувные</a>
<ul class="category-section">
<li><a href="view.php?type=Надувные"><strong>Все инструменты</strong></a></li>

<?php

  $result = mysql_query("SELECT * FROM category WHERE type='Надувные'",$link);
  
 If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);
do
{
	echo '
    
  <li><a href="view.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>
    
    ';
}
 while ($row = mysql_fetch_array($result));
} 
	
?>



</ul>
</li>

<li><a id="index3"><img src="/images/icon4.png" id="icon_images_4" />&nbsp&nbsp&nbsp&nbspУдарные</a>
<ul class="category-section">
<li><a href="view.php?type=Ударные"><strong>Все инструменты</strong></a></li>
<?php

  $result = mysql_query("SELECT * FROM category WHERE type='Ударные'",$link);
  
 If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);
do
{
	echo '
    
  <li><a href="view.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>
    
    ';
}
 while ($row = mysql_fetch_array($result));
} 
	
?>

</ul>
</li>

</ul>

</div>