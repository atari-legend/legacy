{* 
/***************************************************************************
*                                news_add.tpl
*                            --------------------------
*   begin                : Sunday, may 1, 2005
*   copyright            : (C) 2005 Atari Legend
*   email                : maarten.martens@freebel.net
*
*   Id: news_add.tpl,v 0.10 2005/05/01 ST Graveyard
*
***************************************************************************/
//****************************************************************************************
// This is the sub template file to generate the news add page
//**************************************************************************************** 

*}

<table align="center" class="HEADERBAR" width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td style="vertical-align:top;" height="5" colspan=6>
	<span class="LEFTNAVHEADING">&nbsp;Add a News Item</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
	<fieldset class="category_set">
		This is the news adding page. Fill out the headline, text field and pick a news icon. If you feel there is no icon that 
		represents the news you are about to submit then go <a href="../news/news_add_images.php" class="MAINNAV">here</a> first. 
		After you have submitted your news text it is not actually out on the main site, there is failsafe installed. So to get your news online
		go to <a href="../news/news_approve.php" class="MAINNAV">Approve News</a> section and approve your news texts.
	</fieldset> 
	<br>
	<br>
	<form action="../news/news_add.php" method="post" name="newsadd" id="newsadd">
	<label for="name">Headline</label>
	<input type="text" name="headline" id="headline" size='50' maxlength='64' class="links_input-box">
	<br>
	<label for="icon">News Icon</label>
	<select name="icon" class="links_selector">
		{foreach from=$news_images item=line}
			<option value="{$line.image_id}">{$line.image_name}</option>
		{/foreach}	
	</select>
	<a href="../news/news_iconpreview.php" class="MAINNAV">Preview Icons</a>
	<br>
	<label for="descr">Description</label>
	<textarea cols="70" rows="8" name="descr" ></textarea>
	<br>
	<br>
	<input type="hidden" name="action" id="action" value="add_news">
	<input type="hidden" name="user_id" id="user_id" value="{$user_id}">
	<input type="submit" value="Submit">
	<input type="reset">
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