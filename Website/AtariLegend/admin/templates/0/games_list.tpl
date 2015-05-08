{* 
/***************************************************************************
                              games_list.tpl
*                            --------------------------
*   begin                : Sunday, August 28, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: games_list.tpl,v 0.10 2005/08/28 22:02 Gatekeeper
*
***************************************************************************/

************************************************************************************************
The main game page
************************************************************************************************
*}

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Search results</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td colspan="2">
	<fieldset class="category_set">
		This is the search result page. Click a game to go to the main page. Click a Publisher/Developer/Year to do a new search.
		If you want to do a new search query or like to add a new game, click <a href="games_main.php" class="MAINNAV"><b>here</b></a>!
	</fieldset> 
	</td>
</tr>
<tr>
	<td align="center">
		<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
		<tr>
			<td valign="top" width="25%"><b>Game Name</b></td>
			<td valign="top" width="25%"><b>Publisher</b></td>
			<td valign="top" width="25%"><b>Developer</b></td>
			<td valign="top" width="10%"><b>Year</b></td>
			<td valign="top" width="15%"><b>Info</b></td>			
		</tr>
		</table>
		<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
		{foreach from=$game_search item=line}
		<tr bgcolor="{cycle name="tr" values="#EFEFEF,#E9E9E9"}">
			<td width="25%" valign="top">{if $line.game_name != ''}<a href="games_detail.php?game_id={$line.game_id}" class="MAINNAV">{$line.game_name}</a>{else}<i>n/a</i>{/if}</td>
			<td width="25%" valign="top">{if $line.publisher_name != ''}<a href="games_main.php?publisher={$line.publisher_id}&amp;action=search" class="MAINNAV">{$line.publisher_name}</a>{else}<i>n/a</i>{/if}</td>
			<td width="25%" valign="top">{if $line.developer_name != ''}<a href="games_main.php?developer={$line.developer_id}&amp;action=search" class="MAINNAV">{$line.developer_name}</a>{else}<i>n/a</i>{/if}</td>				
			<td width="10%" valign="top">{if $line.year != ''}<a href="games_main.php?year={$line.year}&amp;action=search" class="MAINNAV">{$line.year}</a>{else}<i>n/a</i>{/if}</td>
			<td width="15%" valign="top">
				{if $line.screenshot != ''}<img src="../templates/0/icons/screen.gif" alt="Screenshots available" hspace="0" vspace="0" border="0" title="Screenshot Available">{/if}
				{if $line.music != ''}<img src="../templates/0/icons/sound.gif" alt="Music available" hspace="0" vspace="0" border="0" title="Music Available">{/if}
				{if $line.boxscan != ''}<img src="../templates/0/icons/scan.gif" alt="Boxscan available" hspace="0" vspace="0" border="0" title="Boxscan Available">{/if}
				{if $line.download != ''}<img src="../templates/0/icons/disk.gif" alt="Download available" hspace="0" vspace="0" border="0" title="Download Available">{/if}
				{if $line.ste_enhan != '' or $line.ste_only !=''}<img src="../templates/0/icons/ste.png" alt="STE Game" hspace="0" vspace="0" border="0" title="STE Game">{/if}
				{if $line.falcon_only != '' or $line.falcon.enhan !=''}<img src="../templates/0/icons/falcon.png" alt="Falcon Game" hspace="0" vspace="0" border="0" title="Falcon Game">{/if}
			</td>
		</tr>
		{/foreach}
		</table>	
		<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border-left: solid 1px #b2b2b2; border-left: solid 1px #b2b2b2; border-right: solid 1px #b2b2b2; border-bottom: solid 1px #b2b2b2;background-color:#E9E9E9;">
		<tr>
			<td valign="top" width="100%"><b>{if $nr_of_games == 1}1 game found {else} {$nr_of_games} games found{/if} in {$query_time} sec</b></td>
		</tr>
		</table>
		<br>
	</td>
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
<br>
<br>