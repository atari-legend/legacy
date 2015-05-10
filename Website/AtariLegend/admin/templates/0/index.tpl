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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
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

				{include file='./leftnav.tpl'}
				</td>
				<!--Begin of Middle Comlumn-->
				<!--The middle column is called with a var-->	
    			<td width="84%" valign="top">
					{if isset($updates_tpl) and $updates_tpl eq "1"}
					{include file="./updates.tpl"}
					{/if}
					{if isset($statistics_tpl) and $statistics_tpl eq "1"}
					{include file="./statistics.tpl"}
					{/if}
					{if isset($link_addnew_tpl) and $link_addnew_tpl eq "1"}
					{include file="./link_addnew.tpl"}
					{/if}
					{if isset($link_modlist_tpl) and $link_modlist_tpl eq "1"}
					{include file="./link_modlist.tpl"}
					{/if}
					{if isset($link_mod_tpl) and $link_mod_tpl eq "1"}
					{include file="./link_mod.tpl"}
					{/if}
					{if isset($link_validate_tpl) and $link_validate_tpl eq "1"}
					{include file="./link_validate.tpl"}
					{/if}
					{if isset($link_cat_tpl) and $link_cat_tpl eq "1"}
					{include file="./link_cat.tpl"}
					{/if}
					{if isset($link_cat_mod_tpl) and $link_cat_mod_tpl eq "1"}
					{include file="./link_cat_mod.tpl"}
					{/if}
					{if isset($link_cat_del_tpl) and $link_cat_del_tpl eq "1"}
					{include file="./link_cat_del.tpl"}
					{/if}
					{if isset($error_message_tpl) and $error_message_tpl eq "1"}
					{include file="./error_message.tpl"}
					{/if}
					{if isset($news_add_tpl) and $news_add_tpl eq "1"}
					{include file="./news_add.tpl"}
					{/if}
					{if isset($news_iconpreview_tpl) and $news_iconpreview_tpl eq "1"}
					{include file="./news_iconpreview.tpl"}
					{/if}
					{if isset($news_add_images_tpl) and $news_add_images_tpl eq "1"}
					{include file="./news_add_images.tpl"}
					{/if}
					{if isset($news_edit_images_tpl) and $news_edit_images_tpl eq "1"}
					{include file="./news_edit_images.tpl"}
					{/if}
					{if isset($news_approve_tpl) and $news_approve_tpl eq "1"}
					{include file="./news_approve.tpl"}
					{/if}
					{if isset($news_edit_tpl) and $news_edit_tpl eq "1"}
					{include file="./news_edit.tpl"}
					{/if}
					{if isset($news_edit_all_tpl) and $news_edit_all_tpl eq "1"}
					{include file="./news_edit_all.tpl"}
					{/if}
					{if isset($submission_games_tpl) and $submission_games_tpl eq "1"}
					{include file="./submission_games.tpl"}
					{/if}
					{if isset($interviews_main_tpl) and $interviews_main_tpl eq "1"} 
              		{include file="./interviews_main.tpl"} 
               		{/if}	
					{if isset($interviews_preview_tpl) and $interviews_preview_tpl eq "1"} 
              		{include file="./interviews_preview.tpl"} 
               		{/if}	
					{if isset($interviews_edit_tpl) and $interviews_edit_tpl eq "1"} 
              		{include file="./interviews_edit.tpl"} 
               		{/if}	
					{if isset($interviews_add_tpl) and $interviews_add_tpl eq "1"} 
              		{include file="./interviews_add.tpl"} 
               		{/if}	
					{if isset($interviews_screenshots_add_tpl) and $interviews_screenshots_add_tpl eq "1"} 
              		{include file="./interviews_screenshots_add.tpl"} 
               		{/if}	
					{if isset($interviews_hlp_tpl) and $interviews_hlp_tpl eq "1"} 
              		{include file="./interviews_help.tpl"} 
               		{/if}
					{if isset($individuals_main_tpl) and $individuals_main_tpl eq "1"} 
              		{include file="./individuals_main.tpl"} 
               		{/if}	
					{if isset($individuals_edit_tpl) and $individuals_edit_tpl eq "1"} 
              		{include file="./individuals_edit.tpl"} 
               		{/if}	
					{if isset($individuals_author_tpl) and $individuals_author_tpl eq "1"} 
              		{include file="./individuals_author.tpl"} 
               		{/if}
					{if isset($company_main_tpl) and $company_main_tpl eq "1"} 
              		{include file="./company_main.tpl"} 
               		{/if}
					{if isset($company_edit_tpl) and $company_edit_tpl eq "1"} 
              		{include file="./company_edit.tpl"} 
               		{/if}	
					{if isset($company_logos_tpl) and $company_logos_tpl eq "1"} 
              		{include file="./company_logos.tpl"} 
               		{/if}
					{if isset($did_you_know_tpl) and $did_you_know_tpl eq "1"}
					{include file="./did_you_know.tpl"}
					{/if}
					{if isset($manage_trivia_quotes_tpl) and $manage_trivia_quotes_tpl eq "1"}
					{include file="./manage_trivia_quotes.tpl"}
					{/if}
					{if isset($manage_trivia_screens_tpl) and $manage_trivia_screens_tpl eq "1"}
					{include file="./manage_trivia_screens.tpl"}
					{/if}
					{if isset($games_main_tpl) and $games_main_tpl eq "1"} 
               		{include file="./games_main.tpl"} 
               		{/if}	
					{if isset($games_list_html) and $games_list_html eq "1"} 
               		{include file="./games_list.html"} 
               		{/if}
					{if isset($games_detail_tpl) and $games_detail_tpl eq "1"} 
               		{include file="./games_detail.tpl"} 
               		{/if}	
					{if isset($magazine_add_tpl) and $magazine_add_tpl eq "1"} 
               		{include file="./magazine_add.tpl"} 
               		{/if}
					{if isset($magazine_manage_tpl) and $magazine_manage_tpl eq "1"} 
               		{include file="./magazine_manage.tpl"} 
               		{/if}
					{if isset($magazine_edit_tpl) and $magazine_edit_tpl eq "1"} 
               		{include file="./magazine_edit.tpl"} 
               		{/if}
					{if isset($magazine_issue_edit_tpl) and $magazine_issue_edit_tpl eq "1"} 
               		{include file="./magazine_issue_edit.tpl"} 
               		{/if}
					{if isset($magazine_review_list_tpl) and $magazine_review_list_tpl eq "1"} 
               		{include file="./magazine_review_list.tpl"} 
               		{/if}
					{if isset($magazine_review_score_tpl) and $magazine_review_score_tpl eq "1"} 
               		{include file="./magazine_review_score.tpl"} 
               		{/if}
					{if isset($magazine_setscore_tpl) and $magazine_setscore_tpl eq "1"} 
               		{include file="./magazine_setscore.tpl"} 
               		{/if}
					{if isset($games_comment_tpl) and $games_comment_tpl eq "1"} 
               		{include file="./games_comment.tpl"} 
               		{/if}
					{if isset($games_comment_edit_tpl) and $games_comment_edit_tpl eq "1"} 
               		{include file="./games_comment_edit.tpl"} 
               		{/if}
					{if isset($games_series_main_tpl) and $games_series_main_tpl eq "1"} 
               		{include file="./games_series_main.tpl"} 
               		{/if}
					{if isset($user_main_tpl) and $user_main_tpl eq "1"} 
               		{include file="./user_main.tpl"} 
               		{/if}
					{if isset($user_search_tpl) and $user_search_tpl eq "1"} 
               		{include file="./user_search.tpl"} 
               		{/if}
					{if isset($user_detail_tpl) and $user_detail_tpl eq "1"} 
               		{include file="./user_detail.tpl"} 
               		{/if}	
					{if isset($user_statistics_tpl) and $user_statistics_tpl eq "1"} 
               		{include file="./user_statistics.tpl"} 
               		{/if}	
					{if isset($crew_main_tpl) and $crew_main_tpl eq "1"} 
               		{include file="./crew_main.tpl"} 
               		{/if}
					{if isset($crew_search_tpl) and $crew_search_tpl eq "1"} 
               		{include file="./crew_search.tpl"} 
               		{/if}
					{if isset($demos_main_tpl) and $demos_main_tpl eq "1"} 
               		{include file="./demos_main.tpl"} 
               		{/if}	
					{if isset($demo_list_tpl) and $demo_list_tpl eq "1"} 
               		{include file="./demos_list.tpl"} 
               		{/if}	
					{if isset($demo_detail_tpl) and $demo_detail_tpl eq "1"} 
               		{include file="./demos_detail.tpl"} 
               		{/if}	
					{if isset($demo_screenshot_add_tpl) and $demo_screenshot_add_tpl eq "1"} 
               		{include file="./demos_screenshot_add.tpl"} 
               		{/if}	
					{if isset($demos_comment_tpl) and $demos_comment_tpl eq "1"} 
               		{include file="./demos_comment.tpl"} 
               		{/if}
					{if isset($demos_comment_edit_tpl) and $demos_comment_edit_tpl eq "1"} 
               		{include file="./demos_comment_edit.tpl"} 
               		{/if}
					{if isset($demos_upload_tpl) and $demos_upload_tpl eq "1"} 
               		{include file="./demos_upload.tpl"} 
               		{/if}
					{if isset($demos_music_list_tpl) and $demos_music_list_tpl eq "1"} 
               		{include file="./demos_music_list.tpl"} 
               		{/if}		
					{if isset($demos_music_detail_tpl) and $demos_music_detail_tpl eq "1"} 
               		{include file="./demos_music_detail.tpl"} 
               		{/if}	
					{if isset($demos_music_tpl) and $demos_music_tpl eq "1"} 
               		{include file="./demos_music.tpl"} 
               		{/if}
					{if isset($submission_demos_tpl) and $submission_demos_tpl eq "1"} 
               		{include file="./submission_demos.tpl"} 
               		{/if}
					{if isset($games_upload_tpl) and $games_upload_tpl eq "1"} 
               		{include file="./games_upload.tpl"} 
               		{/if}	
					{if isset($games_screenshot_add_tpl) and $games_screenshot_add_tpl eq "1"} 
               		{include file="./games_screenshot_add.tpl"} 
               		{/if}	
					{if isset($games_music_tpl) and $games_music_tpl eq "1"} 
               		{include file="./games_music.tpl"} 
               		{/if}
					{if isset($games_music_list_tpl) and $games_music_list_tpl eq "1"} 
               		{include file="./games_music_list.tpl"} 
               		{/if}		
					{if isset($games_music_detail_tpl) and $games_music_detail_tpl eq "1"} 
               		{include file="./games_music_detail.tpl"} 
               		{/if}	
					{if isset($user_karmasync_tpl) and $user_karmasync_tpl eq "1"} 
               		{include file="./user_karmasync.tpl"} 
               		{/if}
					{if isset($games_box_tpl) and $games_box_tpl eq "1"} 
               		{include file="./games_box.tpl"} 
               		{/if}
					{if isset($games_review_html) and $games_review_html eq "1"} 
               		{include file="./games_review.html"} 
               		{/if}
					{if isset($games_review_list_tpl) and $games_review_list_tpl eq "1"} 
               		{include file="./games_review_list.tpl"} 
               		{/if}
					{if isset($games_review_add_tpl) and $games_review_add_tpl eq "1"} 
               		{include file="./games_review_add.tpl"} 
               		{/if}
					{if isset($games_review_edit_tpl) and $games_review_edit_tpl eq "1"} 
               		{include file="./games_review_edit.tpl"} 
               		{/if}
					{if isset($games_review_preview_tpl) and $games_review_preview_tpl eq "1"} 
               		{include file="./games_review_preview.tpl"} 
               		{/if}
					{if isset($games_review_submitted_tpl) and $games_review_submitted_tpl eq "1"} 
               		{include file="./games_review_submitted.tpl"} 
               		{/if}
					{if isset($app_main_tpl) and $app_main_tpl eq "1"} 
               		{include file="./app_main.tpl"} 
               		{/if}
					{if isset($games_similar_tpl) and $games_similar_tpl eq "1"} 
               		{include file="./games_similar.tpl"} 
               		{/if}
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</body>
</html>

