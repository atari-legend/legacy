<?php
/***************************************************************************
*                                latest_news_tile.php
*                            ----------------------------
*   begin                : Tuesday, April 14, 2015
*   copyright            : (C) 2015 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : Creation of file
*
*   Id: latest_news_tile.php,v 0.1 2015/04/14 22:56 ST Graveyard
*   Id: latest_news_tile.php,v 0.2 2017/05/22 09:02 ST Graveyard
*           - added the [frontpage] functionality 
*
***************************************************************************/

//*********************************************************************************************
// This is the php code for the latest news tile
//*********************************************************************************************

//Select the news from the DB
$query_news = $mysqli->query("SELECT * FROM news
                           LEFT JOIN news_image ON (news.news_image_id = news_image.news_image_id)
                           ORDER BY news.news_date DESC LIMIT 6");

//Lets put all the acquired news data into a smarty array and send them to the template.
while ($sql_news = $query_news->fetch_array(MYSQLI_BOTH))
{
    $v_image  = $news_images_path;
    $v_image .= $sql_news['news_image_id'];
    $v_image .= '.';
    $v_image .= $sql_news['news_image_ext'];

    $news_text = $sql_news['news_text']; 
    
    $pos_start = strpos($news_text, '[frontpage]');
    $pos_start = $pos_start;
    
    $pos_end = strpos($news_text, '[/frontpage]');
    $pos_end = $pos_end;
    
    $nr_char = $pos_end - $pos_start;
    
    $news_text = substr($news_text, $pos_start, $nr_char);
    
    //fixxx the enters
    $news_text = nl2br($news_text);
    $news_text = InsertALCode($news_text); // disabled this as it wrecked the design.
    $news_text = trim($news_text);
    $news_text = RemoveSmillies($news_text);

    //convert the date to readible format
    $news_date = date("F j, Y",$sql_news['news_date']);

    $smarty->append('news',
        array('news_date' => $news_date,
          'news_headline' => $sql_news['news_headline'],
          'news_text' => $news_text,
          'image' => $v_image));
}
?>
