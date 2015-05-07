<?/***************************************************************************
*                                news_edit_images.php
*                            ---------------------------
*   begin                : Sunday, May 1, 2005
*   copyright            : (C) 2003 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : File creation
*							 
*							
*
*   Id: news_edit_images.php,v 0.10 2004/05/01 ST Graveyard
*
***************************************************************************/

/*
***********************************************************************************
In this section we can delete/edit a newsimage
***********************************************************************************
*/

include("../includes/common.php"); 
include("../includes/config.php"); 

$sql_images = mysql_query("SELECT * FROM news_image");
	
while ( $news_images = mysql_fetch_array($sql_images) )
{
	$v_image  = $news_images_path;
	$v_image .= $news_images[news_image_id];
	$v_image .= '.';
	$v_image .= $news_images[news_image_ext];
	
	$smarty->append('news_images',
	    	 array('image_id' => $news_images[news_image_id],
				   'image_name' => $news_images[news_image_name],
				   'image_link' => $v_image));
}

if ($action=="delete_image")
{
	if(isset($news_image_id)) 
	{
		foreach($news_image_id as $image) 
		{
			$sql=mysql_query("SELECT news_image_ext FROM news_image WHERE news_image_id='$image'") or die("Couldn't query images");
		
			list($news_image_ext) = mysql_fetch_array($sql);
		
			mysql_query("DELETE FROM news_image WHERE news_image_id='$image'") or die("Couldn't delete image$news_image_id"); 
			
			unlink ("$news_images_path$image.$news_image_ext") or die("Couldn't delete image$news_image_id from server");
		}
	}
	else
	{
		$message="something is wrong with the image id";
	}
}


$smarty->assign('news_edit_images_tpl', '1');

//Send all smarty variables to the templates
$smarty->display('file:../templates/0/index.tpl');

//close the connection
mysql_close();
?>