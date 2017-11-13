<?php	
	session_start();
	define('myeshop', true);
	include("include/connect.php");
	include("include/auth_cookie.php");
	include("options/option.php");

	$go = clear_string($_GET["go"]);
    
    switch ($go) {

	    case "news":     
	    $query_class= " WHERE items_visible = '1' AND items_new = '1'";
        $name_class = "Новинки";
	    break;

	    case "sale":
	    $query_class= " WHERE items_visible = '1' AND items_sale = '1'";
        $name_class = "Скидки";
	    break;
        
        
	    default:
        $query_class = "";  
	    break;
} 
	
	$sorting = $_GET["sort"];   
 
switch ($sorting)
{

		case 'price-up': 
		$sorting = 'items_price ASC';
		$sort_name = 'По возрастанию цены';	
		break;

		case 'price-down':
		$sorting = 'items_price DESC';
		$sort_name = 'По убыванию цены';	
		break;

		case 'popular':
		$sorting = 'items_count DESC';
		$sort_name = 'Популярное';	
		break;

		case 'news':
		$sorting = 'datetime DESC';
		$sort_name = 'Новинки';	
		break;

		case 'alph':
		$sorting = 'items_title DESC';
		$sort_name = 'от А до Я';	
		break;
	
		default:
		$sorting = 'items_id Desc';
		$sort_name = 'Нет сортировки';
		break;
	}

?>
		
<!DOCTYPE HTML>
<html>

<head>
	<meta http-equiv="content-type" content="text/html"/>
	<link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/reset.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
    <script type="text/javascript" src="js/jcarousellite_1.0.1.js"></script> 
    <script type="text/javascript" src="js/shop.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.min.js"></script>

    
    
    <title>Главная страница</title>
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
	if ($query_class != "") {
	
	
		
		$num =2; 
    $page = (int)$_GET['page'];              
    
	$count = mysql_query("SELECT COUNT(*) FROM items $query_class",$link);
    $temp = mysql_fetch_array($count);

	If ($temp[0] > 0)
	{  
	$tempcount = $temp[0];

	
	$total = (($tempcount - 1) / $num) + 1;
	$total =  intval($total);

	$page = intval($page);

	if(empty($page) or $page < 0) $page = 1;  
       
	if($page > $total) $page = $total;
	 
	$start = $page * $num - $num;

	$qury_start_num = " LIMIT $start, $num"; 
	}


	If ($temp[0] > 0)
	{

?>
<div id="block-sorting">	
			<p id="nav-main"><a href="index.php">Главная страница</a> \ <span><?php echo $name_class ?></span></p>
				<ul id="sort-list">
					<li>Вид: </li>	
					<li><img id="style-grid" src="/images/icon-grid.png"></li>
					<li><img id="style-list" src="/images/icon-list.png"></li>
					<li>Сортировать:</li>
					<li><a id="select-sort"><?php echo $sort_name;
					 ?></a>
						<ul id="sorting-list">
							<li><a href="view_class.php?go=<?php echo $go ?>&sort=price-up">По возрастанию цены</a></li>
							<li><a href="view_class.php?go=<?php echo $go ?>&sort=price-down">По убыванию цены</a></li>
							<li><a href="view_class.php?go=<?php echo $go ?>&sort=popular">Популярное</a></li>
							<li><a href="view_class.php?go=<?php echo $go ?>&sort=news">Новинки</a></li>
							<li><a href="view_class.php?go=<?php echo $go ?>&sort=alph">от А до Я</a></li>
						</ul>
					</li>
				</ul>
		</div>
		<ul id="block-tovar-grid">
<?php
$result = mysql_query("SELECT * FROM items $query_class ORDER by $sorting $qury_start_num", $link);  
				if (mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_array($result); 
 	 				do   
					{ 
						if  ($row["items_image"] != "" && file_exists("./uploads_images/".$row["items_image"]))
{
$img_path = './uploads_images/'.$row["items_image"];
$max_width = 200; 
$max_height = 200; 
 list($width, $height) = getimagesize($img_path); 
$ratioh = $max_height/$height; 
$ratiow = $max_width/$width; 
$ratio = min($ratioh, $ratiow); 
$width = intval($ratio*$width); 
$height = intval($ratio*$height);    
}else
{
$img_path = "/images/no-image.png";
$width = 110;
$height = 120;
}
    $query_reviews = mysql_query("SELECT * FROM reviews WHERE items_id = '{$row["items_id"]}' AND reviews_moderate='1'",$link);  
$count_reviews = mysql_num_rows($query_reviews);
  
  echo '
  
  <li>
	<div class="block-images-grid">
	<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/>
	</div>
		<p class="style-title-grid" ><a href="view_content.php?id='.$row["items_id"].'" >'.$row["items_title"].'</a></p>
			<ul class="reviews-and-counts-grid">
			<li><img src="/images/eye-icon.png" /><p>'.$row["items_count"].'</p></li>
			<li><img src="/images/comment-icon.png" /><p>'.$count_reviews.'</p></li>
			</ul>
		<a class="add-cart-style-grid" tid="'.$row["items_id"].'"></a>
		<p class="style-price-grid"><strong>'.group_numerals($row["items_price"]).'</strong> тг.</p>
		<div class="mini-features">
			'.$row["mini_features"].'
		</div>
   </li>';
  
  
  
    
}
    while ($row = mysql_fetch_array($result));
}


?>
		</ul>

		
		<ul id="block-tovar-list">
		<?php	 	
				$result = mysql_query("SELECT * FROM items $query_class ORDER by $sorting $qury_start_num" ,$link);  
				if (mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_array($result); 
 	 				do   
					{
						if  ($row["items_image"] != "" && file_exists("./uploads_images/".$row["items_image"]))
{
$img_path = './uploads_images/'.$row["items_image"];
$max_width = 150; 
$max_height = 150; 
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
$query_reviews = mysql_query("SELECT * FROM reviews WHERE items_id = '{$row["items_id"]}' AND reviews_moderate='1'",$link);  
$count_reviews = mysql_num_rows($query_reviews);
						echo '
						<li>

						<div class="block-images-list">
						<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/>
						</div>

						
						<ul class="reviews-and-counts-list">
						<li><img src="/images/eye-icon.png" /><p>'.$row["items_count"].'</p></li>
						<li><img src="/images/comment-icon.png" /><p>'.$count_reviews.'</p></li>
						</ul>
						<p class="style-title-list" ><a href="view_content.php?id='.$row["items_id"].'" >'.$row["items_title"].'</a></p>

						<a class="add-cart-style-list" tid="'.$row["items_id"].'"></a>
						<p class="style-price-list"><strong>'.group_numerals($row["items_price"]).'</strong> тг.</p>
						<div class="mini-features-list">
						'.$row["mini_description"].'
						</div>
						</li>';
					}
					while ($row = mysql_fetch_array($result));
			}

			echo '</ul>';
			 	}else{
			 		echo '<strong>Товаров нет!!!<strong>';
			 	}
	 } else{
	 	echo 'Категория не найдено!!!';
	 }

			if ($page != 1){ $pstr_prev = '<li><a class="pstr-prev" href="view_class.php?go='.$go.'&page='.($page - 1).'">&lt;</a></li>';}
if ($page != $total) $pstr_next = '<li><a class="pstr-next" href="view_class.php?go='.$go.'&page='.($page + 1).'">&gt;</a></li>';

			if($page - 5 > 0) $page5left = '<li><a href="iview_class.php?go='.$go.'&page='.($page - 5).'">'.($page - 5).'</a></li>';
if($page - 4 > 0) $page4left = '<li><a href="view_class.php?go='.$go.'&page='.($page - 4).'">'.($page - 4).'</a></li>';
if($page - 3 > 0) $page3left = '<li><a href="view_class.php?go='.$go.'&page='.($page - 3).'">'.($page - 3).'</a></li>';
if($page - 2 > 0) $page2left = '<li><a href="view_class.php?go='.$go.'&page='.($page - 2).'">'.($page - 2).'</a></li>';
if($page - 1 > 0) $page1left = '<li><a href="view_class.php?go='.$go.'&page='.($page - 1).'">'.($page - 1).'</a></li>';

if($page + 5 <= $total) $page5right = '<li><a href="view_class.php?go='.$go.'&page='.($page + 5).'">'.($page + 5).'</a></li>';
if($page + 4 <= $total) $page4right = '<li><a href="view_class.php?go='.$go.'&page='.($page + 4).'">'.($page + 4).'</a></li>';
if($page + 3 <= $total) $page3right = '<li><a href="view_class.php?go='.$go.'&page='.($page + 3).'">'.($page + 3).'</a></li>';
if($page + 2 <= $total) $page2right = '<li><a href="view_class.php?go='.$go.'&page='.($page + 2).'">'.($page + 2).'</a></li>';
if($page + 1 <= $total) $page1right = '<li><a href="view_class.php?go='.$go.'&page='.($page + 1).'">'.($page + 1).'</a></li>';
		


if ($page+5 < $total)
{
    $strtotal = '<li><p class="nav-point">...</p></li><li><a href="view_class.php?go='.$go.'&page='.$total.'">'.$total.'</a></li>';
}else
{
    $strtotal = ""; 
}

if ($total > 1)
{
    echo '
    <div class="pstrnav">
    <ul>
    ';
    echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='view_class.php?go='.$go.'&page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
    echo '
    </ul>
    </div>
    ';
}	
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