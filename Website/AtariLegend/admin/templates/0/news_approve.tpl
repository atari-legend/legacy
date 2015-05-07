{* 
/***************************************************************************
*                                news_approve.tpl
*                            ---------------------------
*   begin                : Thursday, May 5, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : File creation
*
*   Id: news_approve.tpl,v 0.10 2004/05/05 ST Graveyard
*
***************************************************************************/
****************************************************************************
 This is the sub template file to generate the news approve page
****************************************************************************
*}

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Approve News</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	<fieldset class="category_set">
		This is the approval page. News send in by users, or news which has just been added, 
		should be approved by the admin users before it gets online at the front porche of AL.
	</fieldset> 
	</td>
</tr>
{if $nr_submissions <> '0'}
<tr>
	<td align="center">
	{foreach from=$news_submissions item=line}
		<fieldset class="news_set">
		<legend class="links_legend">
			{if $line.user_email <> ''}
				Written by <a href="mailto:{$line.user_email}?subject=Your newspost {$line.news_headline} at Atari Legend" class="MAINNAV">{$line.news_userid}</a> on {$line.news_date}
			{else}
				Written by {$line.news_userid} on {$line.news_date}
			{/if}
		</legend>
		<table>
		<tr>
			<td colspan="2">
				<b>Headline - {$line.news_headline}</b>
				<br>
				<br>
			<td>
		</tr>
		<tr>
			<td width="20%" valign="top">
				<img src="../includes/showimage.php?img={$line.news_icon}&amp;w=90&amp;shadow=1&amp;bgcolour=FFFFFF" alt="newsbutton">
			</td>
			<td width="80%">
				<i>{$line.news_text}</i>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2">
				<br>
				<a href="news_approve.php?action=approve&amp;news_submission_id={$line.news_submission_id}" class="MAINNAV">APPROVE</a> :: 
				<a href="news_edit.php?news_submission_id={$line.news_submission_id}" class="MAINNAV">EDIT</a> :: 
				<a href="news_approve.php?action=delete&amp;news_submission_id={$line.news_submission_id}" class="MAINNAV">DELETE</a>
			</td>
		</tr>
		</table>
		</fieldset> 
		<br>
		<br>
	{/foreach}	
	</td>
</tr>
{else}
<tr>
	<td align="center">
		No news entries to approve.
	</td>
</tr>
{/if}
</table>
<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td>
 	<span class="LEFTNAVHEADING">&nbsp;&nbsp;&nbsp;</span>
	</td>
</tr>
</table>