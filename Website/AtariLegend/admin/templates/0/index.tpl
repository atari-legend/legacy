{* 
/***************************************************************************
*                                index.tpl
*                            --------------------------
*   begin                : 2005-01-06
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: index.tpl,v 0.10 2005/01/06 Silver
*
***************************************************************************/

//****************************************************************************************
// This is the index template file which all other sub templates are called in
//**************************************************************************************** 
*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<link href="../templates/0/css/atarilegend.css" hreflang="en" rel="stylesheet" type="text/css" charset="ISO-8859-1">
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
					{if $games_list_tpl eq "1" or $games_detail_tpl eq "1"} 
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
			
			<input type="checkbox" name="falcon_only" value="1"{if $games_falcon_only == 1} checked{/if}><strong>Falcon only&nbsp;</strong>
		<input type="checkbox" name="falcon_enhanced" value="1"{if $games_falcon_enhanced == 1} checked{/if}><strong>Falcon Enhanced&nbsp;</strong>
		<input type="checkbox" name="ste_only" value="1"{if $games_ste_only == 1} checked{/if}><strong>STE only</strong>
		<input type="checkbox" name="ste_enhanced" value="1"{if $games_ste_enhanced == 1} checked{/if}><strong>STE Enhanced&nbsp;</strong><br>
		<input type="checkbox" name="free" value="1"{if $games_free == 1} checked{/if}><strong>Non-Commercial&nbsp;</strong>
		<input type="checkbox" name="arcade" value="1"{if $games_arcade == 1} checked{/if}><strong>Arcade Conversion&nbsp;</strong>
		<input type="checkbox" name="development" value="1"{if $games_development == 1} checked{/if}><strong>In development&nbsp;</strong>
			
			
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

				{include file="../templates/0/leftnav.tpl"}
				</td>
				<!--Begin of Middle Comlumn-->
				<!--The middle column is called with a var-->	
    			<td width="84%" valign="top">
					{if $updates_tpl eq "1"}
					{include file="../templates/0/updates.tpl"}
					{/if}
					{if $statistics_tpl eq "1"}
					{include file="../templates/0/statistics.tpl"}
					{/if}
					{if $link_addnew_tpl eq "1"}
					{include file="../templates/0/link_addnew.tpl"}
					{/if}
					{if $link_modlist_tpl eq "1"}
					{include file="../templates/0/link_modlist.tpl"}
					{/if}
					{if $link_mod_tpl eq "1"}
					{include file="../templates/0/link_mod.tpl"}
					{/if}
					{if $link_validate_tpl eq "1"}
					{include file="../templates/0/link_validate.tpl"}
					{/if}
					{if $link_cat_tpl eq "1"}
					{include file="../templates/0/link_cat.tpl"}
					{/if}
					{if $link_cat_mod_tpl eq "1"}
					{include file="../templates/0/link_cat_mod.tpl"}
					{/if}
					{if $link_cat_del_tpl eq "1"}
					{include file="../templates/0/link_cat_del.tpl"}
					{/if}
					{if $error_message_tpl eq "1"}
					{include file="../templates/0/error_message.tpl"}
					{/if}
					{if $news_add_tpl eq "1"}
					{include file="../templates/0/news_add.tpl"}
					{/if}
					{if $news_iconpreview_tpl eq "1"}
					{include file="../templates/0/news_iconpreview.tpl"}
					{/if}
					{if $news_add_images_tpl eq "1"}
					{include file="../templates/0/news_add_images.tpl"}
					{/if}
					{if $news_edit_images_tpl eq "1"}
					{include file="../templates/0/news_edit_images.tpl"}
					{/if}
					{if $news_approve_tpl eq "1"}
					{include file="../templates/0/news_approve.tpl"}
					{/if}
					{if $news_edit_tpl eq "1"}
					{include file="../templates/0/news_edit.tpl"}
					{/if}
					{if $news_edit_all_tpl eq "1"}
					{include file="../templates/0/news_edit_all.tpl"}
					{/if}
					{if $submission_games_tpl eq "1"}
					{include file="../templates/0/submission_games.tpl"}
					{/if}
					{if $interviews_main_tpl eq "1"} 
              		{include file="../templates/0/interviews_main.tpl"} 
               		{/if}	
					{if $interviews_preview_tpl eq "1"} 
              		{include file="../templates/0/interviews_preview.tpl"} 
               		{/if}	
					{if $interviews_edit_tpl eq "1"} 
              		{include file="../templates/0/interviews_edit.tpl"} 
               		{/if}	
					{if $interviews_add_tpl eq "1"} 
              		{include file="../templates/0/interviews_add.tpl"} 
               		{/if}	
					{if $interviews_screenshots_add_tpl eq "1"} 
              		{include file="../templates/0/interviews_screenshots_add.tpl"} 
               		{/if}	
					{if $interviews_hlp_tpl eq "1"} 
              		{include file="../templates/0/interviews_help.tpl"} 
               		{/if}
					{if $individuals_main_tpl eq "1"} 
              		{include file="../templates/0/individuals_main.tpl"} 
               		{/if}	
					{if $individuals_edit_tpl eq "1"} 
              		{include file="../templates/0/individuals_edit.tpl"} 
               		{/if}	
					{if $individuals_author_tpl eq "1"} 
              		{include file="../templates/0/individuals_author.tpl"} 
               		{/if}
					{if $company_main_tpl eq "1"} 
              		{include file="../templates/0/company_main.tpl"} 
               		{/if}
					{if $company_edit_tpl eq "1"} 
              		{include file="../templates/0/company_edit.tpl"} 
               		{/if}	
					{if $company_logos_tpl eq "1"} 
              		{include file="../templates/0/company_logos.tpl"} 
               		{/if}
					{if $did_you_know_tpl eq "1"}
					{include file="../templates/0/did_you_know.tpl"}
					{/if}
					{if $manage_trivia_quotes_tpl eq "1"}
					{include file="../templates/0/manage_trivia_quotes.tpl"}
					{/if}
					{if $manage_trivia_screens_tpl eq "1"}
					{include file="../templates/0/manage_trivia_screens.tpl"}
					{/if}
					{if $games_main_tpl eq "1"} 
               		{include file="../templates/0/games_main.tpl"} 
               		{/if}	
					{if $games_list_html eq "1"} 
               		{include file="../templates/0/games_list.html"} 
               		{/if}
					{if $games_detail_tpl eq "1"} 
               		{include file="../templates/0/games_detail.tpl"} 
               		{/if}	
					{if $magazine_add_tpl eq "1"} 
               		{include file="../templates/0/magazine_add.tpl"} 
               		{/if}
					{if $magazine_manage_tpl eq "1"} 
               		{include file="../templates/0/magazine_manage.tpl"} 
               		{/if}
					{if $magazine_edit_tpl eq "1"} 
               		{include file="../templates/0/magazine_edit.tpl"} 
               		{/if}
					{if $magazine_issue_edit_tpl eq "1"} 
               		{include file="../templates/0/magazine_issue_edit.tpl"} 
               		{/if}
					{if $magazine_review_list_tpl eq "1"} 
               		{include file="../templates/0/magazine_review_list.tpl"} 
               		{/if}
					{if $magazine_review_score_tpl eq "1"} 
               		{include file="../templates/0/magazine_review_score.tpl"} 
               		{/if}
					{if $magazine_setscore_tpl eq "1"} 
               		{include file="../templates/0/magazine_setscore.tpl"} 
               		{/if}
					{if $games_comment_tpl eq "1"} 
               		{include file="../templates/0/games_comment.tpl"} 
               		{/if}
					{if $games_comment_edit_tpl eq "1"} 
               		{include file="../templates/0/games_comment_edit.tpl"} 
               		{/if}
					{if $games_series_main_tpl eq "1"} 
               		{include file="../templates/0/games_series_main.tpl"} 
               		{/if}
					{if $user_main_tpl eq "1"} 
               		{include file="../templates/0/user_main.tpl"} 
               		{/if}
					{if $user_search_tpl eq "1"} 
               		{include file="../templates/0/user_search.tpl"} 
               		{/if}
					{if $user_detail_tpl eq "1"} 
               		{include file="../templates/0/user_detail.tpl"} 
               		{/if}	
					{if $user_statistics_tpl eq "1"} 
               		{include file="../templates/0/user_statistics.tpl"} 
               		{/if}	
					{if $crew_main_tpl eq "1"} 
               		{include file="../templates/0/crew_main.tpl"} 
               		{/if}
					{if $crew_search_tpl eq "1"} 
               		{include file="../templates/0/crew_search.tpl"} 
               		{/if}
					{if $demos_main_tpl eq "1"} 
               		{include file="../templates/0/demos_main.tpl"} 
               		{/if}	
					{if $demo_list_tpl eq "1"} 
               		{include file="../templates/0/demos_list.tpl"} 
               		{/if}	
					{if $demo_detail_tpl eq "1"} 
               		{include file="../templates/0/demos_detail.tpl"} 
               		{/if}	
					{if $demo_screenshot_add_tpl eq "1"} 
               		{include file="../templates/0/demos_screenshot_add.tpl"} 
               		{/if}	
					{if $demos_comment_tpl eq "1"} 
               		{include file="../templates/0/demos_comment.tpl"} 
               		{/if}
					{if $demos_comment_edit_tpl eq "1"} 
               		{include file="../templates/0/demos_comment_edit.tpl"} 
               		{/if}
					{if $demos_upload_tpl eq "1"} 
               		{include file="../templates/0/demos_upload.tpl"} 
               		{/if}
					{if $demos_music_list_tpl eq "1"} 
               		{include file="../templates/0/demos_music_list.tpl"} 
               		{/if}		
					{if $demos_music_detail_tpl eq "1"} 
               		{include file="../templates/0/demos_music_detail.tpl"} 
               		{/if}	
					{if $demos_music_tpl eq "1"} 
               		{include file="../templates/0/demos_music.tpl"} 
               		{/if}
					{if $submission_demos_tpl eq "1"} 
               		{include file="../templates/0/submission_demos.tpl"} 
               		{/if}
					{if $games_upload_tpl eq "1"} 
               		{include file="../templates/0/games_upload.tpl"} 
               		{/if}	
					{if $games_screenshot_add_tpl eq "1"} 
               		{include file="../templates/0/games_screenshot_add.tpl"} 
               		{/if}	
					{if $games_music_tpl eq "1"} 
               		{include file="../templates/0/games_music.tpl"} 
               		{/if}
					{if $games_music_list_tpl eq "1"} 
               		{include file="../templates/0/games_music_list.tpl"} 
               		{/if}		
					{if $games_music_detail_tpl eq "1"} 
               		{include file="../templates/0/games_music_detail.tpl"} 
               		{/if}	
					{if $user_karmasync_tpl eq "1"} 
               		{include file="../templates/0/user_karmasync.tpl"} 
               		{/if}
					{if $games_box_tpl eq "1"} 
               		{include file="../templates/0/games_box.tpl"} 
               		{/if}
					{if $games_review_html eq "1"} 
               		{include file="../templates/0/games_review.html"} 
               		{/if}
					{if $games_review_list_tpl eq "1"} 
               		{include file="../templates/0/games_review_list.tpl"} 
               		{/if}
					{if $games_review_add_tpl eq "1"} 
               		{include file="../templates/0/games_review_add.tpl"} 
               		{/if}
					{if $games_review_edit_tpl eq "1"} 
               		{include file="../templates/0/games_review_edit.tpl"} 
               		{/if}
					{if $games_review_preview_tpl eq "1"} 
               		{include file="../templates/0/games_review_preview.tpl"} 
               		{/if}
					{if $games_review_submitted_tpl eq "1"} 
               		{include file="../templates/0/games_review_submitted.tpl"} 
               		{/if}
					{if $app_main_tpl eq "1"} 
               		{include file="../templates/0/app_main.tpl"} 
               		{/if}
					{if $games_similar_tpl eq "1"} 
               		{include file="../templates/0/games_similar.tpl"} 
               		{/if}
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</body>
</html>

