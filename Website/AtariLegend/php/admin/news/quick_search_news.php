<?php
/***************************************************************************
*                                quick_search_news.php
*                            -------------------------------
*   begin                : Tuesday, April 10, 2018
*   copyright            : (C) 2018 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: quick_search_news.php 10/04/2018 ST Graveyard - creation of file
*
***************************************************************************/

//Get the authors for the news post
$sql_author = $mysqli->query("SELECT news.user_id,
                                     users.userid 
                              FROM news 
                              LEFT JOIN users ON (users.user_id = news.user_id)
                              GROUP BY news.user_id
                              ORDER BY users.userid ASC") or die("Database error - getting members name");

while ($authors = $sql_author->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('authors_search', array(
        'user_id' => $authors['user_id'],
        'user_name' => $authors['userid']
    ));
}
