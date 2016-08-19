<?php
/***************************************************************************
*                                change_log.php
*                            ---------------------------
*   begin                : Wednesday, 17 august, 2016
*   copyright            : (C) 2016 Atari Legend
*   email                : martens_maarten@hotmail.com
*   actual update        : File creation
*
***************************************************************************/
//****************************************************************************************
// This is where we load the db changes from the log table and create links
//**************************************************************************************** 	

include("../../includes/common.php");
include("../../includes/admin.php");

//load the search fields of the quick search side menu
include("../../includes/quick_search_games.php"); 


if(empty($v_linkback)) {$v_linkback = '';}
if(empty($v_linknext)) {$v_linknext = '';}

$v_counter= (isset($_GET["v_counter"]) ? $_GET["v_counter"] : 0);

//get the number of log entries
$query_number = $mysqli->query("SELECT * FROM change_log") or die("Couldn't get the number of changes");
$v_log = $query_number->num_rows;

$smarty->assign('log_nr', $v_log);

$sql_log = $mysqli->query("SELECT * 
						 FROM change_log
						 ORDER BY change_log_id DESC LIMIT  " . $v_counter . ", 25");

while ($log = $sql_log->fetch_array(MYSQLI_BOTH))
{
	$user_name = get_username_from_id($log['user_id']);
	$log_date = convert_timestamp($log['timestamp']);
	
//  create the section link and the subsection link	
//	the GAMES SECTION
	if ($log['section'] == 'Games')
	{			
		$section_link = ( "../games/games_detail.php" . '?game_id=' . $log['section_id'] );
	
	
		if ($log['sub_section'] == 'Game' OR $log['sub_section'] == 'AKA' OR $log['sub_section'] == 'Year' OR $log['sub_section'] == 'Submission')
		{
			$subsection_link = ( "../games/games_detail.php" . '?game_id=' . $log['sub_section_id'] );
		}
		
		if ($log['sub_section'] == 'Creator' )
		{
			$subsection_link = ( "../individuals/individuals_edit.php" . '?ind_id=' . $log['sub_section_id'] );
		}
		
		if ($log['sub_section'] == 'Publisher' OR $log['sub_section'] == 'Developer' )
		{
			$subsection_link = ( "../company/company_edit.php" . '?comp_id=' . $log['sub_section_id'] );
		}
		
		if ($log['sub_section'] == 'File' )
		{
			$subsection_link = ( "../games/games_upload.php" . '?game_id=' . $log['sub_section_id'] );
		}
		
		if ($log['sub_section'] == 'Screenshot' )
		{
			$subsection_link = ( "../games/games_screenshot_add.php" . '?game_id=' . $log['sub_section_id'] . '&game_name=' . $log['section_name']);
		}
		
		if ($log['sub_section'] == 'Mag score' )
		{
			$subsection_link = ( "../magazine/magazine_review_score.php" . '?game_id=' . $log['sub_section_id'] . '&game_name=' . $log['section_name'] );
		}
		
		if ($log['sub_section'] == 'Box back' OR $log['sub_section'] == 'Box front')
		{
			$subsection_link = ( "../games/games_box.php" . '?game_id=' . $log['sub_section_id'] . '&game_name=' . $log['section_name'] );
		}
		
		if ($log['sub_section'] == 'Similar' )
		{
			$subsection_link = ( "../games/games_similar.php" . '?game_id=' . $log['sub_section_id'] . '&game_name=' . $log['section_name'] );
		}
		
		if ($log['sub_section'] == 'Comment' )
		{
			if ($log['action'] == 'Delete')
			{
				$subsection_link = ( "../administration/change_log.php" );
			}
			else
			{
				$subsection_link = ( "../games/games_comment_edit.php" . '?game_user_comments_id=' . $log['sub_section_id'] . '&v_counter=0' );
			}
		}
		
		if ($log['sub_section'] == 'Review' OR $log['sub_section'] == 'Review comment' )
		{
			if ($log['action'] == 'Delete')
			{
				$subsection_link = ( "../games/games_review_add.php" . '?game_id=' . $log['section_id'] );
			}
			else
			{
				$subsection_link = ( "../games/games_review_edit.php" . '?reviewid=' . $log['sub_section_id'] . '&game_id=' . $log['section_id'] );
			}
		}
		
		if ($log['sub_section'] == 'Music' )
		{
			$subsection_link = ( "../games/games_music_detail.php" . '?game_id=' . $log['sub_section_id'] );
		}
	}
	
	//	the GAMES SERIES SECTION
	if ($log['section'] == 'Game series')
	{			
		$section_link = ( "../games/games_series_editor.php" . '?game_series_id=' . $log['section_id'] . '&series_page=series_editor');
		
		if ($log['sub_section'] == 'Series')
		{
			$subsection_link = ( "../games/games_series_editor.php" . '?game_series_id=' . $log['section_id'] . '&series_page=series_editor');
		}
		
		if ($log['sub_section'] == 'Game')
		{
			$subsection_link = ( "../games/games_detail.php" . '?game_id=' . $log['sub_section_id'] );
		}
	}
	
	//	the TRIVIA SECTION
	if ($log['section'] == 'Trivia')
	{	
		if ($log['sub_section'] == 'DYK' )
		{
			$section_link = ( "../trivia/did_you_know.php");
			$subsection_link = ( "../trivia/did_you_know.php");
		}
		
		if ($log['sub_section'] == 'Quote' )
		{
			$section_link = ( "../trivia/manage_trivia_quotes.php");
			$subsection_link = ( "../trivia/manage_trivia_quotes.php");
		}
	}
	
	//	the USER SECTION
	if ($log['section'] == 'Users')
	{
		if ($log['sub_section'] == 'Avatar' OR $log['sub_section'] == 'User')
		{
			$section_link = ( "../user/user_detail.php" . '?user_id_selected=' . $log['section_id'] );
			$subsection_link = ( "../user/user_detail.php" . '?user_id_selected=' . $log['sub_section_id'] );
		}
	}
	
	//	the LINKS SECTION
	if ($log['section'] == 'Links')
	{
		$section_link = ( "../links/link_mod.php" . '?website_id=' . $log['section_id'] );
		
		if ($log['sub_section'] == 'Link' OR $log['sub_section'] == 'Category')
		{
			$subsection_link = ( "../links/link_mod.php" . '?website_id=' . $log['section_id'] );
		}
	}
	
	//	the LINKS CATEGORRY SECTION
	if ($log['section'] == 'Links cat')
	{
		$section_link = ( "../links/link_cat.php" );
		$subsection_link = ( "../links/link_cat.php" );
	}
	
	//	the COMPANY SECTION
	if ($log['section'] == 'Company')
	{	
		$section_link = ( "../company/company_edit.php" . '?comp_id=' . $log['section_id'] );
		
		if ($log['sub_section'] == 'Company' OR $log['sub_section'] == 'Logo')
		{
			$subsection_link = $section_link;
		}
	}
		
		
	$smarty->append('log',
 		 		array('log_user_name' => $user_name,
					  'log_user_id' => $log['user_id'],
					  'log_date' => $log_date,
					  'log_section_link' => $section_link,
					  'log_subsection_link' => $subsection_link,
			  		  'log_action' => $log['action'],
			  		  'log_section' => $log['section'],
					  'log_section_name' => $log['section_name'],
					  'log_subsection_name' => $log['sub_section_name'],
					  'log_subsection' => $log['sub_section']));	
}			 

//Check if back arrow is needed 
if($v_counter > 0)
{
// Build the link
	$v_linkback =("change_log.php" . '?v_counter=' . ($v_counter - 25));
}

//Check if we need to place a next arrow
if($v_log > ($v_counter + 25))
{
//Build the link
	$v_linknext =("change_log.php" . '?v_counter=' . ($v_counter + 25));
}

$smarty->assign('links',
	     array('linkback' => $v_linkback,
			   'linknext' => $v_linknext));

$smarty->assign("user_id",$_SESSION['user_id']);

$smarty->assign('quick_search_games', 'quick_search_change_log');
$smarty->assign('left_nav', 'leftnav_position_change_log');

//Send all smarty variables to the templates
$smarty->display("file:".$cpanel_template_folder."change_log.html");

//close the connection
mysqli_close($mysqli);
?>
