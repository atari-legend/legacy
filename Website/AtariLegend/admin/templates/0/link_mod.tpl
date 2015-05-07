{literal}
<script language='JavaScript'>
function deletelink()
{  
    JSid=document.forms["linkmod"].website_id.value;

    // CONFIRM REQUIRES ONE ARGUMENT
    var message = "Are you sure you want to delete this link?";
    // CONFIRM IS BOOLEAN. THAT MEANS THAT
    // IT RETURNS TRUE IF 'OK' IS CLICKED
    // OTHERWISE IT RETURN FALSE
    var return_value = confirm(message);

    if (return_value !="0")
    {
      url="../links/db_links.php?action=link_delete&website_id="+JSid;
	  location.href=url;
    } 
}
</script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" class="HEADERBAR">
<tr>    
	<td height="5" style="vertical-align:top;">
	<span class="LEFTNAVHEADING">&nbsp;&nbsp;Modify Link</span>
	</td>
</tr>
</table>


<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">
<tr>
	<td width="45%">
	<form enctype="multipart/form-data" action="../links/db_links.php" method="post" name="linkmod" id="linkmod">
	
	<label for="website_name">Site Name</label>
	<input type="text" name="website_name" id="website_name" value="{$website.website_name}" size="50" maxlength="50" class="links_input-box">
	<br>
	<label for="website_url">URL</label>	 
	<input type="text" name="website_url" id="website_url" value="{$website.website_url}" size="50" maxlength="200" class="links_input-box">		 
	<br>
	<label for="category">Category</label> 
		<select name="category" id="category" class="links_selector">
			{foreach from=$category item=line}
					<option value="{$line.category_id}" {$line.selected}>{$line.category_name}</option>
			{/foreach}
		</select>
	<br>
	<label for="website_description_text">Description</label>	
		<textarea name="website_description_text" id="website_description_text" class="textarea_links">{$website.website_description_text}</textarea>
	
	</td>
	<td align="left" valign="top">
	
<fieldset class="links_set">
	<legend class="links_legend">Website Image</legend>
	
		{if  $website.website_imgext !== ""}
			<br>
		  	<label for="delete_image">Delete Image?</label>
			<input type="checkbox" name="delete_image" id="delete_image" value="yes" class="links_checkbox"><br>
			<div class="links_screenshot">
	 		<img src="../includes/show_image.php?file={$website.website_image}&resize=410,null,null,null&crop=left,top,410,260&minimum_size=410,260" border="0" style="border: 1px solid black;">
	 		</div>

		{else}
			<br>
			
	 		<label for="image" style="cursor: help; text-decoration: underline; margin:5px;" accesskey="1" title="Choose an image from your harddrive to attach to be associated with this website.">Attach image</label>
			<input type="hidden" name="MAX_FILE_SIZE" value="10000">
			<input type="file" name="image" class="links_file-box">
	
		{/if}

</fieldset> 
	
		  </td>
		  </tr>
		  <tr>
		  
		  <td colspan="2" style="padding:0px;">
		  <input type="hidden" name="website_id" value="{$website.website_id}">
		  <input type="hidden" name="action" value="modify_link">
		  <input type="submit" name="Modify" value="Modify" class="submit-button">
		  <input type="button" name="delete" value="Delete" onClick="deletelink(); return false;">
	 	  </form>
		  </td>
		  </tr>
		  <tr>
		  
		  <td colspan="2" style="padding-top: 5px;">
		  <span style="text-align: center;">
		  Make the changes you want, then hit the submit button to modify. 
		  <br>
		  Should you want to delete the link, click the delete button. The effects are immidiate.</span>
		  <br><br>
		  
		  
		  <strong><a href="../links/link_modlist.php?catpick={$website.category_id}" class="MAINNAV">Back</a></strong> 
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
