{* 
/***************************************************************************
*                                news_edit_all.tpl
*                            ---------------------------
*   begin                : Thursday, May 5, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : File creation
*
*   Id: news_edit_all.tpl,v 0.10 2004/05/05 ST Graveyard
*
***************************************************************************/
****************************************************************************
 This is the sub template file to generate the news edit page
****************************************************************************
*}

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Edit News</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	<fieldset class="category_set">
		This is the main edit page. Here you may selected whichever news update and edit it. 
		Currently <b>{$news_nr}</b> news threads in the DB.
	</fieldset> 
	</td>
</tr>
<tr>
	<td align="center">
	{foreach from=$edit_submissions item=line}
		<fieldset class="news_set">
		<legend class="links_legend">
		{if $line.edit_email <> ''}	
			Submitted by <a href="mailto:{$line.edit_email}?subject=Your newspost {$line.edit_headline} at Atari Legend" class="MAINNAV">{$line.edit_userid}</a> on {$line.edit_date}</legend>
		{else}
			Submitted by {$line.edit_userid} on {$line.edit_date}
		{/if}	
		</legend>
		<table>
		<tr>
			<td colspan="2" align="left">
				<b>Headline - {$line.edit_headline}</b>
				<br>
				<br>
			<td>
		</tr>
		<tr>
			<td width="20%" valign="top" align="left">
				<img src="../includes/showimage.php?img={$line.edit_icon}&amp;w=90&amp;shadow=1&amp;bgcolour=FFFFFF" alt="newsbutton">
			</td>
			<td width="80%" align="left">
				<i>{$line.edit_text}</i>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2" align="left">
				<br>
				<a href="news_edit.php?news_id={$line.edit_id}" class="MAINNAV">EDIT</a> ::
				<a href="news_edit_all.php?news_id={$line.edit_id}&amp;action=delete" class="MAINNAV">DELETE</a>
			</td>
		</tr>
		</table>
		</fieldset> 
		<br>
		<br>
	{/foreach}	
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
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
   	<td width="50%" align=center>
	{if $links.linkback != ''}
		<b><a href ={$links.linkback} class="MAINNAV">Previous news</a></b>
	{/if}
	</td>
	<td width="50%" align=center>
	{if $links.linknext != ''}
		<b><a href={$links.linknext} class="MAINNAV">Next news</a></b>
	{/if}
	</td>
</tr>
</table>
<br>
<br>