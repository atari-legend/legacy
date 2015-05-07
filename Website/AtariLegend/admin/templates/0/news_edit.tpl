{* 
/***************************************************************************
*                                news_edit.tpl
*                            ---------------------------
*   begin                : Thursday, May 5, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*   actual update        : File creation
*							 
*							
*
*   Id: news_edit.tpl,v 0.10 2004/05/05 ST Graveyard
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
	<form action="news_edit.php" method="post" name="news_edit" id="news_edit">
	<fieldset class="category_set">
		This is the news edit page. Change a news post accordingly.
	</fieldset> 
	<br>
	<br>
	<label for="name">Headline</label>
	<input type="text" name="news_headline" id="headline" size='50' maxlength='64' class="links_input-box" value="{$edit_submissions.edit_headline}">
	<br>
	<label for="icon">News Icon : </label>
	<select name="news_image_id" class="links_selector">
	{foreach from=$news_images item=line}
		{if $edit_submissions.edit_image_id eq $line.image_id}			
			<option value="{$line.image_id}" selected>{$line.image_name}</option>
		{else}
			<option value="{$line.image_id}">{$line.image_name}</option>
		{/if}
	{/foreach}	
	</select>
	<a href="../news/news_iconpreview.php" class="MAINNAV">Preview Icons</a>
	<br>
	<label for="descr">Description</label>
	<textarea cols="70" rows="8" name="news_text" >{$edit_submissions.edit_text}</textarea>
	<br>
	<br>
	<input type="hidden" name="news_submission_id" value="{$edit_submissions.edit_submission_id}">
	<input type="hidden" name="news_id" value="{$edit_submissions.edit_id}">
	<input type="hidden" name="action" value="update">
	<input type="submit" value="Update">	
	</form>
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