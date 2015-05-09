<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" class="HEADERBAR">
<tr>    
	<td height="5" style="vertical-align:top;">
	<span class="LEFTNAVHEADING">&nbsp;&nbsp;Modify Website Categories</span>
	</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td>
			
		Change the name of the category where indicated.<br>
		Use the dropdown menu to change if this category should be a subcategory and to what it should be a subcategory.<br>
		
		
		<br>
		
	<fieldset class="category_set_noGrave">
	<legend class="links_legend">Modify Category</legend>
	<br>
	<form action="../links/db_links.php" method="post" name="cat_modification" id="cat_modification">
	
	<label for="category_name">Site Name</label>
	<input type="text" name="category_name" id="category_name" value="{$category.category_name}" size="50" maxlength="50" class="links_input-box">

	<br>
	<label for="category">Category</label> 
		<select name="category" id="category" class="links_selector">
					<option value="0">Nothing</option>
			{foreach from=$category_list item=line}
					<option value="{$line.category_id}" {$line.selected}>{$line.category_name}</option>
			{/foreach}
		</select>
	<br>

	<input type="hidden" name="action" value="mod_cat">
	<input type="hidden" name="category_id" value="{$category.category_id}">
	<input type="submit" value="Submit Changes">
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