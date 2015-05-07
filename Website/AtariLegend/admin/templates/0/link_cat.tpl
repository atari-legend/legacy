{* 
/***************************************************************************
*                                link_cat.tpl
*                            --------------------------
*   begin                : 2005-01-06
*   copyright            : (C) 2005 Atari Legend
*   email                : admin@atarilegend.com
*
*   Id: link_cat.tpl,v 0.10 2005/01/06 Silver
*
***************************************************************************/
*}

<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" class="HEADERBAR">
<tr>    
	<td height="5" style="vertical-align:top;">
	<span class="LEFTNAVHEADING">&nbsp;&nbsp;Website Categories</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
		Click modify, to change name or make subcategory of the category<br>
		Click delete to remove the category<br>
		<br>
		<fieldset class="category_set_noGrave">
		<legend class="links_legend">Categories in Archive</legend>
	
		{foreach from=$category item=line}
		<img src="../templates/0/images/e.gif" alt="" width="{$line.category_indent}" height="1" border="0">{$line.category_name} :: 
	 	<a href="../links/link_cat_mod.php?category_id={$line.category_id}" class="MAINNAV">Modify</a> :: <a href="link_cat_del.php?category_id={$line.category_id}" class="MAINNAV">Delete</a> :: ({$line.category_count} links)<br>
		{/foreach}

</fieldset> 

<br>

	<form action="../links/db_links.php" method="post" name="insertcat" id="insertcat">
	<input type="text" name="newcat">
	<input type="hidden" name="action" value="new_cat">
	<input type="submit" value="Insert new category">
	</form>



	</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="HEADERBAR">
<tr>
	<td>
	<span class="LEFTNAVHEADING">&nbsp;&nbsp;&nbsp;</span>
 	</td>
</tr>
</table>