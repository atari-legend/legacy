{* 
/***************************************************************************
                              games_review_list.tpl
*                            --------------------------
*   begin                : Sunday, November 27, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: games_review_list.tpl,v 0.10 2005/11/27 Gatekeeper
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
		This is the search result page. Click a game to go to the main review page. 
		If you want to do a new search query, click <a href="games_review.php" class="MAINNAV"><b>here</b></a>!
	</fieldset> 
	</td>
</tr>
<tr>
	<td align="center">
		<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
		<tr>
			<td valign="top" width="30%"><b>Game Name</b></td>
			<td valign="top" width="30%"><b>Publisher</b></td>
			<td valign="top" width="25%"><b>Year</b></td>
			<td valign="top" width="15%"><b>Nr of reviews</b></td>		
		</tr>
		</table>
		<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border: solid 1px #b2b2b2; background-color:#E9E9E9;">
		{foreach from=$review item=line}
		<tr bgcolor="{cycle name="tr" values="#EFEFEF,#E9E9E9"}">
			<td width="30%" valign="top">{if $line.game_name != ''}<a href="games_review_add.php?game_id={$line.game_id}" class="MAINNAV">{$line.game_name}</a>{else}<i>n/a</i>{/if}</td>
			<td width="30%" valign="top">{if $line.game_publisher != ''}{$line.game_publisher}{else}<i>n/a</i>{/if}</td>
			<td width="30%" valign="top">{if $line.game_year != ''}{$line.game_year}{else}<i>n/a</i>{/if}</td>				
			<td width="10%" valign="top">{if $line.number_reviews != ''}{$line.number_reviews}{else}<i>0</i>{/if}</td>
		</tr>
		{/foreach}
		</table>	
		<table cellspacing="0" cellpadding="2" border="0" width="90%" style="border-left: solid 1px #b2b2b2; border-left: solid 1px #b2b2b2; border-right: solid 1px #b2b2b2; border-bottom: solid 1px #b2b2b2;background-color:#E9E9E9;">
		<tr>
			<td valign="top" width="100%"><b>{if $nr_of_entries == 1}1 game found {else} {$nr_of_entries} games found{/if} in {$querytime} sec</b></td>
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
			<b><a href="../games/games_review.php" class="MAINNAV">back</a></b>
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