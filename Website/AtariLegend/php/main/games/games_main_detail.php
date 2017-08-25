<?php
/***************************************************************************
 *                                games_main_detail.php
*                            ------------------------------
*   begin                : Thursday, 20 July, 2017
*   copyright            : (C) 2017 Atari Legend
*   email                : martens_maarten@hotmail.com
*
*   Id: games_main_detail.php,v 0.10 20/07/2017 17:37 STG 
****************************************************************************/

//****************************************************************************************
// This is the detail page of a game. 
//****************************************************************************************

//load all common functions
include("../../config/common.php");

//***********************************************************************************
//Let's get the general game info first.
//***********************************************************************************
$sql_game = $mysqli->query("SELECT game_name,
               game.game_id,
               game_free.free,
               game_development.development,
               game_unreleased.unreleased,
               game_ste_only.ste_only,
               game_ste_enhan.ste_enhanced,
               game_falcon_only.falcon_only,
               game_falcon_enhan.falcon_enhanced,
               game_falcon_rgb.falcon_rgb,
               game_falcon_vga.falcon_vga,
               game_unfinished.unfinished,
               game_mono.monochrome,
               game_wanted.game_wanted_id,
               game_arcade.arcade,
               game_seuck.seuck,
               game_stos.stos,
               game_stac.stac
               FROM game
               LEFT JOIN game_free ON (game.game_id = game_free.game_id)
               LEFT JOIN game_unreleased ON (game.game_id = game_unreleased.game_id)
               LEFT JOIN game_development ON (game.game_id = game_development.game_id)
               LEFT JOIN game_ste_only ON (game.game_id = game_ste_only.game_id)
               LEFT JOIN game_ste_enhan ON (game.game_id = game_ste_enhan.game_id)
               LEFT JOIN game_falcon_only ON (game.game_id = game_falcon_only.game_id)
               LEFT JOIN game_falcon_enhan ON (game.game_id = game_falcon_enhan.game_id)
               LEFT JOIN game_falcon_rgb ON (game.game_id = game_falcon_rgb.game_id)
               LEFT JOIN game_falcon_vga ON (game.game_id = game_falcon_vga.game_id)
               LEFT JOIN game_arcade ON (game.game_id = game_arcade.game_id)
               LEFT JOIN game_seuck ON (game.game_id = game_seuck.game_id)
               LEFT JOIN game_stos ON (game.game_id = game_stos.game_id)
               LEFT JOIN game_stac ON (game.game_id = game_stac.game_id)
               LEFT JOIN game_unfinished ON (game.game_id = game_unfinished.game_id)
               LEFT JOIN game_mono ON (game.game_id = game_mono.game_id)
               LEFT JOIN game_wanted ON (game.game_id = game_wanted.game_id)
                    WHERE game.game_id='$game_id'") or die("Error getting game info");


while ($game_info = $sql_game->fetch_array(MYSQLI_BOTH)) {
    $smarty->assign('game_info', array(
        'game_name' => $game_info['game_name'],
        'game_id' => $game_info['game_id'],
        'game_free' => $game_info['free'],
        'game_development' => $game_info['development'],
        'game_unreleased' => $game_info['unreleased'],
        'game_ste_only' => $game_info['ste_only'],
        'game_ste_enhan' => $game_info['ste_enhanced'],
        'game_falcon_only' => $game_info['falcon_only'],
        'game_falcon_enhan' => $game_info['falcon_enhanced'],
        'game_falcon_rgb' => $game_info['falcon_rgb'],
        'game_falcon_vga' => $game_info['falcon_vga'],
        'game_unfinished' => $game_info['unfinished'],
        'game_mono' => $game_info['monochrome'],
        'game_wanted' => $game_info['game_wanted_id'],
        'game_arcade' => $game_info['arcade'],
        'game_seuck' => $game_info['seuck'],
        'game_stos' => $game_info['stos'],
        'game_stac' => $game_info['stac']
    ));
}

//***********************************************************************************
//get the release dates
//***********************************************************************************
$sql_year = $mysqli->query("SELECT * FROM game_year
               LEFT JOIN game_extra_info ON ( game_year.game_extra_info_id = game_extra_info.game_extra_info_id )
               WHERE game_id='$game_id' ORDER BY game_year ASC") or die("Error loading year");

while ($year = $sql_year->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('game_year', array(
        'game_year_id' => $year['game_year_id'],
        'game_year' => $year['game_year'],
        'extra_info' => $year['game_extra_info']
    ));
}

//***********************************************************************************
//get the game categories & the categories already selected for this game
//***********************************************************************************
$sql_categories = $mysqli->query("SELECT * FROM game_cat 
                                           LEFT JOIN game_cat_cross ON (game_cat.game_cat_id = game_cat_cross.game_cat_id)
                                           WHERE game_id='$game_id' ORDER BY game_cat_name") or die("Error loading categories");

while ($categories = $sql_categories->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('cat', array(
        'cat_id' => $categories['game_cat_id'],
        'cat_name' => $categories['game_cat_name']
    ));
}


//**********************************************************************************
//Get the author info
//**********************************************************************************
//Starting off with displaying the authors that are linked to the game and having a delete option for them */
$sql_gameauthors = $mysqli->query("SELECT * FROM individuals 
                  LEFT JOIN individual_text ON (individual_text.ind_id = individuals.ind_id)
                  LEFT JOIN game_author ON (game_author.ind_id = individuals.ind_id)
                  LEFT JOIN author_type ON (game_author.author_type_id = author_type.author_type_id)
                  WHERE game_author.game_id='$game_id' ORDER BY author_type.author_type_id, individuals.ind_name") or die("Error loading authors");

$nr_interviews = 0;

while ($game_author = $sql_gameauthors->fetch_array(MYSQLI_BOTH)) {
    
    $nickname = '';
    $nick_id = '';
    $interview_id = '';
    
    if ($game_author['ind_imgext'] == 'png' or $game_author['ind_imgext'] == 'jpg' or $game_author['ind_imgext']) {
        $v_ind_image  = $individual_screenshot_path;
        $v_ind_image .= $game_author['ind_id'];
        $v_ind_image .= '.';
        $v_ind_image .= $game_author['ind_imgext'];
    } else {
        $v_ind_image = "none";
    }
    
    if(preg_match("/[a-z]/i", $game_author['ind_profile'])){
        $profile = $game_author['ind_profile'];
    }
    else {$profile = 'none';}
    
    if (isset($game_author['ind_id']))
    {
        // Get nickname information
        $sql_nick = $mysqli->query("SELECT * FROM individual_nicks where ind_id=$game_author[ind_id]") or die ("problem getting nickname");
          
        while ($ind_nicks = $sql_nick->fetch_array(MYSQLI_BOTH)) {
            $ind_id = $ind_nicks['nick_id'];
            $sql_nickname = $mysqli->query("SELECT * FROM individuals WHERE ind_id=$ind_id");
            
            while ($ind_nickname = $sql_nickname->fetch_array(MYSQLI_BOTH)) {
               $nickname = $ind_nickname['ind_name'];
               $nick_id = $ind_nicks['nick_id'];
            }
        }

        //Get the interview
        $sql_interview = $mysqli->query("SELECT * FROM interview_main 
                                                  LEFT JOIN interview_text ON (interview_main.interview_id = interview_text.interview_id) 
                                                  LEFT JOIN users ON (interview_main.user_id = users.user_id)
                                                  WHERE ind_id=$game_author[ind_id]") or die ("problem getting interview");
        while ($interview = $sql_interview->fetch_array(MYSQLI_BOTH)) {
            $nr_interviews++;
            
            $interview_id = $interview['interview_id'];
           
            $interview_date = date("d/m/Y", $interview['interview_date']);

            //Structure and manipulate the comment text
            $int_text = $interview['interview_intro']; 

            //fixxx the enters 
            $int_text = stripslashes($int_text);
            $int_text = InsertALCode($int_text); // disabled this as it wrecked the design.
            $int_text = trim($int_text);
            $int_text = RemoveSmillies($int_text); 
                     
            $smarty->append('interviews',  
                array( 'ind_id' => $game_author['game_author_id'],
                       'ind_name' => $game_author['ind_name'],
                       'ind_img' => $v_ind_image,
                       'int_id' => $interview['interview_id'],
                       'int_text' => $int_text,
                       'int_date' => $interview_date,
                       'int_user_id' => $interview['user_id'],
                       'int_userid' => $interview['userid']
                    ));
        }
    }
                  
    $smarty->append('game_author', array(
        'game_author_id' => $game_author['game_author_id'],
        'ind_name' => $game_author['ind_name'],
        'ind_id' => $game_author['ind_id'],
        'ind_nick' => $nickname,
        'ind_nick_id' => $nick_id,
        'ind_profile' => $profile,
        'ind_img' => $v_ind_image,
        'interview_id' => $interview_id,
        'auhthor_type_info' => $game_author['author_type_info']
    ));  
}

if ( $nr_interviews > 0)
{
    $nr_interviews = $nr_interviews - 1; //*smarty index starting at 0
    $num = mt_rand(0,$nr_interviews);
    $smarty->assign("random_interview_nr", $num);
}

//**********************************************************************************
//Get the companies info
//**********************************************************************************
//let's get the publishers for this game
$sql_publisher = $mysqli->query("SELECT * FROM pub_dev
                 LEFT JOIN pub_dev_text ON (pub_dev.pub_dev_id = pub_dev_text.pub_dev_id )
                 LEFT JOIN game_publisher ON ( pub_dev.pub_dev_id = game_publisher.pub_dev_id )
                 LEFT JOIN game_extra_info ON ( game_publisher.game_extra_info_id = game_extra_info.game_extra_info_id )
                 LEFT JOIN continent ON ( game_publisher.continent_id = continent.continent_id )
                 WHERE game_publisher.game_id = '$game_id' ORDER BY pub_dev_name ASC") or die("Couldn't query publishers");

while ($publishers = $sql_publisher->fetch_array(MYSQLI_BOTH)) {
    
    if ($publishers['pub_dev_imgext'] == 'png' or $publishers['pub_dev_imgext'] == 'jpg' or $publishers['pub_dev_imgext'] == 'gif') {
        //$v_comp_image  = $company_screenshot_path;
        $v_comp_image  = $company_screenshot_save_path;
        $v_comp_image .= $publishers['pub_dev_id'];
        $v_comp_image .= '.';
        $v_comp_image .= $publishers['pub_dev_imgext'];
        
        $v_comp_image_pop  = $company_screenshot_path;
        $v_comp_image_pop .= $publishers['pub_dev_id'];
        $v_comp_image_pop .= '.';
        $v_comp_image_pop .= $publishers['pub_dev_imgext'];
    } else {
        $v_comp_image = "none";
        $v_comp_image_pop = "none";
    }
    
    if(preg_match("/[a-z]/i", $publishers['pub_dev_profile'])){
        $profile = $publishers['pub_dev_profile'];
    }
    else {$profile = 'none';}
   
    $smarty->append('publisher', array(
        'pub_id' => $publishers['pub_dev_id'],
        'pub_name' => $publishers['pub_dev_name'],
        'pub_profile' => $profile,
        'continent_id' => $publishers['continent_id'],
        'extra_info' => $publishers['game_extra_info'],
        'logo' => $v_comp_image,
        'logo_pop' => $v_comp_image_pop,
        'logo_path' => $company_screenshot_path,
        'continent' => $publishers['continent_name']
    ));
}


//let's get the developers for this game
$sql_developer = $mysqli->query("SELECT * FROM game_developer
                  LEFT JOIN pub_dev ON ( pub_dev.pub_dev_id = game_developer.dev_pub_id )
                  LEFT JOIN pub_dev_text ON (pub_dev.pub_dev_id = pub_dev_text.pub_dev_id )
                  LEFT JOIN game_extra_info ON ( game_developer.game_extra_info_id = game_extra_info.game_extra_info_id )
                  LEFT JOIN continent ON ( game_developer.continent_id = continent.continent_id )
                  WHERE game_developer.game_id = '$game_id' ORDER BY pub_dev_name ASC") or die("Couldn't query developers");

while ($developers = $sql_developer->fetch_array(MYSQLI_BOTH)) {
    
    if ($developers['pub_dev_imgext'] == 'png' or $developers['pub_dev_imgext'] == 'jpg' or $developers['pub_dev_imgext'] == 'gif') {
        //$v_ind_image = $company_screenshot_path;
        $v_ind_image = $company_screenshot_save_path;
        $v_ind_image .= $developers['pub_dev_id'];
        $v_ind_image .= '.';
        $v_ind_image .= $developers['pub_dev_imgext'];
        
        $v_ind_image_pop = $company_screenshot_path;
        $v_ind_image_pop .= $developers['pub_dev_id'];
        $v_ind_image_pop .= '.';
        $v_ind_image_pop .= $developers['pub_dev_imgext'];
        
    } else {
        $v_ind_image = "none";
        $v_ind_image_pop = "none";
    }
    
    if(preg_match("/[a-z]/i", $developers['pub_dev_profile'])){
        $profile = $developers['pub_dev_profile'];
    }
    else {$profile = 'none';}
       
    $smarty->append('developer', array(
        'pub_id' => $developers['dev_pub_id'],
        'pub_name' => $developers['pub_dev_name'],
        'pub_profile' =>$profile,
        'continent_id' => $developers['continent_id'],
        'extra_info' => $developers['game_extra_info'],
        'logo' => $v_ind_image,
        'logo_pop' => $v_ind_image_pop,
        'logo_path' => $company_screenshot_path,
        'continent' => $developers['continent_name']
    ));
}

//***********************************************************************************
//AKA's
//***********************************************************************************
$sql_aka = $mysqli->query("SELECT * FROM game_aka WHERE game_id='$game_id'") or die("Couldn't query aka games");

$nr_aka = 0;

while ($aka = $sql_aka->fetch_array(MYSQLI_BOTH)) {
    $smarty->append('aka', array(
        'game_aka_name' => $aka['aka_name'],
        'game_id' => $aka['game_id'],
        'game_aka_id' => $aka['game_aka_id']
    ));
    $nr_aka++;
}


//***********************************************************************************
//Get the screenshots
//***********************************************************************************
//Get the screenshots for this game, if they exist
$sql_screenshots = $mysqli->query("SELECT * FROM screenshot_game
                    LEFT JOIN screenshot_main ON (screenshot_game.screenshot_id = screenshot_main.screenshot_id)
                    WHERE screenshot_game.game_id = '$game_id' ORDER BY screenshot_game.screenshot_id") or die("Database error - selecting screenshots");

$count = 0;

while ($screenshots = $sql_screenshots->fetch_array(MYSQLI_BOTH)) {
    //Ready screenshots path and filename
    $screenshot_image = $game_screenshot_save_path;
    $screenshot_image .= $screenshots['screenshot_id'];
    $screenshot_image .= '.';
    $screenshot_image .= $screenshots['imgext'];
    
    $screenshot_image_pop = $game_screenshot_path;
    $screenshot_image_pop .= $screenshots['screenshot_id'];
    $screenshot_image_pop .= '.';
    $screenshot_image_pop .= $screenshots['imgext'];

    $smarty->append('screenshots', array(
        'count' => $count,
        'path' => $game_screenshot_path,
        'screenshot_image' => $screenshot_image,
        'screenshot_image_pop' => $screenshot_image_pop,
        'id' => $screenshots['screenshot_id']
    ));
    $count++;
}

$smarty->assign("nr_screenshots", $count);



//***********************************************************************************
//Get the boxscans
//***********************************************************************************
$IMAGE = $mysqli->query("SELECT * FROM game_boxscan WHERE game_id='$game_id' ORDER BY game_boxscan_id") or die("Database error - selecting gamebox scan");

$imagenum_rows = $IMAGE->num_rows;

// if no boxscans are attached
$smarty->assign('numberscans', $imagenum_rows);

$front=0;

if ($imagenum_rows > 0) {
    while ($rowimage = $IMAGE->fetch_array(MYSQLI_BOTH)) { // First check if front cover
        if ($rowimage['game_boxscan_side'] == 0) {
            
            $front++;
            
            $front_image_filename = "$game_boxscan_save_path$rowimage[game_boxscan_id].$rowimage[imgext]";
            $front_image_pop_filename = "$game_boxscan_path$rowimage[game_boxscan_id].$rowimage[imgext]";
            
            $smarty->append('boxscan', array(
                'game_boxscan_id' => $rowimage['game_boxscan_id'],
                'image' => $front_image_filename,
                'image_pop' => $front_image_pop_filename
            ));
        } else { // Else back covers
            $couple = $mysqli->query("SELECT game_boxscan_id FROM game_box_couples WHERE game_boxscan_cross=$rowimage[game_boxscan_id]") or die("Database error - selecting gamebox scan");
            $couplerow        = $couple->fetch_row();

            $back_image_filename = "$game_boxscan_save_path$rowimage[game_boxscan_id].$rowimage[imgext]";
            $back_image_pop_filename = "$game_boxscan_path$rowimage[game_boxscan_id].$rowimage[imgext]";

            $smarty->append('boxscan', array(
                'game_boxscan_id' => $rowimage['game_boxscan_id'],
                'image' => $back_image_filename,
                'image_pop' => $back_image_pop_filename
            ));
        }
    }
    
    $smarty->assign("nr_box", $front);
}


//***********************************************************************************
//Get the comments
//***********************************************************************************
//Select the comments from the DB
$sql_comment = $mysqli->query("SELECT *
                                FROM game_user_comments
                                LEFT JOIN comments ON ( game_user_comments.comment_id = comments.comments_id )
                                LEFT JOIN users ON ( comments.user_id = users.user_id )
                                LEFT JOIN game ON ( game_user_comments.game_id = game.game_id )
                                WHERE game_user_comments.game_id = '$game_id'
                                ORDER BY comments.timestamp desc") or die("Syntax Error! Couldn't not get the comments!");

                                // lets put the comments in a smarty array

while ($query_comment = $sql_comment->fetch_array(MYSQLI_BOTH)) 
{
    
    $oldcomment = $query_comment['comment'];
    $oldcomment = nl2br($oldcomment);
    $oldcomment = InsertALCode($oldcomment);
    $oldcomment = trim($oldcomment);
    $oldcomment = RemoveSmillies($oldcomment);
    $oldcomment = stripslashes($oldcomment);
    
    $comment = stripslashes($query_comment['comment']);
    $comment = trim($comment);
    $comment = RemoveSmillies($comment);
     
    //this is needed, because users can change their own comments on the website, however this is done with JS (instead of a post with pure HTML)
    //The translation of the 'enter' breaks is different in JS, so in JS I do a conversion to a <br>. However, when we edit a comment, this <br> should not be 
    //visible to the user, hence again, now this conversion in php    
    $breaks = array("<br />","<br>","<br/>");  
    $comment = str_ireplace($breaks, "\r\n", $comment); 
    
    $date = date("d/m/y",$query_comment['timestamp']);
    
    $smarty->append('comments',
	    array('comment' => $oldcomment,
              'comment_edit' => $comment,
              'comment_id' => $query_comment['comment_id'],
			  'date' => $date,
			  'game' => $query_comment['game_name'],
			  'game_id' => $query_comment['game_id'],
			  'user_name' => $query_comment['userid'],
              'user_id' => $query_comment['user_id'],
              'user_fb' => $query_comment['user_fb'],
              'user_website' => $query_comment['user_website'],
              'user_twitter' => $query_comment['user_twitter'],
              'user_af' => $query_comment['user_af'],
			  'email' => $query_comment['email']));
}


//***********************************************************************************
//Get the reviews
//***********************************************************************************   
    $sql_review = $mysqli->query("SELECT * FROM game
                               LEFT JOIN review_game ON (game.game_id = review_game.game_id)
                               LEFT JOIN review_main ON (review_game.review_id = review_main.review_id)
                               LEFT JOIN review_score ON (review_main.review_id = review_score.review_id)
                               LEFT JOIN users ON (review_main.user_id = users.user_id)
                               WHERE game.game_id = '$game_id' AND review_main.review_edit = '0'") or die("Error - Couldn't query review data");

    while ($query_review = $sql_review->fetch_array(MYSQLI_BOTH)) 
    {
        $review_date = date("F j, Y", $query_review['review_date']);
        
        //Structure and manipulate the review text
        $review_text = $query_review['review_text'];
        
        $pos_start = strpos($review_text , '[frontpage]');  
        $pos_end = strpos($review_text , '[/frontpage]');    
        $nr_char = $pos_end - $pos_start;
        
        $review_text  = substr($review_text , $pos_start, $nr_char);  
        $review_text = nl2br($review_text);
        $review_text = InsertALCode($review_text); // disabled this as it wrecked the design.
        $review_text = trim($review_text);
        $review_text = RemoveSmillies($review_text);

        //Get a screenshots and the comments of this review
        $query_screenshots_review = $mysqli->query("SELECT * FROM review_main
                                        LEFT JOIN screenshot_review ON (review_main.review_id = screenshot_review.review_id)
                                        LEFT JOIN screenshot_main ON (screenshot_review.screenshot_id = screenshot_main.screenshot_id)
                                        LEFT JOIN review_comments ON (screenshot_review.screenshot_review_id = review_comments.screenshot_review_id)
                                        WHERE review_main.review_id = '$query_review[review_id]' AND review_main.review_edit = '0' ORDER BY RAND() LIMIT 1") or die("Error - Couldn't query review screenshots");
        
        $sql_screenshots_review = $query_screenshots_review->fetch_array(MYSQLI_BOTH);
        
        $new_path = $game_screenshot_path;
        $new_path .= $sql_screenshots_review['screenshot_id'];
        $new_path .= ".";
        $new_path .= $sql_screenshots_review['imgext'];
        
        $smarty->append('review', array(
                'user_name' => $query_review['userid'],
                'user_id' => $query_review['user_id'],
                'review_id' => $query_review['review_id'],
                'email' => $query_review['email'],
                'game_id' => $query_review['game_id'],
                'date' => $review_date,
                'game_name' => $query_review['game_name'],
                'text' => $review_text,
                'screenshot' => $new_path,
                'comment' => $sql_screenshots_review['comment_text']
            ));
    }


$smarty->assign("game_id", $game_id);

//Send all smarty variables to the templates
$smarty->display("file:" . $mainsite_template_folder . "games_main_detail.html");

//close the connection
mysqli_close($mysqli);
