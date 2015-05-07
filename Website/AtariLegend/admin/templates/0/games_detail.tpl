{* 
/***************************************************************************
 *                                games_detail.tpl
 *                            ------------------------
 *   begin                : Tuesday, September 11, 2005
 *   copyright            : (C) 2005 Atari Legend
 *   email                : admin@atarilegend.com
 *	 actual update        : Creation of file
 *
 *   Id: games_detail.tpl,v 0.10 2005/10/11 15:03 Zombieman
 *
 ***************************************************************************/

//****************************************************************************************
// This is the detail page of a game. Change all the specifics over here!
//**************************************************************************************** 
*}

{literal}
<script type="text/javascript">
function deletegame(game_id)
{
    // CONFIRM REQUIRES ONE ARGUMENT
    var message = "Are you sure you want to delete this game?";
    // CONFIRM IS BOOLEAN. THAT MEANS THAT
    // IT RETURNS TRUE IF 'OK' IS CLICKED
    // OTHERWISE IT RETURN FALSE
    var return_value = confirm(message);

    if (return_value !="0")
    {
    	url="../games/games_detail.php?game_id="+game_id+"&action=delete_game";
		location.href=url;
    }  
}

function delete_publisher() 
{
	document.publisher.method="post";
	document.publisher.action="../games/games_detail.php?action=delete_publisher";
   	document.publisher.submit();
}

function add_publisher() 
{
	document.publisher.method="post";
	document.publisher.action="../games/games_detail.php?action=add_publisher";
   	document.publisher.submit();
}

function delete_developer() 
{
	document.developer.method="post";
	document.developer.action="../games/games_detail.php?action=delete_developer";
   	document.developer.submit();
}

function add_developer() 
{
	document.developer.method="post";
	document.developer.action="../games/games_detail.php?action=add_developer";
   	document.developer.submit();
}

function delete_creator() 
{
	document.creator.method="post";
	document.creator.action="../games/games_detail.php?action=delete_creator";
   	document.creator.submit();
}

function add_creator() 
{
	document.creator.method="post";
	document.creator.action="../games/games_detail.php?action=add_creator";
   	document.creator.submit();
}

function delete_year() 
{
	document.year.method="post";
	document.year.action="../games/games_detail.php?action=delete_year";
   	document.year.submit();
}

function add_year() 
{
	document.year.method="post";
	document.year.action="../games/games_detail.php?action=add_year";
   	document.year.submit();
}
</script>
{/literal}

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Edit game - {$game_info.game_name}</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" class="CELLCOLOR">
<tr>
	<td>
	<fieldset class="category_set">
		<legend class="links_legend">Basic game info - help</legend>
		<table>
		<tr>
			<td width="100%" align="left" valign="top">
				Add this part of the screen you can add additional game info. Just select what you think is neceasrry, and press the modify button to link it all to the game.
				When you press the delete button, the complete game and all table entries linked to this game entity will be removed from the database!
			</td>
		</tr>
		</table>
	</fieldset> 
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" class="CELLCOLOR">
<tr>
	<td>
	<form action="../games/games_detail.php" method="post" name="edit">
	<fieldset class="game_set">
		<legend class="links_legend">Basic game info</legend>
		<table>
		<tr>
			<td width="100%" align="left" colspan="3">
				<b>Game name :</b> <input type="text" maxlength="255" name="game_name" value="{$game_info.game_name}">
			</td>
		</tr>
		<tr>
			<td width="75%" align="left">
				<table>
				<tr>
					<td width="33%" align="left">
						<br>
						<br>
						{if $game_info.game_unreleased == 1}
							<input type="checkbox" name="unreleased" value="1" checked>This game is unreleased&nbsp;
						{else}
							<input type="checkbox" name="unreleased" value="1">This game is unreleased&nbsp;
						{/if}
					</td>
					<td width="33%" align="left">
						<br>
						<br>
						{if $game_info.game_development == 1}
							<input type="checkbox" name="development" value="1" checked>This game is in development&nbsp;
						{else}
							<input type="checkbox" name="development" value="1">This game is in development&nbsp;
						{/if}
					</td>
				</tr>
				<tr>
					<td width="33%" align="left">
						{if $game_info.game_free == 1}
							<input type="checkbox" name="free" value="1" checked>This game is non-commercial&nbsp;
						{else}
							<input type="checkbox" name="free" value="1">This game is non-commercial&nbsp;
						{/if}
					</td>
					<td width="33%" align="left">
						{if $game_info.game_ste_only == 1}
							<input type="checkbox" name="ste_only" value="1" checked>This game is STE ONLY&nbsp;
						{else}
							<input type="checkbox" name="ste_only" value="1">This game is STE ONLY&nbsp;
						{/if}
					</td>
				</tr>
				<tr>
					<td width="33%" align="left">
						{if $game_info.game_ste_enhan == 1}
							<input type="checkbox" name="ste_enhanced" value="1" checked>This game is STE Enhanced&nbsp;
						{else}
							<input type="checkbox" name="ste_enhanced" value="1">This game is STE Enhanced&nbsp;
						{/if}
					</td>
					<td width="33%" align="left">
						{if $game_info.game_falcon_only == 1}
							<input type="checkbox" name="falcon_only" value="1" checked>This game is Falcon only&nbsp;
						{else}
							<input type="checkbox" name="falcon_only" value="1">This game is Falcon only&nbsp;
						{/if}
					</td>
				</tr>
				<tr>
					<td width="33%" align="left">
						{if $game_info.game_falcon_enhan == 1}
							<input type="checkbox" name="falcon_enhanced" value="1" checked>This game is Falcon Enhanced&nbsp;
						{else}
							<input type="checkbox" name="falcon_enhanced" value="1">This game is Falcon Enhanced&nbsp;
						{/if}
					</td>
					<td width="33%" align="left">
						{if $game_info.game_unfinished == 1}
							<input type="checkbox" name="unfinished" value="1" checked>This game was never completed&nbsp;
						{else}
							<input type="checkbox" name="unfinished" value="1">This game was never completed&nbsp;
						{/if}
					</td>
				</tr>
				<tr>
					<td width="33%" align="left">
						{if $game_info.game_mono == 1}
							<input type="checkbox" name="monochrome" value="1" checked>This game is mono res&nbsp;
						{else}
							<input type="checkbox" name="monochrome" value="1">This game is mono res&nbsp;
						{/if}
					</td>
					<td width="33%" align="left">
						{if $game_info.game_wanted <> ''}
							<input type="checkbox" name="wanted" value="1" checked>This game is wanted&nbsp;
						{else}
							<input type="checkbox" name="wanted" value="1">This game is wanted&nbsp;
						{/if}
					</td>
				</tr>
				<tr>
					<td width="33%" align="left">
						{if $game_info.game_arcade == 1}
							<input type="checkbox" name="arcade" value="1" checked>This game is an arcade conversion&nbsp;
						{else}
							<input type="checkbox" name="arcade" value="1">This game is an arcade conversion&nbsp;
						{/if}
					</td>
					<td width="33%" align="left">
						{if $game_info.game_seuck == 1}
							<input type="checkbox" name="seuck" value="1" checked>This game is a SEUCK game&nbsp;
						{else}
							<input type="checkbox" name="seuck" value="1">This game is a SEUCK game&nbsp;
						{/if}
					</td>
				</tr>
				<tr>
					<td width="33%" align="left">
						{if $game_info.game_stos == 1}
							<input type="checkbox" name="stos" value="1" checked>This game is a STOS game&nbsp;
						{else}
							<input type="checkbox" name="stos" value="1">This game is a STOS game&nbsp;
						{/if}
					</td>
					<td width="33%" align="left">
						{if $game_info.game_stac == 1}
							<input type="checkbox" name="stac" value="1" checked>This game is a STAC game&nbsp;
						{else}
							<input type="checkbox" name="stac" value="1">This game is a STAC game&nbsp;
						{/if}
					</td>
				</tr>
				</table>
			</td>
			<td width="25%" align="left">
				<b>Category</b>
				<br>
				<select name="category[]" multiple size="8">
				{foreach from=$cat item=line}
					<option value="{$line.cat_id}" {$line.cat_selected}>{$line.cat_name}</option>
				{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td width="100%" align="left" colspan="3">
				<br><br>
				<input type="submit" name="valider" value="Modify">
				<input type="button" name="delete" value="Delete" onClick="deletegame({$game_id}); return false;">	
				<input type="hidden" name="action" value="modify_game">	
				<input type="hidden" name="game_id" value="{$game_id}">	
			</td>
		</tr>
		</table>
	</fieldset>
	</form>
	</td>	
</tr>	
</table>

<table width="100%" cellspacing="2" cellpadding="15" class="CELLCOLOR">
<tr>
	<td>
	<fieldset class="category_set">
		<legend class="links_legend">Publisher/Developer/Creator info - help</legend>
		<table>
		<tr>
			<td width="100%" align="left" valign="top">
				You can add as many publishers/developers/creators as you like to a game. Use the continent dropdown for example to add in which part of the world
				the game was released by that particular Publisher. The info dropdown is used for adding budget release info, or arcade release info. 
			</td>
		</tr>
		</table>
	</fieldset> 
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" class="CELLCOLOR">
<tr>
	<td width="33%">
	<form action="../games/games_detail.php" method="post" name="publisher">
	<fieldset class="game_set">
		<legend class="links_legend">Publisher info</legend>
			<table width="100%">
			<tr>
				<td width="33%">		
					{foreach from=$publisher item=line}
						<input type="checkbox" name="game_publisher_id[]" value="{$line.pub_id}">
					  		<a href="../company/company_edit.php?comp_id={$line.pub_id}" class="MAINNAV">{$line.pub_name}</a> {if $line.continent <> '' }<b>({$line.continent})</b>{/if} {if  $line.extra_info <> '' }<b>({$line.extra_info})</b>{/if} 					
					  	<br>
					  	<br>
					{/foreach}					
					<img src="../templates/0/images/arrow_ltr.gif" alt="" width="38" height="22" border="0">		
					<input type="button" name="valider" value="Delete" onclick="delete_publisher()">
					<br>
					<br>
					<select name="company_id_pub" class="authorSelects">
						<option value="-" selected>-</option>
						{foreach from=$company item=line}
							<option value="{$line.comp_id}">{$line.comp_name}</option>
						{/foreach}
					</select>
					<input type="hidden" value="{$line.comp_name}" name="pub_name">
					<b>Name</b>		
					<br>
					<select name="continent_pub" class="continentSelects">
						<option value="-" selected>-</option>
						{foreach from=$continent item=line}
							<option value="{$line.continent_id}">{$line.continent_name}</option>
						{/foreach}		
					</select>
					<b>Continent</b>
					<br>
					<select name="game_extra_info_pub" class="continentSelects">
						<option value="-" selected>-</option>
						{foreach from=$game_extra_info item=line}
							<option value="{$line.game_extra_info_id}">{$line.game_extra_info}</option>							
						{/foreach}		
					</select>	
					<b>Extra Info</b>					
					<br><br>
					<input type="hidden" name="game_id" value="{$game_id}">
					<input type="button" value="Add" onclick="add_publisher()">
				</td>
			</tr>
			</table>
	</fieldset>
	</form>
	</td>
	<td width="33%">
	<form action="../games/games_detail.php" method="post" name="developer">
	<fieldset class="game_set">
		<legend class="links_legend">Developer info</legend>
			<table width="100%">
			<tr>
				<td width="33%">	
					{foreach from=$developer item=line}
						<input type="checkbox" name="game_developer_id[]" value="{$line.pub_id}">
					  	<a href="../company/company_edit.php?comp_id={$line.pub_id}" class="MAINNAV">{$line.pub_name}</a> {if $line.continent <> '' }<b>({$line.continent})</b>{/if} {if  $line.extra_info <> '' }<b>({$line.extra_info})</b>{/if}
					  	<br>
					  	<br>
					{/foreach}
				 	<img src="../templates/0/images/arrow_ltr.gif" alt="" width="38" height="22" border="0">		
				 	<input type="button" name="valider" value="Delete" onclick="delete_developer()">
					<br>
					<br>
					<select name="company_id_dev" class="authorSelects">
						<option value="-" selected>-</option>
						{foreach from=$company item=line}
							<option value="{$line.comp_id}">{$line.comp_name}</option>
						{/foreach}
					</select>
					<b>Name</b>		
					<br>
					<select name="continent_dev" class="continentSelects">
						<option value="-" selected>-</option>
						{foreach from=$continent item=line}
							<option value="{$line.continent_id}">{$line.continent_name}</option>
						{/foreach}		
					</select>	
					<b>Continent</b>
					<br>
					<select name="game_extra_info_dev" class="continentSelects">
						<option value="-" selected>-</option>
						{foreach from=$game_extra_info item=line}
							<option value="{$line.game_extra_info_id}">{$line.game_extra_info}</option>
						{/foreach}			
					</select>	
					<b>Extra Info</b>				
					<br><br>
					<input type="hidden" name="game_id" value="{$game_id}">
					<input type="button" value="Add" onclick="add_developer()">
				</td>
			</tr>
			</table>
	</fieldset>
	</form>
	</td>
	<td width="33%">
	<form action="../games/games_detail.php" method="post" name="creator">
	<fieldset class="game_set">
		<legend class="links_legend">Creator info</legend>
			<table width="100%">
			<tr>
				<td width="33%">	
					{foreach from=$game_author item=line}
						<input type="checkbox" name="game_author_id[]" value="{$line.game_author_id}">
					  		<a href="../individuals/individuals_edit.php?ind_id={$line.ind_id}" class="MAINNAV">{$line.ind_name}</a> <b>({$line.auhthor_type_info})</b>
					  	<br>
					  	<br>
					{/foreach}
				 	<img src="../templates/0/images/arrow_ltr.gif" alt="" width="38" height="22" border="0">		
				 	<input type="button" name="valider" value="Delete" onclick="delete_creator()">
					<br>
					<br>
					<select name="ind_id" class="authorSelects">
					<option value="-" selected>-</option>
					{foreach from=$individuals item=line}
						<option value="{$line.ind_id}">{$line.ind_name}</option>
					{/foreach}
					</select>
					<b>Name</b>		
					<br>
					<select name="author_type_id" class="authorSelects">
					<option value="-" selected>-</option>
					{foreach from=$author_types item=line}
						<option value="{$line.author_type_id}">{$line.author_type}</option>
					{/foreach}
					</select>
					<b>Job</b>		
					<br><br>
					<input type="hidden" name="game_id" value="{$game_id}">
					<input type="button" value="Add" onclick="add_creator()">
				</td>
			</tr>
			</table>
	</fieldset>
	</form>
	</td>
</tr>
<tr>
	<td width="33%" align="center">
	<form action="../games/games_detail.php" method="post" name="year">
	<fieldset class="game_set">
		<legend class="links_legend">Release Year</legend>
			<table width="100%">
			<tr>
				<td width="33%">	
				{foreach from=$game_year item=line}
					<input type="checkbox" name="game_year_id[]" value="{$line.game_year_id}">{$line.game_year} {if  $line.game_extra_info <> ''}<b>({$line.game_extra_info})</b>{/if}
					<br>
					<br>
				{/foreach}
				<img src="../templates/0/images/arrow_ltr.gif" alt="" width="38" height="22" border="0">		
				 <input type="button" name="valider" value="Delete" onclick="delete_year()">
				<br>
				<br>
				{html_select_date start_year=1984 display_days=0 display_months=0}
				<b>Release Year</b>	
				<br>
				<select name="game_extra_info_year" class="continentSelects">
					<option value="-" selected>-</option>
					{foreach from=$game_extra_info item=line}
						<option value="{$line.game_extra_info_id}">{$line.game_extra_info}</option>
					{/foreach}			
				</select>	
				<b>Extra Info</b>			
				<br><br>
				<input type="hidden" name="game_id" value="{$game_id}">
				<input type="button" value="Add" onclick="add_year()">
				</td>
			</tr>
			</table>
	</fieldset>
	</form>
	</td>
	<td width="33%" align="center">
		
	</td>
	<td width="33%" align="center">
		<form action="../games/games_detail.php" method="post" name="aka">
		<fieldset class="game_set">
			<legend class="links_legend">Add game AKA</legend>
			<b>Game AKA :</b> <input type="text" name="game_aka">
			<br>
			<input type="submit" name="valider" value="Add">
			<input type="hidden" name="action" value="game_aka">	
			<input type="hidden" name="game_id" value="{$game_id}">	
			<br>
			<br>
			{if $nr_aka <> 0}
				<b>Current AKA</b>
				<br>
				{foreach from=$aka item=line}
					<a href="../games/games_detail.php?game_id={$line.game_id}" class="MAINNAV">{$line.game_aka_name}</a> - <b><a href="../games/games_detail.php?game_aka_id={$line.game_aka_id}&action=delete_aka&game_id={$line.game_id}" class="MAINNAV">delete</a></b> 
					<br>
				{/foreach}
			{/if}
		</fieldset>
		</form>
	</td>
</tr>
<tr>
	<td width="33%" align="center">
	<fieldset class="game_set">
		<legend class="links_legend">Other Features</legend>
			<table width="100%">
			<tr>
				<td width="33%" align="center">	
					<b><a href="../games/games_upload.php?game_id={$game_info.game_id}" class="MAINNAV">Add file download</a></b><br>
				  	<b><a href="../administration/construction.php" class="MAINNAV">Image Gallery</a></b><br>					
					<b><a href="../games/games_screenshot_add.php?game_id={$game_info.game_id}&game_name={$game_info.game_name}" class="MAINNAV">Add screenshots</a></b><br>
					<b><a href="../magazine/magazine_review_score.php?game_id={$game_info.game_id}&game_name={$game_info.game_name}" class="MAINNAV">Add Mag review score</a></b><br>
					<b><a href="../games/games_box.php?game_id={$game_info.game_id}&game_name={$game_info.game_name}" class="MAINNAV">Add boxscans</a></b><br>
					<b><a href="../games/games_similar.php?game_id={$game_info.game_id}&game_name={$game_info.game_name}" class="MAINNAV">Add Similar Games</a></b><br>
					<b><a href="../administration/construction.php" class="MAINNAV">Write a review</a></b><br>
					<br>
					<b><a href="../administration/construction.php" class="MAINNAV">Moderate comments</a></b>
				</td>
			</tr>
			</table>
	</fieldset>
	</td>
	<td width="33%" align="center">
		<fieldset class="game_set">
		<legend class="links_legend">Statistics</legend>
			<table width="100%">
			<tr>
				<td width="33%" align="center">	
					Nr of Screenshots - {$nr_screenshots}<br>
					Nr of Box scans - {$nr_boxscans}<br>
					Nr of reviews - {$nr_reviews}<br>
					Nr of entries in the Gallery - {$nr_pics}<br>
					Nr of music files - {$nr_music}<br>
					Nr of magazine reviews - {$nr_magazines}<br>
				</td>
			</tr>
			</table>
		</fieldset>
	</td>
	<td width="33%" align="center"></td>
</tr>
</table>
<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td>
 	<span class="LEFTNAVHEADING">&nbsp;&nbsp;&nbsp;</span>
	</td>
</tr>
</table>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
   		<td colspan="3" valign=top align=center>
			<b><a href="../games/games_main.php" class="MAINNAV">back</a></b>
		</td>
	</tr>
</table>
<br>

{if $message <> ''}
	<table align="center" width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td align="center" >
			<br><br>
			<span class="MAINAV">{$message}</span>
		</td>
	</tr>
	</table>
{/if}