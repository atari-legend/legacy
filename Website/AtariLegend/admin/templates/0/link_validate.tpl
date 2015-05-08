{literal}
<script language='JavaScript'>
function deletelink(JSid)
{  
    // CONFIRM REQUIRES ONE ARGUMENT
    var message = "Are you sure you want to delete this link?";
    // CONFIRM IS BOOLEAN. THAT MEANS THAT
    // IT RETURNS TRUE IF 'OK' IS CLICKED
    // OTHERWISE IT RETURN FALSE
    var return_value = confirm(message);

    if (return_value !="0")
    {
      url="../links/db_links.php?action=val_delete&website_id="+JSid;
	  location.href=url;
    } 
}
</script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" class="HEADERBAR">
<tr>    
	<td height="5" style="vertical-align:top;">
	<span class="LEFTNAVHEADING">&nbsp;&nbsp;Validate Links</span>
	</td>
</tr>
</table>



<table width="100%" cellspacing="2" cellpadding="15" align="center" class="CELLCOLOR">

{foreach from=$validate item=lineweb}
<tr>
	<td width="45%">
	
	<fieldset class="links_set">
	<legend class="links_legend">New website submitted</legend>
	
	<form enctype="multipart/form-data" action="../links/db_links.php" method="post" name="linkmod{$lineweb.website_id}" id="linkmod{$lineweb.website_id}">
	
	<label for="website_name">Site Name</label>
	<input type="text" name="validate_website_name" id="website_name" value="{$lineweb.website_name}" size="50" maxlength="50" class="links_input-box">
	<br>
	<label for="website_url">URL</label>	 
	<input type="text" name="validate_website_url" id="website_url" value="{$lineweb.website_url}" size="50" maxlength="200" class="links_input-box">		 
	<br>
	<label for="category">Category</label> 
		<select name="validate_category" id="category" class="links_selector">
			{foreach from=$category item=line}
					<option value="{$line.website_category_id}" {if $line.website_category_id eq $lineweb.website_category}SELECTED{/if}>{$line.website_category_name}</option>
			{/foreach}
		</select>
	<br>
	<label for="website_description_text">Description</label>	
		<textarea name="validate_website_description_text" id="website_description_text" class="textarea_links">{$lineweb.website_description}</textarea>
	
		  <input type="hidden" name="validate_website_id" value="{$lineweb.website_id}">
		  <input type="hidden" name="action" value="approve_link">
		  <input type="submit" name="Approve" value="Approve">
		  <input type="button" name="delete" value="Delete" onClick="deletelink({$lineweb.website_id}); return false;">
		  </form>
	</fieldset> 
	</td>
	<td align="left" valign="top">
	
<fieldset class="links_set">
	<legend class="links_legend">Submission details</legend>
	
		Submitted by {$lineweb.user_name}<br>
		On {$lineweb.website_date}<br>
		User Email <a href="mailto:{$lineweb.user_email}?Subject=Thanks for the link you submitted" class="MAINNAV">{$lineweb.user_email}</a><br>
		<br>
		{$lineweb.user_name} has submitted {$lineweb.link_sub} links before.
	

</fieldset> 
	
		  </td>
		  </tr>
	{/foreach}
		  <tr>
		  
		  <td colspan="2" style="padding:0px;">

	 	  
		  </td>
		  </tr>
		  <tr>
		  
		  <td colspan="2" style="padding-top: 5px;">
		  <span style="text-align: center;">
		  Make the changes you want, then hit the submit button to modify. 
		  <br>
		  Should you want to delete the link, click the delete button. The effects are immidiate.</span>
		  <br><br>
		  
		  
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