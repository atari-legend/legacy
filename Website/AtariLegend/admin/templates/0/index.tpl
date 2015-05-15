{* 
/***************************************************************************
*                                index.html
*                            --------------------------
*   begin                : 2005-01-06
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: index.html,v 0.10 2005/01/06 Silver
*
***************************************************************************/

//****************************************************************************************
// This is the index template file which all other sub templates are called in
//**************************************************************************************** 
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<link href="../templates/0/css/atarilegend.css" hreflang="en" rel="stylesheet" type="text/css" charset="ISO-8859-1">
{if isset($games_review_add_html) or isset($games_review_edit_tpl)} 		
	<script type='text/JavaScript' src='../templates/0/js/sha512.js'></script>
	<script type='text/JavaScript' src='../templates/0/js/md5.js'></script> 
{/if}
{if isset($games_box_tpl)}
<script src="../templates/0/js/jquery-1.11.0.min.js"></script>
	<script src="../templates/0/js/lightbox.min.js"></script>
<link href="../templates/0/css/lightbox.css" rel="stylesheet" />
 
{/if}

	<title>Cpanel</title>
</head>
<body class="BODY">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" >
	<tr>
		<td>
			{*
				//****************************************************************************************
				// This is the header with the Atari Legend logo
				//**************************************************************************************** 
			*}
			<table width="100%" cellspacing="0" cellpadding="0" border="0" class="HEADER">
				<tr>
    				<td width="20%" valign="top">
					<img src="../templates/0/images/al-beta2logo.png" alt="logo" width="200" height="71" border="0" align="top"> 
					</td>
					{if isset($games_list_html) or isset($games_detail_tpl)} 
					<td width="80%" valign="top">
					<form action="../games/games_main.php" method="post" name="game_search" id="game_search">
				<br>
		<table align="left">
		<tr>
			<td>
				<b>By name :</b>
			</td>
			<td>
				<select name="gamebrowse">
					<option value="" SELECTED>-</option>
					<option value="num">0-9</option>
					<option value="a">A</option>
					<option value="b">B</option>
					<option value="c">C</option>
					<option value="d">D</option>
					<option value="e">E</option>
					<option value="f">F</option>
					<option value="g">G</option>
					<option value="h">H</option>
					<option value="i">I</option>
					<option value="j">J</option>
					<option value="k">K</option>
					<option value="l">L</option>
					<option value="m">M</option>
					<option value="n">N</option>
					<option value="o">O</option>
					<option value="p">P</option>
					<option value="q">Q</option>
					<option value="r">R</option>
					<option value="s">S</option>
					<option value="t">T</option>
					<option value="u">U</option>
					<option value="v">V</option>
					<option value="w">W</option>
					<option value="x">X</option>
					<option value="y">Y</option>
					<option value="z">Z</option>
				</select>
				<input type="text" name="gamesearch" value="">
			</td>
		
			<td>
				<input type="submit" value="Search">
			</td>
			<td>
					
			</td>
			<td rowspan="2">
			
			<input type="checkbox" name="falcon_only" value="1"{if isset($games_falcon_only)} checked{/if}><strong>Falcon only&nbsp;</strong>
		<input type="checkbox" name="falcon_enhanced" value="1"{if isset($games_falcon_enhanced)} checked{/if}><strong>Falcon Enhanced&nbsp;</strong>
		<input type="checkbox" name="ste_only" value="1"{if isset($games_ste_only)} checked{/if}><strong>STE only</strong>
		<input type="checkbox" name="ste_enhanced" value="1"{if isset($games_ste_enhanced)} checked{/if}><strong>STE Enhanced&nbsp;</strong><br>
		<input type="checkbox" name="free" value="1"{if isset($games_free)} checked{/if}><strong>Non-Commercial&nbsp;</strong>
		<input type="checkbox" name="arcade" value="1"{if isset($games_arcade)} checked{/if}><strong>Arcade Conversion&nbsp;</strong>
		<input type="checkbox" name="development" value="1"{if isset($games_development)} checked{/if}><strong>In development&nbsp;</strong>
			
			
			</td>
			
			
		</tr>
		<tr>
			<td align="left">
				<b>By Developer :</b>
			</td>
			<td align="left">
				<select name="developer" style="width:90px;">
					<option value="-" SELECTED>-</option>
					{foreach from=$company item=line} 
						<option value="{$line.comp_id}">{$line.comp_name}</option>
					{/foreach}
				</select>
			</td>
			<td align="left">
				<b>By Publisher :</b>
			</td>
			<td align="left">
			<select name="publisher" style="width:90px;">
					<option value="-" SELECTED>-</option>
					{foreach from=$company item=line} 
						<option value="{$line.comp_id}">{$line.comp_name}</option>
					{/foreach}
				</select>	
			</td>
		</tr>		
		</table>
		
		<input type="hidden" name="action" id="action" value="search">
		<input type="hidden" name="user_id" id="user_id" value="{$user_id}">
		</form>	
					</td>
					{/if}
				</tr>
			</table>
			
			<table width="100%" cellspacing="2" cellpadding="2" border="0" class="MAINTABLE" >
			<tr>
    			<td width="16%" valign="top">

			<!--Begin Leftnav Section-->

<div class="NEWNAVCELL">

	<li class="NEWHEADERBAR">Administration</li>

	<li class="leftnav_list"><a href="../index.php" class="LEFTNAV">Main Page</a></li>
	<li class="leftnav_list"><a href="../administration/statistics.php" class="LEFTNAV">Statistics</a></li>
	<li class="leftnav_list"><a href="http://team.atarizone.com" class="LEFTNAV">Forum</a></li>
      	<li class="leftnav_list"><a href="../administration/construction.php" class="LEFTNAV">Log Out</a></li>
	
	<li class="NEWHEADERBAR">Trivia</li>

	<li class="leftnav_list"><a href="../trivia/did_you_know.php" class="LEFTNAV">Did you know</a></li>
	<li class="leftnav_list"><a href="../trivia/manage_trivia_screens.php" class="LEFTNAV">Trivia Screenshots</a></li>
	<li class="leftnav_list"><a href="../trivia/manage_trivia_quotes.php" class="LEFTNAV">Trivia Quotes</a></li>

	<li class="NEWHEADERBAR">Users</li>

	<li class="leftnav_list"><a href="../user/user_main.php" class="LEFTNAV">User admin page</a></li>

	<li class="NEWHEADERBAR">Links</li>

	<li class="leftnav_list"><a href="../links/link_addnew.php" class="LEFTNAV">Add new Links</a></li>
 	<li class="leftnav_list"><a href="../links/link_validate.php" class="LEFTNAV">Validate Links</a></li>
 	<li class="leftnav_list"><a href="../links/link_modlist.php" class="LEFTNAV">Modify Links</a></li>
 	<li class="leftnav_list"><a href="../links/link_cat.php" class="LEFTNAV">Link Categories</a></li>

	<li class="NEWHEADERBAR">Games</li>

	<li class="leftnav_list"><a href="../games/games_main.php" class="LEFTNAV">Game Editor</a></li>
	<li class="leftnav_list"><a href="../games/games_comment.php" class="LEFTNAV">Game Comments</a></li>
	<li class="leftnav_list"><a href="../games/games_review.php" class="LEFTNAV">Reviews</a></li>
	<li class="leftnav_list"><a href="../games/games_review_submitted.php" class="LEFTNAV">Submitted reviews</a></li>
	<li class="leftnav_list"><a href="../games/games_series_main.php" class="LEFTNAV">Game Series</a></li>
	<li class="leftnav_list"><a href="../games/games_music.php" class="LEFTNAV">Game Music</a></li>
	<li class="leftnav_list"><a href="../games/submission_games.php" class="LEFTNAV">Submissions</a></li>

	<li class="NEWHEADERBAR">Articles</li>

	<li class="leftnav_list"><a href="../administration/construction.php" class="LEFTNAV">Articles</a></li>
	<li class="leftnav_list"><a href="../administration/construction.php" class="LEFTNAV">Article types</a></li>
	<li class="leftnav_list"><a href="../administration/construction.php" class="LEFTNAV">Screenshots</a></li>

	<li class="NEWHEADERBAR">Company</li>

	<li class="leftnav_list"><a href="../company/company_main.php" class="LEFTNAV">Companies</a></li>
	<li class="leftnav_list"><a href="../company/company_logos.php" class="LEFTNAV">Company Logos</a></li>

	<li class="NEWHEADERBAR">Individuals</li>

	<li class="leftnav_list"><a href="../individuals/individuals_main.php" class="LEFTNAV">Indivuals</a></li>
	<li class="leftnav_list"><a href="../individuals/individuals_author.php" class="LEFTNAV">Author types</a></li>

	<li class="NEWHEADERBAR">Magazines</li>

	<li class="leftnav_list"><a href="../magazine/magazine_add.php" class="LEFTNAV">Add Magazine</a></li>
	<li class="leftnav_list"><a href="../magazine/magazine_manage.php" class="LEFTNAV">Manage issues</a></li>

	<li class="NEWHEADERBAR">Interviews</li>

	<li class="leftnav_list"><a href="../interviews/interviews_main.php" class="LEFTNAV">Interviews</a></li>
	<li class="leftnav_list"><a href="../interviews/interviews_help.php" class="LEFTNAV">Interviews Help</a></li>

	<li class="NEWHEADERBAR">Crews</li>

	<li class="leftnav_list"><a href="../crew/crew_main.php" class="LEFTNAV">Crew Editor</a></li>

	<li class="NEWHEADERBAR">Demos</li>

	<li class="leftnav_list"><a href="../demos/demos_main.php" class="LEFTNAV">Demo Editor</a></li>
	<li class="leftnav_list"><a href="../demos/demos_comment.php" class="LEFTNAV">Demo Comments</a></li>
	<li class="leftnav_list"><a href="../demos/demos_music.php" class="LEFTNAV">Demo Music</a></li>
	<li class="leftnav_list"><a href="../demos/submission_demos.php" class="LEFTNAV">Submissions</a></li>

	<li class="NEWHEADERBAR">News</li>

	<div class="leftnav_list"><a href="../news/news_add.php" class="LEFTNAV">Add News</a></div>
	<div class="leftnav_list"><a href="../news/news_approve.php" class="LEFTNAV">Approve News</a></div>
	<div class="leftnav_list"><a href="../news/news_edit_all.php" class="LEFTNAV">Edit/Delete News</a></div>
	<div class="leftnav_list"><a href="../news/news_add_images.php" class="LEFTNAV">Add news images</a></div> 


</div>

<br>
<!--
//****************************************************************************************
// Online users
//**************************************************************************************** 
-->

<div class="NEWNAVCELL">

	<li class="NEWHEADERBAR">Online Users</li>

		{foreach from=$onlineusers item=line}
		<li class="leftnav_list">- <a href="../user/user_detail.php?user_id_selected={$line.user_id}" class="LEFTNAV">{$line.user_name}</a></li> 
		{/foreach}


</div>


<!--
//****************************************************************************************
// This is the disclaimer that is called on all pages
//**************************************************************************************** 
-->
<br>

<div class="NEWNAVCELL">
	<li class="leftnav_list" style="text-weight:bold;">
	© 2015 AtariLegend<br>
	AtariLegend is not affiliated with <a href="http://www.atari.com" class="MAINNAV">Atari Corporation</a> in any way.
	</li>	
</div>

			<!--End Leftnav Section-->

				</td>
				<!--Begin of Middle Comlumn-->
				<!--The middle column is called with a var-->	
    			<td width="84%" valign="top">
					{if isset($updates_tpl) and $updates_tpl eq "1"}
					{include file="./updates.html"}
					{/if}
					{if isset($statistics_tpl) and $statistics_tpl eq "1"}
					{include file="./statistics.html"}
					{/if}
					{if isset($link_addnew_tpl) and $link_addnew_tpl eq "1"}
					{include file="./link_addnew.html"}
					{/if}
					{if isset($link_modlist_tpl) and $link_modlist_tpl eq "1"}
					{include file="./link_modlist.html"}
					{/if}
					{if isset($link_mod_tpl) and $link_mod_tpl eq "1"}
					{include file="./link_mod.html"}
					{/if}
					{if isset($link_validate_tpl) and $link_validate_tpl eq "1"}
					{include file="./link_validate.html"}
					{/if}
					{if isset($link_cat_tpl) and $link_cat_tpl eq "1"}
					{include file="./link_cat.html"}
					{/if}
					{if isset($link_cat_mod_tpl) and $link_cat_mod_tpl eq "1"}
					{include file="./link_cat_mod.html"}
					{/if}
					{if isset($link_cat_del_tpl) and $link_cat_del_tpl eq "1"}
					{include file="./link_cat_del.html"}
					{/if}
					{if isset($error_message_tpl) and $error_message_tpl eq "1"}
					{include file="./error_message.html"}
					{/if}
					{if isset($news_add_tpl) and $news_add_tpl eq "1"}
					{include file="./news_add.html"}
					{/if}
					{if isset($news_iconpreview_tpl) and $news_iconpreview_tpl eq "1"}
					{include file="./news_iconpreview.html"}
					{/if}
					{if isset($news_add_images_tpl) and $news_add_images_tpl eq "1"}
					{include file="./news_add_images.html"}
					{/if}
					{if isset($news_edit_images_tpl) and $news_edit_images_tpl eq "1"}
					{include file="./news_edit_images.html"}
					{/if}
					{if isset($news_approve_tpl) and $news_approve_tpl eq "1"}
					{include file="./news_approve.html"}
					{/if}
					{if isset($news_edit_tpl) and $news_edit_tpl eq "1"}
					{include file="./news_edit.html"}
					{/if}
					{if isset($news_edit_all_tpl) and $news_edit_all_tpl eq "1"}
					{include file="./news_edit_all.html"}
					{/if}
					{if isset($submission_games_tpl) and $submission_games_tpl eq "1"}
					{include file="./submission_games.html"}
					{/if}
					{if isset($interviews_main_tpl) and $interviews_main_tpl eq "1"} 
              		{include file="./interviews_main.html"} 
               		{/if}	
					{if isset($interviews_preview_tpl) and $interviews_preview_tpl eq "1"} 
              		{include file="./interviews_preview.html"} 
               		{/if}	
					{if isset($interviews_edit_tpl) and $interviews_edit_tpl eq "1"} 
              		{include file="./interviews_edit.html"} 
               		{/if}	
					{if isset($interviews_add_tpl) and $interviews_add_tpl eq "1"} 
              		{include file="./interviews_add.html"} 
               		{/if}	
					{if isset($interviews_screenshots_add_tpl) and $interviews_screenshots_add_tpl eq "1"} 
              		{include file="./interviews_screenshots_add.html"} 
               		{/if}	
					{if isset($interviews_hlp_tpl) and $interviews_hlp_tpl eq "1"} 
              		{include file="./interviews_help.html"} 
               		{/if}
					{if isset($individuals_main_tpl) and $individuals_main_tpl eq "1"} 
              		{include file="./individuals_main.html"} 
               		{/if}	
					{if isset($individuals_edit_tpl) and $individuals_edit_tpl eq "1"} 
              		{include file="./individuals_edit.html"} 
               		{/if}	
					{if isset($individuals_author_tpl) and $individuals_author_tpl eq "1"} 
              		{include file="./individuals_author.html"} 
               		{/if}
					{if isset($company_main_tpl) and $company_main_tpl eq "1"} 
              		{include file="./company_main.html"} 
               		{/if}
					{if isset($company_edit_tpl) and $company_edit_tpl eq "1"} 
              		{include file="./company_edit.html"} 
               		{/if}	
					{if isset($company_logos_tpl) and $company_logos_tpl eq "1"} 
              		{include file="./company_logos.html"} 
               		{/if}
					{if isset($did_you_know_tpl) and $did_you_know_tpl eq "1"}
					{include file="./did_you_know.html"}
					{/if}
					{if isset($manage_trivia_quotes_tpl) and $manage_trivia_quotes_tpl eq "1"}
					{include file="./manage_trivia_quotes.html"}
					{/if}
					{if isset($manage_trivia_screens_tpl) and $manage_trivia_screens_tpl eq "1"}
					{include file="./manage_trivia_screens.html"}
					{/if}
					{if isset($games_main_tpl) and $games_main_tpl eq "1"} 
               		{include file="./games_main.html"} 
               		{/if}	
					{if isset($games_list_html) and $games_list_html eq "1"} 
               		{include file="./games_list.html"} 
               		{/if}
					{if isset($games_detail_tpl) and $games_detail_tpl eq "1"} 
               		{include file="./games_detail.html"} 
               		{/if}	
					{if isset($magazine_add_tpl) and $magazine_add_tpl eq "1"} 
               		{include file="./magazine_add.html"} 
               		{/if}
					{if isset($magazine_manage_tpl) and $magazine_manage_tpl eq "1"} 
               		{include file="./magazine_manage.html"} 
               		{/if}
					{if isset($magazine_edit_tpl) and $magazine_edit_tpl eq "1"} 
               		{include file="./magazine_edit.html"} 
               		{/if}
					{if isset($magazine_issue_edit_tpl) and $magazine_issue_edit_tpl eq "1"} 
               		{include file="./magazine_issue_edit.html"} 
               		{/if}
					{if isset($magazine_review_list_tpl) and $magazine_review_list_tpl eq "1"} 
               		{include file="./magazine_review_list.html"} 
               		{/if}
					{if isset($magazine_review_score_tpl) and $magazine_review_score_tpl eq "1"} 
               		{include file="./magazine_review_score.html"} 
               		{/if}
					{if isset($magazine_setscore_tpl) and $magazine_setscore_tpl eq "1"} 
               		{include file="./magazine_setscore.html"} 
               		{/if}
					{if isset($games_comment_tpl) and $games_comment_tpl eq "1"} 
               		{include file="./games_comment.html"} 
               		{/if}
					{if isset($games_comment_edit_tpl) and $games_comment_edit_tpl eq "1"} 
               		{include file="./games_comment_edit.html"} 
               		{/if}
					{if isset($games_series_main_tpl) and $games_series_main_tpl eq "1"} 
               		{include file="./games_series_main.html"} 
               		{/if}
					{if isset($user_main_tpl) and $user_main_tpl eq "1"} 
               		{include file="./user_main.html"} 
               		{/if}
					{if isset($user_search_tpl) and $user_search_tpl eq "1"} 
               		{include file="./user_search.html"} 
               		{/if}
					{if isset($user_detail_tpl) and $user_detail_tpl eq "1"} 
               		{include file="./user_detail.html"} 
               		{/if}	
					{if isset($user_statistics_tpl) and $user_statistics_tpl eq "1"} 
               		{include file="./user_statistics.html"} 
               		{/if}	
					{if isset($crew_main_tpl) and $crew_main_tpl eq "1"} 
               		{include file="./crew_main.html"} 
               		{/if}
					{if isset($crew_search_tpl) and $crew_search_tpl eq "1"} 
               		{include file="./crew_search.html"} 
               		{/if}
					{if isset($demos_main_tpl) and $demos_main_tpl eq "1"} 
               		{include file="./demos_main.html"} 
               		{/if}	
					{if isset($demo_list_tpl) and $demo_list_tpl eq "1"} 
               		{include file="./demos_list.html"} 
               		{/if}	
					{if isset($demo_detail_tpl) and $demo_detail_tpl eq "1"} 
               		{include file="./demos_detail.html"} 
               		{/if}	
					{if isset($demo_screenshot_add_tpl) and $demo_screenshot_add_tpl eq "1"} 
               		{include file="./demos_screenshot_add.html"} 
               		{/if}	
					{if isset($demos_comment_tpl) and $demos_comment_tpl eq "1"} 
               		{include file="./demos_comment.html"} 
               		{/if}
					{if isset($demos_comment_edit_tpl) and $demos_comment_edit_tpl eq "1"} 
               		{include file="./demos_comment_edit.html"} 
               		{/if}
					{if isset($demos_upload_tpl) and $demos_upload_tpl eq "1"} 
               		{include file="./demos_upload.html"} 
               		{/if}
					{if isset($demos_music_list_tpl) and $demos_music_list_tpl eq "1"} 
               		{include file="./demos_music_list.html"} 
               		{/if}		
					{if isset($demos_music_detail_tpl) and $demos_music_detail_tpl eq "1"} 
               		{include file="./demos_music_detail.html"} 
               		{/if}	
					{if isset($demos_music_tpl) and $demos_music_tpl eq "1"} 
               		{include file="./demos_music.html"} 
               		{/if}
					{if isset($submission_demos_tpl) and $submission_demos_tpl eq "1"} 
               		{include file="./submission_demos.html"} 
               		{/if}
					{if isset($games_upload_tpl) and $games_upload_tpl eq "1"} 
               		{include file="./games_upload.html"} 
               		{/if}	
					{if isset($games_screenshot_add_tpl) and $games_screenshot_add_tpl eq "1"} 
               		{include file="./games_screenshot_add.html"} 
               		{/if}	
					{if isset($games_music_tpl) and $games_music_tpl eq "1"} 
               		{include file="./games_music.html"} 
               		{/if}
					{if isset($games_music_list_tpl) and $games_music_list_tpl eq "1"} 
               		{include file="./games_music_list.html"} 
               		{/if}		
					{if isset($games_music_detail_tpl) and $games_music_detail_tpl eq "1"} 
               		{include file="./games_music_detail.html"} 
               		{/if}	
					{if isset($user_karmasync_tpl) and $user_karmasync_tpl eq "1"} 
               		{include file="./user_karmasync.html"} 
               		{/if}
					{if isset($games_box_tpl) and $games_box_tpl eq "1"} 
               		{include file="./games_box.html"} 
               		{/if}
					{if isset($games_review_html) and $games_review_html eq "1"} 
               		{include file="./games_review.html"} 
               		{/if}
					{if isset($games_review_list_tpl) and $games_review_list_tpl eq "1"} 
               		{include file="./games_review_list.html"} 
               		{/if}
					{if isset($games_review_add_html) and $games_review_add_html eq "1"} 
               		{include file="./games_review_add.html"} 
               		{/if}
					{if isset($games_review_edit_html) and $games_review_edit_html eq "1"} 
               		{include file="./games_review_edit.html"} 
               		{/if}
					{if isset($games_review_preview_tpl) and $games_review_preview_tpl eq "1"} 
               		{include file="./games_review_preview.html"} 
               		{/if}
					{if isset($games_review_submitted_tpl) and $games_review_submitted_tpl eq "1"} 
               		{include file="./games_review_submitted.html"} 
               		{/if}
					{if isset($app_main_tpl) and $app_main_tpl eq "1"} 
               		{include file="./app_main.html"} 
               		{/if}
					{if isset($games_similar_tpl) and $games_similar_tpl eq "1"} 
               		{include file="./games_similar.html"} 
               		{/if}
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</body>
</html>

