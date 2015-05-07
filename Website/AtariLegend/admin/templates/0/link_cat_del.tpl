<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" class="HEADERBAR">
<tr>    
	<td height="5" style="vertical-align:top;">
	<span class="LEFTNAVHEADING">&nbsp;&nbsp;Delete Website Categories</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
			
		If the selected category doesn't contain any links you will be given the option to delete it.<br>
		If the selected category DOES contain links you will also have to specify a destination for the links.<br>
		
		
		<br>
		
	<fieldset class="category_set_noGrave">
	<legend class="links_legend">Delete Category</legend>
	<br>
	
	
	<form action="../links/db_links.php" method="post" name="cat_delete" id="cat_delete">
	
	{if $website_count.count<1}
	
	<strong>This category doesn't contain any links!</strong>
	<br>
	<br>
	<label for="delete_button">Do Stuff!</label>
	<input type="hidden" name="action" value="del_cat">
	<input type="hidden" name="category_id" value="{$category.category_id}">
	<input type="submit" name="delete_button" id="delete_button" value="Delete Category">
	
	{else}
	
	<strong>This category contains {$website_count.count} links!<br>
	Please select a destination category.</strong>
	<br>
	<br>
	<label for="new_category">Destination</label> 
		<select name="new_category" id="new_category" class="links_selector">
			{foreach from=$category_list item=line}
					<option value="{$line.category_id}" {$line.selected}>{$line.category_name}</option>
			{/foreach}
		</select>
	<br>
	<input type="hidden" name="move" value="yes">
	<input type="hidden" name="action" value="del_cat">
	<input type="hidden" name="category_id" value="{$category.category_id}">
	<input type="submit" value="Move and Delete">
	{/if}
	</form>
</fieldset> 

<br>

<strong><a href="../links/link_cat.php" class="MAINNAV">Back</a></strong>

<br>

	



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