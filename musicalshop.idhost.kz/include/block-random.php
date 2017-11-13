<div id="block-random-tovar">
<ul>
<?php
	
$query_random = mysql_query("SELECT DISTINCT * FROM items WHERE items_visible='1' ORDER by RAND() LIMIT 3",$link);  

If (mysql_num_rows($query_random) > 0)
{
$res_query = mysql_fetch_array($query_random);
do
{
    
    
    
    
if  (strlen($res_query["items_image"]) > 0 && file_exists("./uploads_images/".$res_query["items_image"]))
{
$img_path = './uploads_images/'.$res_query["items_image"];
$max_width = 120; 
$max_height = 120; 
 list($width, $height) = getimagesize($img_path); 
$ratioh = $max_height/$height; 
$ratiow = $max_width/$width; 
$ratio = min($ratioh, $ratiow); 

$width = intval($ratio*$width); 
$height = intval($ratio*$height);    
}else
{
$img_path = "/images/no-image-65.png";
$width = 65;
$height = 118;
}       
$query_reviews = mysql_query("SELECT * FROM reviews WHERE reviews_id = {$res_query["items_id"]} AND reviews_moderate='1'",$link);  
    $count_reviews = mysql_num_rows($query_reviews);
echo '
<ul id="setting-li">
<li>
<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
<a class="random-title" href="view_content.php?id='.$res_query["items_id"].'">'.$res_query["items_title"].'</a>
<p class="random-price">'.group_numerals($res_query["items_price"]).'</p>
<a class="random-add-cart" tid="'.$res_query["items_id"].'"></a>
</li>
</ul>
';

} while($res_query = mysql_fetch_array($query_random));
}
?>
</ul>
</div>