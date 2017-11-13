<div id="block-news">

<center><img id="news-prev" src="/images/img-prev.png"></center>

<div id="news">
<ul>

<?php	
  				$result = mysql_query("SELECT * FROM news Order BY news_id DESC" ,$link);  
				if (mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_array($result); 
 	 				do   
					{
						echo'
						<li>
							<span>'.$row["news_date"].'</span>
							<a href="">'.$row["news_title"].'</a>
							<p>'.$row["news_text"].'</p>
							</li>
							';
					}
while ($row = mysql_fetch_array($result));
			}
		?>

</ul>
</div>
<center><img id="news-next" src="/images/img-next.png"></center>

</div>



	