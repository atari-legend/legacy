{* 
/***************************************************************************
*                               user_statistics.tpl
*                            -----------------------
*   begin                : friday, November 11, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : file creation
*							
*
*   Id: user_statistics.tpl,v 0.10 2005/05/01 ST Graveman
*
***************************************************************************/

************************************************************************************************
The the user stats page
************************************************************************************************
*}

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	&nbsp;Statistics for user <a href="mailto:{$user.user_email}" class="MAINNAV_WHITE">{$user.username}</a>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td colspan="2" align="center">
	<fieldset class="category_set">
		Some statistics of this specific user.
	</fieldset> 
	</td>
</tr>
</table>


<table width="100%" cellspacing="2" cellpadding="15" class="CELLCOLOR">
<tr>
	<td>
	<fieldset class="game_set">
		<legend class="links_legend">User statistics</legend>
		<table width="100%">
		<tr>
			<td width="100%" valign="top">
				This user has posted <b>{if $nr_comments ==! ''}{$nr_comments}{else}0{/if}</b> game comments.
				{if $nr_comments ==! ''}
				<br>
				<br>
				The following games have been commented : 	
				<br>
				<br>
				{foreach from=$users_comments item=line}
					<a href="../games/games_detail.php?game_id={$line.game_id}" class="MAINNAV">{$line.game_name}</a>
					<br>
				{/foreach}		
				{/if}
			</td>
		</tr>
		<tr>
			<td width="100%" valign="top">
				<br>
				<br>
				This user has posted <b>{if $nr_reviews ==! ''}{$nr_reviews}{else}0{/if}</b> game reviews.
				{if $nr_reviews ==! ''}
				<br>
				<br>
				The following games have been reviewed : 	
				<br>
				<br>
				{foreach from=$users_reviews item=line}
					<a href="../administration/construction.php" class="MAINNAV">{$line.game_name}</a>
					<br>
				{/foreach}	
				{/if}	
			</td>
		</tr>
		<tr>
			<td width="100%" valign="top">
				<br>
				<br>
				This user has posted <b>{if $nr_submission ==! ''}{$nr_submission}{else}0{/if}</b> game submissions.
				{if $nr_submission ==! ''}
				<br>
				<br>
				The following submissions have been sent : 	
				<br>
				<br>
				{foreach from=$users_submission item=line}
					<a href="../administration/construction.php" class="MAINNAV">{$line.game_name}</a>
					<br>
				{/foreach}		
				{/if}
			</td>
		</tr>
		<tr>
			<td width="100%" valign="top">
				<br>
				<br>
				This user has posted <b>{if $nr_links ==! ''}{$nr_links}{else}0{/if}</b> links.
				{if $nr_links ==! ''}
				<br>
				<br>
				The following links have been sent : 	
				<br>
				<br>
				{foreach from=$users_website item=line}
					<a href="../links/link_mod.php?website_id={$line.website_id}" class="MAINNAV">{$line.website_name}</a>
					<br>
				{/foreach}		
				{/if}
			</td>
		</tr>
		<tr>
			<td width="100%" valign="top">
				<br>
				<br>
				This user has posted <b>{if $nr_news ==! ''}{$nr_news}{else}0{/if}</b> news updates.
				{if $nr_news ==! ''}
				<br>
				<br>
				The following updates have been sent : 	
				<br>
				<br>
				{foreach from=$users_news item=line}
					<a href="../news/news_edit.php?news_id={$line.news_id}" class="MAINNAV">{$line.news_headline}</a>
					<br>
				{/foreach}
				{/if}	
			</td>
		</tr>
		<tr>
			<td width="100%" valign="top">
				<br>
				<br>
				This user has downloaded <b>{if $nr_downloads ==! ''}{$nr_downloads}{else}0{/if}</b> games.
			</td>
		</table>
	</fieldset>
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
			<b><a href="../user/user_detail.php?user_id_selected={$user_id_selected}" class="MAINNAV">back</a></b>
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