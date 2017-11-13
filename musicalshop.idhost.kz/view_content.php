<?php	
	session_start();
	define('myeshop', true);
	include("include/connect.php");
	include("include/auth_cookie.php");
	include("options/option.php");

	
	
	 $id = clear_string($_GET["id"]); 

  
  If ($id != $_SESSION['countid'])
{
$querycount = mysql_query("SELECT items_count FROM items WHERE items_id='$id'",$link);
$resultcount = mysql_fetch_array($querycount); 

$newcount = $resultcount["items_count"] + 1;

$update = mysql_query ("UPDATE items SET items_count='$newcount' WHERE items_id='$id'",$link);  
}

$_SESSION['countid'] = $id; 
?>
		
<!DOCTYPE HTML>
<html>

<head>
	<meta http-equiv="content-type" content="text/html"/>
	<link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css">
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
    <script type="text/javascript" src="js/jcarousellite_1.0.1.js"></script> 
    <script type="text/javascript" src="js/shop.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.min.js"></script>
    <script type="text/javascript" src="js/jTabs.js"></script>
    <script type="text/javascript" src="fancybox/jquery.fancybox.js"></script>
    
    
    <title>Интернет-магазин музыкальных инструментов</title>
    <script type="text/javascript">
$(document).ready(function(){
 
    $("ul.tabs").jTabs({content: ".tabs_content", animate: true, effect:"fade"}); 
     $(".send-review").fancybox();
    
	
});	
</script> 
</head>

<body>

<div id="block-body">
			<?php
				include("include/block-header.php");
			?>
		<div id="block-right">
			<?php
				include("include/block-category.php");
				include("include/block-news.php");
			?>

		</div>
			<div id="block-content">
<?php
$result1 = mysql_query("SELECT * FROM items WHERE items_id='$id' AND items_visible='1'",$link);
If (mysql_num_rows($result1) > 0)
{
$row1 = mysql_fetch_array($result1);
do
{   
if  (strlen($row1["items_image"]) > 0 && file_exists("./uploads_images/".$row1["items_image"]))
{
$img_path = './uploads_images/'.$row1["items_image"];
$max_width = 150; 
$max_height = 250; 
 list($width, $height) = getimagesize($img_path); 
$ratioh = $max_height/$height; 
$ratiow = $max_width/$width; 
$ratio = min($ratioh, $ratiow); 
$width = intval($ratio*$width); 
$height = intval($ratio*$height);    
}else
{
$img_path = "/images/noimages80x70.png";
$width = 80;
$height = 70;
}     

// Количество отзывов 
$query_reviews = mysql_query("SELECT * FROM reviews WHERE items_id = '$id' AND reviews_moderate='1'",$link);  
$count_reviews = mysql_num_rows($query_reviews);


echo  '

<div id="block-breadcrumbs-and-rating">
<p id="nav-breadcrumbs2"><a href="index.php">Главная страница</a> \ <span>'.$row1["items_brand"].'</span></p>


<div id="block-content-info">

<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />

<div id="block-mini-description">

<p id="content-title">'.$row1["items_title"].'</p>

<ul class="reviews-and-counts-content">
<li><img src="/images/eye-icon.png" /><p>'.$row1["items_count"].'</p></li>
<li><img src="/images/comment-icon.png" /><p>'.$count_reviews.'</p></li>
</ul>


<p id="style-price" >'.group_numerals($row1["items_price"]).' тг</p>

<a class="add-cart" id="add-cart-view" tid="'.$row1["items_id"].'" ></a>

<p id="content-text">'.$row1["mini_description"].'</p>

</div>

</div>

';

   
}
 while ($row1 = mysql_fetch_array($result1));


 
}

$result = mysql_query("SELECT * FROM items WHERE items_id='$id' AND items_visible='1'",$link);
$row = mysql_fetch_array($result);

echo '

<ul class="tabs">
    <li><a class="active" href="#" >Описание</a></li>
    <li><a class="active" href="#" >Характеристики</a></li>
    <li><a href="#" >Отзывы</a></li>   
</ul>

<div class="tabs_content">

<div>'.$row["items_description"].'</div>
<div>'.$row["features"].'</div>
<div>
<p id="link-send-review" ><a class="send-review" href="#send-review" >Написать отзыв</a></p>
';

$query_reviews = mysql_query("SELECT * FROM reviews WHERE items_id='$id' AND reviews_moderate='1' ORDER BY reviews_id DESC",$link);

If (mysql_num_rows($query_reviews) > 0)
{
$row_reviews = mysql_fetch_array($query_reviews);
do
{

echo '
<div class="block-reviews" >
<p class="author-date" ><strong>'.$row_reviews["name"].'</strong>, '.$row_reviews["reviews_date"].'</p>
<img src="/images/plus-reviews.png" />
<p class="textrev" >'.$row_reviews["good_reviews"].'</p>
<img src="/images/minus-reviews.png" />
<p class="textrev" >'.$row_reviews["bad_reviews"].'</p>

<p class="text-comment">'.$row_reviews["comment"].'</p>
</div>

';
        
}
 while ($row_reviews = mysql_fetch_array($query_reviews));
}
else
{
    echo '<p class="title-no-info" >Отзывов нет</p>';
} 



echo '
</div>

</div>


    <div id="send-review" >
    
    <p align="right" id="title-review">Публикация отзыва производится после модерации.</p>
    
    <ul>
    <li><p align="right"><label id="label-name" >Имя<span>*</span></label><input maxlength="15" type="text"  id="name_review" /></p></li>
    <li><p align="right"><label id="label-good" >Достоинства<span>*</span></label><textarea id="good_review" ></textarea></p></li>    
    <li><p align="right"><label id="label-bad" >Недостатки<span>*</span></label><textarea id="bad_review" ></textarea></p></li>     
    <li><p align="right"><label id="label-comment" >Комментарий</label><textarea id="comment_review" ></textarea></p></li>     
    </ul>
    <p id="reload-img"><img src="/images/loading.gif"/></p> <p id="button-send-review" iid="'.$id.'" ></p>
    </div>



';


	
?>
</div>
	
		<?php
		include("include/block-random.php");
			include("include/block-footer.php");
		?>		
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'h66npP17fS';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->
</div>



</body>

</html>