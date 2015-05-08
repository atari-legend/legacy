{* 
/***************************************************************************
*                                games_review_submitted.tpl
*                            -------------------------------
*   begin                : Sunday, December 04, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : created this page
*
*   Id: games_review_submitted.tpl,v 0.10 2005/12/04 Gatekeeper
*
***************************************************************************/

************************************************************************************************
The submitted review page
************************************************************************************************
*}

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Submitted game reviews</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td colspan="2" align="center">
	<fieldset class="category_set">
		In this section you can edit the submitted reviews
	</fieldset> 
	</td>
</tr>
<tr>
	<td align="center">
		<fieldset class="game_set">
		<legend class="links_legend">Submitted Reviews</legend>
		<table>
		<tr>
			{if $submission_nr != '0'}
			<td>
				{foreach from=$review item=line}
					<a href="../games/games_review_edit.php?reviewid={$line.review_id}&game_id={$line.game_id}" class="MAINNAV"><b>{$line.game_name}</b></a> reviewed by <a href="../user/user_detail.php?user_id_selected={$line.user_id}" class="MAINNAV"><b>{$line.userid}</b></a><br>
				{/foreach}
			</td>
			{else}
			<td>
				No reviews submitted today!
			</td>
			{/if}
		</tr>
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